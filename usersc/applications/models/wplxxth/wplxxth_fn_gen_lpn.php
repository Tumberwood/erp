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

	$json['hakakses'] = $hakakses;
	$s_id_users = $hakakses['s_id_users'];
	$s_username = $hakakses['s_username'];

	try{
		$db->transaction();

		$id_transaksi_h    = $_POST['id_transaksi_h'];
		$uniqueToken    = $_POST['uniqueToken'];
		$timestamp    = $_POST['timestamp'];
		$pesan = "";

		function cekDataNotif($db, &$pesan, $id_wplittd){
			$qs_valid = $db
				->raw()
				->bind(':id_wplittd', $id_wplittd)
				->exec('SELECT
							a.id_wloctmh,
							e.id_iimxxmh item_pl,
							f.nama customer,
							f.batas_expired_date,
							if(max(expired_date) >= DATE_ADD(CURDATE(), INTERVAL if(f.batas_expired_date = 0, 0, f.batas_expired_date) MONTH), 1, 0) is_valid_ed,
							a.iwhxxmh_kode,
							a.wloxxmh_nama,
							a.iimxxmh_kode,
							a.iimxxmh_nama,
							a.iumxxmh_default_kode,
							a.iumxxmh_terkecil_kode,
							SUM(a.jumlah_default * is_fisik) as jumlah_default,
							SUM(a.jumlah_terkecil * is_fisik) as jumlah_terkecil,
							ifnull(jumlah_default_booking,0) as jumlah_default_booking,
							ifnull(jumlah_terkecil_booking,0) as jumlah_terkecil_booking,
							(SUM(a.jumlah_default * is_fisik)) - ifnull(jumlah_default_booking,0) as jumlah_default_ava,
							(SUM(a.jumlah_terkecil * is_fisik)) - ifnull(jumlah_terkecil_booking,0) as jumlah_terkecil_ava,
							a.wlpxxmh_kode,
							max(batch_number) batch_number,
							max(date_format(expired_date,"%d %b %Y")) as expired_date
						FROM iivxxrd a
						LEFT JOIN (
							SELECT
								wloxxmh_nama,
								iimxxmh_kode,
								SUM(jumlah_default) * -1 as jumlah_default_booking,
								SUM(jumlah_terkecil) * -1 as jumlah_terkecil_booking,
								wlpxxmh_kode
							FROM iivxxrd
							WHERE tanggal <= curdate() AND is_fisik = 0
							GROUP BY 
								-- id_gbrxxmh, 
								id_iwhxxmh,
								id_iimxxmh,
								id_wloxxmh,
								wlpxxmh_kode
						) AS b ON b.wloxxmh_nama = a.wloxxmh_nama AND b.iimxxmh_kode = a.iimxxmh_kode AND b.wlpxxmh_kode = a.wlpxxmh_kode
						
						LEFT JOIN wplittd e ON e.id = :id_wplittd
						LEFT JOIN grlxxmh f ON f.id = e.id_grlxxmh_customer
						LEFT JOIN wplxxth g ON g.id = e.id_wplxxth
						WHERE a.tanggal <= curdate()
						AND 
						(
							(g.is_crossdocking = 1 AND a.id_wloctmh IN (1, 3))
							OR
							(g.is_crossdocking <> 1 AND a.id_wloctmh = 3)
						)
						GROUP BY 
							-- id_gbrxxmh, 
							a.id_iwhxxmh,
							a.id_iimxxmh,
							a.id_wloxxmh,
							a.wlpxxmh_kode
						having jumlah_terkecil > 0  
						AND id_iimxxmh = item_pl
						ORDER BY expired_date DESC
			');
			
			$rs_valid = $qs_valid->fetchAll();

			$qs_det = $db
				->raw()
				->bind(':id_wplittd', $id_wplittd)
				->exec('SELECT
							CONCAT(b.kode, " - ", b.nama) item
						FROM wplittd a
						LEFT JOIN iimxxmh b ON b.id = a.id_iimxxmh
						WHERE a.id = :id_wplittd
			');
			
			$rs_det = $qs_det->fetch();

			$keterangan_validasi = '';
			if (empty($rs_valid)) {
				$keterangan_validasi = 'Item '.$rs_det['item']. ' <b>Kosong atau tidak ditemukan di Inventory';
				$pesan .= '<br>'.$keterangan_validasi. '</b><br>';
			} else {
				$sum_is_valid_ed = 0;
				foreach ($rs_valid as $row) {
					$sum_is_valid_ed += (int)$row['is_valid_ed'];
				}

				if ($sum_is_valid_ed == 0) {
					$keterangan_validasi = $rs_valid[0]['customer'] .' - Item '.$rs_det['item']. ' <b>Tidak bisa terpenuhi karena batas Expired Date';
					$pesan .= '<br>'.$keterangan_validasi. '</b><br>';
				}
			}
			
			$qu_wplittd = $db
			->query('update', 'wplittd')
			->set('keterangan', $keterangan_validasi)
			->where('id',$id_wplittd)
			->exec();
		}

		$qs_ggswmsh = $db
			->query('select', 'ggswmsh' )
			->get([
				'is_replenishment',
				'is_koordinat',
			] )
			->where('id', 1 )
			->exec();
		$rs_ggswmsh = $qs_ggswmsh->fetch();
		$is_replenishment = $rs_ggswmsh['is_replenishment'];
		$is_koordinat = $rs_ggswmsh['is_koordinat'];

		$qs_wplxxth = $db
			->query('select', 'wplxxth' )
			->get([
					'is_all_wh'
				] )
			->where('id', $id_transaksi_h )
			->exec();
		$rs_wplxxth = $qs_wplxxth->fetch();
		$is_all_wh = $rs_wplxxth['is_all_wh'];

		if ($is_all_wh == 1) {
			$where_wh = '';
		} else {
			$where_wh = 'AND b.id_iwhxxmh = c.id_iwhxxmh';
		}
		
		$qs_items = $db
			->query('select', 'wplittd a' )
			->get([
				'a.id as id_wplittd',
				'id_iimxxmh',
				'id_iumxxmh_unit',
				'movement_method',
				'movement_method2'
			] )
			->join('iimxxmh','iimxxmh.id = a.id_iimxxmh','LEFT' )
			->where('id_wplxxth', $id_transaksi_h )
			->exec();
		$rs_items = $qs_items->fetchAll();

		if ($is_replenishment == 1) {
			foreach ($rs_items as $key => $item) {
				$id_wplittd = $item['id_wplittd'];
				$id_iimxxmh = $item['id_iimxxmh'];
				$id_iumxxmh_unit = $item['id_iumxxmh_unit'];
				$movement_method = $item['movement_method'];
				$movement_method2 = $item['movement_method2'];

				cekDataNotif($db, $pesan, $id_wplittd);

				//ambil 
				$qs_uom_replenishment = $db
					->raw()
					->bind(':id_iimxxmh', $id_iimxxmh)
					->bind(':id_iumxxmh_unit', $id_iumxxmh_unit)
					->exec('SELECT
								a.id_iumxxmh id_uom_replenishment,
								b.id_iumxxmh id_uom_def,
								a.jumlah_konversi / b.jumlah_konversi jumlah_default_replenishment,
								a.jumlah_konversi jumlah_terkecil_replenishment,
								a.jumlah_konversi / c.jumlah_konversi jumlah_unit_replenishment
							FROM iimummd a
							LEFT JOIN iimummd b ON b.id_iimxxmh = a.id_iimxxmh AND b.is_default = 1
							LEFT JOIN iimummd c ON c.id_iimxxmh = a.id_iimxxmh AND c.id_iumxxmh = :id_iumxxmh_unit
							WHERE a.id_iimxxmh = :id_iimxxmh AND a.is_replenishment = 1
					'
					);

				$rs_uom_replenishment = $qs_uom_replenishment->fetch();
				$jumlah_unit_replenishment = $rs_uom_replenishment['jumlah_unit_replenishment'];
				$jumlah_default_replenishment = $rs_uom_replenishment['jumlah_default_replenishment'];
				$jumlah_terkecil_replenishment = $rs_uom_replenishment['jumlah_terkecil_replenishment'];

				include "wplxxth_fn_replenishment.php";

				// $qs_cek_os = $db
				// 	->query('select', 'wplittd' )
				// 	->get([
				// 		'jumlah_terkecil',
				// 		'subtotal_jumlah_terkecil',
				// 		'jumlah_unit',
				// 		'subtotal_jumlah_unit',
				// 		'jumlah_default',
				// 		'subtotal_jumlah_default'
				// 	] )
				// 	->where('id', $id_wplittd )
				// 	->exec();
				// $rs_cek_os = $qs_cek_os->fetch();

				// $terkecil_item_os = $rs_cek_os['jumlah_terkecil'] - $rs_cek_os['subtotal_jumlah_terkecil'];
				// if ($terkecil_item_os > 0) {
				// 	include "wplxxth_fn_replenishment.php";
				// }
			}
		} else {
			//Bukan Replenishment
			foreach ($rs_items as $key => $item) {
				$id_wplittd = $item['id_wplittd'];
				$id_iimxxmh = $item['id_iimxxmh'];
				$movement_method = $item['movement_method'];
				$movement_method2 = $item['movement_method2'];

				
				cekDataNotif($db, $pesan, $id_wplittd);

				//select di inventory
				$qs_iivxxrd = $db
					->raw()
					->bind(':id_wplittd', $id_wplittd)
					->bind(':id_iimxxmh', $id_iimxxmh)
					->bind(':uniqueToken', $uniqueToken)
					->bind(':id_transaksi_h', $id_transaksi_h)
					->exec('SELECT
								:id_transaksi_h,
								a.id_grlxxmh_customer,
								tujuan.id_wloznmh,
								if(is_koordinat = 0, 
									ifnull(h.urutan,0), -- kalo urutan maka ambil dari urutan di loc pref
									ABS(tujuan.koord_x - asal.koord_x) + ABS(tujuan.koord_y - asal.koord_y) + (ABS(tujuan.koord_z - asal.koord_z) * koefisien_level)
								) urutan,
								max(b.id) id_iivxxrd,
								(
							        SELECT a_inner.iimxxmh_status
							        FROM iivxxrd a_inner
							        WHERE a_inner.id = MAX(b.id) -- Correlates with the outer query
							    ) AS iimxxmh_status_max_id,
								id_iiv_fifo AS id_iiv,
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
								max(batch_number) batch_number,
								max(expired_date) as expired_date,
								CASE 
									WHEN c.is_packing = 1 THEN
									(
										SELECT
											wpk.id
										FROM wpkxxmh wpk
										WHERE ((wpk.panjang * wpk.lebar * wpk.tinggi) + (wpk.gw)) >= ((a.jumlah_unit * (uom.panjang * uom.lebar * uom.tinggi)) + (a.jumlah_unit * uom.gw))
										AND wpk.transaction_state = 1
										LIMIT 1
									)
									ELSE 0
								END 
								id_wpkxxmh
							FROM wplittd a
							LEFT JOIN iivxxrd b ON b.id_iimxxmh = a.id_iimxxmh
							LEFT JOIN wplxxth c ON c.id = a.id_wplxxth
							LEFT JOIN iimxxmh d ON d.id = a.id_iimxxmh
							LEFT JOIN grlxxmh f ON f.id = a.id_grlxxmh_customer
							LEFT JOIN iumxxmh g ON g.id = a.id_iumxxmh_unit
							LEFT JOIN wimlotd h ON h.id_iimxxmh = a.id_iimxxmh AND h.id_wloxxmh = b.id_wloxxmh
							LEFT JOIN wloxxmh asal ON asal.id = c.id_wloxxmh_out
							LEFT JOIN wloxxmh tujuan ON tujuan.id = b.id_wloxxmh
							LEFT JOIN ggswmsh gg on gg.id = 1
							LEFT JOIN iimummd uom ON uom.id_iimxxmh = a.id_iimxxmh AND uom.id_iumxxmh = a.id_iumxxmh_unit
							LEFT JOIN (
								SELECT
									fifo.id id_iiv_fifo,
									wlpxxmh_kode lpn
								FROM iivxxrd fifo
								GROUP BY fifo.wlpxxmh_kode
							) fifo ON fifo.lpn = b.wlpxxmh_kode
							WHERE c.id = :id_transaksi_h AND b.keterangan <> :uniqueToken AND a.id_iimxxmh = :id_iimxxmh
							'.$where_wh.' AND a.id = :id_wplittd
							AND
							(
								(c.is_crossdocking = 1 AND b.id_wloctmh IN (1, 3))
								OR
								(c.is_crossdocking <> 1 AND b.id_wloctmh = 3)
							)
							AND expired_date >= DATE_ADD(CURDATE(), INTERVAL f.batas_expired_date MONTH)
							GROUP BY 
								b.id_wloxxmh,
								a.id_iimxxmh,
								wlpxxmh_kode
							HAVING SUM(b.jumlah_terkecil) > 0 AND iimxxmh_status_max_id = 1
				');
				$rs_iivxxrd = $qs_iivxxrd->fetchAll();

				//Aturan Movement Method Order, sesuai master items
				$movementMethodOrder = function ($a, $b) use ($movement_method, $movement_method2) {
					// FEFO utama
					if ($movement_method == 1) {
						$dateComparison = strtotime($a['expired_date']) <=> strtotime($b['expired_date']);
						if ($dateComparison !== 0) return $dateComparison;
				
						// FIFO sekunder
						if ($movement_method2 == 2) {
							$idComparison = intval($a['id_iiv']) <=> intval($b['id_iiv']);
							if ($idComparison !== 0) return $idComparison;
						}
				
						return intval($a['urutan']) <=> intval($b['urutan']);
					}
				
					// FIFO utama
					elseif ($movement_method == 2) {
						$idComparison = intval($a['id_iiv']) <=> intval($b['id_iiv']);
						if ($idComparison !== 0) return $idComparison;
				
						// FEFO sekunder
						if ($movement_method2 == 1) {
							$dateComparison = strtotime($a['expired_date']) <=> strtotime($b['expired_date']);
							if ($dateComparison !== 0) return $dateComparison;
						}
				
						return intval($a['urutan']) <=> intval($b['urutan']);
					}
				
					// Default jika movement_method tidak dikenali
					return 0;
				};
			
				usort($rs_iivxxrd, $movementMethodOrder);

				foreach ($rs_iivxxrd as $key => $iiv) {
					//insert ke Job Picking
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
					
					//jika subtotal di detail item masih belum terpenuhi maka bisa insert data item lpn hasil selectnya
					if ($subtotal_jumlah_terkecil < $jumlah_terkecil) {

						$sisa_terkecil = $jumlah_terkecil - $subtotal_jumlah_terkecil;
						if ($iiv['jumlah_terkecil_lpn'] > $sisa_terkecil) {
							$jumlah_terkecil_insert = $sisa_terkecil;
							$jumlah_unit_insert = $jumlah_unit - $subtotal_jumlah_unit;
							$jumlah_default_insert = $jumlah_default - $subtotal_jumlah_default;
						} else {
							// if ($subtotal_jumlah_terkecil > $iiv['jumlah_terkecil_lpn']) {
								$jumlah_unit_insert = $iiv['jumlah_unit'];
								$jumlah_terkecil_insert = $iiv['jumlah_terkecil_lpn'];
								$jumlah_default_insert = $iiv['jumlah_default_lpn'];
							// } else {
							// 	$jumlah_unit_insert = $iiv['jumlah_unit'] - $subtotal_jumlah_unit;
							// 	$jumlah_terkecil_insert = $iiv['jumlah_terkecil_lpn'] - $subtotal_jumlah_terkecil;
							// 	$jumlah_default_insert = $iiv['jumlah_default_lpn'] - $subtotal_jumlah_default;
							// }
						}
						
						if ($is_koordinat == 1) {
							$total_koordinat = $iiv['urutan'];
						} else {
							$total_koordinat = 0;
						}
						
						//insert Job Picking
						$qi_lpn_d = $db
							->query('insert', 'wpllptd')
							->set('id_wplxxth',$id_transaksi_h)
							->set('id_wjtxxmh',1)
							->set('id_wloznmh',$iiv['id_wloznmh'])
							->set('id_grlxxmh_customer',$iiv['id_grlxxmh_customer'])
							->set('id_wpkxxmh',$iiv['id_wpkxxmh'])
							->set('id_wplittd',$id_wplittd)
							->set('total_koordinat',$total_koordinat)
							->set('id_iimxxmh',$iiv['id_iimxxmh'])
							->set('id_wloxxmh',$iiv['id_wloxxmh'])
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
							->set('wloxxmh_nama',$iiv['wloxxmh_nama'])
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
										a.subtotal_jumlah_unit = a.subtotal_jumlah_unit + (:jumlah_terkecil_insert / jumlah_konversi)
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
			}
		}
		
		// if($pesan == ''){
			$qu_wpxxth = $db
				->raw()
				->bind(':id_transaksi_h', $id_transaksi_h)
				->bind(':timestamp', $timestamp)
				->exec('UPDATE wplxxth a
						SET 
							generated_on = :timestamp,
							a.is_generate_lpn = 1
						WHERE a.id = :id_transaksi_h
						;
				
				'
			);
			
			$db->commit();
			$status_code  = 200;
			
			if ($pesan == '') {
				$message      = 'Job Picking Berhasil di Generate';
				$type_message = 'success';
			} else {
				$message      = 'Job Picking Gagal di Generate!'. '<br>' . $pesan;
				$type_message = 'error';
			}
			
			
		// }else{
		// 	$db->rollback();
		// 	// $db->commit();
		// 	$status_code  = 500;
		// 	$message      = 'Job Picking Gagal di Generate!'. '<br>' . $pesan;
		// 	$type_message = 'error';
		// }
	}catch(PDOException $e){
		$db->rollback();
		$status_code  = 500;
		$message      = 'Job Picking Gagal di Generate! ' . $e->getMessage();
		$type_message = 'error';
	}catch (Exception $e) {
		$db->rollback();
		$status_code = 500;
		$message = 'Job Picking Gagal di Generate!, ' . $e->getMessage();
		$type_message = 'error';
	}
	// build response
	$data = array(
		'status_code'    => $status_code,
		'message'        => $message,
		'type_message'   => $type_message,
	);

	// tampilkan results
    include( "../../../../usersc/helpers/fn_ajax_results.php" );
?>