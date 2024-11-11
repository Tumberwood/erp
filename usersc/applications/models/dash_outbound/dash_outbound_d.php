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
		->exec('SELECT  
					b.id_wdoxxth,
					b.id_wdoxxth,       
					a.wdoxxth_kode,
					SUM(a.subtotal_jumlah_unit) jumlah_unit_pl,
					ifnull(e.jumlah_unit,0) jumlah_unit_pc,
					(ifnull(e.jumlah_unit,0) / SUM(a.subtotal_jumlah_unit)) * 100 persen_pc,
					
					ifnull(f.jumlah_unit,0) jumlah_unit_dp,
					(ifnull(f.jumlah_unit,0) / SUM(a.subtotal_jumlah_unit)) * 100 persen_dp
				FROM wplittd a
				LEFT JOIN wdoittd b ON b.id = a.id_wdoittd
				LEFT JOIN wplxxth c ON c.id = a.id_wplxxth
				
				-- picking
				LEFT JOIN (
					SELECT
						wd.id_wdoxxth,
						SUM(pc.jumlah_unit) jumlah_unit
					FROM wpllptd pl
					LEFT JOIN wpclptd pc ON pc.id_wpllptd = pl.id
					LEFT JOIN wdoittd wd ON wd.id = pc.id_wdoittd
					LEFT JOIN wplxxth plth ON plth.id = pl.id_wplxxth
					WHERE wd.id_wdoxxth = :id_dash_outbound_h AND plth.transaction_state NOT IN (9, -9)
				) e ON e.id_wdoxxth = b.id_wdoxxth
				
				-- dispatch
				LEFT JOIN (
					SELECT
						wd.id_wdoxxth,
						SUM(dp.jumlah_unit) jumlah_unit
					FROM wpllptd pl
					LEFT JOIN wdplptd dp ON dp.id_wpllptd = pl.id
					LEFT JOIN wdoittd wd ON wd.id = dp.id_wdoittd
					LEFT JOIN wplxxth plth ON plth.id = pl.id_wplxxth
					WHERE wd.id_wdoxxth = :id_dash_outbound_h AND plth.transaction_state NOT IN (9, -9)
				) f ON f.id_wdoxxth = b.id_wdoxxth
				
				WHERE b.id_wdoxxth = :id_dash_outbound_h AND c.transaction_state NOT IN (9, -9)
				GROUP BY b.id_wdoxxth
				;
		');
	$rs_dash = $qs_dash->fetchAll();
	if (!empty($rs_dash)) {
		echo json_encode( ['data' => $rs_dash]);
	}else{
		echo json_encode( [ "data" => [] ] );
	}
	
?>