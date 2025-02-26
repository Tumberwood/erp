<?php
    /**
     * Digunakan untuk populate options data item category
     * Table terkait    : sodxxth
     * Parameter        : 
     *  - id_sodxxth_old   : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_sodxxth_old'] > 0){
        $id_sodxxth_old = $_GET['id_sodxxth_old'];
    }else{
        $id_sodxxth_old = 0;
    }

    if($_GET['id_grlxxmh_customer'] > 0){
        $id_grlxxmh_customer = $_GET['id_grlxxmh_customer'];
    }else{
        $id_grlxxmh_customer = 0;
    }

    // BEGIN query self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_sodxxth_old > 0){
        $qs_sodxxth_self = $db
            ->query('select', 'sodxxth')
            ->get([
                'sodxxth.id as id',
                'sodxxth.kode as text'
            ])
            ->where('sodxxth.id', $id_sodxxth_old )            
            ->exec();
        $rs_sodxxth_self = $qs_sodxxth_self->fetchAll();
    }else{
        $rs_sodxxth_self = [];
    }
    // END query self

    $qs_sisa = $db
        ->raw()
        ->exec('WITH sisa AS (
                    SELECT
                        a.id_sodxxth,
                        SUM(a.jumlah_terkecil_os) s_jumlah_terkecil_os
                    FROM sodittd a
                    GROUP BY a.id_sodxxth
                    HAVING s_jumlah_terkecil_os > 0
                )
                SELECT
                    GROUP_CONCAT(id_sodxxth) s_id_sodxxth
                FROM sisa
    ');
    $rs_sisa = $qs_sisa->fetch();
    $s_id_sodxxth = '('.$rs_sisa['s_id_sodxxth'].')';

    // BEGIN query options all except self
    $qs_sodxxth_all = $db
        ->query('select', 'sodxxth')
        ->get([
            'sodxxth.id as id',
            'sodxxth.kode as text'
        ])
        ->where('sodxxth.transaction_state',1)
        ->where('sodxxth.approval_state', 9)
        ->where('sodxxth.id_grlxxmh_customer', $id_grlxxmh_customer)
        ->where('sodxxth.id', $id_sodxxth_old, '<>' )
        ->where('sodxxth.id', $s_id_sodxxth, 'IN', false )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r->where('sodxxth.kode', '%' . $q . '%', 'LIKE' );
        } )
        ->order('sodxxth.kode')
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_sodxxth_all = $qs_sodxxth_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_sodxxth_self) > 0){
        $rs_opt = array_merge($rs_sodxxth_self, $rs_sodxxth_all);
    }else{
        $rs_opt = $rs_sodxxth_all;
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