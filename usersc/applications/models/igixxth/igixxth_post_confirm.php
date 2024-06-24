<?php
    /**
     * Digunakan untuk menghitung hpp
     */
	include( "../../../../users/init.php" );
	include( "../../../../usersc/lib/DataTables.php" );
	include( "../../../../usersc/helpers/datatables_fn_debug.php" );
    require '../../../../usersc/vendor/autoload.php';

    use Carbon\Carbon;
	
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
	
	$id = $_POST['id_transaksi'];
	$state = $_POST['state'];


    try{
        $db->transaction();
        
        if($state == 1){
            $qs_igiittd = $db
                ->query('select', 'igiittd' )
                ->get([
                    'igiittd.id as id_igiittd',
                    'igiittd.id_iimxxmh as id_iimxxmh'
                ] )
                ->where('igiittd.id_igixxth', $id )
                ->exec();
            $rs_igiittd = $qs_igiittd->fetchAll();

            $amount = 0;
            foreach ($rs_igiittd as $row_igiittd) {
                $qs_iivxxrd = $db
                    ->query('select', 'iivxxrd' )
                    ->get([
                        'SUM(iivxxrd.jumlah_terkecil * iivxxrd.hpp ) / SUM(iivxxrd.jumlah_terkecil ) as hpp'
                    ] )
                    ->where('iivxxrd.id_iimxxmh', $row_igiittd['id_iimxxmh'] )
                    ->exec();
                $rs_iivxxrd = $qs_iivxxrd->fetch();
                if(!empty($rs_iivxxrd)){
                    $hpp = $rs_iivxxrd['hpp'];
                }else{
                    // harusnya tidak ada.
                    $hpp = 0;
                }

                $qu_igiittd = $db
                    ->query('update', 'igiittd')
                    ->set('hpp',$hpp)
                    ->where('id',$row_igiittd['id_igiittd'])
                    ->exec();

                $qu_iivxxrd = $db
                    ->query('update', 'iivxxrd')
                    ->set('hpp',$hpp)
                    ->where('imtxxmh_kode', 203)
                    ->where('id_transaksi_h', $id)
                    ->where('id_transaksi_d', $row_igiittd['id_igiittd'])
                    ->exec();

                $amount = $amount + $hpp;

            }

            $qu_igixxth = $db
                ->query('update', 'igixxth')
                ->set('amount',$amount)
                ->where('id',$id)
                ->exec();

        }else{

        }

        if(!empty($qu_igixxth)){
            $db->commit();
            $status_code  = '200';
            $message      = 'Perhitungan HPP Berhasil Dilakukan';
            $type_message = 'success';
            // parameter lain
        }else{
            $db->rollback();
            $status_code  = '500';
            $message      = 'Perhitungan HPP Gagal Dilakukan!';
            $type_message = 'error';
            // parameter lain
        }
    }catch(PDOException $e){
        $db->rollback();
        $status_code  = '500';
        $message      = 'Perhitungan HPP Gagal Dilakukan! ' . $e->getMessage();
        $type_message = 'error';
    }catch (Exception $e) {
        $db->rollback();
        $status_code = 500;
        $message = 'Perhitungan HPP Gagal Dilakukan!, ' . $e->getMessage();
        $type_message = 'error';
    }
    // build response
    $data = array(
        'status_code'    => $status_code,
        'message'        => $message,
        'type_message'   => $type_message
    );

	// tampilkan results
    include( "../../../../usersc/helpers/fn_ajax_results.php" );

?>