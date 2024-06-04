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
            $id_hcdxxmh = $_POST['id_hcd'];

            $qu_hcdxxmh = $db
                ->query('update', 'hcdxxmh')
                ->set('transaction_state',1)
                ->where('id',$id_hcdxxmh)
                ->exec();

            $db->commit();
            echo json_encode(
                array(
                        'message'=> 'Berhasil Menambahkan Data Kandidat' , 
                        'type_message'=>'success',
                        'id_hcdxxmh'=> $id_hcdxxmh
                    )
            );
        }catch (PDOException $e){
            $db->rollback();
            echo json_encode(array('message'=> 'Gagal Menambahkan Data Kandidat ' . $e , 'type_message'=>'danger','id_hcdxxmh'=> 0 ));
        }

?>