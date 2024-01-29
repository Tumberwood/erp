<?php
	/*
        Digunakan untuk meng-update transaction_state
        Sumber 2 digit berarti dari data header detail

        * +--------+------+----------------+--------+------+---------+----------+----------------------------+
        * | Sumber |Kode  | Status         | Cancel | Edit | Next    | Approval | Notes                      |
        * |        |      |                |        |      | Process |          |                            |
        * +--------+------+----------------+--------+------+---------+----------+----------------------------+
        * | -92    |-9    | Deleted        | No     | No   | No      | No       | Soft Delete                |
        * | -93    |-9    | Deleted        | No     | No   | No      | No       | Hard Delete                |
        * |        | 0    | Draft          | No     | Yes  | No      | No       | Doc belum siap dilanjutkan |
        * |        | 1    | Confirmed      | Yes    | No   | Yes     | Yes      | Doc siap dilanjutkan       |
        * |        | 8    | Completed      | No     | No   | No      | Already  | Doc Selesai                |
        * |        | 9    | Closed         | No     | No   | No      | Already  | Doc Selesai                |
        * +--------+------+----------------+--------+------+---------+---------------------------------------+
	*/
	
	require_once( "../../users/init.php" );
	require_once( "../../usersc/lib/DataTables.php" );
    require_once( "datatables_fn_debug.php" );
    require_once( "hakakses_s_fn.php" );

	use
		DataTables\Editor,
		DataTables\Editor\Query,
		DataTables\Editor\Result;

    // BEGIN definisi variable untuk fn_ajax_results.php
    $data      = array();
    $rs_opt    = array();
    $c_rs_opt  = 0;
    $morePages = 0;
    // END definisi variable untuk fn_ajax_results.php
	
	$table_name         = $_POST['table_name'];
	$id_transaksi       = $_POST['id_transaksi'];
    $transaction_state  = $_POST['transaction_state'];
    
    switch ($_POST['transaction_state']) {
        case 1:
            $kode = 'CONFIRM';
            $message = 'Konfirmasi berhasil dilakukan';
            $type_message = 'success';
            break;
        case 8:
            $kode = 'COMPLETE';
            $message = 'Data berhasil dipenuhi';
            $type_message = 'success';
            break;
        case 9:
            $kode = 'CLOSE';
            $message = 'Data ditutup, dokumen sudah tidak dapat digunakan lagi';
            $type_message = 'success';
            break;
        case -92:        // non aktif HD
            $transaction_state = -9;
            $kode = 'DELETE';
            $message = 'Data berhasil dihapus';
            $type_message = 'danger';
            break;
        case -93:        // remove HD
            $transaction_state = -9;
            $kode = 'DELETE';
            $message = 'Data berhasil dihapus';
            $type_message = 'danger';
            break;
        case -9:
            $kode = 'DELETE';
            $message = 'Data berhasil dihapus';
            $type_message = 'danger';
            break;
        default: 
            $kode = 'INVALID CODE';
            $message = "[" . $kode . "] Terjadi kesalahan, harap hubungi Administrator.";
            $type_message = 'error';
    }
    $notes          = $kode . ' ' . $table_name . ' , id = '. $id_transaksi;

    try{
        $db->transaction();

        $qs_gtbrlsh = $db
            ->query('select', 'gtbrlsh' )
            ->get([
                'gtbrlsh.tblheader as tblheader',
                'gtbrlsh.tbldetail as tbldetails'
            ] )
            ->where('gtbrlsh.tblheader', $table_name )
            ->exec();
        $rs_gtbrlsh = $qs_gtbrlsh->fetch();

        if( $_POST['transaction_state'] == -92 ){
            // jika soft delete header detail
            // non aktif table header
            $qu_tblheader = $db
                ->query('update', $rs_gtbrlsh['tblheader'])
                ->set('transaction_state', $transaction_state)
                ->where('id', $id_transaksi )
                ->exec();

            // non aktif all table detail (jika tidak null)
            // jika null artinya table tersebut tidak mempunya detail
            if(!is_null($rs_gtbrlsh['tbldetails'])){
                $tbldetails = explode(",", $rs_gtbrlsh['tbldetails']);
                foreach($tbldetails as $i => $tbldetail) {
                    $qu_tbldetail = $db
                        ->query('update', $tbldetail )
                        ->set('transaction_state', $transaction_state)
                        ->where('id_'. $rs_gtbrlsh['tblheader'] , $id_transaksi )
                        ->exec();
                }
            }
            
        }elseif( $_POST['transaction_state'] == -93 ){
            // jika hard delete header detail
            // ini seharusnya pakai datatables editor remove
            // tetapi karna harus remove header dan detail, maka dibuat custom disini

            // delete table header
            $qd_tblheader = $db
                ->query('delete', $rs_gtbrlsh['tblheader'])
                ->where('id', $id_transaksi )
                ->exec();

            // delete all table detail (jika tidak null)
            // jika null artinya table tersebut tidak mempunya detail
            if(!is_null($rs_gtbrlsh['tbldetails'])){
                $tbldetails = explode(",", $rs_gtbrlsh['tbldetails']);
                foreach($tbldetails as $i => $tbldetail) {
                    $qu_tbldetail = $db
                        ->query('delete', $tbldetail)
                        ->where('id_'. $rs_gtbrlsh['tblheader'] , $id_transaksi )
                        ->exec();
                }
            }

        }else{
            // selain hard delete header detail
            $qu_tblheader = $db
                ->query('update', $table_name)
                ->set('transaction_state', $transaction_state)
                ->where('id', $id_transaksi )
                ->exec();

            // delete all table detail (jika tidak null)
            // jika null artinya table tersebut tidak mempunya detail
            if(!empty($rs_gtbrlsh['tbldetails'])){
                $tbldetails = explode(",", $rs_gtbrlsh['tbldetails']);
                foreach($tbldetails as $i => $tbldetail) {
                    $qu_tbldetail = $db
                        ->query('update', $tbldetail)
                        ->set('transaction_state', $transaction_state)
                        ->where('id_'. $rs_gtbrlsh['tblheader'] , $id_transaksi )
                        ->exec();
                }
            }
                        
        }
        
        // BEGIN insert ke activity_log_ml
        // berlaku untuk semua transaction_state
        // jadi tidak perlu masuk ke if else diatas
        $qi_log = $db
            ->query('insert', 'activity_log_ml')
            ->set('id_transaksi',$id_transaksi)
            ->set('kode',$kode)
            ->set('nama', $table_name )
            ->set('keterangan', $notes )
            ->set('created_by', $s_id_users )
            ->set('username',$s_username)
            ->set('start_on', date("Y-m-d H:i:s"))
            ->set('finish_on', date("Y-m-d H:i:s"))
            ->set('durasi_detik', 0)
            ->exec();
        // END insert ke activity_log_ml
        
        $db->commit();

    }catch(PDOException $e){
		// rollback on error
		$db->rollback();

	}

    $data = array(
		'message'      => $message,
		'type_message' => $type_message
	);

    // tampilkan results
    require_once( "fn_ajax_results.php" );
	
?>