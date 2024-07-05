<?php
    /**
     * Digunakan untuk populate options data item category
     * Table terkait    : wdoxxth
     * Parameter        : 
     *  - id_wdoxxth_old   : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_wdoxxth_old'] > 0){
        $id_wdoxxth_old = $_GET['id_wdoxxth_old'];
    }else{
        $id_wdoxxth_old = 0;
    }

    if($_GET['id_grlxxmh_customer'] > 0){
        $id_grlxxmh_customer = $_GET['id_grlxxmh_customer'];
    }else{
        $id_grlxxmh_customer = 0;
    }

    // BEGIN query self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_wdoxxth_old > 0){
        $qs_wdoxxth_self = $db
            ->query('select', 'wdoxxth')
            ->get([
                'wdoxxth.id as id',
                'wdoxxth.kode as text'
            ])
            ->where('wdoxxth.id', $id_wdoxxth_old )            
            ->exec();
        $rs_wdoxxth_self = $qs_wdoxxth_self->fetchAll();
    }else{
        $rs_wdoxxth_self = [];
    }
    // END query self

    //sisa dari dispatch yang terhubung dengan Delivery Order ini
    $qs_sisa = $db
        ->raw()
        ->exec('SELECT
                    d.id,
                    d.kode,
                    SUM(a.jumlah_terkecil_os) s_terkecil
                FROM wdplptd a
                LEFT JOIN wdoittd b ON b.id = a.id_wdoittd
                LEFT JOIN iimxxmh c ON c.id = a.id_iimxxmh
                LEFT JOIN wdoxxth d ON d.id = b.id_wdoxxth
                GROUP BY b.id_wdoxxth
                HAVING s_terkecil = 0
        '
        );

    $rs_sisa = $qs_sisa->fetchAll();
    $id_array = [];

    if (!empty($rs_sisa)) {
        //yang item OS = 0 semua, maka tidak perlu dimunculkan headernya
        foreach ($rs_sisa as $row) {
            $id_array[] = $row['id'];
        }

        $id_string = '(' . implode(',', $id_array) . ')';
    } else {
        $id_string = '(-9)';
    }

    // BEGIN query options all except self
    $qs_wdoxxth_all = $db
        ->query('select', 'wdoxxth')
        ->get([
            'wdoxxth.id as id',
            'wdoxxth.kode as text'
        ])
        ->where('wdoxxth.transaction_state',1)
        ->where('wdoxxth.id_grlxxmh_customer', $id_grlxxmh_customer)
        ->where('wdoxxth.id', $id_wdoxxth_old, '<>' )
        ->where('wdoxxth.id', $id_string, 'NOT IN', false )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r->where('wdoxxth.kode', '%' . $q . '%', 'LIKE' );
        } )
        ->order('wdoxxth.kode')
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_wdoxxth_all = $qs_wdoxxth_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_wdoxxth_self) > 0){
        $rs_opt = array_merge($rs_wdoxxth_self, $rs_wdoxxth_all);
    }else{
        $rs_opt = $rs_wdoxxth_all;
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