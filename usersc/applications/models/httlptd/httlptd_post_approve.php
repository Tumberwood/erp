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

    $approval_state          = $_POST['approval_state'];
    // print_r($approval_state);
    $id_httlptd = $_POST['id_transaksi'];
    
    try{
        $db->transaction();

		$qs_httlptd = $db
			->query('select', 'httlptd' )
			->get([
				'httlptd.id as id_transaksi',
				'httlptd.jenis as jenis',
				'httlptd.jam_awal as jam_awal',
				'httlptd.jam_akhir as jam_akhir',
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
		
		$jenis = $rs_httlptd['jenis'];
		
		$tanggal_awal  = Carbon::parse($rs_httlptd['tanggal_awal']);
		$tanggal_akhir = Carbon::parse($rs_httlptd['tanggal_akhir']);

		$jumlah_hari = $tanggal_awal->diffInDays($tanggal_akhir) + 1;
		
		$tanggal = $tanggal_awal;

		if($approval_state == 1){

			//Jika Jenis == Harian
			if ($jenis == 1) {
				$tt = '';

				$qs_httlpmh = $db
					->query('select', 'httlpmh' )
					->get(['is_potongcuti'] )
					->where('id', $rs_httlptd['id_httlpmh'] )
					->exec();
				$rs_httlpmh = $qs_httlpmh->fetch();
	
				if ($rs_httlpmh['is_potongcuti'] == 1) {
					$pot_saldo_cuti = -1;
				} else {
					$pot_saldo_cuti = 0;
				}

				for ($x = 0; $x < $jumlah_hari; $x++) {
					$tanggal_ymd = $tanggal;

					$qs_jadwal = $db
						->raw()
						->bind(':tanggal_ymd', $tanggal_ymd)
						->bind(':id_hemxxmh', $rs_httlptd['id_hemxxmh'])
						->exec('SELECT
									DATE_FORMAT(tanggaljam_awal, "%H:%i:%s") AS jam
								FROM htssctd a
								WHERE a.tanggal = :tanggal_ymd AND a.id_hemxxmh = :id_hemxxmh;
						'
						);
				
					$rs_jadwal = $qs_jadwal->fetch();
					$jam = $rs_jadwal['jam'];

					//Jika jadawal Libur, maka tidak diinsert ke report detail httxxrd
					if ($jam != "00:00:00") {
						$qi = $db
							->query('insert', 'httxxrd')
							->set('id_transaksi', $rs_httlptd['id_transaksi'] )
							->set('id_httlpmh', $rs_httlptd['id_httlpmh'] )
							->set('id_hemxxmh', $rs_httlptd['id_hemxxmh'] )
							->set('kode', $rs_httlptd['kode'] )
							->set('approval_state', $approval_state )
							->set('transaction_state', $approval_state )
							->set('tanggal', $tanggal_ymd->format('Y-m-d') )
							->set('keterangan', $rs_httlptd['keterangan'] )
							->set('jenis', $jenis )
							->set('saldo', $pot_saldo_cuti )
							->set('httlpmh_kode', $rs_httlptd['httlpmh_kode'] )
							->set('jumlah', 1 )
							->set('jam_awal', null )
							->set('jam_akhir', null )
							->exec();
					}
					$tt = $tt . ' - ' . $tanggal_ymd->format('Y-m-d');
					$tanggal->add(1, 'days');
				}
				
			} else {
				$qi = $db
				->query('insert', 'httxxrd')
				->set('id_transaksi', $rs_httlptd['id_transaksi'] )
				->set('id_httlpmh', $rs_httlptd['id_httlpmh'] )
				->set('id_hemxxmh', $rs_httlptd['id_hemxxmh'] )
				->set('kode', $rs_httlptd['kode'] )
				->set('approval_state', $approval_state )
				->set('transaction_state', 1 )
				// ->set('tanggal', $tanggal->format('Y-m-d') )
				->set('tanggal', $tanggal )
				->set('keterangan', $rs_httlptd['keterangan'] )
				->set('jenis', $jenis )
				->set('httlpmh_kode', $rs_httlptd['httlpmh_kode'] )
				->set('jumlah', 1 )
				->set('jam_awal', $rs_httlptd['jam_awal'] )
				->set('jam_akhir', $rs_httlptd['jam_akhir'] )
				->exec();
			}

		}elseif($approval_state == -1){
			$qd_httxxrd = $db
				->query('delete', 'httxxrd')
				->where('id_transaksi', $id_httlptd )
				->where('jenis', $jenis )
				->exec();

		}elseif($approval_state == -9){
			$qu_httxxrd = $db
				->query('update', 'httxxrd')
				->set('approval_state', $approval_state)
				->where('id_transaksi', $id_httlptd )
				->where('jenis', $jenis )
				->exec();
			
			$qd_httxxrd = $db
				->query('delete', 'httxxrd')
				->where('id_transaksi', $id_httlptd )
				->where('jenis', $jenis )
				->exec();
		}

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