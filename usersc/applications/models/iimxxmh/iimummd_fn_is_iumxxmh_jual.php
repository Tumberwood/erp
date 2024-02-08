<?php
	include_once( "../../../../users/init.php" );
	include_once( "../../../../usersc/lib/DataTables.php" );
	include_once( "../../../../usersc/vendor/autoload.php");
	include_once( "../../../helpers/hakakses_s_fn.php" );
	
	use
		DataTables\Editor,
		DataTables\Editor\Field,
		DataTables\Editor\Format,
		DataTables\Editor\Mjoin,
		DataTables\Editor\Options,
		DataTables\Editor\Upload,
		DataTables\Editor\Validate,
		DataTables\Editor\ValidateOptions,
		DataTables\Editor\SearchPaneOptions,
		DataTables\Editor\Query,
		DataTables\Editor\Result;

	use 
		Carbon\Carbon;
	
	// BEGIN definisi variable untuk fn_ajax_results.php
    $data      = array();
    $rs_opt    = array();
    $c_rs_opt  = 0;
    $morePages = 0;
    // END definisi variable untuk fn_ajax_results.php

    $id_transaksi_h         = $_POST['id_transaksi_h'];
    $id_transaksi_default   = $_POST['id_transaksi_default'];

    try{
        $db->transaction();

        $sql_update = $db
            ->raw()
            ->bind(':id_transaksi_h', $id_transaksi_h)
            ->bind(':id_transaksi_default', $id_transaksi_default)
            ->exec('
                UPDATE iimummd
                SET
                    is_iumxxmh_jual = 0
                WHERE 
                    '.$field_id_transaksi_h.' = :id_transaksi_h AND
                    id <> :id_transaksi_default
            ');

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
		'id_transaksi_h'       => $id_transaksi_h,
		'id_transaksi_default' => $id_transaksi_default,
		'message'              => $message,
		'type_message'         => $type_message
	);

    // tampilkan results
    include_once( "../../../helpers/fn_ajax_results.php" );
?>