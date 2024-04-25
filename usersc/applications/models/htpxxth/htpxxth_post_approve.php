<?php 
    require_once( "../../../../users/init.php" );
	require_once( "../../../../usersc/lib/DataTables.php" );
	require_once( "../../../../usersc/helpers/datatables_fn_debug.php" );

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

    $state          = $_POST['state'];
    // print_r($state);
    $id_htpxxth = $_POST['id_transaksi_h'];
    
    try{
        $db->transaction();

		if($state == 1){
			$qs_htpxxth = $db
				->query('select', 'htpxxth' )
				->get([
					'htpxxth.id as id_transaksi',
					'htpxxth.id_hemxxmh as id_hemxxmh',
					'htpxxth.id_httlpmh as id_httlpmh',
					'htpxxth.kode as kode',
					'htpxxth.tanggal as tanggal',
					'htpxxth.keterangan as keterangan',
					'htpxxth.jam_awal as jam_awal',
					'htpxxth.jam_akhir as jam_akhir',
					'httlpmh.kode as httlpmh_kode'
				] )
				->join('hemxxmh','hemxxmh.id = htpxxth.id_hemxxmh','LEFT' )
				->join('httlpmh','httlpmh.id = htpxxth.id_httlpmh','LEFT' )
				->where('htpxxth.id', $id_htpxxth )
				->exec();

			$rs_htpxxth = $qs_htpxxth->fetch();
			
			// $tanggal  = Carbon::parse($rs_htpxxth['tanggal']);
				
			$qi = $db
				->query('insert', 'httxxrd')
				->set('id_transaksi', $rs_htpxxth['id_transaksi'] )
				->set('id_httlpmh', $rs_htpxxth['id_httlpmh'] )
				->set('id_hemxxmh', $rs_htpxxth['id_hemxxmh'] )
				->set('kode', $rs_htpxxth['kode'] )
				->set('approval_state', $state )
				->set('transaction_state', 1 )
				// ->set('tanggal', $tanggal->format('Y-m-d') )
				->set('tanggal', $rs_htpxxth['tanggal'] )
				->set('keterangan', $rs_htpxxth['keterangan'] )
				->set('jenis', 2 )
				->set('httlpmh_kode', $rs_htpxxth['httlpmh_kode'] )
				->set('jumlah', 1 )
				->set('jam_awal', $rs_htpxxth['jam_awal'] )
				->set('jam_akhir', $rs_htpxxth['jam_akhir'] )
				->exec();

				
		}elseif($state == -1){
			$qd_httxxrd = $db
				->query('delete', 'httxxrd')
				->where('id_transaksi', $id_htpxxth )
				->where('jenis', 2 )
				->exec();

		}elseif($state == -9){
			$qu_httxxrd = $db
				->query('update', 'httxxrd')
				->set('is_approve', $state)
				->where('id_transaksi', $id_htpxxth )
				->where('jenis', 2 )
				->exec();
		}

        //Update Approval state manual
        $qu_httgltd = $db
            ->query('update', 'htpxxth')
            ->set('approval_state',$state)
            ->where('id',$_POST['id_transaksi_h'])
            ->exec();

        $db->commit();
        $data = array(
            'message'=> 'Data Berhasil Di Insert' , 
            'type_message'=>'success' )
        ;
    }catch(PDOException $e){
        // rollback on error
        $db->rollback();
        $data = array(
            'message'=>'Data Gagal Di Insert', 
            'type_message'=>'danger' 
        );
    }
   
    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>