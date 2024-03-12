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

    try{
        $db->transaction();
        
        // BEGIN ambil nama transaksi
        $qs_gtbrlsh = $db
            ->raw()
            ->bind(':table_name', $table_name)
            ->exec('
                SELECT
                    nama
                FROM gtbrlsh
                WHERE 
                    tblheader = :table_name
            ');
        $rs_gtbrlsh = $qs_gtbrlsh->fetch();
        $nama = $rs_gtbrlsh['nama'];
        // END ambil nama transaksi
        
        // BEGIN ambil aturan approval
        $qs_gapxxsh = $db
            ->raw()
            ->bind(':table_name', $table_name)
            ->exec('
                SELECT 
                    gapxxsh.id as id_gapxxsh,
                    gapxxsh.jumlah_level as jumlah_level,
                    gaptpmh.nama as gaptpmh_nama
                FROM gapxxsh
                LEFT JOIN gaptpmh ON gaptpmh.id = gapxxsh.id_gaptpmh
                WHERE 
                    gapxxsh.nama = :table_name
            ');
        $rs_gapxxsh   = $qs_gapxxsh->fetch();
        $id_gapxxsh   = $rs_gapxxsh['id_gapxxsh'];
        $jumlah_level = $rs_gapxxsh['jumlah_level'];
        $gaptpmh_nama = $rs_gapxxsh['gaptpmh_nama'];
        // END ambil aturan approval

        if($gaptpmh_nama == 'Amount'){
            $field_amount = ',grand_total ';
        }else{
            $field_amount = '';
        }
   
        $qs_transaksi = $db
            ->raw()
            ->bind(':id_transaksi', $id_transaksi)
            ->exec('
                SELECT
                    kode '
                    .$field_amount.
                'FROM '.$table_name.'
                WHERE 
                    id = :id_transaksi
            ');
        $rs_transaksi = $qs_transaksi->fetch();
        
        $kode = $rs_transaksi['kode'];
        if($gaptpmh_nama == 'Amount'){
            $tr_amount = $rs_transaksi['grand_total'];
        }
        
        $qs_gapdusd = $db
            ->raw()
            ->bind(':id_gapxxsh', $id_gapxxsh)
            ->bind(':tr_amount', $tr_amount)
            ->exec('
                SELECT 
                    id_users,
                    level_ke
                FROM gapdusd
                WHERE 1
                    AND id_gapxxsh = :id_gapxxsh
                    AND :tr_amount BETWEEN gaptpmh_value_fr AND IFNULL(gaptpmh_value_to,999999999999999999.99)
            ');
        $rs_gapdusd = $qs_gapdusd->fetch();
        
        $qi_gaplgtd = $db
            ->query('insert', 'gaplgtd')
            ->set('id_users', $rs_gapdusd['id_users'] )
            ->set('id_transaksi', $id_transaksi )
            ->set('kode', $kode)
            ->set('nama', $nama)
            ->set('start_at', date('Y-m-d H:i:s'))
            ->set('tbl_name', $table_name)
            ->set('level_ke', $rs_gapdusd['level_ke'] )
            ->set('transaction_state', 1 )
            ->exec();
                
        $db->commit();

        if($qi_gaplgtd){
            $data = array(
                'status_code'  => 200,
                'message'      => 'Setting Approval Berhasil Dilakukan',
                'type_message' => 'success'
            );
        }else{
            $data = array(
                'status_code'  => 500,
                'message'      => 'Setting Approval Gagal Dilakukan!',
                'type_message' => 'error'
            );
        }
        
    }catch(PDOException $e){
        $data = array(
		    'status_code'  => 500,
            'message'      => 'Setting Approval Gagal Dilakukan! ' . $e->getMessage(),
            'type_message' => 'error'
        );
		$db->rollback();

	}

    

    // tampilkan results
    require_once( "fn_ajax_results.php" );
	
?>