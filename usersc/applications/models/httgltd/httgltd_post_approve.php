<?php 
    require_once( "../../../../users/init.php" );
	require_once( "../../../../usersc/lib/DataTables.php" );
	require_once( "../../../../usersc/helpers/datatables_fn_debug.php" );

	use
		DataTables\Editor,
		DataTables\Editor\Query,
		DataTables\Editor\Result;

    // BEGIN definisi variable untuk fn_ajax_results.php
    $data      = array();
    $rs_opt    = array();
    $c_rs_opt  = 0;
    $morePages = 0;
    // END definisi variable untuk fn_ajax_results.php

    $approval_state          = $_POST['approval_state'];
    // print_r($approval_state);
    // print_r($_POST['id_transaksi']);
    
    try{
        $db->transaction();

        $qs_httgltd = $db
            ->query('select', 'httgltd' )
            ->get([
                'httgltd.tanggal as tanggal',
                'httgltd.kode as kode',
                'httgltd.nama as nama'
            ] )
            ->where('httgltd.id', $_POST['id_transaksi'] )
            ->exec();
        $rs_httgltd = $qs_httgltd->fetch();

        $where_kecuali = '';
		$qs_kecuali = $db
            ->raw()
            ->bind(':id_h', $_POST['id_transaksi'])
            ->exec('SELECT
                        a.id,
                        a.tanggal,
                        a.kode,
                        a.nama,
                        CONCAT("id_", b.nama_tabel) AS nama_id_transaksi,
                        GROUP_CONCAT(b.id_transaksi ORDER BY b.id_transaksi) AS id_transaksi_concat,
                        CONCAT(" AND id_", b.nama_tabel, " NOT IN (", GROUP_CONCAT(b.id_transaksi ORDER BY b.id_transaksi), ") ") AS where_not_in
                    FROM httgltd a
                    LEFT JOIN httgltd_d b ON b.id_httgltd = a.id
                    WHERE a.id = :id_h
                    GROUP BY a.id, a.tanggal, a.kode, a.nama, b.nama_tabel;
            '
            );

        $rs_kecuali = $qs_kecuali->fetchAll();
        foreach ($rs_kecuali as $key => $kecuali) {
            $where_kecuali .= $kecuali['where_not_in'];
        }
        // print_r($where_kecuali);

        if ($approval_state == 1) {
            
            // BEGIN non aktif
            $qd_terpilih = $db
                ->query('delete', 'htssctd')
                ->where('transaction_state', -9)
                ->where('tanggal', $rs_httgltd["tanggal"])
            ->exec();
    
            $tanggal_jam_off = $rs_httgltd["tanggal"] . " 00:00:00";
    
            $qu_htssctd = $db
            ->raw()
            ->bind(':keterangan', $rs_httgltd["nama"])
            ->bind(':tanggal', $rs_httgltd["tanggal"])
            ->exec('UPDATE htssctd AS a
                LEFT JOIN hemjbmh AS jb on jb.id_hemxxmh = a.id_hemxxmh
                SET
                    a.transaction_state = -9,
                    a.keterangan = CONCAT("Cuti Bersama - ", :keterangan)
                WHERE 
                    a.transaction_state = 1
                '.$where_kecuali.'
                AND a.tanggal = :tanggal
            ');

            // Begin insert pengaju
            $qr_tanggal = $db
                ->raw()
                ->bind(':tanggal', $rs_httgltd["tanggal"])
                ->bind(':nama', $rs_httgltd["nama"])
                ->bind(':tanggal_jam_off', $tanggal_jam_off)
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
                    SELECT DISTINCT
                        1,
                        CONCAT("Cuti Bersama - ", :nama),
                        :tanggal,
                        htssctd.id_hemxxmh,

                        :tanggal_jam_off,
                        :tanggal_jam_off,
                        :tanggal_jam_off,
                        :tanggal_jam_off,
                        :tanggal_jam_off,
                        :tanggal_jam_off,
                        :tanggal_jam_off,
                        :tanggal_jam_off
                       
                    FROM htssctd
                    LEFT JOIN hemjbmh AS jb on jb.id_hemxxmh = htssctd.id_hemxxmh
                    WHERE 
                        tanggal = :tanggal
                    '.$where_kecuali.'
                    AND keterangan = CONCAT("Cuti Bersama - ", :nama) 
                ');
            // END insert pengaju

            // Update Untuk mendapatkan flag
            // $qu_tanggal = $db
            //     ->raw()
            //     ->bind(':tanggal', $rs_httgltd["tanggal"])
            //     ->exec('UPDATE htssctd AS jad
            //             LEFT JOIN 
            //             (
            //                 SELECT
            //                     a.id_hemxxmh,
            //                     "sisa saldo cuti",
            //                     :tanggal,
            //                     SUM(
            //                         CASE
            //                             WHEN ifnull(a.saldo, 0) > 0 THEN ifnull(a.saldo, 0) - (COALESCE(cb.c_cb, 0) + IFNULL(c_rd,0))
            //                             ELSE 0
            //                         END
            //                     ) AS sisa_saldo
            //                 FROM httxxrd AS a
            //                 -- employee
            //                 LEFT JOIN hemxxmh AS peg ON peg.id = a.id_hemxxmh
            //                 LEFT JOIN hemjbmh AS jb ON jb.id_hemxxmh = peg.id
            //                 -- Izin yang memotong Cuti
            //                 LEFT JOIN (
            //                     SELECT
            //                         rh.id_hemxxmh,
            //                         COUNT(rh.id) AS c_cb
            //                     FROM httxxrd AS rh
            //                     LEFT JOIN httlpmh AS mh ON mh.id = rh.id_httlpmh
            //                     WHERE YEAR(rh.tanggal) = YEAR(:tanggal) AND rh.jenis = 1 AND mh.is_potongcuti = 1
            //                     GROUP BY rh.id_hemxxmh
            //                 ) AS cb ON cb.id_hemxxmh = a.id_hemxxmh
                            
            //                 LEFT JOIN (
            //                     SELECT
            //                         a.id AS id_presensi,
            //                         id_hemxxmh,
            //                         COUNT(a.id) AS c_rd
            //                     FROM htsprrd AS a
            //                     WHERE YEAR(a.tanggal) = YEAR(:tanggal) AND a.status_presensi_in = "AL"
            //                     GROUP BY id_hemxxmh
            //                 ) AS rd ON rd.id_hemxxmh = a.id_hemxxmh
                            
            //                 WHERE YEAR(a.tanggal) = YEAR(:tanggal) AND jb.is_checkclock = 1 AND a.nama = "saldo"
            //                 GROUP BY a.id_hemxxmh
            //             ) AS sal ON sal.id_hemxxmh = jad.id_hemxxmh
            //             LEFT JOIN hemjbmh AS jb ON jb.id_hemxxmh = jad.id_hemxxmh
            //             SET 
            //                 jad.is_pot_hk = 
            //                     case 
            //                         when ifnull(sisa_saldo,0) = 0 AND jad.jam_awal <> "00:00:00" then 1
            //                         when ifnull(sisa_saldo,0) = 0 AND jad.keterangan LIKE "%cuti bersama%" then 1
            //                     ELSE 0
            //                     END ,
            //                 jad.is_pot_cuti = if(IFNULL(sisa_saldo,0) > 0 AND jad.keterangan LIKE "%cuti bersama%", 1, 0)
            //             WHERE jad.tanggal = :tanggal
            //             AND jad.transaction_state = 1;
            //     ');
            //End flag is_pot_hk dan is_pot_cuti

            //Delete Absen Hari, pada tanggal Cuti, karena akan digantikan sama CB Cuti Bersama
            $qd_absen_lama_same_day = $db
            ->raw()
            ->bind(':tanggal', $rs_httgltd["tanggal"])
            ->exec('DELETE FROM httxxrd
                    WHERE tanggal = :tanggal
                    AND id_hemxxmh IN (
                        SELECT
                            hem.id
                        FROM hemxxmh hem
                        LEFT JOIN hemjbmh jb ON jb.id_hemxxmh = hem.id
                        WHERE hem.transaction_state <> -9 
                        '.$where_kecuali.'
                    )
            ');
            
            //INI TETAP DIINSERT
            $qr_htsprrd = $db
                ->raw()
                ->bind(':tanggal', $rs_httgltd["tanggal"])
                ->exec('
                    INSERT INTO httxxrd
                        (
                            transaction_state,
                            id_transaksi,
                            id_htlgrmh,
                            id_httlpmh,
                            id_hemxxmh,
                            kode,
                            tanggal,
                            keterangan,
                            jenis,
                            httlpmh_kode,
                            htlgrmh_kode,
                            jumlah,
                            jam_awal,
                            jam_akhir
                        )
                    SELECT
                        1,
                        ' . $_POST['id_transaksi'] . ',
                        3,
                        4,
                        hem.id,
                        "'.$rs_httgltd["kode"].'",
                        "'.$rs_httgltd["tanggal"].'",
                        "'.$rs_httgltd["nama"].'",
                        1,
                        "C",
                        "C",
                        1,
                        null,
                        null
                        FROM
                            htssctd AS a
                        LEFT JOIN hemxxmh AS hem ON hem.id = a.id_hemxxmh
                        LEFT JOIN hemjbmh AS jb ON jb.id_hemxxmh = hem.id
                        WHERE 
                            a.transaction_state = 1
                        '.$where_kecuali.'
                        AND a.tanggal = :tanggal
                        -- AND a.is_pot_cuti = 1
                ');
            // BEGIN non aktif

        } else {
            $qd_htl = $db
                ->query('delete', 'httxxrd')
                ->where('tanggal', $rs_httgltd["tanggal"])
                ->where('kode', $rs_httgltd["kode"])
                ->where('keterangan', $rs_httgltd["nama"])
            ->exec();

            $qd_pengganti = $db
                ->raw()
                ->bind(':tanggal', $rs_httgltd["tanggal"])
                ->bind(':nama', $rs_httgltd["nama"])
                ->exec(' DELETE FROM htssctd
                        WHERE transaction_state = 1
                            AND tanggal = :tanggal
                            AND keterangan = CONCAT("Cuti Bersama - ", :nama)
                            ;
                    ');
            
            $qu_htssctd = $db
                ->query('update', 'htssctd')
                ->set('transaction_state', 1)
                ->set('keterangan', "")
                ->where('transaction_state',-9)
                ->where('tanggal', $rs_httgltd["tanggal"])
            ->exec();
        }

        //Update Approval approval_state manual
        $qu_httgltd = $db
            ->query('update', 'httgltd')
            ->set('transaction_state',1)
            ->set('approval_state',$approval_state)
            ->where('id',$_POST['id_transaksi'])
            ->exec();

        $db->commit();
        $data = array(
            'message'=> 'Data Berhasil Di Insert' , 
            'type_message'=>'success' )
        ;
    }catch(PDOException $e){
        // rollback on error
        $db->rollback();
        $data = array(
            'message'=>'Data Gagal Di Insert', 
            'type_message'=>'danger' 
        );
    }
   
    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>