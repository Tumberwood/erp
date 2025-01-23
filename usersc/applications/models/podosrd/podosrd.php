<?php

	include( "../../../../users/init.php" );
	include( "../../../../usersc/lib/DataTables.php" );
	require_once( "../../../../usersc/helpers/datatables_fn_debug.php" );
	require '../../../../usersc/vendor/autoload.php';
	use Carbon\Carbon;
	
	use
		DataTables\Editor,
		DataTables\Editor\Query,
		DataTables\Editor\Result;

	$qs_outstanding_pr = $db
		->raw()
		->exec('SELECT
					a.id,
					d.kode AS kode_po,
					b.kode AS kode_prc,
					date_format(b.tanggal,"%d %b %Y") AS tanggal_prc,
					IFNULL(item_po.nama, a.nama) AS item_po,
					e.kode AS item_code,
					e.nama AS item_prc,
					a.jumlah_unit AS qty_po,
					uom_po.nama AS uom_po,
					ifnull(b.jumlah_unit, 0) AS qty_prc,
					uom_prc.nama AS uom_prc
				FROM podittd AS a
				LEFT JOIN (
					SELECT
						prc.id,
						prc.kode,
						prc.transaction_state,
						td.jumlah_unit,
						td.id_iimxxmh,
						td.id_iumxxmh_unit,
						td.id_podittd,
						prc.tanggal
					FROM prcxxth AS prc
					LEFT JOIN prcittd AS td ON td.id_prcxxth = prc.id
					WHERE prc.transaction_state = 1
				) AS b ON b.id_podittd = a.id
				LEFT JOIN podxxth AS d ON d.id = a.id_podxxth
				LEFT JOIN iimxxmh AS e ON e.id = b.id_iimxxmh
				LEFT JOIN iimxxmh AS item_po ON item_po.id = a.id_iimxxmh
				LEFT JOIN iumxxmh AS uom_po ON uom_po.id = a.id_iumxxmh_unit
				LEFT JOIN iumxxmh AS uom_prc ON uom_prc.id = b.id_iumxxmh_unit
				WHERE d.transaction_state = 1
				'
				);
	$rs_outstanding_pr = $qs_outstanding_pr->fetchAll();

	$results = array();

	if (!empty($rs_outstanding_pr)) {
		$results['data'] = $rs_outstanding_pr;
	} else {
		$results['data'] = [];
	}

	// debugging hak akses
	$results['debug'] = $debug;

	echo json_encode($results);
?>