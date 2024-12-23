<?php 
    /**
     * Digunakan 
     */
    require_once( "../../../../users/init.php" );
	require_once( "../../../../usersc/lib/DataTables.php" );
	require_once( "../../../../usersc/helpers/datatables_fn_debug.php" );

    require_once( "../../../../usersc/vendor/autoload.php");
	use Carbon\Carbon;

    // BEGIN definisi variable untuk fn_ajax_results.php
    $data      = array();
    $rs_opt    = array();
    $c_rs_opt  = 0;
    $morePages = 0;
    // END definisi variable untuk fn_ajax_results.php

    // $tanggal_akhir = $_POST['tanggal_akhir'];
    $tanggal_akhir = new Carbon();

    $qs_hemxxmh = $db
        ->raw()
        ->exec('WITH qs_dep AS (
                    SELECT 
                        dept.id AS id,
                        dept.nama AS hodxxmh_nama,
                        genders.gender AS hemxxmh_gender,
                        IFNULL(COUNT(h.id), 0) AS c_gender_dept
                    FROM (
                        (
                            -- Subquery for department
                            SELECT 
                                hodxxmh.id AS id,
                                hodxxmh.nama AS nama
                            FROM 
                                hodxxmh
                        ) dept
                        JOIN (
                            -- Subquery for distinct genders
                            SELECT DISTINCT 
                                hemxxmh.gender AS gender
                            FROM 
                                hemxxmh
                            WHERE gender IS NOT NULL 
                        ) genders
                    )
                    LEFT JOIN (
                        -- Subquery for employees with transaction_state = 1
                        SELECT 
                            e.id AS id,
                            d.id_hodxxmh AS id_hodxxmh,
                            e.gender AS gender
                        FROM 
                            hemjbmh d
                        LEFT JOIN 
                            hemxxmh e ON (e.id = d.id_hemxxmh)
                        WHERE 
                            e.transaction_state = 1
                    ) h 
                    ON (
                        (h.id_hodxxmh = dept.id) 
                        AND (h.gender = genders.gender)
                    )
                    GROUP BY 
                        dept.id, 
                        genders.gender
                    ORDER BY 
                        dept.id, 
                        genders.gender
                )
                SELECT
                    hodxxmh_nama,
                    SUM(if(hemxxmh_gender="Laki-laki",c_gender_dept,0)) as c_age_laki,
                    SUM(if(hemxxmh_gender="Perempuan",c_gender_dept,0)) as c_age_perempuan
                FROM qs_dep
                GROUP BY hodxxmh_nama
                ORDER BY hodxxmh_nama
    ');
    $rs_hemxxmh = $qs_hemxxmh->fetchAll();

    $category = array();
	$category['name'] = 'Usia';
	
	$series1 = array();
	$series1['name'] =  'Laki-laki';

    $series2 = array();
	$series2['name'] =  'Perempuan';
	
	foreach ($rs_hemxxmh as $key => $row) {
		$category['data'][] = $row['hodxxmh_nama'];
		$series1['data'][] = $row['c_age_laki'];
		$series2['data'][] = $row['c_age_perempuan'];
	}
	
	$results = array();
	array_push($results,$category);
	array_push($results,$series1);
	array_push($results,$series2);

    $data = array(
        'results_empdept' => $results
    );
    
    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>