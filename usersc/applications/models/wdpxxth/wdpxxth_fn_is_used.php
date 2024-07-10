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
                    $qs_wdplptd = $db
                        ->query('select', 'wdplptd' )
                        ->get([
                            'id_wpclptd',
                            'jumlah_terkecil'
                            ] )
                        ->where('keterangan', $uniqueToken )
                        ->where('id_wpcxxth', $id_wpcxxth_old )
                        ->where('id_wdpxxth', 0 )
                        ->exec();
                    $rs_wdplptd = $qs_wdplptd->fetchAll();
                    foreach ($rs_wdplptd as $key => $wdplptd) {
                        $id_wpclptd = $wdplptd['id_wpclptd'];
                        $jumlah_terkecil = $wdplptd['jumlah_terkecil'];
        
                        //Update subtotal detail items
                        $qu_wpclptd = $db
                            ->raw()
                            ->bind(':id_wpclptd', $id_wpclptd)
                            ->bind(':jumlah_terkecil', $jumlah_terkecil)
                            ->exec('UPDATE wpclptd a
                                    SET 
                                        a.jumlah_terkecil_os = a.jumlah_terkecil_os + :jumlah_terkecil,
                                        a.jumlah_terkecil_next = a.jumlah_terkecil_next - :jumlah_terkecil,
                                        a.status_dispatch = 
                                            case 
                                                when a.jumlah_terkecil_os = a.jumlah_terkecil then 1
                                                when a.jumlah_terkecil_os = 0 then 3
                                                when a.jumlah_terkecil_os > 0 then 2
                                                ELSE
                                                    1
                                            END
                                    WHERE a.id = :id_wpclptd
                                    ;
                            
                            '
                        );
        
                    }
        
                    $qd_wdplptd = $db
                        ->query('delete', 'wdplptd')
                        ->where('keterangan', $uniqueToken )
                        ->where('id_wpcxxth', $id_wpcxxth_old )
                        ->where('id_wdpxxth', 0 )
                        ->exec();
                        
                    $qd_iivxxrd = $db
                        ->query('delete', 'iivxxrd')
                        ->where('kode', $uniqueToken )
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