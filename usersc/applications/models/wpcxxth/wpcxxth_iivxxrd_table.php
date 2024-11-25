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
	$uniqueToken = $_POST['uniqueToken'];

	// echo $uniqueToken;

	if ($id_wpcxxth_old > 0 && $uniqueToken != '') {
		//Picking tampa Kitting

		// $qs_wpllptd = $db
		// 	->raw()
		// 	->bind(':uniqueToken', $uniqueToken)
		// 	->exec('SELECT
		// 				a.jumlah_unit AS jumlah_pl,
		// 				unit.kode AS uom_pl,
		// 				ifnull(s_card, 0) AS jumlah_p,
		// 				ifnull(book.jumlah_default, 0) AS jumlah_default_now,
		// 				ifnull(book.jumlah_terkecil, 0) AS jumlah_terkecil_now,
		// 				-- (a.jumlah_terkecil_os / a.jumlah_konversi) + ifnull(book.jumlah_default, 0) as sisa_default_now,
		// 				(a.jumlah_terkecil_os / a.jumlah_konversi) + ifnull(book.jumlah_default, 0) as jumlah_default_os,
		// 				-- (a.jumlah_terkecil_os / a.jumlah_konversi) - ifnull(book.jumlah_default, 0) as sisa_default,
		// 				a.jumlah_terkecil_os + ifnull(book.jumlah_terkecil, 0) as sisa_terkecil_now,
		// 				a.id,
		// 				a.id_wpcxxth,
		// 				a.id_wloxxmh,
		// 				a.id_iwhxxmh,
		// 				a.id_iimxxmh,
		// 				a.id_iumxxmh_unit,
		// 				a.id_iumxxmh_terkecil,
		// 				a.id_iumxxmh_default,
		// 				a.jumlah_unit,
		// 				a.jumlah_terkecil,
		// 				a.jumlah_default,
		// 				a.wlpxxmh_kode,
		// 				DATE_FORMAT(a.expired_date, "%d %b %Y") expired_date,
		// 				a.batch_number,
		// 				b.kode AS iimxxmh_kode,
		// 				b.nama AS iimxxmh_nama,
		// 				a.wloxxmh_nama,
		// 				terkecil.kode AS iumxxmh_terkecil_kode,
		// 				a.jumlah_terkecil_os,
		// 				a.jumlah_terkecil_next,
		// 				a.jumlah_konversi,
		// 				a.jumlah_terkecil_os / a.jumlah_konversi AS sisa_default,
		// 				-- a.jumlah_terkecil_os / a.jumlah_konversi AS jumlah_default_os,
		// 				def.kode AS iumxxmh_default_kode,
		// 				d.nama AS wloxxmh_out_nama,
		// 				ifnull(e.urutan, 0) AS urutan,
		// 				a.status_picking,
		// 				c.id_wjtxxmh
		// 			FROM wpllptd a
		// 			LEFT JOIN iimxxmh b ON b.id = a.id_iimxxmh
		// 			LEFT JOIN iumxxmh terkecil ON terkecil.id = a.id_iumxxmh_terkecil
		// 			LEFT JOIN iumxxmh def ON def.id = a.id_iumxxmh_default
		// 			LEFT JOIN iumxxmh unit ON unit.id = a.id_iumxxmh_unit
		// 			LEFT JOIN wpcxxth c ON c.id = a.id_wpcxxth
		// 			LEFT JOIN wloxxmh d ON d.id = c.id_wloxxmh_out
		// 			LEFT JOIN wimlotd e ON e.id_iimxxmh = a.id_iimxxmh AND e.id_wloxxmh = a.id_wloxxmh
		// 			LEFT JOIN (
		// 				SELECT
		// 					id_wpllptd,
		// 					SUM(jumlah_default) AS s_card
		// 				FROM wpclptd
		// 				GROUP BY id_wpllptd
		// 			) f ON f.id_wpllptd = a.id
		// 			LEFT JOIN wpclptd book on book.id_wpllptd = a.id AND book.keterangan = :uniqueToken
		// 			WHERE 
		// 				-- a.jumlah_terkecil_os > 0 AND
		// 				a.id_wpcxxth = '.$id_wpcxxth_old .'
		// 			HAVING sisa_terkecil_now > 0
		// 			ORDER BY urutan'
					
		// 	);
		// $rs_wpllptd = $qs_wpllptd->fetchAll();

		//Picking Union dari PL dan Picking
		$qs_wpllptd = $db
			->raw()
			->bind(':uniqueToken', $uniqueToken)
			->exec('SELECT
						a.jumlah_unit AS jumlah_pl,
						unit.kode AS uom_pl,
						ifnull(s_card, 0) AS jumlah_p,
						ifnull(book.jumlah_default, 0) AS jumlah_default_now,
						ifnull(book.jumlah_terkecil, 0) AS jumlah_terkecil_now,
						-- (a.jumlah_terkecil_os / a.jumlah_konversi) + ifnull(book.jumlah_default, 0) as sisa_default_now,
						(a.jumlah_terkecil_os / uom_def.jumlah_konversi) + ifnull(book.jumlah_default, 0) as jumlah_default_os,
						-- (a.jumlah_terkecil_os / a.jumlah_konversi) - ifnull(book.jumlah_default, 0) as sisa_default,
						a.jumlah_terkecil_os + ifnull(book.jumlah_terkecil, 0) as sisa_terkecil_now,
						a.id,
						a.id_wpcxxth,
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
						a.jumlah_terkecil_os / a.jumlah_konversi AS sisa_default,
						-- a.jumlah_terkecil_os / a.jumlah_konversi AS jumlah_default_os,
						def.kode AS iumxxmh_default_kode,
						d.nama AS wloxxmh_out_nama,
						ifnull(e.urutan, 0) AS urutan,
						a.status_picking,
						c.id_wjtxxmh
					FROM wpllptd a
					LEFT JOIN iimxxmh b ON b.id = a.id_iimxxmh
					LEFT JOIN iumxxmh terkecil ON terkecil.id = a.id_iumxxmh_terkecil
					LEFT JOIN iumxxmh def ON def.id = a.id_iumxxmh_default
					LEFT JOIN iimummd uom_def ON uom_def.id_iumxxmh = a.id_iumxxmh_default AND uom_def.id_iimxxmh = b.id
					LEFT JOIN iumxxmh unit ON unit.id = a.id_iumxxmh_unit
					LEFT JOIN wpcxxth c ON c.id = a.id_wpcxxth
					LEFT JOIN wloxxmh d ON d.id = c.id_wloxxmh_out
					LEFT JOIN wimlotd e ON e.id_iimxxmh = a.id_iimxxmh AND e.id_wloxxmh = a.id_wloxxmh
					LEFT JOIN (
						SELECT
							id_wpllptd,
							SUM(jumlah_default) AS s_card
						FROM wpclptd
						GROUP BY id_wpllptd
					) f ON f.id_wpllptd = a.id
					LEFT JOIN wpclptd book on book.id_wpllptd = a.id AND book.keterangan = :uniqueToken
					WHERE 
						-- a.jumlah_terkecil_os > 0 AND
						a.id_wpcxxth = '.$id_wpcxxth_old .'
					HAVING sisa_terkecil_now > 0

					UNION ALL

					SELECT
						a.jumlah_unit AS jumlah_pl,
						unit.kode AS uom_pl,
						ifnull(s_card, 0) AS jumlah_p,
						ifnull(book.jumlah_default, 0) AS jumlah_default_now,
						ifnull(book.jumlah_terkecil, 0) AS jumlah_terkecil_now,
						-- (a.jumlah_terkecil_os / a.jumlah_konversi) + ifnull(book.jumlah_default, 0) as sisa_default_now,
						(a.jumlah_terkecil_os / uom_def.jumlah_konversi) + ifnull(book.jumlah_default, 0) as jumlah_default_os,
						-- (a.jumlah_terkecil_os / a.jumlah_konversi) - ifnull(book.jumlah_default, 0) as sisa_default,
						a.jumlah_terkecil_os + ifnull(book.jumlah_terkecil, 0) as sisa_terkecil_now,
						a.id,
						a.id_wpcxxth,
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
						a.jumlah_terkecil_os / a.jumlah_konversi AS sisa_default,
						-- a.jumlah_terkecil_os / a.jumlah_konversi AS jumlah_default_os,
						def.kode AS iumxxmh_default_kode,
						d.nama AS wloxxmh_out_nama,
						ifnull(e.urutan, 0) AS urutan,
						a.status_picking,
						c.id_wjtxxmh
					FROM wktlptd a
					LEFT JOIN iimxxmh b ON b.id = a.id_iimxxmh
					LEFT JOIN iumxxmh terkecil ON terkecil.id = a.id_iumxxmh_terkecil
					LEFT JOIN iumxxmh def ON def.id = a.id_iumxxmh_default
					LEFT JOIN iimummd uom_def ON uom_def.id_iumxxmh = a.id_iumxxmh_default AND uom_def.id_iimxxmh = b.id
					LEFT JOIN iumxxmh unit ON unit.id = a.id_iumxxmh_unit
					LEFT JOIN wpcxxth c ON c.id = a.id_wpcxxth
					LEFT JOIN wloxxmh d ON d.id = c.id_wloxxmh_out
					LEFT JOIN wimlotd e ON e.id_iimxxmh = a.id_iimxxmh AND e.id_wloxxmh = a.id_wloxxmh
					LEFT JOIN (
						SELECT
							id_wktlptd,
							SUM(jumlah_default) AS s_card
						FROM wpclptd
						GROUP BY id_wktlptd
					) f ON f.id_wktlptd = a.id
					LEFT JOIN wpclptd book on book.id_wktlptd = a.id AND book.keterangan = :uniqueToken
					WHERE 
						-- a.jumlah_terkecil_os > 0 AND
						a.id_wpcxxth = '.$id_wpcxxth_old .'
					HAVING sisa_terkecil_now > 0

					ORDER BY urutan'
					
			);
		$rs_wpllptd = $qs_wpllptd->fetchAll();
	}

	if (!empty($rs_wpllptd)) {
		echo json_encode( ['data' => $rs_wpllptd]);
	}else{

		echo json_encode( [ "data" => [] ] );
	}
	
?>