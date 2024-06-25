<?php 
    /**
     * Digunakan untuk populate options data Vehicle Type
     * Table terkait    : wdoxxth
     * Parameter        : 
     *  - id_wdoxxth_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_wdoxxth_old'] > 0){
        $id_wdoxxth_old = $_GET['id_wdoxxth_old'];
    }else{
        $id_wdoxxth_old = 0;
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_wdoxxth_old > 0){
        $qs_wdoxxth_self = $db
            ->query('select', 'wdoxxth')
            ->get([
                'wdoxxth.id as id',
                'IF(
                    wdoxxth.kode IS NULL, 
                    grlxxmh.nama,
                    IF(
                        grlxxmh.nama IS NULL, 
                        wdoxxth.kode,
                        CONCAT(wdoxxth.kode," - ",grlxxmh.nama)
                    )
                ) as text'
            ])
            ->join('grlxxmh','grlxxmh.id = wdoxxth.id_grlxxmh_customer','LEFT' )
            ->where('wdoxxth.id', $id_wdoxxth_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_wdoxxth_self = $qs_wdoxxth_self->fetchAll();
    }else{
        $rs_wdoxxth_self = [];
    }
    // END query options self

    $qs_os_nol = $db
        ->raw()
        ->exec('SELECT
                    a.id,
                    SUM(b.jumlah_terkecil_os) AS os
                FROM wdoxxth a
                LEFT JOIN wdoittd b ON b.id_wdoxxth = a.id
                WHERE a.transaction_state = 1 AND b.transaction_state <> -9
                GROUP BY a.id
                HAVING os = 0
        '
        );

    $rs_os_nol = $qs_os_nol->fetchAll();
    $id_array = [];

    if (!empty($rs_os_nol)) {
        //yang item OS = 0 semua, maka tidak perlu dimunculkan headernya
        foreach ($rs_os_nol as $row) {
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
            'IF(
                wdoxxth.kode IS NULL, 
                grlxxmh.nama,
                IF(
                    grlxxmh.nama IS NULL, 
                    wdoxxth.kode,
                    CONCAT(wdoxxth.kode," - ",grlxxmh.nama)
                )
            ) as text'
        ])
        ->join('grlxxmh','grlxxmh.id = wdoxxth.id_grlxxmh_customer','LEFT' )
        ->where('wdoxxth.transaction_state',1)
        ->where('wdoxxth.id', $id_string, 'NOT IN', false )
        ->where('wdoxxth.id', $id_wdoxxth_old, '<>' )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('wdoxxth.kode', '%' . $q . '%', 'LIKE' )
                ->or_where('wdoxxth.nama', '%' . $q . '%', 'LIKE' );
        } )
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

    // BEGIN finalisasi paginasi select2
    $endCount  = $offset + $resultCount;
    $morePages = $endCount > $c_rs_opt;
    // END finalisasi paginasi select2
    
    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>