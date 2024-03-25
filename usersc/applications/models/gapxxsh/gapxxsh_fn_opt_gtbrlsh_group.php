<?php 
    /**
     * Digunakan untuk populate options data branch / cabang
     * Table terkait    : gtbrlsh
     * Parameter        : 
     *  - id_gtbrlsh_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_gtbrlsh_group'] > 0){
        $id_gtbrlsh_group = $_GET['id_gtbrlsh_group'];
    }else{
        $id_gtbrlsh_group = 0;
    }

    if($_GET['id_tbl_group_old'] > 0){
        $id_tbl_group_old = $_GET['id_tbl_group_old'];
    }else{
        $id_tbl_group_old = 0;
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_tbl_group_old > 0){
        $qs_tbl_self = $db
            ->query('select', 'gtbrlsh')
            ->get([
                'gtbrlsh.id as id',
                'IF(
                    gtbrlsh.kode IS NULL, 
                    gtbrlsh.nama,
                    IF(
                        gtbrlsh.nama IS NULL, 
                        gtbrlsh.kode,
                        CONCAT(gtbrlsh.kode," - ",gtbrlsh.nama)
                    )
                ) as text'
            ])
            ->where('gtbrlsh.id', $id_tbl_group_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_tbl_self = $qs_tbl_self->fetchAll();
    }else{
        $rs_tbl_self = [];
    }
    // END query options self

    // BEGIN select gtbrlsh
    $qs_gtbrlsh = $db
        ->raw()
        ->bind(':id_gtbrlsh_group', $id_gtbrlsh_group)
        ->exec('
            SELECT
                tblheader
            FROM gtbrlsh
            WHERE 1
                AND id = :id_gtbrlsh_group
        ');
    $rs_gtbrlsh = $qs_gtbrlsh->fetch();
    $tbl_name = $rs_gtbrlsh['tblheader'] ;

    // END select gtbrlsh

    // BEGIN query options all except self
    $qs_tbl_all = $db
        ->raw()
        ->bind(':transaction_state', 1)
        ->bind(':id_tbl_group_old', 1)
        ->bind(':q', '%'.$_GET['search'] . '%')
        ->exec('
            SELECT
                id as id,
                IF(
                    kode IS NULL, 
                    nama,
                    IF(
                        nama IS NULL, 
                        kode,
                        CONCAT(kode," - ",nama)
                    )
                ) as text
            FROM ' . $tbl_name . '
            WHERE 1
                AND transaction_state = :transaction_state
                AND id <> :id_tbl_group_old
                AND (
                    kode LIKE :q OR
                    nama LIKE :q
                )
            LIMIT ' . $resultCount . '
            OFFSET ' .$offset
        );
    $rs_tbl_all = $qs_tbl_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_tbl_self) > 0){
        $rs_opt = array_merge($rs_tbl_self, $rs_tbl_all);
    }else{
        $rs_opt = $rs_tbl_all;
    }
    $c_rs_opt = count($rs_opt);    
    // END menggabungkan options

    // BEGIN finalisasi paginasi select2
    // $endCount  = $offset + $resultCount;
    // $morePages = $endCount > $c_rs_opt;
    // END finalisasi paginasi select2

    $data = array(
        'id_gtbrlsh_group' => $id_gtbrlsh_group
    );
    
    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>