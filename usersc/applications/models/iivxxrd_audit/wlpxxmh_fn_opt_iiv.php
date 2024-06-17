<?php 
    /**
     * Digunakan untuk populate options data item category
     * Table terkait    : wlpxxmh
     * Parameter        : 
     *  - id_wlpxxmh_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_wlpxxmh_old'] > 0){
        $id_wlpxxmh_old = $_GET['id_wlpxxmh_old'];
    }else{
        $id_wlpxxmh_old = 0;
    }

    // BEGIN query self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_wlpxxmh_old > 0){
        $qs_wlpxxmh_self = $db
            ->query('select', 'wlpxxmh')
            ->get([
                'wlpxxmh.id as id',
                'CONCAT(wlpxxmh.kode) as text'
            ])
            ->where('wlpxxmh.id', $id_wlpxxmh_old )
            ->exec();
        $rs_wlpxxmh_self = $qs_wlpxxmh_self->fetchAll();
    }else{
        $rs_wlpxxmh_self = [];
    }
    // END query self

    $qs_iiv = $db
            ->raw()
            ->exec('SELECT
                        a.wlpxxmh_kode,
                        b.id
                    FROM iivxxrd a
                    LEFT JOIN wlpxxmh b ON b.kode = a.wlpxxmh_kode
                    WHERE a.is_fisik = 1
                    GROUP BY a.wlpxxmh_kode
                    HAVING SUM(a.jumlah_terkecil) > 0
            '
			);
        $rs_iiv = $qs_iiv->fetchAll();

        $ids = array_column($rs_iiv, 'id');
        $id_string = '(' . implode(',', $ids) . ')';
        
        // echo $id_string; // Outputs: (2,3,5)

    // BEGIN query options all except self
    $qs_wlpxxmh_all = $db
        ->query('select', 'wlpxxmh')
        ->get([
            'wlpxxmh.id as id',
            'CONCAT(wlpxxmh.kode) as text'
        ])
        ->where('wlpxxmh.transaction_state',1)
        ->where('wlpxxmh.id', $id_wlpxxmh_old, '<>' )
        ->where('wlpxxmh.id', $id_string, 'IN' ,false)
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('wlpxxmh.kode', '%' . $q . '%', 'LIKE' )
                ;
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_wlpxxmh_all = $qs_wlpxxmh_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_wlpxxmh_self) > 0){
        $rs_opt = array_merge($rs_wlpxxmh_self, $rs_wlpxxmh_all);
    }else{
        $rs_opt = $rs_wlpxxmh_all;
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