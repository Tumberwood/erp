<?php
    /**
     * Digunakan untuk menampilkan hasil model _fn 
     * Ini digunakan secara global, di require_once di masing-masing halaman model _fn
     * Results :
     *  - debug         : menampilkan debug query. Didapatkan dari helpers/datatables_fn_debug.php
     *  - data          : output general data (array)
     * 
     * Untuk select2
     *  - results       : options untuk select2
     *  - total_data    : total_data options select2
     *  - pagination    : untuk keperluan paginasi select2
     */

    // BEGIN results akhir
    $results = array(
        "debug" => $debug,
        "data" => $data,

        // untuk select2
        "results" => $rs_opt,

        // 2 ini harusny tidak dipakai
        // "total_data" => $c_rs_opt,
        // "pagination" => array(
        //     "more" => $morePages
        // )
    );
    // END results akhir

    header('Content-Type: application/json');
    echo json_encode($results,JSON_NUMERIC_CHECK);
?>