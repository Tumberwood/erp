<?php
	include( "../../../../users/init.php" );
	include( "../../../../usersc/lib/DataTables.php" );
	include( "../../../../usersc/helpers/datatables_fn_debug.php" );

	
	use
		DataTables\Editor,
		DataTables\Editor\Field,
		DataTables\Editor\Format,
		DataTables\Editor\Mjoin,
		DataTables\Editor\Options,
		DataTables\Editor\Upload,
		DataTables\Editor\Validate,
		DataTables\Editor\ValidateOptions,
		DataTables\Editor\Query,
		DataTables\Editor\Result;
	
        $kode   = $_POST['kode'];
        $sql_select = $db
		->raw()
		->bind(':kode', $kode)
		->exec(' SELECT
					a.kode AS kode,
					hcd.nama AS nama,
					jabatan.nama AS hetxxmh,
					ktp.ktp_no AS ktp,
					a.status AS status_disc
				FROM hrctsth_disc AS a
				LEFT JOIN hcdxxmh AS hcd ON hcd.id = a.id_hcdxxmh
				LEFT JOIN hcddcmh AS ktp ON ktp.id_hcdxxmh = hcd.id
				LEFT JOIN hcdjbmh AS job ON job.id_hcdxxmh = hcd.id
				LEFT JOIN hetxxmh AS jabatan ON jabatan.id = job.id_hetxxmh
				WHERE a.kode = :kode
				'
				);
        
	    $results_select = $sql_select->fetch();
        echo json_encode($results_select);
?>