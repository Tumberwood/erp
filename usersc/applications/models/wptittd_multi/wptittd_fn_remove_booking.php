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
            $keterangan = $json_input['keterangan'];

            $qi_iivxxrd = $db
			->query('delete', 'iivxxrd')
			->where('keterangan',$keterangan)
			->exec();

            $db->commit();
            echo json_encode(
                array(
                        'message'=> 'Berhasil Menghapus Data Kandidat' , 
                        'type_message'=>'success',
                        'keterangan'=> $keterangan
                    )
            );
        }catch (PDOException $e){
            $db->rollback();
            echo json_encode(array('message'=> 'Gagal Menghapus Data Kandidat ' . $e , 'type_message'=>'danger','id_hcdxxmh'=> 0 ));
        }

?>