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
        
        $id_aglaktd = $_POST['id_aglaktd'];
        $is_reconcile = $_POST['is_reconcile'];

        if ($is_reconcile == 1) {
            $kode_act = 'REKON';
        } else {
            $kode_act = 'CANCEL REKON';
        }

        $qu_aglaktd = $db
            ->query('update', 'aglaktd')
            ->set('is_reconcile',$is_reconcile)
            ->where('id',$id_aglaktd)
            ->exec();

        // insert log create
        $qi_activity = $db
            ->query('insert', 'activity_log_ml')
            ->set('id_transaksi', $id_aglaktd )
            ->set('kode', $kode_act)
            ->set('nama', 'aglaktd')
            ->set('keterangan', $kode_act.' aglaktd '.$id_aglaktd)
            ->set('created_by', $s_id_users)
            ->set('username', $s_username)
            ->exec();

        if($qu_aglaktd){
            $db->commit();
            $status_code  = '200';
            $message      = 'Reconcile Berhasil Diupdate';
            $type_message = 'success';
        }else{
            $db->rollback();
            $status_code  = '500';
            $message      = 'Reconcile Gagal Diupdate!';
            $type_message = 'error';
        }
    }catch(PDOException $e){
        $db->rollback();
        $status_code  = '500';
        $message      = 'Reconcile Gagal Diupdate!! ' . $e->getMessage();
        $type_message = 'error';
    }catch (Exception $e) {
        $db->rollback();
        $status_code = 500;
        $message = 'Reconcile Gagal Diupdate!!, ' . $e->getMessage();
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