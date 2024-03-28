<?php
	/**
     * Digunakan untuk mengirimkan email
     * Table terkait    : sesuai data yang mau di emailkan
     * Parameter        : sesuai data yang mau di emailkan
     * 
	 * Parameter phpmailer:
	 * RECEIPIENTS
     * 	$mail->setFrom('from@example.com', 'Mailer');
     * 	$mail->addAddress('joe@example.net', 'Joe User');     //Add a recipient
     * 	$mail->addAddress('ellen@example.com');               //Name is optional
     * 	$mail->addReplyTo('info@example.com', 'Information');
     * 	$mail->addCC('cc@example.com');
     * 	$mail->addBCC('bcc@example.com');
     * 
     * ATTACHMENTS
     * 	$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
     * 	$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
     * 
     * CONTENT
     * 	$mail->isHTML(true);                                  //Set email format to HTML
     * 	$mail->Subject = 'Here is the subject';
     * 	$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
     * 	$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
     *  
     */
    require_once( "../../../../users/init.php" );
	require_once( "../../../../usersc/lib/DataTables.php" );
	require_once( "../../../../usersc/vendor/autoload.php" );
	require_once( "../../../../usersc/helpers/fn_Email_setting.php" );
	require_once( "../../../../usersc/helpers/datatables_fn_debug.php" );

    // BEGIN definisi variable untuk fn_ajax_results.php
    $data      = array();
    $rs_opt    = array();
    $c_rs_opt  = 0;
    $morePages = 0;
    // END definisi variable untuk fn_ajax_results.php

	try {

		// query RECEIPIENTS
		// query CONTENT dan ATTACHMENTS

		// sending email
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