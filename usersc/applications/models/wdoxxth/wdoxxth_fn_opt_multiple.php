<?php 
    /**
     * Digunakan untuk populate options data wdoxxth
     * Table terkait    : wdoxxth
     * Parameter        : 
     *  - ids_wdoxxth_old       : data existing (untuk keperluan edit), dipakai di query self
     */
    require_once( "../../../../users/init.php" );
	require_once( "../../../../usersc/lib/DataTables.php" );
	require_once( "../../../../usersc/helpers/datatables_fn_debug.php" );

    // BEGIN definisi variable untuk fn_ajax_results.php
    $data      = array();
    $rs_opt    = array();
    $c_rs_opt  = 0;
    $morePages = 0;
    // END definisi variable untuk fn_ajax_results.php
    
    // BEGIN select2 pagination preparation
    $page        = $_GET['page'];
    $resultCount = 10;
    $offset      = ($page - 1) * $resultCount;
    // END select2 pagination preparation

    if($_GET['ids_wdoxxth_old'] !== ''){
        $ids_array = explode(',', $_GET['ids_wdoxxth_old']);
        $c_data_self = count($ids_array); 

        $ids_wdoxxth_old = "(" . $_GET['ids_wdoxxth_old'] . ")";
        $where_in_self = 'AND wdoxxth.id IN  ' . $ids_wdoxxth_old . ' ';
        $where_in_all = 'AND wdoxxth.id NOT IN  ' . $ids_wdoxxth_old . ' ';
    }else{
        $where_in_self = '';
        $where_in_all = '';
        $c_data_self = 1;
    }
    
    //ferry 7 jan 2025, revisi pada search ini, karena hasilnya adalah array, error string conversion.
    if (empty($_GET['search']) || !is_array($_GET['search'])) {
        $where_q = '';
    } else {
        // Gabungkan nilai array menjadi string dengan spasi
        $search = implode('', $_GET['search']); 
    
        // Escape nilai search untuk keamanan (menghindari SQL Injection)
        //tujuannya buat mecegah karakter petik (") atau (<) biar tidak error.
        $search = htmlspecialchars($search, ENT_QUOTES, 'UTF-8');
    
        $where_q = 'AND (
            wdoxxth.kode LIKE "%' . $search . '%"
            OR grlxxmh.nama LIKE "%' . $search . '%"
        )';
    }
    
        
    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($_GET['ids_wdoxxth_old'] !== ''){
        $sql_self = "SELECT
                wdoxxth.id as id,
                CONCAT(wdoxxth.kode, ' - ', grlxxmh.nama) as text
            FROM wdoxxth
            LEFT JOIN grlxxmh ON grlxxmh.id = wdoxxth.id_grlxxmh_customer
            WHERE 1
                $where_in_self
            LIMIT $c_data_self
            OFFSET $offset
            ";
        $qs_wdoxxth_self = $db
            ->raw()
            ->bind(':ids_wdoxxth_old', $ids_wdoxxth_old)
            ->exec($sql_self);
        $rs_wdoxxth_self = $qs_wdoxxth_self->fetchAll();
    }else{
        $rs_wdoxxth_self = [];
    }
    // END query options self

    //Outstanding
    $qs_os_nol = $db
        ->raw()
        ->exec('SELECT
                    a.id,
                    SUM(b.jumlah_terkecil_os) AS os
                FROM wdoxxth a
                LEFT JOIN wdoittd b ON b.id_wdoxxth = a.id
                WHERE a.transaction_state = 1 AND b.transaction_state <> -9
                GROUP BY a.id
                HAVING os = 0
        '
        );

    $rs_os_nol = $qs_os_nol->fetchAll();
    $id_array = [];

    if (!empty($rs_os_nol)) {
        //yang item OS = 0 semua, maka tidak perlu dimunculkan headernya
        foreach ($rs_os_nol as $row) {
            $id_array[] = $row['id'];
        }

        $id_string = '(' . implode(',', $id_array) . ')';
    } else {
        $id_string = '(-9)';
    }

    // BEGIN query options all except self
    $sql = "SELECT 
            wdoxxth.id as id,
            CONCAT(wdoxxth.kode, ' - ', grlxxmh.nama) as text 
        FROM wdoxxth
        LEFT JOIN grlxxmh ON grlxxmh.id = wdoxxth.id_grlxxmh_customer
        WHERE 
            wdoxxth.id NOT IN $id_string
            AND wdoxxth.transaction_state = 1 $where_in_all $where_q
        LIMIT $resultCount 
        OFFSET $offset
        ";
    $qs_wdoxxth_all = $db
        ->raw()
        ->exec($sql);
    $rs_wdoxxth_all = $qs_wdoxxth_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_wdoxxth_self) > 0){
        $rs_opt = array_merge($rs_wdoxxth_self, $rs_wdoxxth_all);
    }else{
        $rs_opt = $rs_wdoxxth_all;
    }
    $c_rs_opt = count($rs_opt);    
    // END menggabungkan options

    // BEGIN finalisasi paginasi select2
    $endCount  = $offset + $resultCount;
    $morePages = $endCount > $c_rs_opt;
    // END finalisasi paginasi select2
    
    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>