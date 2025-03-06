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

	$json['hakakses'] = $hakakses;
	$s_id_users = $hakakses['s_id_users'];
	$s_username = $hakakses['s_username'];

	try{
		$db->transaction();

		$id_picking    = $_POST['id_picking'];
		$start_at    = $_POST['start_at'];
		$confirm_at    = $_POST['confirm_at'];
		$uniqueToken    = $_POST['uniqueToken'];

		$id_grlxxmh_expedition    = $_POST['ekspedisi'];
		$mobil_nomor    = $_POST['mobil_nomor'];
		$supir_nama    = $_POST['supir_nama'];
		$no_container    = $_POST['no_container'];
		$no_seal    = $_POST['no_seal'];
		$imtxxmh_kode = 215;

		//Generate Kode
		// $start_at = date("Y-m-d H:i:s");
			
		function integerToRoman($integer){
			// Convert the integer into an integer (just to make sure)
			$integer = intval($integer);
			$result = '';
		
			// Create a lookup array that contains all of the Roman numerals.
			$lookup = array(
				'M' => 1000,
				'CM' => 900,
				'D' => 500,
				'CD' => 400,
				'C' => 100,
				'XC' => 90,
				'L' => 50,
				'XL' => 40,
				'X' => 10,
				'IX' => 9,
				'V' => 5,
				'IV' => 4,
				'I' => 1);
		
			foreach($lookup as $roman => $value){
				// Determine the number of matches
				$matches = intval($integer/$value);
		
				// Add the same number of characters to the string
				$result .= str_repeat($roman,$matches);
		
				// Set the integer to be the remainder of the integer and the value
				$integer = $integer % $value;
			}
		
			// The Roman numeral should be built, return it
			return $result;
		}

		$nama_tabel = "wdpxxth";
		$qs_gdnxxsh = $db
			->raw()
			->exec('
				SELECT
					*
				FROM 
					gdnxxsh
				WHERE 
					nama_tabel = "'.$nama_tabel.'" '
			);
		$rs_gdnxxsh = $qs_gdnxxsh->fetch();
		$prefix                 = $rs_gdnxxsh['prefix'];
		$total_digit            = $rs_gdnxxsh['total_digit'];
		$separator              = $rs_gdnxxsh['separator'];

		$nama_field_tanggal = 'activity_log_ml.created_on';
		$field_tanggal 		= date('Y-m-d');
		$field_tanggal_dt	= strtotime($field_tanggal);
		$tahun = substr($field_tanggal,2,2);
		$bulan = substr($field_tanggal,5,2);

		$tanggal = $field_tanggal;
		$where = " WHERE activity_log_ml.kode = 'CREATE' AND activity_log_ml.nama = '" . $nama_tabel . "' ";
		$where = $where . " AND YEAR(".$nama_field_tanggal.") = YEAR('" . $tanggal . "') AND MONTH(".$nama_field_tanggal.") = MONTH('" . $tanggal . "') ";

		//select data dispatch per detail yang telah di submit
		$qs_pick_h = $db
			->raw()
			->bind(':id_picking', $id_picking)
			->exec('SELECT
						a.id_wloxxmh_tujuan as id_wloxxmh_out,
						b.id_wjtxxmh,
						b.id_grlxxmh_customer
					FROM wdplptd a
					LEFT JOIN wpcxxth b ON b.id = a.id_wpcxxth
					WHERE a.id_wpcxxth = :id_picking
			'
		);
		$rs_pick_h = $qs_pick_h->fetch();

		$id_wloxxmh_out = $rs_pick_h['id_wloxxmh_out'];
		$id_wjtxxmh = $rs_pick_h['id_wjtxxmh'];
		$id_grlxxmh_customer = $rs_pick_h['id_grlxxmh_customer'];

		//delete iiv booking per item tadi
		// $qu_iivxxrd = $db
		// 	->query('delete', 'iivxxrd')
		// 	->where('keterangan',"booking_dispatch_id_wpcxxth".$id_picking)
		// 	->exec();

		
		//insert booking balik (+) terhadapt booking PC per detail
		$qi_iivxxrd = $db
			->raw()
			->bind(':id_picking', $id_picking)
			->bind(':uniqueToken', $uniqueToken)
			->exec('
				INSERT INTO iivxxrd (
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
					id_gcpxxmh,
					id_gbrxxmh,
					id_transaksi_h,
					id_transaksi_d,
					id_wloctmh,
					a.kode,
					wlpxxmh_kode,
					id_iwhxxmh,
					id_wloxxmh,
					id_relasi_m,
					id_iimxxmh,
					id_iumxxmh_unit,
					id_iumxxmh_terkecil,
					id_iumxxmh_default,
					a.keterangan,
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
					SUM(a.jumlah_unit * -1) s_unit,
					jumlah_konversi,
					SUM(a.jumlah_terkecil * -1) s_terkecil,
					SUM(a.jumlah_default * -1) s_default,
					expired_date,
					batch_number
				FROM iivxxrd a
				WHERE a.keterangan = CONCAT("booking_dispatch_id_wpcxxth", :id_picking) AND a.kode = :uniqueToken
				GROUP BY a.wlpxxmh_kode
		');

		//insert wdp baru setiap confirm
		$qi_wdpxxth_baru = $db
			->query('insert', 'wdpxxth')
			->set('transaction_state',1)
			->set('id_grlxxmh_expedition',$id_grlxxmh_expedition)
			->set('mobil_nomor',$mobil_nomor)
			->set('supir_nama',$supir_nama)
			->set('no_container',$no_container)
			->set('no_seal',$no_seal)
			->set('id_wpcxxth',$id_picking)
			->set('id_wloxxmh_out',$id_wloxxmh_out)
			->set('id_wjtxxmh',$id_wjtxxmh)
			->set('id_grlxxmh_customer',$id_grlxxmh_customer)
			->exec();
		$id_wdpxxth_baru = $qi_wdpxxth_baru->insertId();

		// GENERATE KODE DISPATCH
		$finish_at = date("Y-m-d H:i:s");
		General::logChange( $db , $nama_tabel, $s_id_users, $s_username, 'CREATE', $id_wdpxxth_baru, 'Dispatch Header dari Picking id ='.$id_picking, $start_at , $finish_at );

		//id picking
		$id_transaksi = $id_wdpxxth_baru;
		$qs_c_id_new = $db
			->raw()
			->exec('
				SELECT
					count(activity_log_ml.id) as c_id_new
				FROM '.$nama_tabel.'
				LEFT JOIN activity_log_ml ON
					activity_log_ml.id_transaksi = '.$nama_tabel.'.id 
					AND  activity_log_ml.kode = "CREATE" 
					AND activity_log_ml.nama = "'.$nama_tabel.'" 
				' 
				. $where 

			);
		$rs_c_id_new 	= $qs_c_id_new->fetch();
		$new_number  	= $rs_c_id_new['c_id_new'];
		$tr_kode 		= str_pad($new_number,$total_digit,"0",STR_PAD_LEFT);

		$formatted_kode = $prefix . $separator . $tahun . $bulan . $separator . $tr_kode;
		
		$result = $db
			->query('update', $nama_tabel)
			->set('kode',$formatted_kode)
			->where('id',$id_transaksi)
		->exec();

		
		//update kode iiv(isinya unique kode) menjadi kode wdpxxth
		$qu_booking = $db
			->query('update', 'iivxxrd')
			->set('kode',$formatted_kode)
			->where('kode',$uniqueToken)
			->exec();
			
		//select picking d
		$qs_pick_d = $db
			->raw()
			->bind(':id_picking', $id_picking)
			->exec('SELECT
						ROW_NUMBER() OVER(ORDER BY a.id) AS s_id,
						LPAD(ROW_NUMBER() OVER(ORDER BY a.id), 4, 0) AS kode_d,
						a.id
					FROM wdplptd a
					WHERE a.id_wpcxxth = :id_picking AND a.id_wdpxxth = 0;
		
			'
		);
		$rs_pick_d = $qs_pick_d->fetchAll();
		
		//update kode picking d
		foreach ($rs_pick_d as $key => $pick_d) {
			$kode_d = $formatted_kode . "/" . $pick_d['kode_d'];
			$id_d = $pick_d['id'];

			$qu_wdplptd = $db
				->query('update', 'wdplptd')
				->set('id_wdpxxth',$id_wdpxxth_baru)
				->set('kode',$kode_d)
				->where('id',$id_d)
				->exec();
		}
			

		//insert booking minus
		$qi_iivxxrd = $db
			->raw()
			->bind(':id_wdpxxth_baru', $id_wdpxxth_baru)
			->bind(':imtxxmh_kode', $imtxxmh_kode)
			->exec('
				INSERT INTO iivxxrd (
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
					a.id_wdpxxth AS id_transaksi_h,
					a.id AS id_transaksi_d,
					f.id_wloctmh,
					a.kode,
					a.wlpxxmh_kode,
					a.id_iwhxxmh,
					a.id_wloxxmh_asal,
					b.id_grlxxmh_customer id_relasi_m,
					a.id_iimxxmh,
					a.id_iumxxmh_unit,
					a.id_iumxxmh_terkecil,
					a.id_iumxxmh_default,
					CONCAT("wdpxxth_", a.id_wdpxxth) AS keterangan,
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
					:imtxxmh_kode,
					g.movement_type,
					curdate(),
					1,
					iumxxmh_terkecil.kode AS iumxxmh_terkecil_kode,
					iumxxmh_terkecil.nama AS iumxxmh_terkecil_nama,
					iumxxmh_default.kode AS iumxxmh_default_kode,
					iumxxmh_default.nama AS iumxxmh_default_nama,
					-a.jumlah_unit,
					a.jumlah_konversi,
					-a.jumlah_terkecil,
					-a.jumlah_default,
					a.expired_date,
					a.batch_number

				FROM wdplptd a
				LEFT JOIN wdpxxth b ON b.id = a.id_wdpxxth
				LEFT JOIN grlxxmh c ON c.id = b.id_grlxxmh_customer
				LEFT JOIN iimxxmh d ON d.id = a.id_iimxxmh
				LEFT JOIN iwhxxmh e ON e.id = a.id_iwhxxmh
				LEFT JOIN iumxxmh iumxxmh_unit ON iumxxmh_unit.id = a.id_iumxxmh_unit
				LEFT JOIN iumxxmh iumxxmh_terkecil ON iumxxmh_terkecil.id = a.id_iumxxmh_terkecil
				LEFT JOIN iumxxmh iumxxmh_default ON iumxxmh_default.id = a.id_iumxxmh_default
				LEFT JOIN wloxxmh f ON f.id = a.id_wloxxmh_asal
				LEFT JOIN imtxxmh g ON g.kode = :imtxxmh_kode
				LEFT JOIN gbrxxmh h ON h.id = e.id_gbrxxmh
				WHERE b.id = :id_wdpxxth_baru
		');

		//insert booking ke dispatch
		$qi_iivxxrd = $db
			->raw()
			->bind(':id_wdpxxth_baru', $id_wdpxxth_baru)
			->bind(':imtxxmh_kode', $imtxxmh_kode)
			->exec('
				INSERT INTO iivxxrd (
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
					a.id_wdpxxth AS id_transaksi_h,
					a.id AS id_transaksi_d,
					f.id_wloctmh,
					a.kode,
					a.wlpxxmh_kode,
					a.id_iwhxxmh,
					a.id_wloxxmh_tujuan,
					b.id_grlxxmh_customer id_relasi_m,
					a.id_iimxxmh,
					a.id_iumxxmh_unit,
					a.id_iumxxmh_terkecil,
					a.id_iumxxmh_default,
					CONCAT("wdpxxth_", a.id_wdpxxth) AS keterangan,
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
					:imtxxmh_kode,
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

				FROM wdplptd a
				LEFT JOIN wdpxxth b ON b.id = a.id_wdpxxth
				LEFT JOIN grlxxmh c ON c.id = b.id_grlxxmh_customer
				LEFT JOIN iimxxmh d ON d.id = a.id_iimxxmh
				LEFT JOIN iwhxxmh e ON e.id = a.id_iwhxxmh
				LEFT JOIN iumxxmh iumxxmh_unit ON iumxxmh_unit.id = a.id_iumxxmh_unit
				LEFT JOIN iumxxmh iumxxmh_terkecil ON iumxxmh_terkecil.id = a.id_iumxxmh_terkecil
				LEFT JOIN iumxxmh iumxxmh_default ON iumxxmh_default.id = a.id_iumxxmh_default
				LEFT JOIN wloxxmh f ON f.id = a.id_wloxxmh_tujuan
				LEFT JOIN imtxxmh g ON g.kode = :imtxxmh_kode
				LEFT JOIN gbrxxmh h ON h.id = e.id_gbrxxmh
				WHERE b.id = :id_wdpxxth_baru
		');

		if(!empty($qi_iivxxrd)){
			//insert semua detail picking ke activity_log confirm
			// $qs_picking = $db
			// 	->query('select', 'wdplptd' )
			// 	->get([
			// 		'id',
			// 		'kode'
			// 	] )
			// 	->where('id_wdpxxth', $id_picking )
			// 	->exec();
			// $rs_picking = $qs_picking->fetchAll();

			// foreach ($rs_picking as $key => $pick) {
			// 	$id = $pick['id'];
			// 	$kode_d = $pick['kode'];

			// 	General::logChange( $db , 'wdplptd', $s_id_users, $s_username, 'CONFIRM', $id, $kode_d, $start_at , $confirm_at );
			// }
			//cek all full
			$qs_is_full = $db
				->raw()
				->bind(':id_picking', $id_picking)
				->exec('SELECT
							a.id_wpcxxth,
							SUM(a.jumlah_terkecil_os) s_sisa
						FROM wpclptd a
						WHERE a.id_wpcxxth = :id_picking
				'
			);
			$rs_is_full = $qs_is_full->fetch();
			$s_sisa = $rs_is_full['s_sisa'];
			$id_wpcxxth = $rs_is_full['id_wpcxxth'];

			if ($s_sisa == 0) {
				$qu_wpcxxth = $db
					->query('update', 'wpcxxth')
					->set('transaction_state',8)
					->where('id',$id_wpcxxth)
					->exec();
			}

			General::logChange( $db , 'wdpxxth', $s_id_users, $s_username, 'CONFIRM', $id_wdpxxth_baru, 'Confirm Dispatch Header id='.$id_wdpxxth_baru, $start_at , $confirm_at );
			
			$db->commit();
			$status_code  = 200;
			$message      = 'Confirm Dispatch Berhasil';
			$type_message = 'success';
			
		}else{
			$db->rollback();
			$status_code  = 500;
			$message      = 'Confirm Dispatch Gagal!';
			$type_message = 'error';
		}
	}catch(PDOException $e){
		$db->rollback();
		$status_code  = 500;
		$message      = 'Confirm Dispatch Gagal! ' . $e->getMessage();
		$type_message = 'error';
	}catch (Exception $e) {
		$db->rollback();
		$status_code = 500;
		$message = 'Confirm Dispatch Gagal!, ' . $e->getMessage();
		$type_message = 'error';
	}
	// build response
	$data = array(
		'status_code'    => $status_code,
		'message'        => $message,
		'type_message'   => $type_message,
	);

	// tampilkan results
    include( "../../../../usersc/helpers/fn_ajax_results.php" );
?>