<?php 
    /**
     * Digunakan untuk populate options data hemxxmh
     * Table terkait    : hemxxmh
     * Parameter        : 
     *  - ids_hemxxmh_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['ids_hemxxmh_old'] !== ''){
        $ids_array = explode(',', $_GET['ids_hemxxmh_old']);
        $c_data_self = count($ids_array); 

        $ids_hemxxmh_old = "(" . $_GET['ids_hemxxmh_old'] . ")";
        $where_in_self = 'AND hemxxmh.id IN  ' . $ids_hemxxmh_old . ' ';
        $where_in_all = 'AND hemxxmh.id NOT IN  ' . $ids_hemxxmh_old . ' ';
    }else{
        $c_data_self = 1;
        
        $where_in_self = '';
        $where_in_all = '';
    }
    
    // print_r($_GET['search']);
    //ferry 7 jan 2025, revisi pada search ini, karena hasilnya adalah array, error string conversion.
    if (empty($_GET['search']) || !is_array($_GET['search'])) {
        $where_q = 'AND (
            hemxxmh.kode LIKE "%' . $_GET['search'] . '%"
            OR hemxxmh.fname LIKE "%' . $_GET['search'] . '%"
            OR hemxxmh.lname LIKE "%' . $_GET['search'] . '%"
        )';
    } else {
        // Gabungkan nilai array menjadi string dengan spasi
        $search = implode('', $_GET['search']); 
    
        // Escape nilai search untuk keamanan (menghindari SQL Injection)
        //tujuannya buat mecegah karakter petik (") atau (<) biar tidak error.
        $search = htmlspecialchars($search, ENT_QUOTES, 'UTF-8');
    
        $where_q = 'AND (
            hemxxmh.kode LIKE "%' . $search . '%"
            OR hemxxmh.fname LIKE "%' . $search . '%"
            OR hemxxmh.lname LIKE "%' . $search . '%"
        )';
    }
    
        
    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($_GET['ids_hemxxmh_old'] !== ''){
        $sql_self = "SELECT
                hemxxmh.id as id,
                CONCAT(hemxxmh.kode,' - ',hemxxmh.fname,' ',hemxxmh.lname) as text
            FROM hemxxmh
            WHERE 1
                $where_in_self
            LIMIT $c_data_self
            OFFSET $offset
            ";
        $qs_hemxxmh_self = $db
            ->raw()
            ->bind(':ids_hemxxmh_old', $ids_hemxxmh_old)
            ->exec($sql_self);
        $rs_hemxxmh_self = $qs_hemxxmh_self->fetchAll();
    }else{
        $rs_hemxxmh_self = [];
    }
    // END query options self

    // BEGIN query options all except self
    $sql = "SELECT 
            hemxxmh.id as id,
            CONCAT(hemxxmh.kode,' - ',hemxxmh.fname,' ',hemxxmh.lname) as text 
        FROM hemxxmh
        WHERE 
            hemxxmh.transaction_state = 1 $where_in_all $where_q
        LIMIT $resultCount 
        OFFSET $offset
        ";
    $qs_hemxxmh_all = $db
        ->raw()
        ->exec($sql);
    $rs_hemxxmh_all = $qs_hemxxmh_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_hemxxmh_self) > 0){
        $rs_opt = array_merge($rs_hemxxmh_self, $rs_hemxxmh_all);
    }else{
        $rs_opt = $rs_hemxxmh_all;
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