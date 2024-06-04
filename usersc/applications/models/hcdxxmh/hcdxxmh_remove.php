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
            $id_hcdxxmh = $json_input['id_hcd'];

            
            $qu_hcdfmmd = $db
                ->query('delete', 'hcdfmmd')
                // ->where('id_hcdxxmh', 1717483383)
                ->where('id_hcdxxmh', $id_hcdxxmh)
                ->exec();

            $qu_hcdedmd = $db
                ->query('delete', 'hcdedmd')
                ->where('id_hcdxxmh', $id_hcdxxmh)
                ->exec();

            $qu_hcdjbmd = $db
                ->query('delete', 'hcdjbmd')
                ->where('id_hcdxxmh', $id_hcdxxmh)
                ->exec();

            $qu_hcdogmd = $db
                ->query('delete', 'hcdogmd')
                ->where('id_hcdxxmh', $id_hcdxxmh)
                ->exec();

            $qu_hcddhmd = $db
                ->query('delete', 'hcddhmd')
                ->where('id_hcdxxmh', $id_hcdxxmh)
                ->exec();

            $qu_hcdecmd = $db
                ->query('delete', 'hcdecmd')
                ->where('id_hcdxxmh', $id_hcdxxmh)
                ->exec();

            $qu_hcdtrmd = $db
                ->query('delete', 'hcdtrmd')
                ->where('id_hcdxxmh', $id_hcdxxmh)
                ->exec();

            $qu_hcdlgmd = $db
                ->query('delete', 'hcdlgmd')
                ->where('id_hcdxxmh', $id_hcdxxmh)
                ->exec();

            $qu_hcdrfmd = $db
                ->query('delete', 'hcdrfmd')
                ->where('id_hcdxxmh', $id_hcdxxmh)
                ->exec();

            $db->commit();
            echo json_encode(
                array(
                        'message'=> 'Berhasil Menghapus Data Kandidat' , 
                        'type_message'=>'success',
                        'id_hcdxxmh'=> $id_hcdxxmh
                    )
            );
        }catch (PDOException $e){
            $db->rollback();
            echo json_encode(array('message'=> 'Gagal Menghapus Data Kandidat ' . $e , 'type_message'=>'danger','id_hcdxxmh'=> 0 ));
        }

?>