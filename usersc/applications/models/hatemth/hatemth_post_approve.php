<?php
    require_once( "../../../../users/init.php" );
    require_once( "../../../../usersc/lib/DataTables.php" );
    require_once( "../../../../usersc/helpers/datatables_fn_debug.php" );

    require '../../../../usersc/vendor/autoload.php';
	use Carbon\Carbon;

    // BEGIN definisi variable untuk fn_ajax_results.php
    $data      = array();
    $rs_opt    = array();
    $c_rs_opt  = 0;
    $morePages = 0;
    // END definisi variable untuk fn_ajax_results.php

    $id_transaksi = $_POST['id_transaksi'];
    $approval_state = $_POST['approval_state'];
	
    try{
        $db->transaction();

		$qs_kode = $db
			->raw()
			->bind(':id', $id_transaksi)
			->exec(' SELECT
						a.kode,
						a.id_hemxxmh,
						a.tanggal
					FROM hatemth AS a
					WHERE a.id = :id
					'
					);
		$rs_kode = $qs_kode->fetch();
		$id_hemxxmh = $rs_kode['id_hemxxmh'];
		$tanggal = $rs_kode['tanggal'];
		$kode = $rs_kode['kode'];

		if($approval_state == 1){

			$qi_hemjbrd = $db
			->raw()
				->bind(':id', $id_transaksi)
				->exec('INSERT INTO hemjbrd(
							id_hemxxmh,
							tanggal_awal,
							kode,
							keterangan
						)
						SELECT
							a.id_hemxxmh,
							a.tanggal,
							a.kode,
							b.nama
						FROM hatemth a
						LEFT JOIN hattpmh b ON b.id = a.id_hattpmh
						WHERE a.id = :id;
						'
						);

			$qu_hemjbmh = $db
				->raw()
				->bind(':id_hemxxmh', $id_hemxxmh)
				->bind(':tanggal', $tanggal)
				->exec('UPDATE hemjbmh
						SET 
							tanggal_keluar = :tanggal
						WHERE id_hemxxmh = :id_hemxxmh;
						'
			);

		} else {
			$qd_ = $db
				->query('delete', 'hemjbrd')
				->where('id_hemxxmh',$rs_kode['id_hemxxmh'])
				->where('kode',$rs_kode['kode'])
				->exec();
				
			$qu_hemjbmh = $db
				->raw()
				->bind(':id_hemxxmh', $id_hemxxmh)
				->bind(':tanggal', $tanggal)
				->exec('UPDATE hemjbmh
						SET 
							tanggal_keluar = null
						WHERE id_hemxxmh = :id_hemxxmh;
						'
			);
		}
		
		$db->commit();
        $data = array(
            'message'=> 'Data Berhasil Di Insert' , 
            'type_message'=>'success' 
        );
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