<?php 
    /**
     * Digunakan untuk populate options data provinsi
     * Table terkait    : hodxxmh
     * Parameter        : 
     *  - id_hodxxmh_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_hodxxmh_old'] > 0){
        $id_hodxxmh_old = $_GET['id_hodxxmh_old'];
    }else{
        $id_hodxxmh_old = 0;
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_hodxxmh_old > 0){
        $qs_hodxxmh_self = $db
            ->query('select', 'hodxxmh')
            ->get([
                'hodxxmh.id as id',
                'hodxxmh.nama as text'
            ])
            ->where('hodxxmh.id', $id_hodxxmh_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_hodxxmh_self = $qs_hodxxmh_self->fetchAll();
    }else{
        $rs_hodxxmh_self = [];
    }
    // END query options self

    if($s_id_users > 100){
        if($s_where_data_permission == 0){
            $where_s_str_arr_ha_hodxxmh = ' AND hodxxmh.id IN ('. implode(', ', $s_arr_ha_hodxxmh) .')';
        }else{
            $where_s_str_arr_ha_hodxxmh = ' AND hodxxmh.id = ' . $s_id_hodxxmh;
        }
    }else{
        $where_s_str_arr_ha_hodxxmh = ' AND hodxxmh.id > 0';
    }

    // BEGIN query options all except self
    $qs_hodxxmh_all = $db
        ->raw()
        ->bind(':transaction_state', 1)
        ->bind(':id_hodxxmh_old', $id_hodxxmh_old)
        // ->bind(':s_str_arr_ha_hodxxmh', $s)
        ->bind(':q', '%' . $_GET['search'] . '%')
        ->exec('
            SELECT
                hodxxmh.id as id,
                hodxxmh.nama as text
            FROM hodxxmh
            WHERE 1
                AND hodxxmh.transaction_state = :transaction_state
                AND hodxxmh.id <> :id_hodxxmh_old'
                . $where_s_str_arr_ha_hodxxmh . '
                AND hodxxmh.nama LIKE :q
            LIMIT ' . $resultCount . '
            OFFSET ' . $offset
        );

    $rs_hodxxmh_all = $qs_hodxxmh_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_hodxxmh_self) > 0){
        $rs_opt = array_merge($rs_hodxxmh_self, $rs_hodxxmh_all);
    }else{
        $rs_opt = $rs_hodxxmh_all;
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