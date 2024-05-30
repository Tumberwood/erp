<?php 
    /**
     * Digunakan untuk populate options data nevxxth
     * Table terkait    : nevxxth
     * Parameter        : 
     *  - id_nevxxth_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_nevxxth_old'] > 0){
        $id_nevxxth_old = $_GET['id_nevxxth_old'];
    }else{
        $id_nevxxth_old = 0;
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_nevxxth_old > 0){
        $qs_nevxxth_self = $db
            ->query('select', 'nevxxth')
            ->get([
                'nevxxth.id as id',
                'IF(
                    nevxxth.kode IS NULL, 
                    nevxxth.nama,
                    IF(
                        nevxxth.nama IS NULL, 
                        nevxxth.kode,
                        CONCAT(nevxxth.kode," - ",nevxxth.nama)
                    )
                ) as text'
            ])
            ->where('nevxxth..id', $id_nevxxth_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_nevxxth_self = $qs_nevxxth_self->fetchAll();
    }else{
        $rs_nevxxth_self = [];
    }
    // END query options self

    // BEGIN query options all except self
    $qs_nevxxth_all = $db
        ->query('select', 'nevxxth')
        ->get([
            'nevxxth.id as id',
            'IF(
                nevxxth.kode IS NULL, 
                nevxxth.nama,
                IF(
                    nevxxth.nama IS NULL, 
                    nevxxth.kode,
                    CONCAT(nevxxth.kode," - ",nevxxth.nama)
                )
            ) as text'
        ])
        ->where('nevxxth.transaction_state',1)
        ->where('nevxxth.id', $id_nevxxth_old, '<>' )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('nevxxth.kode', '%' . $q . '%', 'LIKE' )
                ->or_where('nevxxth.nama', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_nevxxth_all = $qs_nevxxth_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_nevxxth_self) > 0){
        $rs_opt = array_merge($rs_nevxxth_self, $rs_nevxxth_all);
    }else{
        $rs_opt = $rs_nevxxth_all;
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