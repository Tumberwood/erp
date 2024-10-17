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
    include( "../../../../users/init.php" );
	include( "../../../../usersc/lib/DataTables.php" );
    include( "../../../helpers/datatables_fn_debug.php" );  
    
    use Carbon\Carbon; 
    
    use
		DataTables\Editor,
		DataTables\Editor\Query,
		DataTables\Editor\Result;

	$editor = Editor::inst( $db, '' );
    
    $id_hcd   = $_POST['id_hcd'];
    $tanggal   = $_POST['tanggal'];

    try{
        $db->transaction();

        $sql_insert = $editor->db()
            ->query('insert', 'hrctsth_disc')
            ->set('status', 0)
            ->set('id_hcdxxmh', $id_hcd )
            ->set('tanggal', $tanggal )
            ->exec();
        
        // commit transaction
        $db->commit();
        echo json_encode(array('message'=> $message_success  , 'type_message'=>'success' ));
    }catch(PDOException $e){
        // rollback on error
        $db->rollback();
        echo json_encode(array('message'=> $message_error, 'type_message'=>'danger' ));
    }

    // print_r($debug);
?>