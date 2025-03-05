<?php 
    /**
     * Digunakan untuk populate options data item category
     * Table terkait    : rmsxxmh
     * Parameter        : 
     *  - id_rmsxxmh_old    : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_rmsxxmh_old'] > 0){
        $id_rmsxxmh_old = $_GET['id_rmsxxmh_old'];
    }else{
        $id_rmsxxmh_old = 0;
    }

    if($_GET['id_cwoxxth'] > 0){
        $id_cwoxxth = $_GET['id_cwoxxth'];
    }else{
        $id_cwoxxth = 0;
    }

    // BEGIN query self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_rmsxxmh_old > 0){
        $qs_rmsxxmh_self = $db
            ->query('select', 'rmsxxmh')
            ->get([
                'id as id',
                'CONCAT(kode," - ",nama) as text'
            ])
            ->where('id', $id_rmsxxmh_old )
            ->exec();
        $rs_rmsxxmh_self = $qs_rmsxxmh_self->fetchAll();
    }else{
        $rs_rmsxxmh_self = [];
    }
    // END query self


    //Ambil id mesin yang sesuai dengan Header Work Order id_bom (th), lalu cari detail BoM work process
    $qs_filter = $db
        ->raw()
        ->bind(':id_cwoxxth', $id_cwoxxth)
        ->exec('SELECT
                    e.id id_rmsxxmh,
                    wp.nama,
                    e.nama
                FROM cwoittd a
                LEFT JOIN cwoxxth b ON b.id = a.id_cwoxxth
                LEFT JOIN dbmwptd c ON c.id_dbmxxth = b.id_dbmxxth
                LEFT JOIN rwpxxmh wp ON wp.id = c.id_rwpxxmh
                LEFT JOIN rmsxxmh_rwpxxmh d ON d.id_rwpxxmh = wp.id
                LEFT JOIN rmsxxmh e ON e.id = d.id_rmsxxmh
                WHERE b.id = :id_cwoxxth
    ');
    
    $rs_filter = $qs_filter->fetchAll();
    $id_rmsxxmh_list = array_column($rs_filter, 'id_rmsxxmh');

    $ids_rmsxxmh = '(' . implode(',', $id_rmsxxmh_list) . ')';

    // BEGIN query options all except self
    $qs_rmsxxmh_all = $db
        ->query('select', 'rmsxxmh')
        ->get([
            'id as id',
            'CONCAT(kode," - ",nama) as text'
        ])
        ->order('id')
        ->where('transaction_state',1)
        ->where('id', $id_rmsxxmh_old, '<>' )
        ->where('id', $ids_rmsxxmh, 'IN', false )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('kode', '%' . $q . '%', 'LIKE' )
                ->or_where('nama', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_rmsxxmh_all = $qs_rmsxxmh_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_rmsxxmh_self) > 0){
        $rs_opt = array_merge($rs_rmsxxmh_self, $rs_rmsxxmh_all);
    }else{
        $rs_opt = $rs_rmsxxmh_all;
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