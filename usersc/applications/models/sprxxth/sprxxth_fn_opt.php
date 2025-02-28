<?php 
    /**
     * Digunakan untuk populate options data sprxxth
     * Table terkait    : sprxxth
     * Parameter        : 
     *  - id_sprxxth_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_sprxxth_old'] > 0){
        $id_sprxxth_old = $_GET['id_sprxxth_old'];
    }else{
        $id_sprxxth_old = 0;
    }

    if($_GET['id_grlxxmh_customer'] > 0){
        $id_grlxxmh_customer = $_GET['id_grlxxmh_customer'];
    }else{
        $id_grlxxmh_customer = 0;
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_sprxxth_old > 0){
        $qs_sprxxth_self = $db
            ->query('select', 'sprxxth')
            ->get([
                'sprxxth.id as id',
                'IF(
                    sprxxth.kode IS NULL, 
                    sprxxth.nama,
                    IF(
                        sprxxth.nama IS NULL, 
                        sprxxth.kode,
                        CONCAT(sprxxth.kode," - ",sprxxth.nama)
                    )
                ) as text'
            ])
            ->where('sprxxth..id', $id_sprxxth_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_sprxxth_self = $qs_sprxxth_self->fetchAll();
    }else{
        $rs_sprxxth_self = [];
    }
    // END query options self

    $qs_sprxxth = $db
        ->raw()
        ->exec('SELECT
                    a.id_sprxxth
                FROM sprivtd a
                WHERE a.is_purchase_payment = 1
                GROUP BY a.id_sprxxth
    ');
    
    $rs_sprxxth = $qs_sprxxth->fetchAll();

    if (empty($rs_sprxxth)) {
        $exclude = '(-9)';
    } else {
        $ids = array_column($rs_sprxxth, 'id_sprxxth');
        $exclude = '(' . implode(',', $ids) . ')';
    }

    // BEGIN query options all except self
    $qs_sprxxth_all = $db
        ->query('select', 'sprxxth')
        ->get([
            'sprxxth.id as id',
            'IF(
                sprxxth.kode IS NULL, 
                sprxxth.nama,
                IF(
                    sprxxth.nama IS NULL, 
                    sprxxth.kode,
                    CONCAT(sprxxth.kode," - ",sprxxth.nama)
                )
            ) as text'
        ])
        ->where('sprxxth.transaction_state',1)
        ->where('sprxxth.id', $id_sprxxth_old, '<>' )
        ->where('sprxxth.id', $exclude, 'NOT IN', false )
        ->where('sprxxth.id_grlxxmh_customer', $id_grlxxmh_customer)
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('sprxxth.kode', '%' . $q . '%', 'LIKE' )
                ->or_where('sprxxth.nama', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_sprxxth_all = $qs_sprxxth_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_sprxxth_self) > 0){
        $rs_opt = array_merge($rs_sprxxth_self, $rs_sprxxth_all);
    }else{
        $rs_opt = $rs_sprxxth_all;
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