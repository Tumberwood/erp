<?php 
    /**
     * Digunakan untuk populate options data si_training_peserta_m
     * Table terkait    : si_training_peserta_m
     * Parameter        : 
     *  - id_si_training_peserta_m_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_si_training_peserta_m_old'] > 0){
        $id_si_training_peserta_m_old = $_GET['id_si_training_peserta_m_old'];
    }else{
        $id_si_training_peserta_m_old = 0;
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_si_training_peserta_m_old > 0){
        $qs_si_training_peserta_m_self = $db
            ->query('select', 'si_training_peserta_m')
            ->get([
                'si_training_peserta_m.id as id',
                'IF(
                    si_training_peserta_m.kode IS NULL, 
                    si_training_peserta_m.nama,
                    IF(
                        si_training_peserta_m.nama IS NULL, 
                        si_training_peserta_m.kode,
                        CONCAT(si_training_peserta_m.kode," - ",si_training_peserta_m.nama)
                    )
                ) as text'
            ])
            ->where('si_training_peserta_m..id', $id_si_training_peserta_m_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_si_training_peserta_m_self = $qs_si_training_peserta_m_self->fetchAll();
    }else{
        $rs_si_training_peserta_m_self = [];
    }
    // END query options self

    // BEGIN query options all except self
    $qs_si_training_peserta_m_all = $db
        ->query('select', 'si_training_peserta_m')
        ->get([
            'si_training_peserta_m.id as id',
            'IF(
                si_training_peserta_m.kode IS NULL, 
                si_training_peserta_m.nama,
                IF(
                    si_training_peserta_m.nama IS NULL, 
                    si_training_peserta_m.kode,
                    CONCAT(si_training_peserta_m.kode," - ",si_training_peserta_m.nama)
                )
            ) as text'
        ])
        ->where('si_training_peserta_m.transaction_state',1)
        ->where('si_training_peserta_m.id', $id_si_training_peserta_m_old, '<>' )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('si_training_peserta_m.kode', '%' . $q . '%', 'LIKE' )
                ->or_where('si_training_peserta_m.nama', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_si_training_peserta_m_all = $qs_si_training_peserta_m_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_si_training_peserta_m_self) > 0){
        $rs_opt = array_merge($rs_si_training_peserta_m_self, $rs_si_training_peserta_m_all);
    }else{
        $rs_opt = $rs_si_training_peserta_m_all;
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