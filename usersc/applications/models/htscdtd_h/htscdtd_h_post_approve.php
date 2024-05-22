<?php 
    require_once( "../../../../users/init.php" );
	require_once( "../../../../usersc/lib/DataTables.php" );
	require_once( "../../../../usersc/helpers/datatables_fn_debug.php" );

    // BEGIN definisi variable untuk fn_ajax_results.php
    $data      = array();
    $rs_opt    = array();
    $c_rs_opt  = 0;
    $morePages = 0;
    // END definisi variable untuk fn_ajax_results.php
	use Carbon\Carbon;

    $approval_state          = $_POST['approval_state'];
    $id_transaksi = $_POST['id_transaksi'];

    try{
        $db->transaction();
        
        $qs_htscdtd_h = $db
            ->query('select', 'htscdtd_h' )
            ->get([
                'tanggal_terpilih',
                'keterangan',
                'tanggal_pengganti'
            ] )
            ->where('id', $id_transaksi )
        ->exec();

        $rs_htscdtd_h = $qs_htscdtd_h->fetch();
        
        $tanggal_terpilih = $rs_htscdtd_h['tanggal_terpilih'];

        $tanggal_awal_select = new Carbon($tanggal_terpilih); //gunakan carbon untuk ambil data tanggal
        $tanggal_terpilih_dmy = $tanggal_awal_select->format('d-M-Y'); //format jadi 2023-09-12

        $keterangan = "Tukar Hari - " . $tanggal_terpilih_dmy;
        $tanggal_pengganti = $rs_htscdtd_h['tanggal_pengganti'];
        
        
        $qs_htscdtd_peg = $db
            ->query('select', 'htscdtd_peg' )
            ->get([
                'id_hemxxmh'
            ] )
            ->where('id_htscdtd_h', $id_transaksi )
            ->exec();
        $rs_htscdtd_peg = $qs_htscdtd_peg->fetchAll();

        //add by ferry, tambahkan state, karena sebelum ditambahkan if state == 1 meskipun cancel approve tapi tetap menginsert ke database
        if($approval_state == 1) {

            foreach ($rs_htscdtd_peg as $key => $tukar_pegawai) {
                $id_hemxxmh = $tukar_pegawai['id_hemxxmh'];
                
                // BEGIN non aktif
                    $qd_terpilih = $db
                    ->query('delete', 'htssctd')
                    ->where('transaction_state', -9)
                    ->where('tanggal', $tanggal_terpilih)
                    ->where('id_hemxxmh', $id_hemxxmh)
                ->exec();
                
                $qd_pengganti = $db
                    ->query('delete', 'htssctd')
                    ->where('transaction_state', -9)
                    ->where('tanggal', $tanggal_pengganti)
                    ->where('id_hemxxmh', $id_hemxxmh)
                ->exec();

                $qu_htssctd_pengganti = $db
                    ->query('update', 'htssctd')
                    ->set('transaction_state', -9)
                    ->set('keterangan', $keterangan)
                    ->where('tanggal', $tanggal_terpilih)
                    ->where('id_hemxxmh', $id_hemxxmh)
                    ->exec();
                // END non aktif
                    
                // Begin insert pengaju
                $qr_tanggal_terpilih = $db
                    ->raw()
                    ->bind(':tanggal_terpilih', $tanggal_terpilih)
                    ->bind(':tanggal_pengganti', $tanggal_pengganti)
                    ->bind(':id_hemxxmh', $id_hemxxmh)
                    ->exec('INSERT INTO htssctd
                        (
                            transaction_state,
                            keterangan,
                            tanggal,
                            id_hemxxmh,

                            tanggaljam_awal_t1,
                            tanggaljam_awal,
                            tanggaljam_awal_t2,
                            tanggaljam_akhir_t1,
                            tanggaljam_akhir,
                            tanggaljam_akhir_t2,
                            tanggaljam_awal_istirahat,
                            tanggaljam_akhir_istirahat
                        )
                        SELECT
                            1,
                            "'.$keterangan.'",
                            :tanggal_terpilih,
                            htssctd.id_hemxxmh,

                            CONCAT(:tanggal_terpilih, " ", TIME(DATE_SUB(htsxxmh.jam_awal, INTERVAL htsxxmh.menit_toleransi_awal_in MINUTE))) AS tanggaljam_awal_t1,
                            CONCAT(:tanggal_terpilih, " ", htsxxmh.jam_awal) AS tanggaljam_awal,
                            CONCAT(
                                CASE
                                    WHEN DATE_ADD(htsxxmh.jam_awal, INTERVAL htsxxmh.menit_toleransi_akhir_in MINUTE) >= "24:00:00" THEN DATE_ADD(:tanggal_terpilih, INTERVAL 1 DAY)
                                    ELSE :tanggal_terpilih
                                END,
                                " ",
                                TIME(
                                    CASE
                                        WHEN DATE_ADD(htsxxmh.jam_awal, INTERVAL htsxxmh.menit_toleransi_akhir_in MINUTE) >= "24:00:00" THEN
                                            TIMEDIFF(DATE_ADD(htsxxmh.jam_awal, INTERVAL htsxxmh.menit_toleransi_akhir_in MINUTE), "24:00:00")
                                        ELSE
                                            DATE_ADD(htsxxmh.jam_awal, INTERVAL htsxxmh.menit_toleransi_akhir_in MINUTE)
                                    END
                                )
                            ) AS tanggaljam_awal_t2,

                            CASE
                                WHEN htsxxmh.kode like "malam%" AND htsxxmh.jam_akhir <= "12:00:00"
                                THEN CONCAT(DATE_ADD(:tanggal_terpilih, INTERVAL 1 DAY), " ", TIME(DATE_SUB(htsxxmh.jam_akhir, INTERVAL htsxxmh.menit_toleransi_akhir_out MINUTE)))
                                ELSE CONCAT(:tanggal_terpilih, " ", TIME(DATE_SUB(htsxxmh.jam_akhir, INTERVAL htsxxmh.menit_toleransi_akhir_out MINUTE)))
                            END AS tanggaljam_akhir_t1,
                            CASE
                                WHEN htsxxmh.kode like "malam%" AND htsxxmh.jam_akhir <= "12:00:00"
                                THEN CONCAT(DATE_ADD(:tanggal_terpilih, INTERVAL 1 DAY), " ", htsxxmh.jam_akhir)
                                ELSE CONCAT(:tanggal_terpilih, " ", htsxxmh.jam_akhir)
                            END AS tanggaljam_akhir,
                            CONCAT(
                                CASE
                                    WHEN DATE_ADD(htsxxmh.jam_akhir, INTERVAL htsxxmh.menit_toleransi_akhir_out MINUTE) >= "24:00:00" 
                                        OR htsxxmh.kode like "malam%" AND htsxxmh.jam_akhir <= "12:00:00" THEN DATE_ADD(:tanggal_terpilih, INTERVAL 1 DAY)
                                    ELSE :tanggal_terpilih
                                END,
                                " ",
                                TIME(
                                    CASE
                                        WHEN DATE_ADD(htsxxmh.jam_akhir, INTERVAL htsxxmh.menit_toleransi_akhir_out MINUTE) >= "24:00:00" THEN
                                            TIMEDIFF(DATE_ADD(htsxxmh.jam_akhir, INTERVAL htsxxmh.menit_toleransi_akhir_out MINUTE), "24:00:00")
                                        ELSE
                                            DATE_ADD(htsxxmh.jam_akhir, INTERVAL htsxxmh.menit_toleransi_akhir_out MINUTE)
                                    END
                                )
                            ) AS tanggaljam_akhir_t2,
                            CASE
                                WHEN htsxxmh.kode like "malam%" AND htsxxmh.jam_awal_istirahat <= "12:00:00"
                                THEN CONCAT(DATE_ADD(:tanggal_terpilih, INTERVAL 1 DAY), " ", htsxxmh.jam_awal_istirahat)
                                ELSE CONCAT(:tanggal_terpilih, " ", htsxxmh.jam_awal_istirahat)
                            END AS tanggaljam_awal_istirahat,
                            CASE
                                WHEN htsxxmh.kode like "malam%" AND htsxxmh.jam_akhir_istirahat <= "12:00:00"
                                THEN CONCAT(DATE_ADD(:tanggal_terpilih, INTERVAL 1 DAY), " ", htsxxmh.jam_akhir_istirahat)
                                ELSE CONCAT(:tanggal_terpilih, " ", htsxxmh.jam_akhir_istirahat)
                            END AS tanggaljam_akhir_istirahat
                        FROM htssctd
                        LEFT JOIN htsxxmh ON htsxxmh.jam_awal = TIME(htssctd.tanggaljam_awal) AND htsxxmh.jam_akhir = TIME(htssctd.tanggaljam_akhir) AND htsxxmh.jam_awal_istirahat = TIME(htssctd.tanggaljam_awal_istirahat)
                        WHERE 
                            htssctd.tanggal = :tanggal_pengganti
                            AND htssctd.transaction_state = 1
                            AND htssctd.id_hemxxmh = :id_hemxxmh
                    ');
                // END insert pengaju

                //TANGGAL PENGGANTI Jadi tanggal pengaju
                $qu_htssctd_pengganti = $db
                    ->query('update', 'htssctd')
                    ->set('transaction_state', -9)
                    ->where('tanggal', $tanggal_pengganti)
                    ->where('id_hemxxmh', $id_hemxxmh)
                    ->exec();
                    
                // Begin insert pengaju
                $qr_tanggal_pengganti = $db
                    ->raw()
                    ->bind(':tanggal_terpilih', $tanggal_terpilih)
                    ->bind(':tanggal_pengganti', $tanggal_pengganti)
                    ->bind(':id_hemxxmh', $id_hemxxmh)
                    ->exec('INSERT INTO htssctd
                        (
                            transaction_state,
                            keterangan,
                            tanggal,
                            id_hemxxmh,

                            tanggaljam_awal_t1,
                            tanggaljam_awal,
                            tanggaljam_awal_t2,
                            tanggaljam_akhir_t1,
                            tanggaljam_akhir,
                            tanggaljam_akhir_t2,
                            tanggaljam_awal_istirahat,
                            tanggaljam_akhir_istirahat
                        )
                        SELECT
                            1,
                            "'.$keterangan.'",
                            :tanggal_pengganti,
                            htssctd.id_hemxxmh,
                            CONCAT(:tanggal_pengganti, " ", TIME(DATE_SUB(htsxxmh.jam_awal, INTERVAL htsxxmh.menit_toleransi_awal_in MINUTE))) AS tanggaljam_awal_t1,
                            CONCAT(:tanggal_pengganti, " ", htsxxmh.jam_awal) AS tanggaljam_awal,
                            CONCAT(
                                CASE
                                    WHEN DATE_ADD(htsxxmh.jam_awal, INTERVAL htsxxmh.menit_toleransi_akhir_in MINUTE) >= "24:00:00" THEN DATE_ADD(:tanggal_pengganti, INTERVAL 1 DAY)
                                    ELSE :tanggal_pengganti
                                END,
                                " ",
                                TIME(
                                    CASE
                                        WHEN DATE_ADD(htsxxmh.jam_awal, INTERVAL htsxxmh.menit_toleransi_akhir_in MINUTE) >= "24:00:00" THEN
                                            TIMEDIFF(DATE_ADD(htsxxmh.jam_awal, INTERVAL htsxxmh.menit_toleransi_akhir_in MINUTE), "24:00:00")
                                        ELSE
                                            DATE_ADD(htsxxmh.jam_awal, INTERVAL htsxxmh.menit_toleransi_akhir_in MINUTE)
                                    END
                                )
                            ) AS tanggaljam_awal_t2,

                            CASE
                                WHEN htsxxmh.kode like "malam%" AND htsxxmh.jam_akhir <= "12:00:00"
                                THEN CONCAT(DATE_ADD(:tanggal_pengganti, INTERVAL 1 DAY), " ", TIME(DATE_SUB(htsxxmh.jam_akhir, INTERVAL htsxxmh.menit_toleransi_akhir_out MINUTE)))
                                ELSE CONCAT(:tanggal_pengganti, " ", TIME(DATE_SUB(htsxxmh.jam_akhir, INTERVAL htsxxmh.menit_toleransi_akhir_out MINUTE)))
                            END AS tanggaljam_akhir_t1,
                            CASE
                                WHEN htsxxmh.kode like "malam%" AND htsxxmh.jam_akhir <= "12:00:00"
                                THEN CONCAT(DATE_ADD(:tanggal_pengganti, INTERVAL 1 DAY), " ", htsxxmh.jam_akhir)
                                ELSE CONCAT(:tanggal_pengganti, " ", htsxxmh.jam_akhir)
                            END AS tanggaljam_akhir,
                            CONCAT(
                                CASE
                                    WHEN DATE_ADD(htsxxmh.jam_akhir, INTERVAL htsxxmh.menit_toleransi_akhir_out MINUTE) >= "24:00:00" 
                                        OR htsxxmh.kode like "malam%" AND htsxxmh.jam_akhir <= "12:00:00" THEN DATE_ADD(:tanggal_pengganti, INTERVAL 1 DAY)
                                    ELSE :tanggal_pengganti
                                END,
                                " ",
                                TIME(
                                    CASE
                                        WHEN DATE_ADD(htsxxmh.jam_akhir, INTERVAL htsxxmh.menit_toleransi_akhir_out MINUTE) >= "24:00:00" THEN
                                            TIMEDIFF(DATE_ADD(htsxxmh.jam_akhir, INTERVAL htsxxmh.menit_toleransi_akhir_out MINUTE), "24:00:00")
                                        ELSE
                                            DATE_ADD(htsxxmh.jam_akhir, INTERVAL htsxxmh.menit_toleransi_akhir_out MINUTE)
                                    END
                                )
                            ) AS tanggaljam_akhir_t2,
                            CASE
                                WHEN htsxxmh.kode like "malam%" AND htsxxmh.jam_awal_istirahat <= "12:00:00"
                                THEN CONCAT(DATE_ADD(:tanggal_pengganti, INTERVAL 1 DAY), " ", htsxxmh.jam_awal_istirahat)
                                ELSE CONCAT(:tanggal_pengganti, " ", htsxxmh.jam_awal_istirahat)
                            END AS tanggaljam_awal_istirahat,
                            CASE
                                WHEN htsxxmh.kode like "malam%" AND htsxxmh.jam_akhir_istirahat <= "12:00:00"
                                THEN CONCAT(DATE_ADD(:tanggal_pengganti, INTERVAL 1 DAY), " ", htsxxmh.jam_akhir_istirahat)
                                ELSE CONCAT(:tanggal_pengganti, " ", htsxxmh.jam_akhir_istirahat)
                            END AS tanggaljam_akhir_istirahat
                        FROM htssctd
                        LEFT JOIN htsxxmh ON htsxxmh.jam_awal = TIME(htssctd.tanggaljam_awal) AND htsxxmh.jam_akhir = TIME(htssctd.tanggaljam_akhir) AND htsxxmh.jam_awal_istirahat = TIME(htssctd.tanggaljam_awal_istirahat)
                        WHERE 
                            htssctd.tanggal = :tanggal_terpilih
                        AND htssctd.transaction_state = -9
                        AND htssctd.id_hemxxmh = :id_hemxxmh
                    ');
                // END insert pengaju
            }

            
        } else {

            foreach ($rs_htscdtd_peg as $key => $tukar_pegawai) {
                $id_hemxxmh = $tukar_pegawai['id_hemxxmh'];
                
                // BEGIN non aktif
                $qd_terpilih = $db
                    ->query('delete', 'htssctd')
                    ->where('transaction_state', 1)
                    ->where('tanggal', $tanggal_terpilih)
                    ->where('id_hemxxmh', $id_hemxxmh)
                ->exec();

                $qu_htssctd_pengganti = $db
                    ->query('update', 'htssctd')
                    ->set('transaction_state', 1)
                    ->where('transaction_state', -9)
                    ->where('tanggal', $tanggal_terpilih)
                    ->where('id_hemxxmh', $id_hemxxmh)
                    ->exec();

                //TANGGAL PENGGANTI Jadi tanggal pengaju
                
                $qd_pengganti = $db
                    ->query('delete', 'htssctd')
                    ->where('transaction_state', 1)
                    ->where('tanggal', $tanggal_pengganti)
                    ->where('id_hemxxmh', $id_hemxxmh)
                ->exec();
                
                $qu_htssctd_pengganti = $db
                    ->query('update', 'htssctd')
                    ->set('transaction_state', 1)
                    ->where('transaction_state', -9)
                    ->where('tanggal', $tanggal_pengganti)
                    ->where('id_hemxxmh', $id_hemxxmh)
                ->exec();
            }
        }
        
        
    
        $db->commit();
        $data = array(
            'message'=> 'Perubahan Jadwal Berhasil Dibuat' , 
            'type_message'=>'success' 
        );
    }catch(PDOException $e){
        // rollback on error
        $db->rollback();
        $data = array(
            'message'=>'Perubahan Jadwal Gagal Dibuat!', 
            'qr_htssctd_pengaju'=>'danger' 
        );
    }    

    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>