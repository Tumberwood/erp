<?php
    /**
     * fn_email_setting
     * Digunakan untuk setup SMTP keperluan mengirimkan email
     * Parameter diambil dari table db email (bawaan userspice)
     * Setting SMTP Google
     *  - email google harus 2FA. 
     *  - tambahkan App Password. Masuk ke email Account Setting / Security. Akan mendapatkan 16 karakter password
     *  - 16 karakter password itu yang menjadi parameter password di table email. (jadi bukan password login gmail)
     *  - STMP dan port
     *      - server: tls 587
     *      - localhost: ssl 465
     * Referensi: 
     *  https://mailtrap.io/blog/phpmailer-gmail/
     */

    
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    $qs_email = $db
        ->raw()
        ->bind(':id', 1)
        ->exec('
            SELECT
                debug_level,
                isSMTP,
                smtp_server,
                smtp_port,
                email_login,
                email_pass,
                transport,
                from_name,
                from_email
            FROM email
            WHERE id = :id
        ');
    $rs_email = $qs_email->fetch();

	$mail = new PHPMailer(true);
    $mail->SMTPDebug = $rs_email['debug_level'];    // untuk keperluan debug. 0 s/d 4 diatur di tabel email
    $mail->isSMTP();
    $mail->Host       = $rs_email['smtp_server'];   
    $mail->SMTPAuth   = true;
    $mail->Username   = $rs_email['email_login'];
    $mail->Password   = $rs_email['email_pass'];    
    $mail->Port       = $rs_email['smtp_port'];     // tls: 587; ssl: 465;
    $mail->SMTPSecure = $rs_email['transport'];     // jika di server, gunakan tls. localhost bisa ssl

    $mail->setFrom($rs_email['from_email'], $rs_email['from_name'] );
    $mail->isHTML(true);

    // optional BCC wajib untuk keperluan testing cek email terkirim atau tidak
    // $mail->addBCC('');

    // parameter lain ditambahkan di masing-masing halaman yang mau di emailkan
    // parameter yang bisa digunakan
    /**
     * Recipients
     * $mail->setFrom('from@example.com', 'Mailer');
     * $mail->addAddress('joe@example.net', 'Joe User');     //Add a recipient
     * $mail->addAddress('ellen@example.com');               //Name is optional
     * $mail->addReplyTo('info@example.com', 'Information');
     * $mail->addCC('cc@example.com');
     * $mail->addBCC('bcc@example.com');
     * 
     * //Attachments
     * $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
     * $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
     * 
     * //Content
     * $mail->isHTML(true);                                  //Set email format to HTML
     * $mail->Subject = 'Here is the subject';
     * $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
     * $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
     * 
     */
?>
