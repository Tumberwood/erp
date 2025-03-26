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
							WHEN a.jenis_transaksi = "Sales Invoice" AND b.debit > 0 THEN 1
							WHEN a.jenis_transaksi = "Sales Sales" AND b.kredit > 0 THEN 1
							ELSE 0
						END is_valid,
						CASE 
							WHEN a.jenis_transaksi = "Sales Invoice" THEN
							(
								SELECT id_grlxxmh_customer
								FROM sivxxth th
								WHERE th.id = a.id_transaksi_h
							)
							ELSE
							(
								SELECT id_grlxxmh_customer
								FROM spmxxth th
								WHERE th.id = a.id_transaksi_h
							)
						END AS id_grlxxmh,
						CASE 
							WHEN a.jenis_transaksi = "Sales Invoice" THEN
							(
								SELECT rl.nama
								FROM sivxxth th
								LEFT JOIN grlxxmh rl ON rl.id = th.id_grlxxmh_customer
								WHERE th.id = a.id_transaksi_h
							)
							ELSE
							(
								SELECT rl.nama
								FROM spmxxth th
								LEFT JOIN grlxxmh rl ON rl.id = th.id_grlxxmh_customer
								WHERE th.id = a.id_transaksi_h
							)
						END AS customer
					FROM aglxxth a
					LEFT JOIN aglaktd b ON b.id_aglxxth = a.id
					WHERE a.tanggal < :start_date
						AND jenis_transaksi IN ("Sales Receive", "Sales Invoice")
				)
				SELECT
					0 id,
					"SALDO AWAL" kode_transaksi,
					"" AS jenis_transaksi,
					DATE_FORMAT(DATE_SUB(:start_date, INTERVAL 1 DAY), "%d %b %Y") AS tanggal,
					id_grlxxmh,
					customer,
					"" AS keterangan,
					1 AS is_valid,
					null AS debit,
					null AS kredit,
					DATE_SUB(":start_date 00:00:00", INTERVAL 1 DAY) AS created_on,
					SUM(debit) - SUM(kredit) AS saldo
				FROM saldo_awal
				WHERE is_valid = 1
				GROUP BY customer 
				'.$having.'

				UNION ALL

				SELECT 
					0, 
					"SALDO AWAL", 
					"", 
					DATE_FORMAT(DATE_SUB(:start_date, INTERVAL 1 DAY), "%d %b %Y"), 
					CASE 
						WHEN a.jenis_transaksi = "Sales Invoice" THEN
						(
							SELECT id_grlxxmh_customer
							FROM sivxxth th
							WHERE th.id = a.id_transaksi_h
						)
						ELSE
						(
							SELECT id_grlxxmh_customer
							FROM spmxxth th
							WHERE th.id = a.id_transaksi_h
						)
					END AS id_grlxxmh,
					CASE 
						WHEN a.jenis_transaksi = "Sales Invoice" THEN
						(
							SELECT rl.nama
							FROM sivxxth th
							LEFT JOIN grlxxmh rl ON rl.id = th.id_grlxxmh_customer
							WHERE th.id = a.id_transaksi_h
						)
						ELSE
						(
							SELECT rl.nama
							FROM spmxxth th
							LEFT JOIN grlxxmh rl ON rl.id = th.id_grlxxmh_customer
							WHERE th.id = a.id_transaksi_h
						)
					END AS customer,
					"", 
					1, 
					NULL, 
					NULL, 
					DATE_SUB(":start_date 00:00:00", INTERVAL 1 DAY) AS created_on,
					0
				FROM aglxxth a
				LEFT JOIN aglaktd b ON b.id_aglxxth = a.id
				WHERE a.tanggal BETWEEN :start_date AND :end_date
					AND jenis_transaksi IN ("Sales Receive", "Sales Invoice")
					AND NOT EXISTS (SELECT 1 FROM saldo_awal WHERE is_valid = 1)
				GROUP BY customer 
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
							WHEN a.jenis_transaksi = "Sales Invoice" AND b.debit > 0 THEN 1
							WHEN a.jenis_transaksi = "Sales Receive" AND b.kredit > 0 THEN 1
							ELSE 0
						END is_valid,
						CASE 
							WHEN a.jenis_transaksi = "Sales Invoice" THEN
							(
								SELECT rl.nama
								FROM sivxxth th
								LEFT JOIN grlxxmh rl ON rl.id = th.id_grlxxmh_customer
								WHERE th.id = a.id_transaksi_h
							)
							ELSE
							(
								SELECT rl.nama
								FROM spmxxth th
								LEFT JOIN grlxxmh rl ON rl.id = th.id_grlxxmh_customer
								WHERE th.id = a.id_transaksi_h
							)
						END AS customer
					FROM aglxxth a
					LEFT JOIN aglaktd b ON b.id_aglxxth = a.id
					WHERE a.tanggal < :start_date
						AND jenis_transaksi IN ("Sales Receive", "Sales Invoice")
				),
				saldo_awal_cte AS (
					SELECT
						"SALDO AWAL" AS kode_transaksi,
						customer,
						SUM(debit) - SUM(kredit) AS saldo_awal
					FROM saldo_awal
					WHERE is_valid = 1
					GROUP BY customer 
				),
				transaksi AS (
					SELECT
						b.id,
						a.kode_transaksi,
						a.jenis_transaksi,
						DATE_FORMAT(a.tanggal, "%d %b %Y") AS tanggal,
						CASE 
							WHEN a.jenis_transaksi = "Sales Invoice" THEN
							(
								SELECT id_grlxxmh_customer
								FROM sivxxth th
								WHERE th.id = a.id_transaksi_h
							)
							ELSE
							(
								SELECT id_grlxxmh_customer
								FROM spmxxth th
								WHERE th.id = a.id_transaksi_h
							)
						END AS id_grlxxmh,
						CASE 
							WHEN a.jenis_transaksi = "Sales Invoice" THEN
							(
								SELECT rl.nama
								FROM sivxxth th
								LEFT JOIN grlxxmh rl ON rl.id = th.id_grlxxmh_customer
								WHERE th.id = a.id_transaksi_h
							)
							ELSE
							(
								SELECT rl.nama
								FROM spmxxth th
								LEFT JOIN grlxxmh rl ON rl.id = th.id_grlxxmh_customer
								WHERE th.id = a.id_transaksi_h
							)
						END AS customer,
                        CASE 
							WHEN a.jenis_transaksi = "Sales Invoice" THEN b.keterangan
							WHEN a.jenis_transaksi = "Sales Receive" THEN 
                            (
                                SELECT
                                    GROUP_CONCAT(p.kode) keterangan
                                FROM spmxxth h
                                LEFT JOIN spmivtd d ON d.id_spmxxth = h.id
                                LEFT JOIN sivxxth p ON p.id = d.id_sivxxth
                                WHERE h.id = a.id_transaksi_h
                                GROUP BY h.id 
                            )
							ELSE 0
						END keterangan,
						CASE 
							WHEN a.jenis_transaksi = "Sales Invoice" AND b.debit > 0 THEN 1
							WHEN a.jenis_transaksi = "Sales Receive" AND b.kredit > 0 THEN 1
							ELSE 0
						END is_valid,
						b.debit,
						b.kredit,
						CASE 
							WHEN a.jenis_transaksi = "Sales Invoice" THEN
							(
								SELECT ac.created_on
								FROM activity_log_ml ac
								WHERE ac.kode = "CONFIRM" AND ac.nama = "sivxxth" AND id_transaksi = a.id_transaksi_h
								ORDER BY id DESC
								LIMIT 1
							)
							ELSE
							(
								SELECT ac.created_on
								FROM activity_log_ml ac
								WHERE ac.kode = "CONFIRM" AND ac.nama = "spmxxth" AND id_transaksi = a.id_transaksi_h
								ORDER BY id DESC
								LIMIT 1
							)
						END AS created_on
					FROM aglxxth a
					LEFT JOIN aglaktd b ON b.id_aglxxth = a.id
					WHERE a.tanggal BETWEEN :start_date AND :end_date
						AND jenis_transaksi IN ("Sales Receive", "Sales Invoice")
				)
				SELECT 
					t.id,
					t.kode_transaksi,
					t.jenis_transaksi,
					t.tanggal,
					t.id_grlxxmh,
					t.customer,
					t.keterangan,
					t.is_valid,
					SUM(t.debit) debit,
					SUM(t.kredit) kredit,
					t.created_on,
					COALESCE(s.saldo_awal, 0) 
						+ SUM(SUM(t.debit) - SUM(t.kredit)) OVER (
							PARTITION BY t.customer 
							ORDER BY t.created_on, t.kode_transaksi 
							ROWS BETWEEN UNBOUNDED PRECEDING AND CURRENT ROW
						) AS saldo
				FROM transaksi t
				LEFT JOIN saldo_awal_cte s ON s.customer = t.customer
				WHERE t.is_valid = 1
				GROUP BY kode_transaksi, customer
				'.$having.'
				ORDER BY customer, created_on, kode_transaksi
	');
	$rs_kartu_hutang = $qs_kartu_hutang->fetchAll();

	$all_results = array_merge($rs_saldo_awal, $rs_kartu_hutang);
	
	$data = $all_results;
	require_once( "../../../../usersc/helpers/fn_ajax_results2.php" );
?>