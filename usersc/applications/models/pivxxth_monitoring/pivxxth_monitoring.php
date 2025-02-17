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

	$results = array();

	// Mendapatkan semua akun yang aktif
	$qs_aakxxmh = $db
		->raw()
		->bind(':start_date', $start_date)
		->bind(':end_date', $end_date)
		->exec('SELECT
					e.id,
					e.kode kode_iv,
					DATE_FORMAT(e.tanggal, "%d %b %Y") tanggal_iv,
					e.grand_total,
					a.kode kode_dph,
					DATE_FORMAT(a.tanggal, "%d %b %Y") tanggal_dph,
					b.rencana_bayar rencana_bayar_dph, 
					c.kode kode_pp,
					DATE_FORMAT(c.tanggal, "%d %b %Y") tanggal_pp,
					SUM(d.rencana_bayar) s_rencana_bayar_pp,
					IFNULL(e.grand_total - SUM(d.rencana_bayar), e.grand_total) sisa
				FROM pivxxth e
				LEFT JOIN fprivtd b ON b.id_pivxxth = e.id
				LEFT JOIN fprxxth a ON a.id = b.id_fprxxth
				LEFT JOIN fpmxxth c ON c.id_fprxxth = a.id
				LEFT JOIN fpmivtd d ON d.id_fprivtd = b.id
				WHERE e.transaction_state = 1
				AND e.tanggal BETWEEN :start_date AND :end_date
				GROUP BY e.id
		'
		);
	$rs_aakxxmh = $qs_aakxxmh->fetchAll();
	$data = $rs_aakxxmh;
	require_once( "../../../../usersc/helpers/fn_ajax_results2.php" );
?>