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
        
        $m12 = $info['m12'];  

        $qi_si_training_peserta_m = $db
        ->raw()
        ->bind(':m12', $m12)
        ->bind(':json', $json)
        ->exec(' INSERT INTO si_training_peserta_m (
                    transaction_state,
                    start_at,
                    finish_at,
                    nama,
                    keterangan
                )
                VALUES 
                (
                    1,
                    NOW(),
                    NOW(),
                    :m12,
                    :json
                )
        ');

        $form_data = [
            'm12' => $m12,
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