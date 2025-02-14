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
		
	$is_reconcile = $_POST['is_reconcile'];
	$start_date = $_POST['start_date'];
	$end_date = $_POST['end_date'];

	$where = 'AND a.is_reconcile IN ' . $is_reconcile;
	if ($_POST['id_aakxxmh'] > 0) {
		$where = ' AND c.id = '.$_POST['id_aakxxmh'];
	}

	// echo $where;

	$results = array();
	$all_results = [];

	$qs_aglaktd = $db
		->raw()
		// ->bind(':is_reconcile', $is_reconcile)
		->bind(':start_date', $start_date)
		->bind(':end_date', $end_date)
		->exec('SELECT
					a.id,
					DATE_FORMAT(b.tanggal, "%d %b %Y") tanggal,
					b.kode_transaksi,
					a.keterangan,
					a.debit_kredit,
					if(a.debit_kredit = "Debit", a.debit, if(a.debit_kredit = "Kredit", a.kredit, 0)) amount,
					a.is_reconcile
				FROM aglaktd a
				LEFT JOIN aglxxth b ON b.id = a.id_aglxxth
				LEFT JOIN aakxxmh c ON c.id = a.id_aakxxmh
				WHERE b.tanggal BETWEEN :start_date AND :end_date
				AND c.id_aakxxmh_parent = 12
	' .$where
	);
	$rs_aglaktd = $qs_aglaktd->fetchAll();
	
	$data = $rs_aglaktd;
	require_once( "../../../../usersc/helpers/fn_ajax_results2.php" );
?>