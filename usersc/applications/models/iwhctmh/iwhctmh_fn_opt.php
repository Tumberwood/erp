<?php 
    /**
     * Digunakan untuk populate options data branch / cabang
     * Table terkait    : iwhctmh
     * Parameter        : 
     *  - id_iwhctmh_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_iwhctmh_old'] > 0){
        $id_iwhctmh_old = $_GET['id_iwhctmh_old'];
    }else{
        $id_iwhctmh_old = 0;
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_iwhctmh_old > 0){
        $qs_iwhctmh_self = $db
            ->query('select', 'iwhctmh')
            ->get([
                'iwhctmh.id as id',
                'IF(
                    iwhctmh.kode IS NULL, 
                    iwhctmh.nama,
                    IF(
                        iwhctmh.nama IS NULL, 
                        iwhctmh.kode,
                        CONCAT(iwhctmh.kode," - ",iwhctmh.nama)
                    )
                ) as text'
            ])
            ->where('iwhctmh..id', $id_iwhctmh_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_iwhctmh_self = $qs_iwhctmh_self->fetchAll();
    }else{
        $rs_iwhctmh_self = [];
    }
    // END query options self

    // BEGIN query options all except self
    $qs_iwhctmh_all = $db
        ->query('select', 'iwhctmh')
        ->get([
            'iwhctmh.id as id',
            'IF(
                iwhctmh.kode IS NULL, 
                iwhctmh.nama,
                IF(
                    iwhctmh.nama IS NULL, 
                    iwhctmh.kode,
                    CONCAT(iwhctmh.kode," - ",iwhctmh.nama)
                )
            ) as text'
        ])
        ->where('iwhctmh.transaction_state',1)
        ->where('iwhctmh.id', $id_iwhctmh_old, '<>' )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('iwhctmh.kode', '%' . $q . '%', 'LIKE' )
                ->or_where('iwhctmh.nama', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_iwhctmh_all = $qs_iwhctmh_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_iwhctmh_self) > 0){
        $rs_opt = array_merge($rs_iwhctmh_self, $rs_iwhctmh_all);
    }else{
        $rs_opt = $rs_iwhctmh_all;
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