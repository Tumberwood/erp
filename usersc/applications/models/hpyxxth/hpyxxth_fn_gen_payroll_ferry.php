<?php 
    /**
     * Digunakan untuk melakukan perhitungan payroll karyawan
     * 
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

    //DEKLARASI VARIABLE PAYROLL
    $awal = new Carbon();
    $tanggal_awal_select = new Carbon($_POST['tanggal_awal']); //gunakan carbon untuk ambil data tanggal
    $tanggal_awal = $tanggal_awal_select->format('Y-m-d'); //format jadi 2023-09-12

    $tanggal_akhir_select = new Carbon($_POST['tanggal_akhir']); //gunakan carbon untuk ambil data tanggal
    $tanggal_akhir = $tanggal_akhir_select->format('Y-m-d'); //format jadi 2023-09-12

    $id_hpyxxth     = $_POST['id_hpyxxth'];

    $timestamp     = $_POST['timestamp']; //tambah timestamp untuk view

    try{
        $db->transaction();
        
        //DELETE DETAIL PAYROLL LAMA
        $qd_detail_payroll = $db
            ->raw()
            ->bind(':id_hpyxxth', $id_hpyxxth)
            ->exec('DELETE FROM hpyemtd
                    WHERE id_hpyxxth = :id_hpyxxth
            '
        );
        
        //INSERT Payroll
        $qi_hpyemtd = $db
            ->raw()
            ->bind(':id_hpyxxth', $id_hpyxxth)
            ->bind(':tanggal_awal', $tanggal_awal)
            ->bind(':tanggal_akhir', $tanggal_akhir)
            ->exec('INSERT INTO hpyemtd (
                        id_hpyxxth,
                        id_hemxxmh,
                        gp,
                        gpbpjs,
                        
                        -- JHT penambah dan pengurang
                        jht_k,
                        jht_p,

                        -- jkk dan jkm
                        jkk_p,
                        jkm_p,

                        jp_k,
                        jp_p,

                        bpjss_k,
                        bpjss_p,
                        tlev
                    )
                    SELECT
                        :id_hpyxxth,
                        a.id_hemxxmh,
                        nominal_gp AS gp,
                        gaji_bpjs AS gpbpjs,
                        
                        -- JHT penambah dan pengurang
                        IFNULL((persen_jht_karyawan / 100) * gaji_bpjs, 0) AS jht_k,
                        IFNULL((persen_jht_perusahaan / 100) * gaji_bpjs, 0) AS jht_p,

                        -- jkk dan jkm
                        IFNULL((persen_jkk / 100) * gaji_bpjs, 0) AS jkk_p,
                        IFNULL((persen_jkm / 100) * gaji_bpjs, 0) AS jkm_p,

                        IFNULL((persen_jp_karyawan / 100) * gaji_bpjs, 0) AS jp_k,
                        IFNULL((persen_jp_perusahaan / 100) * gaji_bpjs, 0) AS jp_p,

                        IFNULL((persen_karyawan / 100) * gaji_bpjs, 0) AS bpjss_k,
                        IFNULL((persen_perusahaan / 100) * gaji_bpjs, 0) AS bpjss_p,
                        IFNULL(tlev,0) AS tlev
                    FROM htsprrd a
                    LEFT JOIN hemxxmh b ON b.id = a.id_hemxxmh
                    LEFT JOIN hemjbmh c ON c.id_hemxxmh = b.id

                    -- Gaji Pokok
                    LEFT JOIN (
                        SELECT
                            id_hemxxmh,
                            tanggal_efektif,
                            IFNULL(nominal, 0) AS nominal_gp
                        FROM (
                            SELECT
                                id,
                                id_hemxxmh,
                                tanggal_efektif,
                                nominal,
                                ROW_NUMBER() OVER (PARTITION BY id_hemxxmh ORDER BY tanggal_efektif DESC) AS row_num
                            FROM htpr_hemxxmh
                            WHERE
                                htpr_hemxxmh.id_hpcxxmh = 1
                                AND tanggal_efektif < :tanggal_awal
                                AND transaction_state <> -9
                        ) AS subquery
                        WHERE row_num = 1
                    ) tbl_htpr_hemxxmh ON tbl_htpr_hemxxmh.id_hemxxmh = a.id_hemxxmh

                    -- select gaji bpjs
                    LEFT JOIN (
                        SELECT
                            id_hemxxmh,
                            tanggal_efektif,
                            IFNULL(nominal, 0) AS gaji_bpjs
                        FROM (
                            SELECT
                                id,
                                id_hemxxmh,
                                tanggal_efektif,
                                nominal,
                                ROW_NUMBER() OVER (PARTITION BY id_hemxxmh ORDER BY tanggal_efektif DESC) AS row_num
                            FROM htpr_hemxxmh
                            WHERE
                                htpr_hemxxmh.id_hpcxxmh = 2
                                AND tanggal_efektif < :tanggal_awal
                                AND transaction_state <> -9
                        ) AS subquery
                        WHERE row_num = 1
                    ) tbl_gaji_bpjs ON tbl_gaji_bpjs.id_hemxxmh = a.id_hemxxmh

                    -- select data dari hibtkmh untuk hitung bpjs
                    LEFT JOIN (
                        SELECT
                            persen_jht_karyawan,
                            persen_jht_perusahaan,
                            persen_jkk,
                            persen_jkm,
                            persen_jp_karyawan,
                            persen_jp_perusahaan,
                            transaction_state
                        FROM hibtkmh
                    ) bpjs ON bpjs.transaction_state = 1

                    -- select data dari hibksmh untuk hitung bpjs kesehatan
                    LEFT JOIN (
                        SELECT
                            persen_karyawan,
                            persen_perusahaan,
                            transaction_state
                        FROM hibksmh
                    ) bpjs_kesehatan ON bpjs_kesehatan.transaction_state = 1

                    -- select Tunjangan Level TLEV id_hpcxxmh = 12
                    LEFT JOIN (
                        SELECT
                            id_hevxxmh,
                            tanggal_efektif,
                            IFNULL(nominal, 0) AS tlev
                        FROM (
                            SELECT
                                id,
                                id_hevxxmh,
                                tanggal_efektif,
                                nominal,
                                ROW_NUMBER() OVER (PARTITION BY id_hevxxmh ORDER BY tanggal_efektif DESC) AS row_num
                            FROM htpr_hevxxmh
                            WHERE
                                htpr_hevxxmh.id_hpcxxmh = 12
                                AND tanggal_efektif < :tanggal_awal
                                AND transaction_state <> -9
                        ) AS subquery
                        WHERE row_num = 1
                    ) tbl_tlev ON tbl_tlev.id_hevxxmh = c.id_hevxxmh

                    WHERE a.tanggal BETWEEN :tanggal_awal AND :tanggal_akhir
            '
        );

        $qu_hpyxxth = $db
            ->query('update', 'hpyxxth')
            ->set('generated_on',$timestamp)
            ->where('id',$id_hpyxxth)
        ->exec();
        
        $db->commit();

        $akhir = new Carbon();

        $data = array(
            'message' => 'Generate Payroll Berhasil Dibuat dalam waktu ' . $awal->diffInSeconds($akhir) . ' detik', 
            'type_message' => 'success',
            'waktu'=> $awal . ' - ' . $akhir . ' /  ' . $awal->diffInSeconds($akhir)
        );  
    }catch(PDOException $e){
        // rollback on error
        $db->rollback();
        
    }
    

    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );
?>