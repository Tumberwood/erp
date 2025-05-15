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
	
	$id_dash_outbound_h = $_POST['id_dash_outbound_h'];

	$qs_dash = $db
		->raw()
		->bind(':id_dash_outbound_h',$id_dash_outbound_h)
		->exec('WITH picking_list AS (   
					SELECT  
						b.id_wdoxxth,       
						a.wdoxxth_kode,
						i.kode,
						i.nama,
						SUM(a.subtotal_jumlah_unit) jumlah_unit_pl,
						ifnull(e.jumlah_unit,0) jumlah_unit_pc,
						(ifnull(e.jumlah_unit,0) / SUM(a.subtotal_jumlah_unit)) * 100 persen_pc,
						
						ifnull(f.jumlah_unit,0) jumlah_unit_dp,
						(ifnull(f.jumlah_unit,0) / SUM(a.subtotal_jumlah_unit)) * 100 persen_dp
					FROM wplittd a
					LEFT JOIN wdoittd b ON b.id = a.id_wdoittd
					LEFT JOIN wplxxth c ON c.id = a.id_wplxxth
    				LEFT JOIN iimxxmh i ON i.id = a.id_iimxxmh
				
					-- picking
					LEFT JOIN (
						SELECT
							wd.id_wdoxxth,
							wd.id id_wdoittd,
							SUM(pc.jumlah_unit) jumlah_unit
						FROM wpllptd pl
						LEFT JOIN wpclptd pc ON pc.id_wpllptd = pl.id
						LEFT JOIN wdoittd wd ON wd.id = pc.id_wdoittd
						LEFT JOIN wplxxth plth ON plth.id = pl.id_wplxxth
						WHERE wd.id_wdoxxth = :id_dash_outbound_h AND plth.transaction_state NOT IN (9, -9)
						GROUP BY wd.id
					) e ON e.id_wdoxxth = b.id_wdoxxth AND e.id_wdoittd = b.id
				
					-- dispatch
					LEFT JOIN (
						SELECT
							wd.id_wdoxxth,
							wd.id id_wdoittd,
							SUM(dp.jumlah_unit) jumlah_unit
						FROM wpllptd pl
						LEFT JOIN wdplptd dp ON dp.id_wpllptd = pl.id
						LEFT JOIN wdoittd wd ON wd.id = dp.id_wdoittd
						LEFT JOIN wplxxth plth ON plth.id = pl.id_wplxxth
						WHERE wd.id_wdoxxth = :id_dash_outbound_h AND plth.transaction_state NOT IN (9, -9)
						GROUP BY wd.id
					) f ON f.id_wdoxxth = b.id_wdoxxth AND f.id_wdoittd = b.id
				
					WHERE b.id_wdoxxth = :id_dash_outbound_h AND c.transaction_state NOT IN (9, -9)
					GROUP BY b.id
				),
				total_nilai AS (
					SELECT
						id_wdoxxth,
						( SUM(ifnull(jumlah_unit_pc,0)) / SUM(jumlah_unit_pl) ) * 100 persen_total_pc,
						( SUM(ifnull(jumlah_unit_dp,0)) / SUM(jumlah_unit_pl) ) * 100 persen_total_dp
					FROM picking_list pl
					GROUP BY id_wdoxxth 
				)
				SELECT
					a.*,
					persen_total_pc,
					persen_total_dp
				FROM picking_list a
				LEFT JOIN total_nilai b on b.id_wdoxxth = a.id_wdoxxth
				;
		');
	$rs_dash = $qs_dash->fetchAll();
	if (!empty($rs_dash)) {
		echo json_encode( ['data' => $rs_dash]);
	}else{
		echo json_encode( [ "data" => [] ] );
	}
	
?>