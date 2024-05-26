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
        // ambil variable dari ajax data

        $qi_ljoprtd = $db
            ->query('insert', 'ljoprtd')
            ->set('id_ljoxxth', $_POST['id_ljoxxth'])
            ->set('id_lprxxmh', 4 )
            ->set('tanggaljam_start', $_POST['tanggaljam'])
            ->set('tanggaljam_finish', $_POST['tanggaljam'])
            ->set('durasi_detik', 0)
            ->exec();

        $id_ljoprtd = $qi_ljoprtd->insertId();

        // update ljoxxth.id_lprxxmh_last
        $qu_ljoxxth = $db
            ->query('update', 'ljoxxth')
            ->set('id_lprxxmh_last', 4)
            ->where('id', $_POST['id_ljoxxth'] )
            ->exec();
            
         // INSERT log
        $qi_activity_log_ml = $db->insert( 'activity_log_ml', array(
            'id_transaksi' 	=> $id_ljoprtd,
            'kode' 			=> 'EDIT',
            'nama' 			=> 'ljoprtd',
            'keterangan' 	=> 'UPDATE Document ',
            'created_by'   	=> $s_id_users,
            'username'   	=> $s_username,
            'start_on'   	=> $_POST['tanggaljam'],
            'finish_on'   	=> $_POST['tanggaljam'],
            'durasi_detik'  => 0
        ) );
        
        // check apakah query ada resultnya
        if(!empty($qi_ljoprtd) && !empty($qu_ljoxxth) && !empty($qi_activity_log_ml) ){
            $db->commit();
            $status_code  = '200';
            $message      = 'Update Document Berhasil';
            $type_message = 'success';
            // parameter lain
        }else{
            $db->rollback();
            $status_code  = '500';
            $message      = 'Update Document Gagal';
            $type_message = 'error';
            // parameter lain
        }

    }catch(PDOException $e){
        $db->rollback();
        $status_code  = '500';
        $message      = 'Update Document Gagal! ' . $e->getMessage();
        $type_message = 'error';
    }catch (Exception $e) {
        $db->rollback();
        $status_code = 500;
        $message = 'Update Document Gagal!, ' . $e->getMessage();
        $type_message = 'error';
    }
    // build response
    $data = array(
        'status_code'    => $status_code,
        'message'        => $message,
        'type_message'   => $type_message
    );

    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>