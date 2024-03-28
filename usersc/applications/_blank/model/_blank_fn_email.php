<?php
	/**
     * Digunakan untuk populate options data Expedition
     * Table terkait    : lexxxmh
     * Parameter        : 
     *  - id_lexxxmh_old       : data existing (untuk keperluan edit), dipakai di query self
     */
    require_once( "../../../../users/init.php" );
	require_once( "../../../../usersc/lib/DataTables.php" );
	require_once( "../../../../usersc/helpers/datatables_fn_debug.php" );

    // BEGIN definisi variable untuk fn_ajax_results.php
    $data      = array();
    $rs_opt    = array();
    $c_rs_opt  = 0;
    $morePages = 0;
    // END definisi variable untuk fn_ajax_results.php

	try {

		// prepare email
		$mail->addAddress( 'frans@solusi-indonesia.com' );
		$mail->addCC( 'kaosputihmurah@gmail.com' );
		
		$mail->isHTML(true);
		$mail->Subject = 'Test gmail SMPT';
		$mail->Body    = 'Testing via gmail SMTP';

		if (!$mail->send()) {
			$data = array(
				'message' => 'Email Gagal terkirim. ' . $mail->ErrorInfo,
				'type_message' => 'danger'
			);
		} else {
			$data = array(
				'message' => 'Email berhasil terkirim',
				'type_message' => 'success'
			);
		}

		$mail->smtpClose();


	}catch(PDOException $e){
		
		$data = array(
			'message' => 'Email Gagal terkirim. ' . $mail->ErrorInfo,
			'type_message' => 'danger'
		);
	}
	
	// tampilkan results
	require_once( "../../../../usersc/helpers/fn_ajax_results.php" );	
	
?>