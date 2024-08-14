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
	
	
	$qs_wpllptd = $db
		->raw()
		->exec('SELECT
					b.kode iimxxmh_kode,
					b.nama iimxxmh_nama,
					a.wlpxxmh_kode,
					CONCAT(plth.kode, " - ", a.kode) kode_pl,	
					a.jumlah_unit jumlah_pl,
					if(a.jumlah_terkecil_os = 0 OR g.transaction_state = 1, "Lunas", CONCAT("sisa = ", ROUND(a.jumlah_terkecil_os / a.jumlah_konversi))) ket_pl,
					CONCAT(d.kode) kode_pc,
					d.jumlah_unit jumlah_pc,
					if(d.jumlah_terkecil_os = 0 OR g.transaction_state = 1, "Lunas", CONCAT("sisa = ",ROUND(d.jumlah_terkecil_os / d.jumlah_konversi))) ket_pc,
					e.kode kode_dp,
					e.jumlah_unit jumlah_dp,
					if(e.jumlah_terkecil_os = 0 OR g.transaction_state = 1, "Lunas", CONCAT("sisa = ",ROUND(e.jumlah_terkecil_os / e.jumlah_konversi))) ket_dp,
					IFNULL(g.kode, "Draft DN") kode_dn,
					f.jumlah_unit jumlah_dn
				FROM wpllptd a
				LEFT JOIN wplxxth plth ON plth.id = a.id_wplxxth
				LEFT JOIN iimxxmh b ON b.id = a.id_iimxxmh
				LEFT JOIN iumxxmh c ON c.id =  a.id_iumxxmh_unit
				LEFT JOIN wpclptd d ON d.id_wpllptd = a.id
				LEFT JOIN wdplptd e ON e.id_wpclptd = d.id
				LEFT JOIN wdnlptd f ON f.id_wdplptd = e.id
				LEFT JOIN wdnxxth g ON g.id = f.id_wdnxxth
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