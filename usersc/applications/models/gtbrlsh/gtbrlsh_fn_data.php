<?php
	/**
     * Digunakan untuk mengambil data dari table gtbrlsh
     * Data yang diambil:
     *  $is_master_table
     *  $is_need_approval
     *  $is_need_generate_kode
     */

     include_once( "../../../../users/init.php" );
     include_once( "../../../../usersc/lib/DataTables.php" );
     include_once( "../../../../usersc/vendor/autoload.php");
     require_once( "../../../../usersc/helpers/datatables_fn_debug.php" );

     // BEGIN definisi variable untuk fn_ajax_results.php
    $data      = array();
    $rs_opt    = array();
    $c_rs_opt  = 0;
    $morePages = 0;
    // END definisi variable untuk fn_ajax_results.php

    $is_master_table       = null;
    $is_need_approval      = null;
    $is_need_generate_kode = null;
    $is_need_jurnal        = null;
    $tbl_name              = $_POST['tbl_name'];

    try{
        $qs_gtbrlsh = $db
            ->raw()
            ->bind(':tbl_name', $tbl_name)
            ->exec('
                SELECT
                    is_master_table,
                    is_need_approval,
                    is_need_generate_kode,
                    is_need_jurnal
                FROM gtbrlsh
                WHERE 1
                    AND tblheader = :tbl_name
            ');
        $rs_gtbrlsh = $qs_gtbrlsh->fetch();
        
        if(!empty($rs_gtbrlsh)){
            $status_code           = '200';
            $message               = 'Get Table Relation Berhasil';
            $type_message          = 'success';
            $is_master_table       = $rs_gtbrlsh['is_master_table'];
            $is_need_approval      = $rs_gtbrlsh['is_need_approval'] ;
            $is_need_generate_kode = $rs_gtbrlsh['is_need_generate_kode'];
            $is_need_jurnal        = $rs_gtbrlsh['is_need_jurnal'];
        }else{
            $status_code           = '500';
            $message               = 'Get Table Relation Gagal! Tabel belum didefinisikan di table `gtbrlsh`';
            $type_message          = 'error';
        }

    }catch(PDOException $e){
        $status_code = '500';
        $message = 'Get Table Relation Gagal! ' . $e->getMessage();
        $type_message          = 'error';
    }

    $data = array(
        'status_code'           => $status_code,
        'message'               => $message,
        'type_message'          => $type_message,
        'tbl_name'              => $tbl_name,
        'is_master_table'       => $is_master_table,
        'is_need_approval'      => $is_need_approval,
        'is_need_generate_kode' => $is_need_generate_kode,
        'is_need_jurnal'        => $is_need_jurnal
    );

    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );
    
	
?>