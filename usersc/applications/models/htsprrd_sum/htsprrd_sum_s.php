<?php
include("../../../../users/init.php");
include("../../../../usersc/lib/DataTables.php");

use
    DataTables\Editor,
    DataTables\Editor\Query,
    DataTables\Editor\Result;

// Establish a database connection here (replace with your actual database connection code)

// Your SQL query to retrieve the data
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];

$qs_htlgrmh = $db
    ->raw()
    ->exec('SELECT
            kode
            FROM htlgrmh
            ORDER BY id
        ');
$rs_htlgrmh = $qs_htlgrmh->fetchAll();
// print_r($rs_htlgrmh);

$case_sum = '';
$arr_htlgrmh = [];
foreach ($rs_htlgrmh as $key => $htl) {
    $kode_htl_trim = str_replace(' ', '', $htl['kode']);
    // print_r($kode_htl_trim);
    $case_sum .= ' 
    SUM(
        (
            CASE WHEN a.status_presensi_in = "'.$htl['kode'].'" THEN 1 ELSE 0 END
            +
            CASE WHEN a.status_presensi_out = "'.$htl['kode'].'" THEN 1 ELSE 0 END 
        )
    ) 
    AS s_in_'.$kode_htl_trim.', ';
}
// print_r($case_sum);

$qs_payroll = $db
    ->raw()
	->bind(':start_date', $start_date)
	->bind(':end_date', $end_date)
    ->exec('WITH presensi AS (
            SELECT
                a.id_hemxxmh,	
                b.kode_finger,
                b.kode,
                b.nama,
                '.$case_sum.'
                d.nama AS jab
            FROM htsprrd AS a
            LEFT JOIN hemxxmh AS b ON b.id = a.id_hemxxmh
            LEFT JOIN hemjbmh AS c ON c.id_hemxxmh = a.id
            LEFT JOIN hetxxmh AS d ON d.id = c.id_hetxxmh
            WHERE a.tanggal BETWEEN :start_date AND :end_date
            GROUP BY a.id_hemxxmh
        )
        SELECT
            w.*,
            tanggal,
            pr.clock_in,
            pr.clock_out,
            clock_in_format,
            clock_out_format
        FROM presensi AS w
        LEFT JOIN (
            select
                r.tanggal,
                TIME_FORMAT(clock_in, "%H:%i") AS clock_in_format,
                TIME_FORMAT(clock_out, "%H:%i") AS clock_out_format,
                clock_in,
                clock_out,
                r.id_hemxxmh
            FROM htsprrd AS r
            WHERE r.tanggal BETWEEN :start_date AND :end_date
            GROUP BY r.tanggal, r.id_hemxxmh
        ) AS pr ON pr.id_hemxxmh = w.id_hemxxmh
        WHERE w.id_hemxxmh = '.$_SESSION['id_hemxxmh'].'
        ORDER BY pr.tanggal;

    ');

$rs_payroll = $qs_payroll->fetchAll();

if (count($rs_payroll) > 0) {
    // Create an associative array to hold the pivoted data
    $pivotedData = [];

    foreach ($rs_payroll as $row) {
        $id_hemxxmh = $row['id_hemxxmh'];
        $nama = $row['nama'];
        $kode = $row['kode'];
        $kode_finger = $row['kode_finger'];
        $jab = $row['jab'];

		// var_dump($kode_finger);
        if (!isset($pivotedData[$id_hemxxmh])) {
            $pivotedData[$id_hemxxmh] = [
                'id_hemxxmh' => $id_hemxxmh,
                'Nama' => $nama,
                'NIP' => $kode,
                'Kode Finger' => $kode_finger,
                'Jabatan' => $jab,

            ];
            $total = 0;

            foreach ($rs_htlgrmh as $key => $htl) {
                $kode_htl_trim = str_replace(' ', '', $htl['kode']);
                
                $kode_htl = $kode_htl_trim;
                $data_htl = $row['s_in_'.$kode_htl_trim];
                $total = $total + $data_htl;

                $pivotedData[$id_hemxxmh]['htlgrmh'.$kode_htl] = $data_htl;
                // print_r($data_htl."<br>");
            }
            $pivotedData[$id_hemxxmh]['Total'] = $total;
        }
		
        $clock_in = $row['clock_in'];
        $clock_out = $row['clock_out'];

        $clock_in_format = $row['clock_in_format'];
        $clock_out_format = $row['clock_out_format'];
        $tanggal = $row['tanggal'];

        // print_r($total);
        // $pivotedData[$id_hemxxmh][$tanggal] = $clock_in. " - " .$clock_out;
        $pivotedData[$id_hemxxmh][$tanggal.'In'] = $clock_in_format;
        $pivotedData[$id_hemxxmh][$tanggal.'Out'] = $clock_out_format;
    }

    // Convert the associative array into a numeric indexed array (optional)
    $pivotedData = array_values($pivotedData);

    // Create an array of column definitions
    $columns = [];
    // print_r($pivotedData[0]);
    foreach ($pivotedData[0] as $key => $value) {
        // print_r($key);
        if ($key != 'id_hemxxmh') {
            $columns[] = ['data' => $key, 'name' => $key];
        }
    }

    // Prepare the results in the desired format
    $results = [
        'data' => $pivotedData,
        'columns' => $columns
    ];

    // Output the results as JSON
    echo json_encode($results);
} else {
    // If no results found, prepare an empty result
    $results = [
        'data' => [],
        'columns' => []
    ];

    echo json_encode($results);
}

// Close the database connection here (replace with your actual code)
?>
