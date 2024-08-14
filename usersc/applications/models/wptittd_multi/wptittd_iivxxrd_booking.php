<?php	
	/**
	 * Digunakan untuk insert inventory ke iivxxrd
	 */
	include_once( "../../../../users/init.php" );
	include_once( "../../../../usersc/lib/DataTables.php" );
	include_once( "../../../../usersc/helpers/datatables_fn_debug.php" );
	include_once( "../../../../usersc/vendor/autoload.php");
	include_once( "../../../../usersc/helpers/hakakses_s_fn.php" );
	include_once( "../../../helpers/SolusiIndonesiaUtilities.php" );
	// include_once( "../../../helpers/hakakses_s_fn.php" );

    use Carbon\Carbon;
	use
        SolusiIndonesia\Utilities\General;
	
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
		//Putaway
		$imtxxmh_kode = 311;

		$keterangan    = $_POST['keterangan'];
		$jumlah_unit    = $_POST['jumlah_unit'];
		$wlpxxmh_kode    = $_POST['wlpxxmh_kode'];
		$id_iumxxmh_unit    = $_POST['id_iumxxmh_unit'];
		$id_iimxxmh    = $_POST['id_iimxxmh'];
		$id_iwhxxmh    = $_POST['id_iwhxxmh'];
		$id_wloxxmh_asal    = $_POST['id_wloxxmh_asal'];
		$id_wloxxmh_tujuan    = $_POST['id_wloxxmh_tujuan'];
		$state = $_POST['state'];
		$timestamp    = $_POST['timestamp'];
		$id_wpttpmh    = $_POST['id_wpttpmh'];

		$qs_lpn = $db
			->query('select', 'wptittd' )
			->get(['count(id) as c_id'] )
			->where('transaction_state', 0 )
			->where('wlpxxmh_kode', $wlpxxmh_kode )
			->where('created_by', $s_id_users )
			->exec();
		$rs_lpn = $qs_lpn->fetch();
		$c_id = $rs_lpn['c_id'];

		//cek dulu apakah sudah pernah ada header untuk putaway setelah scan LPN (Insert Detail)
		$qs_header = $db
            ->raw()
            ->bind(':s_id_users', $s_id_users)
            ->exec('SELECT
						b.id id_header_putaway
					FROM wptittd a 
					LEFT JOIN wptxxth b ON b.id = a.id_wptxxth
					WHERE a.created_by = :s_id_users AND a.is_multi_lpn = 1 AND b.transaction_state = 0'
			);
	
		$rs_header = $qs_header->fetch();
		if (empty($rs_header)) {
			$id_header_putaway = 0;
		} else {
			$id_header_putaway = $rs_header['id_header_putaway'];
		}

		//jika belum ada header, maka diinsertkan dulu header putaway nya
		if ($id_header_putaway == 0) {
			$qi_wptxxth = $db
				->raw()
				->bind(':s_id_users', $s_id_users)
				->bind(':id_wpttpmh', $id_wpttpmh)
				->exec('INSERT INTO wptxxth (
							wpaxxmh_kode,
							id_wpttpmh,
							created_by
						)
						SELECT
							"Pallet 1",
							:id_wpttpmh,
							:s_id_users
			');

			$id_wptxxth = $qi_wptxxth->insertId();
		} else {
			$id_wptxxth = $id_header_putaway;
		}
		$finish_at = new Carbon();
		General::logChange( $db , 'wptxxth', $s_id_users, $s_username, 'CREATE', $id_wptxxth, "", $timestamp , $finish_at );
		
		if ($c_id > 0) {
			//tidak perlu insert
		} else {
			if ($jumlah_unit > 0) {
				$qi_wptittd = $db
					->raw()
					->bind(':id_wptxxth', $id_wptxxth)
					->bind(':keterangan', $keterangan)
					->bind(':jumlah_unit', $jumlah_unit)
					->bind(':wlpxxmh_kode', $wlpxxmh_kode)
					->bind(':id_iumxxmh_unit', $id_iumxxmh_unit)
					->bind(':id_iimxxmh', $id_iimxxmh)
					->bind(':id_iwhxxmh', $id_iwhxxmh)
					->bind(':id_wloxxmh_asal', $id_wloxxmh_asal)
					->bind(':id_wloxxmh_tujuan', $id_wloxxmh_tujuan)
					->bind(':s_id_users', $s_id_users)
					->bind(':id_wpttpmh', $id_wpttpmh)
					->exec('INSERT INTO wptittd (
								id_wptxxth,
								id_wjtxxmh,
								id_wpttpmh,
								id_gcpxxmh,
								id_gbrxxmh,
								is_multi_lpn,
								wlpxxmh_kode,
								wpaxxmh_kode,
								id_iwhxxmh,
								id_wloxxmh_asal,
								id_wloxxmh_tujuan,
								id_iimxxmh,
								id_iumxxmh_unit,
								id_iumxxmh_terkecil,
								id_iumxxmh_default,
								keterangan,
								created_by,
								jumlah_unit,
								jumlah_unit_os,
								jumlah_konversi,
								jumlah_terkecil_os,
								jumlah_terkecil,
								jumlah_default,
								jumlah_default_os
							)
							SELECT DISTINCT
								:id_wptxxth,
								4 as id_wjtxxmh,
								:id_wpttpmh,
								1,
								1,
								1,
								:wlpxxmh_kode,
								"Pallet 1",
								:id_iwhxxmh as id_iwhxxmh,
								:id_wloxxmh_asal as id_wloxxmh,
								:id_wloxxmh_tujuan,
								:id_iimxxmh,
								:id_iumxxmh_unit,
								iumxxmh_terkecil.id,
								iumxxmh_default.id,
								:keterangan,
								:s_id_users,
								:jumlah_unit,
								:jumlah_unit as jumlah_unit_os,
								konversi.jumlah_konversi,
								konversi.jumlah_konversi * :jumlah_unit,
								konversi.jumlah_konversi * :jumlah_unit as jumlah_terkecil_os,
								konversi.jumlah_konversi * :jumlah_unit / def.jumlah_konversi,
								konversi.jumlah_konversi * :jumlah_unit / def.jumlah_konversi as jumlah_default_os
							FROM iwhxxmh
							LEFT JOIN wloxxmh ON wloxxmh.id = :id_wloxxmh_asal
							LEFT JOIN wreittd re ON re.wlpxxmh_kode = :wlpxxmh_kode
							LEFT JOIN iimxxmh ON iimxxmh.id = :id_iimxxmh
							LEFT JOIN iimummd terkecil ON terkecil.id_iimxxmh = :id_iimxxmh AND terkecil.is_terkecil = 1
							LEFT JOIN iimummd def ON def.id_iimxxmh = :id_iimxxmh AND def.is_default = 1
							LEFT JOIN iimummd konversi ON konversi.id_iimxxmh = :id_iimxxmh AND konversi.id_iumxxmh = :id_iumxxmh_unit 
							LEFT JOIN iumxxmh iumxxmh_unit ON iumxxmh_unit.id = :id_iumxxmh_unit
							LEFT JOIN iumxxmh iumxxmh_terkecil ON iumxxmh_terkecil.id = terkecil.id_iumxxmh
							LEFT JOIN iumxxmh iumxxmh_default ON iumxxmh_default.id = def.id_iumxxmh
							WHERE iwhxxmh.id = :id_iwhxxmh
				');
	
				$id_wptittd = $qi_wptittd->insertId();
				
				$finish_at = new Carbon();
				General::logChange( $db , 'wptittd', $s_id_users, $s_username, 'CREATE', $id_wptittd, "", $timestamp , $finish_at );
	
				//Receiving diminuskan tapi is_fisik = 0
				$qi_iivxxrd = $db
					->raw()
					->bind(':id_wptittd', $id_wptittd)
					->bind(':jumlah_unit', $jumlah_unit)
					->bind(':wlpxxmh_kode', $wlpxxmh_kode)
					->bind(':id_iumxxmh_unit', $id_iumxxmh_unit)
					->bind(':id_iimxxmh', $id_iimxxmh)
					->bind(':id_iwhxxmh', $id_iwhxxmh)
					->bind(':id_wloxxmh_asal', $id_wloxxmh_asal)
					->bind(':id_wloxxmh_tujuan', $id_wloxxmh_tujuan)
					->exec('
						INSERT INTO iivxxrd (
							id_transaksi_d,
							id_wloctmh,
							wlpxxmh_kode,
							wpaxxmh_kode,
							id_iwhxxmh,
							id_wloxxmh,
							id_wloxxmh_tujuan,
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
							jumlah_default
						)
						SELECT DISTINCT
							:id_wptittd,
							1 as id_wloctmh,
							:wlpxxmh_kode,
							"Pallet 1",
							:id_iwhxxmh as id_iwhxxmh,
							:id_wloxxmh_asal as id_wloxxmh,
							:id_wloxxmh_tujuan,
							relasi.id as id_relasi_m,
							:id_iimxxmh,
							:id_iumxxmh_unit,
							iumxxmh_terkecil.id,
							iumxxmh_default.id,
							concat("putaway_multi_id_wptittd_", :id_wptittd),
							iwhxxmh.kode,
							iwhxxmh.nama,
							wloxxmh.kode,
							wloxxmh.nama as loc,
							relasi.kode,
							relasi.nama as nama_relasi,
							iimxxmh.kode,
							iimxxmh.nama,
							iumxxmh_unit.kode,
							iumxxmh_unit.nama,
							'.$imtxxmh_kode.' as imtxxmh_kode,
							imtxxmh.movement_type,
							curdate(),
							0 as is_fisik,
							iumxxmh_terkecil.kode,
							iumxxmh_terkecil.nama,
							iumxxmh_default.kode,
							iumxxmh_default.nama,
							-:jumlah_unit,
							konversi.jumlah_konversi,
							-konversi.jumlah_konversi * :jumlah_unit,
							-konversi.jumlah_konversi * :jumlah_unit / def.jumlah_konversi
						FROM iwhxxmh
						LEFT JOIN wloxxmh ON wloxxmh.id = :id_wloxxmh_asal
						LEFT JOIN wreittd re ON re.wlpxxmh_kode = :wlpxxmh_kode
						LEFT JOIN grlxxmh relasi ON relasi.id = re.id_grlxxmh_supplier
						LEFT JOIN iimxxmh ON iimxxmh.id = :id_iimxxmh
						LEFT JOIN iimummd terkecil ON terkecil.id_iimxxmh = :id_iimxxmh AND terkecil.is_terkecil = 1
						LEFT JOIN iimummd def ON def.id_iimxxmh = :id_iimxxmh AND def.is_default = 1
						LEFT JOIN iimummd konversi ON konversi.id_iimxxmh = :id_iimxxmh AND konversi.id_iumxxmh = :id_iumxxmh_unit 
						LEFT JOIN iumxxmh iumxxmh_unit ON iumxxmh_unit.id = :id_iumxxmh_unit
						LEFT JOIN iumxxmh iumxxmh_terkecil ON iumxxmh_terkecil.id = terkecil.id_iumxxmh
						LEFT JOIN iumxxmh iumxxmh_default ON iumxxmh_default.id = def.id_iumxxmh
						LEFT JOIN imtxxmh imtxxmh ON imtxxmh.kode = '.$imtxxmh_kode.'
						WHERE iwhxxmh.id = :id_iwhxxmh
				');
			}
		}

		if(!empty($qi_iivxxrd)){
			$db->commit();
			$status_code  = 200;
			$message      = 'Inventory Berhasil Ditambahkan';
			$type_message = 'success';
		}else{
			$db->rollback();
			$status_code  = 500;
			$message      = 'Inventory Gagal Ditambahkan!';
			$type_message = 'error';
		}
	}catch(PDOException $e){
		$db->rollback();
		$status_code  = 500;
		$message      = 'Inventory Gagal Ditambahkan! ' . $e->getMessage();
		$type_message = 'error';
	}catch (Exception $e) {
		$db->rollback();
		$status_code = 500;
		$message = 'Inventory Gagal Ditambahkan!, ' . $e->getMessage();
		$type_message = 'error';
	}
	// build response
	$data = array(
		'status_code'    => $status_code,
		'state'    => $state,
		'id_wloxxmh_tujuan'    => $id_wloxxmh_tujuan,
		'message'        => $message,
		'type_message'   => $type_message,
	);

	// tampilkan results
    include( "../../../../usersc/helpers/fn_ajax_results.php" );
?>