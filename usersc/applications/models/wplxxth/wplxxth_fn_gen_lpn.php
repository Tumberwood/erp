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

		$qs_items = $db
			->query('select', 'wplittd a' )
			->get([
				'a.id as id_wplittd',
				'id_iimxxmh',
				'movement_method',
				'movement_method2'
			] )
			->join('iimxxmh','iimxxmh.id = a.id_iimxxmh','LEFT' )
			->where('id_wplxxth', $id_transaksi_h )
			->exec();
		$rs_items = $qs_items->fetchAll();

		foreach ($rs_items as $key => $item) {
			$id_wplittd = $item['id_wplittd'];
			$id_iimxxmh = $item['id_iimxxmh'];
			$movement_method = $item['movement_method'];
			$movement_method2 = $item['movement_method2'];

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
							max(batch_number) batch_number,
							max(expired_date) as expired_date
						FROM wplittd a
						LEFT JOIN iivxxrd b ON b.id_iimxxmh = a.id_iimxxmh
						LEFT JOIN wplxxth c ON c.id = a.id_wplxxth
						LEFT JOIN iimxxmh d ON d.id = a.id_iimxxmh
						LEFT JOIN wdoxxth e ON e.id = c.id_wdoxxth
						LEFT JOIN grlxxmh f ON f.id = e.id_grlxxmh_customer
						LEFT JOIN iumxxmh g ON g.id = a.id_iumxxmh_unit
						LEFT JOIN wimlotd h ON h.id_iimxxmh = a.id_iimxxmh AND h.id_wloxxmh = b.id_wloxxmh
						WHERE c.id = :id_transaksi_h AND b.keterangan <> :uniqueToken AND a.id_iimxxmh = :id_iimxxmh
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
					
					//insert detail LPN
					$qi_lpn_d = $db
						->query('insert', 'wpllptd')
						->set('id_wplxxth',$id_transaksi_h)
						->set('id_wplittd',$id_wplittd)
						->set('id_iimxxmh',$iiv['id_iimxxmh'])
						->set('id_wloxxmh',$iiv['id_wloxxmh'])
						->set('id_iwhxxmh',$iiv['id_iwhxxmh'])
						->set('id_iumxxmh_unit',$iiv['id_iumxxmh_unit'])
						->set('id_iumxxmh_terkecil',$iiv['id_iumxxmh_terkecil'])
						->set('id_iumxxmh_default',$iiv['id_iumxxmh_default'])
						->set('jumlah_unit',$jumlah_unit_insert)
						->set('jumlah_terkecil',$jumlah_terkecil_insert)
						->set('jumlah_default',$jumlah_default_insert)
						->set('wlpxxmh_kode',$iiv['wlpxxmh_kode'])
						->set('batch_number',$iiv['batch_number'])
						->set('expired_date',$iiv['expired_date'])
					->exec();

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

				} else {
					// echo $subtotal_jumlah_terkecil;
				}
				
			}
		}
		
		if(!empty($rs_items)){
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
			$message      = 'Detail LPN Berhasil Ditambahkan';
			$type_message = 'success';
			
		}else{
			$db->rollback();
			$status_code  = 500;
			$message      = 'Detail LPN Gagal Ditambahkan!';
			$type_message = 'error';
		}
	}catch(PDOException $e){
		$db->rollback();
		$status_code  = 500;
		$message      = 'Detail LPN Gagal Ditambahkan! ' . $e->getMessage();
		$type_message = 'error';
	}catch (Exception $e) {
		$db->rollback();
		$status_code = 500;
		$message = 'Detail LPN Gagal Ditambahkan!, ' . $e->getMessage();
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