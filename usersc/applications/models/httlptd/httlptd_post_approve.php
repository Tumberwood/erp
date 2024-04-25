<?php 
    require_once( "../../../../users/init.php" );
	require_once( "../../../../usersc/lib/DataTables.php" );
	require_once( "../../../../usersc/helpers/datatables_fn_debug.php" );

	use
		DataTables\Editor,
		DataTables\Editor\Query,
		DataTables\Editor\Result;
	
	use Carbon\Carbon;
	
    // BEGIN definisi variable untuk fn_ajax_results.php
    $data      = array();
    $rs_opt    = array();
    $c_rs_opt  = 0;
    $morePages = 0;
    // END definisi variable untuk fn_ajax_results.php

    $state          = $_POST['state'];
    // print_r($state);
    $id_httlptd = $_POST['id_transaksi_h'];
    
    try{
        $db->transaction();

		if($state == 1){
			$qs_httlptd = $db
				->query('select', 'httlptd' )
				->get([
					'httlptd.id as id_transaksi',
					'httlptd.id_hemxxmh as id_hemxxmh',
					'httlptd.id_httlpmh as id_httlpmh',
					'httlptd.kode as kode',
					'httlptd.tanggal_awal as tanggal_awal',
					'httlptd.tanggal_akhir as tanggal_akhir',
					'httlptd.keterangan as keterangan',
					'httlpmh.kode as httlpmh_kode'
				] )
				->join('hemxxmh','hemxxmh.id = httlptd.id_hemxxmh','LEFT' )
				->join('httlpmh','httlpmh.id = httlptd.id_httlpmh','LEFT' )
				->where('httlptd.id', $id_httlptd )
				->exec();

			$rs_httlptd = $qs_httlptd->fetch();
			
			$tanggal_awal  = Carbon::parse($rs_httlptd['tanggal_awal']);
			$tanggal_akhir = Carbon::parse($rs_httlptd['tanggal_akhir']);

			$jumlah_hari = $tanggal_awal->diffInDays($tanggal_akhir) + 1;
			
			$tanggal = $tanggal_awal;
			$tt = '';
			for ($x = 0; $x < $jumlah_hari; $x++) {
				$tanggal_ymd = $tanggal;
				$qi = $db
					->query('insert', 'httxxrd')
					->set('id_transaksi', $rs_httlptd['id_transaksi'] )
					->set('id_httlpmh', $rs_httlptd['id_httlpmh'] )
					->set('id_hemxxmh', $rs_httlptd['id_hemxxmh'] )
					->set('kode', $rs_httlptd['kode'] )
					->set('approval_state', $state )
					->set('transaction_state', $state )
					->set('tanggal', $tanggal_ymd->format('Y-m-d') )
					->set('keterangan', $rs_httlptd['keterangan'] )
					->set('jenis', 1 )
					->set('httlpmh_kode', $rs_httlptd['httlpmh_kode'] )
					->set('jumlah', 1 )
					->set('jam_awal', null )
					->set('jam_akhir', null )
					->exec();
				$tt = $tt . ' - ' . $tanggal_ymd->format('Y-m-d');
				$tanggal->add(1, 'days');
			}
			
			$qs_httlpmh = $db
				->query('select', 'httlpmh' )
				->get(['is_potongcuti'] )
				->where('id', $rs_httlptd['id_httlpmh'] )
				->exec();
			$rs_httlpmh = $qs_httlpmh->fetch();

			if ($rs_httlpmh['is_potongcuti'] == 1) {
				$qi_sisa_saldo = $db
					->raw()
					->bind(':id_hemxxmh', $rs_httlptd['id_hemxxmh'])
					->bind(':id_transaksi', $rs_httlptd['id_transaksi'])
					->bind(':tanggal_awal', $tanggal_awal)
					->exec(' INSERT INTO httxxrd (
								id_transaksi,
								transaction_state,
								id_hemxxmh,
								nama,
								tanggal,
								saldo
							)
							SELECT
								:id_transaksi,
								1,
								a.id_hemxxmh,
								"sisa saldo cuti",
								:tanggal_awal,
								SUM(
									CASE
										WHEN ifnull(a.saldo, 0) > 0 THEN ifnull(a.saldo, 0) - (COALESCE(cb.c_cb, 0))
										ELSE 0
									END
								) AS sisa_saldo
							FROM httxxrd AS a
							-- employee
							LEFT JOIN hemxxmh AS peg ON peg.id = a.id_hemxxmh
							LEFT JOIN hemjbmh AS jb ON jb.id_hemxxmh = peg.id
							-- Izin yang memotong Cuti
							LEFT JOIN (
								SELECT
									rh.id_hemxxmh,
									COUNT(rh.id) AS c_cb
								FROM httxxrd AS rh
								LEFT JOIN httlpmh AS mh ON mh.id = rh.id_httlpmh
								WHERE YEAR(rh.tanggal) = YEAR(:tanggal_awal) AND rh.jenis = 1 AND mh.is_potongcuti = 1 AND DAY(rh.tanggal) <> 7
								GROUP BY rh.id_hemxxmh
							) AS cb ON cb.id_hemxxmh = a.id_hemxxmh
							
							WHERE YEAR(a.tanggal) = YEAR(:tanggal_awal) AND jb.is_checkclock = 1 AND a.nama = "saldo" AND a.id_hemxxmh = :id_hemxxmh
							'
				);
			}

		}elseif($state == -1){
			$qd_httxxrd = $db
				->query('delete', 'httxxrd')
				->where('id_transaksi', $id_httlptd )
				->where('jenis', 1 )
				->exec();

			$qd_httxxrd = $db
				->query('delete', 'httxxrd')
				->where('id_transaksi', $id_httlptd )
				->where('nama', "sisa saldo cuti" )
				->exec();

		}elseif($state == -9){
			$qu_httxxrd = $db
				->query('update', 'httxxrd')
				->set('approval_state', $state)
				->where('id_transaksi', $id_httlptd )
				->where('jenis', 1 )
				->exec();
			
			$qd_httxxrd = $db
				->query('delete', 'httxxrd')
				->where('id_transaksi', $id_httlptd )
				->where('jenis', 1 )
				->exec();

			$qd_httxxrd = $db
				->query('delete', 'httxxrd')
				->where('id_transaksi', $id_httlptd )
				->where('nama', "sisa saldo cuti" )
				->exec();
		}

        //Update Approval state manual
        $qu_httgltd = $db
            ->query('update', 'httlptd')
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