<?php 
    /**
     * Digunakan untuk populate options data provinsi
     * Table terkait    : hovxxmh
     * Parameter        : 
     *  - id_hovxxmh_old       : data existing (untuk keperluan edit), dipakai di query self
     */
    require_once( "../../../../users/init.php" );
	require_once( "../../../../usersc/lib/DataTables.php" );
	require_once( "../../../../usersc/helpers/datatables_fn_debug.php" );
    require_once( "../../../helpers/hakakses_s_fn.php" );

    // BEGIN definisi variable untuk fn_ajax_results.php
    $data      = array();
    $rs_opt    = array();
    // $c_rs_opt  = 0;
    // $morePages = 0;
    // END definisi variable untuk fn_ajax_results.php

    // BEGIN select2 pagination preparation
    $page        = $_GET['page'];
    $resultCount = 10;
    $offset      = ($page - 1) * $resultCount;
    // END select2 pagination preparation

    if($_GET['id_hovxxmh_old'] > 0){
        $id_hovxxmh_old = $_GET['id_hovxxmh_old'];
    }else{
        $id_hovxxmh_old = 0;
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_hovxxmh_old > 0){
        $qs_hovxxmh_self = $db
            ->query('select', 'hovxxmh')
            ->get([
                'hovxxmh.id as id',
                'hovxxmh.nama as text'
            ])
            ->where('hovxxmh.id', $id_hovxxmh_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_hovxxmh_self = $qs_hovxxmh_self->fetchAll();
    }else{
        $rs_hovxxmh_self = [];
    }
    // END query options self

    if($s_id_users > 100){
        if($s_where_data_permission == 0){
            $where_s_str_arr_ha_hovxxmh = ' AND hovxxmh.id IN ('. implode(', ', $s_arr_ha_hovxxmh) .')';
        }else{
            $where_s_str_arr_ha_hovxxmh = ' AND hovxxmh.id = ' . $s_id_hovxxmh;
        }
    }else{
        $where_s_str_arr_ha_hovxxmh = ' AND hovxxmh.id > 0';
    }

    // BEGIN query options all except self
    $qs_hovxxmh_all = $db
        ->raw()
        ->bind(':transaction_state', 1)
        ->bind(':id_hovxxmh_old', $id_hovxxmh_old)
        // ->bind(':s_str_arr_ha_hovxxmh', $s)
        ->bind(':q', '%' . $_GET['search'] . '%')
        ->exec('
            SELECT
                hovxxmh.id as id,
                hovxxmh.nama as text
            FROM hovxxmh
            WHERE 1
                AND hovxxmh.transaction_state = :transaction_state
                AND hovxxmh.id <> :id_hovxxmh_old'
                . $where_s_str_arr_ha_hovxxmh . '
                AND hovxxmh.nama LIKE :q
            LIMIT ' . $resultCount . '
            OFFSET ' . $offset
        );

    $rs_hovxxmh_all = $qs_hovxxmh_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_hovxxmh_self) > 0){
        $rs_opt = array_merge($rs_hovxxmh_self, $rs_hovxxmh_all);
    }else{
        $rs_opt = $rs_hovxxmh_all;
    }
    // $c_rs_opt = count($rs_opt);
    // END menggabungkan options

    // BEGIN finalisasi paginasi select2
    // $endCount  = $offset + $resultCount;
    // $morePages = $endCount >= $c_rs_opt;
    // END finalisasi paginasi select2
    
    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>