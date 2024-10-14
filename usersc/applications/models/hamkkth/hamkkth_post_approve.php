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
						a.jenis,
						b.id id_hesxxmh,
						a.id_hemxxmh
					FROM hamkkth AS a
					LEFT JOIN hesxxmh b ON b.nama = a.jenis
					WHERE a.id = :id
					'
					);
		$rs_kode = $qs_kode->fetch();
		$id_hesxxmh = $rs_kode['id_hesxxmh'];
		$id_hemxxmh = $rs_kode['id_hemxxmh'];
		$jenis = $rs_kode['jenis'];

		if($approval_state == 1){

			$qi_hemjbrd = $db
			->raw()
				->bind(':id', $id_transaksi)
				->exec('INSERT INTO hemjbrd(
							id_hemxxmh,
							id_hesxxmh,
							tanggal_awal,
							kode,
							keterangan
						)
						SELECT
							a.id_hemxxmh,
							b.id,
							a.tanggal_mulai,
							a.kode,
							a.jenis
						FROM hamkkth a
						LEFT JOIN hesxxmh b ON b.nama = a.jenis
						WHERE a.id = :id;
						'
						);

			$qu_hemjbmh = $db
				->raw()
				->bind(':id_hemxxmh', $id_hemxxmh)
				->bind(':id_hesxxmh', $id_hesxxmh)
				->bind(':jenis', $jenis)
				->exec('UPDATE hemjbmh
						SET 
							id_hesxxmh = :id_hesxxmh,
							id_heyxxmh = IF(:jenis = "PKWTT", 1, id_heyxxmh)
						WHERE id_hemxxmh = :id_hemxxmh;
						'
			);

		} else {
			$qd_ = $db
				->query('delete', 'hemjbrd')
				->where('id_hemxxmh',$rs_kode['id_hemxxmh'])
				->where('kode',$rs_kode['kode'])
				->exec();
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