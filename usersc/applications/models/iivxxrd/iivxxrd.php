<?php
	/**
	 * Kolom :
	 * 	- dari htlgrmh, dan 
	 * 	- HK		: Hari Kerja
	 * 	- OFF		: Jadwal Off
	 * 	- NJ		: Jadwal Belum Dibuat
	 */

	include( "../../../../users/init.php" );
	include( "../../../../usersc/lib/DataTables.php" );

	require '../../../../usersc/vendor/autoload.php';
	use Carbon\Carbon;
	
	use
		DataTables\Editor,
		DataTables\Editor\Query,
		DataTables\Editor\Result;

		
	$awal 			= new Carbon($_POST['start_date']);
	$start_date = $awal->format('Y-m-d');

	$qs_iivxxrd = $db
		->raw()
		->bind(':start_date', $start_date)
		->exec('SELECT
					a.kode,
					b.nama,
					e.nama AS uom,
					c.nama AS wh,
					if(a.`sign`= "-" OR a.imtxxmh_kode = 201,  -SUM(a.jumlah_terkecil), SUM(a.jumlah_terkecil)) AS qty_terkecil
				FROM iivxxrd AS a
				LEFT JOIN iimxxmh AS b ON b.id = a.id_iimxxmh
				LEFT JOIN iwhxxmh AS c ON c.id = a.id_iwhxxmh
				LEFT JOIN iimummd AS d ON d.id_iimxxmh = a.id_iimxxmh AND d.is_terkecil = 1
				LEFT JOIN iumxxmh AS e ON e.id = d.id_iumxxmh
				WHERE a.tanggal = :start_date
				GROUP BY a.id_iwhxxmh, a.id_iimxxmh
				'
				);
	$rs_iivxxrd = $qs_iivxxrd->fetchAll();

	$results = array();

	if (!empty($rs_iivxxrd)) {
		$results['data'] = $rs_iivxxrd;
		
		$results['columns'] = [
			['data' => 'kode', 'name' => 'kode'],
			['data' => 'nama', 'name' => 'nama'],
			['data' => 'uom', 'name' => 'uom'],
			['data' => 'wh', 'name' => 'wh'],
			['data' => 'qty_terkecil', 'name' => 'qty_terkecil']
		];
		
	} else {
		$results['data'] = [];
		$results['columns'] = [];
	}

	echo json_encode($results);
?>