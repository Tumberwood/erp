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

		$nama_tabel = "iivxxrd_audit";
		$qs_gdnxxsh = $db
			->raw()
			->exec('
				SELECT
					*
				FROM 
					gdnxxsh
				WHERE 
					nama_tabel = "iivxxrd_audit"'
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

		// BEGIN generate WHERE
		
		$tanggal = $field_tanggal;
		$where = " WHERE activity_log_ml.kode = 'CONFIRM' AND activity_log_ml.nama = '" . $nama_tabel . "' ";
		$where = $where . " AND YEAR(".$nama_field_tanggal.") = YEAR('" . $tanggal . "') AND MONTH(".$nama_field_tanggal.") = MONTH('" . $tanggal . "') ";

		// ganti movement type sesuai jenis transaksi
		//Putaway
		$start_at = $_POST['start_at'];
		$insertValue    = $_POST['insertValue']; //concat id_iimxxmh, batch, ED, LPN, location
		$statusAuditValue    = $_POST['statusAuditValue']; //concat id_iimxxmh, batch, ED, LPN, location
		// echo $statusAuditValue;
		// echo $insertValue;

		//Lokasi Tujuan diminuskan
		$qi_iivxxrd = $db
			->raw()
			->bind(':statusAuditValue', $statusAuditValue)
			->bind(':insertValue', $insertValue)
			->bind(':s_id_users', $s_id_users)
			->exec('INSERT INTO iivxxrd_audit (
						transaction_state,
						id_gcpxxmh,
						id_gbrxxmh,
						id_iwhxxmh,
						id_wloctmh,
						id_wloxxmh,
						id_iimxxmh,
						id_iumxxmh_unit,
						id_iumxxmh_terkecil,
						id_iumxxmh_default,
						keterangan,
						created_by,
						gcpxxmh_kode,
						gcpxxmh_nama,
						gbrxxmh_kode,
						gbrxxmh_nama,
						iwhxxmh_kode,
						iwhxxmh_nama,
						wloxxmh_kode,
						wloxxmh_nama,
						iimxxmh_kode,
						iimxxmh_nama,
						iumxxmh_unit_kode,
						iumxxmh_unit_nama,
						iumxxmh_terkecil_kode,
						iumxxmh_terkecil_nama,
						iumxxmh_default_kode,
						iumxxmh_default_nama,
						jumlah_unit,
						jumlah_konversi,
						jumlah_terkecil,
						jumlah_default,
						wlpxxmh_kode,
						expired_date,
						batch_number,
						status_audit
					)
					SELECT
						1,
						id_gcpxxmh,
						id_gbrxxmh,
						id_iwhxxmh,
						id_wloctmh,
						id_wloxxmh,
						id_iimxxmh,
						id_iumxxmh_unit,
						id_iumxxmh_terkecil,
						id_iumxxmh_default,
						a.keterangan,
						:s_id_users,
						gcpxxmh_kode,
						gcpxxmh_nama,
						gbrxxmh_kode,
						gbrxxmh_nama,
						iwhxxmh_kode,
						iwhxxmh_nama,
						wloxxmh_kode,
						wloxxmh_nama,
						iimxxmh_kode,
						iimxxmh_nama,
						iumxxmh_unit_kode,
						iumxxmh_unit_nama,
						iumxxmh_terkecil_kode,
						iumxxmh_terkecil_nama,
						iumxxmh_default_kode,
						iumxxmh_default_nama,
						SUM(a.jumlah_unit) jumlah_unit,
						jumlah_konversi,
						SUM(a.jumlah_terkecil) jumlah_terkecil,
						SUM(a.jumlah_default) jumlah_default,
						a.wlpxxmh_kode,
						expired_date,
						batch_number,
						:statusAuditValue
					FROM iivxxrd a
					LEFT JOIN wlpxxmh b ON b.kode = a.wlpxxmh_kode
					WHERE a.is_fisik = 1
					GROUP BY 
						id_gbrxxmh, 
						id_iwhxxmh,
						id_iimxxmh,
						id_wloxxmh,
						wlpxxmh_kode
					HAVING jumlah_terkecil > 0 
						AND CONCAT(a.id_iimxxmh,a.batch_number,a.expired_date,a.wlpxxmh_kode,a.id_wloxxmh) = :insertValue
			'
		);
		$id_audit = $qi_iivxxrd->insertId();


		if(!empty($qi_iivxxrd)){
			$db->commit();
			$status_code  = 200;
			$message      = 'Audit Inventory Berhasil Ditambahkan';
			$type_message = 'success';

			$finish_at = date("Y-m-d H:i:s");
			General::logChange( $db , 'iivxxrd_audit', $s_id_users, $s_username, 'CREATE', $id_audit, $insertValue, $start_at , $finish_at );
			General::logChange( $db , 'iivxxrd_audit', $s_id_users, $s_username, 'CONFIRM', $id_audit, $insertValue, $start_at , $finish_at );

			$id_transaksi = $id_audit;
			$qs_c_id_new = $db
				->raw()
				->exec('
					SELECT
						count(activity_log_ml.id) as c_id_new
					FROM '.$nama_tabel.'
					LEFT JOIN activity_log_ml ON
						activity_log_ml.id_transaksi = '.$nama_tabel.'.id 
						AND  activity_log_ml.kode = "CONFIRM" 
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
		}else{
			$db->rollback();
			$status_code  = 500;
			$message      = 'Audit Inventory Gagal Ditambahkan!';
			$type_message = 'error';
		}
	}catch(PDOException $e){
		$db->rollback();
		$status_code  = 500;
		$message      = 'Audit Inventory Gagal Ditambahkan! ' . $e->getMessage();
		$type_message = 'error';
	}catch (Exception $e) {
		$db->rollback();
		$status_code = 500;
		$message = 'Audit Inventory Gagal Ditambahkan!, ' . $e->getMessage();
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