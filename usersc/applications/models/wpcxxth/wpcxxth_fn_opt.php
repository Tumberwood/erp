<?php 
    /**
     * Digunakan untuk populate options data item category
     * Table terkait    : wpcxxth
     * Parameter        : 
     *  - id_wpcxxth_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_wpcxxth_old'] > 0){
        $id_wpcxxth_old = $_GET['id_wpcxxth_old'];
    }else{
        $id_wpcxxth_old = 0;
    }

    // BEGIN query self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_wpcxxth_old > 0){
        $qs_wpcxxth_self = $db
            ->query('select', 'wpcxxth')
            ->get([
                'wpcxxth.id as id',
                'IF(
                wpcxxth.kode IS NULL, 
                grlxxmh.nama,
                IF(
                    grlxxmh.nama IS NULL, 
                    wpcxxth.kode,
                    CONCAT(grlxxmh.nama," - ",wpcxxth.kode)
                    
                )
            ) as text'
            ])
            ->join('grlxxmh','grlxxmh.id = wpcxxth.id_grlxxmh_customer','LEFT' )
            ->where('wpcxxth.id', $id_wpcxxth_old )
            ->exec();
        $rs_wpcxxth_self = $qs_wpcxxth_self->fetchAll();
    }else{
        $rs_wpcxxth_self = [];
    }
    // END query self

    // Ini untuk data lama yang sebelum update transaction_state = 8
    //data sebelum revisi tanggal 04/07/2024 (revisi jika detail sudah full semua) maka dibuat complete
    $qs_sisa = $db
        ->raw()
        ->exec('SELECT
                    a.id_wpcxxth as id,
                    SUM(a.jumlah_terkecil_os) AS os
                FROM wpllptd a
                GROUP BY a.id_wpcxxth
                HAVING os = 0
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
    $qs_wpcxxth_all = $db
        ->query('select', 'wpcxxth')
        ->get([
            'wpcxxth.id as id',
            'IF(
                wpcxxth.kode IS NULL, 
                grlxxmh.nama,
                IF(
                    grlxxmh.nama IS NULL, 
                    wpcxxth.kode,
                    CONCAT(grlxxmh.nama," - ",wpcxxth.kode)
                )
            ) as text'
        ])
        ->join('grlxxmh','grlxxmh.id = wpcxxth.id_grlxxmh_customer','LEFT' )
        // ->where('wpcxxth.transaction_state',1)
        ->where('wpcxxth.id', $id_wpcxxth_old, '<>' )
        ->where('wpcxxth.is_in_use', 0 )
        ->where('wpcxxth.id_wpcxxth', 0 )
        ->where('wpcxxth.transaction_state', 8, '<>' )
        ->where('wpcxxth.id', $id_string, 'NOT IN', false )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('wpcxxth.kode', '%' . $q . '%', 'LIKE' )
                ;
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_wpcxxth_all = $qs_wpcxxth_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_wpcxxth_self) > 0){
        $rs_opt = array_merge($rs_wpcxxth_self, $rs_wpcxxth_all);
    }else{
        $rs_opt = $rs_wpcxxth_all;
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