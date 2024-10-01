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
    $filename = dirname( __FILE__ ) . '/nama_file.json';
    // Kami tidak benar-benar memeriksa apakah file ada atau tidak
    file_put_contents( $filename, $json );
// Permintaan kosong, jadi keluar
} else {
    echo 'Permintaan Buruk!';
}
