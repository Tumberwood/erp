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

	$start_date_pr = $_POST['start_date_pr'];
	$end_date_pr = $_POST['end_date_pr'];

	if ($start_date_pr == 'Invalid date' || $end_date_pr == 'Invalid date') {
		$where_tgl_pr = '';
	} else {
		$where_tgl_pr = ' AND tanggal_ymd_pr BETWEEN "'.$start_date_pr.'" AND "'.$end_date_pr.'"';
	}

	$start_date_po = $_POST['start_date_po'];
	$end_date_po = $_POST['end_date_po'];

	if ($start_date_po == 'Invalid date' || $end_date_po == 'Invalid date') {
		$where_tgl_po = '';
	} else {
		$where_tgl_po = ' AND tanggal_ymd_po BETWEEN "'.$start_date_po.'" AND "'.$end_date_po.'"';
	}
	

	$qs_outstanding_pr = $db
		->raw()
		->exec('WITH data_prq AS (
					SELECT
						a.id,
						CONCAT(d.kode, " - ", IF(d.approval_state IN (1,9), "Approved", "Draft")) AS kode_pr,
						CONCAT(b.kode, " - ", IF(b.approval_state IN (1,9), "<b>Approved<b>", "<b>Draft<b>")) AS kode_po,
						-- b.kode AS kode_po,
						date_format(b.tanggal,"%d %b %Y") AS tanggal_po,
						date_format(d.tanggal,"%d %b %Y") AS tanggal_pr,
						d.tanggal tanggal_ymd_pr,
						b.tanggal tanggal_ymd_po,
						IFNULL(item_pr.nama, a.nama) AS item_pr,
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
							pod.approval_state,
							td.jumlah_unit,
							td.id_iimxxmh,
							td.id_iumxxmh_unit,
							td.id_prqittd,
							pod.tanggal
						FROM podxxth AS pod
						LEFT JOIN podittd AS td ON td.id_podxxth = pod.id
						WHERE pod.transaction_state <> -9 AND td.transaction_state <> -9
					) AS b ON b.id_prqittd = a.id
					LEFT JOIN prqxxth AS d ON d.id = a.id_prqxxth
					LEFT JOIN iimxxmh AS e ON e.id = b.id_iimxxmh
					LEFT JOIN iimxxmh AS item_pr ON item_pr.id = a.id_iimxxmh
					LEFT JOIN iumxxmh AS uom_pr ON uom_pr.id = a.id_iumxxmh
					LEFT JOIN iumxxmh AS uom_po ON uom_po.id = b.id_iumxxmh_unit
					WHERE d.transaction_state = 1
				),
				sisa AS (
					SELECT
						id,
						SUM(qty_po) - qty_pr AS sisa
					FROM data_prq
					GROUP BY id
				)
				SELECT
					sisa.id,
					kode_pr,
					kode_po,
					tanggal_po,
					tanggal_pr,
					tanggal_ymd_pr,
					tanggal_ymd_po,
					DATEDIFF(IFNULL(tanggal_ymd_po, CURDATE()), tanggal_ymd_pr) AS pemenuhan,
					item_pr,
					item_code,
					item_po,
					qty_pr,
					uom_pr,
					qty_po,
					uom_po,
					sisa
				FROM data_prq
				left join sisa on sisa.id = data_prq.id
				WHERE 1
				' .$where_tgl_pr . $where_tgl_po
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