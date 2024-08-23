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

        $id_h = $_POST['id_transaksi_h'];
        $start_button = $_POST['start_button'];

        $qu_def = $db
            ->raw()
            ->bind(':id_h', $id_h)
            ->exec('    UPDATE isoittd_upload AS b
                        SET 
                            b.is_skip = 1
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