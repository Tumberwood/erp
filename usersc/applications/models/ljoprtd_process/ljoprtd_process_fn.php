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
        $jenis = $_POST['jenis'];   // 1: start | 2: finish
        if($jenis == 1){
            $jenis_process = 'Start';

            $qs_ljoprtd_arrival = $db
                ->query('select', 'ljoprtd' )
                ->get([
                    'ljoprtd.tanggaljam_finish as tanggaljam_finish_arrival'
                ] )
                ->where('ljoprtd.id_ljoxxth', $_POST['id_ljoxxth'] )
                ->where('ljoprtd.id_lprxxmh', 2 )
                ->exec();
            $rs_ljoprtd_arrival = $qs_ljoprtd_arrival->fetch();
            $tanggaljam_finish_arrival = $rs_ljoprtd_arrival['tanggaljam_finish_arrival'];

			$cb_tanggaljam_finish_arrival = Carbon::parse($tanggaljam_finish_arrival);
			$cb_tanggaljam_start_process  = Carbon::parse($_POST['tanggaljam']);
			$durasi_tunggu_detik          = $cb_tanggaljam_finish_arrival->diffInSeconds($cb_tanggaljam_start_process);

            $q_ljoprtd = $db
                ->query('insert', 'ljoprtd')
                ->set('id_ljoxxth', $_POST['id_ljoxxth'])
                ->set('id_lprxxmh', 3 )
                ->set('tanggaljam_start', $_POST['tanggaljam'])
                ->set('durasi_tunggu_detik', $durasi_tunggu_detik)
                ->exec();
            
            $id_ljoprtd = $q_ljoprtd->insertId();

            // update ljoxxth.id_lprxxmh_last
            $qu_ljoxxth = $db
                ->query('update', 'ljoxxth')
                ->set('id_lprxxmh_last', 3)
                ->where('id', $_POST['id_ljoxxth'] )
                ->exec();

        }else if($jenis == 2){
            $jenis_process = 'Finish';
            $id_ljoprtd = $_POST['id_ljoprtd'];
            $qs_ljoprtd = $db
                ->query('select', 'ljoprtd' )
                ->get([
                    'ljoprtd.tanggaljam_start as tanggaljam_start'
                ] )
                ->where('ljoprtd.id', $_POST['id_ljoprtd'] )
                ->exec();
            $rs_ljoprtd = $qs_ljoprtd->fetch();
            $tanggaljam_start = $rs_ljoprtd['tanggaljam_start'];

            $cb_start_at = Carbon::parse($tanggaljam_start);
			$cb_finish_at = Carbon::parse($_POST['tanggaljam']);
			$durasi_detik = $cb_start_at->diffInSeconds($cb_finish_at);

            $q_ljoprtd = $db
                ->query('update', 'ljoprtd')
                ->set('tanggaljam_finish', $_POST['tanggaljam'])
                ->set('durasi_detik', $durasi_detik )
                ->where('id', $_POST['id_ljoprtd'])
                ->exec();
        }else{

        }  
        
         // INSERT log
        $qi_activity_log_ml = $db->insert( 'activity_log_ml', array(
            'id_transaksi' 	=> $id_ljoprtd,
            'kode' 			=> 'EDIT',
            'nama' 			=> 'ljoprtd',
            'keterangan' 	=> 'UPDATE Process ' . $jenis_process,
            'created_by'   	=> $s_id_users,
            'username'   	=> $s_username,
            'start_on'   	=> $_POST['tanggaljam'],
            'finish_on'   	=> $_POST['tanggaljam'],
            'durasi_detik'  => 0
        ) );
        
        // check apakah query ada resultnya
        if(!empty($q_ljoprtd) && !empty($qi_activity_log_ml) ){
            $db->commit();
            $status_code  = '200';
            $message      = 'Update Process Berhasil';
            $type_message = 'success';
            // parameter lain
        }else{
            $db->rollback();
            $status_code  = '500';
            $message      = 'Update Process Gagal';
            $type_message = 'error';
            // parameter lain
        }

    }catch(PDOException $e){
        $db->rollback();
        $status_code  = '500';
        $message      = 'Update Process Gagal! ' . $e->getMessage();
        $type_message = 'error';
    }catch (Exception $e) {
        $db->rollback();
        $status_code = 500;
        $message = 'Update Process Gagal!, ' . $e->getMessage();
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