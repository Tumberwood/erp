<?php 
    /**
     * Digunakan untuk populate options data hgnlgmh
     * Table terkait    : hgnlgmh
     * Parameter        : 
     *  - ids_hgnlgmh_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['ids_hgnlgmh_old'] !== ''){
        $ids_array = explode(',', $_GET['ids_hgnlgmh_old']);
        $c_data_self = count($ids_array); 

        $ids_hgnlgmh_old = "(" . $_GET['ids_hgnlgmh_old'] . ")";
        $where_in_self = 'AND hgnlgmh.id IN  ' . $ids_hgnlgmh_old . ' ';
        $where_in_all = 'AND hgnlgmh.id NOT IN  ' . $ids_hgnlgmh_old . ' ';
    }else{
        $where_in_self = '';
        $where_in_all = '';
        $c_data_self = 1;
    }
    
    //ferry 7 jan 2025, revisi pada search ini, karena hasilnya adalah array, error string conversion.
    if (empty($_GET['search']) || !is_array($_GET['search'])) {
        $search = $_GET['search'];
        $where_q = 'AND (
            hgnlgmh.kode LIKE "%' . $search . '%"
            OR hgnlgmh.nama LIKE "%' . $search . '%"
        )';
    } else {
        // Gabungkan nilai array menjadi string dengan spasi
        $search = implode('', $_GET['search']); 
    
        // Escape nilai search untuk keamanan (menghindari SQL Injection)
        //tujuannya buat mecegah karakter petik (") atau (<) biar tidak error.
        $search = htmlspecialchars($search, ENT_QUOTES, 'UTF-8');
    
        $where_q = 'AND (
            hgnlgmh.kode LIKE "%' . $search . '%"
            OR hgnlgmh.nama LIKE "%' . $search . '%"
        )';
    }
    
        
    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($_GET['ids_hgnlgmh_old'] !== ''){
        $sql_self = "SELECT
                hgnlgmh.id as id,
                CONCAT(hgnlgmh.kode,' - ',hgnlgmh.nama) as text
            FROM hgnlgmh
            WHERE 1
                $where_in_self
            LIMIT $c_data_self
            OFFSET $offset
            ";
        $qs_hgnlgmh_self = $db
            ->raw()
            ->bind(':ids_hgnlgmh_old', $ids_hgnlgmh_old)
            ->exec($sql_self);
        $rs_hgnlgmh_self = $qs_hgnlgmh_self->fetchAll();
    }else{
        $rs_hgnlgmh_self = [];
    }
    // END query options self

    // BEGIN query options all except self
    $sql = "SELECT 
            hgnlgmh.id as id,
            CONCAT(hgnlgmh.kode,' - ',hgnlgmh.nama) as text 
        FROM hgnlgmh
        WHERE 
            hgnlgmh.transaction_state = 1 $where_in_all $where_q
        LIMIT $resultCount 
        OFFSET $offset
        ";
    $qs_hgnlgmh_all = $db
        ->raw()
        ->exec($sql);
    $rs_hgnlgmh_all = $qs_hgnlgmh_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_hgnlgmh_self) > 0){
        $rs_opt = array_merge($rs_hgnlgmh_self, $rs_hgnlgmh_all);
    }else{
        $rs_opt = $rs_hgnlgmh_all;
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