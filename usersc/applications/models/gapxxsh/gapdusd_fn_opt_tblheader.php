<?php 
    /**
     * Digunakan untuk populate options data gapdusd
     * Table terkait    : gapdusd
     * Parameter        : 
     *  - tbl_group_nama_old       : data existing (untuk keperluan edit), dipakai di query self
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
    
    // echo 'tbl_group_nama_old ' . $_GET['tbl_group_nama_old'];
    // echo 'tblheader ' . $_GET['tblheader'];

    if($_GET['tbl_group_nama_old'] != ''){
        $tbl_group_nama_old = $_GET['tbl_group_nama_old'];
    }else{
        $tbl_group_nama_old = '';
    }
    // echo 'tbl_group_nama_old ' . $tbl_group_nama_old;

    $tblheader = $_GET['tblheader'];
    // echo 'tblheader ' . $tblheader;

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai nya
    if($tbl_group_nama_old != '' ){
        $qs_gapdusd_self = $db
            ->query('select', $tblheader)
            ->get([
                $tblheader.'.nama as id',
                $tblheader.'.nama as text'
            ])
            ->where($tblheader.'.nama', $tbl_group_nama_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_gapdusd_self = $qs_gapdusd_self->fetchAll();
    }else{
        $rs_gapdusd_self = [];
    }
    // END query options self

    // BEGIN query options all except self
    $qs_gapdusd_all = $db
        ->query('select', $tblheader)
        ->get([
            $tblheader.'.nama as id',
            $tblheader.'.nama as text'
        ])
        ->where($tblheader.'.transaction_state',1)
        ->where($tblheader.'.nama', $tbl_group_nama_old, '<>' )
        ->where( function ( $r ) use ($tblheader) {
            $q = $_GET['search'];
            $r
                ->where($tblheader.'.nama', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_gapdusd_all = $qs_gapdusd_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_gapdusd_self) > 0){
        $rs_opt = array_merge($rs_gapdusd_self, $rs_gapdusd_all);
    }else{
        $rs_opt = $rs_gapdusd_all;
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