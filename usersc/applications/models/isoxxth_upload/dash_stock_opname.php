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
        
        $qs_row_data = $db
            ->raw()
            ->bind(':id_isoxxth_upload', $id_isoxxth_upload)
            ->exec('SELECT
                        c_target,
                        ifnull(c_upload,0) as c_upload,
                        ifnull(c_not_upload,0) as c_not_upload,
                        
                        CONCAT(
                            ROUND(
                                    (ifnull(c_terhitung, 0) / c_target) * 100, 
                                2),
                                "%"
                            ) AS terhitung,
                        ifnull(c_terhitung, 0) as c_terhitung,
                    
                        CONCAT(
                            ROUND(
                                ( (c_target - ifnull(c_terhitung, 0)) / c_target
                                )
                                * 100, 
                            2),
                            "%"
                        ) AS not_terhitung,
                        (c_target - ifnull(c_terhitung, 0)) AS c_not_terhitung,
                        
                        ifnull(CONCAT(
                            ROUND(
                                (c_sesuai / c_terhitung) * 100,
                                2)
                        ,"%"), "0.00%") AS sesuai,
                        ifnull(c_sesuai, 0) as c_sesuai,
                    
                        ifnull(CONCAT(
                            ROUND(
                                (c_lebih / c_terhitung) * 100,
                                2)
                        ,"%"), "0.00%") AS lebih,
                        ifnull(c_lebih, 0) as c_lebih,
                    
                        ifnull(CONCAT(
                            ROUND(
                                (c_kurang / c_terhitung) * 100,
                                2)
                        ,"%"), "0.00%") AS kurang,
                        ifnull(c_kurang, 0) as c_kurang,
                    
                        ifnull(CONCAT(
                            ROUND(
                                (c_skip / c_terhitung) * 100,
                                2)
                        ,"%"), "0.00%") AS skip,
                        ifnull(c_skip, 0) as c_skip

                    FROM isoxxth_upload AS a
                    
                    -- all data isoittd
                    left JOIN (
                        select
                            COUNT(id) AS c_target,
                            target.id_isoxxth_upload
                        FROM isoittd_upload AS target
                        WHERE target.id_isoxxth_upload = :id_isoxxth_upload
                    ) AS target ON target.id_isoxxth_upload = a.id
                    
                    -- is_upload = 1
                    left JOIN (
                        select
                            COUNT(id) AS c_upload,
                            up.id_isoxxth_upload
                        FROM isoittd_upload AS up
                        WHERE up.id_isoxxth_upload = :id_isoxxth_upload AND up.is_upload = 1
                    ) AS upload ON upload.id_isoxxth_upload = a.id
                    
                    -- is_upload = 0 / Bukan Upload
                    left JOIN (
                        select
                            COUNT(id) AS c_not_upload,
                            up.id_isoxxth_upload
                        FROM isoittd_upload AS up
                        WHERE up.id_isoxxth_upload = :id_isoxxth_upload AND up.is_upload IS NULL
                    ) AS not_upload ON not_upload.id_isoxxth_upload = a.id
                    
                    -- isoittd yang sudah terhitung
                    left JOIN (
                        select
                            COUNT(id) AS c_terhitung,
                            hitung.id_isoxxth_upload
                        FROM isoittd_upload AS hitung
                        WHERE hitung.id_isoxxth_upload = :id_isoxxth_upload AND (fisik >= 0 OR is_skip = 1)
                    ) AS hitung ON hitung.id_isoxxth_upload = a.id
                    
                    -- fisik sesuai
                    left JOIN (
                        select
                            COUNT(d.id) AS c_sesuai,
                            d.id_isoxxth_upload
                        FROM isoittd_upload AS d
                        WHERE d.id_isoxxth_upload = :id_isoxxth_upload AND d.selisih = 0
                    ) AS sesuai ON sesuai.id_isoxxth_upload = a.id
                    
                    -- fisik lebih
                    left JOIN (
                        select
                            COUNT(d.id) AS c_lebih,
                            d.id_isoxxth_upload
                        FROM isoittd_upload AS d
                        WHERE d.id_isoxxth_upload = :id_isoxxth_upload AND d.selisih > 0
                    ) AS lebih ON lebih.id_isoxxth_upload = a.id
                    
                    -- fisik kurang
                    left JOIN (
                        select
                            COUNT(d.id) AS c_kurang,
                            d.id_isoxxth_upload
                        FROM isoittd_upload AS d
                        WHERE d.id_isoxxth_upload = :id_isoxxth_upload AND d.selisih < 0
                    ) AS kurang ON kurang.id_isoxxth_upload = a.id
                    
                    -- fisik skip
                    left JOIN (
                        select
                            COUNT(d.id) AS c_skip,
                            d.id_isoxxth_upload
                        FROM isoittd_upload AS d
                        WHERE d.id_isoxxth_upload = :id_isoxxth_upload AND d.is_skip = 1
                    ) AS skip ON skip.id_isoxxth_upload = a.id
                    
                    WHERE a.id = :id_isoxxth_upload
                    '
                    );
        $rs_row_data = $qs_row_data->fetch();

        $qs_group_item = $db
            ->raw()
            ->bind(':id_isoxxth_upload', $id_isoxxth_upload)
            ->exec('SELECT
                        c_target,
                        ifnull(c_upload,0) as c_upload,
                        
                        CONCAT(
                            ROUND(
                                    (ifnull(c_terhitung, 0) / c_target) * 100, 
                                2),
                                "%"
                            ) AS terhitung,
                        ifnull(c_terhitung, 0) as c_terhitung,
                    
                        CONCAT(
                            ROUND(
                                ( (c_target - ifnull(c_terhitung, 0)) / c_target
                                )
                                * 100, 
                            2),
                            "%"
                        ) AS not_terhitung,
                        (c_target - ifnull(c_terhitung, 0)) AS c_not_terhitung,
                        
                        ifnull(CONCAT(
                            ROUND(
                                (c_sesuai / c_terhitung) * 100,
                                2)
                        ,"%"), "0.00%") AS sesuai,
                        ifnull(c_sesuai, 0) as c_sesuai,
                    
                        ifnull(CONCAT(
                            ROUND(
                                (c_lebih / c_terhitung) * 100,
                                2)
                        ,"%"), "0.00%") AS lebih,
                        ifnull(c_lebih, 0) as c_lebih,
                    
                        ifnull(CONCAT(
                            ROUND(
                                (c_kurang / c_terhitung) * 100,
                                2)
                        ,"%"), "0.00%") AS kurang,
                        ifnull(c_kurang, 0) as c_kurang
                    FROM isoxxth_upload AS a
                    
                    -- all data isoittd
                    left JOIN (
                        select
                            COUNT(c_target) AS c_target,
                            id_isoxxth_upload
                        FROM (
                            select
                                COUNT(id) AS c_target,
                                nama,
                                target.id_isoxxth_upload
                            FROM isoittd_upload AS target
                            WHERE target.id_isoxxth_upload = :id_isoxxth_upload
                            group BY nama
                        ) AS z
                    ) AS target ON target.id_isoxxth_upload = a.id
                    
                    -- is_upload = 1
                    left JOIN (
                        select
                            count(c_upload) as c_upload,
                            id_isoxxth_upload
                        from (
                            select
                                COUNT(id) AS c_upload,
                                up.id_isoxxth_upload
                            FROM isoittd_upload AS up
                            WHERE up.id_isoxxth_upload = :id_isoxxth_upload AND up.is_upload = 1
                            group by nama
                        ) AS z
                    ) AS upload ON upload.id_isoxxth_upload = a.id
                    
                    -- isoittd yang sudah terhitung
                    left JOIN (
                        select
                            count(c_terhitung) as c_terhitung,
                            id_isoxxth_upload
                        from (
                            select
                                COUNT(id) AS c_terhitung,
                                hitung.id_isoxxth_upload
                            FROM isoittd_upload AS hitung
                            WHERE hitung.id_isoxxth_upload = :id_isoxxth_upload 
                            group by nama
                            HAVING SUM(fisik) >= 0
                        ) AS z
                    ) AS hitung ON hitung.id_isoxxth_upload = a.id
                    
                    -- fisik sesuai
                    left JOIN (
                        select
                            count(c_sesuai) as c_sesuai,
                            id_isoxxth_upload
                        from (
                            select
                                COUNT(d.id) AS c_sesuai,
                                d.nama,
                                d.id_isoxxth_upload
                            FROM isoittd_upload AS d
                            WHERE d.id_isoxxth_upload = :id_isoxxth_upload 
                            group by nama
                            Having sum(d.selisih) = 0
                        ) AS z
                    ) AS sesuai ON sesuai.id_isoxxth_upload = a.id
                    
                    -- fisik lebih
                    left JOIN (
                        select
                            count(c_lebih) as c_lebih,
                            id_isoxxth_upload
                        from (
                            select
                                COUNT(d.id) AS c_lebih,
                                d.nama,
                                d.id_isoxxth_upload
                            FROM isoittd_upload AS d
                            WHERE d.id_isoxxth_upload = :id_isoxxth_upload 
                            group by nama
                            Having sum(d.selisih) > 0
                        ) AS z
                    ) AS lebih ON lebih.id_isoxxth_upload = a.id
                    
                    -- fisik kurang
                    left JOIN (
                        select
                            count(c_kurang) as c_kurang,
                            id_isoxxth_upload
                        from (
                            select
                                COUNT(d.id) AS c_kurang,
                                d.nama,
                                d.id_isoxxth_upload
                            FROM isoittd_upload AS d
                            WHERE d.id_isoxxth_upload = :id_isoxxth_upload 
                            group by nama
                            Having sum(d.selisih) < 0
                        ) AS z
                    ) AS kurang ON kurang.id_isoxxth_upload = a.id
                    
                    WHERE a.id = :id_isoxxth_upload
                    '
                    );
        $rs_group_item = $qs_group_item->fetch();

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
                                created_by,
                                SUM(TIMESTAMPDIFF(second,start_on,finish_on)) AS diff_in_seconds
                            FROM activity_log_ml
                            WHERE nama = "isoittd_upload_fisik"
                            GROUP BY created_by
                        ) AS jam ON jam.created_by = p.created_by

                        WHERE a.id_isoxxth_upload = :id_isoxxth_upload
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

        $qs_selisih_terbanyak = $db
            ->raw()
            ->bind(':id_isoxxth_upload', $id_isoxxth_upload)
            ->exec('SELECT
                        a.kode,
                        a.nama,
                        sum(a.jumlah_terkecil) AS s_jumlah_terkecil,
                        sum(a.fisik) AS s_fisik,
                        sum(a.selisih) AS s_selisih
                    FROM isoittd_upload AS a
                    WHERE a.id_isoxxth_upload = :id_isoxxth_upload AND a.fisik is not null
                    GROUP BY a.nama
                    having s_selisih < 0
                    ORDER BY s_selisih ASC
                    LIMIT 10
                    '
                    );
        $rs_selisih_terbanyak = $qs_selisih_terbanyak->fetchAll();

        $results = array();
		$results['data'] = $rs_row_data;
		$results['data2'] = $rs_group_item;
		$results['data3'] = $rs_selisih_terbanyak;
		$results['data4'] = $rs_log_user;
        
		$results['columns'] = [
			['data' => 'kode', 'name' => 'kode'],
			['data' => 'nama', 'name' => 'nama'],
			['data' => 's_jumlah_terkecil', 'name' => 's_jumlah_terkecil'],
			['data' => 's_fisik', 'name' => 's_fisik'],
			['data' => 's_selisih', 'name' => 's_selisih']
		];

		$results['columns2'] = [
			['data' => 'nama', 'name' => 'nama'],
			['data' => 'c_upload', 'name' => 'c_upload'],
			['data' => 'c_new', 'name' => 'c_new'],
			['data' => 'lokasi', 'name' => 'lokasi'],
			['data' => 'total_time', 'name' => 'total_time']
		];
	} else {
		$results['data'] = [];
		$results['columns'] = [];
	}

	echo json_encode($results);
?>