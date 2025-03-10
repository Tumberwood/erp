<?php
include("../../../../users/init.php");
include("../../../../usersc/lib/DataTables.php");
include("../../../helpers/datatables_fn_debug.php");

use Carbon\Carbon;

use DataTables\Editor;
use DataTables\Editor\Query;
use DataTables\Editor\Result;

$editor = Editor::inst($db, '');

// CEK APAKAH ADA DATANYA
if (isset($_POST['selectedAnswersByQuestion4'], $_POST['kode'], $_POST['id_hcd'])) {
    $tanggal = $_POST['start_date'];
    $selectedAnswersByQuestion4 = $_POST['selectedAnswersByQuestion4'];
    $kode = $_POST['kode'];
    $id_hcd = $_POST['id_hcd'];
    $hasil1 = $_POST['hasil1'];
    $hasil2 = $_POST['hasil2'];
    $hasil3 = $_POST['hasil3'];
    $hasil4 = $_POST['hasil4'];
    $jawaban1 = $_POST['jawaban1'];
    $jawaban2 = $_POST['jawaban2'];
    $jawaban3 = $_POST['jawaban3'];
    $start_at = $_POST['start_at'];
    $finish_at = $_POST['finish_at'];

    try {
        $db->transaction();

        // update TES CFIT
        $sql_update = $editor->db()
            ->query('update', 'hrctsth_cfit')
            ->set('status', 2)
            ;

        // Loop through the array to set the remaining values
        foreach ($jawaban1 as $index => $value) {
            // Access the first element of the $value array
            $answer = $value[0];
            $sql_update->set("part1_soal$index", $answer);
        }

        foreach ($jawaban2 as $index => $values) {
            $answer = implode(', ', $values);
            $sql_update->set("part2_soal$index", $answer);
        }

        foreach ($jawaban3 as $index => $values) {
            $answer = implode(', ', $values);
            $sql_update->set("part3_soal$index", $answer);
        }

        foreach ($selectedAnswersByQuestion4 as $index => $value) {
            // Access the first element of the $value array
            $answer = $value[0];
            $sql_update->set("part4_soal$index", $answer);
        }

        $sql_update->where('kode', $kode);
        $result_update = $sql_update->exec();

        //MENDAPATKAN ID UPDATE TADI
        $sql_select = $editor->db()
		->query('select', 'hrctsth_cfit')
		->get('id')
        ->where('kode', $kode)
		->exec();	// eksekusi query

	    $result_select = $sql_select->fetch();

        // insert HASIL CFIT
        $hasil_insert = $editor->db()
            ->query('insert', 'hrctstd_cfit')
            ->set('id_hrctsth_cfit', $result_select['id'])
            ->set('id_hcdxxmh', $id_hcd)
            ->set('tanggal', $tanggal)
            ->set('start_at', $start_at)
            ->set('finish_at', $finish_at)
            ->set('transaction_state', 1);

        // Loop through the $hasil array to set the remaining values
        for ($i = 1; $i <= 13; $i++) {
            $hasil_insert->set("part1_soal$i", $hasil1[$i]);
        }
        for ($i = 1; $i <= 14; $i++) {
            $hasil_insert->set("part2_soal$i", $hasil2[$i]);
        }
        for ($i = 1; $i <= 13; $i++) {
            $hasil_insert->set("part3_soal$i", $hasil3[$i]);
        }
        for ($i = 1; $i <= 10; $i++) {
            $hasil_insert->set("part4_soal$i", $hasil4[$i]);
        }

        $hasil_insert->exec();

        
        $select_nilai = $db
		->raw()
		->bind(':id_cfit', $result_select['id'])
		->exec(' SELECT
                    CASE WHEN part1_soal1 = 1 THEN 1 ELSE 0 END +
                    CASE WHEN part1_soal2 = 1 THEN 1 ELSE 0 END +
                    CASE WHEN part1_soal3 = 1 THEN 1 ELSE 0 END +
                    CASE WHEN part1_soal4 = 1 THEN 1 ELSE 0 END +
                    CASE WHEN part1_soal5 = 1 THEN 1 ELSE 0 END +
                    CASE WHEN part1_soal6 = 1 THEN 1 ELSE 0 END +
                    CASE WHEN part1_soal7 = 1 THEN 1 ELSE 0 END +
                    CASE WHEN part1_soal8 = 1 THEN 1 ELSE 0 END +
                    CASE WHEN part1_soal9 = 1 THEN 1 ELSE 0 END +
                    CASE WHEN part1_soal10 = 1 THEN 1 ELSE 0 END +
                    CASE WHEN part1_soal11 = 1 THEN 1 ELSE 0 END +
                    CASE WHEN part1_soal12 = 1 THEN 1 ELSE 0 END +
                    CASE WHEN part1_soal13 = 1 THEN 1 ELSE 0 END +
                    CASE WHEN part2_soal1 = 1 THEN 1 ELSE 0 END +
                    CASE WHEN part2_soal2 = 1 THEN 1 ELSE 0 END +
                    CASE WHEN part2_soal3 = 1 THEN 1 ELSE 0 END +
                    CASE WHEN part2_soal4 = 1 THEN 1 ELSE 0 END +
                    CASE WHEN part2_soal5 = 1 THEN 1 ELSE 0 END +
                    CASE WHEN part2_soal6 = 1 THEN 1 ELSE 0 END +
                    CASE WHEN part2_soal7 = 1 THEN 1 ELSE 0 END +
                    CASE WHEN part2_soal8 = 1 THEN 1 ELSE 0 END +
                    CASE WHEN part2_soal9 = 1 THEN 1 ELSE 0 END +
                    CASE WHEN part2_soal10 = 1 THEN 1 ELSE 0 END +
                    CASE WHEN part2_soal11 = 1 THEN 1 ELSE 0 END +
                    CASE WHEN part2_soal12 = 1 THEN 1 ELSE 0 END +
                    CASE WHEN part2_soal13 = 1 THEN 1 ELSE 0 END +
                    CASE WHEN part2_soal14 = 1 THEN 1 ELSE 0 END +
                    CASE WHEN part3_soal1 = 1 THEN 1 ELSE 0 END +
                    CASE WHEN part3_soal2 = 1 THEN 1 ELSE 0 END +
                    CASE WHEN part3_soal3 = 1 THEN 1 ELSE 0 END +
                    CASE WHEN part3_soal4 = 1 THEN 1 ELSE 0 END +
                    CASE WHEN part3_soal5 = 1 THEN 1 ELSE 0 END +
                    CASE WHEN part3_soal6 = 1 THEN 1 ELSE 0 END +
                    CASE WHEN part3_soal7 = 1 THEN 1 ELSE 0 END +
                    CASE WHEN part3_soal8 = 1 THEN 1 ELSE 0 END +
                    CASE WHEN part3_soal9 = 1 THEN 1 ELSE 0 END +
                    CASE WHEN part3_soal10 = 1 THEN 1 ELSE 0 END +
                    CASE WHEN part3_soal11 = 1 THEN 1 ELSE 0 END +
                    CASE WHEN part3_soal12 = 1 THEN 1 ELSE 0 END +
                    CASE WHEN part3_soal13 = 1 THEN 1 ELSE 0 END +
                    CASE WHEN part4_soal1 = 1 THEN 1 ELSE 0 END +
                    CASE WHEN part4_soal2 = 1 THEN 1 ELSE 0 END +
                    CASE WHEN part4_soal3 = 1 THEN 1 ELSE 0 END +
                    CASE WHEN part4_soal4 = 1 THEN 1 ELSE 0 END +
                    CASE WHEN part4_soal5 = 1 THEN 1 ELSE 0 END +
                    CASE WHEN part4_soal6 = 1 THEN 1 ELSE 0 END +
                    CASE WHEN part4_soal7 = 1 THEN 1 ELSE 0 END +
                    CASE WHEN part4_soal8 = 1 THEN 1 ELSE 0 END +
                    CASE WHEN part4_soal9 = 1 THEN 1 ELSE 0 END +
                    CASE WHEN part4_soal10 = 1 THEN 1 ELSE 0 END AS total_sum
                FROM
                    hrctstd_cfit
                WHERE id_hrctsth_cfit = :id_cfit
				'
				);
		$nilai = $select_nilai->fetch();
        $total = $nilai['total_sum'] * 2;

        if ($nilai['total_sum'] == 14) {
            $iq = 75;
        } else if ($nilai['total_sum'] == 15) {
            $iq = 78;
        } else if ($nilai['total_sum'] == 16) {
            $iq = 81;
        } else if ($nilai['total_sum'] == 17) {
            $iq = 85;
        } else if ($nilai['total_sum'] == 18) {
            $iq = 88;
        } else if ($nilai['total_sum'] == 19) {
            $iq = 91;
        } else if ($nilai['total_sum'] == 20) {
            $iq = 94;
        } else if ($nilai['total_sum'] == 21) {
            $iq = 96;
        } else if ($nilai['total_sum'] == 22) {
            $iq = 100;
        } else if ($nilai['total_sum'] == 23) {
            $iq = 103;
        } else if ($nilai['total_sum'] == 24) {
            $iq = 106;
        } else if ($nilai['total_sum'] == 25) {
            $iq = 109;
        } else if ($nilai['total_sum'] == 26) {
            $iq = 113;
        } else if ($nilai['total_sum'] == 27) {
            $iq = 116;
        } else if ($nilai['total_sum'] == 28) {
            $iq = 119;
        } else if ($nilai['total_sum'] == 29) {
            $iq = 121;
        } else if ($nilai['total_sum'] == 30) {
            $iq = 124;
        } else if ($nilai['total_sum'] == 31) {
            $iq = 128;
        } else if ($nilai['total_sum'] == 32) {
            $iq = 131;
        } else if ($nilai['total_sum'] == 33) {
            $iq = 133;
        } else if ($nilai['total_sum'] == 34) {
            $iq = 137;
        } else if ($nilai['total_sum'] == 35) {
            $iq = 140;
        } else if ($nilai['total_sum'] == 36) {
            $iq = 142;
        } else if ($nilai['total_sum'] == 37) {
            $iq = 145;
        } else if ($nilai['total_sum'] == 38) {
            $iq = 149;
        } else if ($nilai['total_sum'] == 39) {
            $iq = 152;
        } else if ($nilai['total_sum'] == 40) {
            $iq = 155;
        } else if ($nilai['total_sum'] == 41) {
            $iq = 157;
        } else if ($nilai['total_sum'] == 42) {
            $iq = 161;
        } else if ($nilai['total_sum'] == 43) {
            $iq = 165;
        } else if ($nilai['total_sum'] == 44) {
            $iq = 167;
        } else if ($nilai['total_sum'] == 45) {
            $iq = 169;
        } else if ($nilai['total_sum'] == 46) {
            $iq = 173;
        } else if ($nilai['total_sum'] == 47) {
            $iq = 176;
        } else if ($nilai['total_sum'] == 48) {
            $iq = 179;
        } else if ($nilai['total_sum'] == 49) {
            $iq = 183;
        } else if ($nilai['total_sum'] == 50) {
            $iq = 185;
        } else {
            $iq = 0;
        }

        if ($iq >= 170) {
            $category = "GENIUS";
        } else if ($iq >= 140 && $iq <= 169) {
            $category = "VERY SUPERIOR";
        } else if ($iq >= 120 && $iq <= 139) {
            $category = "SUPERIOR";
        } else if ($iq >= 110 && $iq <= 119) {
            $category = "HIGH AVERAGE";
        } else if ($iq >= 90 && $iq <= 109) {
            $category = "AVERAGE";
        } else if ($iq >= 84 && $iq <= 89) {
            $category = "LOW AVERAGE";
        } else if ($iq >= 75 && $iq <= 83) {
            $category = "BORDERLINE MENTAL RETARDATION";
        } else {
            $category = "UNKNOWN";
        }

        $hasil_update = $editor->db()
        ->query('update', 'hrctstd_cfit')
        ->set('total_benar', $nilai['total_sum'])
        ->set('total_nilai', $total)
        ->set('iq', $iq)
        ->set('keterangan', $category);
        $hasil_update->where('id_hrctsth_cfit', $result_select['id']);
        $hasil_update->exec();

        $db->commit();
    } catch (Exception $e) {
        // Handle the exception and rollback the transaction
        $db->rollback();
        echo 'Error: ' . $e->getMessage();
    }
} else {
    echo 'Error: Missing required POST data.';
}
?>
