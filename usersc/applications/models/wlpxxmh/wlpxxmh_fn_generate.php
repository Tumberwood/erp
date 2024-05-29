<?php 
    require_once( "../../../../users/init.php" );
    require_once( "../../../../usersc/lib/DataTables.php" );
    require_once( "../../../../usersc/helpers/datatables_fn_debug.php" );
	require_once( "../../../../usersc/vendor/autoload.php");
	require_once( "../../../helpers/hakakses_s_fn.php" );

	use Carbon\Carbon;

    // BEGIN definisi variable untuk fn_ajax_results.php
    $data      = array();
    $rs_opt    = array();
    // END definisi variable untuk fn_ajax_results.php    

    try{
        $db->transaction();
        // ambil format LPN
        $qs_gdnxxsh = $db
            ->query('select', 'gdnxxsh' )
            ->get([
                'gdnxxsh.prefix as prefix',
                'gdnxxsh.total_digit as total_digit'
            ] )
            ->where('gdnxxsh.nama_tabel', 'wlpxxmh' )
            ->exec();
        $rs_gdnxxsh = $qs_gdnxxsh->fetch();
        $prefix     = $rs_gdnxxsh['prefix'];
        $total_digit     = $rs_gdnxxsh['total_digit'];

        $qs_wlpxxmh = $db
            ->query('select', 'wlpxxmh' )
            ->get([
                'COUNT(wlpxxmh.id) as c_id_wlpxxmh'
            ] )
            ->exec();
        $rs_wlpxxmh = $qs_wlpxxmh->fetch();
        $new_number    = $rs_wlpxxmh['c_id_wlpxxmh'] + 1;

        $tahun= Carbon::now()->format('y');
        
        $is_insert = 1;
        for ($i=0; $i < $_POST['lpnJumlah']; $i++) { 
            $tr_kode = str_pad($new_number,$total_digit,"0",STR_PAD_LEFT);
            $formatted_kode = $prefix . $tahun . $tr_kode;

            // INSERT LPN
            $qi_wlpxxmh = $db
                ->query('insert', 'wlpxxmh')
                ->set('kode',$formatted_kode)
                ->set('transaction_state', 1)
                ->exec();

            $id_wlpxxmh = $qi_wlpxxmh->insertId();

            // insert log create
            $qi_activity_log_ml_create = $db
                ->query('insert', 'activity_log_ml')
                ->set('id_transaksi', $id_wlpxxmh )
                ->set('kode', 'CREATE')
                ->set('nama', 'wlpxxmh')
                ->set('keterangan', 'CREATE from Generate, id = ' . $id_wlpxxmh)
                ->set('created_by', $s_id_users)
                ->set('username', $s_username)
                ->exec();

            // insert log create
            $qi_activity_log_ml_confirm = $db
                ->query('insert', 'activity_log_ml')
                ->set('id_transaksi', $id_wlpxxmh )
                ->set('kode', 'CONFIRM')
                ->set('nama', 'wlpxxmh')
                ->set('keterangan', 'CONFIRM from Generate, id = ' . $id_wlpxxmh)
                ->set('created_by', $s_id_users)
                ->set('username', $s_username)
                ->exec();

            $new_number = $new_number + 1;

            if(empty($qi_wlpxxmh || $qi_activity_log_ml_create || $qi_activity_log_ml_confirm)){
                $is_insert = 0;
                break;
            }
        }

        if($is_insert == 1){
            $db->commit();
            $status_code  = '200';
            $message      = 'LPN Berhasil Di-Generate';
            $type_message = 'success';
        }else{
            $db->rollback();
            $status_code  = '500';
            $message      = 'LPN Gagal Di-Generate!';
            $type_message = 'error';
        }
    }catch(PDOException $e){
        $db->rollback();
        $status_code  = '500';
        $message      = 'LPN Gagal Di-Generate!! ' . $e->getMessage();
        $type_message = 'error';
    }catch (Exception $e) {
        $db->rollback();
        $status_code = 500;
        $message = 'LPN Gagal Di-Generate!!, ' . $e->getMessage();
        $type_message = 'error';
    }
    // build response
    $data = array(
        'status_code'  => $status_code,
        'message'      => $message,
        'type_message' => $type_message
    );

    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>