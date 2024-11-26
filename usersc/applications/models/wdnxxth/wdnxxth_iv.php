<?php
	include( "../../../../users/init.php" );
	include( "../../../../usersc/lib/DataTables.php" );
	include( "../../../../usersc/helpers/datatables_fn_debug.php" );
    require '../../../../usersc/vendor/autoload.php';

    use Carbon\Carbon;
	
	use
		DataTables\Editor,
		DataTables\Editor\Query,
		DataTables\Editor\Result;

	// BEGIN definisi variable untuk fn_ajax_results.php
	$data      = array();
	$rs_opt    = array();
	$c_rs_opt  = 0;
	$morePages = 0;
	// END definisi variable untuk fn_ajax_results.php

	try{
		$db->transaction();
		
		// ganti movement type sesuai jenis transaksi
		$imtxxmh_kode = 217;

		$id    = $_POST['id_transaksi_h'];
		$state = $_POST['state'];

		$qs_ggswmsh = $db
			->query('select', 'ggswmsh' )
			->get([
				'is_replenishment',
				'is_one_way_do'
				] )
			->where('id', 1 )
			->exec();
		$rs_ggswmsh = $qs_ggswmsh->fetch();
		$is_replenishment = $rs_ggswmsh['is_replenishment'];
		$is_one_way_do = $rs_ggswmsh['is_one_way_do'];

		//jurnal balik, booking +
		$qi_iivxxrd = $db
			->raw()
			->bind(':id', $id)
			->exec('INSERT INTO iivxxrd (
						id_transaksi_h,
						id_transaksi_d,
						id_wloctmh,
						kode,
						wlpxxmh_kode,
						id_iwhxxmh,
						id_wloxxmh,
						id_relasi_m,
						id_iimxxmh,
						id_iumxxmh_unit,
						id_iumxxmh_terkecil,
						id_iumxxmh_default,
						keterangan,
						iwhxxmh_kode,
						iwhxxmh_nama,
						wloxxmh_kode,
						wloxxmh_nama,
						relasi_m_kode,
						relasi_m_nama,
						iimxxmh_kode,
						iimxxmh_nama,
						iumxxmh_unit_kode,
						iumxxmh_unit_nama,
						imtxxmh_kode,
						imtxxmh_movement_type,
						tanggal,
						is_fisik,
						iumxxmh_terkecil_kode,
						iumxxmh_terkecil_nama,
						iumxxmh_default_kode,
						iumxxmh_default_nama,
						jumlah_unit,
						jumlah_konversi,
						jumlah_terkecil,
						jumlah_default,
						expired_date,
						batch_number
					)
					SELECT DISTINCT
						a.id_wdnxxth AS id_transaksi_h,
						a.id AS id_transaksi_d,
						wlo.id_wloctmh,
						"" AS kode,
						a.wlpxxmh_kode,
						wlo.id_iwhxxmh,
						wlo.id AS id_wloxxmh,
						c.id_grlxxmh_customer AS id_relasi_m,
						a.id_iimxxmh,
						a.id_iumxxmh_unit,
						a.id_iumxxmh_terkecil,
						a.id_iumxxmh_default,
						CONCAT("Booking Jurnal Balik DN id_wdnxxth=", a.id_wdnxxth) AS keterangan,
						iwh.kode AS iwhxxmh_kode,
						iwh.nama AS iwhxxmh_nama,
						wlo.kode AS wloxxmh_kode,
						wlo.nama AS wloxxmh_nama,
						cs.kode AS relasi_m_kode,
						cs.nama AS relasi_m_nama,
						item.kode AS iimxxmh_kode,
						item.nama AS iimxxmh_nama,
						unit.kode AS iumxxmh_unit_kode,
						unit.nama AS iumxxmh_unit_nama,
						217,
						imt.movement_type,
						CURDATE(),
						0 AS is_fisik,
						iumxxmh_terkecil.kode AS iumxxmh_terkecil_kode,
						iumxxmh_terkecil.nama AS iumxxmh_terkecil_nama,
						iumxxmh_default.kode AS iumxxmh_default_kode,
						iumxxmh_default.nama AS iumxxmh_default_nama,
						a.jumlah_unit,
						a.jumlah_konversi,
						a.jumlah_terkecil,
						a.jumlah_default,
						a.expired_date,
						a.batch_number
					FROM wdnlptd a
					LEFT JOIN wdplptd b ON b.id = a.id_wdplptd
					LEFT JOIN wdnxxth c ON c.id = a.id_wdnxxth
					LEFT JOIN wloxxmh wlo ON wlo.id = b.id_wloxxmh_tujuan
					LEFT JOIN iwhxxmh iwh ON iwh.id = wlo.id_iwhxxmh
					LEFT JOIN grlxxmh cs ON cs.id = c.id_grlxxmh_customer
					LEFT JOIN iimxxmh item ON item.id = a.id_iimxxmh
					LEFT JOIN iumxxmh iumxxmh_terkecil ON iumxxmh_terkecil.id = a.id_iumxxmh_terkecil
					LEFT JOIN iumxxmh iumxxmh_default ON iumxxmh_default.id = a.id_iumxxmh_default
					LEFT JOIN iumxxmh unit ON unit.id = a.id_iumxxmh_unit
					LEFT JOIN imtxxmh imt ON imt.kode = 217
					WHERE a.id_wdnxxth = :id;
		');

		$qi_iivxxrd = $db
			->raw()
			->bind(':id', $id)
			->exec('INSERT INTO iivxxrd (
						id_transaksi_h,
						id_transaksi_d,
						id_wloctmh,
						kode,
						wlpxxmh_kode,
						id_iwhxxmh,
						id_wloxxmh,
						id_relasi_m,
						id_iimxxmh,
						id_iumxxmh_unit,
						id_iumxxmh_terkecil,
						id_iumxxmh_default,
						keterangan,
						iwhxxmh_kode,
						iwhxxmh_nama,
						wloxxmh_kode,
						wloxxmh_nama,
						relasi_m_kode,
						relasi_m_nama,
						iimxxmh_kode,
						iimxxmh_nama,
						iumxxmh_unit_kode,
						iumxxmh_unit_nama,
						imtxxmh_kode,
						imtxxmh_movement_type,
						tanggal,
						is_fisik,
						iumxxmh_terkecil_kode,
						iumxxmh_terkecil_nama,
						iumxxmh_default_kode,
						iumxxmh_default_nama,
						jumlah_unit,
						jumlah_konversi,
						jumlah_terkecil,
						jumlah_default,
						expired_date,
						batch_number
					)
					SELECT DISTINCT
						a.id_wdnxxth AS id_transaksi_h,
						a.id AS id_transaksi_d,
						wlo.id_wloctmh,
						"" AS kode,
						a.wlpxxmh_kode,
						wlo.id_iwhxxmh,
						wlo.id AS id_wloxxmh,
						c.id_grlxxmh_customer AS id_relasi_m,
						a.id_iimxxmh,
						a.id_iumxxmh_unit,
						a.id_iumxxmh_terkecil,
						a.id_iumxxmh_default,
						CONCAT("Minus di Transit Out karena Confirm DN id_wdnxxth=", a.id_wdnxxth) AS keterangan,
						iwh.kode AS iwhxxmh_kode,
						iwh.nama AS iwhxxmh_nama,
						wlo.kode AS wloxxmh_kode,
						wlo.nama AS wloxxmh_nama,
						cs.kode AS relasi_m_kode,
						cs.nama AS relasi_m_nama,
						item.kode AS iimxxmh_kode,
						item.nama AS iimxxmh_nama,
						unit.kode AS iumxxmh_unit_kode,
						unit.nama AS iumxxmh_unit_nama,
						217,
						imt.movement_type,
						CURDATE(),
						1 AS is_fisik,
						iumxxmh_terkecil.kode AS iumxxmh_terkecil_kode,
						iumxxmh_terkecil.nama AS iumxxmh_terkecil_nama,
						iumxxmh_default.kode AS iumxxmh_default_kode,
						iumxxmh_default.nama AS iumxxmh_default_nama,
						-a.jumlah_unit,
						a.jumlah_konversi,
						-a.jumlah_terkecil,
						-a.jumlah_default,
						a.expired_date,
						a.batch_number
					FROM wdnlptd a
					LEFT JOIN wdplptd b ON b.id = a.id_wdplptd
					LEFT JOIN wdnxxth c ON c.id = a.id_wdnxxth
					LEFT JOIN wloxxmh wlo ON wlo.id = b.id_wloxxmh_tujuan
					LEFT JOIN iwhxxmh iwh ON iwh.id = wlo.id_iwhxxmh
					LEFT JOIN grlxxmh cs ON cs.id = c.id_grlxxmh_customer
					LEFT JOIN iimxxmh item ON item.id = a.id_iimxxmh
					LEFT JOIN iumxxmh iumxxmh_terkecil ON iumxxmh_terkecil.id = a.id_iumxxmh_terkecil
					LEFT JOIN iumxxmh iumxxmh_default ON iumxxmh_default.id = a.id_iumxxmh_default
					LEFT JOIN iumxxmh unit ON unit.id = a.id_iumxxmh_unit
					LEFT JOIN imtxxmh imt ON imt.kode = 217
					WHERE a.id_wdnxxth = :id;
		');

		//select wdo atau Delivery Order
		$qs_wdnxxth = $db
			->query('select', 'wdnxxth' )
			->get(['id_wdoxxth'] )
			->where('id', $id )
			->exec();
		$rs_wdnxxth = $qs_wdnxxth->fetch();
		$id_wdoxxth = $rs_wdnxxth['id_wdoxxth'];

		//insert ke Location Return untuk items yang sisa dari PL sampai DP
		
		//cek apakah ada item PL yang belum di Picking
		$qs_wpc = $db
			->raw()
			->bind(':id_wdoxxth', $id_wdoxxth)
			->exec('SELECT
						a.id_wplxxth,
						it.id_wdoittd,
						a.id_wpcxxth,
						a.id_wloxxmh,
						f.nama wloxxmh_nama,
						a.id_iimxxmh,
						c.nama iimxxmh_nama,
						d.kode iumxxmh_kode,
						a.wlpxxmh_kode,
						COUNT(b.id) c_id_pc,
						a.jumlah_unit AS jumlah_unit_pl,
						SUM(ifnull(b.jumlah_unit,0)) AS jumlah_unit_pc,
						a.jumlah_unit - SUM(ifnull(b.jumlah_unit,0)) AS sisa_pl,
						a.jumlah_default - SUM(ifnull(b.jumlah_default,0)) AS sisa_pl_default,
						a.jumlah_terkecil - SUM(ifnull(b.jumlah_terkecil,0)) AS sisa_pl_terkecil
					FROM wpllptd a
					LEFT JOIN wplittd it ON it.id = a.id_wplittd
					LEFT JOIN wpclptd b ON b.id_wpllptd = a.id
					LEFT JOIN iimxxmh c ON c.id = a.id_iimxxmh
					LEFT JOIN iumxxmh d ON d.id = a.id_iumxxmh_unit
					LEFT JOIN wdoittd e ON e.id = it.id_wdoittd 
					LEFT JOIN wloxxmh f ON f.id = a.id_wloxxmh
					LEFT JOIN wplxxth h ON h.id = a.id_wplxxth
					WHERE e.id_wdoxxth = :id_wdoxxth AND h.transaction_state <> 9
					GROUP BY a.id
					HAVING sisa_pl > 0
			'
			);
		$rs_wpc = $qs_wpc->fetchAll();
		if (!empty($rs_wpc)) {
			foreach ($rs_wpc as $key => $rs_wpcxxth) {
				$id_wplxxth = $rs_wpcxxth['id_wplxxth'];
				$id_wdoittd = $rs_wpcxxth['id_wdoittd'];
				$id_wpcxxth = $rs_wpcxxth['id_wpcxxth'];
				$sisa_pl = $rs_wpcxxth['sisa_pl'];
				$sisa_pl_terkecil = $rs_wpcxxth['sisa_pl_terkecil'];

				//Plus di Bookingan Picking List dulu. Jurnal balik
				$qi_pl_book = $db
					->raw()
					->bind(':id', $id)
					->bind(':id_wdoxxth', $id_wdoxxth)
					->exec('INSERT INTO iivxxrd (
								id_transaksi_h,
								id_transaksi_d,
								id_wloctmh,
								kode,
								wlpxxmh_kode,
								id_iwhxxmh,
								id_wloxxmh,
								id_relasi_m,
								id_iimxxmh,
								id_iumxxmh_unit,
								id_iumxxmh_terkecil,
								id_iumxxmh_default,
								keterangan,
								iwhxxmh_kode,
								iwhxxmh_nama,
								wloxxmh_kode,
								wloxxmh_nama,
								relasi_m_kode,
								relasi_m_nama,
								iimxxmh_kode,
								iimxxmh_nama,
								iumxxmh_unit_kode,
								iumxxmh_unit_nama,
								imtxxmh_kode,
								imtxxmh_movement_type,
								tanggal,
								is_fisik,
								iumxxmh_terkecil_kode,
								iumxxmh_terkecil_nama,
								iumxxmh_default_kode,
								iumxxmh_default_nama,
								jumlah_unit,
								jumlah_konversi,
								jumlah_terkecil,
								jumlah_default,
								expired_date,
								batch_number
							)
							SELECT DISTINCT
								:id AS id_transaksi_h,
								a.id AS id_transaksi_d,
								wlo.id_wloctmh,
								"" AS kode,
								a.wlpxxmh_kode,
								wlo.id_iwhxxmh,
								wlo.id AS id_wloxxmh,
								h.id_grlxxmh_customer AS id_relasi_m,
								a.id_iimxxmh,
								a.id_iumxxmh_unit,
								a.id_iumxxmh_terkecil,
								a.id_iumxxmh_default,
								CONCAT("Item Picking List yang belum di Picking id_wdnxxth=", :id) AS keterangan,
								iwh.kode AS iwhxxmh_kode,
								iwh.nama AS iwhxxmh_nama,
								wlo.kode AS wloxxmh_kode,
								wlo.nama AS wloxxmh_nama,
								cs.kode AS relasi_m_kode,
								cs.nama AS relasi_m_nama,
								item.kode AS iimxxmh_kode,
								item.nama AS iimxxmh_nama,
								unit.kode AS iumxxmh_unit_kode,
								unit.nama AS iumxxmh_unit_nama,
								211,
								imt.movement_type,
								CURDATE(),
								0 AS is_fisik,
								iumxxmh_terkecil.kode AS iumxxmh_terkecil_kode,
								iumxxmh_terkecil.nama AS iumxxmh_terkecil_nama,
								iumxxmh_default.kode AS iumxxmh_default_kode,
								iumxxmh_default.nama AS iumxxmh_default_nama,
								(a.jumlah_unit - SUM(ifnull(b.jumlah_unit,0))) AS sisa_pl,
								a.jumlah_konversi,
								(a.jumlah_terkecil - SUM(ifnull(b.jumlah_terkecil,0))) AS sisa_terkecil,
								(a.jumlah_default - SUM(ifnull(b.jumlah_default,0))) AS sisa_default,
								a.expired_date,
								a.batch_number
							FROM wpllptd a
							LEFT JOIN wpclptd b ON b.id_wpllptd = a.id
							LEFT JOIN wplittd it ON it.id = a.id_wplittd
							LEFT JOIN wdoittd e ON e.id = it.id_wdoittd
							LEFT JOIN wplxxth h ON h.id = a.id_wplxxth
							LEFT JOIN wloxxmh wlo ON wlo.id = a.id_wloxxmh
							LEFT JOIN iwhxxmh iwh ON iwh.id = wlo.id_iwhxxmh
							LEFT JOIN grlxxmh cs ON cs.id = h.id_grlxxmh_customer
							LEFT JOIN iimxxmh item ON item.id = a.id_iimxxmh
							LEFT JOIN iumxxmh iumxxmh_terkecil ON iumxxmh_terkecil.id = a.id_iumxxmh_terkecil
							LEFT JOIN iumxxmh iumxxmh_default ON iumxxmh_default.id = a.id_iumxxmh_default
							LEFT JOIN iumxxmh unit ON unit.id = a.id_iumxxmh_unit
							LEFT JOIN imtxxmh imt ON imt.kode = 211
							WHERE e.id_wdoxxth = :id_wdoxxth AND h.transaction_state <> 9
							GROUP BY a.id
							HAVING sisa_pl <> 0
					'
				);
	
				//lihat di item transfer replenish 
				$qs_wtrittd = $db
					->query('select', 'wtrittd' )
					->get([
						'id'
					] )
					->where('keterangan', 'wplxxth_id_'.$id_wplxxth )
					->where('is_replenishment', 1 )
					->exec();
				$rs_wtrittd = $qs_wtrittd->fetchAll();

				//jika ada replenishment yang belum di confirm
				if(!empty($rs_wtrittd)) {
					foreach ($rs_wtrittd as $key => $wtrittd) {
						$id_wtrittd = $wtrittd['id'];
						
						//booking balik PL reserve yang belum di confirm replenishment
						$qi_pl_loc = $db
							->raw()
							->bind(':id', $id)
							->bind(':id_wtrittd', $id_wtrittd)
							->exec('INSERT INTO iivxxrd (
										id_transaksi_h,
										id_transaksi_d,
										id_wloctmh,
										kode,
										wlpxxmh_kode,
										id_iwhxxmh,
										id_wloxxmh,
										id_relasi_m,
										id_iimxxmh,
										id_iumxxmh_unit,
										id_iumxxmh_terkecil,
										id_iumxxmh_default,
										keterangan,
										iwhxxmh_kode,
										iwhxxmh_nama,
										wloxxmh_kode,
										wloxxmh_nama,
										relasi_m_kode,
										relasi_m_nama,
										iimxxmh_kode,
										iimxxmh_nama,
										iumxxmh_unit_kode,
										iumxxmh_unit_nama,
										imtxxmh_kode,
										imtxxmh_movement_type,
										tanggal,
										is_fisik,
										iumxxmh_terkecil_kode,
										iumxxmh_terkecil_nama,
										iumxxmh_default_kode,
										iumxxmh_default_nama,
										jumlah_unit,
										jumlah_konversi,
										jumlah_terkecil,
										jumlah_default,
										expired_date,
										batch_number
									)
									SELECT DISTINCT
										:id AS id_transaksi_h,
										a.id AS id_transaksi_d,
										wlo.id_wloctmh,
										"" AS kode,
										a.wlpxxmh_kode,
										wlo.id_iwhxxmh,
										wlo.id AS id_wloxxmh,
										h.id_grlxxmh_customer AS id_relasi_m,
										a.id_iimxxmh,
										a.id_iumxxmh_unit,
										a.id_iumxxmh_terkecil,
										a.id_iumxxmh_default,
										CONCAT("Item Picking List yang belum di Picking id_wdnxxth=", :id) AS keterangan,
										iwh.kode AS iwhxxmh_kode,
										iwh.nama AS iwhxxmh_nama,
										wlo.kode AS wloxxmh_kode,
										wlo.nama AS wloxxmh_nama,
										cs.kode AS relasi_m_kode,
										cs.nama AS relasi_m_nama,
										item.kode AS iimxxmh_kode,
										item.nama AS iimxxmh_nama,
										unit.kode AS iumxxmh_unit_kode,
										unit.nama AS iumxxmh_unit_nama,
										217,
										imt.movement_type,
										CURDATE(),
										0 AS is_fisik,
										iumxxmh_terkecil.kode AS iumxxmh_terkecil_kode,
										iumxxmh_terkecil.nama AS iumxxmh_terkecil_nama,
										iumxxmh_default.kode AS iumxxmh_default_kode,
										iumxxmh_default.nama AS iumxxmh_default_nama,
										(a.jumlah_unit) AS sisa_pl,
										a.jumlah_konversi,
										(a.jumlah_terkecil) AS sisa_terkecil,
										(a.jumlah_default) AS sisa_default,
										a.expired_date,
										a.batch_number
									FROM wtrittd a
									LEFT JOIN wplxxth h on h.id = SUBSTRING(a.keterangan, LENGTH("wplxxth_id_") + 1)
									LEFT JOIN wloxxmh wlo ON wlo.id = a.id_wloxxmh_asal
									LEFT JOIN iwhxxmh iwh ON iwh.id = wlo.id_iwhxxmh
									LEFT JOIN grlxxmh cs ON cs.id = h.id_grlxxmh_customer
									LEFT JOIN iimxxmh item ON item.id = a.id_iimxxmh
									LEFT JOIN iumxxmh iumxxmh_terkecil ON iumxxmh_terkecil.id = a.id_iumxxmh_terkecil
									LEFT JOIN iumxxmh iumxxmh_default ON iumxxmh_default.id = a.id_iumxxmh_default
									LEFT JOIN iumxxmh unit ON unit.id = a.id_iumxxmh_unit
									LEFT JOIN imtxxmh imt ON imt.kode = 217
									WHERE a.id = :id_wtrittd
									GROUP BY a.id
							'
						);

						//Delete Item Transfer Replenishment
						$qd_wtrittd = $db
							->query('delete', 'wtrittd')
							->where('id',$id_wtrittd)
							->exec();
					}
				} else {
					//Minus di Lokasi Awal untuk PL yang belum dibuat PC
					$qi_pl_loc = $db
						->raw()
						->bind(':id', $id)
						->bind(':id_wdoxxth', $id_wdoxxth)
						->exec('INSERT INTO iivxxrd (
									id_transaksi_h,
									id_transaksi_d,
									id_wloctmh,
									kode,
									wlpxxmh_kode,
									id_iwhxxmh,
									id_wloxxmh,
									id_relasi_m,
									id_iimxxmh,
									id_iumxxmh_unit,
									id_iumxxmh_terkecil,
									id_iumxxmh_default,
									keterangan,
									iwhxxmh_kode,
									iwhxxmh_nama,
									wloxxmh_kode,
									wloxxmh_nama,
									relasi_m_kode,
									relasi_m_nama,
									iimxxmh_kode,
									iimxxmh_nama,
									iumxxmh_unit_kode,
									iumxxmh_unit_nama,
									imtxxmh_kode,
									imtxxmh_movement_type,
									tanggal,
									is_fisik,
									iumxxmh_terkecil_kode,
									iumxxmh_terkecil_nama,
									iumxxmh_default_kode,
									iumxxmh_default_nama,
									jumlah_unit,
									jumlah_konversi,
									jumlah_terkecil,
									jumlah_default,
									expired_date,
									batch_number
								)
								SELECT DISTINCT
									:id AS id_transaksi_h,
									a.id AS id_transaksi_d,
									wlo.id_wloctmh,
									"" AS kode,
									a.wlpxxmh_kode,
									wlo.id_iwhxxmh,
									wlo.id AS id_wloxxmh,
									h.id_grlxxmh_customer AS id_relasi_m,
									a.id_iimxxmh,
									a.id_iumxxmh_unit,
									a.id_iumxxmh_terkecil,
									a.id_iumxxmh_default,
									CONCAT("Item Picking List yang belum di Picking id_wdnxxth=", :id) AS keterangan,
									iwh.kode AS iwhxxmh_kode,
									iwh.nama AS iwhxxmh_nama,
									wlo.kode AS wloxxmh_kode,
									wlo.nama AS wloxxmh_nama,
									cs.kode AS relasi_m_kode,
									cs.nama AS relasi_m_nama,
									item.kode AS iimxxmh_kode,
									item.nama AS iimxxmh_nama,
									unit.kode AS iumxxmh_unit_kode,
									unit.nama AS iumxxmh_unit_nama,
									217,
									imt.movement_type,
									CURDATE(),
									1 AS is_fisik,
									iumxxmh_terkecil.kode AS iumxxmh_terkecil_kode,
									iumxxmh_terkecil.nama AS iumxxmh_terkecil_nama,
									iumxxmh_default.kode AS iumxxmh_default_kode,
									iumxxmh_default.nama AS iumxxmh_default_nama,
									-(a.jumlah_unit - SUM(ifnull(b.jumlah_unit,0))) AS sisa_pl,
									a.jumlah_konversi,
									-(a.jumlah_terkecil - SUM(ifnull(b.jumlah_terkecil,0))) AS sisa_terkecil,
									-(a.jumlah_default - SUM(ifnull(b.jumlah_default,0))) AS sisa_default,
									a.expired_date,
									a.batch_number
								FROM wpllptd a
								LEFT JOIN wpclptd b ON b.id_wpllptd = a.id
								LEFT JOIN wplittd it ON it.id = a.id_wplittd
								LEFT JOIN wdoittd e ON e.id = it.id_wdoittd
								LEFT JOIN wplxxth h ON h.id = a.id_wplxxth
								LEFT JOIN wloxxmh wlo ON wlo.id = a.id_wloxxmh
								LEFT JOIN iwhxxmh iwh ON iwh.id = wlo.id_iwhxxmh
								LEFT JOIN grlxxmh cs ON cs.id = h.id_grlxxmh_customer
								LEFT JOIN iimxxmh item ON item.id = a.id_iimxxmh
								LEFT JOIN iumxxmh iumxxmh_terkecil ON iumxxmh_terkecil.id = a.id_iumxxmh_terkecil
								LEFT JOIN iumxxmh iumxxmh_default ON iumxxmh_default.id = a.id_iumxxmh_default
								LEFT JOIN iumxxmh unit ON unit.id = a.id_iumxxmh_unit
								LEFT JOIN imtxxmh imt ON imt.kode = 217
								WHERE e.id_wdoxxth = :id_wdoxxth AND h.transaction_state <> 9
								GROUP BY a.id
								HAVING sisa_pl <> 0
						'
					);
					
					//Plus di Lokasi return
					$qi_pl_retur = $db
						->raw()
						->bind(':id', $id)
						->bind(':id_wdoxxth', $id_wdoxxth)
						->exec('INSERT INTO iivxxrd (
									id_transaksi_h,
									id_transaksi_d,
									id_wloctmh,
									kode,
									wlpxxmh_kode,
									id_iwhxxmh,
									id_wloxxmh,
									id_relasi_m,
									id_iimxxmh,
									id_iumxxmh_unit,
									id_iumxxmh_terkecil,
									id_iumxxmh_default,
									keterangan,
									iwhxxmh_kode,
									iwhxxmh_nama,
									wloxxmh_kode,
									wloxxmh_nama,
									relasi_m_kode,
									relasi_m_nama,
									iimxxmh_kode,
									iimxxmh_nama,
									iumxxmh_unit_kode,
									iumxxmh_unit_nama,
									imtxxmh_kode,
									imtxxmh_movement_type,
									tanggal,
									is_fisik,
									iumxxmh_terkecil_kode,
									iumxxmh_terkecil_nama,
									iumxxmh_default_kode,
									iumxxmh_default_nama,
									jumlah_unit,
									jumlah_konversi,
									jumlah_terkecil,
									jumlah_default,
									expired_date,
									batch_number
								)
								SELECT DISTINCT
									:id AS id_transaksi_h,
									a.id AS id_transaksi_d,
									wlo.id_wloctmh,
									"" AS kode,
									a.wlpxxmh_kode,
									wlo.id_iwhxxmh,
									wlo.id AS id_wloxxmh,
									h.id_grlxxmh_customer AS id_relasi_m,
									a.id_iimxxmh,
									a.id_iumxxmh_unit,
									a.id_iumxxmh_terkecil,
									a.id_iumxxmh_default,
									CONCAT("Item Picking List yang belum di Picking id_wdnxxth=", :id) AS keterangan,
									iwh.kode AS iwhxxmh_kode,
									iwh.nama AS iwhxxmh_nama,
									wlo.kode AS wloxxmh_kode,
									wlo.nama AS wloxxmh_nama,
									cs.kode AS relasi_m_kode,
									cs.nama AS relasi_m_nama,
									item.kode AS iimxxmh_kode,
									item.nama AS iimxxmh_nama,
									unit.kode AS iumxxmh_unit_kode,
									unit.nama AS iumxxmh_unit_nama,
									217,
									imt.movement_type,
									CURDATE(),
									1 AS is_fisik,
									iumxxmh_terkecil.kode AS iumxxmh_terkecil_kode,
									iumxxmh_terkecil.nama AS iumxxmh_terkecil_nama,
									iumxxmh_default.kode AS iumxxmh_default_kode,
									iumxxmh_default.nama AS iumxxmh_default_nama,
									(a.jumlah_unit - SUM(ifnull(b.jumlah_unit,0))) AS sisa_pl,
									a.jumlah_konversi,
									(a.jumlah_terkecil - SUM(ifnull(b.jumlah_terkecil,0))) AS sisa_terkecil,
									(a.jumlah_default - SUM(ifnull(b.jumlah_default,0))) AS sisa_default,
									a.expired_date,
									a.batch_number
								FROM wpllptd a
								LEFT JOIN wpclptd b ON b.id_wpllptd = a.id
								LEFT JOIN wplittd it ON it.id = a.id_wplittd
								LEFT JOIN wdoittd e ON e.id = it.id_wdoittd
								LEFT JOIN wplxxth h ON h.id = a.id_wplxxth
								LEFT JOIN wloxxmh asal ON asal.id = a.id_wloxxmh
								LEFT JOIN iwhxxmh iwh ON iwh.id = asal.id_iwhxxmh
								LEFT JOIN wloxxmh wlo ON wlo.id_iwhxxmh = iwh.id AND wlo.id_wloctmh = 7 AND wlo.is_default = 1
								LEFT JOIN grlxxmh cs ON cs.id = h.id_grlxxmh_customer
								LEFT JOIN iimxxmh item ON item.id = a.id_iimxxmh
								LEFT JOIN iumxxmh iumxxmh_terkecil ON iumxxmh_terkecil.id = a.id_iumxxmh_terkecil
								LEFT JOIN iumxxmh iumxxmh_default ON iumxxmh_default.id = a.id_iumxxmh_default
								LEFT JOIN iumxxmh unit ON unit.id = a.id_iumxxmh_unit
								LEFT JOIN imtxxmh imt ON imt.kode = 217
								WHERE e.id_wdoxxth = :id_wdoxxth AND h.transaction_state <> 9
								GROUP BY a.id
								HAVING sisa_pl <> 0
						'
					);
				}
	
				//close wpl
				$qu_wplxxth = $db
					->query('update', 'wplxxth')
					->set('transaction_state', 9)
					->where('id',$id_wplxxth)
					->exec();
	
				//close wpcxxth
				$qu_wplxxth = $db
					->query('update', 'wpcxxth')
					->set('transaction_state', 9)
					->where('id',$id_wpcxxth)
					->exec();
	
				//update detail DO
				$qu_wdoittd = $db
					->raw()
					->bind(':id_wdoittd', $id_wdoittd)
					->bind(':sisa_pl', $sisa_pl)
					->bind(':sisa_pl_terkecil', $sisa_pl_terkecil)
					->exec('UPDATE wdoittd a
							SET 
								a.jumlah_unit_next = jumlah_unit_next - :sisa_pl,
								a.jumlah_unit_os = jumlah_unit_os + :sisa_pl,
								a.jumlah_terkecil_next = jumlah_terkecil_next - :sisa_pl_terkecil,
								a.jumlah_terkecil_os = jumlah_terkecil_os + :sisa_pl_terkecil
							WHERE a.id = :id_wdoittd
							;
					'
				);
			}
		}
		
		//cek apakah ada item Picking yang belum di Dispatch
		$qs_wdp = $db
			->raw()
			->bind(':id_wdoxxth', $id_wdoxxth)
			->exec('SELECT
						a.id_wpcxxth,
						a.id_wloxxmh_tujuan,
						f.nama wloxxmh_nama,
						a.id_iimxxmh,
						c.nama iimxxmh_nama,
						d.kode iumxxmh_kode,
						a.wlpxxmh_kode,
						a.jumlah_unit AS jumlah_unit_pc,
						SUM(ifnull(b.jumlah_unit,0)) AS jumlah_unit_dp,
						a.jumlah_unit - SUM(ifnull(b.jumlah_unit,0)) AS sisa_pc
					FROM wpclptd a
					LEFT JOIN wdplptd b ON b.id_wpclptd = a.id
					LEFT JOIN iimxxmh c ON c.id = a.id_iimxxmh
					LEFT JOIN iumxxmh d ON d.id = a.id_iumxxmh_unit
					LEFT JOIN wdoittd e ON e.id = a.id_wdoittd
					LEFT JOIN wloxxmh f ON f.id = a.id_wloxxmh_tujuan
					LEFT JOIN wpcxxth h ON h.id = a.id_wpcxxth
					WHERE e.id_wdoxxth = :id_wdoxxth AND h.transaction_state <> 9
					GROUP BY a.id
					HAVING sisa_pc > 0
			'
			);
		$rs_wdp = $qs_wdp->fetchAll();
		if (!empty($rs_wdp)) {
			foreach ($rs_wdp as $key => $rs_wdpxxth) {
				$id_wpcxxth = $rs_wdpxxth['id_wpcxxth'];
				//Minus
				$qi_dp_to = $db
					->raw()
					->bind(':id', $id)
					->bind(':id_wdoxxth', $id_wdoxxth)
					->exec('INSERT INTO iivxxrd (
								id_transaksi_h,
								id_transaksi_d,
								id_wloctmh,
								kode,
								wlpxxmh_kode,
								id_iwhxxmh,
								id_wloxxmh,
								id_relasi_m,
								id_iimxxmh,
								id_iumxxmh_unit,
								id_iumxxmh_terkecil,
								id_iumxxmh_default,
								keterangan,
								iwhxxmh_kode,
								iwhxxmh_nama,
								wloxxmh_kode,
								wloxxmh_nama,
								relasi_m_kode,
								relasi_m_nama,
								iimxxmh_kode,
								iimxxmh_nama,
								iumxxmh_unit_kode,
								iumxxmh_unit_nama,
								imtxxmh_kode,
								imtxxmh_movement_type,
								tanggal,
								is_fisik,
								iumxxmh_terkecil_kode,
								iumxxmh_terkecil_nama,
								iumxxmh_default_kode,
								iumxxmh_default_nama,
								jumlah_unit,
								jumlah_konversi,
								jumlah_terkecil,
								jumlah_default,
								expired_date,
								batch_number
							)
							SELECT DISTINCT
								:id AS id_transaksi_h,
								a.id AS id_transaksi_d,
								wlo.id_wloctmh,
								"" AS kode,
								a.wlpxxmh_kode,
								wlo.id_iwhxxmh,
								wlo.id AS id_wloxxmh,
								h.id_grlxxmh_customer AS id_relasi_m,
								a.id_iimxxmh,
								a.id_iumxxmh_unit,
								a.id_iumxxmh_terkecil,
								a.id_iumxxmh_default,
								CONCAT("Item Picking yang belum di Dispatch id_wdnxxth=", :id) AS keterangan,
								iwh.kode AS iwhxxmh_kode,
								iwh.nama AS iwhxxmh_nama,
								wlo.kode AS wloxxmh_kode,
								wlo.nama AS wloxxmh_nama,
								cs.kode AS relasi_m_kode,
								cs.nama AS relasi_m_nama,
								item.kode AS iimxxmh_kode,
								item.nama AS iimxxmh_nama,
								unit.kode AS iumxxmh_unit_kode,
								unit.nama AS iumxxmh_unit_nama,
								217,
								imt.movement_type,
								CURDATE(),
								1 AS is_fisik,
								iumxxmh_terkecil.kode AS iumxxmh_terkecil_kode,
								iumxxmh_terkecil.nama AS iumxxmh_terkecil_nama,
								iumxxmh_default.kode AS iumxxmh_default_kode,
								iumxxmh_default.nama AS iumxxmh_default_nama,
								-(a.jumlah_unit - SUM(ifnull(b.jumlah_unit,0))) AS sisa_pc,
								a.jumlah_konversi,
								-(a.jumlah_terkecil - SUM(ifnull(b.jumlah_terkecil,0))) AS sisa_terkecil,
								-(a.jumlah_default - SUM(ifnull(b.jumlah_default,0))) AS sisa_default,
								a.expired_date,
								a.batch_number
							FROM wpclptd a
							LEFT JOIN wdplptd b ON b.id_wpclptd = a.id
							LEFT JOIN wdoittd e ON e.id = a.id_wdoittd
							LEFT JOIN wpcxxth h ON h.id = a.id_wpcxxth
							LEFT JOIN wloxxmh wlo ON wlo.id = a.id_wloxxmh_tujuan
							LEFT JOIN iwhxxmh iwh ON iwh.id = wlo.id_iwhxxmh
							LEFT JOIN grlxxmh cs ON cs.id = h.id_grlxxmh_customer
							LEFT JOIN iimxxmh item ON item.id = a.id_iimxxmh
							LEFT JOIN iumxxmh iumxxmh_terkecil ON iumxxmh_terkecil.id = a.id_iumxxmh_terkecil
							LEFT JOIN iumxxmh iumxxmh_default ON iumxxmh_default.id = a.id_iumxxmh_default
							LEFT JOIN iumxxmh unit ON unit.id = a.id_iumxxmh_unit
							LEFT JOIN imtxxmh imt ON imt.kode = 217
							WHERE e.id_wdoxxth = :id_wdoxxth AND h.transaction_state <> 9
							GROUP BY a.id
							HAVING sisa_pc <> 0
					'
				);
				
				//Plus
				$qi_dp_to = $db
					->raw()
					->bind(':id', $id)
					->bind(':id_wdoxxth', $id_wdoxxth)
					->exec('INSERT INTO iivxxrd (
								id_transaksi_h,
								id_transaksi_d,
								id_wloctmh,
								kode,
								wlpxxmh_kode,
								id_iwhxxmh,
								id_wloxxmh,
								id_relasi_m,
								id_iimxxmh,
								id_iumxxmh_unit,
								id_iumxxmh_terkecil,
								id_iumxxmh_default,
								keterangan,
								iwhxxmh_kode,
								iwhxxmh_nama,
								wloxxmh_kode,
								wloxxmh_nama,
								relasi_m_kode,
								relasi_m_nama,
								iimxxmh_kode,
								iimxxmh_nama,
								iumxxmh_unit_kode,
								iumxxmh_unit_nama,
								imtxxmh_kode,
								imtxxmh_movement_type,
								tanggal,
								is_fisik,
								iumxxmh_terkecil_kode,
								iumxxmh_terkecil_nama,
								iumxxmh_default_kode,
								iumxxmh_default_nama,
								jumlah_unit,
								jumlah_konversi,
								jumlah_terkecil,
								jumlah_default,
								expired_date,
								batch_number
							)
							SELECT DISTINCT
								:id AS id_transaksi_h,
								a.id AS id_transaksi_d,
								wlo.id_wloctmh,
								"" AS kode,
								a.wlpxxmh_kode,
								wlo.id_iwhxxmh,
								wlo.id AS id_wloxxmh,
								h.id_grlxxmh_customer AS id_relasi_m,
								a.id_iimxxmh,
								a.id_iumxxmh_unit,
								a.id_iumxxmh_terkecil,
								a.id_iumxxmh_default,
								CONCAT("Item Picking yang belum di Dispatch id_wdnxxth=", :id) AS keterangan,
								iwh.kode AS iwhxxmh_kode,
								iwh.nama AS iwhxxmh_nama,
								wlo.kode AS wloxxmh_kode,
								wlo.nama AS wloxxmh_nama,
								cs.kode AS relasi_m_kode,
								cs.nama AS relasi_m_nama,
								item.kode AS iimxxmh_kode,
								item.nama AS iimxxmh_nama,
								unit.kode AS iumxxmh_unit_kode,
								unit.nama AS iumxxmh_unit_nama,
								217,
								imt.movement_type,
								CURDATE(),
								1 AS is_fisik,
								iumxxmh_terkecil.kode AS iumxxmh_terkecil_kode,
								iumxxmh_terkecil.nama AS iumxxmh_terkecil_nama,
								iumxxmh_default.kode AS iumxxmh_default_kode,
								iumxxmh_default.nama AS iumxxmh_default_nama,
								(a.jumlah_unit - SUM(ifnull(b.jumlah_unit,0))) AS sisa_pc,
								a.jumlah_konversi,
								(a.jumlah_terkecil - SUM(ifnull(b.jumlah_terkecil,0))) AS sisa_terkecil,
								(a.jumlah_default - SUM(ifnull(b.jumlah_default,0))) AS sisa_default,
								a.expired_date,
								a.batch_number
							FROM wpclptd a
							LEFT JOIN wdplptd b ON b.id_wpclptd = a.id
							LEFT JOIN wdoittd e ON e.id = a.id_wdoittd
							LEFT JOIN wpcxxth h ON h.id = a.id_wpcxxth
							LEFT JOIN wloxxmh asal ON asal.id = a.id_wloxxmh_tujuan
							LEFT JOIN iwhxxmh iwh ON iwh.id = asal.id_iwhxxmh
							LEFT JOIN wloxxmh wlo ON wlo.id_iwhxxmh = iwh.id AND wlo.id_wloctmh = 7 AND wlo.is_default = 1
							LEFT JOIN grlxxmh cs ON cs.id = h.id_grlxxmh_customer
							LEFT JOIN iimxxmh item ON item.id = a.id_iimxxmh
							LEFT JOIN iumxxmh iumxxmh_terkecil ON iumxxmh_terkecil.id = a.id_iumxxmh_terkecil
							LEFT JOIN iumxxmh iumxxmh_default ON iumxxmh_default.id = a.id_iumxxmh_default
							LEFT JOIN iumxxmh unit ON unit.id = a.id_iumxxmh_unit
							LEFT JOIN imtxxmh imt ON imt.kode = 217
							WHERE e.id_wdoxxth = :id_wdoxxth AND h.transaction_state <> 9
							GROUP BY a.id
							HAVING sisa_pc <> 0
					'
				);
	
				//close WPC
				$qu_wpcxxth = $db
					->query('update', 'wpcxxth')
					->set('transaction_state', 9)
					->where('id',$id_wpcxxth)
				->exec();
			}
		}

		//cek apakah ada item DP yang belum dibuat DN
		$qs_wdn = $db
			->raw()
			->bind(':id_wdoxxth', $id_wdoxxth)
			->exec('SELECT
						a.id_wdpxxth,
						a.id_wloxxmh_tujuan,
						f.nama wloxxmh_nama,
						a.id_iimxxmh,
						c.nama iimxxmh_nama,
						d.kode iumxxmh_kode,
						a.wlpxxmh_kode,
						a.jumlah_unit AS jumlah_unit_dp,
						SUM(ifnull(b.jumlah_unit,0)) AS jumlah_unit_dn,
						a.jumlah_unit - SUM(ifnull(b.jumlah_unit,0)) AS sisa_dp
					FROM wdplptd a
					LEFT JOIN wdnlptd b ON b.id_wdplptd = a.id
					LEFT JOIN iimxxmh c ON c.id = a.id_iimxxmh
					LEFT JOIN iumxxmh d ON d.id = a.id_iumxxmh_unit
					LEFT JOIN wdoittd e ON e.id = a.id_wdoittd
					LEFT JOIN wloxxmh f ON f.id = a.id_wloxxmh_tujuan
					LEFT JOIN wdpxxth h ON h.id = a.id_wdpxxth
					WHERE e.id_wdoxxth = :id_wdoxxth AND h.transaction_state <> 9
					GROUP BY a.id
					HAVING sisa_dp > 0
			'
			);
		$rs_wdn = $qs_wdn->fetchAll();
		if (!empty($rs_wdn)) {
			foreach ($rs_wdn as $key => $rs_wdnxxth) {
				$id_wdpxxth = $rs_wdnxxth['id_wdpxxth'];
				//Minus 
				$qi_dn_to = $db
					->raw()
					->bind(':id', $id)
					->bind(':id_wdoxxth', $id_wdoxxth)
					->exec('INSERT INTO iivxxrd (
								id_transaksi_h,
								id_transaksi_d,
								id_wloctmh,
								kode,
								wlpxxmh_kode,
								id_iwhxxmh,
								id_wloxxmh,
								id_relasi_m,
								id_iimxxmh,
								id_iumxxmh_unit,
								id_iumxxmh_terkecil,
								id_iumxxmh_default,
								keterangan,
								iwhxxmh_kode,
								iwhxxmh_nama,
								wloxxmh_kode,
								wloxxmh_nama,
								relasi_m_kode,
								relasi_m_nama,
								iimxxmh_kode,
								iimxxmh_nama,
								iumxxmh_unit_kode,
								iumxxmh_unit_nama,
								imtxxmh_kode,
								imtxxmh_movement_type,
								tanggal,
								is_fisik,
								iumxxmh_terkecil_kode,
								iumxxmh_terkecil_nama,
								iumxxmh_default_kode,
								iumxxmh_default_nama,
								jumlah_unit,
								jumlah_konversi,
								jumlah_terkecil,
								jumlah_default,
								expired_date,
								batch_number
							)
							SELECT DISTINCT
								:id AS id_transaksi_h,
								a.id AS id_transaksi_d,
								wlo.id_wloctmh,
								"" AS kode,
								a.wlpxxmh_kode,
								wlo.id_iwhxxmh,
								wlo.id AS id_wloxxmh,
								h.id_grlxxmh_customer AS id_relasi_m,
								a.id_iimxxmh,
								a.id_iumxxmh_unit,
								a.id_iumxxmh_terkecil,
								a.id_iumxxmh_default,
								CONCAT("Item Dispatch yang belum dibuat DN id_wdnxxth=", :id) AS keterangan,
								iwh.kode AS iwhxxmh_kode,
								iwh.nama AS iwhxxmh_nama,
								wlo.kode AS wloxxmh_kode,
								wlo.nama AS wloxxmh_nama,
								cs.kode AS relasi_m_kode,
								cs.nama AS relasi_m_nama,
								item.kode AS iimxxmh_kode,
								item.nama AS iimxxmh_nama,
								unit.kode AS iumxxmh_unit_kode,
								unit.nama AS iumxxmh_unit_nama,
								217,
								imt.movement_type,
								CURDATE(),
								1 AS is_fisik,
								iumxxmh_terkecil.kode AS iumxxmh_terkecil_kode,
								iumxxmh_terkecil.nama AS iumxxmh_terkecil_nama,
								iumxxmh_default.kode AS iumxxmh_default_kode,
								iumxxmh_default.nama AS iumxxmh_default_nama,
								-(a.jumlah_unit - SUM(ifnull(b.jumlah_unit,0))) AS sisa_dp,
								a.jumlah_konversi,
								-(a.jumlah_terkecil - SUM(ifnull(b.jumlah_terkecil,0))) AS sisa_terkecil,
								-(a.jumlah_default - SUM(ifnull(b.jumlah_default,0))) AS sisa_default,
								a.expired_date,
								a.batch_number
							FROM wdplptd a
							LEFT JOIN wdnlptd b ON b.id_wdplptd = a.id
							LEFT JOIN wdoittd e ON e.id = a.id_wdoittd
							LEFT JOIN wdpxxth h ON h.id = a.id_wdpxxth
							LEFT JOIN wloxxmh wlo ON wlo.id = a.id_wloxxmh_tujuan
							LEFT JOIN iwhxxmh iwh ON iwh.id = wlo.id_iwhxxmh
							LEFT JOIN grlxxmh cs ON cs.id = h.id_grlxxmh_customer
							LEFT JOIN iimxxmh item ON item.id = a.id_iimxxmh
							LEFT JOIN iumxxmh iumxxmh_terkecil ON iumxxmh_terkecil.id = a.id_iumxxmh_terkecil
							LEFT JOIN iumxxmh iumxxmh_default ON iumxxmh_default.id = a.id_iumxxmh_default
							LEFT JOIN iumxxmh unit ON unit.id = a.id_iumxxmh_unit
							LEFT JOIN imtxxmh imt ON imt.kode = 217
							WHERE e.id_wdoxxth = :id_wdoxxth AND h.transaction_state <> 9
							GROUP BY a.id
							HAVING sisa_dp <> 0
					'
				);
				
				//Plus
				$qi_dn_to = $db
					->raw()
					->bind(':id', $id)
					->bind(':id_wdoxxth', $id_wdoxxth)
					->exec('INSERT INTO iivxxrd (
								id_transaksi_h,
								id_transaksi_d,
								id_wloctmh,
								kode,
								wlpxxmh_kode,
								id_iwhxxmh,
								id_wloxxmh,
								id_relasi_m,
								id_iimxxmh,
								id_iumxxmh_unit,
								id_iumxxmh_terkecil,
								id_iumxxmh_default,
								keterangan,
								iwhxxmh_kode,
								iwhxxmh_nama,
								wloxxmh_kode,
								wloxxmh_nama,
								relasi_m_kode,
								relasi_m_nama,
								iimxxmh_kode,
								iimxxmh_nama,
								iumxxmh_unit_kode,
								iumxxmh_unit_nama,
								imtxxmh_kode,
								imtxxmh_movement_type,
								tanggal,
								is_fisik,
								iumxxmh_terkecil_kode,
								iumxxmh_terkecil_nama,
								iumxxmh_default_kode,
								iumxxmh_default_nama,
								jumlah_unit,
								jumlah_konversi,
								jumlah_terkecil,
								jumlah_default,
								expired_date,
								batch_number
							)
							SELECT DISTINCT
								:id AS id_transaksi_h,
								a.id AS id_transaksi_d,
								wlo.id_wloctmh,
								"" AS kode,
								a.wlpxxmh_kode,
								wlo.id_iwhxxmh,
								wlo.id AS id_wloxxmh,
								h.id_grlxxmh_customer AS id_relasi_m,
								a.id_iimxxmh,
								a.id_iumxxmh_unit,
								a.id_iumxxmh_terkecil,
								a.id_iumxxmh_default,
								CONCAT("Item Dispatch yang belum dibuat DN id_wdnxxth=", :id) AS keterangan,
								iwh.kode AS iwhxxmh_kode,
								iwh.nama AS iwhxxmh_nama,
								wlo.kode AS wloxxmh_kode,
								wlo.nama AS wloxxmh_nama,
								cs.kode AS relasi_m_kode,
								cs.nama AS relasi_m_nama,
								item.kode AS iimxxmh_kode,
								item.nama AS iimxxmh_nama,
								unit.kode AS iumxxmh_unit_kode,
								unit.nama AS iumxxmh_unit_nama,
								217,
								imt.movement_type,
								CURDATE(),
								1 AS is_fisik,
								iumxxmh_terkecil.kode AS iumxxmh_terkecil_kode,
								iumxxmh_terkecil.nama AS iumxxmh_terkecil_nama,
								iumxxmh_default.kode AS iumxxmh_default_kode,
								iumxxmh_default.nama AS iumxxmh_default_nama,
								(a.jumlah_unit - SUM(ifnull(b.jumlah_unit,0))) AS sisa_dp,
								a.jumlah_konversi,
								(a.jumlah_terkecil - SUM(ifnull(b.jumlah_terkecil,0))) AS sisa_terkecil,
								(a.jumlah_default - SUM(ifnull(b.jumlah_default,0))) AS sisa_default,
								a.expired_date,
								a.batch_number
							FROM wdplptd a
							LEFT JOIN wdnlptd b ON b.id_wdplptd = a.id
							LEFT JOIN wdoittd e ON e.id = a.id_wdoittd
							LEFT JOIN wdpxxth h ON h.id = a.id_wdpxxth
							LEFT JOIN wloxxmh asal ON asal.id = a.id_wloxxmh_tujuan
							LEFT JOIN iwhxxmh iwh ON iwh.id = asal.id_iwhxxmh
							LEFT JOIN wloxxmh wlo ON wlo.id_iwhxxmh = iwh.id AND wlo.id_wloctmh = 7 AND wlo.is_default = 1
							LEFT JOIN grlxxmh cs ON cs.id = h.id_grlxxmh_customer
							LEFT JOIN iimxxmh item ON item.id = a.id_iimxxmh
							LEFT JOIN iumxxmh iumxxmh_terkecil ON iumxxmh_terkecil.id = a.id_iumxxmh_terkecil
							LEFT JOIN iumxxmh iumxxmh_default ON iumxxmh_default.id = a.id_iumxxmh_default
							LEFT JOIN iumxxmh unit ON unit.id = a.id_iumxxmh_unit
							LEFT JOIN imtxxmh imt ON imt.kode = 217
							WHERE e.id_wdoxxth = :id_wdoxxth AND h.transaction_state <> 9
							GROUP BY a.id
							HAVING sisa_dp <> 0
					'
				);
	
				//close Wdp
				$qu_wdpxxth = $db
					->query('update', 'wdpxxth')
					->set('transaction_state', 9)
					->where('id',$id_wdpxxth)
					->exec();
			}
		}

		//jika sudah confirm, maka DO akan di close, jika is_one_way_do = 1
		if ($is_one_way_do == 1) {
			$qu_wdoxxth = $db
				->query('update', 'wdoxxth')
				->set('transaction_state',9)
				->where('id',$id_wdoxxth)
				->exec();
		} else {
			$qu_wdoittd = $db
				->raw()
				->bind(':id_wdoxxth', $id_wdoxxth)
				->exec('UPDATE wdoittd a
						SET 
							a.jumlah_unit_next = 0,
							a.jumlah_unit = jumlah_unit_os,
							a.jumlah_terkecil_next = 0,
							a.jumlah_terkecil = jumlah_terkecil_os,
							a.jumlah_default = jumlah_unit_os
						WHERE a.id_wdoxxth = :id_wdoxxth
						;
				'
				);
		}

		
		$qi_wdoxxth_wdnxxth = $db
			->raw()
			->bind(':id', $id)
			->exec('INSERT INTO wdoxxth_wdnxxth (
						id_wdnxxth,
						id_wdoxxth,
						id_wdoittd,
						jumlah_unit_do,
						jumlah_unit_dn,
						jumlah_terkecil_do,
						jumlah_terkecil_dn
					)
					SELECT DISTINCT
						a.id id_wdnxxth,
						a.id_wdoxxth,
						b.id id_wdoittd,
						b.jumlah_unit jumlah_unit_do,
						c.jumlah_unit jumlah_unit_dn,
						b.jumlah_terkecil jumlah_terkecil_do,
						c.jumlah_terkecil jumlah_terkecil_dn
					FROM wdnxxth a
					LEFT JOIN wdoittd b ON b.id_wdoxxth = a.id_wdoxxth
					LEFT JOIN wdnittd c ON c.id_wdoittd = b.id
					WHERE a.id = :id
					;
			'
			);

		// check apakah query ada resultnya
		if(!empty($qi_iivxxrd)){
			$db->commit();
			$status_code  = '200';
			$message      = 'Delivery Note Berhasil Dilakukan';
			$type_message = 'success';
			// parameter lain
		}else{
			$db->rollback();
			$status_code  = '500';
			$message      = 'Delivery Note Gagal Dilakukan';
			$type_message = 'error';
			// parameter lain
		}
	}catch(PDOException $e){
		$db->rollback();
		$status_code  = '500';
		$message      = 'Delivery Note Gagal Dilakukan! ' . $e->getMessage();
		$type_message = 'error';
	}catch (Exception $e) {
		$db->rollback();
		$status_code = 500;
		$message = 'Delivery Note Gagal Dilakukan!, ' . $e->getMessage();
		$type_message = 'error';
	}
	// build response
	$data = array(
		'status_code'    => $status_code,
		'message'        => $message,
		'type_message'   => $type_message
	);

	// tampilkan results
    include( "../../../../usersc/helpers/fn_ajax_results.php" );
?>