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

	$qs_wpllptd = $db
		->raw()
		->bind(':start_date', $start_date)
		->bind(':end_date', $end_date)
		->exec('SELECT DISTINCT
					b.kode iimxxmh_kode,
					b.nama iimxxmh_nama,
					a.wlpxxmh_kode,
					customer.nama customer,
					DATE_FORMAT(wdo.tanggal, "%d %b %Y") tanggal,
					ifnull(do_rl.kode, wdo.kode) kode_do,
					ifnull(h.jumlah_unit_do, wdt.jumlah_unit) jumlah_do,
					CONCAT(plth.kode, " - ", a.kode) kode_pl,	
					a.jumlah_unit jumlah_pl,
					if(a.jumlah_terkecil_os = 0 OR g.transaction_state = 1, "Lunas", CONCAT("sisa = ", ROUND(a.jumlah_terkecil_os / a.jumlah_konversi))) ket_pl,
					CONCAT(d.kode) kode_pc,
					d.jumlah_unit jumlah_pc,
					if(d.jumlah_terkecil_os = 0 OR g.transaction_state = 1, "Lunas", CONCAT("sisa = ",ROUND(d.jumlah_terkecil_os / d.jumlah_konversi))) ket_pc,
					e.kode kode_dp,
					e.jumlah_unit jumlah_dp,
					if(e.jumlah_terkecil_os = 0 OR g.transaction_state = 1, "Lunas", CONCAT("sisa = ",ROUND(e.jumlah_terkecil_os / e.jumlah_konversi))) ket_dp,
					IF(g.id > 0, IFNULL(g.kode, "Draft DN"), "") kode_dn,
					f.jumlah_unit jumlah_dn
				FROM wpllptd a
				LEFT JOIN wplxxth plth ON plth.id = a.id_wplxxth
				LEFT JOIN iimxxmh b ON b.id = a.id_iimxxmh
				LEFT JOIN iumxxmh c ON c.id =  a.id_iumxxmh_unit
				LEFT JOIN wpclptd d ON d.id_wpllptd = a.id
				LEFT JOIN wdplptd e ON e.id_wpclptd = d.id
				LEFT JOIN wdnlptd f ON f.id_wdplptd = e.id
				LEFT JOIN wdnxxth g ON g.id = f.id_wdnxxth
				LEFT JOIN wplittd plt ON plt.id = a.id_wplittd
				LEFT JOIN wdoittd wdt ON wdt.id = plt.id_wdoittd	
				LEFT JOIN wdoxxth wdo ON wdo.id = wdt.id_wdoxxth		
				LEFT JOIN grlxxmh customer ON customer.id = wdo.id_grlxxmh_customer		

				LEFT JOIN wdoxxth_wdnxxth h ON h.id_wdoxxth = g.id_wdoxxth AND h.id_wdnxxth = g.id
				LEFT JOIN wdoxxth do_rl ON do_rl.id = h.id_wdoxxth
				WHERE wdo.tanggal BETWEEN :start_date AND :end_date
				ORDER BY a.wlpxxmh_kode
	'
				
		);
	$rs_wpllptd = $qs_wpllptd->fetchAll();
	if (!empty($rs_wpllptd)) {
		echo json_encode( ['data' => $rs_wpllptd]);
	}else{

		echo json_encode( [ "data" => [] ] );
	}
?>