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

        $nama = $data['nama'];  
        $no_wa = $data['no_wa']; 
        $domisili = $data['domisili']; 
        $profesi = $data['profesi']; 
        $sumber_info = $data['sumber_info']; //Dapat info dari mana?
        $alasan = $data['alasan'];  //alasan 3 kata

        $qi_si_training_peserta_m = $db
        ->raw()
        ->bind(':nama', $nama)
        ->bind(':no_wa', $no_wa)
        ->bind(':domisili', $domisili)
        ->bind(':profesi', $profesi)
        ->bind(':sumber_info', $sumber_info)
        ->bind(':alasan', $alasan)
        ->exec(' INSERT INTO si_training_peserta_m (
                    transaction_state,
                    start_at,
                    finish_at,
                    nama,
                    no_wa,
                    domisili,
                    profesi,
                    sumber_info,
                    alasan
                )
                VALUES 
                (
                    NOW(),
                    NOW(),
                    1,
                    :nama,
                    :no_wa,
                    :domisili,
                    :profesi,
                    :sumber_info,
                    :alasan
                )
        ');

        $form_data = [
            'nama' => $nama,
            'no_wa' => $no_wa,
            'domisili' => $domisili,
            'profesi' => $profesi,
            'sumber_info' => $sumber_info,
            'alasan' => $alasan,
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