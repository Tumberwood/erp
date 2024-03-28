<?php 
    /**
     * Digunakan untuk populate options data Expedition
     * Table terkait    : lexxxmh
     * Parameter        : 
     *  - id_lexxxmh_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_lexxxmh_old'] > 0){
        $id_lexxxmh_old = $_GET['id_lexxxmh_old'];
    }else{
        $id_lexxxmh_old = 0;
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_lexxxmh_old > 0){
        $qs_lexxxmh_self = $db
            ->query('select', 'lexxxmh')
            ->get([
                'lexxxmh.id as id',
                'IF(
                    lexxxmh.kode IS NULL, 
                    lexxxmh.nama,
                    IF(
                        lexxxmh.nama IS NULL, 
                        lexxxmh.kode,
                        CONCAT(lexxxmh.kode," - ",lexxxmh.nama)
                    )
                ) as text'
            ])
            ->where('lexxxmh..id', $id_lexxxmh_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_lexxxmh_self = $qs_lexxxmh_self->fetchAll();
    }else{
        $rs_lexxxmh_self = [];
    }
    // END query options self

    // BEGIN query options all except self
    $qs_lexxxmh_all = $db
        ->query('select', 'lexxxmh')
        ->get([
            'lexxxmh.id as id',
            'IF(
                lexxxmh.kode IS NULL, 
                lexxxmh.nama,
                IF(
                    lexxxmh.nama IS NULL, 
                    lexxxmh.kode,
                    CONCAT(lexxxmh.kode," - ",lexxxmh.nama)
                )
            ) as text'
        ])
        ->where('lexxxmh.transaction_state',1)
        ->where('lexxxmh.id', $id_lexxxmh_old, '<>' )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('lexxxmh.kode', '%' . $q . '%', 'LIKE' )
                ->or_where('lexxxmh.nama', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_lexxxmh_all = $qs_lexxxmh_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_lexxxmh_self) > 0){
        $rs_opt = array_merge($rs_lexxxmh_self, $rs_lexxxmh_all);
    }else{
        $rs_opt = $rs_lexxxmh_all;
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