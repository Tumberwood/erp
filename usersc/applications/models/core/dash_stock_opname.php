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
                                    (c_terhitung / c_target) * 100, 
                                2),
                                "%"
                            ) AS terhitung,
                        c_terhitung,
                    
                        CONCAT(
                            ROUND(
                                ( (c_target - c_terhitung) / c_target
                                )
                                * 100, 
                            2),
                            "%"
                        ) AS not_terhitung,
                        (c_target - c_terhitung) AS c_not_terhitung,
                        
                        CONCAT(
                            ROUND(
                                (c_sesuai / c_terhitung) * 100,
                                2)
                        ,"%") AS sesuai,
                        c_sesuai,
                    
                        CONCAT(
                            ROUND(
                                (c_lebih / c_terhitung) * 100,
                                2)
                        ,"%") AS lebih,
                        c_lebih,
                    
                        CONCAT(
                            ROUND(
                                (c_kurang / c_terhitung) * 100,
                                2)
                        ,"%") AS kurang,
                        c_kurang
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
                                    (c_terhitung / c_target) * 100, 
                                2),
                                "%"
                            ) AS terhitung,
                    c_terhitung,
                    
                        CONCAT(
                            ROUND(
                                ( (c_target - c_terhitung) / c_target
                                )
                                * 100, 
                            2),
                            "%"
                        ) AS not_terhitung,
                        (c_target - c_terhitung) AS c_not_terhitung,
                        
                        CONCAT(
                            ROUND(
                                (c_sesuai / c_terhitung) * 100,
                                2)
                        ,"%") AS sesuai,
                        c_sesuai,
                    
                        CONCAT(
                            ROUND(
                                (c_lebih / c_terhitung) * 100,
                                2)
                        ,"%") AS lebih,
                        c_lebih,
                    
                        CONCAT(
                            ROUND(
                                (c_kurang / c_terhitung) * 100,
                                2)
                        ,"%") AS kurang,
                        c_kurang
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
                            sum(c_terhitung) as c_terhitung,
                            id_isoxxth_upload
                        from (
                            select
                                COUNT(id) AS c_terhitung,
                                hitung.id_isoxxth_upload
                            FROM isoittd_upload AS hitung
                            WHERE hitung.id_isoxxth_upload = :id_isoxxth_upload AND fisik > 0
                            group by id_iimxxmh
                        ) AS z
                    ) AS hitung ON hitung.id_isoxxth_upload = a.id
                    
                    -- fisik sesuai
                    left JOIN (
                        select
                            sum(c_sesuai) as c_sesuai,
                            id_isoxxth_upload
                        from (
                            select
                                COUNT(d.id) AS c_sesuai,
                                d.id_iimxxmh,
                                d.id_isoxxth_upload
                            FROM isoittd_upload AS d
                            WHERE d.id_isoxxth_upload = :id_isoxxth_upload AND d.selisih = 0
                            group by id_iimxxmh
                        ) AS z
                    ) AS sesuai ON sesuai.id_isoxxth_upload = a.id
                    
                    -- fisik lebih
                    left JOIN (
                        select
                            sum(c_lebih) as c_lebih,
                            id_isoxxth_upload
                        from (
                            select
                                COUNT(d.id) AS c_lebih,
                                d.id_iimxxmh,
                                d.id_isoxxth_upload
                            FROM isoittd_upload AS d
                            WHERE d.id_isoxxth_upload = :id_isoxxth_upload AND d.selisih > 0
                            group by id_iimxxmh
                        ) AS z
                    ) AS lebih ON lebih.id_isoxxth_upload = a.id
                    
                    -- fisik kurang
                    left JOIN (
                        select
                            sum(c_kurang) as c_kurang,
                            id_isoxxth_upload
                        from (
                            select
                                COUNT(d.id) AS c_kurang,
                                d.id_iimxxmh,
                                d.id_isoxxth_upload
                            FROM isoittd_upload AS d
                            WHERE d.id_isoxxth_upload = :id_isoxxth_upload AND d.selisih < 0
                            group by id_iimxxmh
                        ) AS z
                    ) AS kurang ON kurang.id_isoxxth_upload = a.id
                    
                    WHERE a.id = :id_isoxxth_upload
                    '
                    );
        $rs_group_item = $qs_group_item->fetch();

        $results = array();
		$results['data'] = $rs_row_data;
		$results['data2'] = $rs_group_item;
        
		// $results['columns2'] = [
		// 	['data' => 'tanggal', 'name' => 'tanggal'],
		// 	['data' => 'jam', 'name' => 'jam'],
		// 	['data' => 'mesin', 'name' => 'mesin']
		// ];
	} else {
		$results['data'] = [];
		$results['columns'] = [];
	}

	echo json_encode($results);
?>