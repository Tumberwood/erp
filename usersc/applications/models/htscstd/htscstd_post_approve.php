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

    $approval_state          = $_POST['approval_state'];
    $id_transaksi = $_POST['id_transaksi'];

    try{
        $db->transaction();
        
        $qs_htscctd = $db
            ->query('select', 'htscstd' )
            ->get([
                'htscstd.id_hemxxmh_pengaju as id_hemxxmh_pengaju',
                'htscstd.id_hemxxmh_pengganti as id_hemxxmh_pengganti',
                'htscstd.jam_awal_pengaju as jam_awal_pengaju',
                'htscstd.jam_akhir_pengaju as jam_akhir_pengaju',
                'htscstd.jam_awal_pengganti as jam_awal_pengganti',
                'htscstd.jam_akhir_pengganti as jam_akhir_pengganti',
                'htscstd.jam_awal_istirahat_pengaju as jam_awal_istirahat_pengaju',
                'htscstd.jam_awal_istirahat_pengganti as jam_awal_istirahat_pengganti',
                'htscstd.kode as kode',
                'htscstd.jenis as jenis',
                'htscstd.tanggal as tanggal',
                'htscstd.keterangan as keterangan'
            ] )
            ->where('htscstd.id', $id_transaksi )
            ->exec();

        $rs_htscctd = $qs_htscctd->fetch();
        
        $keterangan = $rs_htscctd['kode'] ." - ". $rs_htscctd['keterangan'];
        $jenis = $rs_htscctd['jenis'];
        $jam_awal_pengganti = $rs_htscctd['jam_awal_pengganti'];
        $jam_akhir_pengganti = $rs_htscctd['jam_akhir_pengganti'];

        $jam_awal_istirahat_pengaju = $rs_htscctd['jam_awal_istirahat_pengaju'];
        $jam_awal_istirahat_pengganti = $rs_htscctd['jam_awal_istirahat_pengganti'];

        $jam_awal_pengaju = $rs_htscctd['jam_awal_pengaju'];
        $jam_akhir_pengaju = $rs_htscctd['jam_akhir_pengaju'];

        //add by ferry, tambahkan approval_state, karena sebelum ditambahkan if approval_state == 1 meskipun cancel approve tapi tetap menginsert ke database
        if($approval_state == 1) {
            //Jika Approved dan Jenis == Tukar Jadwal
            if ($jenis == "Tukar Jadwal") {
                
                // BEGIN non aktif
                $qu_htssctd_pengaju = $db
                    ->query('update', 'htssctd')
                    ->set('transaction_state', -9)
                    ->set('keterangan', $keterangan)
                    ->where('tanggal', $rs_htscctd['tanggal'])
                    ->where('id_hemxxmh', $rs_htscctd['id_hemxxmh_pengaju'])
                ->exec();
    
                $qu_htssctd_pengganti = $db
                    ->query('update', 'htssctd')
                    ->set('transaction_state', -9)
                    ->set('keterangan', $keterangan)
                    ->where('tanggal', $rs_htscctd['tanggal'])
                    ->where('id_hemxxmh', $rs_htscctd['id_hemxxmh_pengganti'])
                ->exec();
                // END non aktif
    
                // Begin insert pengaju
                $qr_htssctd_pengaju = $db
                    ->raw()
                    ->bind(':jam_awal_pengganti', $rs_htscctd['jam_awal_pengganti'])
                    ->bind(':jam_akhir_pengganti', $rs_htscctd['jam_akhir_pengganti'])
                    ->bind(':jam_awal_istirahat_pengganti', $rs_htscctd['jam_awal_istirahat_pengganti'])
                    ->bind(':tanggal_pengganti', $rs_htscctd["tanggal"])
                    ->exec('
                        INSERT INTO htssctd
                        (
                            transaction_state,
                            id_hemxxmh,
                            keterangan,
                            tanggal,
    
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
                            '.$rs_htscctd["id_hemxxmh_pengaju"].',
                            "'.$keterangan.'",
                            "'.$rs_htscctd["tanggal"].'",

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
                        FROM htsxxmh
                        WHERE 
                            jam_awal = :jam_awal_pengganti AND jam_akhir = :jam_akhir_pengganti AND jam_awal_istirahat = :jam_awal_istirahat_pengganti
                    ');
                // END insert pengaju
    
                // BEGIN insert pengganti
                $qr_htssctd_pengganti = $db
                    ->raw()
                    ->bind(':jam_awal_pengaju', $rs_htscctd['jam_awal_pengaju'])
                    ->bind(':jam_akhir_pengaju', $rs_htscctd['jam_akhir_pengaju'])
                    ->bind(':jam_awal_istirahat_pengaju', $rs_htscctd['jam_awal_istirahat_pengaju'])
                    ->bind(':tanggal_pengaju', $rs_htscctd["tanggal"])
                    ->exec('
                        INSERT INTO htssctd
                        (
                            transaction_state,
                            id_hemxxmh,
                            keterangan,
                            tanggal,
    
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
                            '.$rs_htscctd["id_hemxxmh_pengganti"].',
                            "'.$keterangan.'",
                            "'.$rs_htscctd["tanggal"].'",
                            
                            CONCAT(:tanggal_pengaju, " ", TIME(DATE_SUB(htsxxmh.jam_awal, INTERVAL htsxxmh.menit_toleransi_awal_in MINUTE))) AS tanggaljam_awal_t1,
                            CONCAT(:tanggal_pengaju, " ", htsxxmh.jam_awal) AS tanggaljam_awal,
                            CONCAT(
                                CASE
                                    WHEN DATE_ADD(htsxxmh.jam_awal, INTERVAL htsxxmh.menit_toleransi_akhir_in MINUTE) >= "24:00:00" THEN DATE_ADD(:tanggal_pengaju, INTERVAL 1 DAY)
                                    ELSE :tanggal_pengaju
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
                                THEN CONCAT(DATE_ADD(:tanggal_pengaju, INTERVAL 1 DAY), " ", TIME(DATE_SUB(htsxxmh.jam_akhir, INTERVAL htsxxmh.menit_toleransi_akhir_out MINUTE)))
                                ELSE CONCAT(:tanggal_pengaju, " ", TIME(DATE_SUB(htsxxmh.jam_akhir, INTERVAL htsxxmh.menit_toleransi_akhir_out MINUTE)))
                            END AS tanggaljam_akhir_t1,
                            CASE
                                WHEN htsxxmh.kode like "malam%" AND htsxxmh.jam_akhir <= "12:00:00"
                                THEN CONCAT(DATE_ADD(:tanggal_pengaju, INTERVAL 1 DAY), " ", htsxxmh.jam_akhir)
                                ELSE CONCAT(:tanggal_pengaju, " ", htsxxmh.jam_akhir)
                            END AS tanggaljam_akhir,
                            CONCAT(
                                CASE
                                    WHEN DATE_ADD(htsxxmh.jam_akhir, INTERVAL htsxxmh.menit_toleransi_akhir_out MINUTE) >= "24:00:00" 
                                        OR htsxxmh.kode like "malam%" AND htsxxmh.jam_akhir <= "12:00:00" THEN DATE_ADD(:tanggal_pengaju, INTERVAL 1 DAY)
                                    ELSE :tanggal_pengaju
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
                                THEN CONCAT(DATE_ADD(:tanggal_pengaju, INTERVAL 1 DAY), " ", htsxxmh.jam_awal_istirahat)
                                ELSE CONCAT(:tanggal_pengaju, " ", htsxxmh.jam_awal_istirahat)
                            END AS tanggaljam_awal_istirahat,
                            CASE
                                WHEN htsxxmh.kode like "malam%" AND htsxxmh.jam_akhir_istirahat <= "12:00:00"
                                THEN CONCAT(DATE_ADD(:tanggal_pengaju, INTERVAL 1 DAY), " ", htsxxmh.jam_akhir_istirahat)
                                ELSE CONCAT(:tanggal_pengaju, " ", htsxxmh.jam_akhir_istirahat)
                            END AS tanggaljam_akhir_istirahat
                        FROM htsxxmh
                        WHERE 
                            jam_awal = :jam_awal_pengaju AND jam_akhir = :jam_akhir_pengaju AND jam_awal_istirahat = :jam_awal_istirahat_pengaju
                    ');
    
            
                // END insert pengganti
            } else {
                ///////////// REPLACEMENT ////////////

                // BEGIN insert pengganti tambahan
                $qr_htssctd = $db
                    ->raw()
                    ->bind(':jam_awal_pengaju', $rs_htscctd['jam_awal_pengaju'])
                    ->bind(':jam_akhir_pengaju', $rs_htscctd['jam_akhir_pengaju'])
                    ->bind(':jam_awal_istirahat_pengaju', $rs_htscctd['jam_awal_istirahat_pengaju'])
                    ->bind(':tanggal_pengganti', $rs_htscctd["tanggal"])
                    ->exec('
                        INSERT INTO htssctd
                        (
                            transaction_state,
                            id_hemxxmh,
                            keterangan,
                            tanggal,

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
                            '.$rs_htscctd["id_hemxxmh_pengganti"].',
                            "'.$keterangan.'",
                            "'.$rs_htscctd["tanggal"].'",

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
                        FROM htsxxmh
                        WHERE 
                            jam_awal = :jam_awal_pengaju AND jam_akhir = :jam_akhir_pengaju AND jam_awal_istirahat = :jam_awal_istirahat_pengaju
                    ');
                // END insert pengganti tambahan
            }
            
        } else {
            
            if ($jenis == "Tukar Jadwal") {
                ////// Pengaju //////////
    
                $qd_pengaju = $db
                    ->raw()
                    ->bind(':tanggal', $rs_htscctd["tanggal"])
                    ->bind(':keterangan', $keterangan)
                    ->bind(':id_hemxxmh_pengaju', $rs_htscctd["id_hemxxmh_pengaju"])
                    ->exec('DELETE FROM htssctd
                            WHERE transaction_state = 1
                                AND id_hemxxmh = :id_hemxxmh_pengaju
                                AND tanggal = :tanggal
                                AND keterangan = :keterangan
                                ;
                ');
    
                $qu_htssctd_pengaju = $db
                    ->query('update', 'htssctd')
                    ->set('transaction_state', 1)
                    ->where('transaction_state',-9)
                    ->where('tanggal', $rs_htscctd['tanggal'])
                    ->where('id_hemxxmh', $rs_htscctd['id_hemxxmh_pengaju'])
                    ->exec();
    
                ////// Pengganti //////////
                $qd_pengganti = $db
                    ->raw()
                    ->bind(':tanggal', $rs_htscctd["tanggal"])
                    ->bind(':keterangan', $keterangan)
                    ->bind(':id_hemxxmh_pengganti', $rs_htscctd["id_hemxxmh_pengganti"])
                    ->exec('DELETE FROM htssctd
                            WHERE transaction_state = 1
                                AND id_hemxxmh = :id_hemxxmh_pengganti
                                AND tanggal = :tanggal
                                AND keterangan = :keterangan
                                ;
                ');
    
                $qu_htssctd_pengganti = $db
                    ->query('update', 'htssctd')
                    ->set('transaction_state', 1)
                    ->where('transaction_state',-9)
                    ->where('tanggal', $rs_htscctd['tanggal'])
                    ->where('id_hemxxmh', $rs_htscctd['id_hemxxmh_pengganti'])
                    ->exec();
            } else {
                $qd_pengganti = $db
                    ->raw()
                    ->bind(':tanggal', $rs_htscctd["tanggal"])
                    ->bind(':keterangan', $keterangan)
                    ->bind(':id_hemxxmh_pengganti', $rs_htscctd["id_hemxxmh_pengganti"])
                    ->exec('DELETE FROM htssctd
                            WHERE transaction_state = 1
                                AND id_hemxxmh = :id_hemxxmh_pengganti
                                AND tanggal = :tanggal
                                AND keterangan = :keterangan
                                ;
                ');
            }
        }
        
    
        $db->commit();
        $data = array(
            'message'=> 'Perubahan Jadwal Berhasil Dibuat' , 
            'type_message'=>'success' 
            // 'tanggaljam_awal_t2'=> $rs_testig['tanggaljam_awal_t2'],
            // 'tanggaljam_akhir_t2'=> $rs_testig['tanggaljam_akhir_t2']
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