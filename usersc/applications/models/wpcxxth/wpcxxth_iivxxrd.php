<?php
	/**
	 * 
	 */

	include( "../../../../users/init.php" );
	include( "../../../../usersc/lib/DataTables.php" );

	require '../../../../usersc/vendor/autoload.php';
	use Carbon\Carbon;
	
	use
		DataTables\Editor,
		DataTables\Editor\Query,
		DataTables\Editor\Result;

	$id_wpcxxth_old = $_POST['id_wpcxxth_old'];

	$qs_wpllptd = $db
		->raw()
		->exec('SELECT
					a.id,
					a.id_wloxxmh,
					a.id_iwhxxmh,
					a.id_iimxxmh,
					a.id_iumxxmh_unit,
					a.id_iumxxmh_terkecil,
					a.id_iumxxmh_default,
					a.jumlah_unit,
					a.jumlah_terkecil,
					a.jumlah_default,
					a.wlpxxmh_kode,
					DATE_FORMAT(a.expired_date, "%d %b %Y") expired_date,
					a.batch_number,
					b.kode AS iimxxmh_kode,
					b.nama AS iimxxmh_nama,
					a.wloxxmh_nama,
					terkecil.kode AS iumxxmh_terkecil_kode,
					a.jumlah_terkecil_os,
					a.jumlah_terkecil_next,
					a.jumlah_konversi,
					a.jumlah_terkecil_os / a.jumlah_konversi AS jumlah_default_os,
					def.kode AS iumxxmh_default_kode,
					d.nama AS wloxxmh_out_nama,
					ifnull(e.urutan, 99999999) AS urutan,
					c.id_wjtxxmh
				FROM wpllptd a
				LEFT JOIN iimxxmh b ON b.id = a.id_iimxxmh
				LEFT JOIN iumxxmh terkecil ON terkecil.id = a.id_iumxxmh_terkecil
				LEFT JOIN iumxxmh def ON def.id = a.id_iumxxmh_default
				LEFT JOIN wpcxxth c ON c.id = a.id_wpcxxth
				LEFT JOIN wloxxmh d ON d.id = c.id_wloxxmh_out
				LEFT JOIN wimlotd e ON e.id_iimxxmh = a.id_iimxxmh AND e.id_wloxxmh = a.id_wloxxmh
				WHERE 
					-- a.jumlah_terkecil_os > 0 AND
					a.id_wpcxxth = '.$id_wpcxxth_old .'
				ORDER BY urutan'
				
		);
	$rs_wpllptd = $qs_wpllptd->fetchAll();
	if (!empty($rs_wpllptd)) {
		echo json_encode( ['data' => $rs_wpllptd]);
	}else{

		echo json_encode( [ "data" => [] ] );
	}
	
?>