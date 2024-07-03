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

	$id_wpclptd = $_POST['id_wpclptd'];

	if ($id_wpclptd > 0) {
		$qs_wpllptd = $db
			->raw()
			->exec('SELECT
						a.jumlah_unit AS jumlah_pl,
						unit.kode AS uom_pl,
						ifnull(s_card, 0) AS jumlah_p,
						a.id,
						a.kode as kode_pl_d,
						a.id_wpcxxth,
						a.id_wloxxmh_tujuan,
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
						e.nama AS wloxxmh_nama,
						terkecil.kode AS iumxxmh_terkecil_kode,
						a.jumlah_terkecil_os,
						a.jumlah_terkecil_next,
						a.jumlah_konversi,
						a.jumlah_terkecil_os / a.jumlah_konversi AS jumlah_default_os,
						def.kode AS iumxxmh_default_kode,
						d.nama AS wloxxmh_out_nama,
						a.status_dispatch,
						c.id_wjtxxmh
					FROM wpclptd a
					LEFT JOIN iimxxmh b ON b.id = a.id_iimxxmh
					LEFT JOIN iumxxmh terkecil ON terkecil.id = a.id_iumxxmh_terkecil
					LEFT JOIN iumxxmh def ON def.id = a.id_iumxxmh_default
					LEFT JOIN iumxxmh unit ON unit.id = a.id_iumxxmh_unit
					LEFT JOIN wpcxxth c ON c.id = a.id_wpcxxth
					LEFT JOIN wloxxmh d ON d.id = c.id_wloxxmh_out
					LEFT JOIN wloxxmh e ON e.id = a.id_wloxxmh_tujuan
					LEFT JOIN (
						SELECT
							id_wpclptd,
							SUM(jumlah_default) AS s_card
						FROM wdplptd
						GROUP BY id_wpclptd
					) f ON f.id_wpclptd = a.id
					WHERE 
						-- a.jumlah_terkecil_os > 0 AND
						a.id = '.$id_wpclptd
					
			);
		$rs_wpllptd = $qs_wpllptd->fetchAll();
	}

	if (!empty($rs_wpllptd)) {
		echo json_encode( ['data' => $rs_wpllptd]);
	}else{

		echo json_encode( [ "data" => [] ] );
	}
	
?>