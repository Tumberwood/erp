<?php 
    require_once( "../../../../users/init.php" );
    require_once( "../../../../usersc/lib/DataTables.php" );
    require_once( "../../../../usersc/helpers/datatables_fn_debug.php" );
	require_once( "../../../../usersc/vendor/autoload.php");
	require_once( "../../../helpers/hakakses_s_fn.php" );

	use Carbon\Carbon;

    // BEGIN definisi variable untuk fn_ajax_results.php
    $data      = array();
    $rs_opt    = array();
    // END definisi variable untuk fn_ajax_results.php

    $id_iimxxmh = $_POST['id_iimxxmh'];
    $id_iumxxmh_unit = $_POST['id_iumxxmh_unit'];

    $qs_iimummd = $db
        ->raw()
        ->bind(':id_iimxxmh', $id_iimxxmh)
        ->bind(':id_iumxxmh_unit', $id_iumxxmh_unit)
        ->exec('SELECT
                    a.id_iumxxmh id_uom_replenishment,
                    b.id_iumxxmh id_uom_def,
                    a.jumlah_konversi / b.jumlah_konversi jumlah_default_replenishment,
                    a.jumlah_konversi jumlah_terkecil_replenishment,
                    a.jumlah_konversi / c.jumlah_konversi jumlah_unit_replenishment,
                    d.kode
                FROM iimummd a
                LEFT JOIN iimummd b ON b.id_iimxxmh = a.id_iimxxmh AND b.is_default = 1
                LEFT JOIN iimummd c ON c.id_iimxxmh = a.id_iimxxmh AND c.id_iumxxmh = :id_iumxxmh_unit
                LEFT JOIN iumxxmh d ON d.id = c.id_iumxxmh
                WHERE a.id_iimxxmh = :id_iimxxmh AND a.is_replenishment = 1;
        '
        );

    $rs_iimummd = $qs_iimummd->fetch();

    if (!empty($rs_iimummd)) {
        $jumlah_unit_replenishment = $rs_iimummd['jumlah_unit_replenishment'];
        $id_uom_replenishment = $rs_iimummd['id_uom_replenishment'];
        $kode = $rs_iimummd['kode'];
        $message = "";
    } else {
        $jumlah_unit_replenishment = 0;
        $id_uom_replenishment = 0;
        $kode = '';
        $message = "UoM replenishment belum diset untuk item ini!";
    }

    $data = array(
        'jumlah_unit_replenishment' => $jumlah_unit_replenishment,
        'id_uom_replenishment' => $id_uom_replenishment,
        'kode' => $kode,
        'message' => $message,
    );

    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>