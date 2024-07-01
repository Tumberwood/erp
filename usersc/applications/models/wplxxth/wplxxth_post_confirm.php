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
			
			$start_at = date("Y-m-d H:i:s");
			
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

			$nama_tabel = "wpcxxth";
			$qs_gdnxxsh = $db
				->raw()
				->exec('
					SELECT
						*
					FROM 
						gdnxxsh
					WHERE 
						nama_tabel = "wpcxxth"'
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

			//select detail LPN, lihat job type nya apa aja
			$qs_lpn_d = $db
				->raw()
				->bind(':id', $id)
				->exec('SELECT
							a.id_wjtxxmh,
							id_grlxxmh_customer,
							id_wloxxmh_out
						FROM wpllptd a
						LEFT JOIN wplxxth b on b.id = a.id_wplxxth
						WHERE a.id_wplxxth = :id
						GROUP BY a.id_wjtxxmh
				'
				);

			$rs_lpn_d = $qs_lpn_d->fetchAll();

			foreach ($rs_lpn_d as $key => $lpn) {
				$id_wjtxxmh = $lpn['id_wjtxxmh'];
				$id_wloxxmh_out = $lpn['id_wloxxmh_out'];
				$id_grlxxmh_customer = $lpn['id_grlxxmh_customer'];

				//insert picking header
				$qi_wpcxxth = $db
					->query('insert', 'wpcxxth')
					->set('id_grlxxmh_customer',$id_grlxxmh_customer)
					->set('id_wplxxth',$id)
					->set('id_wjtxxmh',$id_wjtxxmh)
					->set('id_wloxxmh_out',$id_wloxxmh_out)
					->exec();
				$id_picking = $qi_wpcxxth->insertId();
				
				$finish_at = date("Y-m-d H:i:s");
				General::logChange( $db , 'wpcxxth', $s_id_users, $s_username, 'CREATE', $id_picking, 'Insert Picking dari Picking List id'.$id, $start_at , $finish_at );

				//id picking
				$id_transaksi = $id_picking;
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

				//detail LPN Picking List
				$qu_wpllptd = $db
					->query('update', 'wpllptd')
					->set('kode',$formatted_kode)
					->set('id_wpcxxth',$id_transaksi)
					->where('id_wjtxxmh',$id_wjtxxmh)
					->where('id_wplxxth',$id)
				->exec();
			}
		} // end if($state == 1)

		if(!empty($qi_wpcxxth)){
			$status_code  = 200;
			$message = "Picking Berhasil Ditambahkan";
			$type_message = "success";
			// parameter lain
		}else{
			$status_code  = 500;
			$message = "Picking Gagal Ditambahkan";
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