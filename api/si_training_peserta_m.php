<?php
// Periksa apakah permintaan kosong
if ( ! empty( $_REQUEST ) ) {
    // Ambil permintaan. Bekerja baik untuk GET maupun POST
    $info = $_REQUEST;
    // Simpan METODE HTTP untuk debugging
    $info['method'] = $_SERVER['REQUEST_METHOD'];
    // Buat JSON
    $json = json_encode( $info );
    // Simpan dalam sebuah file
    $jsonData = file_get_contents('https://solusi-indonesia.com/eforms/pendaftaran-training-basic-salesmanship-online-copy/14/nama_file.json');
$dataArray = json_decode($jsonData, true); // Mengubah JSON menjadi array PHP

// Permintaan kosong, jadi keluar
} else {
    echo 'Permintaan Buruk!';
}
