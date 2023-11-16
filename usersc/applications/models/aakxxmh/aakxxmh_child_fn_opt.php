<?php 
    /**
     * Digunakan untuk populate options data branch / cabang
     * Table terkait    : aakxxmh
     * Parameter        : 
     *  - id_aakxxmh_old     : data existing (untuk keperluan edit), dipakai di query self
     *  - id_aatxxmh_x       : id_aakxxmh yang di exclude (untuk where NOT IN)
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

    if($_GET['id_aakxxmh_old'] > 0){
        $id_aakxxmh_old = $_GET['id_aakxxmh_old'];
    }else{
        $id_aakxxmh_old = 0;
    }

    $id_aatxxmh_x = $_GET['id_aatxxmh_x'];

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_aakxxmh_old > 0){
        $qs_aakxxmh_self = $db
            ->query('select', 'aakxxmh')
            ->get([
                'aakxxmh.id as id',
                'IF(
                    aakxxmh.kode IS NULL, 
                    aakxxmh.nama,
                    IF(
                        aakxxmh.nama IS NULL, 
                        aakxxmh.kode,
                        CONCAT(aakxxmh.kode," - ",aakxxmh.nama)
                    )
                ) as text'
            ])
            ->where('aakxxmh.id', $id_aakxxmh_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_aakxxmh_self = $qs_aakxxmh_self->fetchAll();
    }else{
        $rs_aakxxmh_self = [];
    }
    // END query options self

    // BEGIN query options all except self
    $sql = '
   
    ';
    $qs_aakxxmh_all = $db
        ->raw()
        ->bind(':resultCount', $resultCount, PDO::PARAM_INT)
        ->bind(':offset', $offset, PDO::PARAM_INT)
        ->bind(':transaction_state', 1)
        ->bind(':id_aatxxmh_x', $id_aatxxmh_x)
        ->bind(':is_parent', 0)
        ->bind(':id_aakxxmh_old', $id_aakxxmh_old)
        ->bind(':q',  '%' . $id_aakxxmh_old . '%')
        ->exec('
            SELECT
                aakxxmh.id as id,
                IF(
                    aakxxmh.kode IS NULL, 
                    aakxxmh.nama,
                    IF(
                        aakxxmh.nama IS NULL, 
                        aakxxmh.kode,
                        CONCAT(aakxxmh.kode," - ",aakxxmh.nama)
                    )
                ) as text
            FROM aakxxmh
            WHERE 
                aakxxmh.transaction_state = :transaction_state AND 
                aakxxmh.is_parent = :is_parent AND
                aakxxmh.id_aatxxmh NOT IN ( :id_aatxxmh_x ) AND
                aakxxmh.id <> :id_aakxxmh_old AND
                (
                    aakxxmh.kode LIKE :q OR
                    aakxxmh.nama LIKE :q 
                )
            LIMIT :resultCount
            OFFSET :offset
        ');
    echo $sql;

    $rs_aakxxmh_all = $qs_aakxxmh_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_aakxxmh_self) > 0){
        $rs_opt = array_merge($rs_aakxxmh_self, $rs_aakxxmh_all);
    }else{
        $rs_opt = $rs_aakxxmh_all;
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