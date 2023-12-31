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

	// (ROW_NUMBER() OVER (ORDER BY a.id) * (ROW_NUMBER() OVER (ORDER BY a.id) - 1)) / 2 AS result

	if($state == 1){
		$qs_wh = $db
			->raw()
			->bind(':transaction_state', 1)
			->exec('
				SELECT
					a.kode,
					a.nama,
					a.id_gbrxxmh,
					a.id,
					ROW_NUMBER() OVER (ORDER BY a.id) AS urutan
				FROM
					iwhxxmh AS a
				WHERE 
					a.transaction_state = :transaction_state AND 
					is_sistem IS NULL
			');
		$rs_wh = $qs_wh->fetchAll();

		foreach ($rs_wh as $key => $wh1) {
			foreach ($rs_wh as $key => $wh2) {
				if ($wh1['urutan'] < $wh2['urutan']) {
					
					$nama = 'WHTR ' . $wh1['nama'] . ' - ' . $wh2['nama'];
					$kode = 'WHTR ' . $wh1['kode'] . ' - ' . $wh2['kode'];
					
					// cari apakah sudah ada warehouse transit dengan kode terkait 
					// kode merupakan gabungan kode dari 2 warehouse utamanya
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

					// jika belum ada, maka akan insert
					if (empty($rs_cari_whtr)) {
						$qi_bro = $db
							->query('insert', 'iwhxxmh')
							->set('id_gbrxxmh',$wh1['id_gbrxxmh'])
							->set('id_iwhctmh',3)
							->set('nama',$nama)
							->set('kode',$kode)
							->set('transaction_state',1)
							->set('is_sistem',1)
							->exec();
					}
				}
			}
		}			
	
	} // end if($state == 1)

	// tampilkan results
    include( "../../../../usersc/helpers/fn_ajax_results.php" );

?>