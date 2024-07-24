<?php 
    /**
     * Digunakan untuk populate options data item category
     * Table terkait    : isoxxth_upload
     * Parameter        : 
     *  - id_isoxxth_upload_old       : data existing (untuk keperluan edit), dipakai di query self
     */    
    require_once( "../../../../users/init.php" );
    require_once( "../../../../usersc/lib/DataTables.php" );
    require_once( "../../../../usersc/helpers/datatables_fn_debug.php" );

    // BEGIN definisi variable untuk fn_ajax_results.php
    $data      = array();
    $rs_opt    = array();
    $c_rs_opt  = 0;
    $morePages = false;
    // END definisi variable untuk fn_ajax_results.php

    // BEGIN select2 pagination preparation
    $page        = $_GET['page'];
    $resultCount = 10;
    $offset      = ($page - 1) * $resultCount;
    // END select2 pagination preparation

    if($_GET['id_isoxxth_upload_old'] > 0){
        $id_isoxxth_upload_old = $_GET['id_isoxxth_upload_old'];
    }else{
        $id_isoxxth_upload_old = 0;
    }

    // BEGIN query self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_isoxxth_upload_old > 0){
        $qs_isoxxth_upload_self = $db
            ->query('select', 'isoxxth_upload')
            ->get([
                'isoxxth_upload.id as id',
                'CONCAT(isoxxth_upload.kode, " - ", warehouse) as text'
            ])
            ->where('isoxxth_upload.id', $id_isoxxth_upload_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_isoxxth_upload_self = $qs_isoxxth_upload_self->fetchAll();
    }else{
        $rs_isoxxth_upload_self = [];
    }
    // END query self

    // BEGIN query options all except self
    $qs_isoxxth_upload_all = $db
        ->query('select', 'isoxxth_upload')
        ->get([
            'isoxxth_upload.id as id',
            'CONCAT(isoxxth_upload.kode, " - ", warehouse) as text'
        ])
        ->where('isoxxth_upload.transaction_state',1)
        ->where('isoxxth_upload.id', $id_isoxxth_upload_old, '<>' )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('isoxxth_upload.kode', '%' . $q . '%', 'LIKE' )
                ->or_where('warehouse', '%' . $q . '%', 'LIKE' )
                ;
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_isoxxth_upload_all = $qs_isoxxth_upload_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_isoxxth_upload_self) > 0){
        $rs_opt = array_merge($rs_isoxxth_upload_self, $rs_isoxxth_upload_all);
    }else{
        $rs_opt = $rs_isoxxth_upload_all;
    }
    $c_rs_opt = count($rs_opt);
    // END menggabungkan options

    // BEGIN untuk keperluan paginasi select2
    $endCount  = $offset + $resultCount;
    $morePages = $endCount > $c_rs_opt;
    // END untuk keperluan paginasi select2
    
    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>