<?php 
    /**
     * Digunakan untuk populate options data holxxmh
     * Table terkait    : holxxmh
     * Parameter        : 
     *  - id_holxxmh_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_holxxmh_old'] > 0){
        $id_holxxmh_old = $_GET['id_holxxmh_old'];
    }else{
        $id_holxxmh_old = 0;
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_holxxmh_old > 0){
        $qs_holxxmh_self = $db
            ->query('select', 'holxxmh')
            ->get([
                'holxxmh.id as id',
                'IF(
                    holxxmh.kode IS NULL, 
                    holxxmh.nama,
                    IF(
                        holxxmh.nama IS NULL, 
                        holxxmh.kode,
                        CONCAT(holxxmh.kode," - ",holxxmh.nama)
                    )
                ) as text'
            ])
            ->where('holxxmh..id', $id_holxxmh_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_holxxmh_self = $qs_holxxmh_self->fetchAll();
    }else{
        $rs_holxxmh_self = [];
    }
    // END query options self

    // BEGIN query options all except self
    $qs_holxxmh_all = $db
        ->query('select', 'holxxmh')
        ->get([
            'holxxmh.id as id',
            'IF(
                holxxmh.kode IS NULL, 
                holxxmh.nama,
                IF(
                    holxxmh.nama IS NULL, 
                    holxxmh.kode,
                    CONCAT(holxxmh.kode," - ",holxxmh.nama)
                )
            ) as text'
        ])
        ->where('holxxmh.transaction_state',1)
        ->where('holxxmh.id', $id_holxxmh_old, '<>' )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('holxxmh.kode', '%' . $q . '%', 'LIKE' )
                ->or_where('holxxmh.nama', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_holxxmh_all = $qs_holxxmh_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_holxxmh_self) > 0){
        $rs_opt = array_merge($rs_holxxmh_self, $rs_holxxmh_all);
    }else{
        $rs_opt = $rs_holxxmh_all;
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