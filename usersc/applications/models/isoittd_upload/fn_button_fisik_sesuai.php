<?php

include( "../../../../users/init.php" );
include( "../../../../usersc/lib/DataTables.php" );
include_once( "../../../helpers/hakakses_s_fn.php" );

use
    DataTables\Editor,
    DataTables\Editor\Query,
    DataTables\Editor\Result;

	$editor = Editor::inst( $db, '' );
    $start_at = date('Y-m-d H:i:s');
    
    $id_users = $hakakses['s_id_users'];
    $username = $hakakses['s_username'];

    try {
        $db->transaction();

        $id_h = $_POST['id_transaksi_h'];

        $qu_def = $db
            ->raw()
            ->bind(':id_h', $id_h)
            ->exec('    UPDATE isoittd_upload AS b
                        SET 
                            b.fisik = b.jumlah_terkecil,
                            b.selisih = 0
                        WHERE b.id = :id_h
        ');

        $qi_det = $db
            ->raw()
            ->bind(':id_h', $id_h)
            ->exec('    INSERT INTO isoittd_upload_fisik (
                            id_isoittd_upload,
                            fisik
                        )
                        SELECT
                            b.id,
                            b.jumlah_terkecil
                        FROM isoittd_upload as b
                        WHERE b.id = :id_h
        ');

        $id_det = $qi_det->insertId();

        $end = date('Y-m-d H:i:s');
        $durasi_detik = strtotime($end) - strtotime($start_at);

        $qi_log = $db
            ->raw()
            ->bind(':id_users', $id_users)
            ->bind(':username', $username)
            ->bind(':start_at', $start_at)
            ->bind(':end', $end)
            ->bind(':durasi_detik', $durasi_detik)
            ->bind(':id_det', $id_det)
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
                    :id_det,
                    "CREATE",
                    "isoxxth_upload",	
                    "DARI BUTTON FISIK SESUAI",
                    :id_users,
                    :username,
                    :start_at,
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