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
    
    $tabel   = $_POST['tabel'];
    $id_tabel = $_POST['id_tabel'];

    try{
        $db->transaction();

        $sql_update = $editor->db()
            ->raw()
            ->exec('UPDATE '.$tabel.' AS a
                    LEFT JOIN iimummd AS b ON b.id_iumxxmh = a.id_iumxxmh AND b.id_iimxxmh = a.id_iimxxmh
                    SET
                        a.jumlah_konversi = b.jumlah_konversi,
                        a.jumlah_terkecil = ROUND(b.jumlah_konversi * a.jumlah_unit, 2), 
                        a.harga_terkecil = ROUND(a.harga_unit / (b.jumlah_konversi * a.jumlah_unit), 2)
                    WHERE a.id = '.$id_tabel.'
                    ;
                    '
                    );
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