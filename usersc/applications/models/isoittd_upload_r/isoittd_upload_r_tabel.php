<?php

	include( "../../../../users/init.php" );
	include( "../../../../usersc/lib/DataTables.php" );

	require '../../../../usersc/vendor/autoload.php';
	use Carbon\Carbon;
	
	use
		DataTables\Editor,
		DataTables\Editor\Query,
		DataTables\Editor\Result;

	if (isset($_POST['id_isoxxth_upload_filter']) && $_POST['id_isoxxth_upload_filter'] > 0){
		$id_isoxxth_upload		= $_POST['id_isoxxth_upload_filter'];

        $qs_data = $db
            ->raw()
            ->bind(':id_isoxxth_upload', $id_isoxxth_upload)
            ->exec('SELECT
                        th.kode kode_sou,
                        CONCAT(ifnull(GROUP_CONCAT(a.keterangan SEPARATOR ", "), ""), ifnull(GROUP_CONCAT(fis.keterangan SEPARATOR ", "),"")) AS s_keterangan,
                        a.*
                    FROM isoittd_upload AS a
                    INNER JOIN isoxxth_upload th ON th.id = a.id_isoxxth_upload
                    INNER JOIN isoittd_upload_fisik fis ON fis.id_isoittd_upload = a.id
                    WHERE (a.id_isoxxth_upload = :id_isoxxth_upload OR th.id_isoxxth_upload_parent = :id_isoxxth_upload) 
                    AND a.transaction_state <> -9 
                    GROUP BY a.id
                    '
                    );
        $rs_data = $qs_data->fetchAll();

        $results = array();
		$results['data'] = $rs_data;
        
	} else {
		$results['data'] = [];
	}

	echo json_encode($results);
?>