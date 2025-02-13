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
		
	$start_date_awal = $_POST['start_date_awal'];
	$end_date_awal = $_POST['end_date_awal'];

	$start_date_akhir = $_POST['start_date_akhir'];
	$end_date_akhir = $_POST['end_date_akhir'];

	$is_akunbertransaksi = $_POST['is_akunbertransaksi'];
	$is_akunbernilai = $_POST['is_akunbernilai'];

	$results = array();

	// Mendapatkan semua akun yang aktif
	$qs_aakxxmh = $db
		->raw()
		->bind(':start_date_awal', $start_date_awal)
		->bind(':end_date_awal', $end_date_awal)

		->bind(':start_date_akhir', $start_date_akhir)
		->bind(':end_date_akhir', $end_date_akhir)
		->exec('WITH aak AS (
					SELECT 
						aak.id,
						aak.kode,
						aak.id_aatxxmh,
						UPPER(aat.nama) aatxxmh_nama,
						aak.nama
					FROM aakxxmh aak
					LEFT JOIN aatxxmh aat ON aat.id = aak.id_aatxxmh
					WHERE aak.transaction_state = 1 AND aak.is_parent = 0 
					-- AND aak.id_aatxxmh IN (12,13,14,16,15)
				),
				awal_period AS ( 
					SELECT
						a.id_aakxxmh,
						b.kode,
						b.nama,
						IFNULL(SUM(a.debit),0) AS s_debit,
						IFNULL(SUM(a.kredit),0) AS s_kredit
					FROM aakxxmh b
					LEFT JOIN  aglaktd a  ON b.id = a.id_aakxxmh
					LEFT JOIN aglxxth c ON c.id = a.id_aglxxth
					WHERE c.tanggal BETWEEN :start_date_awal AND :end_date_awal
					GROUP BY b.id, b.kode, b.nama
				),
				akhir_period AS ( 
					SELECT
						a.id_aakxxmh,
						b.kode,
						b.nama,
						IFNULL(SUM(a.debit),0) AS s_debit,
						IFNULL(SUM(a.kredit),0) AS s_kredit
					FROM aakxxmh b
					LEFT JOIN  aglaktd a  ON b.id = a.id_aakxxmh
					LEFT JOIN aglxxth c ON c.id = a.id_aglxxth
					WHERE c.tanggal BETWEEN :start_date_akhir AND :end_date_akhir
					GROUP BY b.id, b.kode, b.nama
				),
				data_aak AS (
					SELECT
						aak.id,
						aak.id_aatxxmh,
						aak.kode,
						aak.nama,
						aatxxmh_nama,
						CASE 
							WHEN id_aatxxmh = 12 THEN 1
							WHEN id_aatxxmh = 13 THEN 2
							WHEN id_aatxxmh = 14 THEN 3
							WHEN id_aatxxmh = 16 THEN 4
							ELSE 5
						END AS urutan,
						IFNULL(awal_period.s_debit,0) - IFNULL(awal_period.s_kredit,0) saldo_akhir1,
						IFNULL(akhir_period.s_debit,0) - IFNULL(akhir_period.s_kredit,0) saldo_akhir2,
						(IFNULL(awal_period.s_debit,0) - IFNULL(awal_period.s_kredit,0))
						+
						(IFNULL(akhir_period.s_debit,0) - IFNULL(akhir_period.s_kredit,0)) saldo_akhir3
					FROM aak
					LEFT JOIN awal_period ON awal_period.id_aakxxmh = aak.id
					LEFT JOIN akhir_period ON akhir_period.id_aakxxmh = aak.id
					WHERE aak.id_aatxxmh IN (12,13,14,16,15)
				)
				-- mengurutkan Type Pendapatan, Beban Pokok Penjualan, Beban, Pendapatan Lainnya, Beban Lainnya
				SELECT
					*
				FROM data_aak
				WHERE data_aak.id_aatxxmh = 12

				UNION ALL

				SELECT
					*
				FROM data_aak
				WHERE data_aak.id_aatxxmh = 13


				UNION ALL

				SELECT
					*
				FROM data_aak
				WHERE data_aak.id_aatxxmh = 14

				UNION ALL

				SELECT
					*
				FROM data_aak
				WHERE data_aak.id_aatxxmh = 16
				UNION ALL

				SELECT
					*
				FROM data_aak
				WHERE data_aak.id_aatxxmh = 15
				;
				;
		
		');
	$rs_aakxxmh = $qs_aakxxmh->fetchAll();
	$data = $rs_aakxxmh;
	require_once( "../../../../usersc/helpers/fn_ajax_results2.php" );
?>