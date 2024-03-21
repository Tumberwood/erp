<?php
	/**
     * Digunakan untuk menghitung konversi UoM
     * Parameter:
     *  table_name      : nama table database yang akan dihitung
     *  id_transaksi    : id transaksi yang akan dihitung
     */
    require_once( "../../users/init.php" );
	require_once( "../../usersc/lib/DataTables.php" );
    require_once( "datatables_fn_debug.php" );    

	use
		DataTables\Editor,
		DataTables\Editor\Query,
		DataTables\Editor\Result;

    // BEGIN definisi variable untuk fn_ajax_results.php
    $data      = array();
    $rs_opt    = array();
    $c_rs_opt  = 0;
    $morePages = 0;
    // END definisi variable untuk fn_ajax_results.php

    $arr_id_files = $_POST['arr_id_files'];
    $nama_tabel = $_POST['nama_tabel'];

    try{
        $db->transaction();

        foreach ($arr_id_files as $key => $id_files) {
            $qu_transaksi = $db
                ->query('update', 'lk_transaksi_files')
                ->set('nama',$nama_tabel)
                ->where('idfiles',$id_files)
                ->exec();
        }

        // commit transaction
        $db->commit();

        $message = 'Update Files Berhasil Diperbaharui';
        $type_message = 'success';
        
    }catch(PDOException $e){
        // rollback on error
        $db->rollback();

        $message = 'Update Files Gagal Berhasil Diperbaharui';
        $type_message = 'success';

    }

    $data = array(
		'message'      => $message,
		'type_message' => $type_message
	);

    // tampilkan results
    require_once( "fn_ajax_results.php" );  
?>