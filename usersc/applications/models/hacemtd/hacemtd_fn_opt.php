<?php 
    /**
     * Digunakan untuk populate options data hacemtd
     * Table terkait    : hacemtd
     * Parameter        : 
     *  - id_hacemtd_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_hacemtd_old'] > 0){
        $id_hacemtd_old = $_GET['id_hacemtd_old'];
    }else{
        $id_hacemtd_old = 0;
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_hacemtd_old > 0){
        $qs_hacemtd_self = $db
            ->query('select', 'hacemtd')
            ->get([
                'hacemtd.id as id',
                'IF(
                    hacemtd.kode IS NULL, 
                    hacemtd.nama,
                    IF(
                        hacemtd.nama IS NULL, 
                        hacemtd.kode,
                        CONCAT(hacemtd.kode," - ",hacemtd.nama)
                    )
                ) as text'
            ])
            ->where('hacemtd..id', $id_hacemtd_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_hacemtd_self = $qs_hacemtd_self->fetchAll();
    }else{
        $rs_hacemtd_self = [];
    }
    // END query options self

    // BEGIN query options all except self
    $qs_hacemtd_all = $db
        ->query('select', 'hacemtd')
        ->get([
            'hacemtd.id as id',
            'IF(
                hacemtd.kode IS NULL, 
                hacemtd.nama,
                IF(
                    hacemtd.nama IS NULL, 
                    hacemtd.kode,
                    CONCAT(hacemtd.kode," - ",hacemtd.nama)
                )
            ) as text'
        ])
        ->where('hacemtd.transaction_state',1)
        ->where('hacemtd.id', $id_hacemtd_old, '<>' )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('hacemtd.kode', '%' . $q . '%', 'LIKE' )
                ->or_where('hacemtd.nama', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_hacemtd_all = $qs_hacemtd_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_hacemtd_self) > 0){
        $rs_opt = array_merge($rs_hacemtd_self, $rs_hacemtd_all);
    }else{
        $rs_opt = $rs_hacemtd_all;
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