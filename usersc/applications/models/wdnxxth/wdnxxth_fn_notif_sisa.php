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

    $id_wdoxxth = $_POST['id_wdoxxth'];
    $pesan = "";
    $pesan_retur = "";
    
    //cek apakah ada item Do yang belum dibuat picking list
    $qs_wpl = $db
        ->raw()
        ->bind(':id_wdoxxth', $id_wdoxxth)
        ->exec('SELECT
                    a.id_iimxxmh,
                    c.nama iimxxmh_nama,
                    d.kode iumxxmh_kode,
                    a.subtotal_jumlah_unit,
                    b.jumlah_unit,
                    b.jumlah_unit - a.subtotal_jumlah_unit sisa_do
                FROM wplittd a
                LEFT JOIN wplxxth h ON h.id = a.id_wplxxth
                LEFT JOIN wdoittd b ON b.id = a.id_wdoittd 
                LEFT JOIN iimxxmh c ON c.id = a.id_iimxxmh
                LEFT JOIN iumxxmh d ON d.id = a.id_iumxxmh_unit
                WHERE b.id_wdoxxth = :id_wdoxxth AND h.transaction_state <> 9
                HAVING sisa_do > 0
                '
        );
    $rs_wpl = $qs_wpl->fetchAll();

    if (!empty($rs_wpl)) {
        foreach ($rs_wpl as $key => $wpl) {
            $pesan .= 'Terdapat '.$wpl['sisa_do'].  " " .$wpl['iumxxmh_kode'] . ' item DO yang belum ditambahkan'. PHP_EOL;
        }
    }
    
    //cek apakah ada item PL yang belum di picking
    $qs_wpc = $db
        ->raw()
        ->bind(':id_wdoxxth', $id_wdoxxth)
        ->exec('SELECT
                    a.id_wplxxth,
                    a.id_wloxxmh,
                    f.nama wloxxmh_nama,
                    a.id_iimxxmh,
                    c.nama iimxxmh_nama,
                    d.kode iumxxmh_kode,
                    a.wlpxxmh_kode,
                    COUNT(b.id) c_id_pc,
                    a.jumlah_unit AS jumlah_unit_pl,
                    SUM(ifnull(b.jumlah_unit,0)) AS jumlah_unit_pc,
                    a.jumlah_unit - SUM(ifnull(b.jumlah_unit,0)) AS sisa_pl
                FROM wpllptd a
                LEFT JOIN wplittd it ON it.id = a.id_wplittd
                LEFT JOIN wpclptd b ON b.id_wpllptd = a.id
                LEFT JOIN iimxxmh c ON c.id = a.id_iimxxmh
                LEFT JOIN iumxxmh d ON d.id = a.id_iumxxmh_unit
                LEFT JOIN wdoittd e ON e.id = it.id_wdoittd 
                LEFT JOIN wloxxmh f ON f.id = a.id_wloxxmh
                LEFT JOIN wplxxth h ON h.id = a.id_wplxxth
                WHERE e.id_wdoxxth = :id_wdoxxth AND h.transaction_state <> 9
                GROUP BY a.id
                HAVING sisa_pl > 0
        '
        );
    $rs_wpc = $qs_wpc->fetchAll();

    if (!empty($rs_wpc)) {
        foreach ($rs_wpc as $key => $wpc) {
            $pesan .= 'Terdapat '.$wpc['sisa_pl']. " " .$wpc['iumxxmh_kode'].' item Picking List yang belum di Picking'. PHP_EOL;
            $pesan_retur .= $wpc['wlpxxmh_kode']. " - " .$wpc['iimxxmh_nama']. " (" .$wpc['sisa_pl']. " " .$wpc['iumxxmh_kode'] . ")" .PHP_EOL;
        }
    }

    //cek apakah ada item Picking yang belum di Dispatch
    $qs_wdp = $db
        ->raw()
        ->bind(':id_wdoxxth', $id_wdoxxth)
        ->exec('SELECT
                    a.id_wpcxxth,
                    a.id_wloxxmh_tujuan,
                    f.nama wloxxmh_nama,
                    a.id_iimxxmh,
                    c.nama iimxxmh_nama,
                    d.kode iumxxmh_kode,
                    a.wlpxxmh_kode,
                    a.jumlah_unit AS jumlah_unit_pc,
                    sum(ifnull(b.jumlah_unit,0)) AS jumlah_unit_dp,
                    a.jumlah_unit - SUM(ifnull(b.jumlah_unit,0)) AS sisa_pc
                FROM wpclptd a
                LEFT JOIN wdplptd b ON b.id_wpclptd = a.id
                LEFT JOIN iimxxmh c ON c.id = a.id_iimxxmh
                LEFT JOIN iumxxmh d ON d.id = a.id_iumxxmh_unit
                LEFT JOIN wdoittd e ON e.id = a.id_wdoittd
                LEFT JOIN wloxxmh f ON f.id = a.id_wloxxmh_tujuan
                LEFT JOIN wpcxxth h ON h.id = a.id_wpcxxth
                WHERE e.id_wdoxxth = :id_wdoxxth AND h.transaction_state <> 9
                GROUP BY a.id
                HAVING sisa_pc > 0
        '
        );
    $rs_wdp = $qs_wdp->fetchAll();

    if (!empty($rs_wdp)) {
        foreach ($rs_wdp as $key => $wdp) {
            $pesan .= 'Terdapat '.$wdp['sisa_pc']. " " .$wdp['iumxxmh_kode'].' item Picking yang belum di Dispatch'. PHP_EOL;
            $pesan_retur .= $wdp['wlpxxmh_kode']. " - " .$wdp['iimxxmh_nama']. " (" .$wdp['sisa_pc']. " " .$wdp['iumxxmh_kode'] . ")" .PHP_EOL;
        }
    }

    //cek apakah ada item Picking yang belum di Dispatch
    $qs_wdn = $db
        ->raw()
        ->bind(':id_wdoxxth', $id_wdoxxth)
        ->exec('SELECT
                    a.id_wdpxxth,
                    a.id_wloxxmh_tujuan,
                    f.nama wloxxmh_nama,
                    a.id_iimxxmh,
                    c.nama iimxxmh_nama,
                    d.kode iumxxmh_kode,
                    a.wlpxxmh_kode,
                    a.jumlah_unit AS jumlah_unit_dp,
                    SUM(ifnull(b.jumlah_unit,0)) AS jumlah_unit_dn,
                    a.jumlah_unit - SUM(ifnull(b.jumlah_unit,0)) AS sisa_dp
                FROM wdplptd a
                LEFT JOIN wdnlptd b ON b.id_wdplptd = a.id
                LEFT JOIN iimxxmh c ON c.id = a.id_iimxxmh
                LEFT JOIN iumxxmh d ON d.id = a.id_iumxxmh_unit
                LEFT JOIN wdoittd e ON e.id = a.id_wdoittd
                LEFT JOIN wloxxmh f ON f.id = a.id_wloxxmh_tujuan
                LEFT JOIN wdpxxth h ON h.id = a.id_wdpxxth
                WHERE e.id_wdoxxth = :id_wdoxxth AND h.transaction_state <> 9
                GROUP BY a.id
                HAVING sisa_dp > 0
        '
        );
    $rs_wdn = $qs_wdn->fetchAll();

    if (!empty($rs_wdn)) {
        foreach ($rs_wdn as $key => $wdn) {
            $pesan .= 'Terdapat '.$wdn['sisa_dp']. " " .$wdn['iumxxmh_kode'].' item Dispatch yang belum di ada di Draft Delivery Note'. PHP_EOL;
            $pesan_retur .= $wdn['wlpxxmh_kode']. " - " .$wdn['iimxxmh_nama']. " (" .$wdn['sisa_dp']. " " .$wdn['iumxxmh_kode'] . ")". PHP_EOL;
        }
    }

    if ($pesan == "") {
        $pesan = "Anda yakin untuk melakukan confirm data?";
    }

    $data = array(
        'pesan' => $pesan,
        'pesan_retur' => $pesan_retur,
    );

    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>