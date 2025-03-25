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

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	try {
		$id_transaksi_h    = $_POST['id_transaksi_h'];

		$qs_kandidat = $db
			->raw()
			->bind(':id_transaksi_h', $id_transaksi_h)
			->exec('SELECT
						c.nama,
						b.id_hcdxxmh,
						DATE_FORMAT(a.tanggal, "%d %b %Y") tanggal,
						DATE_FORMAT(curdate(), "%d %b %Y") today,
						d.email_personal
					FROM hrctsth a
					LEFT JOIN hrctstd b ON b.id_hrctsth = a.id
					LEFT JOIN hcdxxmh c ON c.id = b.id_hcdxxmh
					LEFT JOIN hcdcsmh d ON d.id_hcdxxmh = c.id
					WHERE a.transaction_state = 1 
						AND a.is_email = 0 
						AND b.transaction_state <> -9 
						AND a.id = :id_transaksi_h
					GROUP BY id_hcdxxmh
		');
		$rs_kandidat = $qs_kandidat->fetchAll();
		
		// Instantiation and passing `true` enables exceptions
		// $mail = new PHPMailer(true);
		
		foreach ($rs_kandidat as $key => $kandidat) {
			$nama = $kandidat['nama'];
			$tanggal = $kandidat['tanggal'];
			$id_hcdxxmh = $kandidat['id_hcdxxmh'];
			$email_personal = $kandidat['email_personal'];

			$body =  '<b>Dear. '.$nama.'</b></br></br>';
			$body = $body . 'Terima kasih telah mendaftar untuk tes online ERPX-Solusi Indonesia. Berikut adalah detail akses Anda:</br></br>';
			$body = $body . 'Link Tes: <a href="https://erpx.solusiprogram.top/tes_online.php">Klik di sini untuk mengikuti tes</a></br>';
			$body = $body . '<table style="border-collapse: collapse; width:100%">';
				$body = $body .  '<thead>';
					$body = $body .  '<tr>';
						$body = $body .  '<th style="border: 1px solid #000; padding:5px">Jenis</th>';
						$body = $body .  '<th style="border: 1px solid #000; padding:5px">Kode Tes</th>';
					$body = $body .  '</tr>';
				$body = $body .  '</thead>';
				$body = $body .  '<tbody>';
				
				$qs_tes = $db
					->raw()
					->bind(':id_transaksi_h', $id_transaksi_h)
					->bind(':id_hcdxxmh', $id_hcdxxmh)
					->exec('SELECT
								c.nama,
								d.nama tes,
								b.kode
							FROM hrctsth a
							LEFT JOIN hrctstd b ON b.id_hrctsth = a.id
							LEFT JOIN hcdxxmh c ON c.id = b.id_hcdxxmh
							LEFT JOIN hrctsmh d ON d.id = b.id_hrctsmh
							WHERE a.transaction_state = 1 AND b.transaction_state <> -9 AND a.id = :id_transaksi_h AND b.id_hcdxxmh = :id_hcdxxmh
				');
				$rs_tes = $qs_tes->fetchAll();
					//for ($x = 0; $x < $c_select_kontrakexpired; $x++) {
					foreach ($rs_tes as $key => $tes) {
						$textColor = ''; // Default text color
						$body .= '<tr>';
						$body .= '<td style="border: 1px solid #000; padding:5px; vertical-align:top;">' . $tes['tes'] . '</td>';
						$body .= '<td style="border: 1px solid #000; padding:5px; vertical-align:top;">' . $tes['kode'] . '</td>';
						$body .= '</tr>';
					}
						
				$body = $body .  '</tbody>';
			$body = $body .  '</table>';
			$body = $body .  '<br> <p>Terkirim otomatis dari ERPX - Solusi Indonesia </p>';
			echo $body;

			// build table
			
			// generate email
			//Testing by Ferry
			$mail->setFrom('noreply@solusi-indonesia.com', 'ERPX');
			$mail->addAddress($email_personal);
			// $mail->addBCC('danny.harjono@solusi-indonesia.com');
	
					
			$mail->isHTML(true);
			$mail->Subject = 'Undangan Tes Online ERPX ' . $tanggal;
			$mail->Body    = $body;
			
			// sending email
			$mail->send();	
			
		}

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

			$qu_hrctsth = $db
				->query('update', 'hrctsth')
				->set('is_email',1)
				->where('id',$id_transaksi_h)
				->exec();
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