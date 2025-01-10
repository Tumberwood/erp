<?php 
    /**
     * Digunakan untuk melakukan perhitungan presensi karyawan
     */
    require_once( "../../../../users/init.php" );
	require_once( "../../../../usersc/lib/DataTables.php" );
	require_once( "../../../../usersc/helpers/datatables_fn_debug.php" );

    require_once('../../../../usersc/vendor/autoload.php');
	use Carbon\Carbon;

    // BEGIN definisi variable untuk fn_ajax_results.php
    $data      = array();
    $rs_opt    = array();
    $c_rs_opt  = 0;
    $morePages = 0;
    // END definisi variable untuk fn_ajax_results.php

    $awal = new Carbon();
    
    //tanggal
    $tanggal_select = new Carbon($_POST['tanggal_select']); //gunakan carbon untuk ambil data tanggal
    $tanggal = $tanggal_select->format('Y-m-d'); //format jadi 2023-09-12

    $timestamp     = $_POST['timestamp']; //tambah timestamp untuk view

    // BEGIN delete old data
    $qd_htsprrd = $db
        ->query('delete', 'htsprrd')
        ->where('tanggal',$tanggal)
        ->exec();
    // END delete old data
    
    try{
        $db->transaction();

        $qs_status = $db
        ->raw()
        ->exec('SELECT
                    a.kode,
                    a.jenis,
                    GROUP_CONCAT(
                        "WHEN ", 
                        conditions.combined_conditions, 
                        " THEN \"", 
                        a.kode, 
                        "\""
                    ) AS conditional_statement
                FROM hprstmh a
                LEFT JOIN (
                    SELECT 
                        b.id_hprstmh,
                        GROUP_CONCAT(
                            b.kombinasi1, 
                            " ", 
                            IF(b.condition = "Not", "<>", b.condition), 
                            IF(b.kombinasi2 IS NULL OR b.kombinasi2 = "", "", CONCAT(" \"", b.kombinasi2, "\""))
                            SEPARATOR " AND "
                        ) AS combined_conditions
                    FROM hprstmd b
                    GROUP BY b.id_hprstmh
                ) conditions ON conditions.id_hprstmh = a.id
                WHERE a.transaction_state = 1
                GROUP BY a.id;
        ');
    
        $rs_status = $qs_status->fetchAll();
        
        $case_in = '';
        $case_out = '';
        foreach ($rs_status as $key => $status) {
            $jenis_status = $status['jenis'];
            $conditional_statement = $status['conditional_statement'];

            if ($jenis_status == 1) {
                $case_in .= $conditional_statement;
            } else if ($jenis_status == 2) {
                $case_out .= $conditional_statement;
            } else {
                $case_in .= $conditional_statement;
                $case_out .= $conditional_statement;
            }
        }

        // echo $case_in;
        
        $qi_htsprrd_new = $db
            ->raw()
            ->bind(':tanggal', $tanggal)
            ->exec(' INSERT INTO htsprrd (
                        transaction_state,
                        id_hemxxmh,
                        tanggal,
                        st_jadwal,
                        clock_in,
                        clock_out,
                        st_clock_in,
                        st_clock_out,
                        keterangan,
                        htlxxrh_kode,
                        status_presensi_in,
                        status_presensi_out
                    )
                    WITH presensi AS (
                        SELECT DISTINCT
                            a.id AS id_hemxxmh,
                            a.id_users,
                            a.nama,
                            a.kode,
                            IFNULL(kode_shift, "No Jadwal") AS kode_shift,
                            ceklok_in,
                            ceklok_out,
                            tanggaljadwal,
                            
                        -- cek check in
                        if(ceklok_in BETWEEN tanggaljam_awal_t1 AND tanggaljam_awal_toleransi, "OK", 
                            if(ceklok_in BETWEEN tanggaljam_awal_toleransi AND tanggaljam_akhir_toleransi, "Late 1", 
                                if(ceklok_in BETWEEN tanggaljam_akhir_toleransi AND tanggaljam_awal_t2, 
                                    "Late", 
                                    -- IF(ja, 
                                    --     "OFF",
                                        "No CI"
                                    -- )
                                )
                            ) 
                        ) AS st_clock_in,
                        -- cek check out
                        if(ceklok_out BETWEEN tanggaljam_akhir AND tanggaljam_akhir_t2, "OK", 
                            if(ceklok_out BETWEEN tanggaljam_akhir_t1 AND tanggaljam_akhir, 
                                "Early", 
                                -- IF(ja, 
                                --     "OFF",
                                    "No CO"
                                -- )
                            )
                        ) AS st_clock_out,
                        simbol_cuti,
                        jam_shift,
                        simbol_ijin_in,
                        simbol_ijin_out,
                        simbol_ijin_mid,
                        CONCAT(simbol_cuti, " [", cuti.httxxrd_kode, "] ") AS ket_cuti,
                        CONCAT(simbol_ijin_in, " [", izin_in.httxxrd_kode, "] ") AS ket_izin_in,
                        CONCAT(simbol_ijin_out, " [", izin_out.httxxrd_kode, "] ") AS ket_izin_out,
                        CONCAT(simbol_ijin_mid, " [", izin_mid.httxxrd_kode, "] ") AS ket_izin_mid

                        FROM hemxxmh a
                        LEFT JOIN hemjbmh b ON b.id_hemxxmh = a.id

                        LEFT JOIN (
                            SELECT
                                jad.*,
                                sft.jam_awal as jam_shift,
                                jad.tanggal AS tanggaljadwal,
                                concat(sft.jam_awal, " - ", sft.jam_akhir) AS kode_shift,
                                DATE_ADD(jad.tanggaljam_awal, INTERVAL 5 MINUTE) AS tanggaljam_akhir_toleransi, -- tolreansi awal 5 menit
                                DATE_SUB(jad.tanggaljam_awal, INTERVAL 5 MINUTE) AS tanggaljam_awal_toleransi, -- toleransi akhir 5 menit
                                DATE_ADD(jad.tanggaljam_awal, INTERVAL 65 MINUTE) AS tanggaljam_akhir_toleransi_min1jam, -- keperluan toleransi terlambat Late +1 jam 
                                    DATE_SUB(jad.tanggaljam_akhir , INTERVAL 60 MINUTE) AS tanggaljam_akhir_min1, -- keperluan early
                                    DATE_SUB(jad.tanggaljam_akhir_t2 , INTERVAL 60 MINUTE) AS tanggaljam_akhir_t2_min_hour -- untuk is_makan akhir t2 - 1 jam
                                
                            FROM htssctd AS jad
                            LEFT JOIN htsxxmh AS sft ON sft.jam_awal = time(jad.tanggaljam_awal)
                            
                            WHERE jad.transaction_state = 1 AND jad.tanggal = :tanggal
                        ) AS jadwal ON jadwal.id_hemxxmh =  a.id

                        -- ceklok in
                        LEFT JOIN (
                            SELECT
                                a.id,
                                MIN(CONCAT(c.tanggal, " ", c.jam)) AS ceklok_in
                            FROM htssctd AS a
                            LEFT JOIN hemxxmh AS b ON b.id = a.id_hemxxmh
                            LEFT JOIN htsprtd AS c ON c.id_users = b.id_users
                            WHERE a.tanggal = :tanggal
                                    AND a.transaction_state = 1 AND b.transaction_state = 1
                                    AND CONCAT(c.tanggal, " ", c.jam) BETWEEN a.tanggaljam_awal_t1 AND a.tanggaljam_awal_t2
                            GROUP BY a.id
                            ORDER BY ceklok_in

                        ) AS cek_in ON cek_in.id = jadwal.id
                            
                        -- ceklok out
                        LEFT JOIN (
                            SELECT
                                a.id,
                                MAX(CONCAT(c.tanggal, " ", c.jam)) AS ceklok_out
                            FROM htssctd AS a
                            LEFT JOIN hemxxmh AS b ON b.id = a.id_hemxxmh
                            LEFT JOIN htsprtd AS c ON c.id_users = b.id_users
                            WHERE a.tanggal = :tanggal
                                AND a.transaction_state = 1 AND b.transaction_state = 1
                            AND CONCAT(c.tanggal, " ", c.jam) BETWEEN a.tanggaljam_akhir_t1 AND a.tanggaljam_akhir_t2
                            GROUP BY a.id
                            ORDER BY ceklok_out DESC

                        ) AS cek_out ON cek_out.id = jadwal.id

                        -- cuti
                        LEFT JOIN (
                            SELECT
                                httxxrd.kode AS httxxrd_kode,
                                httxxrd.id_hemxxmh,
                                httxxrd.approval_state AS approval_state,
                                httxxrd.saldo AS saldo,
                                httlpmh.kode AS httlpmh_kode,
                                httlpmh_kode AS simbol_cuti
                            FROM httxxrd
                            LEFT JOIN httlpmh ON httlpmh.id = httxxrd.id_httlpmh
                            WHERE httxxrd.tanggal = :tanggal
                                AND httxxrd.jenis = 1
                                AND httxxrd.transaction_state = 1
                            GROUP BY httxxrd.id_hemxxmh
                        ) AS cuti ON cuti.id_hemxxmh = a.id
                            
                        -- Izin IN
                        LEFT JOIN (
                            SELECT
                                httxxrd.id_hemxxmh,
                                httxxrd.id_httlpmh,
                                httxxrd.kode AS httxxrd_kode,
                                concat(httxxrd.tanggal, " ", httxxrd.jam_awal) AS tanggal_jam_izin_awal_in,
                                httxxrd.jam_awal,
                                httxxrd.httlpmh_kode AS httlpmh_kode,
                                httlpmh_kode AS simbol_ijin_in,
                                httxxrd.approval_state
                            FROM httxxrd
                            LEFT JOIN httlpmh ON httlpmh.id = httxxrd.id_httlpmh
                            WHERE httxxrd.transaction_state = 1
                                AND httxxrd.tanggal = :tanggal
                                AND httlpmh.jenis_jam = 1 -- jenis jam awal
                                AND httxxrd.jenis = 2

                        ) AS izin_in ON izin_in.id_hemxxmh = a.id
                            
                        -- Izin OUT
                        LEFT JOIN (
                            SELECT
                                httxxrd.id_hemxxmh,
                                httxxrd.id_httlpmh,
                                httxxrd.kode AS httxxrd_kode,
                                concat(httxxrd.tanggal, " ", httxxrd.jam_akhir) AS tanggal_jam_izin_akhir_out,
                                httxxrd.jam_akhir as jam_akhir_izin_out,
                                httxxrd.httlpmh_kode AS httlpmh_kode,
                                httlpmh_kode AS simbol_ijin_out,
                                httxxrd.approval_state
                            FROM httxxrd
                            LEFT JOIN httlpmh ON httlpmh.id = httxxrd.id_httlpmh
                            WHERE httxxrd.transaction_state = 1
                                AND httxxrd.tanggal = :tanggal
                                AND httlpmh.jenis_jam = 2 -- jenis jam akhir
                                AND httxxrd.jenis = 2

                        ) AS izin_out ON izin_out.id_hemxxmh = a.id
                            
                        -- Izin mid
                        LEFT JOIN (
                            SELECT
                                httxxrd.id_hemxxmh,
                                httxxrd.id_httlpmh,
                                httxxrd.kode AS httxxrd_kode,
                                concat(httxxrd.tanggal, " ", httxxrd.jam_akhir) AS tanggal_jam_izin_akhir_mid,
                                concat(httxxrd.tanggal, " ", httxxrd.jam_awal) AS tanggal_jam_izin_awal_mid,
                                httxxrd.jam_akhir as jam_akhir_izin_mid,
                                httxxrd.jam_awal as jam_awal_izin_mid,
                                httxxrd.httlpmh_kode AS httlpmh_kode,
                                httlpmh_kode AS simbol_ijin_mid,
                                httxxrd.approval_state
                            FROM httxxrd
                            LEFT JOIN httlpmh ON httlpmh.id = httxxrd.id_httlpmh
                            WHERE httxxrd.transaction_state = 1
                                AND httxxrd.tanggal = :tanggal
                                AND httlpmh.jenis_jam = 3 -- jenis jam awal dan akhir
                                AND httxxrd.jenis = 2

                        ) AS izin_mid ON izin_mid.id_hemxxmh = a.id

                        WHERE a.transaction_state = 1 AND b.tanggal_masuk <= :tanggal AND (b.tanggal_keluar IS NULL OR b.tanggal_keluar > :tanggal)
                    ),
                    kondite AS (
                        SELECT
                            id_hemxxmh,
                            kode_shift,
                            ceklok_in,
                            ceklok_out,
                            st_clock_in,
                            st_clock_out,
                            simbol_cuti,
                            jam_shift,
                            simbol_ijin_in,
                            simbol_ijin_mid,
                            simbol_ijin_out,
                            concat(ifnull(ket_cuti,""), ifnull(ket_izin_in,""), ifnull(ket_izin_out,""), ifnull(ket_izin_mid, "") ) AS keterangan,
                        concat(ifnull(simbol_cuti,""), ifnull(simbol_ijin_in,""), ifnull(simbol_ijin_out,""), ifnull(simbol_ijin_mid, "") ) AS kode_kondite,
                            concat(ifnull(ket_cuti,null), ifnull(ket_izin_in,null), ifnull(ket_izin_out,null), ifnull(ket_izin_mid, null) ) AS kondite_harian,
                            concat(ifnull(simbol_cuti,""), ifnull(simbol_ijin_in,""), ifnull(simbol_ijin_out,""), ifnull(simbol_ijin_mid, "") ) AS kondite_jam
                        FROM presensi 
                    ),
                    simbol_presensi AS (
                        SELECT
                            *,
                            -- STATUS PRESENSI IN
                            CASE
                                WHEN simbol_cuti IS NOT NULL AND kondite_harian <> "" THEN kondite_harian
                                WHEN simbol_ijin_in IS NOT NULL AND kondite_harian <> "" THEN kondite_jam
                                '.$case_in.'
                                ELSE NULL
                            END AS status_presensi_in,
                            
                            -- STATUS PRESENSI OUT
                            CASE
                                WHEN simbol_cuti IS NOT NULL AND kondite_harian <> "" THEN kondite_harian
                                WHEN simbol_ijin_out IS NOT NULL AND kondite_harian <> "" THEN kondite_jam
                                '.$case_out.'
                                ELSE NULL
                            END AS status_presensi_out
                        FROM kondite 
                    )
                    SELECT
                        1,
                        id_hemxxmh,
                        :tanggal,
                        kode_shift,
                        ceklok_in,
                        ceklok_out,
                        
                        if(kode_shift = "No Jadwal", NULL, st_clock_in) AS st_clock_in,
                        if(kode_shift = "No Jadwal", NULL, st_clock_out) AS st_clock_out,
                        keterangan,
                        kode_kondite,
                        
                        if(kode_shift = "No Jadwal", "No Jadwal", status_presensi_in) AS status_presensi_in,
                        if(kode_shift = "No Jadwal", "No Jadwal", status_presensi_out) AS status_presensi_out
                    FROM simbol_presensi
                '
        );

        // di commit per karyawan
        $qu_hgtprth = $db
            ->query('update', 'hgtprth')
            ->set('transaction_state',1)
            ->set('generated_on',$timestamp)
            ->where('tanggal',$tanggal)
        ->exec();
        
        $db->commit();
        
        $akhir = new Carbon();
        
        $data = array(
            'message'=> 'Generate Presensi Berhasil Dibuat dalam waktu ' . $awal->diffInSeconds($akhir) . ' detik', 
            'type_message'=>'success',
            'waktu'=> $awal . ' - ' . $akhir . ' /  ' . $awal->diffInSeconds($akhir)
        );
        
    }catch(PDOException $e){
        // rollback on error
        $db->rollback();
        $data = array(
            'message'=>'Data Gagal Dibuat', 
            'type_message'=>'danger',
            'error' => $e
        );
    }

    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );
?>