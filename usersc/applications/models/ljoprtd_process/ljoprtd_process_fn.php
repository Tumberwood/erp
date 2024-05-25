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

            $q_ljoprtd = $db
                ->query('insert', 'ljoprtd')
                ->set('id_ljoxxth', $_POST['id_ljoxxth'])
                ->set('id_lprxxmh', 3 )
                ->set('tanggaljam_start',$_POST['tanggaljam'])
                ->exec();
        }else if($jenis == 2){

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
        
        // check apakah query ada resultnya
        if(!empty($q_ljoprtd)){
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