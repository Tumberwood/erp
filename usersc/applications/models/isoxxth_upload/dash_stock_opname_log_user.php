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
        
        $qs_log_user = $db
            ->raw()
            ->bind(':id_isoxxth_upload', $id_isoxxth_upload)
            ->exec('WITH hasil AS (
                        SELECT
                            p.created_by,
                            concat(us.fname, " ", us.lname) AS nama,
                            SUM(if(a.is_upload = 1 AND fin.kode = "CREATE",1,0) ) AS c_upload,
                            SUM(if(a.is_upload IS NULL  AND fin.kode = "CREATE" ,1,0) ) AS c_new,
                            COUNT(distinct(a.id)) AS lokasi,
                            MIN(p.start_on) AS start_on,
                            MAX(fin.finish_on) AS finish_on,
                            diff_in_seconds
                        FROM isoittd_upload a
                        INNER JOIN isoxxth_upload th on th.id = a.id_isoxxth_upload
                        INNER JOIN (
                            SELECT
                                f.id_isoittd_upload,
                                g.created_by,
                                g.start_on,
                                up.lokasi
                            FROM isoittd_upload_fisik f
                            inner JOIN activity_log_ml g ON g.id_transaksi = f.id AND g.nama = "isoittd_upload_fisik" AND g.kode = "CREATE"
                            INNER JOIN isoittd_upload up ON up.id = f.id_isoittd_upload
                        ) p ON p.id_isoittd_upload = a.id
                        
                        INNER JOIN (
                            SELECT
                                f.id_isoittd_upload,
                                g.created_by,
                                g.finish_on,
                                g.kode,
                                up.lokasi
                            FROM isoittd_upload_fisik f
                            inner JOIN activity_log_ml g ON g.id_transaksi = f.id AND g.nama = "isoittd_upload_fisik"
                            INNER JOIN isoittd_upload up ON up.id = f.id_isoittd_upload
                        ) fin ON fin.id_isoittd_upload = a.id
                        INNER JOIN users AS us ON us.id = p.created_by
                        INNER JOIN (
                            SELECT
                                act.created_by,
                                SUM(TIMESTAMPDIFF(SECOND,act.start_on,act.finish_on)) AS diff_in_seconds
                            FROM activity_log_ml act
                            LEFT JOIN isoittd_upload_fisik fis ON fis.id = act.id_transaksi
                            LEFT JOIN isoittd_upload iso ON iso.id = fis.id_isoittd_upload
                            INNER JOIN isoxxth_upload th on th.id = iso.id_isoxxth_upload
                            WHERE act.nama = "isoittd_upload_fisik" AND durasi_detik > 0 AND (iso.id_isoxxth_upload = :id_isoxxth_upload OR th.id_isoxxth_upload_parent = :id_isoxxth_upload)                            GROUP BY act.created_by
                        ) AS jam ON jam.created_by = p.created_by

                        WHERE (a.id_isoxxth_upload = :id_isoxxth_upload OR th.id_isoxxth_upload_parent = :id_isoxxth_upload) AND a.transaction_state <> -9
                        GROUP BY p.created_by
                    )
                    SELECT
                        nama,
                        c_upload,
                        c_new,
                        lokasi,
                        CONCAT(
                            FLOOR(diff_in_seconds / 3600), "h ",
                            FLOOR((diff_in_seconds % 3600) / 60), "m ",
                            (diff_in_seconds % 60), "s"
                        ) AS total_time
                    FROM hasil
                    '
                    );
        $rs_log_user = $qs_log_user->fetchAll();

        $results = array();
		$results['data4'] = $rs_log_user;

    } else {
		$results['data4'] = [];
	}

	echo json_encode($results);
?>