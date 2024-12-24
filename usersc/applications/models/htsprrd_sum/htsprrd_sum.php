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
// print_r($start_date);
$end_date = $_POST['end_date'];
$is_cuti_khusus = $_POST['is_cuti_khusus'];
// print_r($end_date);

//ALL
$qs_httlpmh = $db
    ->raw()
    ->exec('SELECT
            kode
            FROM httlpmh
            ORDER BY urutan
        ');
$rs_httlpmh = $qs_httlpmh->fetchAll();

//Harian
$qs_httlpmh_c = $db
    ->raw()
    ->exec('SELECT
            kode,
            is_cuti_khusus
            FROM httlpmh
            WHERE jenis = 1
            ORDER BY urutan
        ');
$rs_httlpmh_c = $qs_httlpmh_c->fetchAll();

//Jam atau izin
$qs_httlpmh_i = $db
    ->raw()
    ->exec('SELECT
            kode
            FROM httlpmh
            WHERE jenis = 2
            ORDER BY urutan
        ');
$rs_httlpmh_i = $qs_httlpmh_i->fetchAll();
// print_r($rs_httlpmh);

$case_sum = '';
$arr_httlpmh = [];
foreach ($rs_httlpmh as $key => $htl) {
    $kode_htl_trim = str_replace(' ', '', $htl['kode']);
    // print_r($kode_htl_trim);
    $case_sum .= ' 
    SUM(
        (
            CASE WHEN a.status_presensi_in = "'.$htl['kode'].'" THEN 0.5 ELSE 0 END
            +
            CASE WHEN a.status_presensi_out = "'.$htl['kode'].'" THEN 0.5 ELSE 0 END 
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
                b.kode,
                b.nama,
                 SUM(
                    (
                        CASE WHEN a.status_presensi_in = "HK" THEN 0.5 ELSE 0 END
                        +
                        CASE WHEN a.status_presensi_out = "HK" THEN 0.5 ELSE 0 END 
                    )
                ) 
                AS s_in_hk,
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
            hari,
            jk,
            off,
            nj,
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
        LEFT JOIN (
            SELECT
                peg.id as id_hemxxmh,
                DATEDIFF(:end_date, :start_date) + 1 AS hari,
                ifnull(jk,0) AS jk,
                ifnull(libur,0) AS off,
                (DATEDIFF(:end_date, :start_date) + 1) - (ifnull(jk,0) + ifnull(libur,0))
                AS nj
            FROM hemxxmh peg
            LEFT JOIN (
                SELECT 
                    COALESCE(SUM(if(DATE_FORMAT(tanggaljam_awal, "%H:%i:%s") <> "00:00:00", 1, 0)), 0) AS jk,
                    COALESCE(SUM(if(DATE_FORMAT(tanggaljam_awal, "%H:%i:%s") = "00:00:00", 1, 0)), 0) AS libur,
                    id_hemxxmh
                FROM htssctd sch
                where sch.tanggal BETWEEN :start_date AND :end_date AND sch.transaction_state = 1
                GROUP BY id_hemxxmh
            ) jad ON jad.id_hemxxmh = peg.id
        ) AS jadwal on jadwal.id_hemxxmh = w.id_hemxxmh
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
        $jab = $row['jab'];
        $hk = $row['s_in_hk'];
        $hari = $row['hari'];
        $jk = $row['jk'];
        $off = $row['off'];
        $nj = $row['nj'];

        if (!isset($pivotedData[$id_hemxxmh])) {
            $pivotedData[$id_hemxxmh] = [
                'id_hemxxmh' => $id_hemxxmh,
                'Nama' => $nama,
                'NIP' => $kode,
                'Jabatan' => $jab,

            ];

            $pivotedData[$id_hemxxmh]['Hari'] = $hari;
            $pivotedData[$id_hemxxmh]['JK'] = $jk;
            $pivotedData[$id_hemxxmh]['OFF'] = $off;
            $pivotedData[$id_hemxxmh]['No Jadwal'] = $nj;

            //Untuk HK
            $total = 0;
            $total = $total + $hk;
            $pivotedData[$id_hemxxmh]['httlpmhHK'] = ceil($hk);

            //Ini foreach column dan data pivot untuk simbol harian
            $sum_cuti_khusus = 0; // Initialize sum for cuti khusus

            foreach ($rs_httlpmh_c as $key => $htl) {
                $is_cuti_khusus_query = $htl['is_cuti_khusus'];

                $kode_htl_trim = str_replace(' ', '', $htl['kode']);
                $data_htl = $row['s_in_'.$kode_htl_trim];

                if ($is_cuti_khusus == 0) {
                    if ($is_cuti_khusus_query == 1) {
                        // Sum the values for cuti khusus
                        $sum_cuti_khusus += $data_htl;
                    } else {
                        // Process other cases
                        $kode_htl = $kode_htl_trim;
                        $total += $data_htl;
                        $pivotedData[$id_hemxxmh]['httlpmh'.$kode_htl] = ceil($data_htl);
                    }
                } else {
                    // Process other cases
                    $kode_htl = $kode_htl_trim;
                    $total += $data_htl;
                    $pivotedData[$id_hemxxmh]['httlpmh'.$kode_htl] = ceil($data_htl);
                    
                }
            }

            // After summing, assign to 'cKhusus'
            if ($is_cuti_khusus == 0) {
                $kode_htl = 'Cuti Khusus';
                $total += $sum_cuti_khusus;
                $pivotedData[$id_hemxxmh]['httlpmh'.$kode_htl] = ceil($sum_cuti_khusus);
            }

            $pivotedData[$id_hemxxmh]['Total'] = ceil($total);

            //Ini foreach column dan data pivot untuk simbol jam
            foreach ($rs_httlpmh_i as $key => $htl_jam) {
                $kode_htl_jam_trim = str_replace(' ', '', $htl_jam['kode']);
                
                $kode_htl_jam = $kode_htl_jam_trim;
                $data_htl_jam = $row['s_in_'.$kode_htl_jam_trim];
                $total = $total + $data_htl;

                $pivotedData[$id_hemxxmh]['htlgJAM'.$kode_htl_jam] = ceil($data_htl_jam);
                // print_r($data_htl."<br>");
            }
        }
		
        // $clock_in = $row['clock_in'];
        // $clock_out = $row['clock_out'];

        // $clock_in_format = $row['clock_in_format'];
        // $clock_out_format = $row['clock_out_format'];
        // $tanggal = $row['tanggal'];

        // // print_r($total);
        // // $pivotedData[$id_hemxxmh][$tanggal] = $clock_in. " - " .$clock_out;
        // $pivotedData[$id_hemxxmh][$tanggal.'In'] = $clock_in_format;
        // $pivotedData[$id_hemxxmh][$tanggal.'Out'] = $clock_out_format;
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
