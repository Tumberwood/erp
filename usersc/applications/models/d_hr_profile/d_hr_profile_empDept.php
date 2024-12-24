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

    $qs_hemxxmh = $db
    ->raw()
    ->exec(' WITH qs_dep AS (
                SELECT 
                    id_hovxxmh,
                    hovxxmh_nama,
                    dept.id AS id,
                    dept.nama AS hodxxmh_nama,
                    genders.gender AS hemxxmh_gender,
                    IFNULL(COUNT(h.id), 0) AS c_gender_dept
                FROM (
                    (
                        -- Subquery for department
                        SELECT 
                            hodxxmh.id_hovxxmh,
                            hovxxmh.nama hovxxmh_nama,
                            hodxxmh.id AS id,
                            hodxxmh.nama AS nama
                        FROM 
                            hodxxmh
                    LEFT JOIN hovxxmh ON hovxxmh.id = hodxxmh.id_hovxxmh
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
                hov.id id_hovxxmh,
                hov.nama hovxxmh_nama,
                if(id_hovxxmh, SUM(c_gender_dept), 0) as c_total
            FROM hovxxmh hov
            LEFT JOIN qs_dep qs ON qs.id_hovxxmh = hov.id
            GROUP BY hov.id
            ORDER BY hov.id
            '
            );
    $rs_hemxxmh = $qs_hemxxmh->fetchAll();

    $category = array();
	$category['name'] = 'Divisi';
	
	$series1 = array();
	$series1['name'] =  'Karyawan';
	$series1['colorByPoint'] =  true;

    $drilldown = array();
    $data_dept = array();
	

	foreach ($rs_hemxxmh as $key => $row) {
		$category['data'][] = $row['hovxxmh_nama'];
        $series1['data'][] = array(
            'name' => $row['hovxxmh_nama'],
            'y' =>$row['c_total'],
            'drilldown' => $row['hovxxmh_nama']
        );

        $drillDeptData = [
            'name' => $row['hovxxmh_nama'],
            'id' => $row['hovxxmh_nama']
        ];

		$izin = $row['id_hovxxmh'];

        $qs_department = $db
        ->raw()
        ->bind(':izin', $izin)
        ->exec('WITH qs_dep AS (
                    SELECT 
                        id_hovxxmh,
                        hovxxmh_nama,
                        dept.id AS id,
                        dept.nama AS hodxxmh_nama,
                        genders.gender AS hemxxmh_gender,
                        IFNULL(COUNT(h.id), 0) AS c_gender_dept
                    FROM (
                        (
                            -- Subquery for department
                            SELECT 
                                hodxxmh.id_hovxxmh,
                                hovxxmh.nama hovxxmh_nama,
                                hodxxmh.id AS id,
                                hodxxmh.nama AS nama
                            FROM 
                                hodxxmh
                        LEFT JOIN hovxxmh ON hovxxmh.id = hodxxmh.id_hovxxmh
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
                    id_hovxxmh,
                    hovxxmh_nama,
                    hodxxmh_nama,
                    SUM(if(hemxxmh_gender="Laki-laki",c_gender_dept,0)) as c_age_laki,
                    SUM(if(hemxxmh_gender="Laki-laki",c_gender_dept,0)) as c_total,
                    SUM(if(hemxxmh_gender="Perempuan",c_gender_dept,0)) as c_age_perempuan
                FROM qs_dep
                WHERE id_hovxxmh = :izin
                GROUP BY hodxxmh_nama
                ORDER BY hodxxmh_nama
                '
                );
        $rs_department = $qs_department->fetchAll();

        foreach ($rs_department as $key => $dept) {
            $data_dept = array($dept['hodxxmh_nama'], $dept['c_total']);

            $data_dept = [$dept['hodxxmh_nama'], $dept['c_total']];
            
            $drillDeptData['data'][] = $data_dept;
        }
        //add drillDeptData ke drilldown[series] agar mengkelompokkan berdasarkan izin sesuai dengan yang di example
        $drilldown['series'][] = $drillDeptData;
	}
	
	$results = array();
	array_push($results,$category);
	array_push($results,$series1);
	array_push($results,$drilldown);

    $data = array(
        'results_emp_dept' => $results,
    );
    
    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>

