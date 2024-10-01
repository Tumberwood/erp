<?php
	include( "../users/init.php" );
	include( "../usersc/lib/DataTables.php" );
	include( "../usersc/helpers/datatables_fn_debug.php" );
    require '../usersc/vendor/autoload.php';
	
	use
		DataTables\Editor,
		DataTables\Editor\Query,
		DataTables\Editor\Result;
        
    header('Content-Type: application/json');

    $jsonData = file_get_contents('php://input');

    // Mengubah JSON menjadi array PHP
    $data = json_decode($jsonData, true);

    // Mengecek apakah data diterima
    if ($data) {

        $data_id = $data['data_id'];  
       

        $qi_si_training_peserta_m = $db
        ->raw()
        ->bind(':data_id', $data_id)
        ->exec(' INSERT INTO si_training_peserta_m (
                    transaction_state,
                    start_at,
                    finish_at,
                    nama
                )
                VALUES 
                (
                    1,
                    NOW(),
                    NOW(),
                    :data_id
                )
        ');

        $form_data = [
            'data_id' => $data_id,
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