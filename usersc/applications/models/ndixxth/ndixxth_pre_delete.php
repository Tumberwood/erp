<?php
	// path nya beda, karena dipanggil dari helpers
	require_once( "../../users/init.php" );
	require_once( "../../usersc/lib/DataTables.php" );
    require_once( "datatables_fn_debug.php" );
    require_once( "hakakses_s_fn.php" );
	require_once '../../usersc/vendor/autoload.php';

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
	
	// $id = $_POST['id_transaksi_h'];
	$state = $_POST['transaction_state'];	// dari tr_transaction_state

	try{
		
		if($state == -93){
            $qu_ndoxxth = $db
                ->raw()
                ->bind(':id_transaksi', $id_transaksi)
                ->exec('
                    UPDATE ndoxxth a
                    LEFT JOIN ndixxth b ON b.id_ndoxxth = a.id
                    SET
                        a.is_nextprocess = null
                    WHERE
                        b.id = :id_transaksi
                ');
            
            if(!empty($qu_ndoxxth)){
                $status_code  = '200';
                $message = "Update Document Transfer Out Berhasil";
                $type_message = "success";
                // parameter lain
            }else{
                $status_code  = '500';
                $message = "Update Document Transfer Out Gagal!";
                $type_message = 'error';
                // parameter lain
            }
            
		} // end if($state == -93)

		
	}catch(PDOException $e){
		$status_code  = '500';
		$message      = 'Message Gagal! ' . $e->getMessage();
		$type_message = 'error';
	}

	// build response
	$data = array(
		'status_code'    => $status_code,
		'message'        => $message,
		'type_message'   => $type_message
	);

	$data = array(
		'status_code'   => $status_code,
		'message'      	=> $message,
		'type_message' 	=> $type_message
	);

	require_once( "fn_ajax_results.php" );

?>