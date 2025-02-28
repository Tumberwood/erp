<?php 
    /**
     * Digunakan untuk populate options data fprxxth
     * Table terkait    : fprxxth
     * Parameter        : 
     *  - id_fprxxth_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_fprxxth_old'] > 0){
        $id_fprxxth_old = $_GET['id_fprxxth_old'];
    }else{
        $id_fprxxth_old = 0;
    }

    if($_GET['id_grlxxmh_supplier'] > 0){
        $id_grlxxmh_supplier = $_GET['id_grlxxmh_supplier'];
    }else{
        $id_grlxxmh_supplier = 0;
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_fprxxth_old > 0){
        $qs_fprxxth_self = $db
            ->query('select', 'fprxxth')
            ->get([
                'fprxxth.id as id',
                'IF(
                    fprxxth.kode IS NULL, 
                    fprxxth.nama,
                    IF(
                        fprxxth.nama IS NULL, 
                        fprxxth.kode,
                        CONCAT(fprxxth.kode," - ",fprxxth.nama)
                    )
                ) as text'
            ])
            ->where('fprxxth..id', $id_fprxxth_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_fprxxth_self = $qs_fprxxth_self->fetchAll();
    }else{
        $rs_fprxxth_self = [];
    }
    // END query options self

    $qs_fprxxth = $db
        ->raw()
        ->exec('SELECT
                    a.id_fprxxth
                FROM fprivtd a
                WHERE a.is_purchase_payment = 1
                GROUP BY a.id_fprxxth
    ');
    
    $rs_fprxxth = $qs_fprxxth->fetchAll();
    
    if (empty($rs_fprxxth)) {
        $exclude = '(-9)';
    } else {
        $ids = array_column($rs_fprxxth, 'id_fprxxth');
        $exclude = '(' . implode(',', $ids) . ')';
    }

    // BEGIN query options all except self
    $qs_fprxxth_all = $db
        ->query('select', 'fprxxth')
        ->get([
            'fprxxth.id as id',
            'IF(
                fprxxth.kode IS NULL, 
                fprxxth.nama,
                IF(
                    fprxxth.nama IS NULL, 
                    fprxxth.kode,
                    CONCAT(fprxxth.kode," - ",fprxxth.nama)
                )
            ) as text'
        ])
        ->where('fprxxth.transaction_state',1)
        ->where('fprxxth.id', $id_fprxxth_old, '<>' )
        ->where('fprxxth.id', $exclude, 'NOT IN', false )
        ->where('fprxxth.id_grlxxmh_supplier', $id_grlxxmh_supplier)
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('fprxxth.kode', '%' . $q . '%', 'LIKE' )
                ->or_where('fprxxth.nama', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_fprxxth_all = $qs_fprxxth_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_fprxxth_self) > 0){
        $rs_opt = array_merge($rs_fprxxth_self, $rs_fprxxth_all);
    }else{
        $rs_opt = $rs_fprxxth_all;
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