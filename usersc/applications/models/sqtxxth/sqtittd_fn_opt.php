<?php 
    /**
     * Digunakan untuk populate options data badan usaha
     * Table terkait    : sqtittd
     * Parameter        : 
     *  - id_sqtittd_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_sqtittd_old'] > 0){
        $id_sqtittd_old = $_GET['id_sqtittd_old'];
    }else{
        $id_sqtittd_old = 0;
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_sqtittd_old > 0){
        $qs_sqtittd_self = $db
            ->query('select', 'sqtittd')
            ->get([
                'sqtittd.id as id',
                'IF(
                    sqtxxth.kode IS NULL, 
                    sqtittd.nama,
                    IF(
                        sqtittd.nama IS NULL, 
                        sqtxxth.kode,
                        CONCAT(sqtxxth.kode," - ",sqtittd.nama)
                    )
                ) as text'
            ])
            ->join('sqtxxth','sqtxxth.id = sqtittd.id_sqtxxth','LEFT' )
            ->where('sqtittd.id', $id_sqtittd_old )            
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_sqtittd_self = $qs_sqtittd_self->fetchAll();
    }else{
        $rs_sqtittd_self = [];
    }
    // END query options self

    // BEGIN query options all except self
    $qs_sqtittd_all = $db
        ->query('select', 'sqtittd')
        ->get([
            'sqtittd.id as id',
            'IF(
                sqtxxth.kode IS NULL, 
                sqtittd.nama,
                IF(
                    sqtittd.nama IS NULL, 
                    sqtxxth.kode,
                    CONCAT(sqtxxth.kode," - ",sqtittd.nama)
                )
            ) as text'
        ])
        ->join('sqtxxth','sqtxxth.id = sqtittd.id_sqtxxth','LEFT' )
        ->where('sqtxxth.transaction_state',1)
        ->where('sqtxxth.approval_state',9)
        ->where('sqtittd.id', $id_sqtittd_old, '<>' )
        ->where('sqtittd.is_nextprocess', null)
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('sqtxxth.kode', '%' . $q . '%', 'LIKE' )
                ->or_where('sqtittd.nama', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_sqtittd_all = $qs_sqtittd_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_sqtittd_self) > 0){
        $rs_opt = array_merge($rs_sqtittd_self, $rs_sqtittd_all);
    }else{
        $rs_opt = $rs_sqtittd_all;
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