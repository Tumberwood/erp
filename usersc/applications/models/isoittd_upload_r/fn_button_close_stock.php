<?php

include( "../../../../users/init.php" );
include( "../../../../usersc/lib/DataTables.php" );
include_once( "../../../helpers/hakakses_s_fn.php" );

use
    DataTables\Editor,
    DataTables\Editor\Query,
    DataTables\Editor\Result;

	$editor = Editor::inst( $db, '' );

    $id_users = $hakakses['s_id_users'];
    $username = $hakakses['s_username'];

    try {
        $db->transaction();

        $id_isoxxth_upload_filter = $_POST['id_isoxxth_upload_filter'];
        $start_button = $_POST['start_button'];

        $qu_closed_stock = $db
            ->raw()
            ->bind(':id_isoxxth_upload_filter', $id_isoxxth_upload_filter)
            ->exec('UPDATE isoxxth_upload a
                    SET
                        a.transaction_state = 9
                    WHERE (a.id = :id_isoxxth_upload_filter OR a.id_isoxxth_upload_parent = :id_isoxxth_upload_filter)
                '
        );

        $end = date('Y-m-d H:i:s');
        $durasi_detik = strtotime($end) - strtotime($start_button);

        $qi_log = $db
            ->raw()
            ->bind(':id_users', $id_users)
            ->bind(':username', $username)
            ->bind(':start_button', $start_button)
            ->bind(':end', $end)
            ->bind(':durasi_detik', $durasi_detik)
            ->bind(':id_isoxxth_upload_filter', $id_isoxxth_upload_filter)
            ->exec('INSERT INTO activity_log_ml
                (
                    id_transaksi,
                    kode,
                    nama,
                    keterangan,
                    created_by,
                    username,
                    start_on,
                    finish_on,
                    durasi_detik
                )
                SELECT 
                    :id_isoxxth_upload_filter,
                    "CLOSED",
                    "isoittd_upload",	
                    "Close Transaction Stock Opname",
                    :id_users,
                    :username,
                    :start_button,
                    :end,
                    :durasi_detik
            '
        );

        $db->commit();
        echo json_encode(array('message' => 'Transaksi Berhasil Diproses', 'type_message' => 'success'));
    } catch (PDOException $e) {
        // rollback on error
        $db->rollback();
        echo json_encode(array('message' => 'Transaksi Gagal Diproses! ' . $e->getMessage(), 'type_message' => 'danger'));
    }
    
	
?>