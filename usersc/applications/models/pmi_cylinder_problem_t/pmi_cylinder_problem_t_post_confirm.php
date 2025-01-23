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
	
	$id = $_POST['id_transaksi'];
	$state = $_POST['state'];

	// (ROW_NUMBER() OVER (ORDER BY a.id) * (ROW_NUMBER() OVER (ORDER BY a.id) - 1)) / 2 AS result

	try{
		
		if($state == 1){
			$qi_action = $db
				->raw()
				->bind(':id', $id)
				->exec('INSERT INTO pmi_cylinder_problem_t_action (
							id_pmi_cylinder_problem_t,
							keterangan,
							antrian,
							action
						)
						SELECT
							a.id,
							a.keterangan,
							(
								SELECT
									IF(COUNT(b.id) = 0, 1, COUNT(b.id) + 1) c_id
								FROM pmi_cylinder_problem_t_action b
								WHERE b.transaction_state <> -9 AND b.`action` = a.`action`
							) AS antrian,
							a.`action`
						FROM pmi_cylinder_problem_t a
						WHERE a.id = :id


			');	
		} // end if($state == 1)

		if(!empty($qi_action)){
			$status_code  = 200;
			$message = "Cylinder Problem Action Berhasil Ditambahkan";
			$type_message = "success";
			// parameter lain
		}else{
			$status_code  = 500;
			$message = "Cylinder Problem Action Gagal Ditambahkan";
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