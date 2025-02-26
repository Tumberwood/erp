<?php 
    /**
     * Digunakan untuk populate options data sivxxth
     * Table terkait    : sivxxth
     * Parameter        : 
     *  - id_sivxxth_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_sivxxth_old'] > 0){
        $id_sivxxth_old = $_GET['id_sivxxth_old'];
    }else{
        $id_sivxxth_old = 0;
    }

    if($_GET['id_grlxxmh_customer'] > 0){
        $id_grlxxmh_customer = $_GET['id_grlxxmh_customer'];
    }else{
        $id_grlxxmh_customer = 0;
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_sivxxth_old > 0){
        $qs_sivxxth_self = $db
            ->query('select', 'sivxxth')
            ->get([
                'sivxxth.id as id',
                'IF(
                    sivxxth.kode IS NULL, 
                    sivxxth.nama,
                    IF(
                        sivxxth.nama IS NULL, 
                        sivxxth.kode,
                        CONCAT(sivxxth.kode," - ",sivxxth.nama)
                    )
                ) as text'
            ])
            ->where('sivxxth..id', $id_sivxxth_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_sivxxth_self = $qs_sivxxth_self->fetchAll();
    }else{
        $rs_sivxxth_self = [];
    }
    // END query options self

    // BEGIN query options all except self
    $qs_sivxxth_all = $db
        ->query('select', 'sivxxth')
        ->get([
            'sivxxth.id as id',
            'IF(
                sivxxth.kode IS NULL, 
                sivxxth.nama,
                IF(
                    sivxxth.nama IS NULL, 
                    sivxxth.kode,
                    CONCAT(sivxxth.kode," - ",sivxxth.nama)
                )
            ) as text'
        ])
        ->where('sivxxth.transaction_state',1)
        ->where('sivxxth.id', $id_sivxxth_old, '<>' )
        ->where('sivxxth.id_grlxxmh_customer', $id_grlxxmh_customer)
        ->where('sivxxth.selisih_bayar', 0, '>' )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('sivxxth.kode', '%' . $q . '%', 'LIKE' )
                ->or_where('sivxxth.nama', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_sivxxth_all = $qs_sivxxth_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_sivxxth_self) > 0){
        $rs_opt = array_merge($rs_sivxxth_self, $rs_sivxxth_all);
    }else{
        $rs_opt = $rs_sivxxth_all;
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