<?php 
    /**
     * Digunakan untuk populate options data nirctmh
     * Table terkait    : nirctmh
     * Parameter        : 
     *  - id_nirctmh_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_nirctmh_old'] > 0){
        $id_nirctmh_old = $_GET['id_nirctmh_old'];
    }else{
        $id_nirctmh_old = 0;
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_nirctmh_old > 0){
        $qs_nirctmh_self = $db
            ->query('select', 'nirctmh')
            ->get([
                'nirctmh.id as id',
                'IF(
                    nirctmh.kode IS NULL, 
                    nirctmh.nama,
                    IF(
                        nirctmh.nama IS NULL, 
                        nirctmh.kode,
                        CONCAT(nirctmh.kode," - ",nirctmh.nama)
                    )
                ) as text'
            ])
            ->where('nirctmh..id', $id_nirctmh_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_nirctmh_self = $qs_nirctmh_self->fetchAll();
    }else{
        $rs_nirctmh_self = [];
    }
    // END query options self

    // BEGIN query options all except self
    $qs_nirctmh_all = $db
        ->query('select', 'nirctmh')
        ->get([
            'nirctmh.id as id',
            'IF(
                nirctmh.kode IS NULL, 
                nirctmh.nama,
                IF(
                    nirctmh.nama IS NULL, 
                    nirctmh.kode,
                    CONCAT(nirctmh.kode," - ",nirctmh.nama)
                )
            ) as text'
        ])
        ->where('nirctmh.transaction_state',1)
        ->where('nirctmh.id', $id_nirctmh_old, '<>' )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('nirctmh.kode', '%' . $q . '%', 'LIKE' )
                ->or_where('nirctmh.nama', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_nirctmh_all = $qs_nirctmh_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_nirctmh_self) > 0){
        $rs_opt = array_merge($rs_nirctmh_self, $rs_nirctmh_all);
    }else{
        $rs_opt = $rs_nirctmh_all;
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