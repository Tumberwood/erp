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
	
	// Dari gudang asal mengirim ke transit (-)
	$qi_asal = $db
		->raw()
		->bind(':id', $id)
		->exec('INSERT INTO iivxxrd (
					id_gbrxxmh,
					is_fisik,
					id_iwhxxmh,
					id_iwhxxmh_asal,
					id_iwhxxmh_tujuan,
					kode,
					id_iimxxmh,
					id_transaksi_h,
					id_transaksi_d,
					keterangan,
					created_by,
					imtxxmh_kode,
					sign,
					tanggal,
					jumlah_unit,
					jumlah_konversi,
					jumlah_terkecil
				)
				SELECT
					1 AS id_gbrxxmh,
					1 AS is_fisik,
					a.id_iwhxxmh_asal AS id_iwhxxmh,
					a.id_iwhxxmh_asal AS id_iwhxxmh_asal,
					a.id_iwhxxmh_tujuan AS id_iwhxxmh_tujuan,
					a.kode AS kode,
					b.id_iimxxmh AS id_iimxxmh,
					a.id AS id_transaksi_h,
					b.id AS id_transaksi_d,
					"Keluar" AS keterangan,
					a.created_by AS created_by,
					201 AS imtxxmh_kode,
					"-" AS sign,
					a.tanggal AS tanggal,
					b.jumlah_unit AS jumlah_unit,
					b.jumlah_konversi AS jumlah_konversi,
					b.jumlah_terkecil AS jumlah_terkecil
				FROM itoxxth AS a
				LEFT JOIN itoittd AS b ON b.id_itoxxth = a.id
				LEFT JOIN iwhxxmh AS gudang ON gudang.id = a.id_iwhxxmh_tujuan
				WHERE a.id = :id;
		
				'
				);
	
	// DIKIRIM atau Masuk ke Gudang Transit (+)
	$qi_tujuan = $db
		->raw()
		->bind(':id', $id)
		->exec('INSERT INTO iivxxrd (
					id_gbrxxmh,
					is_fisik,
					id_iwhxxmh,
					id_iwhxxmh_asal,
					id_iwhxxmh_tujuan,
					kode,
					id_iimxxmh,
					id_transaksi_h,
					id_transaksi_d,
					keterangan,
					created_by,
					imtxxmh_kode,
					sign,
					tanggal,
					jumlah_unit,
					jumlah_konversi,
					jumlah_terkecil
				)
				SELECT
					1 AS id_gbrxxmh,
					1 AS is_fisik,
					transit.id AS id_iwhxxmh,
					a.id_iwhxxmh_asal AS id_iwhxxmh_asal,
					a.id_iwhxxmh_tujuan AS id_iwhxxmh_tujuan,
					a.kode AS kode,
					b.id_iimxxmh AS id_iimxxmh,
					a.id AS id_transaksi_h,
					b.id AS id_transaksi_d,
					"Masuk" AS keterangan,
					a.created_by AS created_by,
					101 AS imtxxmh_kode,
					"+" AS sign,
					a.tanggal AS tanggal,
					b.jumlah_unit AS jumlah_unit,
					b.jumlah_konversi AS jumlah_konversi,
					b.jumlah_terkecil AS jumlah_terkecil
				FROM itoxxth AS a
				LEFT JOIN itoittd AS b ON b.id_itoxxth = a.id
				LEFT JOIN iwhxxmh AS asal ON asal.id = a.id_iwhxxmh_asal
				LEFT JOIN iwhxxmh AS tujuan ON tujuan.id = a.id_iwhxxmh_tujuan
				LEFT JOIN iwhxxmh AS transit ON transit.kode = CONCAT("WHTR ", asal.kode, " - ", tujuan.kode) OR transit.kode = CONCAT("WHTR ", tujuan.kode, " - ", asal.kode)
				WHERE a.id = :id;
		
				'
				);

	if($state == 1){

	} else if($state == 2) {
	}

	

?>