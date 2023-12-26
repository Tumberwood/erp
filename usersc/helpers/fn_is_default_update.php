<?php
    /**
     * Digunakan untuk mengubah nilai is_default (biasanya pada table master)
     * Syarat: 
     *  dalam 1 table hanya ada 1 baris data yang is_default = 1
     * Parameter:
     *  table_name          : nama table yang akan diubah value data is_default nya
     *  id_transaksi_default: id baris data yang akan menjadi default baru
     */

     /**
      * Log Changes 
      * Create by       : Ferry
      * Modified by     : Danny
      * Last Modified   : 26 Dec 2023
      */

    require_once( "../../usersc/lib/DataTables.php" );
    require_once( "datatables_fn_debug.php" );
    require_once( "../../usersc/vendor/autoload.php" );
    
    use
		DataTables\Editor,
		DataTables\Editor\Query,
		DataTables\Editor\Result;

	$editor = Editor::inst( $db, '' );
    
    $table_name             = $_POST['table_name'];
    $id_transaksi_default   = $_POST['id_transaksi_default'];

    try{
        $db->transaction();
        
		$qs_def = $db
            ->raw()
            ->bind(':id_transaksi_default', $id_transaksi_default)
            ->exec('
                SELECT
                    is_default
                FROM '.$table_name.' 
                WHERE id = :id_transaksi_default
            ');
        $rs_def = $qs_def->fetch();
        
        if ($rs_def['is_default'] == 1) {
            $sql_update = $editor->db()
                ->raw()
                ->bind(':id_transaksi_default', $id_transaksi_default)
                ->exec('
                    UPDATE '.$table_name.' AS a
                    SET
                        a.is_default = 0
                    WHERE a.id <> :id_transaksi_default
                ');
        }

        // commit transaction
        $db->commit();
        echo json_encode(array('message'=> 'Default Data Berhasil Diperbaharui'  , 'type_message'=>'success' ));
    }catch(PDOException $e){
        // rollback on error
        $db->rollback();
        echo json_encode(array('message'=> 'Default Data Gagal Diperbaharui', 'type_message'=>'danger' ));
    }

?>