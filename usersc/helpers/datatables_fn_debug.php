<?php
    // digunakan untuk melakukan debugging query datatables class, tanpa melalui editor
    // untuk menampilkan hasil debug, gunakan print_r di halaman terkait:
    // print_r($debug);
    
    $debug = [];
    $results = array();
    $db->debug( function ( $mess ) use ( &$debug ) {
        // old version
        $debug[] = $mess;

        // if (is_array($mess)) {
        //     $mess = print_r($mess, true);
        // }

        // $cleanMessage = str_replace(array("\r", "\n", "\t"), ' ', $mess);
        // $cleanMessage = preg_replace('/\s+/', ' ', $cleanMessage);
        // $debug[] = $cleanMessage;
    } );

?>