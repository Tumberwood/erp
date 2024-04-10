<?php 
    /**
     * Digunakan untuk get data default Currency untuk di load di datatables editor select2
     * Dipanggil lewat helpers/general_fn.js
     * Credit to Ferry Ibnu
     * 
     */
    require_once( "../../../../users/init.php" );
    require_once( "../../../../usersc/lib/DataTables.php" );
    require_once( "../../../../usersc/helpers/datatables_fn_debug.php" );

    require '../../../../usersc/vendor/autoload.php';
	use Carbon\Carbon;

    // BEGIN definisi variable untuk fn_ajax_results.php
    $data      = array();
    $rs_opt    = array();
    // END definisi variable untuk fn_ajax_results.php

    try{
        $db->transaction();
        
        $qs_def = $db
            ->raw()
            ->exec('
                SELECT
                    id,
                    concat(kode, " - ", nama) as nama
                FROM fcrxxmh
                WHERE is_default = 1
            ');
        $rs_def   = $qs_def->fetch();

        // check apakah query ada resultnya
        if(!empty($rs_def)){
            
            $id_def   = $rs_def['id'];
            $nama_def = $rs_def['nama'];

            $status_code  = '200';
            $message      = 'Get Data Default Currency Berhasil';
            $type_message = 'success';

        }else{
            
            $id_def   = 0;
            $nama_def = "";

            $status_code  = '500';
            $message      = 'Get Data Default Currency Gagal! Default Currency Belum Didefinisikan!';
            $type_message = 'error';

        }
    }catch(PDOException $e){
        $status_code  = '500';
        $message      = 'Get Data Default Currency Gagal!  ' . $e->getMessage();
        $type_message = 'error';
    }

    // build response
    $data = array(
        'status_code'  => $status_code,
        'message'      => $message,
        'type_message' => $type_message,
        'id_def'       => $id_def,
        'nama_def'     => $nama_def
    );
    
    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>