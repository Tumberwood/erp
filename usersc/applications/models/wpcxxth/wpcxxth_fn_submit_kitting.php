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

		$id_lpn    = $_POST['id_lpn'];
		$id_picking    = $_POST['id_picking'];
		$id_iumxxmh_input    = $_POST['id_iumxxmh_input'];
		$jumlah_unit_input    = $_POST['jumlah_unit_input'];
		$start_at    = $_POST['start_at'];
		$finish_at    = $_POST['finish_at'];
		$uniqueToken    = $_POST['uniqueToken'];
		$nama_table = "wpclptd";
		$nama_table_before = "wktlptd";
		$imtxxmh_kode = 213;

		//ambil data PC LPN yang belum di submit, sesuai dengan detail LPN yg dipilih
		$qs_pclp = $db
			->query('select', 'wpclptd' )
			->get([
				'id'
				] )
			->where('keterangan', $uniqueToken )
			->where('id_wktlptd', $id_lpn )
			->exec();
		$rs_pclp = $qs_pclp->fetch();
		
		if(!empty($rs_pclp)) {
			$id = $rs_pclp['id'];

			$qu_wpclptd = $db
				->query('update', 'wpclptd')
				->set('jumlah_unit',$jumlah_unit_input)
				->set('id_iumxxmh_unit',$id_iumxxmh_input)
				->where('id',$id)
				->exec();
			
			include('wpcxxth_fn_konversi_terkecil.php');

			$qs_pc_d = $db
				->query('select', 'wpclptd' )
				->get([
					'id_iumxxmh_unit',
					'id_iumxxmh_terkecil',
					'id_iumxxmh_default',
					'jumlah_unit',
					'jumlah_konversi',
					'jumlah_terkecil',
					'jumlah_default',
					] )
				->where('id', $id )
				->exec();
			$rs_pc_d = $qs_pc_d->fetch();

			$id_iumxxmh_unit = $rs_pc_d['id_iumxxmh_unit'];
			$id_iumxxmh_terkecil = $rs_pc_d['id_iumxxmh_terkecil'];
			$id_iumxxmh_default = $rs_pc_d['id_iumxxmh_default'];
			$jumlah_unit = $rs_pc_d['jumlah_unit'];
			$jumlah_konversi = $rs_pc_d['jumlah_konversi'];
			$jumlah_terkecil = $rs_pc_d['jumlah_terkecil'];
			$jumlah_default = $rs_pc_d['jumlah_default'];

			
			$qu_wpxxth = $db
				->raw()
				->bind(':id_lpn', $id_lpn)
				->exec('UPDATE wktlptd a
						SET 
							a.status_picking = 
								case 
									when a.jumlah_terkecil_os = a.jumlah_terkecil then 1
									when a.jumlah_terkecil_os = 0 then 3
									when a.jumlah_terkecil_os > 0 then 2
									ELSE
										1
								END
						WHERE a.id = :id_lpn
						;
				
				'
			);
			
			$qu_iivxxrd = $db
				->query('update', 'iivxxrd')
                ->set('id_iumxxmh_unit',$id_iumxxmh_unit)
                ->set('id_iumxxmh_terkecil',$id_iumxxmh_terkecil)
                ->set('id_iumxxmh_default',$id_iumxxmh_default)
				->set('jumlah_unit',$jumlah_unit)
                ->set('jumlah_konversi',$jumlah_konversi)
                ->set('jumlah_terkecil',$jumlah_terkecil) 
                ->set('jumlah_default',$jumlah_default) 
				->where('id_transaksi_d',$id_lpn)
				->where('kode',$uniqueToken)
				->exec();
				
			$qu_iivxxrd = $db
				->query('update', 'iivxxrd')
                ->set('id_iumxxmh_unit',$id_iumxxmh_unit)
                ->set('id_iumxxmh_terkecil',$id_iumxxmh_terkecil)
                ->set('id_iumxxmh_default',$id_iumxxmh_default)
				->set('jumlah_unit',-$jumlah_unit)
                ->set('jumlah_konversi',$jumlah_konversi)
                ->set('jumlah_terkecil',-$jumlah_terkecil) 
                ->set('jumlah_default',-$jumlah_default) 
				->where('id_transaksi_d',$id)
				->where('imtxxmh_kode',$imtxxmh_kode)
				->exec();

			if (!empty($qu_iivxxrd)) {
				$db->commit();
				$status_code  = 200;
				$message      = 'Picking Berhasil Dilakukan';
				$type_message = 'success';
			} else{
				$db->rollback();
				$status_code  = 500;
				$message      = 'Picking Gagal Dilakukan!';
				$type_message = 'error';
			}


		} else {
			$qi_lpn_picking = $db
				->raw()
				->bind(':id_picking', $id_picking)
				->bind(':id_lpn', $id_lpn)
				->bind(':id_iumxxmh_input', $id_iumxxmh_input)
				->bind(':jumlah_unit_input', $jumlah_unit_input)
				->bind(':uniqueToken', $uniqueToken)
				->exec('INSERT INTO wpclptd (
							id_wpcxxth,
							id_wktlptd,
							id_iimxxmh,
							id_wloxxmh_asal,
							id_wloxxmh_tujuan,
							id_iwhxxmh,
							id_iumxxmh_unit,
							jumlah_unit,
							wlpxxmh_kode,
							wloxxmh_nama,
							batch_number,
							expired_date,
							keterangan
						)
						SELECT
							c.id,
							a.id,
							a.id_iimxxmh,
							a.id_wloxxmh,
							c.id_wloxxmh_out,
							a.id_iwhxxmh,
							:id_iumxxmh_input,
							:jumlah_unit_input,
							a.wlpxxmh_kode,
							a.wloxxmh_nama,
							a.batch_number,
							a.expired_date,
							:uniqueToken
						FROM wktlptd a
						LEFT JOIN wktittd b ON b.id = a.id_wktittd
						LEFT JOIN wpcxxth c ON c.id = :id_picking
						WHERE a.id = :id_lpn
				'
			);

			if(!empty($qi_lpn_picking)){
				
				$id = $qi_lpn_picking->insertId();
				include('wpcxxth_fn_konversi_terkecil.php');

				$qs_kode = $db
					->raw()
					->bind(':id_picking', $id_picking)
					->exec('SELECT
								b.id_wktxxth
							FROM wpclptd a
							LEFT JOIN wpcxxth b ON b.id = a.id_wpcxxth
							WHERE a.id_wpcxxth = :id_picking
					'
				);
				$rs_kode = $qs_kode->fetch();
				$id_wktxxth = $rs_kode['id_wktxxth'];

				$qu_wpxxth = $db
					->raw()
					->bind(':id_lpn', $id_lpn)
					->exec('UPDATE wktlptd a
							SET 
								a.status_picking = 
									case 
										when a.jumlah_terkecil_os = a.jumlah_terkecil then 1
										when a.jumlah_terkecil_os = 0 then 3
										when a.jumlah_terkecil_os > 0 then 2
										ELSE
											1
									END
							WHERE a.id = :id_lpn
							;
					
					'
				);

				$qs_booking_pl = $db
					->raw()
					->bind(':id_lpn', $id_lpn)
					->bind(':id_wktxxth', $id_wktxxth)
					->exec('SELECT
								SUM(a.jumlah_terkecil) s_terkecil,
								SUM(a.jumlah_unit) s_unit
							FROM iivxxrd a
							WHERE a.keterangan = CONCAT("wktxxth_id_", :id_wktxxth) AND id_transaksi_d = :id_lpn
					'
				);
				$rs_booking_pl = $qs_booking_pl->fetch();
				
				if (!empty($rs_booking_pl)) {
					$s_terkecil = $rs_booking_pl['s_terkecil'];

					//jika sum booking PL masih minus, maka insert booking balik nya (+)
					if ($s_terkecil < 0) {
						//insert booking iiv balik, untuk menghilangkan booking dari Picking List (ini sifatnya +)
						$qi_iivxxrd = $db
							->raw()
							->bind(':id', $id)
							->bind(':id_wktxxth', $id_wktxxth)
							->bind(':id_lpn', $id_lpn)
							->bind(':uniqueToken', $uniqueToken)
							->exec('
								INSERT INTO iivxxrd (
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
									a.id_wpcxxth AS id_transaksi_h,
									:id_lpn AS id_transaksi_d,
									f.id_wloctmh,
									:uniqueToken,
									a.wlpxxmh_kode,
									a.id_iwhxxmh,
									a.id_wloxxmh_asal,
									b.id_grlxxmh_customer id_relasi_m,
									a.id_iimxxmh,
									a.id_iumxxmh_unit,
									a.id_iumxxmh_terkecil,
									a.id_iumxxmh_default,
									CONCAT("wktxxth_id_", :id_wktxxth) AS keterangan,
									e.kode AS iwhxxmh_kode,
									e.nama AS iwhxxmh_nama,
									f.kode AS wloxxmh_kode,
									a.wloxxmh_nama,
									c.kode AS relasi_m_kode,
									c.nama AS relasi_m_nama,
									d.kode AS iimxxmh_kode,
									d.nama AS iimxxmh_nama,
									iumxxmh_unit.kode AS iumxxmh_unit_kode,
									iumxxmh_unit.nama AS iumxxmh_unit_nama,
									211,
									g.movement_type,
									curdate(),
									0,
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
			
								FROM wpclptd a
								LEFT JOIN wpcxxth b ON b.id = a.id_wpcxxth
								LEFT JOIN grlxxmh c ON c.id = b.id_grlxxmh_customer
								LEFT JOIN iimxxmh d ON d.id = a.id_iimxxmh
								LEFT JOIN iwhxxmh e ON e.id = a.id_iwhxxmh
								LEFT JOIN iumxxmh iumxxmh_unit ON iumxxmh_unit.id = a.id_iumxxmh_unit
								LEFT JOIN iumxxmh iumxxmh_terkecil ON iumxxmh_terkecil.id = a.id_iumxxmh_terkecil
								LEFT JOIN iumxxmh iumxxmh_default ON iumxxmh_default.id = a.id_iumxxmh_default
								LEFT JOIN wloxxmh f ON f.id = a.id_wloxxmh_asal
								LEFT JOIN imtxxmh g ON g.kode = 211
								WHERE a.id = :id
						');
					}
				}

				//hapus booking picking list
				// $qd_booking_lpn_pickingList = $db
				// 	->query('delete', 'iivxxrd')
				// 	->where('keterangan','wktxxth_id_'.$id_wktxxth)
				// 	->where('id_transaksi_d',$id_lpn)
				// 	->exec();

				// insert booking iiv is_fisik 0 untuk PC
				$qi_iivxxrd = $db
					->raw()
					->bind(':id', $id)
					->bind(':imtxxmh_kode', $imtxxmh_kode)
					->bind(':uniqueToken', $uniqueToken)
					->exec('
						INSERT INTO iivxxrd (
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
							a.id_wpcxxth AS id_transaksi_h,
							a.id AS id_transaksi_d,
							f.id_wloctmh,
							:uniqueToken,
							a.wlpxxmh_kode,
							a.id_iwhxxmh,
							a.id_wloxxmh_asal,
							b.id_grlxxmh_customer id_relasi_m,
							a.id_iimxxmh,
							a.id_iumxxmh_unit,
							a.id_iumxxmh_terkecil,
							a.id_iumxxmh_default,
							CONCAT("wpcxxth_", a.id_wpcxxth) AS keterangan,
							e.kode AS iwhxxmh_kode,
							e.nama AS iwhxxmh_nama,
							f.kode AS wloxxmh_kode,
							a.wloxxmh_nama,
							c.kode AS relasi_m_kode,
							c.nama AS relasi_m_nama,
							d.kode AS iimxxmh_kode,
							d.nama AS iimxxmh_nama,
							iumxxmh_unit.kode AS iumxxmh_unit_kode,
							iumxxmh_unit.nama AS iumxxmh_unit_nama,
							:imtxxmh_kode,
							g.movement_type,
							curdate(),
							0,
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

						FROM wpclptd a
						LEFT JOIN wpcxxth b ON b.id = a.id_wpcxxth
						LEFT JOIN grlxxmh c ON c.id = b.id_grlxxmh_customer
						LEFT JOIN iimxxmh d ON d.id = a.id_iimxxmh
						LEFT JOIN iwhxxmh e ON e.id = a.id_iwhxxmh
						LEFT JOIN iumxxmh iumxxmh_unit ON iumxxmh_unit.id = a.id_iumxxmh_unit
						LEFT JOIN iumxxmh iumxxmh_terkecil ON iumxxmh_terkecil.id = a.id_iumxxmh_terkecil
						LEFT JOIN iumxxmh iumxxmh_default ON iumxxmh_default.id = a.id_iumxxmh_default
						LEFT JOIN wloxxmh f ON f.id = a.id_wloxxmh_asal
						LEFT JOIN imtxxmh g ON g.kode = :imtxxmh_kode
						WHERE a.id = :id
				');

				General::logChange( $db , 'wpclptd', $s_id_users, $s_username, 'CREATE', $id, "", $start_at , $finish_at );
				General::logChange( $db , 'wpclptd', $s_id_users, $s_username, 'CONFIRM', $id, "", $start_at , $finish_at );

				
				$db->commit();
				$status_code  = 200;
				$message      = 'Picking Berhasil Dilakukan';
				$type_message = 'success';
			} else{
				$db->rollback();
				$status_code  = 500;
				$message      = 'Picking Gagal Dilakukan!';
				$type_message = 'error';
			}
			
		}
	}catch(PDOException $e){
		$db->rollback();
		$status_code  = 500;
		$message      = 'Picking Gagal Dilakukan! ' . $e->getMessage();
		$type_message = 'error';
	}catch (Exception $e) {
		$db->rollback();
		$status_code = 500;
		$message = 'Picking Gagal Dilakukan!, ' . $e->getMessage();
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