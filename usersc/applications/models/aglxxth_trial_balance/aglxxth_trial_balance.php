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
		->bind(':start_date', $start_date)
		->bind(':end_date', $end_date)
		->exec('WITH aak AS (
					SELECT 
						aak.id,
						aak.kode,
						aak.nama
					FROM aakxxmh aak
					WHERE aak.transaction_state = 1 AND is_parent = 0
				),
				data_agl AS ( 
					SELECT
						a.id_aakxxmh,
						b.kode,
						b.nama,
						IFNULL(SUM(a.debit),0) AS s_debit,
						IFNULL(SUM(a.kredit),0) AS s_kredit
					FROM aakxxmh b
					LEFT JOIN  aglaktd a  ON b.id = a.id_aakxxmh
					LEFT JOIN aglxxth c ON c.id = a.id_aglxxth
					WHERE c.tanggal BETWEEN :start_date AND :end_date
					GROUP BY b.id, b.kode, b.nama
				)
				SELECT
					aak.id,
					aak.kode,
					aak.nama,
					IFNULL(s_saldo_awal,0) saldo_awal,
					IFNULL(data_agl.s_debit,0) debit,
					IFNULL(data_agl.s_kredit,0) kredit,
					IFNULL(s_saldo_awal,0) + IFNULL(data_agl.s_debit,0) - IFNULL(data_agl.s_kredit,0) saldo_akhir
				FROM aak
				LEFT JOIN data_agl ON data_agl.id_aakxxmh = aak.id
				LEFT JOIN (
					SELECT
						a.id_aakxxmh,
						SUM(a.debit) - SUM(a.kredit) AS s_saldo_awal
					FROM aglaktd a
					LEFT JOIN aglxxth c ON c.id = a.id_aglxxth
					WHERE c.tanggal < :start_date
					GROUP BY a.id_aakxxmh
				) d ON d.id_aakxxmh = aak.id
		
		');
	$rs_aakxxmh = $qs_aakxxmh->fetchAll();
	$data = $rs_aakxxmh;
	require_once( "../../../../usersc/helpers/fn_ajax_results2.php" );
?>