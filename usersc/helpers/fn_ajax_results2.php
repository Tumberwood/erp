<?php
    /**
     * Digunakan untuk menampilkan hasil model _fn 
     * Ini digunakan secara global, di require_once di masing-masing halaman model _fn
     * Results :
     *  - debug         : menampilkan debug query. Didapatkan dari helpers/datatables_fn_debug.php
     *  - data          : output general data (array). Silakan isi variable $data di halaman sumber
     *  - hakakses      : mendaptakan data hak akses
     *  - options       : options untuk select2
     */

    // BEGIN results akhir
    $json = array(
        "debug" => $debug,
        "data" => $data,
        "hakakses" => $hakakses,
        "options" => $rs_opt
    );
    // END results akhir

    header('Content-Type: application/json');

    if(empty($not_numcheck)){
        echo json_encode($json,JSON_NUMERIC_CHECK);
    }else{
        echo json_encode($json);
    }
?>