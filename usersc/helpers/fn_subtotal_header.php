<?php
	/**
     * Digunakan untuk menghitung header transaksi
     * - Subtotal   : SUM dpp detail (Dasar Pengenaan Pajak, nilai setelah dikurangi diskon)
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

	$editor = Editor::inst( $db, '' );

    $id_transaksi_h = $_POST['id_transaksi_h'];
    $tabel_detail   = $_POST['tabel_detail'];
    $tabel_header   = $_POST['tabel_header'];
    $id_header      = 'id_'. $tabel_header;

    try{
        $db->transaction();

        $qs_detail = $db
            ->raw()
            ->bind(':id_transaksi_h', $id_transaksi_h)
            ->exec('
                SELECT
                    SUM(dpp) as s_dpp
                FROM '.$tabel_detail.'
                WHERE
                    id_' . $tabel_header . ' = :id_transaksi_h
            ');
        $rs_detail = $qs_detail->fetch();
        $subtotal_header = $rs_detail['s_dpp'];

        $qu_header = $db
            ->raw()
            ->bind(':subtotal_header', $subtotal_header)
            ->bind(':id', $id_transaksi_h)
            ->exec('
                UPDATE '.$tabel_header.' 
                SET subtotal = :subtotal_header
                WHERE 
                    id = :id
            ');

        // commit transaction
        $db->commit();
        $message      = 'Subtotal Header Berhasil Diperbaharui' ;
        $type_message = 'success';

    }catch(PDOException $e){
        // rollback on error
        $db->rollback();
        $message      = 'Subtotal Header Gagal Diperbaharui' ;
        $type_message = 'danger';
    }

    $data = array(
		'subtotal_header' => $subtotal_header,
		'message'      => $message,
		'type_message' => $type_message
	);

    // tampilkan results
    require_once( "fn_ajax_results.php" );
?>