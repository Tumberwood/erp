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

	try{
		
		if($state == 1){
			// do nothing
			$status_code  = 200;
			$message      = 'Post Confirm No Action';
			$type_message = 'success';
		} // end if($state == 1)

		
	}catch(PDOException $e){
		$status_code  = 500;
		$message      = 'Post Confirm No Action! ' . $e->getMessage();
		$type_message = 'error';
	}catch (Exception $e) {
        $db->rollback();
        $status_code = 500;
        $message      = 'Post Confirm No Action! ' . $e->getMessage();
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