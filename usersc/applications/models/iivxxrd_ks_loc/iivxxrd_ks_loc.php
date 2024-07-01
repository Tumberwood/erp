<?php
	/**
	 * 
	 */

	include( "../../../../users/init.php" );
	include( "../../../../usersc/lib/DataTables.php" );

	require '../../../../usersc/vendor/autoload.php';
	use Carbon\Carbon;
	
	use
		DataTables\Editor,
		DataTables\Editor\Query,
		DataTables\Editor\Result;

		
	$start_date = new Carbon($_POST['start_date']);
	$end_date = new Carbon($_POST['end_date']);

	$wloxxmh_nama = $_POST['wloxxmh_nama'];

	$results = array();

	if($wloxxmh_nama != ""){
		// BEGIN saldo awal
		$qs_iivxxrd_awal = $db
			->raw()
			->bind(':wloxxmh_nama', $wloxxmh_nama)
			->bind(':start_date', $start_date->format('Y-m-d'))
			->exec('
				SELECT
					DATE_FORMAT("'.$start_date.'","%d %b %Y") as tanggal,
					"SALDO AWAL" as kode,
					"" as iimxxmh_kode,
					"" as iimxxmh_nama,
					"" as wlpxxmh_kode,
					"" as wloxxmh_nama,
					"" as relasi,
					SUM(IF(a.jumlah_terkecil>0,a.jumlah_terkecil,0)) AS jumlah_in,
					SUM(IF(a.jumlah_terkecil<0,a.jumlah_terkecil,0)) AS jumlah_out,
					a.iumxxmh_terkecil_kode,
					MAX(a.confirmed_at) AS confirmed_at,
					"" AS keterangan
				FROM iivxxrd a
				WHERE
					a.jumlah_terkecil <> 0 AND
					a.tanggal < :start_date AND
					a.wloxxmh_nama = :wloxxmh_nama AND
					a.is_fisik > 0
				GROUP BY a.wloxxmh_kode
				ORDER BY a.tanggal asc, a.confirmed_at
			');
		$rs_iivxxrd_awal = $qs_iivxxrd_awal->fetchAll();
		$c_rs_iivxxrd_awal = count($rs_iivxxrd_awal);

		if($c_rs_iivxxrd_awal == 0){

			$rs_iivxxrd_awal[0]['id'] = 0;
			$rs_iivxxrd_awal[0]['tanggal'] = date('d M Y', strtotime("-1 day", strtotime($start_date)));
			$rs_iivxxrd_awal[0]['kode'] = 'SALDO AWAL';
			$rs_iivxxrd_awal[0]['iimxxmh_kode'] = '';
			$rs_iivxxrd_awal[0]['iimxxmh_nama'] = '';
			$rs_iivxxrd_awal[0]['wlpxxmh_kode'] = '';
			$rs_iivxxrd_awal[0]['wloxxmh_nama'] = '';
			$rs_iivxxrd_awal[0]['relasi'] = '';
			$rs_iivxxrd_awal[0]['jumlah_in'] = '';
			$rs_iivxxrd_awal[0]['jumlah_out'] = '';
			$rs_iivxxrd_awal[0]['saldo'] = 0;
			$rs_iivxxrd_awal[0]['iumxxmh_terkecil_kode'] = '';
			$rs_iivxxrd_awal[0]['keterangan'] = '';

		}else{

			$rs_iivxxrd_awal[0]['tanggal'] = date('d M Y', strtotime("-1 day", strtotime($start_date)));
			$rs_iivxxrd_awal[0]['saldo'] = $rs_iivxxrd_awal[0]['jumlah_in'] + $rs_iivxxrd_awal[0]['jumlah_out'];

		}

		$saldo_final = $rs_iivxxrd_awal[0]['saldo'];
		$satuan = $rs_iivxxrd_awal[0]['iumxxmh_terkecil_kode'];
		// END saldo awal

		// BEGIN mutasi
		$qs_iivxxrd_mutasi = $db
			->raw()
			->bind(':wloxxmh_nama', $wloxxmh_nama)
			->bind(':start_date', $start_date)
			->bind(':end_date', $end_date)
			->exec('
				SELECT
					date_format(a.tanggal,"%d %b %Y") as tanggal,
					a.kode as kode,
					a.iimxxmh_kode,
					a.iimxxmh_nama,
					a.wlpxxmh_kode,
					a.wloxxmh_nama,
					a.relasi_m_nama as relasi,
					IF(a.jumlah_terkecil>0,a.jumlah_terkecil,0) AS jumlah_in,
					-IF(a.jumlah_terkecil<0,a.jumlah_terkecil,0) AS jumlah_out,
					a.id_iumxxmh_unit,
					a.id_iumxxmh_terkecil,
					a.confirmed_at,
					a.keterangan
				FROM iivxxrd a
				WHERE
					a.jumlah_terkecil <> 0 AND 
					(a.tanggal BETWEEN :start_date AND :end_date) AND
					a.wloxxmh_nama = :wloxxmh_nama AND
					a.is_fisik > 0
				ORDER BY a.tanggal, a.confirmed_at;
			');
			$rs_iivxxrd_mutasi = $qs_iivxxrd_mutasi->fetchAll();
			$c_rs_iivxxrd_mutasi = count($rs_iivxxrd_mutasi);

			if ($c_rs_iivxxrd_mutasi > 0){
				foreach($rs_iivxxrd_mutasi as $key => $row){
					$rs_iivxxrd_mutasi[$key]['saldo'] = $saldo_final + $row['jumlah_in'] - $row['jumlah_out'] ;
					$saldo_final = $rs_iivxxrd_mutasi[$key]['saldo'];
				}

				$rs_iivxxrd_awal[0]['jumlah_in'] = '';
				$rs_iivxxrd_awal[0]['jumlah_out'] = '';
				
				$results = array_merge($rs_iivxxrd_awal, $rs_iivxxrd_mutasi);
				echo json_encode( ['data' => $results]);
			}else{
				$rs_iivxxrd_awal[0]['jumlah_in'] = '';
				$rs_iivxxrd_awal[0]['jumlah_out'] = '';
				echo json_encode( [ "data" => $rs_iivxxrd_awal ] );
			}
			// END mutasi

	}else{
		echo json_encode( [ "data" => [] ] );
	}
	

	
?>