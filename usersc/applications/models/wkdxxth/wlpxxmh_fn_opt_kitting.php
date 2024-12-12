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
        ->raw()
        ->bind(':id_wlpxxmh_old', $id_wlpxxmh_old)
        ->limit($resultCount)
        ->offset($offset)
        ->exec('SELECT
                    lpn.id,
                    concat(a.wlpxxmh_kode, " - ", a.iimxxmh_nama) text,
                    item.id_iicxxmh,
                    a.id_wloctmh,
                    a.iwhxxmh_kode,
                    a.wloxxmh_nama,
                    a.iimxxmh_kode,
                    a.iimxxmh_nama,
                    a.iumxxmh_default_kode,
                    a.iumxxmh_terkecil_kode,
                    SUM(jumlah_default * is_fisik) as jumlah_default,
                    SUM(jumlah_terkecil * is_fisik) as jumlah_terkecil,
                    ifnull(jumlah_default_booking,0) as jumlah_default_booking,
                    ifnull(jumlah_terkecil_booking,0) as jumlah_terkecil_booking,
                    (SUM(jumlah_default * is_fisik)) - ifnull(jumlah_default_booking,0) as jumlah_default_ava,
                    (SUM(jumlah_terkecil * is_fisik)) - ifnull(jumlah_terkecil_booking,0) as jumlah_terkecil_ava,
                    a.wlpxxmh_kode,
                    max(batch_number) batch_number,
                    max(date_format(expired_date,"%d %b %Y")) as expired_date
                FROM iivxxrd a
                LEFT JOIN iimxxmh item ON item.id = a.id_iimxxmh
                LEFT JOIN wlpxxmh lpn ON lpn.kode = a.wlpxxmh_kode
                LEFT JOIN (
                    SELECT
                        wloxxmh_nama,
                        iimxxmh_kode,
                        SUM(jumlah_default) * -1 as jumlah_default_booking,
                        SUM(jumlah_terkecil) * -1 as jumlah_terkecil_booking,
                        wlpxxmh_kode
                    FROM iivxxrd
                    WHERE tanggal <= curdate() AND is_fisik = 0
                    GROUP BY 
                        -- id_gbrxxmh, 
                        id_iwhxxmh,
                        id_iimxxmh,
                        id_wloxxmh,
                        wlpxxmh_kode
                ) AS b ON b.wloxxmh_nama = a.wloxxmh_nama AND b.iimxxmh_kode = a.iimxxmh_kode AND b.wlpxxmh_kode = a.wlpxxmh_kode
                WHERE tanggal <= curdate()
                GROUP BY 
                    -- id_gbrxxmh, 
                    id_iwhxxmh,
                    id_iimxxmh,
                    id_wloxxmh,
                    wlpxxmh_kode
                having jumlah_terkecil_ava > 0 
                AND id_wloctmh = 4
                AND id_iicxxmh = 4
                AND id = :id_wlpxxmh_old
        ')
        ;
        $rs_wlpxxmh_self = $qs_wlpxxmh_self->fetchAll();
    }else{
        $rs_wlpxxmh_self = [];
    }
    // END query self

    // BEGIN query options all except self
    $qs_wlpxxmh_all = $db
        ->raw()
        ->bind(':id_wlpxxmh_old', $id_wlpxxmh_old)
        ->limit($resultCount)
        ->offset($offset)
        ->exec('SELECT
                    lpn.id,
                    concat(a.wlpxxmh_kode, " - ", a.iimxxmh_nama) text,
                    item.id_iicxxmh,
                    a.id_wloctmh,
                    a.iwhxxmh_kode,
                    a.wloxxmh_nama,
                    a.iimxxmh_kode,
                    a.iimxxmh_nama,
                    a.iumxxmh_default_kode,
                    a.iumxxmh_terkecil_kode,
                    SUM(jumlah_default * is_fisik) as jumlah_default,
                    SUM(jumlah_terkecil * is_fisik) as jumlah_terkecil,
                    ifnull(jumlah_default_booking,0) as jumlah_default_booking,
                    ifnull(jumlah_terkecil_booking,0) as jumlah_terkecil_booking,
                    (SUM(jumlah_default * is_fisik)) - ifnull(jumlah_default_booking,0) as jumlah_default_ava,
                    (SUM(jumlah_terkecil * is_fisik)) - ifnull(jumlah_terkecil_booking,0) as jumlah_terkecil_ava,
                    a.wlpxxmh_kode,
                    max(batch_number) batch_number,
                    max(date_format(expired_date,"%d %b %Y")) as expired_date
                FROM iivxxrd a
                LEFT JOIN iimxxmh item ON item.id = a.id_iimxxmh
                LEFT JOIN wlpxxmh lpn ON lpn.kode = a.wlpxxmh_kode
                LEFT JOIN (
                    SELECT
                        wloxxmh_nama,
                        iimxxmh_kode,
                        SUM(jumlah_default) * -1 as jumlah_default_booking,
                        SUM(jumlah_terkecil) * -1 as jumlah_terkecil_booking,
                        wlpxxmh_kode
                    FROM iivxxrd
                    WHERE tanggal <= curdate() AND is_fisik = 0
                    GROUP BY 
                        -- id_gbrxxmh, 
                        id_iwhxxmh,
                        id_iimxxmh,
                        id_wloxxmh,
                        wlpxxmh_kode
                ) AS b ON b.wloxxmh_nama = a.wloxxmh_nama AND b.iimxxmh_kode = a.iimxxmh_kode AND b.wlpxxmh_kode = a.wlpxxmh_kode
                WHERE tanggal <= curdate()
                GROUP BY 
                    -- id_gbrxxmh, 
                    id_iwhxxmh,
                    id_iimxxmh,
                    id_wloxxmh,
                    wlpxxmh_kode
                having jumlah_terkecil_ava > 0 
                AND id_wloctmh = 4
                AND id_iicxxmh = 4
                AND id <> :id_wlpxxmh_old
                AND wlpxxmh_kode LIKE "%'.$_GET['search'].'%"
        ')
        ;
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