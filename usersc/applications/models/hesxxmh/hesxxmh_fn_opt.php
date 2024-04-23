<?php 
    /**
     * Digunakan untuk populate options data branch / cabang
     * Table terkait    : hesxxmh
     * Parameter        : 
     *  - id_hesxxmh_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_hesxxmh_old'] > 0){
        $id_hesxxmh_old = $_GET['id_hesxxmh_old'];
    }else{
        $id_hesxxmh_old = 0;
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_hesxxmh_old > 0){
        $qs_hesxxmh_self = $db
            ->query('select', 'hesxxmh')
            ->get([
                'hesxxmh.id as id',
                'IF(
                    hesxxmh.kode IS NULL, 
                    hesxxmh.nama,
                    IF(
                        hesxxmh.nama IS NULL, 
                        hesxxmh.kode,
                        CONCAT(hesxxmh.kode," - ",hesxxmh.nama)
                    )
                ) as text'
            ])
            ->where('hesxxmh.id', $id_hesxxmh_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_hesxxmh_self = $qs_hesxxmh_self->fetchAll();
    }else{
        $rs_hesxxmh_self = [];
    }
    // END query options self

    // BEGIN query options all except self
    $qs_hesxxmh_all = $db
        ->query('select', 'hesxxmh')
        ->get([
            'hesxxmh.id as id',
            'IF(
                hesxxmh.kode IS NULL, 
                hesxxmh.nama,
                IF(
                    hesxxmh.nama IS NULL, 
                    hesxxmh.kode,
                    CONCAT(hesxxmh.kode," - ",hesxxmh.nama)
                )
            ) as text'
        ])
        ->where('hesxxmh.transaction_state',1)
        ->where('hesxxmh.id', $id_hesxxmh_old, '<>' )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('hesxxmh.kode', '%' . $q . '%', 'LIKE' )
                ->or_where('hesxxmh.nama', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_hesxxmh_all = $qs_hesxxmh_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_hesxxmh_self) > 0){
        $rs_opt = array_merge($rs_hesxxmh_self, $rs_hesxxmh_all);
    }else{
        $rs_opt = $rs_hesxxmh_all;
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