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
    $id_iwhxxmh = $_POST['id_iwhxxmh'];
    $table_before = $_POST['table_before'];
    $id_transaksi_before = $_POST['id_transaksi_before'];
    $jumlah_unit = $_POST['jumlah_unit'];

    $qs_iwhxxmh = $db
        ->query('select', 'iwhxxmh' )
        ->get(['nama'] )
        ->where('id', $id_iwhxxmh )
        ->exec();
    $rs_iwhxxmh = $qs_iwhxxmh->fetch();
    $iwhxxmh_nama = $rs_iwhxxmh['nama'];

    $qs_iimummd = $db
        ->query('select', 'iimummd' )
        ->get([
            'iumxxmh.kode as iumxxmh_kode',
            'jumlah_konversi'
            ] )
        ->join('iumxxmh','iumxxmh.id = iimummd.id_iumxxmh','LEFT' )
        ->where('id_iimxxmh', $id_iimxxmh )
        ->where('id_iumxxmh', $id_iumxxmh_unit )
        ->exec();
    $rs_iimummd = $qs_iimummd->fetch();
    $jumlah_konversi = $rs_iimummd['jumlah_konversi'];
    $iumxxmh_kode    = $rs_iimummd['iumxxmh_kode'];

    $jumlah_terkecil_input = $jumlah_unit * $jumlah_konversi;

    $qs_iiv = $db
        ->raw()
        ->bind(':id_iimxxmh', $id_iimxxmh)
        ->bind(':id_iwhxxmh', $id_iwhxxmh)
        ->exec('SELECT
                    a.id_wloctmh,
                    a.id_iwhxxmh,
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
                LEFT JOIN (
                    SELECT
                        wloxxmh_nama,
                        iimxxmh_kode,
                        SUM(jumlah_default) * -1 as jumlah_default_booking,
                        SUM(jumlah_terkecil) * -1 as jumlah_terkecil_booking,
                        wlpxxmh_kode
                    FROM iivxxrd
                    WHERE tanggal <= CURDATE() AND is_fisik = 0
                    GROUP BY 
                        -- id_gbrxxmh, 
                        id_iwhxxmh,
                        id_iimxxmh,
                        id_wloxxmh,
                        wlpxxmh_kode
                ) AS b ON b.wloxxmh_nama = a.wloxxmh_nama AND b.iimxxmh_kode = a.iimxxmh_kode AND b.wlpxxmh_kode = a.wlpxxmh_kode
                WHERE tanggal <= CURDATE() 
                    AND id_iwhxxmh = :id_iwhxxmh
                    AND id_iimxxmh = :id_iimxxmh
                GROUP BY 
                    -- id_gbrxxmh, 
                    id_iwhxxmh,
                    id_iimxxmh
                HAVING jumlah_terkecil > 0
    ');
    
    $rs_iiv = $qs_iiv->fetch();

    if (!empty($rs_iiv)) {
        $jumlah_terkecil_ava = $rs_iiv['jumlah_terkecil_ava'];

        if ($jumlah_terkecil_input > $jumlah_terkecil_ava) {
            $jumlah_unit_ava = $jumlah_terkecil_ava / $jumlah_konversi;
            
            $status_code = 500;
            $full_message = "Jumlah Max di Inventory adalah = ".$jumlah_unit_ava." ".$iumxxmh_kode;
            $type_message = 'success';
            $validasi = 'jumlah_unit';
        } else {
            $qs_iwhxxmh = $db
            ->query('select', $table_before )
            ->get(['jumlah_terkecil_os'] )
                ->where('id', $id_transaksi_before )
                ->exec();
                $rs_iwhxxmh = $qs_iwhxxmh->fetch();
                $jumlah_terkecil_os = $rs_iwhxxmh['jumlah_terkecil_os'];
                
            if ($jumlah_terkecil_input > $jumlah_terkecil_os) {
                $jumlah_unit_before = $jumlah_terkecil_os / $jumlah_konversi;
                    
                if ($table_before == "sodittd") {
                    $menu = "Sales Order";
                } else {
                    $menu = "Purchase Order";
                }
                
                $status_code = 500;
                $full_message = "Jumlah Max di ".$menu." adalah = ".$jumlah_unit_before." ".$iumxxmh_kode;
                $type_message = 'success';
                $validasi = 'jumlah_unit';
            } else {
                $status_code = 200;
                $full_message = "Item Tidak Terdaftar di Inventory";
                $type_message = 'success';
                $validasi = 'jumlah_unit';
            }
        }
    } else {
        $status_code = 500;
        $full_message = "Item tidak terdaftar di Inventory pada ".$iwhxxmh_nama;
        $type_message = 'error';
        $validasi = 'id_iimxxmh';
    }

    $data = array(
        'status_code' => $status_code,
        'full_message' => $full_message,
        'type_message' => $type_message,
        'validasi' => $validasi,
    );

    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>