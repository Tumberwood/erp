<?php 
    /**
     * Digunakan untuk populate options data _blank
     * Table terkait    : _blank
     * Parameter        : 
     *  - id__blank_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id__blank_old'] > 0){
        $id__blank_old = $_GET['id__blank_old'];
    }else{
        $id__blank_old = 0;
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id__blank_old > 0){
        $qs__blank_self = $db
            ->query('select', '_blank')
            ->get([
                '_blank.id as id',
                'IF(
                    _blank.kode IS NULL, 
                    _blank.nama,
                    IF(
                        _blank.nama IS NULL, 
                        _blank.kode,
                        CONCAT(_blank.kode," - ",_blank.nama)
                    )
                ) as text'
            ])
            ->where('_blank..id', $id__blank_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs__blank_self = $qs__blank_self->fetchAll();
    }else{
        $rs__blank_self = [];
    }
    // END query options self

    // BEGIN query options all except self
    $qs__blank_all = $db
        ->query('select', '_blank')
        ->get([
            '_blank.id as id',
            'IF(
                _blank.kode IS NULL, 
                _blank.nama,
                IF(
                    _blank.nama IS NULL, 
                    _blank.kode,
                    CONCAT(_blank.kode," - ",_blank.nama)
                )
            ) as text'
        ])
        ->where('_blank.transaction_state',1)
        ->where('_blank.id', $id__blank_old, '<>' )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('_blank.kode', '%' . $q . '%', 'LIKE' )
                ->or_where('_blank.nama', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs__blank_all = $qs__blank_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs__blank_self) > 0){
        $rs_opt = array_merge($rs__blank_self, $rs__blank_all);
    }else{
        $rs_opt = $rs__blank_all;
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