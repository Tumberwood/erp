<?php

	include( "../../../../users/init.php" );
	include( "../../../../usersc/lib/DataTables.php" );

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
					d.kode AS kode_pr,
					b.kode AS kode_po,
					a.nama AS item_pr,
					e.kode AS item_code,
					e.nama AS item_po,
					a.jumlah_unit AS qty_pr,
					uom_pr.nama AS uom_pr,
					ifnull(b.jumlah_unit, 0) AS qty_po,
					uom_po.nama AS uom_po
				FROM prqittd AS a
				LEFT JOIN (
					SELECT
						pod.id,
						pod.kode,
						pod.transaction_state,
						td.jumlah_unit,
						td.id_iimxxmh,
						td.id_iumxxmh_unit,
						td.id_prqittd
					FROM podxxth AS pod
					LEFT JOIN podittd AS td ON td.id_podxxth = pod.id
					WHERE pod.transaction_state = 1
				) AS b ON b.id_prqittd = a.id
				LEFT JOIN prqxxth AS d ON d.id = a.id_prqxxth
				LEFT JOIN iimxxmh AS e ON e.id = b.id_iimxxmh
				LEFT JOIN iumxxmh AS uom_pr ON uom_pr.id = a.id_iumxxmh
				LEFT JOIN iumxxmh AS uom_po ON uom_po.id = b.id_iumxxmh_unit
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

	echo json_encode($results);
?>