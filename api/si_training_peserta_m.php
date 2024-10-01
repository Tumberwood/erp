<?php
include("../users/init.php");
include("../usersc/lib/DataTables.php");
include("../usersc/helpers/datatables_fn_debug.php");
require '../usersc/vendor/autoload.php';

use DataTables\Editor;
use DataTables\Editor\Query;
use DataTables\Editor\Result;

// Set content type to JSON
header('Content-Type: application/json');

// Check if request is not empty
if (!empty($_REQUEST)) {
    // Get the request data (GET or POST)
    $info = $_REQUEST;
    // Save HTTP METHOD for debugging
    $info['method'] = $_SERVER['REQUEST_METHOD'];

    // Create the JSON for storage in a file
    $json = json_encode($info);
    // Store it in a file
    $filename = dirname(__FILE__) . '/eform-url-' . (isset($_REQUEST['data_id']) ? $_REQUEST['data_id'] : uniqid()) . '.json';
    // Save JSON to file
    file_put_contents($filename, $json);

    // Prepare data for insertion into the database
    $nama = isset($info['nama']) ? $info['nama'] : '';
    $no_wa = isset($info['no_wa']) ? $info['no_wa'] : '';
    $domisili = isset($info['domisili']) ? $info['domisili'] : '';
    $profesi = isset($info['profesi']) ? $info['profesi'] : '';
    $sumber_info = isset($info['sumber_info']) ? $info['sumber_info'] : ''; // Dapat info dari mana?
    $alasan = isset($info['alasan']) ? $info['alasan'] : '';  // alasan 3 kata

    // Check if all required fields are present
    if (!empty($nama) && !empty($no_wa) && !empty($domisili) && !empty($profesi) && !empty($sumber_info) && !empty($alasan)) {
        // Insert data into database
        $qi_si_training_peserta_m = $db
            ->raw()
            ->bind(':nama', $nama)
            ->bind(':no_wa', $no_wa)
            ->bind(':domisili', $domisili)
            ->bind(':profesi', $profesi)
            ->bind(':sumber_info', $sumber_info)
            ->bind(':alasan', $alasan)
            ->exec('INSERT INTO si_training_peserta_m (
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
                        1,
                        NOW(),
                        NOW(),
                        :nama,
                        :no_wa,
                        :domisili,
                        :profesi,
                        :sumber_info,
                        :alasan
                    )
        ');

        // Prepare response data
        $form_data = [
            'nama' => $nama,
            'no_wa' => $no_wa,
            'domisili' => $domisili,
            'profesi' => $profesi,
            'sumber_info' => $sumber_info,
            'alasan' => $alasan,
        ];

        // Send success response
        http_response_code(200);
        echo json_encode([
            "status" => "success",
            "message" => "Data berhasil diterima dan disimpan.",
            "data" => $form_data,
        ]);
    } else {
        // If required fields are missing
        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "Semua field diperlukan."]);
    }
} else {
    // Request is empty, so exit
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Bad Request!"]);
}
?>
