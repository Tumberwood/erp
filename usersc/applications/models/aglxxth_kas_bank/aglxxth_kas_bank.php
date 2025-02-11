<?php
	/**
	 * 
	 */

	 require_once( "../../../../users/init.php" );
	 require_once( "../../../../usersc/lib/DataTables.php" );
	 require_once( "../../../../usersc/helpers/datatables_fn_debug.php" );
	 require_once( "../../../../usersc/vendor/autoload.php");
	 require_once( "../../../helpers/hakakses_s_fn.php" );
	 require_once( "../../../helpers/SolusiIndonesiaUtilities.php" );
	 
	use Carbon\Carbon;
	
	use
		DataTables\Editor,
		DataTables\Editor\Query,
		DataTables\Editor\Result;

		// BEGIN definisi variable untuk fn_ajax_results.php
		$data      = array();
		$rs_opt    = array();
		// END definisi variable untuk fn_ajax_results.php
		
	$start_date = $_POST['start_date'];
	$end_date = $_POST['end_date'];
	$is_akunbertransaksi = $_POST['is_akunbertransaksi'];
	$is_akunbernilai = $_POST['is_akunbernilai'];

	$results = array();

	// Mendapatkan semua akun yang aktif
	$qs_aakxxmh = $db
		->raw()
		->bind(':transaction_state', 1)
		->exec('SELECT 
			id as id_aakxxmh
			FROM aakxxmh 
			WHERE 1
				AND id_aatxxmh = 1
				AND transaction_state = :transaction_state
				AND is_parent = 0
		');
	$rs_aakxxmh = $qs_aakxxmh->fetchAll();

	$all_results = [];


	foreach ($rs_aakxxmh as $row_aakxxmh) {
		$id_aakxxmh = $row_aakxxmh['id_aakxxmh'];
		// BEGIN saldo awal
		$qs_aglxxth_awal = $db
			->raw()
			->bind(':id_aakxxmh', $id_aakxxmh)
			->bind(':start_date', $start_date)
			->exec('SELECT
						a.id as id,
						ifnull(
							CONCAT(c.kode," ",c.nama),
							(
								SELECT
									CONCAT(kode," ",nama)
								FROM aakxxmh
								WHERE id = :id_aakxxmh
							)
						) as akun,
						b.kode_transaksi as kode_transaksi,
						date_format(b.tanggal,"%d %b %Y") as tanggal,
						b.keterangan as keterangan,
						IFNULL(
							SUM(IF(a.debit_kredit = "Debit",a.debit,0)),
							0
						) AS debit,
						IFNULL(
							SUM(IF(a.debit_kredit = "Kredit",a.kredit,0)),
							0
						) AS kredit,
						SUM(IF(a.debit_kredit = "Debit",a.debit,0)) - SUM(IF(a.debit_kredit = "Kredit",a.kredit,0)) AS saldo 
					FROM aglaktd a
					LEFT JOIN aglxxth b ON b.id = a.id_aglxxth
					LEFT JOIN aakxxmh c ON c.id = a.id_aakxxmh
					WHERE 1
						AND c.id_aatxxmh = 1
						AND c.id = :id_aakxxmh
						AND b.tanggal < :start_date
			');
		$rs_aglxxth_awal = $qs_aglxxth_awal->fetchAll();

		if(!empty($rs_aglxxth_awal)){

			$rs_aglxxth_awal[0]['kode_transaksi'] = 'SALDO AWAL';
			$rs_aglxxth_awal[0]['tanggal'] = date('d M Y', strtotime("-1 day", strtotime($start_date)));
			$rs_aglxxth_awal[0]['keterangan'] = '';
			$rs_aglxxth_awal[0]['saldo'] = 0; //kalau hitungan saldo awal null atau blank, maka dibuat jadi 0 saja
		}else{

			$rs_aglxxth_awal[0]['tanggal'] = date('d M Y', strtotime("-1 day", strtotime($start_date)));
			$rs_aglxxth_awal[0]['saldo'] = $rs_aglxxth_awal[0]['debit'] + $rs_aglxxth_awal[0]['kredit'];

		}

		$saldo_final = $rs_aglxxth_awal[0]['saldo'];

		// END saldo awal

		// BEGIN mutasi
		$qs_aglxxth_mutasi = $db
			->raw()
			->bind(':id_aakxxmh', $id_aakxxmh)
			->bind(':start_date', $start_date)
			->bind(':end_date', $end_date)
			->exec('SELECT
					a.id as id,
					CONCAT(c.kode," ",c.nama) as akun,
					b.kode_transaksi as kode_transaksi,
					date_format(b.tanggal,"%d %b %Y") as tanggal,
					b.keterangan as keterangan,
					IF(a.debit_kredit = "Debit",a.debit,0) AS debit,
					IF(a.debit_kredit = "Kredit",a.kredit,0) AS kredit
				FROM aglaktd a
				LEFT JOIN aglxxth b ON b.id = a.id_aglxxth
				LEFT JOIN aakxxmh c ON c.id = a.id_aakxxmh
				WHERE 1
					AND c.id_aatxxmh = 1
					AND id_aakxxmh = :id_aakxxmh
					AND b.tanggal BETWEEN :start_date AND :end_date
				ORDER BY 
					c.id, b.tanggal, b.id
			');
			$rs_aglxxth_mutasi = $qs_aglxxth_mutasi->fetchAll();
			
			if (!empty($rs_aglxxth_mutasi) ){
				foreach($rs_aglxxth_mutasi as $key => $row){
					$hitung_saldo = $saldo_final + $row['debit'] - $row['kredit'];
					$rs_aglxxth_mutasi[$key]['saldo'] = abs($hitung_saldo);
					$saldo_final = $rs_aglxxth_mutasi[$key]['saldo'];
				}

				$rs_aglxxth_awal[0]['debit'] = '';
				$rs_aglxxth_awal[0]['kredit'] = '';
				
				$results = array_merge($rs_aglxxth_awal, $rs_aglxxth_mutasi);
				
				// sebelum ada is_akunbertransaksi
				// $all_results = array_merge($all_results, $results);

				// Menambahkan ke hasil akhir jika $is_akunbertransaksi == 0 atau jika terdapat mutasi
				if ($is_akunbertransaksi == 0 || !empty($rs_aglxxth_mutasi)) {
					$all_results = array_merge($all_results, $results);
				}

				// Menambahkan ke hasil akhir jika $is_akunbertransaksi == 0 atau jika terdapat mutasi
				// if ($is_akunbertransaksi == 0 || !empty($rs_aglxxth_mutasi)) {
				// 	// Memeriksa apakah akun memiliki saldo akhir (saldo_final) dan menambahkan ke hasil akhir jika $is_akunbernilai == 0 atau saldo_final != 0
				// 	if ($is_akunbernilai == 0 || $saldo_final != 0) {
				// 		$all_results = array_merge($all_results, $results);
				// 	}
				// }

			
			}else{
				// sebelum ada is_akunbertransaksi
				// $all_results = array_merge($all_results, $rs_aglxxth_awal);

				if ($is_akunbertransaksi == 0) {
					$all_results = array_merge($all_results, $rs_aglxxth_awal);
				}

				// Menambahkan ke hasil akhir jika $is_akunbertransaksi == 0
				// if ($is_akunbertransaksi == 0) {
				// 	// Memeriksa apakah akun memiliki saldo akhir (saldo_final) dan menambahkan ke hasil akhir jika $is_akunbernilai == 0 atau saldo_final != 0
				// 	if ($is_akunbernilai == 0 || $saldo_final != 0) {
				// 		$all_results = array_merge($all_results, $rs_aglxxth_awal);
				// 	}
				// }
			}
			// END mutasi
			
	}
	$data = $all_results;
	require_once( "../../../../usersc/helpers/fn_ajax_results2.php" );
?>