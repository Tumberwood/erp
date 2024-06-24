<?php 
    /**
     * Digunakan untuk populate options data Vehicle Type
     * Table terkait    : wroxxth
     * Parameter        : 
     *  - id_wroxxth_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_wroxxth_old'] > 0){
        $id_wroxxth_old = $_GET['id_wroxxth_old'];
    }else{
        $id_wroxxth_old = 0;
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_wroxxth_old > 0){
        $qs_wroxxth_self = $db
            ->query('select', 'wroxxth')
            ->get([
                'wroxxth.id as id',
                'IF(
                    wroxxth.kode IS NULL, 
                    grlxxmh.nama,
                    IF(
                        grlxxmh.nama IS NULL, 
                        wroxxth.kode,
                        CONCAT(wroxxth.kode," - ",grlxxmh.nama)
                    )
                ) as text'
            ])
            ->join('grlxxmh','grlxxmh.id = wroxxth.id_grlxxmh_supplier','LEFT' )
            ->where('wroxxth.id', $id_wroxxth_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_wroxxth_self = $qs_wroxxth_self->fetchAll();
    }else{
        $rs_wroxxth_self = [];
    }
    // END query options self

    $qs_os_nol = $db
        ->raw()
        ->exec('SELECT
                    a.id,
                    SUM(b.jumlah_terkecil_os) AS os
                FROM wroxxth a
                LEFT JOIN wroittd b ON b.id_wroxxth = a.id
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

    // echo $id_string;
    
    // BEGIN query options all except self
    $qs_wroxxth_all = $db
        ->query('select', 'wroxxth')
        ->get([
            'wroxxth.id as id',
            'IF(
                wroxxth.kode IS NULL, 
                grlxxmh.nama,
                IF(
                    grlxxmh.nama IS NULL, 
                    wroxxth.kode,
                    CONCAT(wroxxth.kode," - ",grlxxmh.nama)
                )
            ) as text'
        ])
        ->join('grlxxmh','grlxxmh.id = wroxxth.id_grlxxmh_supplier','LEFT' )
        ->where('wroxxth.transaction_state',1)
        ->where('wroxxth.id', $id_string, 'NOT IN', false )
        ->where('wroxxth.id', $id_wroxxth_old, '<>' )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('wroxxth.kode', '%' . $q . '%', 'LIKE' )
                ->or_where('wroxxth.nama', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_wroxxth_all = $qs_wroxxth_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_wroxxth_self) > 0){
        $rs_opt = array_merge($rs_wroxxth_self, $rs_wroxxth_all);
    }else{
        $rs_opt = $rs_wroxxth_all;
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