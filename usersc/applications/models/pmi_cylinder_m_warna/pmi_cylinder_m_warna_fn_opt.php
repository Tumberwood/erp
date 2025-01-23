<?php 
    /**
     * Digunakan untuk populate options data pmi_cylinder_m_warna
     * Table terkait    : pmi_cylinder_m_warna
     * Parameter        : 
     *  - id_pmi_cylinder_m_warna_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_pmi_cylinder_m_warna_old'] > 0){
        $id_pmi_cylinder_m_warna_old = $_GET['id_pmi_cylinder_m_warna_old'];
    }else{
        $id_pmi_cylinder_m_warna_old = 0;
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_pmi_cylinder_m_warna_old > 0){
        $qs_pmi_cylinder_m_warna_self = $db
            ->query('select', 'pmi_cylinder_m_warna')
            ->get([
                'pmi_cylinder_m_warna.id as id',
                'IF(
                    pmi_cylinder_m_warna.kode IS NULL, 
                    pmi_cylinder_m_warna.nama,
                    IF(
                        pmi_cylinder_m_warna.nama IS NULL, 
                        pmi_cylinder_m_warna.kode,
                        CONCAT(pmi_cylinder_m_warna.kode," - ",pmi_cylinder_m_warna.nama)
                    )
                ) as text'
            ])
            ->where('pmi_cylinder_m_warna..id', $id_pmi_cylinder_m_warna_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_pmi_cylinder_m_warna_self = $qs_pmi_cylinder_m_warna_self->fetchAll();
    }else{
        $rs_pmi_cylinder_m_warna_self = [];
    }
    // END query options self

    // BEGIN query options all except self
    $qs_pmi_cylinder_m_warna_all = $db
        ->query('select', 'pmi_cylinder_m_warna')
        ->get([
            'pmi_cylinder_m_warna.id as id',
            'IF(
                pmi_cylinder_m_warna.kode IS NULL, 
                pmi_cylinder_m_warna.nama,
                IF(
                    pmi_cylinder_m_warna.nama IS NULL, 
                    pmi_cylinder_m_warna.kode,
                    CONCAT(pmi_cylinder_m_warna.kode," - ",pmi_cylinder_m_warna.nama)
                )
            ) as text'
        ])
        ->where('pmi_cylinder_m_warna.transaction_state',1)
        ->where('pmi_cylinder_m_warna.id', $id_pmi_cylinder_m_warna_old, '<>' )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('pmi_cylinder_m_warna.kode', '%' . $q . '%', 'LIKE' )
                ->or_where('pmi_cylinder_m_warna.nama', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_pmi_cylinder_m_warna_all = $qs_pmi_cylinder_m_warna_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_pmi_cylinder_m_warna_self) > 0){
        $rs_opt = array_merge($rs_pmi_cylinder_m_warna_self, $rs_pmi_cylinder_m_warna_all);
    }else{
        $rs_opt = $rs_pmi_cylinder_m_warna_all;
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