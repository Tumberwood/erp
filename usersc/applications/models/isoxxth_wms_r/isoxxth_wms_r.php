<?php
	include_once( "../../../../users/init.php" );
	include_once( "../../../../usersc/lib/DataTables.php" );
	include_once( "../../../../usersc/vendor/autoload.php");
	include_once( "../../../helpers/hakakses_s_fn.php" );
	include_once( "../../../helpers/SolusiIndonesiaUtilities.php" );
	
	use
		DataTables\Editor,
		DataTables\Editor\Field,
		DataTables\Editor\Format,
		DataTables\Editor\Mjoin,
		DataTables\Editor\Options,
		DataTables\Editor\Upload,
		DataTables\Editor\Validate,
		DataTables\Editor\ValidateOptions,
		DataTables\Editor\SearchPaneOptions,
		DataTables\Editor\Query,
		DataTables\Editor\Result;

	use 
		Carbon\Carbon;
	
	$start_date = $_POST['start_date'];
	$end_date = $_POST['end_date'];
	$id_iwhxxmh = $_POST['id_iwhxxmh'];

	$where_wh = '';

	if ($id_iwhxxmh > 0) {
		$where_wh = ' AND a.id_iwhxxmh = '.$id_iwhxxmh;
	}

	$qs_wpllptd = $db
		->raw()
		->bind(':start_date', $start_date)
		->bind(':end_date', $end_date)
		->exec('SELECT
					b.kode,
					DATE_FORMAT(b.tanggal, "%d %b %Y") tanggal,
					e.kode wh,
					d.nama loc,
					c.nama item,
					a.wlpxxmh_kode,
					a.batch_number,
					DATE_FORMAT(a.expired_date, "%d %b %Y") expired_date,
					f.kode uom,
					a.jumlah_terkecil fisik,
					a.jumlah_iiv_terkecil sistem,
					a.jumlah_terkecil - a.jumlah_iiv_terkecil selisih
				FROM isoittd_wms a
				LEFT JOIN isoxxth_wms b ON b.id = a.id_isoxxth_wms
				INNER JOIN iimxxmh c ON c.id = a.id_iimxxmh
				INNER JOIN wloxxmh d ON d.id = a.id_wloxxmh
				INNER JOIN iwhxxmh e ON e.id = a.id_iwhxxmh
				INNER JOIN iumxxmh f ON f.id = a.id_iumxxmh_terkecil
				WHERE b.transaction_state = 1 AND a.transaction_state = 1
				AND b.tanggal BETWEEN :start_date AND :end_date
				' . $where_wh
		);
	$rs_wpllptd = $qs_wpllptd->fetchAll();
	if (!empty($rs_wpllptd)) {
		echo json_encode( ['data' => $rs_wpllptd]);
	}else{

		echo json_encode( [ "data" => [] ] );
	}
?>