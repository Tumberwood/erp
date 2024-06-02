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
		->where('activity_log_ml.nama', 'wreittd' )
		->exec();
	$rs_activity_log_ml = $qs_activity_log_ml->fetch();
	$confirmed_at       = $rs_activity_log_ml['confirmed_at'];
	$confirmed_date     = new Carbon($rs_activity_log_ml['confirmed_at']);
	// END ambil data confirmed_at dari table activity_log_ml

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
				a.id as id_transaksi_d,
				1 as id_gbrxxmh,
				iwhxxmh.id as id_iwhxxmh,
				a.id_grlxxmh_supplier as id_relasi_m,
				a.id_iimxxmh,
				a.id_iumxxmh_unit,
				a.id_iumxxmh_terkecil,
				a.id_iumxxmh_default,
				a.kode,
				a.keterangan,
				"'.$confirmed_at.'",
				a.created_by,
				101 as imtxxmh_kode,
				grlxxmh.kode,
				grlxxmh.nama,
				"'.$confirmed_date->format('Y-m-d').'",
				1 as is_fisik,
				a.jumlah_unit as jumlah_unit,
				a.jumlah_konversi as jumlah_konversi,
				a.jumlah_terkecil as jumlah_terkecil,
				a.jumlah_default as jumlah_default
			FROM wreittd a
			LEFT JOIN iwhxxmh ON iwhxxmh.id = a.id_iwhxxmh
			LEFT JOIN grlxxmh ON grlxxmh.id = a.id_grlxxmh_supplier
			WHERE a.id = :id
		');

	// tampilkan results
    include( "../../../../usersc/helpers/fn_ajax_results.php" );
?>