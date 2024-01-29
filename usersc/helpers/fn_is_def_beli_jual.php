<?php
    /**
     * Digunakan untuk mengubah nilai is_default (biasanya pada table master)
     * Syarat: 
     *  dalam 1 table hanya ada 1 baris data yang is_default = 1
     * Parameter:
     *  table_name          : nama table yang akan diubah value data is_default nya
     *  id_transaksi_default: id baris data yang akan menjadi default baru
     */

     /**
      * Log Changes 
      * Create by       : Ferry
      * Modified by     : Danny
      * Last Modified   : 26 Dec 2023
      */

    require_once( "../../users/init.php" );
    require_once( "../../usersc/lib/DataTables.php" );
    require_once( "datatables_fn_debug.php" );
    require_once( "hakakses_s_fn.php" );

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

    $field_name             = $_POST['field_name'];
    $id_transaksi_default   = $_POST['id_transaksi_default'];

    try{
        $db->transaction();
            // mengubah baris data menjadi is_default = 1, selain baris data yang dijadikan is_default = 1
            $sql_update = $db
                ->raw()
                ->bind(':id_transaksi_default', $id_transaksi_default)
                ->exec('
                    UPDATE iimummd
                    SET
                        '.$field_name.' = 0
                    WHERE 
                        id <> :id_transaksi_default
                ');
        // }

        // commit transaction
        $db->commit();
        $message = 'Default Data Berhasil Diperbaharui';
        $type_message = 'success';

    }catch(PDOException $e){
        // rollback on error
        $db->rollback();
        $message = 'Default Data Gagal Diperbaharui';
        $type_message = 'danger';

    }

    $data = array(
		'message'      => $message,
		'type_message' => $type_message
	);

    // tampilkan results
    require_once( "fn_ajax_results.php" );

?>