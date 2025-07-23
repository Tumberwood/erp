<?php	
	/**
	 * Digunakan untuk insert inventory ke iivxxrd
	 */
	include_once( "../../../../users/init.php" );
	include_once( "../../../../usersc/lib/DataTables.php" );
	include_once( "../../../../usersc/helpers/datatables_fn_debug.php" );
	include_once( "../../../../usersc/vendor/autoload.php");
	include_once( "../../../../usersc/helpers/hakakses_s_fn.php" );
	// include_once( "../../../helpers/hakakses_s_fn.php" );

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

	try{
		$db->transaction();

		// ganti movement type sesuai jenis transaksi
		//Putaway
		$imtxxmh_kode = 313;

		$keterangan    = $_POST['keterangan'];
		$jumlah_unit    = $_POST['jumlah_unit'];
		$wlpxxmh_kode    = $_POST['wlpxxmh_kode'];
		$id_iumxxmh_unit    = $_POST['id_iumxxmh_unit'];
		$id_iimxxmh    = $_POST['id_iimxxmh'];
		$id_iwhxxmh    = $_POST['id_iwhxxmh'];
		$id_wloxxmh_asal    = $_POST['id_wloxxmh_asal'];
		$id_wloxxmh_tujuan    = $_POST['id_wloxxmh_tujuan'];
		$state = $_POST['state'];


		if ($state == 1) {
			//insert
			if ($jumlah_unit > 0) {
				//Receiving diminuskan tapi is_fisik = 0
				$qi_iivxxrd = $db
					->raw()
					->bind(':keterangan', $keterangan)
					->bind(':jumlah_unit', $jumlah_unit)
					->bind(':wlpxxmh_kode', $wlpxxmh_kode)
					->bind(':id_iumxxmh_unit', $id_iumxxmh_unit)
					->bind(':id_iimxxmh', $id_iimxxmh)
					->bind(':id_iwhxxmh', $id_iwhxxmh)
					->bind(':id_wloxxmh_asal', $id_wloxxmh_asal)
					->bind(':id_wloxxmh_tujuan', $id_wloxxmh_tujuan)
					->exec('
						INSERT INTO iivxxrd (
							id_wloctmh,
							wlpxxmh_kode,
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
							3 as id_wloctmh,
							:wlpxxmh_kode,
							:id_iwhxxmh as id_iwhxxmh,
							:id_wloxxmh_asal as id_wloxxmh,
							:id_wloxxmh_tujuan,
							relasi.id as id_relasi_m,
							:id_iimxxmh,
							:id_iumxxmh_unit,
							iumxxmh_terkecil.id,
							iumxxmh_default.id,
							:keterangan,
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
						LEFT JOIN imtxxmh imtxxmh ON imtxxmh.kode = '.$imtxxmh_kode.' AND imtxxmh.transaction_state = 1 AND module = "WMS"
						WHERE iwhxxmh.id = :id_iwhxxmh
				');
			}
		} else if ($state == 2) {
			//update ketika button start dipilih

            // BEGIN get jumlah_konversi
            $qs_jumlah_konversi = $db
                ->query('select', 'iimummd')
                ->get('jumlah_konversi')
                ->where('id_iimxxmh',$id_iimxxmh)
                ->where('id_iumxxmh',$id_iumxxmh_unit)
                ->exec();
            $rs_jumlah_konversi = $qs_jumlah_konversi->fetch();

            $jumlah_konversi    = $rs_jumlah_konversi['jumlah_konversi'];
            $jumlah_terkecil    = $jumlah_konversi * $jumlah_unit; 
            // END get jumlah_konversi

            // BEGIN get UoM terkecil
            $qs_iumxxmh_terkecil = $db
                ->query('select', 'iimummd' )
                ->get([
                    'id_iumxxmh as id_iumxxmh_terkecil'
                ] )
                ->where('iimummd.id_iimxxmh', $id_iimxxmh )
                ->where('iimummd.is_terkecil', 1 )
                ->exec();
            $rs_iumxxmh_terkecil = $qs_iumxxmh_terkecil->fetch();

            $id_iumxxmh_terkecil = $rs_iumxxmh_terkecil['id_iumxxmh_terkecil'];
            // END get UoM terkecil

            // BEGIN get UoM default
            $qs_iumxxmh_default = $db
                ->query('select', 'iimummd' )
                ->get([
                    'id_iumxxmh as id_iumxxmh_default',
                    'jumlah_konversi as jumlah_konversi_default'
                ] )
                ->where('iimummd.id_iimxxmh', $id_iimxxmh )
                ->where('iimummd.is_default', 1 )
                ->exec();
            $rs_iumxxmh_default = $qs_iumxxmh_default->fetch();

            $id_iumxxmh_default         = $rs_iumxxmh_default['id_iumxxmh_default'];
            $jumlah_konversi_default    = $rs_iumxxmh_default['jumlah_konversi_default'];

            $jumlah_default = $jumlah_konversi * $jumlah_unit / $jumlah_konversi_default;
            // END get UoM default

			//nama uom dan kode
			$qs_uom_unit = $db
				->query('select', 'iumxxmh' )
				->get([
					'kode',
					'nama',
					] )
				->where('id', $id_iumxxmh_unit )
				->exec();
			$rs_uom_unit = $qs_uom_unit->fetch();
			$iumxxmh_unit_kode = $rs_uom_unit['kode'];
			$iumxxmh_unit_nama = $rs_uom_unit['nama'];

			$qi_iivxxrd = $db
				->query('update', 'iivxxrd')
                ->set('iumxxmh_unit_kode',$iumxxmh_unit_kode)
                ->set('iumxxmh_unit_nama',$iumxxmh_unit_nama)
                ->set('id_iumxxmh_unit',$id_iumxxmh_unit)
                ->set('id_iumxxmh_terkecil',$id_iumxxmh_terkecil)
                ->set('id_iumxxmh_default',$id_iumxxmh_default)
				->set('jumlah_unit',-$jumlah_unit)
                ->set('jumlah_konversi',$jumlah_konversi)
                ->set('jumlah_terkecil',-$jumlah_terkecil) 
                ->set('jumlah_default',-$jumlah_default) 
				->where('keterangan',$keterangan)
				->exec();

		} else if ($state == 3) {
			//ketika form di close maka akan dihapus
			$qi_iivxxrd = $db
			->query('delete', 'iivxxrd')
			->where('keterangan',$keterangan)
			->exec();
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