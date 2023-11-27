<?php 
    /**
     * Digunakan untuk populate options data branch / cabang
     * Table terkait    : fpytmmh
     * Parameter        : 
     *  - id_fpytmmh_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_fpytmmh_old'] > 0){
        $id_fpytmmh_old = $_GET['id_fpytmmh_old'];
    }else{
        $id_fpytmmh_old = 0;
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_fpytmmh_old > 0){
        $qs_fpytmmh_self = $db
            ->query('select', 'fpytmmh')
            ->get([
                'fpytmmh.id as id',
                'IF(
                    fpytmmh.kode IS NULL, 
                    fpytmmh.nama,
                    IF(
                        fpytmmh.nama IS NULL, 
                        fpytmmh.kode,
                        CONCAT(fpytmmh.kode," - ",fpytmmh.nama)
                    )
                ) as text'
            ])
            ->where('fpytmmh.id', $id_fpytmmh_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_fpytmmh_self = $qs_fpytmmh_self->fetchAll();
    }else{
        $rs_fpytmmh_self = [];
    }
    // END query options self

    // BEGIN query options all except self
    $qs_fpytmmh_all = $db
        ->query('select', 'fpytmmh')
        ->get([
            'fpytmmh.id as id',
            'IF(
                fpytmmh.kode IS NULL, 
                fpytmmh.nama,
                IF(
                    fpytmmh.nama IS NULL, 
                    fpytmmh.kode,
                    CONCAT(fpytmmh.kode," - ",fpytmmh.nama)
                )
            ) as text'
        ])
        ->where('fpytmmh.transaction_state',1)
        ->where('fpytmmh.id', $id_fpytmmh_old, '<>' )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('fpytmmh.kode', '%' . $q . '%', 'LIKE' )
                ->or_where('fpytmmh.nama', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_fpytmmh_all = $qs_fpytmmh_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_fpytmmh_self) > 0){
        $rs_opt = array_merge($rs_fpytmmh_self, $rs_fpytmmh_all);
    }else{
        $rs_opt = $rs_fpytmmh_all;
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