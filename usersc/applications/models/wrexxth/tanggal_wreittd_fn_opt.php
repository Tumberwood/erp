<?php 
    /**
     * Digunakan untuk populate options data Vehicle Type
     * Table terkait    : wreittd
     * Parameter        : 
     *  - tanggal       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['tanggal'] > 0){
        $tanggal = $_GET['tanggal'];
    }else{
        $tanggal = 0;
    }

    // echo $_GET['id_wroxxth'];
    if (isset($_GET['id_wroxxth']) && $_GET['id_wroxxth'] > 0) {
        $id_wroxxth = $_GET['id_wroxxth'];
    } else {
        $id_wroxxth = 0;
    }
    

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($tanggal != ''){
        $qs_wreittd_self = $db
            ->query('select', 'wreittd')  // Assuming 'wreittd' is the table name
            ->get([
                'DATE_FORMAT(wreittd.finish_at, "%d %b %Y") as id',
                'DATE_FORMAT(wreittd.finish_at, "%d %b %Y") as text'
            ])
            ->where('DATE_FORMAT(wreittd.finish_at, "%d %b %Y")', $tanggal )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_wreittd_self = $qs_wreittd_self->fetchAll();
    }else{
        $rs_wreittd_self = [];
    }
    // END query options self

    // BEGIN query options all except self
    $qs_wreittd_all = $db
    ->query('select', 'wreittd')  // Assuming 'wreittd' is the table name
    ->get([
        'DATE_FORMAT(wreittd.finish_at, "%d %b %Y") as id',
        'DATE_FORMAT(wreittd.finish_at, "%d %b %Y") as text'
    ])
    ->where('wreittd.transaction_state', 1)
    ->where('wreittd.is_done_slip', 0)
    ->where('wreittd.id_wroxxth', $id_wroxxth)
    ->where('DATE_FORMAT(wreittd.finish_at, "%d %b %Y")', $tanggal, '<>')  // Correctly applying the operator '<>'
    ->where(function ($r) {
        $q = $_GET['search'];
        $r->where('wreittd.finish_at', '%' . $q . '%', 'LIKE');
    })
    ->distinct('text')
    ->limit($resultCount)
    ->offset($offset)
    ->exec();

$rs_wreittd_all = $qs_wreittd_all->fetchAll();

    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_wreittd_self) > 0){
        $rs_opt = array_merge($rs_wreittd_self, $rs_wreittd_all);
    }else{
        $rs_opt = $rs_wreittd_all;
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