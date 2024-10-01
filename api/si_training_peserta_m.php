<?php
	include( "../users/init.php" );
	include( "../usersc/lib/DataTables.php" );
	include( "../usersc/helpers/datatables_fn_debug.php" );
    require '../usersc/vendor/autoload.php';
	
	use
		DataTables\Editor,
		DataTables\Editor\Query,
		DataTables\Editor\Result;
        
    if ( ! empty( $_REQUEST ) ) {
        // Get the request. Works both for GET and POST
        $info = $_REQUEST;
        // Save HTTP METHOD for debugging
        $info['method'] = $_SERVER['REQUEST_METHOD'];
        // Create the JSON
        $json = json_encode( $info );
        
        $data_id = $info['data_id']; 
        $nama = $info['nama'];  
        $no_wa = $info['no_wa'];  
        $domisili = $info['domisili'];  
        $sumber_info = $info['sumber_info'];  
        $profesi = $info['profesi'];  
        $alasan = $info['alasan'];  
        $email = $info['email'];  

        $qi_si_training_peserta_m = $db
        ->raw()
        ->bind(':nama', $nama)
        ->bind(':email', $email)
        ->bind(':no_wa', $no_wa)
        ->bind(':domisili', $domisili)
        ->bind(':sumber_info', $sumber_info)
        ->bind(':profesi', $profesi)
        ->bind(':alasan', $alasan)
        ->bind(':json', $json)
        ->exec(' INSERT INTO si_training_peserta_m (
                    transaction_state,
                    start_at,
                    finish_at,
                    nama,
                    email,
                    no_wa,
                    domisili,
                    sumber_info,
                    profesi,
                    alasan
                )
                VALUES 
                (
                    1,
                    NOW(),
                    NOW(),
                    :nama,
                    :email,
                    :no_wa,
                    :domisili,
                    :sumber_info,
                    :profesi,
                    :alasan
                )
        ');

        $form_data = [
            'nama' => $nama,
        ];

        // Mengirim response sukses
        http_response_code(200);
        echo json_encode([
            "status" => "success", 
            "message" => "Data berhasil diterima",
            "data" => $form_data,
        ]);
    } else {
        // Jika tidak ada data yang diterima
        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "Tidak ada data yang diterima"]);
    }
?>