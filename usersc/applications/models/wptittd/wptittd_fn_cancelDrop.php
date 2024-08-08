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

    // ambil variable dari ajax data
    $wlpxxmh_kode = $_POST['wlpxxmh_kode'];
    
    $qs_receiving = $db
        ->raw()
        ->bind(':wlpxxmh_kode', $wlpxxmh_kode)
        ->exec('SELECT
                    a.id,
                    a.id_wloxxmh,
                    a.wloxxmh_kode,
                    a.wloxxmh_nama
                FROM iivxxrd a
                WHERE a.wlpxxmh_kode = :wlpxxmh_kode AND a.id_wloctmh = 1
                LIMIT 1
        '
        );
    $rs_receiving = $qs_receiving->fetch();
    $id_wloxxmh_awal = $rs_receiving['id_wloxxmh'];
    $wloxxmh_kode_awal = $rs_receiving['wloxxmh_kode'];
    $wloxxmh_nama_awal = $rs_receiving['wloxxmh_nama'];
    
    //minus di location drop
    $qi_iivxxrd_min = $db
        ->raw()
        ->bind(':wlpxxmh_kode', $wlpxxmh_kode)
        ->exec('INSERT INTO iivxxrd (
                    id_transaksi_h,
                    id_transaksi_d,
                    id_gcpxxmh,
                    id_gbrxxmh,
                    id_iwhxxmh,
                    id_wloctmh,
                    id_wloxxmh,
                    id_relasi_m,
                    id_iimxxmh,
                    id_iumxxmh_unit,
                    id_iumxxmh_terkecil,
                    id_iumxxmh_default,
                    kode,
                    keterangan,
                    confirmed_at,
                    created_by,
                    gcpxxmh_kode,
                    gcpxxmh_nama,
                    gbrxxmh_kode,
                    gbrxxmh_nama,
                    iwhxxmh_kode,
                    iwhxxmh_nama,
                    wloxxmh_kode,
                    wloxxmh_nama,
                    relasi_m_kode,
                    relasi_m_nama,
                    iimxxmh_kode,
                    iimxxmh_nama,
                    iumxxmh_unit_kode,
                    iumxxmh_unit_nama,
                    iumxxmh_terkecil_kode,
                    iumxxmh_terkecil_nama,
                    iumxxmh_default_kode,
                    iumxxmh_default_nama,
                    imtxxmh_kode,
                    imtxxmh_movement_type,
                    tanggal,
                    is_fisik,
                    jumlah_unit,
                    jumlah_konversi,
                    jumlah_terkecil,
                    jumlah_default,
                    wlpxxmh_kode,
                    expired_date,
                    batch_number
                )
                SELECT
                    id_transaksi_h,
                    id_transaksi_d,
                    id_gcpxxmh,
                    id_gbrxxmh,
                    id_iwhxxmh,
                    id_wloctmh,
                    id_wloxxmh,
                    id_relasi_m,
                    id_iimxxmh,
                    id_iumxxmh_unit,
                    id_iumxxmh_terkecil,
                    id_iumxxmh_default,
                    kode,
                    concat("CANCEL DROP - ",keterangan),
                    now(),
                    created_by,
                    gcpxxmh_kode,
                    gcpxxmh_nama,
                    gbrxxmh_kode,
                    gbrxxmh_nama,
                    iwhxxmh_kode,
                    iwhxxmh_nama,
                    wloxxmh_kode,
                    wloxxmh_nama,
                    relasi_m_kode,
                    relasi_m_nama,
                    iimxxmh_kode,
                    iimxxmh_nama,
                    iumxxmh_unit_kode,
                    iumxxmh_unit_nama,
                    iumxxmh_terkecil_kode,
                    iumxxmh_terkecil_nama,
                    iumxxmh_default_kode,
                    iumxxmh_default_nama,
                    imtxxmh_kode,
                    imtxxmh_movement_type,
                    curdate(),
                    is_fisik,
                    -SUM(a.jumlah_unit) s_unit,
                    jumlah_konversi,
                    -SUM(a.jumlah_terkecil) s_terkecil,
                    -SUM(a.jumlah_default) s_def,
                    wlpxxmh_kode,
                    expired_date,
                    batch_number
                FROM iivxxrd a
                WHERE a.wlpxxmh_kode = :wlpxxmh_kode AND a.id_wloctmh IN (1,6)
                GROUP BY a.id_wloxxmh
                HAVING SUM(a.jumlah_terkecil) > 0 > 0
        '
    );
    $id_iivxxrd = $qi_iivxxrd_min->insertId();

    //plus di location receiving
    $qi_iivxxrd = $db
        ->raw()
        ->bind(':id_iivxxrd', $id_iivxxrd)
        ->bind(':id_wloxxmh_awal', $id_wloxxmh_awal)
        ->bind(':wloxxmh_kode_awal', $wloxxmh_kode_awal)
        ->bind(':wloxxmh_nama_awal', $wloxxmh_nama_awal)
        ->exec('INSERT INTO iivxxrd (
                    id_transaksi_h,
                    id_transaksi_d,
                    id_gcpxxmh,
                    id_gbrxxmh,
                    id_iwhxxmh,
                    id_wloctmh,
                    id_wloxxmh,
                    id_relasi_m,
                    id_iimxxmh,
                    id_iumxxmh_unit,
                    id_iumxxmh_terkecil,
                    id_iumxxmh_default,
                    kode,
                    keterangan,
                    confirmed_at,
                    created_by,
                    gcpxxmh_kode,
                    gcpxxmh_nama,
                    gbrxxmh_kode,
                    gbrxxmh_nama,
                    iwhxxmh_kode,
                    iwhxxmh_nama,
                    wloxxmh_kode,
                    wloxxmh_nama,
                    relasi_m_kode,
                    relasi_m_nama,
                    iimxxmh_kode,
                    iimxxmh_nama,
                    iumxxmh_unit_kode,
                    iumxxmh_unit_nama,
                    iumxxmh_terkecil_kode,
                    iumxxmh_terkecil_nama,
                    iumxxmh_default_kode,
                    iumxxmh_default_nama,
                    imtxxmh_kode,
                    imtxxmh_movement_type,
                    tanggal,
                    is_fisik,
                    jumlah_unit,
                    jumlah_konversi,
                    jumlah_terkecil,
                    jumlah_default,
                    wlpxxmh_kode,
                    expired_date,
                    batch_number
                )
                SELECT
                    id_transaksi_h,
                    id_transaksi_d,
                    id_gcpxxmh,
                    id_gbrxxmh,
                    id_iwhxxmh,
                    1,
                    :id_wloxxmh_awal,
                    id_relasi_m,
                    id_iimxxmh,
                    id_iumxxmh_unit,
                    id_iumxxmh_terkecil,
                    id_iumxxmh_default,
                    kode,
                    keterangan,
                    confirmed_at,
                    created_by,
                    gcpxxmh_kode,
                    gcpxxmh_nama,
                    gbrxxmh_kode,
                    gbrxxmh_nama,
                    iwhxxmh_kode,
                    iwhxxmh_nama,
                    :wloxxmh_kode_awal,
                    :wloxxmh_nama_awal,
                    relasi_m_kode,
                    relasi_m_nama,
                    iimxxmh_kode,
                    iimxxmh_nama,
                    iumxxmh_unit_kode,
                    iumxxmh_unit_nama,
                    iumxxmh_terkecil_kode,
                    iumxxmh_terkecil_nama,
                    iumxxmh_default_kode,
                    iumxxmh_default_nama,
                    imtxxmh_kode,
                    imtxxmh_movement_type,
                    tanggal,
                    is_fisik,
                    a.jumlah_unit * -1,
                    jumlah_konversi,
                    a.jumlah_terkecil * -1,
                    a.jumlah_default * -1,
                    wlpxxmh_kode,
                    expired_date,
                    batch_number
                FROM iivxxrd a
                WHERE a.id = :id_iivxxrd
        '
    );
    
    //ubah flag is_cancel_drop = 1 untuk LPN yang terpilih (jika lokasi tujuan adalah lokasi drop).
    $qi_iivxxrd = $db
        ->raw()
        ->bind(':wlpxxmh_kode', $wlpxxmh_kode)
        ->exec('UPDATE wptittd a
                LEFT JOIN wloxxmh b ON b.id = a.id_wloxxmh_tujuan
                SET
                    a.is_cancel_drop = 1
                WHERE a.wlpxxmh_kode = :wlpxxmh_kode AND b.id_wloctmh = 6
        '
    );

    if(empty($qi_iivxxrd)){
        $status_code = 500;
        $message = 'Cancel Drop Gagal!';
        $type_message = 'error';
    }else{
        $status_code = 200;
        $message = 'Cancel Drop Berhasil!';
        $type_message = 'success';        
    }

    $data = array(
        'status_code'       => $status_code,
        'message'           => $message,
        'type_message'      => $type_message,
    );

    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>