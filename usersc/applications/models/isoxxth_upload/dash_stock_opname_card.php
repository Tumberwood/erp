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
                            COUNT(targt.id) AS c_target,
                            targt.id_isoxxth_upload
                        FROM isoittd_upload AS targt
                        LEFT JOIN isoxxth_upload th on th.id = targt.id_isoxxth_upload
                        WHERE (targt.id_isoxxth_upload = :id_isoxxth_upload OR th.id_isoxxth_upload_parent = :id_isoxxth_upload) AND targt.transaction_state <> -9
                    ) AS targt ON targt.id_isoxxth_upload = a.id
                    
                    -- is_upload = 1
                    left JOIN (
                        select
                            COUNT(up.id) AS c_upload,
                            up.id_isoxxth_upload
                        FROM isoittd_upload AS up
                        LEFT JOIN isoxxth_upload th on th.id = up.id_isoxxth_upload
                        WHERE (up.id_isoxxth_upload = :id_isoxxth_upload OR th.id_isoxxth_upload_parent = :id_isoxxth_upload) AND up.transaction_state <> -9 AND up.is_upload = 1
                    ) AS upload ON upload.id_isoxxth_upload = a.id
                    
                    -- is_upload = 0 / Bukan Upload
                    left JOIN (
                        select
                            COUNT(up.id) AS c_not_upload,
                            if(th.id_isoxxth_upload_parent > 0, th.id_isoxxth_upload_parent, up.id_isoxxth_upload) id_isoxxth_upload
                        FROM isoittd_upload AS up
                        LEFT JOIN isoxxth_upload th on th.id = up.id_isoxxth_upload
                        WHERE (up.id_isoxxth_upload = :id_isoxxth_upload OR th.id_isoxxth_upload_parent = :id_isoxxth_upload) AND up.transaction_state <> -9 AND up.is_upload IS NULL
                    ) AS not_upload ON not_upload.id_isoxxth_upload = a.id OR not_upload.id_isoxxth_upload = a.id_isoxxth_upload_parent
                    
                    -- isoittd yang sudah terhitung
                    left JOIN (
                        select
                            COUNT(hitung.id) AS c_terhitung,
                            hitung.id_isoxxth_upload
                        FROM isoittd_upload AS hitung
                        LEFT JOIN isoxxth_upload th on th.id = hitung.id_isoxxth_upload
                        WHERE (hitung.id_isoxxth_upload = :id_isoxxth_upload OR th.id_isoxxth_upload_parent = :id_isoxxth_upload) AND hitung.transaction_state <> -9 AND (selisih_final IS NOT NULL OR is_skip = :id_isoxxth_upload)
                    ) AS hitung ON hitung.id_isoxxth_upload = a.id
                    
                    -- fisik sesuai
                    left JOIN (
                        select
                            COUNT(d.id) AS c_sesuai,
                            d.id_isoxxth_upload
                        FROM isoittd_upload AS d
                        LEFT JOIN isoxxth_upload th on th.id = d.id_isoxxth_upload
                        WHERE (d.id_isoxxth_upload = :id_isoxxth_upload OR th.id_isoxxth_upload_parent = :id_isoxxth_upload) AND d.transaction_state <> -9 AND d.selisih_final = 0
                    ) AS sesuai ON sesuai.id_isoxxth_upload = a.id
                    
                    -- fisik lebih
                    left JOIN (
                        select
                            COUNT(d.id) AS c_lebih,
                            d.id_isoxxth_upload
                        FROM isoittd_upload AS d
                        LEFT JOIN isoxxth_upload th on th.id = d.id_isoxxth_upload
                        WHERE (d.id_isoxxth_upload = :id_isoxxth_upload OR th.id_isoxxth_upload_parent = :id_isoxxth_upload) AND d.transaction_state <> -9 AND d.selisih_final > 0
                    ) AS lebih ON lebih.id_isoxxth_upload = a.id
                    
                    -- fisik kurang
                    left JOIN (
                        select
                            COUNT(d.id) AS c_kurang,
                            d.id_isoxxth_upload
                        FROM isoittd_upload AS d
                        LEFT JOIN isoxxth_upload th on th.id = d.id_isoxxth_upload
                        WHERE (d.id_isoxxth_upload = :id_isoxxth_upload OR th.id_isoxxth_upload_parent = :id_isoxxth_upload) AND d.transaction_state <> -9 AND d.selisih_final < 0
                    ) AS kurang ON kurang.id_isoxxth_upload = a.id
                    
                    -- fisik skip
                    left JOIN (
                        select
                            COUNT(d.id) AS c_skip,
                            if(th.id_isoxxth_upload_parent > 0, th.id_isoxxth_upload_parent, d.id_isoxxth_upload) id_isoxxth_upload
                        FROM isoittd_upload AS d
                        LEFT JOIN isoxxth_upload th on th.id = d.id_isoxxth_upload
                        WHERE (d.id_isoxxth_upload = :id_isoxxth_upload OR th.id_isoxxth_upload_parent = :id_isoxxth_upload) AND d.transaction_state <> -9 AND d.is_skip = 1
                    ) AS skip ON skip.id_isoxxth_upload = a.id OR skip.id_isoxxth_upload = a.id_isoxxth_upload_parent
                    
                    WHERE a.id = :id_isoxxth_upload OR a.id_isoxxth_upload_parent = :id_isoxxth_upload
                    HAVING c_target > 0
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
                                COUNT(target.id) AS c_target,
                                target.id_isoxxth_upload
                            FROM isoittd_upload AS target
                            LEFT JOIN isoxxth_upload th on th.id = target.id_isoxxth_upload
                            WHERE (target.id_isoxxth_upload = :id_isoxxth_upload OR th.id_isoxxth_upload_parent = :id_isoxxth_upload) AND target.transaction_state <> -9
                            group BY target.nama
                        ) AS z
                    ) AS target ON target.id_isoxxth_upload = a.id
                    
                    -- is_upload = 1
                    left JOIN (
                        select
                            count(c_upload) as c_upload,
                            id_isoxxth_upload
                        from (
                            select
                                COUNT(up.id) AS c_upload,
                                up.id_isoxxth_upload
                            FROM isoittd_upload AS up
                            LEFT JOIN isoxxth_upload th on th.id = up.id_isoxxth_upload
                            WHERE (up.id_isoxxth_upload = :id_isoxxth_upload OR th.id_isoxxth_upload_parent = :id_isoxxth_upload) AND up.transaction_state <> -9 AND up.is_upload = 1
                            group by up.nama
                        ) AS z
                    ) AS upload ON upload.id_isoxxth_upload = a.id
                    
                    -- isoittd yang sudah terhitung
                    left JOIN (
                        select
                            count(c_terhitung) as c_terhitung,
                            id_isoxxth_upload
                        from (
                            select
                                COUNT(hitung.id) AS c_terhitung,
                                hitung.id_isoxxth_upload
                            FROM isoittd_upload AS hitung
                            LEFT JOIN isoxxth_upload th on th.id = hitung.id_isoxxth_upload
                            WHERE (hitung.id_isoxxth_upload = :id_isoxxth_upload OR th.id_isoxxth_upload_parent = :id_isoxxth_upload) AND hitung.transaction_state <> -9 
                            group by hitung.nama
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
                            LEFT JOIN isoxxth_upload th on th.id = d.id_isoxxth_upload
                            WHERE (d.id_isoxxth_upload = :id_isoxxth_upload OR th.id_isoxxth_upload_parent = :id_isoxxth_upload) AND d.transaction_state <> -9 
                            group by d.nama
                            Having sum(d.selisih_final) = 0
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
                            LEFT JOIN isoxxth_upload th on th.id = d.id_isoxxth_upload
                            WHERE (d.id_isoxxth_upload = :id_isoxxth_upload OR th.id_isoxxth_upload_parent = :id_isoxxth_upload) AND d.transaction_state <> -9 
                            group by d.nama
                            Having sum(d.selisih_final) > 0
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
                            LEFT JOIN isoxxth_upload th on th.id = d.id_isoxxth_upload
                            WHERE (d.id_isoxxth_upload = :id_isoxxth_upload OR th.id_isoxxth_upload_parent = :id_isoxxth_upload) AND d.transaction_state <> -9 
                            group by d.nama
                            Having sum(d.selisih_final) < 0
                        ) AS z
                    ) AS kurang ON kurang.id_isoxxth_upload = a.id
                    
                    WHERE a.id = :id_isoxxth_upload OR a.id_isoxxth_upload_parent = :id_isoxxth_upload
                    HAVING c_target > 0
                    '
                    );
        $rs_group_item = $qs_group_item->fetch();

        $results = array();
		$results['data'] = $rs_row_data;
		$results['data2'] = $rs_group_item;

    } else {
		$results['data'] = [];
		$results['data2'] = [];
	}

	echo json_encode($results);
?>