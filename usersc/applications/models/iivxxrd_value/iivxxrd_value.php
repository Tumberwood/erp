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
	
	$start_date = new Carbon($_POST['start_date']);
	$end_date = new Carbon($_POST['end_date']);
	$id_iicxxmh = $_POST['id_iicxxmh_old'];
	
	if ($id_iicxxmh > 0) {
		$where = " WHERE id_iicxxmh = " . $id_iicxxmh;
	} else {
		$where = "";
	}

	$qs_wms_log_r = $db
		->raw()
		->bind(':start_date',$start_date)
		->bind(':end_date',$end_date)
		->exec('WITH inventory AS (
					SELECT
						a.id_iimxxmh,
						b.id_iicxxmh,
						b.id_iitxxmh,
						a.iimxxmh_kode,
						a.iimxxmh_nama,
						SUM(IF(a.jumlah_terkecil>0,a.jumlah_terkecil,0)) AS jumlah_in,
						SUM(IF(a.jumlah_terkecil<0,a.jumlah_terkecil,0)) AS jumlah_out,
						
					
						(SELECT x.hpp 
						FROM iivxxrd x 
						WHERE x.id_iimxxmh = a.id_iimxxmh 
						AND x.jumlah_terkecil > 0 AND x.hpp > 0
						ORDER BY x.id DESC 
						LIMIT 1) AS hpp_in,
				
						(SELECT x.hpp 
						FROM iivxxrd x 
						WHERE x.id_iimxxmh = a.id_iimxxmh 
						AND x.jumlah_terkecil < 0 AND x.hpp > 0
						ORDER BY x.id DESC 
						LIMIT 1) AS hpp_out,
						a.iumxxmh_terkecil_kode
					FROM iivxxrd a
					LEFT JOIN iimxxmh b ON b.id = a.id_iimxxmh
					WHERE
						a.jumlah_terkecil <> 0 
						AND a.is_fisik > 0
						AND b.id_iitxxmh = 1
						AND a.tanggal BETWEEN :start_date AND :end_date
					GROUP BY a.id_iimxxmh
					ORDER BY a.id_iimxxmh
				),
				beginning AS (
					SELECT 
						main.id_iimxxmh,
						main.iimxxmh_nama,
						SUM(main.jumlah_terkecil) AS jumlah_begin,
						ifnull(latest_hpp.hpp,0) AS hpp_begin
					FROM iivxxrd main
					LEFT JOIN (
						SELECT id_iimxxmh, hpp
						FROM (
							SELECT 
								id_iimxxmh, 
								hpp,
								ROW_NUMBER() OVER (PARTITION BY id_iimxxmh ORDER BY id DESC) AS rn
							FROM iivxxrd
							WHERE tanggal < :start_date
							AND jumlah_terkecil <> 0 
							AND is_fisik > 0
							AND hpp > 0
						) sub
						WHERE rn = 1
					) latest_hpp ON main.id_iimxxmh = latest_hpp.id_iimxxmh
					WHERE 
						main.tanggal < :start_date
						AND main.jumlah_terkecil <> 0
						AND main.is_fisik > 0
					GROUP BY main.id_iimxxmh, main.iimxxmh_nama, latest_hpp.hpp
				)
				SELECT
					i.id_iimxxmh,
					id_iitxxmh,
					id_iicxxmh,
					i.iimxxmh_kode,
					i.iimxxmh_nama,
					IFNULL(jumlah_begin,0) jumlah_begin,
					IFNULL(hpp_begin,0) hpp_begin,
					jumlah_in,
					IFNULL(hpp_in,0) hpp_in,
					jumlah_out,
					IFNULL(hpp_out,0) hpp_out,
					(IFNULL(jumlah_begin,0) + jumlah_in) - ABS(jumlah_out) AS jumlah_ending,
					(IFNULL(hpp_begin,0) + IFNULL(hpp_in,0)) - ABS(IFNULL(hpp_out,0)) hpp_ending
				FROM inventory i
				LEFT JOIN beginning be ON be.id_iimxxmh = i.id_iimxxmh
		'. $where);
	$rs_wms_log_r = $qs_wms_log_r->fetchAll();
	if (!empty($rs_wms_log_r)) {
		echo json_encode( ['data' => $rs_wms_log_r]);
	}else{
		echo json_encode( [ "data" => [] ] );
	}
	
?>