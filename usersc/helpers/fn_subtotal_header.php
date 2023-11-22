<?php
	/*
        220827 - 2.0.0
            Mengubah query dengan menggunakan class bawaan dari datatables.

		Kegunaan:
            - Mengubah is_active transaksi menjadi 0 (menandakan data tidak aktif)
            - Insert log ke table activity_log_ml
		
        Parameter:
            - $table_name
		    - $id_transaksi
	*/
    include_once( "../../users/init.php" );
	include_once( "../../usersc/lib/DataTables.php" );
    include( "datatables_fn_debug.php" );   
    use
		DataTables\Editor,
		DataTables\Editor\Query,
		DataTables\Editor\Result;

	$editor = Editor::inst( $db, '' );
    
    $id_transaksi_h   = $_POST['id_transaksi_h'];
    $is_dpp   = 0;
    if (isset($_POST['is_dpp']) && !empty($_POST['is_dpp'])) {
        $is_dpp   = $_POST['is_dpp'];
    }
    $detail = $_POST['detail'];
    $header = $_POST['header'];
    $id_header = 'id_'. $header;

    try{
        $db->transaction();

        $sql_update = $editor->db()
            ->raw()
            ->exec('UPDATE '.$header.' AS a
                    LEFT JOIN (
                        SELECT '.$id_header.', SUM(dpp) AS total_dpp
                        FROM '.$detail.'
                        GROUP BY '.$id_header.'
                    ) AS b ON b.'.$id_header.' = a.id
                    SET a.subtotal = COALESCE(b.total_dpp, 0)
                    WHERE a.id = '.$id_transaksi_h.'
                    ;
                    '
                    );

        if ($is_dpp > 0) {
            $sql_update = $editor->db()
                ->raw()
                ->exec('UPDATE '.$header.' AS a
                        LEFT JOIN (
                            SELECT '.$id_header.', SUM(dpp) AS total_dpp
                            FROM '.$detail.'
                            GROUP BY '.$id_header.'
                        ) AS b ON b.'.$id_header.' = a.id
                        SET a.dpp = COALESCE(b.total_dpp, 0) - a.diskon_final
                        WHERE a.id = '.$id_transaksi_h.'
                        ;
                        '
                        );
        }
        // commit transaction
        $db->commit();
        echo json_encode(array('message'=> 'Subtotal Header Berhasil Diperbaharui'  , 'type_message'=>'success' ));
    }catch(PDOException $e){
        // rollback on error
        $db->rollback();
        echo json_encode(array('message'=> 'Subtotal Header Gagal Diperbaharui', 'type_message'=>'danger' ));
    }

    // print_r($debug);
?>