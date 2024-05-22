<?php 
    /**
     * Digunakan untuk populate options data nevxxth
     * Table terkait    : nevxxth
     * Parameter        : 
     *  - id_nevxxth_old       : data existing (untuk keperluan edit), dipakai di query self
     */
    require_once( "../../../../users/init.php" );
	require_once( "../../../../usersc/lib/DataTables.php" );
	require_once( "../../../../usersc/helpers/datatables_fn_debug.php" );

    // BEGIN definisi variable untuk fn_ajax_results.php
    $data      = array();
    $rs_opt    = array();
    // END definisi variable untuk fn_ajax_results.php

    $qs_nevxxth = $db
        ->query('select', 'nevxxth' )
        ->get([
            'nevxxth.id as id',
            'nevxxth.nama as title',
            'DATE_FORMAT(nevxxth.tanggaljam_awal, "%Y-%m-%dT%T") as start',
            'DATE_FORMAT(nevxxth.tanggaljam_akhir, "%Y-%m-%dT%T") as end'
        ] )
        // ->join('namatable2','namatable2.fieldjoin = nevxxth.id_namatable2','LEFT' )
        // ->where('nevxxth.tanggaljam_awal', $_POST['awal'], ">=" )
        // ->where('nevxxth.tanggaljam_akhir', $_POST['akhir'], "<=" )
        // ->order('nama')
        // ->group_by('nevxxth.fieldgroupby')
        ->exec();

    $rs_nevxxth = $qs_nevxxth->fetchAll();

    $data = array(
        'rs_nevxxth' => $rs_nevxxth
    );
    
    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>