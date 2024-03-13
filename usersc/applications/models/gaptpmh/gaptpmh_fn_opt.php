<?php 
    /**
     * Digunakan untuk populate options data branch / cabang
     * Table terkait    : gaptpmh
     * Parameter        : 
     *  - id_gaptpmh_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_gaptpmh_old'] > 0){
        $id_gaptpmh_old = $_GET['id_gaptpmh_old'];
    }else{
        $id_gaptpmh_old = 0;
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_gaptpmh_old > 0){
        $qs_gaptpmh_self = $db
            ->query('select', 'gaptpmh')
            ->get([
                'gaptpmh.id as id',
                'IF(
                    gaptpmh.kode IS NULL, 
                    gaptpmh.nama,
                    IF(
                        gaptpmh.nama IS NULL, 
                        gaptpmh.kode,
                        CONCAT(gaptpmh.kode," - ",gaptpmh.nama)
                    )
                ) as text'
            ])
            ->where('gaptpmh.id', $id_gaptpmh_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_gaptpmh_self = $qs_gaptpmh_self->fetchAll();
    }else{
        $rs_gaptpmh_self = [];
    }
    // END query options self

    // BEGIN query options all except self
    $qs_gaptpmh_all = $db
        ->query('select', 'gaptpmh')
        ->get([
            'gaptpmh.id as id',
            'IF(
                gaptpmh.kode IS NULL, 
                gaptpmh.nama,
                IF(
                    gaptpmh.nama IS NULL, 
                    gaptpmh.kode,
                    CONCAT(gaptpmh.kode," - ",gaptpmh.nama)
                )
            ) as text'
        ])
        ->where('gaptpmh.transaction_state',1)
        ->where('gaptpmh.id', $id_gaptpmh_old, '<>' )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('gaptpmh.kode', '%' . $q . '%', 'LIKE' )
                ->or_where('gaptpmh.nama', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_gaptpmh_all = $qs_gaptpmh_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_gaptpmh_self) > 0){
        $rs_opt = array_merge($rs_gaptpmh_self, $rs_gaptpmh_all);
    }else{
        $rs_opt = $rs_gaptpmh_all;
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