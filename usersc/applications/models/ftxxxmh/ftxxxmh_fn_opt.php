<?php 
    /**
     * Digunakan untuk populate options data branch / cabang
     * Table terkait    : ftxxxmh
     * Parameter        : 
     *  - id_ftxxxmh_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_ftxxxmh_old'] > 0){
        $id_ftxxxmh_old = $_GET['id_ftxxxmh_old'];
    }else{
        $id_ftxxxmh_old = 0;
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_ftxxxmh_old > 0){
        $qs_ftxxxmh_self = $db
            ->query('select', 'ftxxxmh')
            ->get([
                'ftxxxmh.id as id',
                'IF(
                    ftxxxmh.kode IS NULL, 
                    ftxxxmh.nama,
                    IF(
                        ftxxxmh.nama IS NULL, 
                        ftxxxmh.kode,
                        CONCAT(ftxxxmh.kode," - ",ftxxxmh.nama)
                    )
                ) as text'
            ])
            ->where('ftxxxmh.id', $id_ftxxxmh_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_ftxxxmh_self = $qs_ftxxxmh_self->fetchAll();
    }else{
        $rs_ftxxxmh_self = [];
    }
    // END query options self

    // BEGIN query options all except self
    $qs_ftxxxmh_all = $db
        ->query('select', 'ftxxxmh')
        ->get([
            'ftxxxmh.id as id',
            'IF(
                ftxxxmh.kode IS NULL, 
                ftxxxmh.nama,
                IF(
                    ftxxxmh.nama IS NULL, 
                    ftxxxmh.kode,
                    CONCAT(ftxxxmh.kode," - ",ftxxxmh.nama)
                )
            ) as text'
        ])
        ->where('ftxxxmh.transaction_state',1)
        ->where('ftxxxmh.id', $id_ftxxxmh_old, '<>' )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('ftxxxmh.kode', '%' . $q . '%', 'LIKE' )
                ->or_where('ftxxxmh.nama', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_ftxxxmh_all = $qs_ftxxxmh_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_ftxxxmh_self) > 0){
        $rs_opt = array_merge($rs_ftxxxmh_self, $rs_ftxxxmh_all);
    }else{
        $rs_opt = $rs_ftxxxmh_all;
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