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
	$qs_kartu_hutang = $db
		->raw()
		->bind(':start_date', $start_date)
		->bind(':end_date', $end_date)
		->exec('WITH transaksi AS (
					SELECT
						b.id,
						a.kode_transaksi,
						a.jenis_transaksi,
						DATE_FORMAT(a.tanggal,"%d %b %Y") as tanggal,
						CASE 
							WHEN a.jenis_transaksi = "Purchase Invoice" THEN
							(
								SELECT rl.nama
								FROM pivxxth th
								LEFT JOIN grlxxmh rl ON rl.id = th.id_grlxxmh_supplier
								WHERE th.id = a.id_transaksi_h
							)
							ELSE
							(
								SELECT rl.nama
								FROM fpmxxth th
								LEFT JOIN grlxxmh rl ON rl.id = th.id_grlxxmh_supplier
								WHERE th.id = a.id_transaksi_h
							)
						END AS supplier,
						b.keterangan,
						CASE 
							WHEN a.jenis_transaksi = "Purchase Invoice" AND b.debit > 0 THEN 1
							WHEN a.jenis_transaksi = "Purchase Payment" AND b.kredit > 0 THEN 1
							ELSE 0
						END is_valid,
						b.debit,
						b.kredit,
						CASE 
							WHEN a.jenis_transaksi = "Purchase Invoice" THEN
							(
								SELECT ac.created_on
								FROM activity_log_ml ac
								WHERE ac.kode = "CONFIRM" AND ac.nama = "pivxxth" AND id_transaksi = a.id_transaksi_h
								ORDER BY id DESC
								LIMIT 1
							)
							ELSE
							(
								SELECT ac.created_on
								FROM activity_log_ml ac
								WHERE ac.kode = "CONFIRM" AND ac.nama = "fpmxxth" AND id_transaksi = a.id_transaksi_h
								ORDER BY id DESC
								LIMIT 1
							)
						END AS created_on
					FROM aglxxth a
					LEFT JOIN aglaktd b ON b.id_aglxxth = a.id
					WHERE 1
						AND a.tanggal BETWEEN :start_date AND :end_date
						AND jenis_transaksi IN ("Purchase Payment", "Purchase Invoice")
				)
				SELECT 
					t.*,
					-- Hitung balance increment per supplier
					SUM(debit - kredit) OVER (
						PARTITION BY supplier 
						ORDER BY created_on, kode_transaksi 
						ROWS BETWEEN UNBOUNDED PRECEDING AND CURRENT ROW
					) AS saldo
				FROM transaksi t
				HAVING is_valid = 1
				ORDER BY supplier, created_on
				;
	');
	$rs_kartu_hutang = $qs_kartu_hutang->fetchAll();
	
	$data = $rs_kartu_hutang;
	require_once( "../../../../usersc/helpers/fn_ajax_results2.php" );
?>