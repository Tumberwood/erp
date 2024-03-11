<?php
    /**
     * isDefaultUpdateD
     * Digunakan untuk update field is_default
     * Parameter:
     *  @param object   $db database connection, biasanya diisi $editor->db()
     *  @param string   $tbl_name
     *  @param string   $id_transaksi_h
     *  @param string   $id_transaksi_default
     *  @param string   $action : CREATE | EDIT | REMOVE
     * 
     */

    function isDefaultUpdateD( $db, $tbl_name, $id_transaksi_h, $id_transaksi_default, $action ){

        if($action != 'REMOVE'){

            // BEGIN select table relation
            $qs_gtbrlsh = $db
                ->raw()
                ->bind(':tbl_name', '%'.$tbl_name.'%')
                ->exec('
                    SELECT 
                        tblheader
                    FROM gtbrlsh
                    WHERE 
                        tbldetails LIKE :tbl_name
                ');
            $rs_gtbrlsh           = $qs_gtbrlsh->fetch();
            $field_id_transaksi_h = 'id_' . $rs_gtbrlsh['tblheader'];
            // END select table relation
            
            $qu = $db
                ->raw()
                ->bind(':id_transaksi_h', $id_transaksi_h)
                ->bind(':id_transaksi_default', $id_transaksi_default)
                ->exec('
                    UPDATE '.$tbl_name.'
                    SET
                        is_default = 0
                    WHERE 
                        '.$field_id_transaksi_h.' = :id_transaksi_h AND
                        id <> :id_transaksi_default
                ');
            

        }else{
            

                
        }

        if($qu){
            $status_code  = 200;
            $message      = 'Update Default Berhasil Dilakukan';
            $type_message = 'success';
        }else{
            $status_code  = 500;
            $message      = 'Update Default Gagal Dilakukan!';
            $type_message = 'error';
        }
    }
    

?>