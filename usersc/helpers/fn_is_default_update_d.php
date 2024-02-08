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

      require_once( "../../users/init.php" );
      require_once( "../../usersc/lib/DataTables.php" );
      require_once( "datatables_fn_debug.php" );
      require_once( "hakakses_s_fn.php" );
  
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
    
    $table_name             = $_POST['table_name'];
    $id_transaksi_h         = $_POST['id_transaksi_h'];
    $id_transaksi_default   = $_POST['id_transaksi_default'];

    try{
        $db->transaction();

        // BEGIN select table relation
        $qs_gtbrlsh = $db
            ->raw()
            ->bind(':table_name', '%'.$table_name.'%')
            ->exec('
                SELECT 
                    tblheader
                FROM gtbrlsh
                WHERE 
                    tbldetails LIKE :table_name
            ');
        $rs_gtbrlsh = $qs_gtbrlsh->fetch();
        $field_id_transaksi_h = 'id_' . $rs_gtbrlsh['tblheader'];
        // END select table relation
        
        $sql_update = $db
            ->raw()
            ->bind(':id_transaksi_h', $id_transaksi_h)
            ->bind(':id_transaksi_default', $id_transaksi_default)
            ->exec('
                UPDATE '.$table_name.'
                SET
                    is_default = 0
                WHERE 
                    '.$field_id_transaksi_h.' = :id_transaksi_h AND
                    id <> :id_transaksi_default
            ');

        // commit transaction
        $db->commit();
        
        $message = 'Default Data Berhasil Diperbaharui';
        $type_message = 'success';

    }catch(PDOException $e){
        // rollback on error
        $db->rollback();
        
        $message = 'Default Data Gagal Diperbaharui';
        $type_message = 'danger';
    }

    $data = array(
		'id_transaksi_h'      => $id_transaksi_h,
		'id_transaksi_default'      => $id_transaksi_default,
		'message'      => $message,
		'type_message' => $type_message
	);

    // tampilkan results
    require_once( "fn_ajax_results.php" );
?>