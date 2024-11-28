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

		$qs_ggswmsh = $db
			->query('select', 'ggswmsh' )
			->get(['is_replenishment'] )
			->where('id', 1 )
			->exec();
		$rs_ggswmsh = $qs_ggswmsh->fetch();
		$is_replenishment = $rs_ggswmsh['is_replenishment'];

		$qs_wktxxth = $db
			->query('select', 'wktxxth' )
			->get([
					'is_all_wh'
				] )
			->where('id', $id_transaksi_h )
			->exec();
		$rs_wktxxth = $qs_wktxxth->fetch();
		$is_all_wh = $rs_wktxxth['is_all_wh'];

		if ($is_all_wh == 1) {
			$where_wh = '';
		} else {
			$where_wh = 'AND b.id_iwhxxmh = c.id_iwhxxmh';
		}
		
		$qs_items = $db
			->query('select', 'wktittd a' )
			->get([
				'a.id as id_wktittd',
				'id_iimxxmh',
				'jumlah_unit',
				'jumlah_konversi',
				'jumlah_terkecil',
				'id_iumxxmh_unit',
				'movement_method',
				'movement_method2'
			] )
			->join('iimxxmh','iimxxmh.id = a.id_iimxxmh','LEFT' )
			->where('id_wktxxth', $id_transaksi_h )
			->exec();
		$rs_items = $qs_items->fetchAll();

		//select hasil terceil dari iiv dari qty detail item * qty kitting header.
		/**
		 * Contoh qty Header: 50
		 * 
		 * Detail A: 1 | 50 * 1 = 50
		 * Detail B: 2 | 50 * 2 = 100
		 * 
		 * Hasil generate:
		 * Detail A: 50
		 * Detail B: 70 (harusnya 100)
		 * 
		 * Buat hasil pembagian
		 * Hasil Generate Detail A: 50, maka 50 / 1 (dari qty detail item) = 50 
		 * Hasil Generate Detail B: 70, maka 70 / 2 (dari qty detail item) = 35
		 * 
		 * Terkecil dari hasil pembagian = 35
		 * Buat sama rata 35, Jadi menghasilkan output:
		 * Hasil Generate Detail A: 35 (tidak jadi 50, karena yang terkecil 35)
		 * Hasil Generate Detail B: 70
		 */
		$qs_hasil_terkecil = $db
			->raw()
			->bind(':uniqueToken', $uniqueToken)
			->bind(':id_transaksi_h', $id_transaksi_h)
			->exec('WITH inventory AS (
						SELECT
							:id_transaksi_h,
							max(b.id) id_iivxxrd,
							(
								SELECT a_inner.iimxxmh_status
								FROM iivxxrd a_inner
								WHERE a_inner.id = MAX(b.id) -- Correlates with the outer query
							) AS iimxxmh_status_max_id,
							ifnull(h.urutan,0) AS urutan,
							b.id AS id_iiv,
							b.id_wloctmh,
							wlpxxmh_kode,
							b.id_iwhxxmh,
							b.id_wloxxmh,
							a.id_iimxxmh,
							a.id_iumxxmh_unit,
							b.id_iumxxmh_terkecil,
							b.id_iumxxmh_default,
							:uniqueToken,
							iwhxxmh_kode,
							iwhxxmh_nama,
							b.wloxxmh_kode,
							b.wloxxmh_nama,
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
							if((a.jumlah_default * c.jumlah_unit) > SUM(b.jumlah_default), SUM(b.jumlah_default), (a.jumlah_default * c.jumlah_unit)) jumlah_unit,
							a.jumlah_konversi,
							if((a.jumlah_terkecil * c.jumlah_unit) > SUM(b.jumlah_terkecil), SUM(b.jumlah_terkecil), (a.jumlah_terkecil * c.jumlah_unit)) jumlah_terkecil_lpn,
							if((a.jumlah_default * c.jumlah_unit) > SUM(b.jumlah_default), SUM(b.jumlah_default), (a.jumlah_default * c.jumlah_unit)) jumlah_default_lpn,
							max(batch_number) batch_number,
							max(expired_date) as expired_date,
							(a.jumlah_default * c.jumlah_unit) AS jumlah_unit_kali,
							(a.jumlah_terkecil * c.jumlah_unit) AS jumlah_terkecil_kali,
							a.jumlah_default jumlah_detail_item
						FROM wktittd a
						LEFT JOIN iivxxrd b ON b.id_iimxxmh = a.id_iimxxmh
						LEFT JOIN wktxxth c ON c.id = a.id_wktxxth
						LEFT JOIN iimxxmh d ON d.id = a.id_iimxxmh
						LEFT JOIN iumxxmh g ON g.id = a.id_iumxxmh_unit
						LEFT JOIN wimlotd h ON h.id_iimxxmh = a.id_iimxxmh AND h.id_wloxxmh = b.id_wloxxmh
						WHERE c.id = :id_transaksi_h AND b.keterangan <> :uniqueToken AND a.id_iimxxmh IN (SELECT id_iimxxmh FROM wktittd WHERE id_wktxxth = :id_transaksi_h )
						AND (
								(c.is_crossdocking = 1 AND b.id_wloctmh IN (1, 3))
								OR
								(c.is_crossdocking <> 1 AND b.id_wloctmh = 3)
							)
						GROUP BY 
							b.id_wloxxmh,
							a.id_iimxxmh,
							wlpxxmh_kode
						HAVING SUM(b.jumlah_terkecil) > 0 AND iimxxmh_status_max_id = 1
					)
					SELECT
						id_iimxxmh,
						iimxxmh_kode,
						iimxxmh_nama,
						iumxxmh_terkecil_kode,
						iumxxmh_terkecil_nama,
						iumxxmh_default_kode,
						iumxxmh_default_nama,
						jumlah_konversi,
						if(jumlah_unit_kali > SUM(jumlah_unit), SUM(jumlah_unit), jumlah_unit_kali) jumlah_unit,
						if(jumlah_terkecil_kali > SUM(jumlah_terkecil_lpn), SUM(jumlah_terkecil_lpn), jumlah_terkecil_kali) jumlah_terkecil_lpn,
						if(jumlah_unit_kali > SUM(jumlah_default_lpn), SUM(jumlah_default_lpn), jumlah_unit_kali) jumlah_default_lpn,

						if(jumlah_unit_kali > SUM(jumlah_unit), SUM(jumlah_unit), jumlah_unit_kali) / jumlah_detail_item AS jumlah_unit_tersedia,
						-- jumlah_terkecil_kali,
						-- jumlah_terkecil_lpn,
						if(jumlah_terkecil_kali > SUM(jumlah_terkecil_lpn), SUM(jumlah_terkecil_lpn), jumlah_terkecil_kali) / jumlah_detail_item AS jumlah_terkecil_tersedia
					FROM inventory z
					GROUP BY z.id_iimxxmh
					ORDER BY jumlah_unit_tersedia
		');
		
		$rs_hasil_terkecil = $qs_hasil_terkecil->fetch();
		//hasil terkecil setelah perhitungan
		$jumlah_unit_tersedia = $rs_hasil_terkecil['jumlah_unit_tersedia'];

		if ($is_replenishment == 1) {
			foreach ($rs_items as $key => $item) {
				$jumlah_terkecil_tersedia = $jumlah_unit_tersedia * $item['jumlah_konversi'];
				$id_wktittd = $item['id_wktittd'];
				$id_iimxxmh = $item['id_iimxxmh'];
				$jumlah_unit_detail = $item['jumlah_unit'];
				$id_iumxxmh_unit = $item['id_iumxxmh_unit'];
				$movement_method = $item['movement_method'];
				$movement_method2 = $item['movement_method2'];

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

				include "wktxxth_fn_replenishment.php";

				// $qs_cek_os = $db
				// 	->query('select', 'wktittd' )
				// 	->get([
				// 		'jumlah_terkecil',
				// 		'subtotal_jumlah_terkecil',
				// 		'jumlah_unit',
				// 		'subtotal_jumlah_unit',
				// 		'jumlah_default',
				// 		'subtotal_jumlah_default'
				// 	] )
				// 	->where('id', $id_wktittd )
				// 	->exec();
				// $rs_cek_os = $qs_cek_os->fetch();

				// $terkecil_item_os = $rs_cek_os['jumlah_terkecil'] - $rs_cek_os['subtotal_jumlah_terkecil'];
				// if ($terkecil_item_os > 0) {
				// 	include "wktxxth_fn_replenishment.php";
				// }
			}
		} else {
			//Bukan Replenishment
			foreach ($rs_items as $key => $item) {
				$jumlah_terkecil_tersedia = $jumlah_unit_tersedia * $item['jumlah_konversi'];
				$id_wktittd = $item['id_wktittd'];
				$jumlah_unit_detail = $item['jumlah_unit'];
				$jumlah_terkecil_detail = $item['jumlah_terkecil'];
				$id_iimxxmh = $item['id_iimxxmh'];
				$movement_method = $item['movement_method'];
				$movement_method2 = $item['movement_method2'];

				//select di inventory
				$qs_iivxxrd = $db
					->raw()
					->bind(':jumlah_unit_tersedia', $jumlah_unit_tersedia * $jumlah_unit_detail)
					->bind(':jumlah_terkecil_tersedia', $jumlah_terkecil_tersedia * $jumlah_unit_detail)
					->bind(':id_iimxxmh', $id_iimxxmh)
					->bind(':uniqueToken', $uniqueToken)
					->bind(':id_transaksi_h', $id_transaksi_h)
					->exec('SELECT
								:id_transaksi_h,
								ifnull(h.urutan,0) AS urutan,
								max(b.id) id_iivxxrd,
								(
							        SELECT a_inner.iimxxmh_status
							        FROM iivxxrd a_inner
							        WHERE a_inner.id = MAX(b.id) -- Correlates with the outer query
							    ) AS iimxxmh_status_max_id,
								b.id AS id_iiv,
								b.id_wloctmh,
								wlpxxmh_kode,
								b.id_iwhxxmh,
								b.id_wloxxmh,
								a.id_iimxxmh,
								a.id_iumxxmh_unit,
								b.id_iumxxmh_terkecil,
								b.id_iumxxmh_default,
								:uniqueToken,
								iwhxxmh_kode,
								iwhxxmh_nama,
								b.wloxxmh_kode,
								b.wloxxmh_nama,
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
								if(:jumlah_unit_tersedia > SUM(b.jumlah_default), SUM(b.jumlah_default), :jumlah_unit_tersedia) jumlah_unit,
								a.jumlah_konversi,
								if(:jumlah_terkecil_tersedia > SUM(b.jumlah_terkecil), SUM(b.jumlah_terkecil), :jumlah_terkecil_tersedia) jumlah_terkecil_lpn,
								if(:jumlah_unit_tersedia > SUM(b.jumlah_default), SUM(b.jumlah_default), :jumlah_unit_tersedia) jumlah_default_lpn,
								max(batch_number) batch_number,
								max(expired_date) as expired_date
							FROM wktittd a
							LEFT JOIN iivxxrd b ON b.id_iimxxmh = a.id_iimxxmh
							LEFT JOIN wktxxth c ON c.id = a.id_wktxxth
							LEFT JOIN iimxxmh d ON d.id = a.id_iimxxmh
							LEFT JOIN iumxxmh g ON g.id = a.id_iumxxmh_unit
							LEFT JOIN wimlotd h ON h.id_iimxxmh = a.id_iimxxmh AND h.id_wloxxmh = b.id_wloxxmh
							WHERE c.id = :id_transaksi_h AND b.keterangan <> :uniqueToken AND a.id_iimxxmh = :id_iimxxmh
							'.$where_wh.' AND 
							(
								(c.is_crossdocking = 1 AND b.id_wloctmh IN (1, 3))
								OR
								(c.is_crossdocking <> 1 AND b.id_wloctmh = 3)
							)
							AND expired_date >= CURDATE()
							GROUP BY 
								b.id_wloxxmh,
								a.id_iimxxmh,
								wlpxxmh_kode
							HAVING SUM(b.jumlah_terkecil) > 0 AND iimxxmh_status_max_id = 1
				');
				$rs_iivxxrd = $qs_iivxxrd->fetchAll();

				//Aturan Movement Method Order, sesuai master items
				$movementMethodOrder = function ($a, $b) use ($movement_method, $movement_method2) {
					//Jika movement method pertama adalah FEFO
					if ($movement_method == 1) {
						$dateComparison = strtotime($a['expired_date']) - strtotime($b['expired_date']);
			
						//jika movement method 2 adalah FIFO
						if ($movement_method2 == 2) {
							if ($dateComparison == 0) {
								// Jika tanggal kedaluwarsa sama, bandingkan id_iiv secara ascending
								// return intval($a['id_iiv']) - intval($b['id_iiv']);
								return intval($a['urutan']) - intval($b['urutan']);
							}
						}
						return $dateComparison;
					}
				};
			
				usort($rs_iivxxrd, $movementMethodOrder);

				foreach ($rs_iivxxrd as $key => $iiv) {
					//insert ke Job Picking
					// echo $iiv['expired_date'] . '/n';
					$qs_cek_sisa = $db
						->query('select', 'wktittd' )
						->get([
							'jumlah_terkecil',
							'subtotal_jumlah_terkecil',
							'jumlah_unit',
							'jumlah_konversi',
							'subtotal_jumlah_unit',
							'jumlah_default',
							'subtotal_jumlah_default'
						] )
						->where('id', $id_wktittd )
						->exec();
					$rs_cek_sisa = $qs_cek_sisa->fetch();

					//untuk yang subtotal_jumlah, defaultnya 0
					$jumlah_terkecil = $jumlah_terkecil_tersedia * $rs_cek_sisa['jumlah_unit'];
					$subtotal_jumlah_terkecil = $rs_cek_sisa['subtotal_jumlah_terkecil'];

					$jumlah_unit = $jumlah_terkecil * $rs_cek_sisa['jumlah_konversi'];
					$subtotal_jumlah_unit = $rs_cek_sisa['subtotal_jumlah_unit'];

					// BEGIN get UoM default
					$qs_iumxxmh_default = $db
						->query('select', 'iimummd' )
						->get([
							'id_iumxxmh as id_iumxxmh_default',
							'jumlah_konversi as jumlah_konversi_default'
						] )
						->where('iimummd.id_iimxxmh', $id_iimxxmh )
						->where('iimummd.is_default', 1 )
						->exec();
					$rs_iumxxmh_default = $qs_iumxxmh_default->fetch();

					$id_iumxxmh_default         = $rs_iumxxmh_default['id_iumxxmh_default'];
					$jumlah_konversi_default    = $rs_iumxxmh_default['jumlah_konversi_default'];

					$jumlah_default = $jumlah_terkecil / $jumlah_konversi_default;
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
						
						//insert Job Picking
						$qi_lpn_d = $db
							->query('insert', 'wktlptd')
							->set('id_wktxxth',$id_transaksi_h)
							->set('id_wjtxxmh',1)
							->set('id_wktittd',$id_wktittd)
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
						$qu_wktittd = $db
							->raw()
							->bind(':id_wktittd', $id_wktittd)
							->bind(':jumlah_default_insert', $jumlah_default_insert)
							->bind(':jumlah_terkecil_insert', $jumlah_terkecil_insert)
							->bind(':jumlah_unit_insert', $jumlah_unit_insert)
							->exec('UPDATE wktittd a
									SET 
										a.subtotal_jumlah_terkecil = a.subtotal_jumlah_terkecil + :jumlah_terkecil_insert,
										a.subtotal_jumlah_default = a.subtotal_jumlah_default + :jumlah_default_insert,
										a.subtotal_jumlah_unit = a.subtotal_jumlah_unit + :jumlah_unit_insert
									WHERE a.id = :id_wktittd
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
							// ->set('id_relasi_m',$iiv['id_relasi_m'])
							->set('id_iimxxmh',$iiv['id_iimxxmh'])
							->set('id_iumxxmh_unit',$iiv['id_iumxxmh_unit'])
							->set('id_iumxxmh_terkecil',$iiv['id_iumxxmh_terkecil'])
							->set('id_iumxxmh_default',$iiv['id_iumxxmh_default'])
							->set('keterangan',$uniqueToken)
							->set('iwhxxmh_kode',$iiv['iwhxxmh_kode'])
							->set('iwhxxmh_nama',$iiv['iwhxxmh_nama'])
							->set('wloxxmh_kode',$iiv['wloxxmh_kode'])
							->set('wloxxmh_nama',$iiv['wloxxmh_nama'])
							// ->set('relasi_m_kode',$iiv['relasi_m_kode'])
							// ->set('relasi_m_nama',$iiv['relasi_m_nama'])
							->set('iimxxmh_kode',$iiv['iimxxmh_kode'])
							->set('iimxxmh_nama',$iiv['iimxxmh_nama'])
							->set('iumxxmh_unit_kode',$iiv['iumxxmh_unit_kode'])
							->set('iumxxmh_unit_nama',$iiv['iumxxmh_unit_nama'])
							->set('tanggal',$iiv['tanggal'])
							->set('is_fisik',0)
							->set('imtxxmh_kode',219)
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
						General::logChange( $db , 'wktlptd', $s_id_users, $s_username, 'CREATE', $id_lpn_d, "", $timestamp , $finish_at );
						General::logChange( $db , 'wktlptd', $s_id_users, $s_username, 'CONFIRM', $id_lpn_d, "", $timestamp , $finish_at );
					} else {
						// echo $subtotal_jumlah_terkecil;
					}
					
				}
			}
		}
		
		if(!empty($rs_items)){
			$qu_wpxxth = $db
				->raw()
				->bind(':id_transaksi_h', $id_transaksi_h)
				->bind(':timestamp', $timestamp)
				->exec('UPDATE wktxxth a
						SET 
							generated_on = :timestamp,
							a.is_generate_lpn = 1
						WHERE a.id = :id_transaksi_h
						;
				
				'
			);
			
			$db->commit();
			$status_code  = 200;
			$message      = 'Job Picking Berhasil di Generate';
			$type_message = 'success';
			
		}else{
			$db->rollback();
			$status_code  = 500;
			$message      = 'Job Picking Gagal di Generate!';
			$type_message = 'error';
		}
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