<?php 
    /**
     * Digunakan untuk populate options data aatxxmh
     * Table terkait    : aatxxmh
     * Parameter        : 
     *  - id_aatxxmh_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_aatxxmh_old'] > 0){
        $id_aatxxmh_old = $_GET['id_aatxxmh_old'];
    }else{
        $id_aatxxmh_old = 0;
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_aatxxmh_old > 0){
        $qs_aatxxmh_self = $db
            ->query('select', 'aatxxmh')
            ->get([
                'aatxxmh.id as id',
                'IF(
                    aatxxmh.kode IS NULL, 
                    aatxxmh.nama,
                    IF(
                        aatxxmh.nama IS NULL, 
                        aatxxmh.kode,
                        CONCAT(aatxxmh.kode," - ",aatxxmh.nama)
                    )
                ) as text'
            ])
            ->where('aatxxmh..id', $id_aatxxmh_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_aatxxmh_self = $qs_aatxxmh_self->fetchAll();
    }else{
        $rs_aatxxmh_self = [];
    }
    // END query options self

    // BEGIN query options all except self
    $qs_aatxxmh_all = $db
        ->query('select', 'aatxxmh')
        ->get([
            'aatxxmh.id as id',
            'IF(
                aatxxmh.kode IS NULL, 
                aatxxmh.nama,
                IF(
                    aatxxmh.nama IS NULL, 
                    aatxxmh.kode,
                    CONCAT(aatxxmh.kode," - ",aatxxmh.nama)
                )
            ) as text'
        ])
        ->where('aatxxmh.transaction_state',1)
        ->where('aatxxmh.id', $id_aatxxmh_old, '<>' )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('aatxxmh.kode', '%' . $q . '%', 'LIKE' )
                ->or_where('aatxxmh.nama', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_aatxxmh_all = $qs_aatxxmh_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_aatxxmh_self) > 0){
        $rs_opt = array_merge($rs_aatxxmh_self, $rs_aatxxmh_all);
    }else{
        $rs_opt = $rs_aatxxmh_all;
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