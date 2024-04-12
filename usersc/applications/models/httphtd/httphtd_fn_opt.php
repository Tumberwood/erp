<?php 
    /**
     * Digunakan untuk populate options data httphtd
     * Table terkait    : httphtd
     * Parameter        : 
     *  - id_httphtd_old       : data existing (untuk keperluan edit), dipakai di query self
     */
    require_once( "../../../../users/init.php" );
	require_once( "../../../../usersc/lib/DataTables.php" );
	require_once( "../../../../usersc/helpers/datatables_fn_debug.php" );

    // BEGIN definisi variable untuk fn_ajax_results.php
    $data      = array();
    $rs_opt    = array();
    $c_rs_opt  = 0;
    $morePages = 0;
    // END definisi variable untuk fn_ajax_results.php

    // BEGIN select2 pagination preparation
    $page        = $_GET['page'];
    $resultCount = 10;
    $offset      = ($page - 1) * $resultCount;
    // END select2 pagination preparation

    if($_GET['id_httphtd_old'] > 0){
        $id_httphtd_old = $_GET['id_httphtd_old'];
    }else{
        $id_httphtd_old = 0;
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_httphtd_old > 0){
        $qs_httphtd_self = $db
            ->query('select', 'httphtd')
            ->get([
                'httphtd.id as id',
                'IF(
                    httphtd.kode IS NULL, 
                    httphtd.nama,
                    IF(
                        httphtd.nama IS NULL, 
                        httphtd.kode,
                        CONCAT(httphtd.kode," - ",httphtd.nama)
                    )
                ) as text'
            ])
            ->where('httphtd..id', $id_httphtd_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_httphtd_self = $qs_httphtd_self->fetchAll();
    }else{
        $rs_httphtd_self = [];
    }
    // END query options self

    // BEGIN query options all except self
    $qs_httphtd_all = $db
        ->query('select', 'httphtd')
        ->get([
            'httphtd.id as id',
            'IF(
                httphtd.kode IS NULL, 
                httphtd.nama,
                IF(
                    httphtd.nama IS NULL, 
                    httphtd.kode,
                    CONCAT(httphtd.kode," - ",httphtd.nama)
                )
            ) as text'
        ])
        ->where('httphtd.transaction_state',1)
        ->where('httphtd.id', $id_httphtd_old, '<>' )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('httphtd.kode', '%' . $q . '%', 'LIKE' )
                ->or_where('httphtd.nama', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_httphtd_all = $qs_httphtd_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_httphtd_self) > 0){
        $rs_opt = array_merge($rs_httphtd_self, $rs_httphtd_all);
    }else{
        $rs_opt = $rs_httphtd_all;
    }
    $c_rs_opt = count($rs_opt);    
    // END menggabungkan options

    // BEGIN finalisasi paginasi select2
    $endCount  = $offset + $resultCount;
    $morePages = $endCount > $c_rs_opt;
    // END finalisasi paginasi select2
    
    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>