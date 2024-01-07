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

	// BEGIN ambil data confirmed_at dari table activity_log_ml
	$qs_activity_log_ml = $db
		->query('select', 'activity_log_ml' )
		->get([
			'activity_log_ml.created_on as confirmed_at'
		] )
		->where('activity_log_ml.id_transaksi', $id )
		->where('activity_log_ml.kode', 'CONFIRM' )
		->where('activity_log_ml.nama', 'itoxxth' )
		->exec();
	$rs_activity_log_ml = $qs_activity_log_ml->fetch();
	$confirmed_at = $rs_activity_log_ml['confirmed_at'];
	// END ambil data confirmed_at dari table activity_log_ml

	// Dari gudang asal mengirim ke transit (-)
	$qi_asal = $db
		->raw()
		->bind(':id', $id)
		->exec('
			INSERT INTO iivxxrd (
				id_transaksi_h,
				id_transaksi_d,
				id_gbrxxmh,
				id_iwhxxmh,
				id_relasi_m,
				id_iimxxmh,
				id_iumxxmh_unit,
				id_iumxxmh_terkecil,
				id_iumxxmh_default,
				kode,
				keterangan,
				confirmed_at,
				created_by,
				imtxxmh_kode,
				relasi_m_kode,
				relasi_m_nama,
				tanggal,
				is_fisik,
				jumlah_unit,
				jumlah_konversi,
				jumlah_terkecil,
				jumlah_default
			)
			SELECT
				a.id as id_transaksi_h,
				b.id as id_transaksi_d,
				a.id_gbrxxmh as id_gbrxxmh,
				a.id_iwhxxmh_asal as id_iwhxxmh,
				a.id_iwhxxmh_tujuan as id_relasi_m,
				b.id_iimxxmh,
				b.id_iumxxmh_unit,
				b.id_iumxxmh_terkecil,
				b.id_iumxxmh_default,
				a.kode,
				a.keterangan,
				"'.$confirmed_at.'",
				a.created_by,
				301 as imtxxmh_kode,
				iwhxxmh_tujuan.kode,
				iwhxxmh_tujuan.nama,
				a.tanggal,
				1 as is_fisik,
				-b.jumlah_unit as jumlah_unit,
				b.jumlah_konversi as jumlah_konversi,
				-b.jumlah_terkecil as jumlah_terkecil,
				-b.jumlah_default as jumlah_default
			FROM itoxxth a
			LEFT JOIN itoittd b ON b.id_itoxxth = a.id
			LEFT JOIN iwhxxmh as iwhxxmh_asal ON iwhxxmh_asal.id = a.id_iwhxxmh_asal
			LEFT JOIN iwhxxmh AS iwhxxmh_tujuan ON iwhxxmh_tujuan.id = a.id_iwhxxmh_tujuan
			WHERE a.id = :id
		');
	
	// DIKIRIM atau Masuk ke Gudang Transit (+)
	$qi_tujuan = $db
		->raw()
		->bind(':id', $id)
		->exec('
			INSERT INTO iivxxrd (
				id_transaksi_h,
				id_transaksi_d,
				id_gbrxxmh,
				id_iwhxxmh,
				id_relasi_m,
				id_iimxxmh,
				id_iumxxmh_unit,
				id_iumxxmh_terkecil,
				id_iumxxmh_default,
				kode,
				keterangan,
				confirmed_at,
				created_by,
				imtxxmh_kode,
				relasi_m_kode,
				relasi_m_nama,
				tanggal,
				is_fisik,
				jumlah_unit,
				jumlah_konversi,
				jumlah_terkecil,
				jumlah_default
			)
			SELECT
				a.id as id_transaksi_h,
				b.id as id_transaksi_d,
				1 as id_gbrxxmh,
				iwhxxmh_transit.id as id_iwhxxmh,
				iwhxxmh_asal.id as id_relasi_m,
				b.id_iimxxmh,
				b.id_iumxxmh_unit,
				b.id_iumxxmh_terkecil,
				b.id_iumxxmh_default,
				a.kode,
				a.keterangan,
				"'.$confirmed_at.'",
				a.created_by,
				301 as imtxxmh_kode,
				iwhxxmh_asal.kode,
				iwhxxmh_asal.nama,
				a.tanggal,
				1 as is_fisik,
				b.jumlah_unit as jumlah_unit,
				b.jumlah_konversi as jumlah_konversi,
				b.jumlah_terkecil as jumlah_terkecil,
				b.jumlah_default as jumlah_default
			FROM itoxxth a
			LEFT JOIN itoittd b ON b.id_itoxxth = a.id
			LEFT JOIN iwhxxmh AS iwhxxmh_asal ON iwhxxmh_asal.id = a.id_iwhxxmh_asal
			LEFT JOIN iwhxxmh AS iwhxxmh_tujuan ON iwhxxmh_tujuan.id = a.id_iwhxxmh_tujuan
			LEFT JOIN iwhxxmh AS iwhxxmh_transit ON iwhxxmh_transit.kode = CONCAT("WHTR ", iwhxxmh_asal.kode, " - ", iwhxxmh_tujuan.kode) OR iwhxxmh_transit.kode = CONCAT("WHTR ", iwhxxmh_tujuan.kode, " - ", iwhxxmh_asal.kode)
			WHERE a.id = :id
		');

	// tampilkan results
    include( "../../../../usersc/helpers/fn_ajax_results.php" );
?>