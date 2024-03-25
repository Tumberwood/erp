<?php 
    /**
     * Digunakan untuk populate options data branch / cabang
     * Table terkait    : scuxxmh
     * Parameter        : 
     *  - id_scuxxmh_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_scuxxmh_old'] > 0){
        $id_scuxxmh_old = $_GET['id_scuxxmh_old'];
    }else{
        $id_scuxxmh_old = 0;
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_scuxxmh_old > 0){
        $qs_scuxxmh_self = $db
            ->query('select', 'scuxxmh')
            ->get([
                'scuxxmh.id as id',
                'IF(
                    scuxxmh.kode IS NULL, 
                    scuxxmh.nama,
                    IF(
                        scuxxmh.nama IS NULL, 
                        scuxxmh.kode,
                        CONCAT(scuxxmh.kode," - ",scuxxmh.nama)
                    )
                ) as text'
            ])
            ->where('scuxxmh.id', $id_scuxxmh_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_scuxxmh_self = $qs_scuxxmh_self->fetchAll();
    }else{
        $rs_scuxxmh_self = [];
    }
    // END query options self

    // BEGIN query options all except self
    $qs_scuxxmh_all = $db
        ->query('select', 'scuxxmh')
        ->get([
            'scuxxmh.id as id',
            'IF(
                scuxxmh.kode IS NULL, 
                scuxxmh.nama,
                IF(
                    scuxxmh.nama IS NULL, 
                    scuxxmh.kode,
                    CONCAT(scuxxmh.kode," - ",scuxxmh.nama)
                )
            ) as text'
        ])
        ->where('scuxxmh.transaction_state',1)
        ->where('scuxxmh.id', $id_scuxxmh_old, '<>' )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('scuxxmh.kode', '%' . $q . '%', 'LIKE' )
                ->or_where('scuxxmh.nama', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_scuxxmh_all = $qs_scuxxmh_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_scuxxmh_self) > 0){
        $rs_opt = array_merge($rs_scuxxmh_self, $rs_scuxxmh_all);
    }else{
        $rs_opt = $rs_scuxxmh_all;
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