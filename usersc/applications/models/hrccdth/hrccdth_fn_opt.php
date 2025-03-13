<?php 
    /**
     * Digunakan untuk populate options data hrccdth
     * Table terkait    : hrccdth
     * Parameter        : 
     *  - id_hrccdth_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_hrccdth_old'] > 0){
        $id_hrccdth_old = $_GET['id_hrccdth_old'];
    }else{
        $id_hrccdth_old = 0;
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_hrccdth_old > 0){
        $qs_hrccdth_self = $db
            ->query('select', 'hrccdth')
            ->get([
                'hrccdth.id as id',
                'IF(
                    hrccdth.kode IS NULL, 
                    hrccdth.nama,
                    IF(
                        hrccdth.nama IS NULL, 
                        hrccdth.kode,
                        CONCAT(hrccdth.kode," - ",hrccdth.nama)
                    )
                ) as text'
            ])
            ->where('hrccdth..id', $id_hrccdth_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_hrccdth_self = $qs_hrccdth_self->fetchAll();
    }else{
        $rs_hrccdth_self = [];
    }
    // END query options self

    // BEGIN query options all except self
    $qs_hrccdth_all = $db
        ->query('select', 'hrccdth')
        ->get([
            'hrccdth.id as id',
            'IF(
                hrccdth.kode IS NULL, 
                hrccdth.nama,
                IF(
                    hrccdth.nama IS NULL, 
                    hrccdth.kode,
                    CONCAT(hrccdth.kode," - ",hrccdth.nama)
                )
            ) as text'
        ])
        ->where('hrccdth.transaction_state',1)
        ->where('hrccdth.id', $id_hrccdth_old, '<>' )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('hrccdth.kode', '%' . $q . '%', 'LIKE' )
                ->or_where('hrccdth.nama', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_hrccdth_all = $qs_hrccdth_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_hrccdth_self) > 0){
        $rs_opt = array_merge($rs_hrccdth_self, $rs_hrccdth_all);
    }else{
        $rs_opt = $rs_hrccdth_all;
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