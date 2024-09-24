<?php 
    /**
     * Digunakan untuk populate options data hrremth
     * Table terkait    : hrremth
     * Parameter        : 
     *  - id_hrremth_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_hrremth_old'] > 0){
        $id_hrremth_old = $_GET['id_hrremth_old'];
    }else{
        $id_hrremth_old = 0;
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_hrremth_old > 0){
        $qs_hrremth_self = $db
            ->query('select', 'hrremth')
            ->get([
                'hrremth.id as id',
                'kode as text'
            ])
            ->where('hrremth..id', $id_hrremth_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_hrremth_self = $qs_hrremth_self->fetchAll();
    }else{
        $rs_hrremth_self = [];
    }
    // END query options self

    // BEGIN query options all except self
    $qs_hrremth_all = $db
        ->query('select', 'hrremth')
        ->get([
            'hrremth.id as id',
            'kode as text'
        ])
        ->where('hrremth.transaction_state',1)
        ->where('hrremth.id', $id_hrremth_old, '<>' )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('hrremth.kode', '%' . $q . '%', 'LIKE' )
                ;
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_hrremth_all = $qs_hrremth_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_hrremth_self) > 0){
        $rs_opt = array_merge($rs_hrremth_self, $rs_hrremth_all);
    }else{
        $rs_opt = $rs_hrremth_all;
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