<?php
	
	include_once( "../../../../users/init.php" );
	include_once( "../../../../usersc/lib/DataTables.php" );
	include_once( "../../../../usersc/helpers/datatables_fn_debug.php" );
	include_once( "../../../../usersc/vendor/autoload.php");
	include_once( "../../../../usersc/helpers/hakakses_s_fn.php" );
	include_once( "../../../helpers/SolusiIndonesiaUtilities.php" );

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
	
	$id = $_POST['id_transaksi'];
	$state = $_POST['state'];

	// (ROW_NUMBER() OVER (ORDER BY a.id) * (ROW_NUMBER() OVER (ORDER BY a.id) - 1)) / 2 AS result

	try{
		
		if($state == 1){
			//updatekan LPN
			
			$qs_wkdlptd = $db
				->query('select', 'wkdlptd' )
				->get(['id'] )
				->where('id_wkdxxth', $id )
				->exec();
			$rs_wkdlptd = $qs_wkdlptd->fetchAll();

			foreach ($rs_wkdlptd as $key => $wkdlptd) {
				$qs_wlpxxmh = $db
					->raw()
					->exec('SELECT
								a.kode
							FROM wlpxxmh a
							WHERE a.is_nextprocess IS NULL
							AND kode NOT IN
							(
								SELECT
									wlpxxmh_kode
								FROM iivxxrd b
								GROUP BY b.wlpxxmh_kode
							)
				');
				$rs_wlpxxmh = $qs_wlpxxmh->fetch();
				$wlpxxmh_kode = $rs_wlpxxmh['kode'];

				$qu_wkdlptd = $db
					->query('update', 'wkdlptd')
					->set('wlpxxmh_kode',$wlpxxmh_kode)
					->where('id',$wkdlptd['id'])
					->exec();
				
				$qu_wlpxxmh = $db
					->query('update', 'wlpxxmh')
					->set('is_nextprocess',1)
					->where('kode',$wlpxxmh_kode)
				->exec();
			}

			//Lepas Booking De Kitting
			$qi_iivxxrd_head_booking = $db
				->raw()
				->bind(':id', $id)
				->exec('INSERT INTO iivxxrd (
							id_gcpxxmh,
							id_gbrxxmh,
							id_transaksi_h,
							id_transaksi_d,
							id_wloctmh,
							kode,
							wlpxxmh_kode,
							id_iwhxxmh,
							id_wloxxmh,
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
							jumlah_default,
							expired_date,
							batch_number
						)
						SELECT DISTINCT
							h.id_gcpxxmh,
							e.id_gbrxxmh,
							b.id AS id_transaksi_h,
							b.id AS id_transaksi_d,
							f.id_wloctmh,
							b.kode,
							b.wlpxxmh_kode_kitting,
							f.id_iwhxxmh,
							b.id_wloxxmh_out,
							b.id_grlxxmh_customer id_relasi_m,
							b.id_iimxxmh,
							b.id_iumxxmh_unit,
							b.id_iumxxmh_terkecil,
							b.id_iumxxmh_default,
							CONCAT("wkdxxth_", b.id) AS keterangan,
							e.kode AS iwhxxmh_kode,
							e.nama AS iwhxxmh_nama,
							f.kode AS wloxxmh_kode,
							f.nama AS wloxxmh_nama,
							c.kode AS relasi_m_kode,
							c.nama AS relasi_m_nama,
							d.kode AS iimxxmh_kode,
							d.nama AS iimxxmh_nama,
							iumxxmh_unit.kode AS iumxxmh_unit_kode,
							iumxxmh_unit.nama AS iumxxmh_unit_nama,
							219,
							g.movement_type,
							curdate(),
							0,
							iumxxmh_terkecil.kode AS iumxxmh_terkecil_kode,
							iumxxmh_terkecil.nama AS iumxxmh_terkecil_nama,
							iumxxmh_default.kode AS iumxxmh_default_kode,
							iumxxmh_default.nama AS iumxxmh_default_nama,
							b.jumlah_unit,
							b.jumlah_konversi,
							b.jumlah_terkecil,
							b.jumlah_default,
							iv.expired_date,
							iv.batch_number

						FROM wkdxxth b
						LEFT JOIN grlxxmh c ON c.id = b.id_grlxxmh_customer
						LEFT JOIN iimxxmh d ON d.id = b.id_iimxxmh
						LEFT JOIN iumxxmh iumxxmh_unit ON iumxxmh_unit.id = b.id_iumxxmh_unit
						LEFT JOIN iumxxmh iumxxmh_terkecil ON iumxxmh_terkecil.id = b.id_iumxxmh_terkecil
						LEFT JOIN iumxxmh iumxxmh_default ON iumxxmh_default.id = b.id_iumxxmh_default
						LEFT JOIN wloxxmh f ON f.id = b.id_wloxxmh_out
						LEFT JOIN iwhxxmh e ON e.id = f.id_iwhxxmh
						LEFT JOIN imtxxmh g ON g.kode = 219
						LEFT JOIN gbrxxmh h ON h.id = e.id_gbrxxmh
						LEFT JOIN iivxxrd iv ON iv.wlpxxmh_kode = b.wlpxxmh_kode_kitting AND iv.id_wloxxmh = b.id_wloxxmh_out
						WHERE b.id = :id
			');
			
			//insert minus Kitting Set
			$qi_iivxxrd_head = $db
				->raw()
				->bind(':id', $id)
				->exec('INSERT INTO iivxxrd (
							id_gcpxxmh,
							id_gbrxxmh,
							id_transaksi_h,
							id_transaksi_d,
							id_wloctmh,
							kode,
							wlpxxmh_kode,
							id_iwhxxmh,
							id_wloxxmh,
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
							jumlah_default,
							expired_date,
							batch_number
						)
						SELECT DISTINCT
							h.id_gcpxxmh,
							e.id_gbrxxmh,
							b.id AS id_transaksi_h,
							b.id AS id_transaksi_d,
							f.id_wloctmh,
							b.kode,
							b.wlpxxmh_kode_kitting,
							f.id_iwhxxmh,
							b.id_wloxxmh_out,
							b.id_grlxxmh_customer id_relasi_m,
							b.id_iimxxmh,
							b.id_iumxxmh_unit,
							b.id_iumxxmh_terkecil,
							b.id_iumxxmh_default,
							CONCAT("wkdxxth_", b.id) AS keterangan,
							e.kode AS iwhxxmh_kode,
							e.nama AS iwhxxmh_nama,
							f.kode AS wloxxmh_kode,
							f.nama AS wloxxmh_nama,
							c.kode AS relasi_m_kode,
							c.nama AS relasi_m_nama,
							d.kode AS iimxxmh_kode,
							d.nama AS iimxxmh_nama,
							iumxxmh_unit.kode AS iumxxmh_unit_kode,
							iumxxmh_unit.nama AS iumxxmh_unit_nama,
							219,
							g.movement_type,
							curdate(),
							1,
							iumxxmh_terkecil.kode AS iumxxmh_terkecil_kode,
							iumxxmh_terkecil.nama AS iumxxmh_terkecil_nama,
							iumxxmh_default.kode AS iumxxmh_default_kode,
							iumxxmh_default.nama AS iumxxmh_default_nama,
							-b.jumlah_unit,
							b.jumlah_konversi,
							-b.jumlah_terkecil,
							-b.jumlah_default,
							iv.expired_date,
							iv.batch_number

						FROM wkdxxth b
						LEFT JOIN grlxxmh c ON c.id = b.id_grlxxmh_customer
						LEFT JOIN iimxxmh d ON d.id = b.id_iimxxmh
						LEFT JOIN iumxxmh iumxxmh_unit ON iumxxmh_unit.id = b.id_iumxxmh_unit
						LEFT JOIN iumxxmh iumxxmh_terkecil ON iumxxmh_terkecil.id = b.id_iumxxmh_terkecil
						LEFT JOIN iumxxmh iumxxmh_default ON iumxxmh_default.id = b.id_iumxxmh_default
						LEFT JOIN wloxxmh f ON f.id = b.id_wloxxmh_out
						LEFT JOIN iwhxxmh e ON e.id = f.id_iwhxxmh
						LEFT JOIN imtxxmh g ON g.kode = 219
						LEFT JOIN gbrxxmh h ON h.id = e.id_gbrxxmh
						LEFT JOIN iivxxrd iv ON iv.wlpxxmh_kode = b.wlpxxmh_kode_kitting AND iv.id_wloxxmh = b.id_wloxxmh_out
						WHERE b.id = :id
			');
			
			//insert plus ke detail yang pecahan
			$qi_iivxxrd_det = $db
				->raw()
				->bind(':id', $id)
				->exec('INSERT INTO iivxxrd (
							id_gcpxxmh,
							id_gbrxxmh,
							id_transaksi_h,
							id_transaksi_d,
							id_wloctmh,
							kode,
							wlpxxmh_kode,
							id_iwhxxmh,
							id_wloxxmh,
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
							jumlah_default,
							expired_date,
							batch_number
						)
						SELECT DISTINCT
							h.id_gcpxxmh,
							e.id_gbrxxmh,
							a.id_wkdxxth AS id_transaksi_h,
							a.id AS id_transaksi_d,
							f.id_wloctmh,
							b.kode,
							a.wlpxxmh_kode,
							f.id_iwhxxmh,
							b.id_wloxxmh_out,
							b.id_grlxxmh_customer id_relasi_m,
							a.id_iimxxmh,
							a.id_iumxxmh_unit,
							a.id_iumxxmh_terkecil,
							a.id_iumxxmh_default,
							CONCAT("wkdxxth_", a.id_wkdxxth) AS keterangan,
							e.kode AS iwhxxmh_kode,
							e.nama AS iwhxxmh_nama,
							f.kode AS wloxxmh_kode,
							f.nama AS wloxxmh_nama,
							c.kode AS relasi_m_kode,
							c.nama AS relasi_m_nama,
							d.kode AS iimxxmh_kode,
							d.nama AS iimxxmh_nama,
							iumxxmh_unit.kode AS iumxxmh_unit_kode,
							iumxxmh_unit.nama AS iumxxmh_unit_nama,
							219,
							g.movement_type,
							curdate(),
							1,
							iumxxmh_terkecil.kode AS iumxxmh_terkecil_kode,
							iumxxmh_terkecil.nama AS iumxxmh_terkecil_nama,
							iumxxmh_default.kode AS iumxxmh_default_kode,
							iumxxmh_default.nama AS iumxxmh_default_nama,
							a.jumlah_unit,
							a.jumlah_konversi,
							a.jumlah_terkecil,
							a.jumlah_default,
							
							a.expired_date,
							a.batch_number

						FROM wkdlptd a
						LEFT JOIN wkdxxth b ON b.id = a.id_wkdxxth
						LEFT JOIN grlxxmh c ON c.id = b.id_grlxxmh_customer
						LEFT JOIN iimxxmh d ON d.id = a.id_iimxxmh
						LEFT JOIN iumxxmh iumxxmh_unit ON iumxxmh_unit.id = a.id_iumxxmh_unit
						LEFT JOIN iumxxmh iumxxmh_terkecil ON iumxxmh_terkecil.id = a.id_iumxxmh_terkecil
						LEFT JOIN iumxxmh iumxxmh_default ON iumxxmh_default.id = a.id_iumxxmh_default
						LEFT JOIN wloxxmh f ON f.id = b.id_wloxxmh_out
						LEFT JOIN iwhxxmh e ON e.id = f.id_iwhxxmh
						LEFT JOIN imtxxmh g ON g.kode = 219
						LEFT JOIN gbrxxmh h ON h.id = e.id_gbrxxmh
						LEFT JOIN iimummd j ON j.id_iimxxmh = a.id_iimxxmh AND j.is_default = 1
						WHERE b.id = :id
			');

		} // end if($state == 1)

		if(!empty($qi_iivxxrd_det)){
			$status_code  = 200;
			$message = "Confirm Berhasil ";
			$type_message = "success";
			// parameter lain
		}else{
			$status_code  = 500;
			$message = "Confirm Gagal ";
			$type_message = 'error';
			// parameter lain
		}
	}catch(PDOException $e){
		$status_code  = 500;
		$message      = 'Message Gagal! ' . $e->getMessage();
		$type_message = 'error';
	}
	
	// build response
	$data = array(
		'status_code'    => $status_code,
		'message'        => $message,
		'type_message'   => $type_message
	);	

	// tampilkan results
    include( "../../../../usersc/helpers/fn_ajax_results.php" );

?>