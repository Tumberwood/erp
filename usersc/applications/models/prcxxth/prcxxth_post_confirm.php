<?php
    /**
     * Digunakan untuk menghitung hpp
     */
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
	
	$id = $_POST['id_transaksi'];
	$state = $_POST['state'];

	// (ROW_NUMBER() OVER (ORDER BY a.id) * (ROW_NUMBER() OVER (ORDER BY a.id) - 1)) / 2 AS result

	try{
		
		if($state == 1){
			$qs_prcxxth = $db
                ->query('select', 'prcxxth' )
                ->get([
                    'prcxxth.id_iitxxmh as id_iitxxmh',
                    'prcxxth.subtotal as prcxxth_subtotal',
                    'prcxxth.dpp_final as prcxxth_dpp_final'
                ] )
                ->where('prcxxth.id', $id )
                ->exec();
            $rs_prcxxth = $qs_prcxxth->fetch();

			if($rs_prcxxth['id_iitxxmh'] == 1){
				// jika persediaan, hitung hpp
				$qi_prcittd = $db
					->raw()
					->bind(':id_prcxxth', $id)
					->exec('UPDATE prcittd a
						INNER JOIN prcittd b ON b.id = a.id
						SET a.hpp = b.dpp / '.$rs_prcxxth['prcxxth_subtotal'].'*'.$rs_prcxxth['prcxxth_dpp_final'] . ' / a.jumlah_terkecil
						WHERE a.id_prcxxth = :id_prcxxth
					');

				$qi_iivxxrd = $db
					->raw()
					->bind(':id_prcxxth', $id)
					->bind(':imtxxmh_kode', 101)
					->exec('UPDATE iivxxrd a
						INNER JOIN prcittd b ON b.id = a.id_transaksi_d
						SET a.hpp = b.hpp
						WHERE 1 
							AND a.id_transaksi_h = :id_prcxxth
							AND a.imtxxmh_kode = :imtxxmh_kode
					');

				if(!empty($qi_prcittd) && !empty($qi_iivxxrd) ){
					$status_code  = 200;
					$message = "Perhitungan HPP Berhasil Dilakukan";
					$type_message = "success";
				}else{
					$status_code  = 500;
					$message = "Perhitungan HPP Gagal Dilakukan";
					$type_message = 'error';
				}
			}else{
				// tidak perlu perhitungan HPP, message tidak ditampilkan
				$status_code  = 200;
				$message = "";
				$type_message = "success";
			}
			
		} // end if($state == 1)

		
	}catch(PDOException $e){
		$status_code  = 500;
		$message      = 'Perhitungan HPP Gagal Dilakukan! ' . $e->getMessage();
		$type_message = 'error';
	}catch (Exception $e) {
        $db->rollback();
        $status_code = 500;
        $message      = 'Perhitungan HPP Gagal Dilakukan! ' . $e->getMessage();
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