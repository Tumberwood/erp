<?php 
    /**
     * Digunakan untuk populate options data wdpxxth
     * Table terkait    : wdpxxth
     * Parameter        : 
     *  - ids_wdpxxth_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['ids_wdpxxth_old'] !== ''){
        $ids_array = explode(',', $_GET['ids_wdpxxth_old']);
        $c_data_self = count($ids_array); 

        $ids_wdpxxth_old = "(" . $_GET['ids_wdpxxth_old'] . ")";
        $where_in_self = 'AND wdpxxth.id IN  ' . $ids_wdpxxth_old . ' ';
        $where_in_all = 'AND wdpxxth.id NOT IN  ' . $ids_wdpxxth_old . ' ';
    }else{
        $where_in_self = '';
        $where_in_all = '';
        $c_data_self = 1;
    }
    
    if($_GET['id_wdoxxth'] > 0){
        $id_wdoxxth = $_GET['id_wdoxxth'];
    }else{
        $id_wdoxxth = 0;
    }
    
    //ferry 7 jan 2025, revisi pada search ini, karena hasilnya adalah array, error string conversion.
    if (empty($_GET['search']) || !is_array($_GET['search'])) {
        $search = $_GET['search'];
        $where_q = 'AND (
            wdpxxth.kode LIKE "%' . $search . '%"
            OR wdpxxth.mobil_nomor LIKE "%' . $search . '%"
        )';
    } else {
        // Gabungkan nilai array menjadi string dengan spasi
        $search = implode('', $_GET['search']); 
    
        // Escape nilai search untuk keamanan (menghindari SQL Injection)
        //tujuannya buat mecegah karakter petik (") atau (<) biar tidak error.
        $search = htmlspecialchars($search, ENT_QUOTES, 'UTF-8');
    
        $where_q = 'AND (
            wdpxxth.kode LIKE "%' . $search . '%"
            OR wdpxxth.mobil_nomor LIKE "%' . $search . '%"
        )';
    }
        
    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($_GET['ids_wdpxxth_old'] !== ''){
        $sql_self = "SELECT
                wdpxxth.id as id,
                CONCAT(wdpxxth.kode, ' - ', IFNULL(wdpxxth.mobil_nomor, '')) as text
            FROM wdpxxth
            LEFT JOIN grlxxmh ON grlxxmh.id = wdpxxth.id_grlxxmh_customer
            WHERE 1
                $where_in_self
            LIMIT $c_data_self
            OFFSET $offset
            ";
        $qs_wdpxxth_self = $db
            ->raw()
            ->bind(':ids_wdpxxth_old', $ids_wdpxxth_old)
            ->exec($sql_self);
        $rs_wdpxxth_self = $qs_wdpxxth_self->fetchAll();
    }else{
        $rs_wdpxxth_self = [];
    }
    // END query options self
    
    //wdoxxth Include
    $qs_wdpxxth_include = $db
        ->raw()
        ->bind(':id_wdoxxth', $id_wdoxxth)
        ->exec('SELECT
                    a.id_wdpxxth,
                    b.id_wdoxxth,
                    SUM(a.jumlah_terkecil_os) sisa
                FROM wdplptd a
                LEFT JOIN wdoittd b ON b.id = a.id_wdoittd
                GROUP BY a.id_wdpxxth
                HAVING id_wdoxxth = :id_wdoxxth AND sisa > 0
    ');
    $rs_wdpxxth_include = $qs_wdpxxth_include->fetchAll();
    //END wdoxxth Include

    $id_list = array_column($rs_wdpxxth_include, 'id_wdpxxth'); 
    $id_wdpxxth = !empty($id_list) ? implode(',', $id_list) : 'NULL';
    $where_include = " AND wdpxxth.id IN ($id_wdpxxth)";

    // BEGIN query options all except self
    $sql = "SELECT 
            wdpxxth.id as id,
            CONCAT(wdpxxth.kode, ' - ', IFNULL(wdpxxth.mobil_nomor, '')) as text 
        FROM wdpxxth
        LEFT JOIN grlxxmh ON grlxxmh.id = wdpxxth.id_grlxxmh_customer
        WHERE 1
            $where_include
            AND wdpxxth.transaction_state = 1 $where_in_all $where_q
        LIMIT $resultCount 
        OFFSET $offset
        ";
    $qs_wdpxxth_all = $db
        ->raw()
        ->exec($sql);
    $rs_wdpxxth_all = $qs_wdpxxth_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_wdpxxth_self) > 0){
        $rs_opt = array_merge($rs_wdpxxth_self, $rs_wdpxxth_all);
    }else{
        $rs_opt = $rs_wdpxxth_all;
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