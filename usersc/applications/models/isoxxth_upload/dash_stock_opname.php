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
                        c_upload,
                        
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
                    
                    -- isoittd yang sudah terhitung
                    left JOIN (
                        select
                            COUNT(id) AS c_terhitung,
                            hitung.id_isoxxth_upload
                        FROM isoittd_upload AS hitung
                        WHERE hitung.id_isoxxth_upload = :id_isoxxth_upload AND fisik > 0
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
                    
                    WHERE a.id = :id_isoxxth_upload
                    '
                    );
        $rs_row_data = $qs_row_data->fetch();

        $qs_group_item = $db
            ->raw()
            ->bind(':id_isoxxth_upload', $id_isoxxth_upload)
            ->exec('SELECT
                        c_target,
                        c_upload,
                        
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
                                id_iimxxmh,
                                target.id_isoxxth_upload
                            FROM isoittd_upload AS target
                            WHERE target.id_isoxxth_upload = :id_isoxxth_upload
                            group BY id_iimxxmh
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
                            group by id_iimxxmh
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
                            group by id_iimxxmh
                            HAVING SUM(fisik) > 0
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
                                d.id_iimxxmh,
                                d.id_isoxxth_upload
                            FROM isoittd_upload AS d
                            WHERE d.id_isoxxth_upload = :id_isoxxth_upload 
                            group by id_iimxxmh
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
                                d.id_iimxxmh,
                                d.id_isoxxth_upload
                            FROM isoittd_upload AS d
                            WHERE d.id_isoxxth_upload = :id_isoxxth_upload 
                            group by id_iimxxmh
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
                                d.id_iimxxmh,
                                d.id_isoxxth_upload
                            FROM isoittd_upload AS d
                            WHERE d.id_isoxxth_upload = :id_isoxxth_upload 
                            group by id_iimxxmh
                            Having sum(d.selisih) < 0
                        ) AS z
                    ) AS kurang ON kurang.id_isoxxth_upload = a.id
                    
                    WHERE a.id = :id_isoxxth_upload
                    '
                    );
        $rs_group_item = $qs_group_item->fetch();

        $qs_selisih_terbanyak = $db
            ->raw()
            ->bind(':id_isoxxth_upload', $id_isoxxth_upload)
            ->exec('SELECT
                        b.kode,
                        b.nama,
                        sum(a.jumlah_terkecil) AS s_jumlah_terkecil,
                        sum(a.fisik) AS s_fisik,
                        sum(a.selisih) AS s_selisih
                    FROM isoittd_upload AS a
                    LEFT JOIN iimxxmh AS b ON b.id = a.id_iimxxmh
                    WHERE a.id_isoxxth_upload = :id_isoxxth_upload AND a.selisih > 0
                    GROUP BY a.id_iimxxmh
                    ORDER BY s_selisih DESC
                    LIMIT 10
                    '
                    );
        $rs_selisih_terbanyak = $qs_selisih_terbanyak->fetchAll();

        $results = array();
		$results['data'] = $rs_row_data;
		$results['data2'] = $rs_group_item;
		$results['data3'] = $rs_selisih_terbanyak;
        
		$results['columns'] = [
			['data' => 'kode', 'name' => 'kode'],
			['data' => 'nama', 'name' => 'nama'],
			['data' => 's_jumlah_terkecil', 'name' => 's_jumlah_terkecil'],
			['data' => 's_fisik', 'name' => 's_fisik'],
			['data' => 's_selisih', 'name' => 's_selisih']
		];
	} else {
		$results['data'] = [];
		$results['columns'] = [];
	}

	echo json_encode($results);
?>