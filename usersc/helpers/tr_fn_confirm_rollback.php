<?php
    require_once( "../../users/init.php" );
	require_once( "../../usersc/lib/DataTables.php" );
    require_once( "datatables_fn_debug.php" );
    require_once( "hakakses_s_fn.php" );
    
    // BEGIN definisi variable untuk fn_ajax_results.php
    $data      = array();
    $rs_opt    = array();
    // END definisi variable untuk fn_ajax_results.php

    $message = '';

    $state                       = $_POST['state'];
    $id_transaksi                = $_POST['id_transaksi'];
    $table_name                  = $_POST['table_name'];
    $is_error                    = $_POST['is_error'];
    $is_update_transaction_state = $_POST['is_update_transaction_state'];
    $is_generate_kode            = $_POST['is_generate_kode'];
    $is_inventory                = $_POST['is_inventory'];
    $is_jurnal                   = $_POST['is_jurnal'];
    $is_post_confirm             = $_POST['is_post_confirm'];

    if($is_update_transaction_state == 1){
        // rollback
        $qu_transaction_state = $db
            ->query('update', $table_name )
            ->set('transaction_state',0)
            ->where('id',$id_transaksi)
            ->exec();

        $qd_activity_log_ml = $db
            ->query('delete', 'activity_log_ml')
            ->where('kode','CONFIRM')
            ->where('nama',$table_name)
            ->where('id_transaksi',$id_transaksi)
            ->exec();

        $message = $message . 'Rollback Transaction State Berhasil' . '</br>';
    }

    if($is_generate_kode == 1){
        $qu_kode = $db
            ->query('update', $table_name )
            ->set('kode',null)
            ->where('id',$id_transaksi)
            ->exec();

        $message = $message . 'Rollback Generate Kode Berhasil' . '</br>';
    }

    if($is_inventory == 1){
        $qd_iivxxrd = $db
            ->query('delete', 'activity_log_ml')
            ->where('imtxxmh_kode', 111 )
            ->where('id_transaksi_h',$id_transaksi)
            ->exec();
        $message = $message . 'Rollback Inventory Berhasil' . '</br>';
    }

    if($is_jurnal == 1){

        $message = $message . 'Rollback Jurnal Berhasil' . '</br>';
        
    }

    if($is_post_confirm == 1){

        $message = $message . 'Rollback Post Confirm Berhasil' . '</br>';
        
    }

    $data = array(
		'status_code'  => 200,
		'message'      => $message,
		'type_message' => 'success',
		// 'table_name' => $table_name
        'state'                       => $state,
        'id_transaksi'                => $id_transaksi,
        'table_name'                  => $table_name,
        'is_error'                    => $is_error,
        'is_update_transaction_state' => $is_update_transaction_state,
        'is_generate_kode'            => $is_generate_kode,
        'is_inventory'                => $is_inventory,
        'is_jurnal'                   => $is_jurnal,
        'is_post_confirm'             => $is_post_confirm
	);

    require_once( "fn_ajax_results.php" );
	
?>