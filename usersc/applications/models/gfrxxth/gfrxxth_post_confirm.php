<?php
	
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

	// (ROW_NUMBER() OVER (ORDER BY a.id) * (ROW_NUMBER() OVER (ORDER BY a.id) - 1)) / 2 AS result

	try{
		
		if($state == 1){
			
			//update nama atau table name
			$qs_gfrfltd = $db
				->raw()
				->bind(':id', $id)
				->exec('SELECT
							a.id,
							b.nama_tabel,
							CONCAT("field_", a.id) field_name
						FROM gfrfltd a
						LEFT JOIN gfrxxth b ON b.id = a.id_gfrxxth
						WHERE a.id_gfrxxth = :id
						'
			);
			$rs_gfrfltd = $qs_gfrfltd->fetchAll();
			foreach ($rs_gfrfltd as $key => $gfrfltd) {
				$qu_gfrfltd = $db
				->query('update', 'gfrfltd')
				->set('nama',$gfrfltd['field_name'])
				->where('id',$gfrfltd['id'])
				->exec();

				$q_alter_table = $db
				->raw() 
				->exec('ALTER TABLE ' . $gfrfltd['nama_tabel'] . '
						ADD COLUMN IF NOT EXISTS ' . $gfrfltd['field_name'] . ' VARCHAR(255);');

			}
		} // end if($state == 1)

		if(!empty($q_alter_table)){
			$status_code  = 200;
			$message = "Konfirmasi Berhasil";
			$type_message = "success";
			// parameter lain
		}else{
			$status_code  = 500;
			$message = "Konfirmasi Gagal";
			$type_message = 'error';
			// parameter lain
		}
	}catch(PDOException $e){
		$status_code  = 500;
		$message      = 'Message Gagal! ' . $e->getMessage();
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