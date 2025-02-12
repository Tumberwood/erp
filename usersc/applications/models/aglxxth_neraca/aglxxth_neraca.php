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
						parent1.nama parent1,
						-- parent2.nama parent2,
						-- parent3.nama parent3,
						IF(parent2.nama = IFNULL(parent3.nama, parent2.nama), parent1.nama, parent2.nama) AS parent2,
						IFNULL(parent3.nama, parent2.nama) AS parent3,
						aak.id_aatxxmh,
						aat.nama aatxxmh_nama,
						aak.nama
					FROM aakxxmh aak
					LEFT JOIN aatxxmh aat ON aat.id = aak.id_aatxxmh
					LEFT JOIN aakxxmh parent1 ON parent1.id = aak.id_aakxxmh_parent
					LEFT JOIN aakxxmh parent2 ON parent2.id = parent1.id_aakxxmh_parent
					LEFT JOIN aakxxmh parent3 ON parent3.id = parent2.id_aakxxmh_parent
					WHERE aak.transaction_state = 1 AND aak.is_parent = 0 
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
					AND c.tanggal BETWEEN :start_date AND :end_date
					WHERE c.tanggal BETWEEN :start_date AND :end_date
					GROUP BY b.id, b.kode, b.nama
				)
				SELECT
					aak.id,
					aak.id_aatxxmh,
					aak.kode,
					aak.nama,
                    parent1,
                    parent2,
                    parent3,
					aatxxmh_nama,
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
				;
		
		');
	$rs_aakxxmh = $qs_aakxxmh->fetchAll();
	$data = $rs_aakxxmh;
	require_once( "../../../../usersc/helpers/fn_ajax_results2.php" );
?>