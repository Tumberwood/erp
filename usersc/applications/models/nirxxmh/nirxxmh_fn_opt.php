<?php 
    /**
     * Digunakan untuk populate options data nirxxmh
     * Table terkait    : nirxxmh
     * Parameter        : 
     *  - id_nirxxmh_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_nirxxmh_old'] > 0){
        $id_nirxxmh_old = $_GET['id_nirxxmh_old'];
    }else{
        $id_nirxxmh_old = 0;
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_nirxxmh_old > 0){
        $qs_nirxxmh_self = $db
            ->query('select', 'nirxxmh')
            ->get([
                'nirxxmh.id as id',
                'IF(
                    nirxxmh.kode IS NULL, 
                    nirxxmh.nama,
                    IF(
                        nirxxmh.nama IS NULL, 
                        nirxxmh.kode,
                        CONCAT(nirxxmh.kode," - ",nirxxmh.nama)
                    )
                ) as text'
            ])
            ->where('nirxxmh..id', $id_nirxxmh_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_nirxxmh_self = $qs_nirxxmh_self->fetchAll();
    }else{
        $rs_nirxxmh_self = [];
    }
    // END query options self

    // BEGIN query options all except self
    $qs_nirxxmh_all = $db
        ->query('select', 'nirxxmh')
        ->get([
            'nirxxmh.id as id',
            'IF(
                nirxxmh.kode IS NULL, 
                nirxxmh.nama,
                IF(
                    nirxxmh.nama IS NULL, 
                    nirxxmh.kode,
                    CONCAT(nirxxmh.kode," - ",nirxxmh.nama)
                )
            ) as text'
        ])
        ->where('nirxxmh.transaction_state',1)
        ->where('nirxxmh.id', $id_nirxxmh_old, '<>' )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('nirxxmh.kode', '%' . $q . '%', 'LIKE' )
                ->or_where('nirxxmh.nama', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_nirxxmh_all = $qs_nirxxmh_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_nirxxmh_self) > 0){
        $rs_opt = array_merge($rs_nirxxmh_self, $rs_nirxxmh_all);
    }else{
        $rs_opt = $rs_nirxxmh_all;
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