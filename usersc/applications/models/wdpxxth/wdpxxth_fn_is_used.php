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

            $qi_iivxxrd = $db
			->query('update', 'wpcxxth')
            ->set('is_in_use',$is_in_use)
			->where('id',$id_wpcxxth_old)
			->exec();

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