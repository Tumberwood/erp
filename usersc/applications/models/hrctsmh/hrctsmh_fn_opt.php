<?php 
    /**
     * Digunakan untuk populate options data hrctsmh
     * Table terkait    : hrctsmh
     * Parameter        : 
     *  - id_hrctsmh_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_hrctsmh_old'] > 0){
        $id_hrctsmh_old = $_GET['id_hrctsmh_old'];
    }else{
        $id_hrctsmh_old = 0;
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_hrctsmh_old > 0){
        $qs_hrctsmh_self = $db
            ->query('select', 'hrctsmh')
            ->get([
                'hrctsmh.id as id',
                'IF(
                    hrctsmh.kode IS NULL, 
                    hrctsmh.nama,
                    IF(
                        hrctsmh.nama IS NULL, 
                        hrctsmh.kode,
                        CONCAT(hrctsmh.kode," - ",hrctsmh.nama)
                    )
                ) as text'
            ])
            ->where('hrctsmh..id', $id_hrctsmh_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_hrctsmh_self = $qs_hrctsmh_self->fetchAll();
    }else{
        $rs_hrctsmh_self = [];
    }
    // END query options self

    // BEGIN query options all except self
    $qs_hrctsmh_all = $db
        ->query('select', 'hrctsmh')
        ->get([
            'hrctsmh.id as id',
            'IF(
                hrctsmh.kode IS NULL, 
                hrctsmh.nama,
                IF(
                    hrctsmh.nama IS NULL, 
                    hrctsmh.kode,
                    CONCAT(hrctsmh.kode," - ",hrctsmh.nama)
                )
            ) as text'
        ])
        ->where('hrctsmh.transaction_state',1)
        ->where('hrctsmh.id', $id_hrctsmh_old, '<>' )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('hrctsmh.kode', '%' . $q . '%', 'LIKE' )
                ->or_where('hrctsmh.nama', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_hrctsmh_all = $qs_hrctsmh_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_hrctsmh_self) > 0){
        $rs_opt = array_merge($rs_hrctsmh_self, $rs_hrctsmh_all);
    }else{
        $rs_opt = $rs_hrctsmh_all;
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