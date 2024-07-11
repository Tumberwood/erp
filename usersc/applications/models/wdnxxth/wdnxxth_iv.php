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

		// BEGIN ambil data confirmed_at dari table activity_log_ml
		$qs_activity_log_ml = $db
			->query('select', 'activity_log_ml' )
			->get([
				'activity_log_ml.created_on as confirmed_at'
			] )
			->where('activity_log_ml.id_transaksi', $id )
			->where('activity_log_ml.kode', 'CONFIRM' )
			->where('activity_log_ml.nama', 'wdnxxth' )
			->exec();
		$rs_activity_log_ml = $qs_activity_log_ml->fetch();
		$confirmed_at = $rs_activity_log_ml['confirmed_at'];
		// END ambil data confirmed_at dari table activity_log_ml

		//jurnal balik, booking +
		$qi_iivxxrd = $db
			->raw()
			->bind(':id', $id)
			->exec('
				INSERT INTO iivxxrd (
					id_transaksi_h,
					id_transaksi_d,
					id_gcpxxmh,
					id_gbrxxmh,
					id_iwhxxmh,
					id_wloxxmh,
					id_wloctmh,
					id_relasi_m,
					id_iimxxmh,
					id_iumxxmh_unit,
					id_iumxxmh_terkecil,
					id_iumxxmh_default,
					kode,
					keterangan,
					confirmed_at,
					created_by,
					gcpxxmh_kode,
					gcpxxmh_nama,
					gbrxxmh_kode,
					gbrxxmh_nama,
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
					iumxxmh_terkecil_kode,
					iumxxmh_terkecil_nama,
					iumxxmh_default_kode,
					iumxxmh_default_nama,
					imtxxmh_kode,
					imtxxmh_movement_type,
					tanggal,
					is_fisik,
					jumlah_unit,
					jumlah_konversi,
					jumlah_terkecil,
					jumlah_default,
					wlpxxmh_kode,
					expired_date,
					batch_number
				)
				SELECT
					wdnxxth.id as id_transaksi_h,
					wdnittd.id as id_transaksi_d,
					wdnxxth.id_gcpxxmh as id_gcpxxmh,
					wdnxxth.id_gbrxxmh as id_gbrxxmh,
					wdnxxth.id_iwhxxmh as id_iwhxxmh,
					wlo.id AS id_wloxxmh,
					wlo.id_wloctmh,
					wdnxxth.id_grlxxmh_customer as id_relasi_m,
					wdnittd.id_iimxxmh,
					wdnittd.id_iumxxmh_unit,
					wdnittd.id_iumxxmh_terkecil,
					wdnittd.id_iumxxmh_default,
					wdnxxth.kode,
					wdnxxth.keterangan,
					"'.$confirmed_at.'",
					wdnxxth.created_by,
					gcpxxmh.kode,
					gcpxxmh.nama,
					gbrxxmh.kode,
					gbrxxmh.nama,
					iwhxxmh.kode,
					iwhxxmh.nama,
					wlo.kode AS wloxxmh_kode,
					wlo.nama AS wloxxmh_nama,
					grlxxmh.kode,
					grlxxmh.nama,
					iimxxmh.kode,
					iimxxmh.nama,
					iumxxmh_unit.kode,
					iumxxmh_unit.nama,
					iumxxmh_terkecil.kode,
					iumxxmh_terkecil.nama,
					iumxxmh_default.kode,
					iumxxmh_default.nama,
					'.$imtxxmh_kode.' as imtxxmh_kode,
					imtxxmh.movement_type,
					wdnxxth.tanggal,
					0 as is_fisik,
					b.jumlah_unit as jumlah_unit,
					b.jumlah_konversi as jumlah_konversi,
					b.jumlah_terkecil as jumlah_terkecil,
					b.jumlah_default as jumlah_default,
					b.wlpxxmh_kode,
					b.expired_date,
					b.batch_number
				FROM wdnxxth
				LEFT JOIN gcpxxmh ON gcpxxmh.id = wdnxxth.id_gcpxxmh
				LEFT JOIN gbrxxmh ON gbrxxmh.id = wdnxxth.id_gbrxxmh
				LEFT JOIN iwhxxmh ON iwhxxmh.id = wdnxxth.id_iwhxxmh
				LEFT JOIN grlxxmh ON grlxxmh.id = wdnxxth.id_grlxxmh_customer
				LEFT JOIN wdnittd ON wdnittd.id_wdnxxth = wdnxxth.id
				LEFT JOIN iimxxmh ON iimxxmh.id = wdnittd.id_iimxxmh
				LEFT JOIN iumxxmh AS iumxxmh_unit ON iumxxmh_unit.id = wdnittd.id_iumxxmh_unit
				LEFT JOIN iumxxmh AS iumxxmh_terkecil ON iumxxmh_terkecil.id = wdnittd.id_iumxxmh_terkecil
				LEFT JOIN iumxxmh AS iumxxmh_default ON iumxxmh_default.id = wdnittd.id_iumxxmh_default
				LEFT JOIN imtxxmh as imtxxmh ON imtxxmh.kode = '.$imtxxmh_kode.'
				LEFT JOIN wloxxmh wlo ON wlo.id = wdnittd.id_wloxxmh
				LEFT JOIN wdnlptd b ON b.id_wdnxxth = wdnxxth.id
				WHERE wdnxxth.id = :id
		');

		$qi_iivxxrd = $db
			->raw()
			->bind(':id', $id)
			->exec('
				INSERT INTO iivxxrd (
					id_transaksi_h,
					id_transaksi_d,
					id_gcpxxmh,
					id_gbrxxmh,
					id_iwhxxmh,
					id_wloxxmh,
					id_wloctmh,
					id_relasi_m,
					id_iimxxmh,
					id_iumxxmh_unit,
					id_iumxxmh_terkecil,
					id_iumxxmh_default,
					kode,
					keterangan,
					confirmed_at,
					created_by,
					gcpxxmh_kode,
					gcpxxmh_nama,
					gbrxxmh_kode,
					gbrxxmh_nama,
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
					iumxxmh_terkecil_kode,
					iumxxmh_terkecil_nama,
					iumxxmh_default_kode,
					iumxxmh_default_nama,
					imtxxmh_kode,
					imtxxmh_movement_type,
					tanggal,
					is_fisik,
					jumlah_unit,
					jumlah_konversi,
					jumlah_terkecil,
					jumlah_default,
					wlpxxmh_kode,
					expired_date,
					batch_number
				)
				SELECT
					wdnxxth.id as id_transaksi_h,
					wdnittd.id as id_transaksi_d,
					wdnxxth.id_gcpxxmh as id_gcpxxmh,
					wdnxxth.id_gbrxxmh as id_gbrxxmh,
					wdnxxth.id_iwhxxmh as id_iwhxxmh,
					wlo.id AS id_wloxxmh,
					wlo.id_wloctmh,
					wdnxxth.id_grlxxmh_customer as id_relasi_m,
					wdnittd.id_iimxxmh,
					wdnittd.id_iumxxmh_unit,
					wdnittd.id_iumxxmh_terkecil,
					wdnittd.id_iumxxmh_default,
					wdnxxth.kode,
					wdnxxth.keterangan,
					"'.$confirmed_at.'",
					wdnxxth.created_by,
					gcpxxmh.kode,
					gcpxxmh.nama,
					gbrxxmh.kode,
					gbrxxmh.nama,
					iwhxxmh.kode,
					iwhxxmh.nama,
					wlo.kode AS wloxxmh_kode,
					wlo.nama AS wloxxmh_nama,
					grlxxmh.kode,
					grlxxmh.nama,
					iimxxmh.kode,
					iimxxmh.nama,
					iumxxmh_unit.kode,
					iumxxmh_unit.nama,
					iumxxmh_terkecil.kode,
					iumxxmh_terkecil.nama,
					iumxxmh_default.kode,
					iumxxmh_default.nama,
					'.$imtxxmh_kode.' as imtxxmh_kode,
					imtxxmh.movement_type,
					wdnxxth.tanggal,
					1 as is_fisik,
					-b.jumlah_unit as jumlah_unit,
					b.jumlah_konversi as jumlah_konversi,
					-b.jumlah_terkecil as jumlah_terkecil,
					-b.jumlah_default as jumlah_default,
					b.wlpxxmh_kode,
					b.expired_date,
					b.batch_number
				FROM wdnxxth
				LEFT JOIN gcpxxmh ON gcpxxmh.id = wdnxxth.id_gcpxxmh
				LEFT JOIN gbrxxmh ON gbrxxmh.id = wdnxxth.id_gbrxxmh
				LEFT JOIN iwhxxmh ON iwhxxmh.id = wdnxxth.id_iwhxxmh
				LEFT JOIN grlxxmh ON grlxxmh.id = wdnxxth.id_grlxxmh_customer
				LEFT JOIN wdnittd ON wdnittd.id_wdnxxth = wdnxxth.id
				LEFT JOIN iimxxmh ON iimxxmh.id = wdnittd.id_iimxxmh
				LEFT JOIN iumxxmh AS iumxxmh_unit ON iumxxmh_unit.id = wdnittd.id_iumxxmh_unit
				LEFT JOIN iumxxmh AS iumxxmh_terkecil ON iumxxmh_terkecil.id = wdnittd.id_iumxxmh_terkecil
				LEFT JOIN iumxxmh AS iumxxmh_default ON iumxxmh_default.id = wdnittd.id_iumxxmh_default
				LEFT JOIN imtxxmh as imtxxmh ON imtxxmh.kode = '.$imtxxmh_kode.'
				LEFT JOIN wloxxmh wlo ON wlo.id = wdnittd.id_wloxxmh
				LEFT JOIN wdnlptd b ON b.id_wdnxxth = wdnxxth.id
				WHERE wdnxxth.id = :id
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
						sum(b.jumlah_unit) AS jumlah_unit_dp,
						a.jumlah_unit - SUM(b.jumlah_unit) AS sisa_pc
					FROM wpclptd a
					LEFT JOIN wdplptd b ON b.id_wpclptd = a.id
					LEFT JOIN iimxxmh c ON c.id = b.id_iimxxmh
					LEFT JOIN iumxxmh d ON d.id = b.id_iumxxmh_unit
					LEFT JOIN wdoittd e ON e.id = a.id_wdoittd
					LEFT JOIN wloxxmh f ON f.id = a.id_wloxxmh_tujuan
					LEFT JOIN wpcxxth h ON h.id = a.id_wpcxxth
					WHERE e.id_wdoxxth = :id_wdoxxth AND h.transaction_state <> 9
					GROUP BY a.id
					HAVING sisa_pc > 0
			'
			);
		$rs_wdp = $qs_wdp->fetch();
		if (!empty($rs_wdp)) {
			$id_wpcxxth = $rs_wdp['id_wpcxxth'];
			//Minus di Transit Out untuk DP yang belum dibuat DN
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
						SELECT
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
							-(a.jumlah_unit - SUM(b.jumlah_unit)) AS sisa_pc,
							a.jumlah_konversi,
							-(a.jumlah_terkecil - SUM(b.jumlah_terkecil)) AS sisa_terkecil,
							-(a.jumlah_default - SUM(b.jumlah_default)) AS sisa_default,
							a.expired_date,
							a.batch_number
						FROM wpclptd a
						LEFT JOIN wdplptd b ON b.id_wpclptd = a.id
						LEFT JOIN wdoittd e ON e.id = a.id_wdoittd
						LEFT JOIN wpcxxth h ON h.id = a.id_wpcxxth
						LEFT JOIN wloxxmh wlo ON wlo.id = b.id_wloxxmh_asal
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
			
			//Plus di Lokasi return
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
						SELECT
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
							(a.jumlah_unit - SUM(b.jumlah_unit)) AS sisa_pc,
							a.jumlah_konversi,
							(a.jumlah_terkecil - SUM(b.jumlah_terkecil)) AS sisa_terkecil,
							(a.jumlah_default - SUM(b.jumlah_default)) AS sisa_default,
							a.expired_date,
							a.batch_number
						FROM wpclptd a
						LEFT JOIN wdplptd b ON b.id_wpclptd = a.id
						LEFT JOIN wdoittd e ON e.id = a.id_wdoittd
						LEFT JOIN wpcxxth h ON h.id = a.id_wpcxxth
						LEFT JOIN wloxxmh asal ON asal.id = b.id_wloxxmh_asal
						LEFT JOIN iwhxxmh iwh ON iwh.id = asal.id_iwhxxmh
						LEFT JOIN wloxxmh wlo ON wlo.id_iwhxxmh = iwh.id AND wlo.nama = "Location Return"
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
		
		//cek apakah ada item Picking yang belum di Dispatch
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
						sum(b.jumlah_unit) AS jumlah_unit_dn,
						a.jumlah_unit - SUM(b.jumlah_unit) AS sisa_dp
					FROM wdplptd a
					LEFT JOIN wdnlptd b ON b.id_wdplptd = a.id
					LEFT JOIN iimxxmh c ON c.id = b.id_iimxxmh
					LEFT JOIN iumxxmh d ON d.id = b.id_iumxxmh_unit
					LEFT JOIN wdoittd e ON e.id = a.id_wdoittd
					LEFT JOIN wloxxmh f ON f.id = a.id_wloxxmh_tujuan
					LEFT JOIN wdpxxth h ON h.id = a.id_wdpxxth
					WHERE e.id_wdoxxth = :id_wdoxxth AND h.transaction_state <> 9
					GROUP BY a.id
					HAVING sisa_dp > 0
			'
			);
		$rs_wdn = $qs_wdn->fetch();
		if (!empty($rs_wdn)) {
			$id_wdpxxth = $rs_wdn['id_wdpxxth'];
			//Minus di Transit Out untuk dn yang belum dibuat DN
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
						SELECT
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
							-(a.jumlah_unit - SUM(b.jumlah_unit)) AS sisa_dp,
							a.jumlah_konversi,
							-(a.jumlah_terkecil - SUM(b.jumlah_terkecil)) AS sisa_terkecil,
							-(a.jumlah_default - SUM(b.jumlah_default)) AS sisa_default,
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
			
			//Plus di Lokasi return
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
						SELECT
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
							(a.jumlah_unit - SUM(b.jumlah_unit)) AS sisa_dp,
							a.jumlah_konversi,
							(a.jumlah_terkecil - SUM(b.jumlah_terkecil)) AS sisa_terkecil,
							(a.jumlah_default - SUM(b.jumlah_default)) AS sisa_default,
							a.expired_date,
							a.batch_number
						FROM wdplptd a
						LEFT JOIN wdnlptd b ON b.id_wdplptd = a.id
						LEFT JOIN wdoittd e ON e.id = a.id_wdoittd
						LEFT JOIN wdpxxth h ON h.id = a.id_wdpxxth
						LEFT JOIN wloxxmh asal ON asal.id = a.id_wloxxmh_tujuan
						LEFT JOIN iwhxxmh iwh ON iwh.id = asal.id_iwhxxmh
						LEFT JOIN wloxxmh wlo ON wlo.id_iwhxxmh = iwh.id AND wlo.nama = "Location Return"
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

		//jika sudah confirm, maka DO akan di close
		$qu_wdoxxth = $db
			->query('update', 'wdoxxth')
			->set('transaction_state',9)
			->where('id',$id_wdoxxth)
			->exec();

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