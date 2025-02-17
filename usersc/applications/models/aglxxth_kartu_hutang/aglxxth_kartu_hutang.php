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

	if (isset($_POST['id_grlxxmh']) && $_POST['id_grlxxmh'] > 0) {
		$having= 'HAVING id_grlxxmh = '. $_POST['id_grlxxmh'];
	} else {
		$having = '';
	}
	

	$results = array();
	$all_results = [];

	$qs_saldo_awal = $db
		->raw()
		->bind(':start_date', $start_date)
		->bind(':end_date', $end_date)
		->exec('WITH saldo_awal AS (
					SELECT
						b.debit,
						b.kredit,
						CASE 
							WHEN a.jenis_transaksi = "Purchase Invoice" AND b.debit > 0 THEN 1
							WHEN a.jenis_transaksi = "Purchase Payment" AND b.kredit > 0 THEN 1
							ELSE 0
						END is_valid,
						CASE 
							WHEN a.jenis_transaksi = "Purchase Invoice" THEN
							(
								SELECT id_grlxxmh_supplier
								FROM pivxxth th
								WHERE th.id = a.id_transaksi_h
							)
							ELSE
							(
								SELECT id_grlxxmh_supplier
								FROM fpmxxth th
								WHERE th.id = a.id_transaksi_h
							)
						END AS id_grlxxmh,
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
						END AS supplier
					FROM aglxxth a
					LEFT JOIN aglaktd b ON b.id_aglxxth = a.id
					WHERE a.tanggal < :start_date
						AND jenis_transaksi IN ("Purchase Payment", "Purchase Invoice")
				)
				SELECT
					0 id,
					"SALDO AWAL" kode_transaksi,
					"" AS jenis_transaksi,
					DATE_FORMAT(DATE_SUB(:start_date, INTERVAL 1 DAY), "%d %b %Y") AS tanggal,
					id_grlxxmh,
					supplier,
					"" AS keterangan,
					1 AS is_valid,
					null AS debit,
					null AS kredit,
					DATE_SUB(":start_date 00:00:00", INTERVAL 1 DAY) AS created_on,
					SUM(debit) - SUM(kredit) AS saldo
				FROM saldo_awal
				WHERE is_valid = 1
				GROUP BY supplier 
				'.$having.'

				UNION ALL

				SELECT 
					0, 
					"SALDO AWAL", 
					"", 
					DATE_FORMAT(DATE_SUB(:start_date, INTERVAL 1 DAY), "%d %b %Y"), 
					CASE 
						WHEN a.jenis_transaksi = "Purchase Invoice" THEN
						(
							SELECT id_grlxxmh_supplier
							FROM pivxxth th
							WHERE th.id = a.id_transaksi_h
						)
						ELSE
						(
							SELECT id_grlxxmh_supplier
							FROM fpmxxth th
							WHERE th.id = a.id_transaksi_h
						)
					END AS id_grlxxmh,
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
					"", 
					1, 
					NULL, 
					NULL, 
					DATE_SUB(":start_date 00:00:00", INTERVAL 1 DAY) AS created_on,
					0
				FROM aglxxth a
				LEFT JOIN aglaktd b ON b.id_aglxxth = a.id
				WHERE a.tanggal BETWEEN :start_date AND :end_date
					AND jenis_transaksi IN ("Purchase Payment", "Purchase Invoice")
					AND NOT EXISTS (SELECT 1 FROM saldo_awal WHERE is_valid = 1)
				GROUP BY supplier 
				'.$having.'
				;
	');
	$rs_saldo_awal = $qs_saldo_awal->fetchAll();

	$qs_kartu_hutang = $db
		->raw()
		->bind(':start_date', $start_date)
		->bind(':end_date', $end_date)
		->exec('WITH saldo_awal AS (
					SELECT
						b.debit,
						b.kredit,
						CASE 
							WHEN a.jenis_transaksi = "Purchase Invoice" AND b.debit > 0 THEN 1
							WHEN a.jenis_transaksi = "Purchase Payment" AND b.kredit > 0 THEN 1
							ELSE 0
						END is_valid,
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
						END AS supplier
					FROM aglxxth a
					LEFT JOIN aglaktd b ON b.id_aglxxth = a.id
					WHERE a.tanggal < :start_date
						AND jenis_transaksi IN ("Purchase Payment", "Purchase Invoice")
				),
				saldo_awal_cte AS (
					SELECT
						"SALDO AWAL" AS kode_transaksi,
						supplier,
						SUM(debit) - SUM(kredit) AS saldo_awal
					FROM saldo_awal
					WHERE is_valid = 1
					GROUP BY supplier 
				),
				transaksi AS (
					SELECT
						b.id,
						a.kode_transaksi,
						a.jenis_transaksi,
						DATE_FORMAT(a.tanggal, "%d %b %Y") AS tanggal,
						CASE 
							WHEN a.jenis_transaksi = "Purchase Invoice" THEN
							(
								SELECT id_grlxxmh_supplier
								FROM pivxxth th
								WHERE th.id = a.id_transaksi_h
							)
							ELSE
							(
								SELECT id_grlxxmh_supplier
								FROM fpmxxth th
								WHERE th.id = a.id_transaksi_h
							)
						END AS id_grlxxmh,
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
                        CASE 
							WHEN a.jenis_transaksi = "Purchase Invoice" THEN b.keterangan
							WHEN a.jenis_transaksi = "Purchase Payment" THEN 
                            (
                                SELECT
                                    GROUP_CONCAT(p.kode) keterangan
                                FROM fpmxxth h
                                LEFT JOIN fpmivtd d ON d.id_fpmxxth = h.id
                                LEFT JOIN pivxxth p ON p.id = d.id_pivxxth
                                WHERE h.id = a.id_transaksi_h
                                GROUP BY h.id 
                            )
							ELSE 0
						END keterangan,
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
					WHERE a.tanggal BETWEEN :start_date AND :end_date
						AND jenis_transaksi IN ("Purchase Payment", "Purchase Invoice")
				)
				SELECT 
					t.id,
					t.kode_transaksi,
					t.jenis_transaksi,
					t.tanggal,
					t.id_grlxxmh,
					t.supplier,
					t.keterangan,
					t.is_valid,
					SUM(t.debit) debit,
					SUM(t.kredit) kredit,
					t.created_on,
					COALESCE(s.saldo_awal, 0) 
						+ SUM(SUM(t.debit) - SUM(t.kredit)) OVER (
							PARTITION BY t.supplier 
							ORDER BY t.created_on, t.kode_transaksi 
							ROWS BETWEEN UNBOUNDED PRECEDING AND CURRENT ROW
						) AS saldo
				FROM transaksi t
				LEFT JOIN saldo_awal_cte s ON s.supplier = t.supplier
				WHERE t.is_valid = 1
				GROUP BY kode_transaksi, supplier
				'.$having.'
				ORDER BY supplier, created_on, kode_transaksi
	');
	$rs_kartu_hutang = $qs_kartu_hutang->fetchAll();

	$all_results = array_merge($rs_saldo_awal, $rs_kartu_hutang);
	
	$data = $all_results;
	require_once( "../../../../usersc/helpers/fn_ajax_results2.php" );
?>