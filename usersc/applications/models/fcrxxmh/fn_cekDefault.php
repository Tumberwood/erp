<?php
    require_once( "../../../../users/init.php" );
	require_once( "../../../../usersc/lib/DataTables.php" );
	require_once( "../../../../usersc/helpers/datatables_fn_debug.php" );

    require '../../../../usersc/vendor/autoload.php';  
    use
		DataTables\Editor,
		DataTables\Editor\Query,
		DataTables\Editor\Result;

	$editor = Editor::inst( $db, '' );
    
    $id_tabel   = $_POST['id_tabel'];

    try{
        $db->transaction();

        
		$qs_def = $db
            ->raw()
            ->bind(':id_tabel', $id_tabel)
            ->exec(' SELECT
                        is_default
                    FROM fcrxxmh
                    WHERE id = :id_tabel
                    '
                    );
        $rs_def = $qs_def->fetch();
        
        if ($rs_def['is_default'] == 1) {
            $sql_update = $editor->db()
                ->raw()
                ->bind(':id_tabel', $id_tabel)
                ->exec('UPDATE fcrxxmh AS a
                        SET
                            a.is_default = 0
                        WHERE a.id <> '.$id_tabel.'
                        ;
                        '
                        );
        }

        // commit transaction
        $db->commit();
        echo json_encode(array('message'=> 'Konversi Terkecil Berhasil Diperbaharui'  , 'type_message'=>'success' ));
    }catch(PDOException $e){
        // rollback on error
        $db->rollback();
        echo json_encode(array('message'=> 'Konversi Terkecil Gagal Diperbaharui', 'type_message'=>'danger' ));
    }

    // print_r($debug);
?>