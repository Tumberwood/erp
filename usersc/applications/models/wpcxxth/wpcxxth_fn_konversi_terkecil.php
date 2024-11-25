<?php 
    require_once( "../../../../users/init.php" );
    require_once( "../../../../usersc/lib/DataTables.php" );
    // require_once( "../../../../usersc/helpers/datatables_fn_debug.php" );
	require_once( "../../../../usersc/vendor/autoload.php");
	require_once( "../../../helpers/hakakses_s_fn.php" );

	use Carbon\Carbon;

    // BEGIN definisi variable untuk fn_ajax_results.php
    $data      = array();
    $rs_opt    = array();
    // END definisi variable untuk fn_ajax_results.php

    // ambil variable dari ajax data
    $qs_os_self = $db
        ->raw()
        ->exec('SELECT
                    a.id id_before,
                    c.id id_now,
                    c.id_iumxxmh_unit,
                    a.jumlah_unit unit_before,
                    c.jumlah_unit unit_now,
                    e.id_iumxxmh id_iumxxmh_terkecil,
                    f.id_iumxxmh id_iumxxmh_default,
                    ROUND(if(e.id_iumxxmh = c.id_iumxxmh_unit, c.jumlah_unit, c.jumlah_unit * d.jumlah_konversi)) AS jumlah_terkecil,
                    if(e.id_iumxxmh = c.id_iumxxmh_unit, c.jumlah_unit, c.jumlah_unit * d.jumlah_konversi)
                    / (f.jumlah_konversi) AS jumlah_default,
	                f.jumlah_konversi
                FROM '.$nama_table.' c -- now
                LEFT JOIN '.$nama_table_before.' a ON a.id = c.id_'.$nama_table_before.' -- before
                LEFT JOIN iimummd d ON d.id_iimxxmh = a.id_iimxxmh AND d.id_iumxxmh = c.id_iumxxmh_unit -- UoM unit
                LEFT JOIN iimummd e ON e.id_iimxxmh = a.id_iimxxmh AND e.is_terkecil = 1 -- UoM terkecil
                LEFT JOIN iimummd f ON f.id_iimxxmh = a.id_iimxxmh AND f.is_default = 1 -- UoM Default
                WHERE c.id = '.$id.'
                GROUP BY c.id
        '
        );

    $rs_os_self = $qs_os_self->fetch();
    $id_before = $rs_os_self['id_before'];

    // echo $rs_os_self['unit_now'];
    $qu_os_self = $db
        ->query('update', $nama_table)
        ->set('id_iumxxmh_terkecil',$rs_os_self['id_iumxxmh_terkecil'])
        ->set('id_iumxxmh_default',$rs_os_self['id_iumxxmh_default'])
        ->set('jumlah_konversi',$rs_os_self['jumlah_konversi'])
        ->set('jumlah_terkecil',$rs_os_self['jumlah_terkecil'])
        ->set('jumlah_terkecil_os',$rs_os_self['jumlah_terkecil'])
        ->set('jumlah_default',$rs_os_self['jumlah_default'])
        // ->set('jumlah_default_os',$rs_os_self['jumlah_default'])
        ->where('id',$id)
        ->exec();

    //update os table before
    $qs_table_before = $db
        ->raw()
        ->exec('SELECT
                    c.id,
                    c.id_iumxxmh_unit unit_after,
                    a.jumlah_unit unit_before,
                    sum(c.jumlah_unit) unit_after,
                    d.jumlah_konversi,
                    SUM(if(e.id_iumxxmh = c.id_iumxxmh_unit, c.jumlah_unit, c.jumlah_terkecil)) AS terkecil,
                    a.jumlah_terkecil,
                    (a.jumlah_terkecil) - SUM(if(e.id_iumxxmh = c.id_iumxxmh_unit, c.jumlah_unit, c.jumlah_terkecil)) AS jumlah_terkecil_os,
                    SUM(if(e.id_iumxxmh = c.id_iumxxmh_unit, c.jumlah_unit, c.jumlah_terkecil)) AS jumlah_terkecil_next,
                    ((a.jumlah_terkecil) - SUM(if(e.id_iumxxmh = c.id_iumxxmh_unit, c.jumlah_unit, c.jumlah_terkecil))) / d.jumlah_konversi AS sisa_unit,
                    SUM(if(e.id_iumxxmh = c.id_iumxxmh_unit, c.jumlah_unit, c.jumlah_terkecil))
                    / (f.jumlah_konversi) AS jumlah_default,
                    SUM(if(e.id_iumxxmh = c.id_iumxxmh_unit, c.jumlah_unit, c.jumlah_terkecil))
                    / (d.jumlah_konversi) AS jumlah_unit_next,
                    f.jumlah_konversi
                FROM '.$nama_table.' c -- now
                LEFT JOIN '.$nama_table_before.' a ON a.id = c.id_'.$nama_table_before.' -- before
                LEFT JOIN iimummd d ON d.id_iimxxmh = a.id_iimxxmh AND d.id_iumxxmh = a.id_iumxxmh_unit -- UoM unit
                LEFT JOIN iimummd e ON e.id_iimxxmh = a.id_iimxxmh AND e.is_terkecil = 1 -- UoM terkecil
                LEFT JOIN iimummd f ON f.id_iimxxmh = a.id_iimxxmh AND f.is_default = 1 -- UoM Default
                WHERE a.id = '.$id_before.'
                GROUP BY a.id
        '
        );

    $rs_table_before = $qs_table_before->fetch();

    $qu_table_before = $db
        ->query('update', $nama_table_before)
        ->set('jumlah_terkecil_next', $rs_table_before['jumlah_terkecil_next'])
        ->set('jumlah_terkecil_os', $rs_table_before['jumlah_terkecil_os'])
        ->where('id', $id_lpn )
    ->exec();

?>