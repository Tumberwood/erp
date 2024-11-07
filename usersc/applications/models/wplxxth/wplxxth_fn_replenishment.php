<?php	
	/**
	 * Digunakan untuk insert inventory ke iivxxrd
	 */
	include_once( "../../../../users/init.php" );
	include_once( "../../../../usersc/lib/DataTables.php" );
	include_once( "../../../../usersc/helpers/datatables_fn_debug.php" );
	include_once( "../../../../usersc/vendor/autoload.php");
	include_once( "../../../../usersc/helpers/hakakses_s_fn.php" );
	include_once( "../../../helpers/SolusiIndonesiaUtilities.php" );

    use Carbon\Carbon;
	use
        SolusiIndonesia\Utilities\General;
	
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

	if ($movement_method == 1) {
		$orderMethod = ', expired_date ASC';
	} else {
		$orderMethod = '';
	}
	//select di inventory
	$qs_iivxxrd = $db
		->raw()
		->bind(':id_iimxxmh', $id_iimxxmh)
		->bind(':uniqueToken', $uniqueToken)
		->bind(':id_transaksi_h', $id_transaksi_h)
		->exec('SELECT
					:id_transaksi_h,
					ifnull(h.urutan,0) AS urutan,
					b.id AS id_iiv,
					b.id_wloctmh,
					wlpxxmh_kode,
					b.id_iwhxxmh,
					b.id_wloxxmh,
					f.id id_relasi_m,
					a.id_iimxxmh,
					a.id_iumxxmh_unit,
					b.id_iumxxmh_terkecil,
					b.id_iumxxmh_default,
					:uniqueToken,
					iwhxxmh_kode,
					iwhxxmh_nama,
					b.wloxxmh_kode,
					b.wloxxmh_nama,
					f.kode relasi_m_kode,
					f.nama relasi_m_nama,
					b.iimxxmh_kode,
					b.iimxxmh_nama,
					g.kode iumxxmh_unit_kode,
					g.nama iumxxmh_unit_nama,
					curdate() tanggal,
					0, -- is_fisik
					b.iumxxmh_terkecil_kode,
					b.iumxxmh_terkecil_nama,
					b.iumxxmh_default_kode,
					b.iumxxmh_default_nama,
					if(a.jumlah_default > SUM(b.jumlah_default), SUM(b.jumlah_default), a.jumlah_default) jumlah_unit,
					a.jumlah_konversi,
					if(a.jumlah_terkecil > SUM(b.jumlah_terkecil), SUM(b.jumlah_terkecil), a.jumlah_terkecil) jumlah_terkecil_lpn,
					if(a.jumlah_default > SUM(b.jumlah_default), SUM(b.jumlah_default), a.jumlah_default) jumlah_default_lpn,
					
    				-- iiv
					SUM(b.jumlah_default) AS jumlah_unit_iv,
					a.jumlah_konversi,
					SUM(b.jumlah_terkecil) AS jumlah_terkecil_iv,
					SUM(b.jumlah_default) AS jumlah_default_iv,
					max(batch_number) batch_number,
					max(expired_date) as expired_date,
					i.`level` level_loc
				FROM wplittd a
				LEFT JOIN iivxxrd b ON b.id_iimxxmh = a.id_iimxxmh
				LEFT JOIN wplxxth c ON c.id = a.id_wplxxth
				LEFT JOIN iimxxmh d ON d.id = a.id_iimxxmh
				LEFT JOIN grlxxmh f ON f.id = a.id_grlxxmh_customer
				LEFT JOIN iumxxmh g ON g.id = a.id_iumxxmh_unit
				LEFT JOIN wimlotd h ON h.id_iimxxmh = a.id_iimxxmh AND h.id_wloxxmh = b.id_wloxxmh
				LEFT JOIN wloxxmh i ON i.id = b.id_wloxxmh
				WHERE c.id = :id_transaksi_h 
				AND b.keterangan <> :uniqueToken 
				AND a.id_iimxxmh = :id_iimxxmh
				'.$where_wh.' AND b.iimxxmh_status = 1
				AND (
						(c.is_crossdocking = 1 AND b.id_wloctmh IN (1, 3))
						OR
						(c.is_crossdocking <> 1 AND b.id_wloctmh = 3)
					)
				GROUP BY 
					b.id_wloxxmh,
					a.id_iimxxmh,
					wlpxxmh_kode
				HAVING SUM(b.jumlah_terkecil) > 0
				ORDER BY jumlah_terkecil_iv DESC
				'.$orderMethod.'

	');
	$rs_iivxxrd = $qs_iivxxrd->fetchAll();

	// echo $jumlah_terkecil_replenishment;
	// $index_rep = array_search(
	// 	true,
	// 	array_map(
	// 		function ($item) use ($jumlah_terkecil_replenishment) {
	// 			return $item['jumlah_terkecil_iv'] < $jumlah_terkecil_replenishment;
	// 		},
	// 		$rs_iivxxrd
	// 	)
	// );

	$index_replenishment = array_keys(
		array_filter(
			$rs_iivxxrd,
			function ($item) use ($jumlah_terkecil_replenishment) {
				return $item['jumlah_terkecil_iv'] < $jumlah_terkecil_replenishment;
			}
		)
	);

	// if ($index_rep !== false) {
	// 	// Found the index where jumlah_terkecil_iv < 50
	// 	$index_replenishment = $index_rep;
	// } else {
	// 	$index_replenishment = 0;
	// }
	//Aturan Movement Method Order, sesuai master items
	// $movementMethodOrder = function ($a, $b) use ($movement_method, $movement_method2) {
	// 	//Jika movement method pertama adalah FEFO
	// 	if ($movement_method == 1) {
	// 		$dateComparison = strtotime($a['expired_date']) - strtotime($b['expired_date']);

	// 		//jika movement method 2 adalah FIFO
	// 		if ($movement_method2 == 2) {
	// 			if ($dateComparison == 0) {
	// 				// return intval($a['level_loc']) - intval($b['level_loc']);
	// 			}
	// 		}
	// 		return $dateComparison;
	// 	}
	// };

	// usort($rs_iivxxrd, $movementMethodOrder);

	foreach ($rs_iivxxrd as $key => $iiv) {
		//insert ke detail LPN
		// echo $iiv['expired_date'] . '/n';
		$qs_cek_sisa = $db
			->query('select', 'wplittd' )
			->get([
				'jumlah_terkecil',
				'subtotal_jumlah_terkecil',
				'jumlah_unit',
				'subtotal_jumlah_unit',
				'jumlah_default',
				'subtotal_jumlah_default'
			] )
			->where('id', $id_wplittd )
			->exec();
		$rs_cek_sisa = $qs_cek_sisa->fetch();

		//untuk yang subtotal_jumlah, defaultnya 0
		$jumlah_terkecil = $rs_cek_sisa['jumlah_terkecil'];
		$subtotal_jumlah_terkecil = $rs_cek_sisa['subtotal_jumlah_terkecil'];

		$jumlah_unit = $rs_cek_sisa['jumlah_unit'];
		$subtotal_jumlah_unit = $rs_cek_sisa['subtotal_jumlah_unit'];

		$jumlah_default = $rs_cek_sisa['jumlah_default'];
		$subtotal_jumlah_default = $rs_cek_sisa['subtotal_jumlah_default'];

		// print_r($jumlah_terkecil);
		// print_r($iiv['jumlah_terkecil_lpn']);
		$wlpxxmh_kode = $iiv['wlpxxmh_kode'];
		
		// print_r($iiv['jumlah_terkecil_lpn']." - ");
		//jika subtotal di detail item masih belum terpenuhi maka bisa insert data item lpn hasil selectnya
		if ($subtotal_jumlah_terkecil < $jumlah_terkecil) {

			$sisa_terkecil = $jumlah_terkecil - $subtotal_jumlah_terkecil;
			
			if ($iiv['jumlah_terkecil_lpn'] > $sisa_terkecil) {
				$jumlah_terkecil_insert = $sisa_terkecil;
				$jumlah_unit_insert = $jumlah_unit - $subtotal_jumlah_unit;
				$jumlah_default_insert = $jumlah_default - $subtotal_jumlah_default;
			} else {
				// if ($subtotal_jumlah_terkecil > $iiv['jumlah_terkecil_lpn']) {
					//jika jumlah terkecil inventory > dari replenishment, maka dibuat pakai unit replenishment saja
					// if ($iiv['jumlah_terkecil_lpn'] >  $jumlah_terkecil_replenishment) {
					// 	$jumlah_unit_insert = $jumlah_unit_replenishment;
					// 	$jumlah_terkecil_insert = $jumlah_terkecil_replenishment;
					// 	$jumlah_default_insert = $jumlah_default_replenishment;
					// } else {
						$jumlah_unit_insert = $iiv['jumlah_unit'];
						$jumlah_terkecil_insert = $iiv['jumlah_terkecil_lpn'];
						$jumlah_default_insert = $iiv['jumlah_default_lpn'];
					// }
				// } else {
				// 	$jumlah_unit_insert = $iiv['jumlah_unit'] - $subtotal_jumlah_unit;
				// 	$jumlah_terkecil_insert = $iiv['jumlah_terkecil_lpn'] - $subtotal_jumlah_terkecil;
				// 	$jumlah_default_insert = $iiv['jumlah_default_lpn'] - $subtotal_jumlah_default;
				// }
			}
			// print_r($iiv['jumlah_unit']."->");
			// print_r($jumlah_unit_insert."->");

			//Jika jumlah terkecil di iiv kurang dari konversi di uom replenishment
			if ($jumlah_terkecil_insert <  $jumlah_terkecil_replenishment) {
				
				if (!empty($index_replenishment)) {
					if (!in_array($key, $index_replenishment)) {
						// Skip this iteration because the current index is not in $index_replenishment
						continue;
					}
				}

				//select lokasi is_smaller = 1 yang masih avalaible, harus lihat lpn sama dan kapasitas
				$qs_loc_smaller = $db
					->raw()
					->bind(':wlpxxmh_kode', $wlpxxmh_kode)
					->exec('SELECT DISTINCT
								id_wloxxmh,
								loc.id_iwhxxmh,
								loc.wloxxmh_nama,
								loc.wloxxmh_kode
							FROM (
								SELECT 
									id_wloxxmh,
									id_iwhxxmh,
									wloxxmh_nama,
									wloxxmh_kode
								FROM (
									SELECT 
										wimlotd.id_wloxxmh as id_wloxxmh,
										wloxxmh.id_iwhxxmh as id_iwhxxmh,
										wloxxmh.nama as wloxxmh_nama,
										wloxxmh.kode as wloxxmh_kode
									FROM wimlotd
									LEFT JOIN wloxxmh ON wloxxmh.id = wimlotd.id_wloxxmh
									LEFT JOIN 
										iivxxrd ON iivxxrd.id_wloxxmh = wimlotd.id_wloxxmh AND 
										wimlotd.id_iimxxmh = iivxxrd.id_iimxxmh
									WHERE 1
										AND wloxxmh.is_smaller = 1
										AND wimlotd.id_iimxxmh = 
										(
											SELECT 
												wreittd.id_iimxxmh
											FROM wreittd
											WHERE wreittd.wlpxxmh_kode = :wlpxxmh_kode
										)
										AND 
											CASE 
											WHEN wloxxmh.id_iumxxmh_kapasitas = 14 then 
												wimlotd.id_wloxxmh NOT IN ( -- yang location tidak termasuk dalam select dibawah ini
													SELECT -- select lokasi yang sudah masuk storage dan fisik 1 dan jumlah terkecil > 0
														a.id_wloxxmh
													FROM iivxxrd a
													LEFT JOIN iivxxrd rd ON rd.wlpxxmh_kode = :wlpxxmh_kode
													WHERE a.id_wloctmh = 3 AND a.is_fisik = 1 AND a.id_iimxxmh <> rd.id_iimxxmh
													GROUP BY a.id_wloxxmh
													HAVING SUM(a.jumlah_terkecil) > 0 AND COUNT(a.id)
													AND COUNT(a.id) >= (SELECT kapasitas FROM wloxxmh WHERE id = a.id_wloxxmh)
												)
											ELSE 1
										END
										
										AND wimlotd.id_wloxxmh NOT IN 
										(
												SELECT
												c.id_wloxxmh_tujuan
											FROM wreittd a
											LEFT JOIN wimlotd b ON b.id_iimxxmh = a.id_iimxxmh
											LEFT JOIN iivxxrd c ON c.id_iimxxmh = a.id_iimxxmh AND c.id_wloxxmh_tujuan = b.id_wloxxmh
											WHERE a.wlpxxmh_kode = :wlpxxmh_kode  AND c.id_wloxxmh_tujuan > 0
										)
			
									ORDER BY wloxxmh.is_smaller DESC
									-- LIMIT 1
								) location
							) loc
					'
					);

				$rs_loc_smaller = $qs_loc_smaller->fetchAll();

				$ids_wloxxmh = array_column($rs_loc_smaller, 'id_wloxxmh');
				$id_wloxxmh_smaller = '(' . implode(',', $ids_wloxxmh) . ')';

				$id_wloxxmh_now = $iiv['id_wloxxmh'];

				$qs_this_smaller = $db
					->raw()
					->bind(':id_wloxxmh_now', $id_wloxxmh_now)
					->exec('SELECT
								IF(:id_wloxxmh_now IN '.$id_wloxxmh_smaller.', "is_smaller", "is_not_smaller") AS result;
					'
					);

				$rs_this_smaller = $qs_this_smaller->fetch();

				$is_smaller_location = $rs_this_smaller['result'];

				//cek apakah lokasi sekarang ini adalah smaller = 1
				if ($is_smaller_location == "is_not_smaller") {
					//insert ke Item Transfer
					$qi_wtrittd = $db
						->query('insert', 'wtrittd')
						->set('id_wpttpmh',1)
						->set('id_gcpxxmh',1)
						->set('id_gbrxxmh',1)
						->set('is_replenishment',1)
						->set('id_wjtxxmh',4)
						->set('Kode','Replenishment From PL id '.$id_transaksi_h)
						->set('keterangan',$uniqueToken)
						->set('start_at',$timestamp)
						->set('id_iimxxmh',$iiv['id_iimxxmh'])
						->set('id_wloxxmh_asal',$iiv['id_wloxxmh'])
						->set('id_wloxxmh_tujuan',$rs_loc_smaller[0]['id_wloxxmh'])
						->set('id_iwhxxmh',$iiv['id_iwhxxmh'])
						->set('id_iumxxmh_unit',$iiv['id_iumxxmh_unit'])
						->set('id_iumxxmh_terkecil',$iiv['id_iumxxmh_terkecil'])
						->set('id_iumxxmh_default',$iiv['id_iumxxmh_default'])
						->set('jumlah_konversi',$iiv['jumlah_konversi'])
						->set('jumlah_unit',$iiv['jumlah_unit_iv'])
						->set('jumlah_terkecil',$iiv['jumlah_terkecil_iv'])
						->set('jumlah_terkecil_os',$iiv['jumlah_terkecil_iv'])
						->set('jumlah_default',$iiv['jumlah_default_iv'])
						->set('wlpxxmh_kode',$iiv['wlpxxmh_kode'])
						->set('batch_number',$iiv['batch_number'])
						->set('expired_date',$iiv['expired_date'])
					->exec();
					$id_wtrittd = $qi_wtrittd->insertId();

					//insert minus di lokasi inventory sekarang yang bukan smaller
					$qi_replenishment_iiv = $db
						->query('insert', 'iivxxrd')
						->set('id_transaksi_h',$id_transaksi_h)
						->set('id_transaksi_d',$id_wtrittd)
						->set('id_wloctmh',$iiv['id_wloctmh'])
						->set('wlpxxmh_kode',$iiv['wlpxxmh_kode'])
						->set('id_iwhxxmh',$iiv['id_iwhxxmh'])
						->set('id_wloxxmh',$iiv['id_wloxxmh'])
						->set('id_relasi_m',$iiv['id_relasi_m'])
						->set('id_iimxxmh',$iiv['id_iimxxmh'])
						->set('id_iumxxmh_unit',$iiv['id_iumxxmh_unit'])
						->set('id_iumxxmh_terkecil',$iiv['id_iumxxmh_terkecil'])
						->set('id_iumxxmh_default',$iiv['id_iumxxmh_default'])
						->set('keterangan',$uniqueToken)
						->set('iwhxxmh_kode',$iiv['iwhxxmh_kode'])
						->set('iwhxxmh_nama',$iiv['iwhxxmh_nama'])
						->set('wloxxmh_kode',$iiv['wloxxmh_kode'])
						->set('wloxxmh_nama',$iiv['wloxxmh_nama'])
						->set('relasi_m_kode',$iiv['relasi_m_kode'])
						->set('relasi_m_nama',$iiv['relasi_m_nama'])
						->set('iimxxmh_kode',$iiv['iimxxmh_kode'])
						->set('iimxxmh_nama',$iiv['iimxxmh_nama'])
						->set('iumxxmh_unit_kode',$iiv['iumxxmh_unit_kode'])
						->set('iumxxmh_unit_nama',$iiv['iumxxmh_unit_nama'])
						->set('tanggal',$iiv['tanggal'])
						->set('is_fisik',0)
						->set('imtxxmh_kode',211)
						->set('imtxxmh_movement_type','Picking List')
						->set('iumxxmh_terkecil_kode',$iiv['iumxxmh_terkecil_kode'])
						->set('iumxxmh_terkecil_nama',$iiv['iumxxmh_terkecil_nama'])
						->set('iumxxmh_default_kode',$iiv['iumxxmh_default_kode'])
						->set('iumxxmh_default_nama',$iiv['iumxxmh_default_nama'])
						->set('jumlah_unit',-$iiv['jumlah_unit_iv'])
						->set('jumlah_terkecil',-$iiv['jumlah_terkecil_iv'])
						->set('jumlah_default',-$iiv['jumlah_default_iv'])
						->set('jumlah_konversi',$iiv['jumlah_konversi'])
						->set('batch_number',$iiv['batch_number'])
						->set('expired_date',$iiv['expired_date'])
					->exec();

					//Insert Plus di lokasi smaller
					$qi_replenishment_iiv = $db
						->query('insert', 'iivxxrd')
						->set('id_transaksi_h',$id_transaksi_h)
						->set('id_transaksi_d',$id_wtrittd)
						->set('id_wloctmh',$iiv['id_wloctmh'])
						->set('wlpxxmh_kode',$iiv['wlpxxmh_kode'])
						->set('id_iwhxxmh',$iiv['id_iwhxxmh'])
						->set('id_wloxxmh',$rs_loc_smaller[0]['id_wloxxmh'])
						->set('id_relasi_m',$iiv['id_relasi_m'])
						->set('id_iimxxmh',$iiv['id_iimxxmh'])
						->set('id_iumxxmh_unit',$iiv['id_iumxxmh_unit'])
						->set('id_iumxxmh_terkecil',$iiv['id_iumxxmh_terkecil'])
						->set('id_iumxxmh_default',$iiv['id_iumxxmh_default'])
						->set('keterangan',$uniqueToken)
						->set('iwhxxmh_kode',$iiv['iwhxxmh_kode'])
						->set('iwhxxmh_nama',$iiv['iwhxxmh_nama'])
						->set('wloxxmh_kode',$rs_loc_smaller[0]['wloxxmh_kode'])
						->set('wloxxmh_nama',$rs_loc_smaller[0]['wloxxmh_nama'])
						->set('relasi_m_kode',$iiv['relasi_m_kode'])
						->set('relasi_m_nama',$iiv['relasi_m_nama'])
						->set('iimxxmh_kode',$iiv['iimxxmh_kode'])
						->set('iimxxmh_nama',$iiv['iimxxmh_nama'])
						->set('iumxxmh_unit_kode',$iiv['iumxxmh_unit_kode'])
						->set('iumxxmh_unit_nama',$iiv['iumxxmh_unit_nama'])
						->set('tanggal',$iiv['tanggal'])
						->set('is_fisik',0)
						->set('imtxxmh_kode',211)
						->set('imtxxmh_movement_type','Picking List')
						->set('iumxxmh_terkecil_kode',$iiv['iumxxmh_terkecil_kode'])
						->set('iumxxmh_terkecil_nama',$iiv['iumxxmh_terkecil_nama'])
						->set('iumxxmh_default_kode',$iiv['iumxxmh_default_kode'])
						->set('iumxxmh_default_nama',$iiv['iumxxmh_default_nama'])
						->set('jumlah_unit',$iiv['jumlah_unit_iv'])
						->set('jumlah_terkecil',$iiv['jumlah_terkecil_iv'])
						->set('jumlah_default',$iiv['jumlah_default_iv'])
						->set('jumlah_konversi',$iiv['jumlah_konversi'])
						->set('batch_number',$iiv['batch_number'])
						->set('expired_date',$iiv['expired_date'])
					->exec();

					$finish_at = new Carbon();
					General::logChange( $db , 'wtrittd', $s_id_users, $s_username, 'CREATE', $id_wtrittd, "Replenishment From PL id ".$id_transaksi_h, $timestamp , $finish_at );
					// General::logChange( $db , 'wtrittd', $s_id_users, $s_username, 'CONFIRM', $id_wtrittd, "Replenishment From PL id ".$id_transaksi_h, $timestamp , $finish_at );
					
					$id_lokasi_insert = $rs_loc_smaller[0]['id_wloxxmh'];
					$nama_lokasi_insert = $rs_loc_smaller[0]['wloxxmh_nama'];
					$kode_lokasi_insert = $rs_loc_smaller[0]['wloxxmh_kode'];
				} else {
					$id_lokasi_insert = $iiv['id_wloxxmh'];
					$nama_lokasi_insert = $iiv['wloxxmh_nama'];
					$kode_lokasi_insert = $iiv['wloxxmh_kode'];
				}
			} else {
				$id_lokasi_insert = $iiv['id_wloxxmh'];
				$nama_lokasi_insert = $iiv['wloxxmh_nama'];
				$kode_lokasi_insert = $iiv['wloxxmh_kode'];
			}

			//insert detail LPN
			$qi_lpn_d = $db
				->query('insert', 'wpllptd')
				->set('id_wplxxth',$id_transaksi_h)
				->set('id_wjtxxmh',1)
				->set('id_wplittd',$id_wplittd)
				->set('id_iimxxmh',$iiv['id_iimxxmh'])
				->set('id_wloxxmh',$id_lokasi_insert)
				->set('id_iwhxxmh',$iiv['id_iwhxxmh'])
				->set('id_iumxxmh_unit',$iiv['id_iumxxmh_unit'])
				->set('id_iumxxmh_terkecil',$iiv['id_iumxxmh_terkecil'])
				->set('id_iumxxmh_default',$iiv['id_iumxxmh_default'])
				->set('jumlah_konversi',$iiv['jumlah_konversi'])
				->set('jumlah_unit',$jumlah_unit_insert)
				->set('jumlah_terkecil',$jumlah_terkecil_insert)
				->set('jumlah_terkecil_os',$jumlah_terkecil_insert)
				->set('jumlah_default',$jumlah_default_insert)
				->set('wlpxxmh_kode',$iiv['wlpxxmh_kode'])
				->set('wloxxmh_nama',$nama_lokasi_insert)
				->set('batch_number',$iiv['batch_number'])
				->set('expired_date',$iiv['expired_date'])
			->exec();
			$id_lpn_d = $qi_lpn_d->insertId();

			//Update subtotal detail items
			$qu_wplittd = $db
				->raw()
				->bind(':id_wplittd', $id_wplittd)
				->bind(':jumlah_default_insert', $jumlah_default_insert)
				->bind(':jumlah_terkecil_insert', $jumlah_terkecil_insert)
				->bind(':jumlah_unit_insert', $jumlah_unit_insert)
				->exec('UPDATE wplittd a
						SET 
							a.subtotal_jumlah_terkecil = a.subtotal_jumlah_terkecil + :jumlah_terkecil_insert,
							a.subtotal_jumlah_default = a.subtotal_jumlah_default + :jumlah_default_insert,
							a.subtotal_jumlah_unit = a.subtotal_jumlah_unit + :jumlah_unit_insert
						WHERE a.id = :id_wplittd
						;
				
				'
			);
			
			//insert booking iiv is_fisik 0
			$qi_booking_iiv = $db
				->query('insert', 'iivxxrd')
				->set('id_transaksi_h',$id_transaksi_h)
				->set('id_transaksi_d',$id_lpn_d)
				->set('id_wloctmh',$iiv['id_wloctmh'])
				->set('wlpxxmh_kode',$iiv['wlpxxmh_kode'])
				->set('id_iwhxxmh',$iiv['id_iwhxxmh'])
				->set('id_wloxxmh',$id_lokasi_insert)
				->set('id_relasi_m',$iiv['id_relasi_m'])
				->set('id_iimxxmh',$iiv['id_iimxxmh'])
				->set('id_iumxxmh_unit',$iiv['id_iumxxmh_unit'])
				->set('id_iumxxmh_terkecil',$iiv['id_iumxxmh_terkecil'])
				->set('id_iumxxmh_default',$iiv['id_iumxxmh_default'])
				->set('keterangan',$uniqueToken)
				->set('iwhxxmh_kode',$iiv['iwhxxmh_kode'])
				->set('iwhxxmh_nama',$iiv['iwhxxmh_nama'])
				->set('wloxxmh_kode',$kode_lokasi_insert)
				->set('wloxxmh_nama',$nama_lokasi_insert)
				->set('relasi_m_kode',$iiv['relasi_m_kode'])
				->set('relasi_m_nama',$iiv['relasi_m_nama'])
				->set('iimxxmh_kode',$iiv['iimxxmh_kode'])
				->set('iimxxmh_nama',$iiv['iimxxmh_nama'])
				->set('iumxxmh_unit_kode',$iiv['iumxxmh_unit_kode'])
				->set('iumxxmh_unit_nama',$iiv['iumxxmh_unit_nama'])
				->set('tanggal',$iiv['tanggal'])
				->set('is_fisik',0)
				->set('imtxxmh_kode',211)
				->set('imtxxmh_movement_type','Picking List')
				->set('iumxxmh_terkecil_kode',$iiv['iumxxmh_terkecil_kode'])
				->set('iumxxmh_terkecil_nama',$iiv['iumxxmh_terkecil_nama'])
				->set('iumxxmh_default_kode',$iiv['iumxxmh_default_kode'])
				->set('iumxxmh_default_nama',$iiv['iumxxmh_default_nama'])
				->set('jumlah_unit',-$jumlah_unit_insert)
				->set('jumlah_terkecil',-$jumlah_terkecil_insert)
				->set('jumlah_default',-$jumlah_default_insert)
				->set('jumlah_konversi',$iiv['jumlah_konversi'])
				->set('batch_number',$iiv['batch_number'])
				->set('expired_date',$iiv['expired_date'])
			->exec();

			$finish_at = new Carbon();
			General::logChange( $db , 'wpllptd', $s_id_users, $s_username, 'CREATE', $id_lpn_d, "", $timestamp , $finish_at );
			General::logChange( $db , 'wpllptd', $s_id_users, $s_username, 'CONFIRM', $id_lpn_d, "", $timestamp , $finish_at );
		} else {
			// echo $subtotal_jumlah_terkecil;
		}
		
	}
	// build response
	$data = array(
	);

	// tampilkan results
    // include( "../../../../usersc/helpers/fn_ajax_results.php" );
?>