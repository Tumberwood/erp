<?php
    /**
     * tes case SLO/2305/0082
     */
    require_once( "../../../../users/init.php" );
    require_once( "../../../../usersc/lib/DataTables.php" );
    require_once( "../../../../usersc/helpers/datatables_fn_debug.php" );

    require '../../../../usersc/vendor/autoload.php';
	use Carbon\Carbon;

    // BEGIN definisi variable untuk fn_ajax_results.php
    $data      = array();
    $rs_opt    = array();
    $c_rs_opt  = 0;
    $morePages = 0;
    // END definisi variable untuk fn_ajax_results.php

    $id_transaksi = $_POST['id_transaksi'];
    $approval_state = $_POST['approval_state'];

    try{
        $db->transaction();
        // BEGIN ambil data htoemtd
        $qs_htoemtd = $db
            ->raw()
            ->bind(':id_transaksi', $id_transaksi)
            ->exec('SELECT
                        htoemtd.id_hemxxmh AS id_hemxxmh,
                        htoxxth.id AS id_htoxxth,
                        htoemtd.id AS id_htoemtd,
                        htoemtd.id_htotpmh AS id_htotpmh,
                        htoxxth.kode AS kode,
                        htoxxth.tanggal AS tanggal,
                        htoxxth.approval_state AS approval_state,
                        htoemtd.is_istirahat AS is_istirahat,
                        htoemtd.jam_awal AS jam_awal,
                        htoemtd.jam_akhir AS jam_akhir,
                        htoemtd.durasi_lembur_jam AS durasi_lembur_jam,
                        htoemtd.durasi_lembur_menit AS durasi_lembur_menit,
                        hemjbmh.id_hesxxmh AS id_hesxxmh
                    FROM htoemtd
                    LEFT JOIN htoxxth ON htoxxth.id = htoemtd.id_htoxxth
                    LEFT JOIN hemjbmh ON hemjbmh.id_hemxxmh = htoemtd.id_hemxxmh
                    WHERE htoemtd.transaction_state = 1
                        AND htoxxth.transaction_state = 1
                        AND htoxxth.id = :id_transaksi;
                    '
                    );
        $rs_htoemtd = $qs_htoemtd->fetchAll();
        // END ambil data htoemtd
        if($approval_state == 1){

            foreach ($rs_htoemtd as $row_htoemtd) {
                $durasi_lembur_menit = $row_htoemtd['durasi_lembur_jam'] * 60;
                // INSERT htoxxrd
                $qi_htoxxrd = $db
                    ->query('insert', 'htoxxrd')
                    ->set( 'id_hemxxmh', $row_htoemtd['id_hemxxmh'] )
                    ->set( 'id_htoxxth', $row_htoemtd['id_htoxxth'] )
                    ->set( 'id_htoemtd', $row_htoemtd['id_htoemtd'] )
                    ->set( 'id_htotpmh', $row_htoemtd['id_htotpmh'] )
                    ->set( 'kode', $row_htoemtd['kode'] ) 
                    ->set( 'transaction_state', 1 ) 
                    ->set( 'approval_state', 1 ) 
                    ->set( 'tanggal', $row_htoemtd['tanggal'] )
                    ->set( 'jam_awal', $row_htoemtd['jam_awal'] )
                    ->set( 'jam_akhir', $row_htoemtd['jam_akhir'] )
                    ->set( 'durasi_lembur_jam', $row_htoemtd['durasi_lembur_jam'] )
                    ->set( 'durasi_lembur_menit', $durasi_lembur_menit )
                    ->set( 'is_istirahat', $row_htoemtd['is_istirahat'] )
                    ->exec();
            }
        
        } else {
            // print_r($id_transaksi);
            $qd_htoxxrd = $db
                ->query('delete', 'htoxxrd')
                ->where('id_htoxxth', $id_transaksi )
                ->exec();
        }

        $db->commit();
        $data = array(
            'message'=> 'Data Berhasil Di Insert' , 
            'type_message'=>'success' 
        );
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