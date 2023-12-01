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
	
	$id = $_POST['id_transaksi_h'];
	$state = $_POST['state'];

	if($state == 1){
		$qs_wh = $db
			->raw()
			->exec('
				SELECT
					a.kode,
					a.nama,
					a.id_gbrxxmh,
					a.id,
					ROW_NUMBER() OVER (ORDER BY a.id) AS urutan,
					(ROW_NUMBER() OVER (ORDER BY a.id) * (ROW_NUMBER() OVER (ORDER BY a.id) - 1)) / 2 AS result
				FROM
					iwhxxmh AS a
				WHERE a.transaction_state = 1 AND is_sistem IS NULL
			');

		$rs_wh = $qs_wh->fetchAll();

		// $qd_transit = $db
		// 	->query('delete', 'iwhxxmh')
		// 	->where('is_sistem',1)
		// 	->exec();

		foreach ($rs_wh as $key => $wh1) {
			foreach ($rs_wh as $key => $wh2) {
				if ($wh1['urutan'] < $wh2['urutan']) {
					$nama = 'WHTR ' . $wh1['nama'] . ' - ' . $wh2['nama'];
					$kode = 'WHTR ' . $wh1['kode'] . ' - ' . $wh2['kode'];
					
					$qs_cari_whtr = $db
						->raw()
						->bind(':kode', $kode)
						->exec('
							SELECT
								a.id
							FROM
								iwhxxmh AS a
							WHERE a.transaction_state <> -9 AND is_sistem = 1 AND a.kode = :kode
						');

					$rs_cari_whtr = $qs_cari_whtr->fetch();

					if (empty($rs_cari_whtr)) {
						$qi_bro = $db
							->query('insert', 'iwhxxmh')
							->set('id_gbrxxmh',$wh1['id_gbrxxmh'])
							->set('nama',$nama)
							->set('kode',$kode)
							->set('transaction_state',1)
							->set('is_sistem',1)
							->exec();
					}
				}
			}
		}			
	}

	

?>