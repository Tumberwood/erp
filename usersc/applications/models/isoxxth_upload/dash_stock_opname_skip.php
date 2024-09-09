<?php

	include( "../../../../users/init.php" );
	include( "../../../../usersc/lib/DataTables.php" );

	require '../../../../usersc/vendor/autoload.php';
	use Carbon\Carbon;
	
	use
		DataTables\Editor,
		DataTables\Editor\Query,
		DataTables\Editor\Result;

	if (isset($_POST['id_isoxxth_upload']) && $_POST['id_isoxxth_upload'] > 0){
		$id_isoxxth_upload		= $_POST['id_isoxxth_upload'];
        
        $qs_skip = $db
            ->raw()
            ->bind(':id_isoxxth_upload', $id_isoxxth_upload)
            ->exec('SELECT
                        a.kode,
                        a.nama,
                        a.alasan_skip,
                        a.lokasi
                    FROM isoittd_upload AS a
                    INNER JOIN isoxxth_upload th on th.id = a.id_isoxxth_upload
                    WHERE (a.id_isoxxth_upload = :id_isoxxth_upload OR th.id_isoxxth_upload_parent = :id_isoxxth_upload) AND a.transaction_state <> -9 AND a.is_skip = 1
                    '
                    );
        $rs_skip = $qs_skip->fetchAll();

        $results = array();
		$results['data5'] = $rs_skip;

    } else {
		$results['data5'] = [];
	}

	echo json_encode($results);
?>