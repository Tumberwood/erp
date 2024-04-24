<?php 
    /**
     * Digunakan untuk INSERT data hari libur nasional httphtd ke table httxxrd
     * Notes:
     *  Masih kurang where karyawan yang aktif berdasarkan tanggal resign
     */
    require_once( "../../../../users/init.php" );
	require_once( "../../../../usersc/lib/DataTables.php" );
	require_once( "../../../../usersc/helpers/datatables_fn_debug.php" );

    // BEGIN definisi variable untuk fn_ajax_results.php
    $data      = array();
    $rs_opt    = array();
    $c_rs_opt  = 0;
    $morePages = 0;
    // END definisi variable untuk fn_ajax_results.php

    $state          = $_POST['state'];

    try{
        $db->transaction();

        $qs_httphtd = $db
            ->query('select', 'httphtd' )
            ->get([
                'httphtd.tanggal as tanggal',
                'httphtd.kode as kode',
                'httphtd.nama as nama'
            ] )
            ->where('httphtd.id', $_POST['id_transaksi_h'] )
            ->exec();
        $rs_httphtd = $qs_httphtd->fetch();
        
        if ($state == 1) {
            // BEGIN non aktif
            $qd_terpilih = $db
                ->query('delete', 'htssctd')
                ->where('transaction_state', -9)
                ->where('tanggal', $rs_httphtd["tanggal"])
            ->exec();
    
            $tanggal_jam_off = $rs_httphtd["tanggal"] . " 00:00:00";
    
            //Dilakukan Non Aktif jadwal selain satpam
            $qu_htssctd = $db
            ->raw()
            ->bind(':keterangan', $rs_httphtd["nama"])
            ->bind(':tanggal', $rs_httphtd["tanggal"])
            ->exec('UPDATE htssctd AS a
                    SET
                        a.transaction_state = -9,
                        a.keterangan = CONCAT("Public Holiday - ", :keterangan)
                    WHERE 
                        tanggal = :tanggal
                        AND a.transaction_state = 1
                        ;
            ');
            
            $qr_tanggal = $db
                ->raw()
                ->bind(':tanggal', $rs_httphtd["tanggal"])
                ->bind(':nama', $rs_httphtd["nama"])
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
                        CONCAT("Public Holiday - ", :nama),
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
                    AND keterangan = CONCAT("Public Holiday - ", :nama) AND jb.id_hetxxmh NOT IN (99, 48)
                ');
            // END insert pengaju

        } else if($state == -1) {
            $qd_pengganti = $db
                ->raw()
                ->bind(':tanggal', $rs_httphtd["tanggal"])
                ->bind(':nama', $rs_httphtd["nama"])
                ->exec(' DELETE FROM htssctd
                        WHERE transaction_state = 1
                            AND tanggal = :tanggal
                            AND keterangan = CONCAT("Public Holiday - ", :nama)
                            ;
                    ');
            
            $qu_htssctd = $db
                ->query('update', 'htssctd')
                ->set('transaction_state', 1)
                ->where('transaction_state',-9)
                ->where('tanggal', $rs_httphtd["tanggal"])
            ->exec();
        }

        
            //Update Approval state manual
            $qu_httgltd = $db
                ->query('update', 'httphtd')
                ->set('approval_state',$state)
                ->where('id',$_POST['id_transaksi_h'])
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