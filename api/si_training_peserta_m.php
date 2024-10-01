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

    // Handle incoming JSON data
    $jsonData = file_get_contents('php://input');
    // Convert JSON into a PHP array
    $data = json_decode($jsonData, true);

    // Check if data is received
    if ($data) {
        $nama = $data['nama'];
        $no_wa = $data['no_wa'];
        $domisili = $data['domisili'];
        $profesi = $data['profesi'];
        $sumber_info = $data['sumber_info'];
        $alasan = $data['alasan'];

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
            "message" => "Data berhasil diterima",
            "data" => $form_data,
        ]);
    } else {
        // If no data is received
        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "Tidak ada data yang diterima"]);
    }
} else {
    // Request is empty, so exit
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Bad Request!"]);
}
?>
