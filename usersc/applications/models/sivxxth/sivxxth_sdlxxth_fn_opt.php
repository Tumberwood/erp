<?php
    /**
     * Digunakan untuk populate options data item category
     * Table terkait    : sdlxxth
     * Parameter        : 
     *  - id_sdlxxth_old   : data existing (untuk keperluan edit), dipakai di query self
     *  - id_grlxxmh_customer            : data id_grlxxmh_customer
     */        
    require_once( "../../../../users/init.php" );
	require_once( "../../../../usersc/lib/DataTables.php" );
	require_once( "../../../../usersc/helpers/datatables_fn_debug.php" );

    // BEGIN definisi variable untuk fn_ajax_results.php
    $data      = array();
    $rs_opt    = array();
    $c_rs_opt  = 0;
    $morePages = false;
    // END definisi variable untuk fn_ajax_results.php

    // BEGIN select2 pagination preparation
    $page        = $_GET['page'];
    $resultCount = 10;
    $offset      = ($page - 1) * $resultCount;
    // END select2 pagination preparation

    if($_GET['id_sdlxxth_old'] > 0){
        $id_sdlxxth_old = $_GET['id_sdlxxth_old'];
    }else{
        $id_sdlxxth_old = 0;
    }

    if($_GET['id_grlxxmh_customer'] > 0){
        $id_grlxxmh_customer = $_GET['id_grlxxmh_customer'];
    }else{
        $id_grlxxmh_customer = 0;
    }

    // BEGIN query self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_sdlxxth_old > 0){
        $qs_sdlxxth_self = $db
            ->query('select', 'sdlxxth')
            ->get([
                'sdlxxth.id as id',
                'sdlxxth.kode as text'
            ])
            ->where('sdlxxth.id', $id_sdlxxth_old )            
            ->exec();
        $rs_sdlxxth_self = $qs_sdlxxth_self->fetchAll();
    }else{
        $rs_sdlxxth_self = [];
    }
    // END query self

    //exclude sdl yang pernah dibuat di siv yang lain
    $qs_exclude = $db
        ->query('select', 'sivxxth' )
        ->get(['id_sdlxxth'] )
        ->where('transaction_state', -9, '<>' )
        ->exec();
    $rs_exclude = $qs_exclude->fetchAll();

    if (!empty($rs_exclude)) {
        $ids = array_column($rs_exclude, 'id_sdlxxth');
    
        // Create the WHERE IN clause string
        $ids_exclude = '(' . implode(',', $ids) . ')';
    } else {
        $ids_exclude = '(0)';
    }

    // BEGIN query options all except self
    $qs_sdlxxth_all = $db
        ->query('select', 'sdlxxth')
        ->get([
            'sdlxxth.id as id',
            'sdlxxth.kode as text'
        ])
        ->where('sdlxxth.transaction_state',1)
        // ->where('sdlxxth.approval_state', 9)
        ->where('sdlxxth.id_grlxxmh_customer', $id_grlxxmh_customer)
        ->where('sdlxxth.id', $id_sdlxxth_old, '<>' )
        ->where('sdlxxth.id_sodxxth', 0, '>' )
        ->where('sdlxxth.id', $ids_exclude, 'NOT IN', false)
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r->where('sdlxxth.kode', '%' . $q . '%', 'LIKE' );
        } )
        ->order('sdlxxth.kode')
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_sdlxxth_all = $qs_sdlxxth_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_sdlxxth_self) > 0){
        $rs_opt = array_merge($rs_sdlxxth_self, $rs_sdlxxth_all);
    }else{
        $rs_opt = $rs_sdlxxth_all;
    }
    $c_rs_opt = count($rs_opt);
    // END menggabungkan options

    // BEGIN untuk keperluan paginasi select2
    $endCount  = $offset + $resultCount;
    $morePages = $endCount > $c_rs_opt;
    // END untuk keperluan paginasi select2
    
    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );
?>