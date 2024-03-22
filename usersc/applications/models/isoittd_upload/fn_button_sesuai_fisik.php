<?php

include( "../../../../users/init.php" );
include( "../../../../usersc/lib/DataTables.php" );

use
    DataTables\Editor,
    DataTables\Editor\Query,
    DataTables\Editor\Result;

	$editor = Editor::inst( $db, '' );

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

        $db->commit();
        echo json_encode(array('message' => 'Transaksi Berhasil Diproses', 'type_message' => 'success'));
    } catch (PDOException $e) {
        // rollback on error
        $db->rollback();
        echo json_encode(array('message' => 'Transaksi Gagal Diproses! ' . $e->getMessage(), 'type_message' => 'danger'));
    }
    
	
?>