<?php
	include( "../../../../users/init.php" );
	include( "../../../../usersc/lib/DataTables.php" );
	include( "../../../../usersc/helpers/datatables_fn_debug.php" );
	
    require_once('../../../../usersc/vendor/autoload.php');
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
    
        try{
            $db->transaction();
            $data_input = file_get_contents("php://input");

            // Decode JSON data
            $json_input = json_decode($data_input, true);

            // Access the 'id_hcd' value
            $id_wpcxxth_old = $json_input['id_wpcxxth_old'];
            $is_in_use = $json_input['is_in_use'];
            $uniqueToken = $json_input['uniqueToken'];

            $qi_iivxxrd = $db
			->query('update', 'wpcxxth')
            ->set('is_in_use',$is_in_use)
			->where('id',$id_wpcxxth_old)
			->exec();

            $qs_ggswmsh = $db
                ->query('select', 'ggswmsh' )
                ->get(['is_delete_reload'] )
                ->where('id', 1 )
                ->exec();
            $rs_ggswmsh = $qs_ggswmsh->fetch();
            $is_delete_reload = $rs_ggswmsh['is_delete_reload'];

            //jika di setting wms is_delete_reload = 1 maka hapus data terkait dengan transaksi sekarang
            if ($is_delete_reload == 1) {
                //jika di reload maka hapus data
                if ($is_in_use == 0) {
                    $qs_wpclptd = $db
                        ->query('select', 'wpclptd' )
                        ->get([
                            'id_wktlptd',
                            'jumlah_terkecil'
                            ] )
                        ->where('keterangan', $uniqueToken )
                        ->where('id_wpcxxth', $id_wpcxxth_old )
                        ->exec();
                    $rs_wpclptd = $qs_wpclptd->fetchAll();
                    foreach ($rs_wpclptd as $key => $wpclptd) {
                        $id_wktlptd = $wpclptd['id_wktlptd'];
                        $jumlah_terkecil = $wpclptd['jumlah_terkecil'];
        
                        //Update subtotal detail items
                        $qu_wktlptd = $db
                            ->raw()
                            ->bind(':id_wktlptd', $id_wktlptd)
                            ->bind(':jumlah_terkecil', $jumlah_terkecil)
                            ->exec('UPDATE wktlptd a
                                    SET 
                                        a.jumlah_terkecil_os = a.jumlah_terkecil_os + :jumlah_terkecil,
                                        a.jumlah_terkecil_next = a.jumlah_terkecil_next - :jumlah_terkecil,
                                        a.status_picking = 
                                            case 
                                                when a.jumlah_terkecil_os = a.jumlah_terkecil then 1
                                                when a.jumlah_terkecil_os = 0 then 3
                                                when a.jumlah_terkecil_os > 0 then 2
                                                ELSE
                                                    1
                                            END
                                    WHERE a.id = :id_wktlptd
                                    ;
                            
                            '
                        );
        
                    }
        
                    $qd_wpclptd = $db
                        ->query('delete', 'wpclptd')
                        ->where('keterangan', $uniqueToken )
                        ->where('id_wpcxxth', $id_wpcxxth_old )
                        ->exec();
                        
                    $qd_iivxxrd = $db
                        ->query('delete', 'iivxxrd')
                        ->where('kode', $uniqueToken )
                        ->where('id_transaksi_h', $id_wpcxxth_old )
                        ->exec();
                }
            }


            $db->commit();
            echo json_encode(
                array(
                        'message'=> 'Berhasil Mengubah Status Picking' , 
                        'type_message'=>'success',
                        'keterangan'=> $keterangan
                    )
            );
        }catch (PDOException $e){
            $db->rollback();
            echo json_encode(array('message'=> 'Gagal Menghapus Data Kandidat ' . $e , 'type_message'=>'danger','id_hcdxxmh'=> 0 ));
        }

?>