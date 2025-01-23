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

		$id_pmi_cylinder_problem_t_action    = $_POST['id_pmi_cylinder_problem_t_action'];
		
		$qu_verified = $db
			->raw()
			->bind(':id_pmi_cylinder_problem_t_action', $id_pmi_cylinder_problem_t_action)
			->bind(':s_username', $s_username)
			->exec('UPDATE pmi_cylinder_problem_t_action 
					SET
						verifikasi_by = :s_username,
						approval_state = 9,
						transaction_state = 1
					WHERE id = :id_pmi_cylinder_problem_t_action
		');
		
		if(!empty($qu_verified)){
			$db->commit();
			$status_code  = 200;
			$message      = 'Verified Cylinder Problem Action Berhasil';
			$type_message = 'success';
			
		}else{
			$db->rollback();
			$status_code  = 500;
			$message      = 'Verified Cylinder Problem Action Gagal!';
			$type_message = 'error';
		}
	}catch(PDOException $e){
		$db->rollback();
		$status_code  = 500;
		$message      = 'Verified Cylinder Problem Action Gagal! ' . $e->getMessage();
		$type_message = 'error';
	}catch (Exception $e) {
		$db->rollback();
		$status_code = 500;
		$message = 'Verified Cylinder Problem Action Gagal!, ' . $e->getMessage();
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