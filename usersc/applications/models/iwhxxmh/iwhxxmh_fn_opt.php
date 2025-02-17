<?php 
    /**
     * Digunakan untuk populate options data branch / cabang
     * Table terkait    : iwhxxmh
     * Parameter        : 
     *  - id_iwhxxmh_old       : data existing (untuk keperluan edit), dipakai di query self
     */
    require_once( "../../../../users/init.php" );
	require_once( "../../../../usersc/lib/DataTables.php" );
	require_once( "../../../../usersc/helpers/datatables_fn_debug.php" );
	include_once( "../../../helpers/hakakses_s_fn.php" );

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

    if($_GET['id_iwhxxmh_old'] > 0){
        $id_iwhxxmh_old = $_GET['id_iwhxxmh_old'];
    }else{
        $id_iwhxxmh_old = 0;
    }

    if(isset($_GET['ids_iwhctmh']) && $_GET['ids_iwhctmh'] != ''){
        $ids_iwhctmh = '('.$_GET['ids_iwhctmh'].')';
        $where_iwhctmh = 'IN';
    } else {
        $where_iwhctmh = 'NOT IN';
        $ids_iwhctmh = '(-9)';
    }

    if ($s_id_users > 100) {
        $ids_iwh = '('.$s_str_arr_ha_iwhxxmh.')';
        $where_hk = 'IN';
    } else {
        $where_hk = 'NOT IN';
        $ids_iwh = '('.$s_str_arr_ha_iwhxxmh.')';
    }

    // echo $ids_iwh;

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_iwhxxmh_old > 0){
        $qs_iwhxxmh_self = $db
            ->query('select', 'iwhxxmh')
            ->get([
                'iwhxxmh.id as id',
                'IF(
                    iwhxxmh.kode IS NULL, 
                    iwhxxmh.nama,
                    IF(
                        iwhxxmh.nama IS NULL, 
                        iwhxxmh.kode,
                        CONCAT(iwhxxmh.kode," - ",iwhxxmh.nama)
                    )
                ) as text'
            ])
            ->where('iwhxxmh.id', $id_iwhxxmh_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_iwhxxmh_self = $qs_iwhxxmh_self->fetchAll();
    }else{
        $rs_iwhxxmh_self = [];
    }
    // END query options self

    // BEGIN query options all except self
    $qs_iwhxxmh_all = $db
        ->query('select', 'iwhxxmh')
        ->get([
            'iwhxxmh.id as id',
            'IF(
                iwhxxmh.kode IS NULL, 
                iwhxxmh.nama,
                IF(
                    iwhxxmh.nama IS NULL, 
                    iwhxxmh.kode,
                    CONCAT(iwhxxmh.kode," - ",iwhxxmh.nama)
                )
            ) as text'
        ])
        ->where('iwhxxmh.transaction_state',1)
        ->where('iwhxxmh.id_iwhctmh',3,'<>')
        ->where('iwhxxmh.id', $id_iwhxxmh_old, '<>' )
        ->where('iwhxxmh.id', $ids_iwh, $where_hk, false )
        ->where('iwhxxmh.id_iwhctmh', $ids_iwhctmh, $where_iwhctmh, false )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('iwhxxmh.kode', '%' . $q . '%', 'LIKE' )
                ->or_where('iwhxxmh.nama', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_iwhxxmh_all = $qs_iwhxxmh_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_iwhxxmh_self) > 0){
        $rs_opt = array_merge($rs_iwhxxmh_self, $rs_iwhxxmh_all);
    }else{
        $rs_opt = $rs_iwhxxmh_all;
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