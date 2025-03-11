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
if (isset($_POST['limitedResult'], $_POST['kode'])) {
    $limitedResult = $_POST['limitedResult'];
    $tanggal = date('Y-m-d');
    $kode = $_POST['kode'];
    
    try {
        $db->transaction();

        // Update TES DISC
        $sql_update = $editor->db()
            ->query('update', 'hrctsth_disc')
            ->set('status', 2)
            ->set('tanggal', $tanggal);

        // INSERT SOAL1_P SAMPAI SOAL24_P ===== Ganjil = K, Genap = P;
        for ($i = 0; $i < count($limitedResult); $i += 2) {
            $columnName = "soal" . ($i / 2 + 1) . "_p";
            $answer = isset($limitedResult[$i]['gambaran']) ? $limitedResult[$i]['gambaran'] : "";
        
            $sql_update->set($columnName, $answer);
        }

        // INSERT SOAL1_K SAMPAI SOAL24_K
        for ($i = 1; $i < count($limitedResult); $i += 2) {
            $columnName = "soal" . (($i - 1) / 2 + 1) . "_k";
            $answer = isset($limitedResult[$i]['gambaran']) ? $limitedResult[$i]['gambaran'] : "";
        
            $sql_update->set($columnName, $answer);
        }
        $sql_update->where('kode', $kode);
        $update_hrctsth_disc = $sql_update->exec();

        //Deklarasi Variabel D I S C *
        //tab 1 P
        $p_tab1_d = 0;
        $p_tab1_i = 0;
        $p_tab1_s = 0;
        $p_tab1_c = 0;
        $p_tab1_star = 0;
        
        //tab 1 K
        $k_tab1_d = 0;
        $k_tab1_i = 0;
        $k_tab1_s = 0;
        $k_tab1_c = 0;
        $k_tab1_star = 0;

        //tab 2 P
        $p_tab2_d = 0;
        $p_tab2_i = 0;
        $p_tab2_s = 0;
        $p_tab2_c = 0;
        $p_tab2_star = 0;
        
        //tab 2 K
        $k_tab2_d = 0;
        $k_tab2_i = 0;
        $k_tab2_s = 0;
        $k_tab2_c = 0;
        $k_tab2_star = 0;

        //tab 3 P
        $p_tab3_d = 0;
        $p_tab3_i = 0;
        $p_tab3_s = 0;
        $p_tab3_c = 0;
        $p_tab3_star = 0;
        
        //tab 3 K
        $k_tab3_d = 0;
        $k_tab3_i = 0;
        $k_tab3_s = 0;
        $k_tab3_c = 0;
        $k_tab3_star = 0;
        
        //$limitedResult hasil json seperti ini
        // {0
        // : 
        // answer
        // : 
        // "p"
        // gambaran
        // : 
        // "1"
        // table
        // : 
        // "Soal 1"
        // : 
        // 1
        // : 
        // answer
        // : 
        // "k"
        // gambaran
        // : 
        // "2"
        // table
        // : 
        // "Soal 1"
        // :}
        
        //koreksi P dulu
        if (isset($limitedResult[0]['gambaran'])) {
            if ($limitedResult[0]['gambaran'] == 1) {
                $p_tab1_s = $p_tab1_s + 1;
            } else if ($limitedResult[0]['gambaran'] == 2) {
                $p_tab1_i = $p_tab1_i + 1;
            } else if ($limitedResult[0]['gambaran'] == 3) {
                $p_tab1_star = $p_tab1_star + 1;
            } else if ($limitedResult[0]['gambaran'] == 4) {
                $p_tab1_c = $p_tab1_c + 1;
            } else {
                $p_tab1_star = $p_tab1_star;
            }
        }

        if (isset($limitedResult[2]['gambaran'])) {
            if ($limitedResult[2]['gambaran'] == 1) {
                $p_tab1_c = $p_tab1_c +1;
            } else if ($limitedResult[2]['gambaran'] == 2) {
                $p_tab1_d = $p_tab1_d +1;
            } else if ($limitedResult[2]['gambaran'] == 3) {
                $p_tab1_star = $p_tab1_star +1;
            } else if ($limitedResult[2]['gambaran'] == 4) {
                $p_tab1_s = $p_tab1_s +1;
            } else {
                $p_tab1_star = $p_tab1_star +1;
            }
        }

        if (isset($limitedResult[4]['gambaran'])) {
            if ($limitedResult[4]['gambaran'] == 1) {
                $p_tab1_i = $p_tab1_i +1;
            } else if ($limitedResult[4]['gambaran'] == 2) {
                $p_tab1_star = $p_tab1_star +1;
            } else if ($limitedResult[4]['gambaran'] == 3) {
                $p_tab1_star = $p_tab1_star +1;
            } else if ($limitedResult[4]['gambaran'] == 4) {
                $p_tab1_d = $p_tab1_d +1;
            } else {
                $p_tab1_star = $p_tab1_star +1;
            }
        }

        if (isset($limitedResult[6]['gambaran'])) {
            if ($limitedResult[6]['gambaran'] == 1) {
                $p_tab1_c = $p_tab1_c +1;
            } else if ($limitedResult[6]['gambaran'] == 2) {
                $p_tab1_s = $p_tab1_s +1;
            } else if ($limitedResult[6]['gambaran'] == 3) {
                $p_tab1_star = $p_tab1_star +1;
            } else if ($limitedResult[6]['gambaran'] == 4) {
                $p_tab1_d = $p_tab1_d +1;
            } else {
                $p_tab1_star = $p_tab1_star +1;
            }
        }

        if (isset($limitedResult[8]['gambaran'])) {
            if ($limitedResult[8]['gambaran'] == 1) {
                $p_tab1_i = $p_tab1_i +1;
            } else if ($limitedResult[8]['gambaran'] == 2) {
                $p_tab1_d = $p_tab1_d +1;
            } else if ($limitedResult[8]['gambaran'] == 3) {
                $p_tab1_s = $p_tab1_s +1;
            } else if ($limitedResult[8]['gambaran'] == 4) {
                $p_tab1_star = $p_tab1_star +1;
            } else {
                $p_tab1_star = $p_tab1_star +1;
            }
        }

        if (isset($limitedResult[10]['gambaran'])) {
            if ($limitedResult[10]['gambaran'] == 1) {
                $p_tab1_c = $p_tab1_c +1;
            } else if ($limitedResult[10]['gambaran'] == 2) {
                $p_tab1_d = $p_tab1_d +1;
            } else if ($limitedResult[10]['gambaran'] == 3) {
                $p_tab1_i = $p_tab1_i +1;
            } else if ($limitedResult[10]['gambaran'] == 4) {
                $p_tab1_s = $p_tab1_s +1;
            } else {
                $p_tab1_star = $p_tab1_star +1;
            }
        }

        if (isset($limitedResult[12]['gambaran'])) {
            if ($limitedResult[12]['gambaran'] == 1) {
                $p_tab1_s = $p_tab1_s +1;
            } else if ($limitedResult[12]['gambaran'] == 2) {
                $p_tab1_i = $p_tab1_i +1;
            } else if ($limitedResult[12]['gambaran'] == 3) {
                $p_tab1_star = $p_tab1_star +1;
            } else if ($limitedResult[12]['gambaran'] == 4) {
                $p_tab1_star = $p_tab1_star +1;
            } else {
                $p_tab1_star = $p_tab1_star +1;
            }
        }

        if (isset($limitedResult[14]['gambaran'])) {
            if ($limitedResult[14]['gambaran'] == 1) {
                $p_tab1_i = $p_tab1_i +1;
            } else if ($limitedResult[14]['gambaran'] == 2) {
                $p_tab1_s = $p_tab1_s +1;
            } else if ($limitedResult[14]['gambaran'] == 3) {
                $p_tab1_c = $p_tab1_c +1;
            } else if ($limitedResult[14]['gambaran'] == 4) {
                $p_tab1_d = $p_tab1_d +1;
            } else {
                $p_tab1_star = $p_tab1_star +1;
            }
        }

        //tab 2 P == genap
        if (isset($limitedResult[16]['gambaran'])) {
            if ($limitedResult[16]['gambaran'] == 1) {
                $p_tab2_d = $p_tab2_d + 1;
            } else if ($limitedResult[16]['gambaran'] == 2) {
                $p_tab2_c = $p_tab2_c + 1;
            } else if ($limitedResult[16]['gambaran'] == 3) {
                $p_tab2_star = $p_tab2_star + 1;
            } else if ($limitedResult[16]['gambaran'] == 4) {
                $p_tab2_star = $p_tab2_star + 1;
            } else {
                $p_tab2_star = $p_tab2_star + 1;
            }
        }

        if (isset($limitedResult[18]['gambaran'])) {
            if ($limitedResult[18]['gambaran'] == 1) {
                $p_tab2_star = $p_tab2_star + 1;
            } else if ($limitedResult[18]['gambaran'] == 2) {
                $p_tab2_d = $p_tab2_d + 1;
            } else if ($limitedResult[18]['gambaran'] == 3) {
                $p_tab2_s = $p_tab2_s + 1;
            } else if ($limitedResult[18]['gambaran'] == 4) {
                $p_tab2_i = $p_tab2_i + 1;
            } else {
                $p_tab2_star = $p_tab2_star + 1;
            }
        }

        if (isset($limitedResult[20]['gambaran'])) {
            if ($limitedResult[20]['gambaran'] == 1) {
                $p_tab2_s = $p_tab2_s + 1;
            } else if ($limitedResult[20]['gambaran'] == 2) {
                $p_tab2_star = $p_tab2_star + 1;
            } else if ($limitedResult[20]['gambaran'] == 3) {
                $p_tab2_d = $p_tab2_d + 1;
            } else if ($limitedResult[20]['gambaran'] == 4) {
                $p_tab2_c = $p_tab2_c + 1;
            } else {
                $p_tab2_star = $p_tab2_star + 1;
            }
        }

        if (isset($limitedResult[22]['gambaran'])) {
            if ($limitedResult[22]['gambaran'] == 1) {
                $p_tab2_star = $p_tab2_star + 1;
            } else if ($limitedResult[22]['gambaran'] == 2) {
                $p_tab2_c = $p_tab2_c + 1;
            } else if ($limitedResult[22]['gambaran'] == 3) {
                $p_tab2_i = $p_tab2_i + 1;
            } else if ($limitedResult[22]['gambaran'] == 4) {
                $p_tab2_d = $p_tab2_d + 1;
            } else {
                $p_tab2_star = $p_tab2_star + 1;
            }
        }

        if (isset($limitedResult[24]['gambaran'])) {
            if ($limitedResult[24]['gambaran'] == 1) {
                $p_tab2_d = $p_tab2_d + 1;
            } else if ($limitedResult[24]['gambaran'] == 2) {
                $p_tab2_s = $p_tab2_s + 1;
            } else if ($limitedResult[24]['gambaran'] == 3) {
                $p_tab2_i = $p_tab2_i + 1;
            } else if ($limitedResult[24]['gambaran'] == 4) {
                $p_tab2_star = $p_tab2_star + 1;
            } else {
                $p_tab2_star = $p_tab2_star + 1;
            }
        }

        if (isset($limitedResult[26]['gambaran'])) {
            if ($limitedResult[26]['gambaran'] == 1) {
                $p_tab2_c = $p_tab2_c + 1;
            } else if ($limitedResult[26]['gambaran'] == 2) {
                $p_tab2_i = $p_tab2_i + 1;
            } else if ($limitedResult[26]['gambaran'] == 3) {
                $p_tab2_s = $p_tab2_s + 1;
            } else if ($limitedResult[26]['gambaran'] == 4) {
                $p_tab2_d = $p_tab2_d + 1;
            } else {
                $p_tab2_star = $p_tab2_star + 1;
            }
        }

        if (isset($limitedResult[28]['gambaran'])) {
            if ($limitedResult[28]['gambaran'] == 1) {
                $p_tab2_s = $p_tab2_s + 1;
            } else if ($limitedResult[28]['gambaran'] == 2) {
                $p_tab2_c = $p_tab2_c + 1;
            } else if ($limitedResult[28]['gambaran'] == 3) {
                $p_tab2_i = $p_tab2_i + 1;
            } else if ($limitedResult[28]['gambaran'] == 4) {
                $p_tab2_d = $p_tab2_d + 1;
            } else {
                $p_tab2_star = $p_tab2_star + 1;
            }
        }

        if (isset($limitedResult[30]['gambaran'])) {
            if ($limitedResult[30]['gambaran'] == 1) {
                $p_tab2_star = $p_tab2_star + 1;
            } else if ($limitedResult[30]['gambaran'] == 2) {
                $p_tab2_c = $p_tab2_c + 1;
            } else if ($limitedResult[30]['gambaran'] == 3) {
                $p_tab2_i = $p_tab2_i + 1;
            } else if ($limitedResult[30]['gambaran'] == 4) {
                $p_tab2_s = $p_tab2_s + 1;
            } else {
                $p_tab2_star = $p_tab2_star + 1;
            }
        }


        //TAB 3    BEGIN P ----> GANJIL
        if (isset($limitedResult[32]['gambaran'])) {
            if ($limitedResult[32]['gambaran'] == 1) {
                $p_tab3_star = $p_tab3_star + 1;
            } else if ($limitedResult[32]['gambaran'] == 2) {
                $p_tab3_d = $p_tab3_d + 1;
            } else if ($limitedResult[32]['gambaran'] == 3) {
                $p_tab3_s = $p_tab3_s + 1;
            } else if ($limitedResult[32]['gambaran'] == 4) {
                $p_tab3_i = $p_tab3_i + 1;
            } else { 
                $p_tab3_star = $p_tab3_star + 1;
            }
        }

        if (isset($limitedResult[34]['gambaran'])) {
            if ($limitedResult[34]['gambaran'] == 1) {
                $p_tab3_d = $p_tab3_d + 1;
            } else if ($limitedResult[34]['gambaran'] == 2) {
                $p_tab3_star = $p_tab3_star + 1;
            } else if ($limitedResult[34]['gambaran'] == 3) {
                $p_tab3_star = $p_tab3_star + 1;
            } else if ($limitedResult[34]['gambaran'] == 4) {
                $p_tab3_c = $p_tab3_c + 1;
            } else { 
                $p_tab3_star = $p_tab3_star + 1;
            }
        }

        if (isset($limitedResult[36]['gambaran'])) {
            if ($limitedResult[36]['gambaran'] == 1) {
                $p_tab3_d = $p_tab3_d + 1;
            } else if ($limitedResult[36]['gambaran'] == 2) {
                $p_tab3_s = $p_tab3_s + 1;
            } else if ($limitedResult[36]['gambaran'] == 3) {
                $p_tab3_i = $p_tab3_i + 1;
            } else if ($limitedResult[36]['gambaran'] == 4) {
                $p_tab3_star = $p_tab3_star + 1;
            } else { 
                $p_tab3_star = $p_tab3_star + 1;
            }
        }

        if (isset($limitedResult[38]['gambaran'])) {
            if ($limitedResult[38]['gambaran'] == 1) {
                $p_tab3_d = $p_tab3_d + 1;
            } else if ($limitedResult[38]['gambaran'] == 2) {
                $p_tab3_s = $p_tab3_s + 1;
            } else if ($limitedResult[38]['gambaran'] == 3) {
                $p_tab3_i = $p_tab3_i + 1;
            } else if ($limitedResult[38]['gambaran'] == 4) {
                $p_tab3_c = $p_tab3_c + 1;
            } else { 
                $p_tab3_star = $p_tab3_star + 1;
            }
        }

        if (isset($limitedResult[40]['gambaran'])) {
            if ($limitedResult[40]['gambaran'] == 1) {
                $p_tab3_s = $p_tab3_s + 1;
            } else if ($limitedResult[40]['gambaran'] == 2) {
                $p_tab3_d = $p_tab3_d + 1;
            } else if ($limitedResult[40]['gambaran'] == 3) {
                $p_tab3_i = $p_tab3_i + 1;
            } else if ($limitedResult[40]['gambaran'] == 4) {
                $p_tab3_star = $p_tab3_star + 1;
            } else { 
                $p_tab3_star = $p_tab3_star + 1;
            }
        }

        if (isset($limitedResult[42]['gambaran'])) {
            if ($limitedResult[42]['gambaran'] == 1) {
                $p_tab3_s = $p_tab3_s + 1;
            } else if ($limitedResult[42]['gambaran'] == 2) {
                $p_tab3_star = $p_tab3_star + 1;
            } else if ($limitedResult[42]['gambaran'] == 3) {
                $p_tab3_d = $p_tab3_d + 1;
            } else if ($limitedResult[42]['gambaran'] == 4) {
                $p_tab3_c = $p_tab3_c + 1;
            } else { 
                $p_tab3_star = $p_tab3_star + 1;
            }
        }

        if (isset($limitedResult[44]['gambaran'])) {
            if ($limitedResult[44]['gambaran'] == 1) {
                $p_tab3_star = $p_tab3_star + 1;
            } else if ($limitedResult[44]['gambaran'] == 2) {
                $p_tab3_i = $p_tab3_i + 1;
            } else if ($limitedResult[44]['gambaran'] == 3) {
                $p_tab3_s = $p_tab3_s + 1;
            } else if ($limitedResult[44]['gambaran'] == 4) {
                $p_tab3_star = $p_tab3_star + 1;
            } else { 
                $p_tab3_star = $p_tab3_star + 1;
            }
        }

        if (isset($limitedResult[46]['gambaran'])) {
            if ($limitedResult[46]['gambaran'] == 1) {
                $p_tab3_star = $p_tab3_star + 1;
            } else if ($limitedResult[46]['gambaran'] == 2) {
                $p_tab3_i = $p_tab3_i + 1;
            } else if ($limitedResult[46]['gambaran'] == 3) {
                $p_tab3_d = $p_tab3_d + 1;
            } else if ($limitedResult[46]['gambaran'] == 4) {
                $p_tab3_c = $p_tab3_c + 1;
            } else { 
                $p_tab3_star = $p_tab3_star + 1;
            }
        }
        
//////////////////////////////////////////////////////////////////////////////////////////
        //k === index ganjil

        if (isset($limitedResult[1]['gambaran'])) {
            if ($limitedResult[1]['gambaran'] == 1) {
                $k_tab1_s = $k_tab1_s +1;
            } else if ($limitedResult[1]['gambaran'] == 2) {
                $k_tab1_i = $k_tab1_i +1;
            } else if ($limitedResult[1]['gambaran'] == 3) {
                $k_tab1_d = $k_tab1_d +1;
            } else if ($limitedResult[1]['gambaran'] == 4) {
                $k_tab1_c = $k_tab1_c +1;
            } else {
                $k_tab1_star = $k_tab1_star +1;
            }
        }
        
        if (isset($limitedResult[3]['gambaran'])) {
            if ($limitedResult[3]['gambaran'] == 1) {
                $k_tab1_star = $k_tab1_star +1;
            } else if ($limitedResult[3]['gambaran'] == 2) {
                $k_tab1_d = $k_tab1_d +1;
            } else if ($limitedResult[3]['gambaran'] == 3) {
                $k_tab1_i = $k_tab1_i +1;
            } else if ($limitedResult[3]['gambaran'] == 4) {
                $k_tab1_s = $k_tab1_s +1;
            } else {
                $k_tab1_star = $k_tab1_star +1;
            }
        }
        
        if (isset($limitedResult[5]['gambaran'])) {
            if ($limitedResult[5]['gambaran'] == 1) {
                $k_tab1_i = $k_tab1_i +1;
            } else if ($limitedResult[5]['gambaran'] == 2) {
                $k_tab1_c = $k_tab1_c +1;
            } else if ($limitedResult[5]['gambaran'] == 3) {
                $k_tab1_s = $k_tab1_s +1;
            } else if ($limitedResult[5]['gambaran'] == 4) {
                $k_tab1_star = $k_tab1_star +1;
            } else {
                $k_tab1_star = $k_tab1_star +1;
            }
        }
        
        if (isset($limitedResult[7]['gambaran'])) {
            if ($limitedResult[7]['gambaran'] == 1) {
                $k_tab1_c = $k_tab1_c +1;
            } else if ($limitedResult[7]['gambaran'] == 2) {
                $k_tab1_s = $k_tab1_s +1;
            } else if ($limitedResult[7]['gambaran'] == 3) {
                $k_tab1_i = $k_tab1_i +1;
            } else if ($limitedResult[7]['gambaran'] == 4) {
                $k_tab1_d = $k_tab1_d +1;
            } else {
                $k_tab1_star = $k_tab1_star +1;
            }
        }
        
        if (isset($limitedResult[9]['gambaran'])) {
            if ($limitedResult[9]['gambaran'] == 1) {
                $k_tab1_star = $k_tab1_star +1;
            } else if ($limitedResult[9]['gambaran'] == 2) {
                $k_tab1_d = $k_tab1_d +1;
            } else if ($limitedResult[9]['gambaran'] == 3) {
                $k_tab1_s = $k_tab1_s +1;
            } else if ($limitedResult[9]['gambaran'] == 4) {
                $k_tab1_c = $k_tab1_c +1;
            } else {
                $k_tab1_star = $k_tab1_star +1;
            }
        }
        
        if (isset($limitedResult[11]['gambaran'])) {
            if ($limitedResult[11]['gambaran'] == 1) {
                $k_tab1_star = $k_tab1_star +1;
            } else if ($limitedResult[11]['gambaran'] == 2) {
                $k_tab1_d = $k_tab1_d +1;
            } else if ($limitedResult[11]['gambaran'] == 3) {
                $k_tab1_i = $k_tab1_i +1;
            } else if ($limitedResult[11]['gambaran'] == 4) {
                $k_tab1_s = $k_tab1_s +1;
            } else {
                $k_tab1_star = $k_tab1_star +1;
            }
        }
        
        if (isset($limitedResult[13]['gambaran'])) {
            if ($limitedResult[13]['gambaran'] == 1) {
                $k_tab1_star = $k_tab1_star +1;
            } else if ($limitedResult[13]['gambaran'] == 2) {
                $k_tab1_i = $k_tab1_i +1;
            } else if ($limitedResult[13]['gambaran'] == 3) {
                $k_tab1_c = $k_tab1_c +1;
            } else if ($limitedResult[13]['gambaran'] == 4) {
                $k_tab1_d = $k_tab1_d +1;
            } else {
                $k_tab1_star = $k_tab1_star +1;
            }
        }
        
        if (isset($limitedResult[15]['gambaran'])) {
            if ($limitedResult[15]['gambaran'] == 1) {
                $k_tab1_i = $k_tab1_i +1;
            } else if ($limitedResult[15]['gambaran'] == 2) {
                $k_tab1_s = $k_tab1_s +1;
            } else if ($limitedResult[15]['gambaran'] == 3) {
                $k_tab1_c = $k_tab1_c +1;
            } else if ($limitedResult[15]['gambaran'] == 4) {
                $k_tab1_d = $k_tab1_d +1;
            } else {
                $k_tab1_star = $k_tab1_star +1;
            }
        }

        //TAB 2 K ===> GANJIL
        if (isset($limitedResult[17]['gambaran'])) {
            if ($limitedResult[17]['gambaran'] == 1) {
                $k_tab2_d = $k_tab2_d + 1;
            } else if ($limitedResult[17]['gambaran'] == 2) {
                $k_tab2_c = $k_tab2_c + 1;
            } else if ($limitedResult[17]['gambaran'] == 3) {
                $k_tab2_i = $k_tab2_i + 1;
            } else if ($limitedResult[17]['gambaran'] == 4) {
                $k_tab2_s = $k_tab2_s + 1;
            } else { 
                $k_tab2_star = $k_tab2_star + 1;
            }
        }

        if (isset($limitedResult[19]['gambaran'])) {
            if ($limitedResult[19]['gambaran'] == 1) {
                $k_tab2_c = $k_tab2_c + 1;
            } else if ($limitedResult[19]['gambaran'] == 2) {
                $k_tab2_d = $k_tab2_d + 1;
            } else if ($limitedResult[19]['gambaran'] == 3) {
                $k_tab2_s = $k_tab2_s + 1;
            } else if ($limitedResult[19]['gambaran'] == 4) {
                $k_tab2_star = $k_tab2_star + 1;
            } else { 
                $k_tab2_star = $k_tab2_star + 1;
            }
        }

        if (isset($limitedResult[21]['gambaran'])) {
            if ($limitedResult[21]['gambaran'] == 1) {
                $k_tab2_star = $k_tab2_star + 1;
            } else if ($limitedResult[21]['gambaran'] == 2) {
                $k_tab2_i = $k_tab2_i + 1;
            } else if ($limitedResult[21]['gambaran'] == 3) {
                $k_tab2_d = $k_tab2_d + 1;
            } else if ($limitedResult[21]['gambaran'] == 4) {
                $k_tab2_c = $k_tab2_c + 1;
            } else { 
                $k_tab2_star = $k_tab2_star + 1;
            }
        }

        if (isset($limitedResult[23]['gambaran'])) {
            if ($limitedResult[23]['gambaran'] == 1) {
                $k_tab2_s = $k_tab2_s + 1;
            } else if ($limitedResult[23]['gambaran'] == 2) {
                $k_tab2_star = $k_tab2_star + 1;
            } else if ($limitedResult[23]['gambaran'] == 3) {
                $k_tab2_i = $k_tab2_i + 1;
            } else if ($limitedResult[23]['gambaran'] == 4) {
                $k_tab2_d = $k_tab2_d + 1;
            } else { 
                $k_tab2_star = $k_tab2_star + 1;
            }
        }

        if (isset($limitedResult[25]['gambaran'])) {
            if ($limitedResult[25]['gambaran'] == 1) {
                $k_tab2_d = $k_tab2_d + 1;
            } else if ($limitedResult[25]['gambaran'] == 2) {
                $k_tab2_star = $k_tab2_star + 1;
            } else if ($limitedResult[25]['gambaran'] == 3) {
                $k_tab2_star = $k_tab2_star + 1;
            } else if ($limitedResult[25]['gambaran'] == 4) {
                $k_tab2_c = $k_tab2_c + 1;
            } else { 
                $k_tab2_star = $k_tab2_star + 1;
            }
        }

        if (isset($limitedResult[27]['gambaran'])) {
            if ($limitedResult[27]['gambaran'] == 1) {
                $k_tab2_c = $k_tab2_c + 1;
            } else if ($limitedResult[27]['gambaran'] == 2) {
                $k_tab2_i = $k_tab2_i + 1;
            } else if ($limitedResult[27]['gambaran'] == 3) {
                $k_tab2_star = $k_tab2_star + 1;
            } else if ($limitedResult[27]['gambaran'] == 4) {
                $k_tab2_d = $k_tab2_d + 1;
            } else { 
                $k_tab2_star = $k_tab2_star + 1;
            }
        }

        if (isset($limitedResult[29]['gambaran'])) {
            if ($limitedResult[29]['gambaran'] == 1) {
                $k_tab2_s = $k_tab2_s + 1;
            } else if ($limitedResult[29]['gambaran'] == 2) {
                $k_tab2_star = $k_tab2_star + 1;
            } else if ($limitedResult[29]['gambaran'] == 3) {
                $k_tab2_i = $k_tab2_i + 1;
            } else if ($limitedResult[29]['gambaran'] == 4) {
                $k_tab2_d = $k_tab2_d + 1;
            } else { 
                $k_tab2_star = $k_tab2_star + 1;
            }
        }

        if (isset($limitedResult[31]['gambaran'])) {
            if ($limitedResult[31]['gambaran'] == 1) {
                $k_tab2_d = $k_tab2_d + 1;
            } else if ($limitedResult[31]['gambaran'] == 2) {
                $k_tab2_star = $k_tab2_star + 1;
            } else if ($limitedResult[31]['gambaran'] == 3) {
                $k_tab2_i = $k_tab2_i + 1;
            } else if ($limitedResult[31]['gambaran'] == 4) {
                $k_tab2_s = $k_tab2_s + 1;
            } else { 
                $k_tab2_star = $k_tab2_star + 1;
            }
        }

        //TAB 3 BEGIN K ----> GENAP
        if (isset($limitedResult[33]['gambaran'])) {
            if ($limitedResult[33]['gambaran'] == 1) {
                $k_tab3_c = $k_tab3_c + 1;
            } else if ($limitedResult[33]['gambaran'] == 2) {
                $k_tab3_d = $k_tab3_d + 1;
            } else if ($limitedResult[33]['gambaran'] == 3) {
                $k_tab3_s = $k_tab3_s + 1;
            } else if ($limitedResult[33]['gambaran'] == 4) {
                $k_tab3_star = $k_tab3_star + 1;
            } else { 
                $k_tab3_star = $k_tab3_star + 1;
            }
        }

        if (isset($limitedResult[35]['gambaran'])) {
            if ($limitedResult[35]['gambaran'] == 1) {
                $k_tab3_d = $k_tab3_d + 1;
            } else if ($limitedResult[35]['gambaran'] == 2) {
                $k_tab3_i = $k_tab3_i + 1;
            } else if ($limitedResult[35]['gambaran'] == 3) {
                $k_tab3_s = $k_tab3_s + 1;
            } else if ($limitedResult[35]['gambaran'] == 4) {
                $k_tab3_star = $k_tab3_star + 1;
            } else { 
                $k_tab3_star = $k_tab3_star + 1;
            }
        }

        if (isset($limitedResult[37]['gambaran'])) {
            if ($limitedResult[37]['gambaran'] == 1) {
                $k_tab3_d = $k_tab3_d + 1;
            } else if ($limitedResult[37]['gambaran'] == 2) {
                $k_tab3_star = $k_tab3_star + 1;
            } else if ($limitedResult[37]['gambaran'] == 3) {
                $k_tab3_i = $k_tab3_i + 1;
            } else if ($limitedResult[37]['gambaran'] == 4) {
                $k_tab3_c = $k_tab3_c + 1;
            } else { 
                $k_tab3_star = $k_tab3_star + 1;
            }
        }

        if (isset($limitedResult[39]['gambaran'])) {
            if ($limitedResult[39]['gambaran'] == 1) {
                $k_tab3_star = $k_tab3_star + 1;
            } else if ($limitedResult[39]['gambaran'] == 2) {
                $k_tab3_s = $k_tab3_s + 1;
            } else if ($limitedResult[39]['gambaran'] == 3) {
                $k_tab3_i = $k_tab3_i + 1;
            } else if ($limitedResult[39]['gambaran'] == 4) {
                $k_tab3_star = $k_tab3_star + 1;
            } else { 
                $k_tab3_star = $k_tab3_star + 1;
            }
        }

        if (isset($limitedResult[41]['gambaran'])) {
            if ($limitedResult[41]['gambaran'] == 1) {
                $k_tab3_s = $k_tab3_s + 1;
            } else if ($limitedResult[41]['gambaran'] == 2) {
                $k_tab3_d = $k_tab3_d + 1;
            } else if ($limitedResult[41]['gambaran'] == 3) {
                $k_tab3_i = $k_tab3_i + 1;
            } else if ($limitedResult[41]['gambaran'] == 4) {
                $k_tab3_c = $k_tab3_c + 1;
            } else { 
                $k_tab3_star = $k_tab3_star + 1;
            }
        }

        if (isset($limitedResult[43]['gambaran'])) {
            if ($limitedResult[43]['gambaran'] == 1) {
                $k_tab3_s = $k_tab3_s + 1;
            } else if ($limitedResult[43]['gambaran'] == 2) {
                $k_tab3_i = $k_tab3_i + 1;
            } else if ($limitedResult[43]['gambaran'] == 3) {
                $k_tab3_d = $k_tab3_d + 1;
            } else if ($limitedResult[43]['gambaran'] == 4) {
                $k_tab3_c = $k_tab3_c + 1;
            } else { 
                $k_tab3_star = $k_tab3_star + 1;
            }
        }

        if (isset($limitedResult[45]['gambaran'])) {
            if ($limitedResult[45]['gambaran'] == 1) {
                $k_tab3_d = $k_tab3_d + 1;
            } else if ($limitedResult[45]['gambaran'] == 2) {
                $k_tab3_star = $k_tab3_star + 1;
            } else if ($limitedResult[45]['gambaran'] == 3) {
                $k_tab3_s = $k_tab3_s + 1;
            } else if ($limitedResult[45]['gambaran'] == 4) {
                $k_tab3_c = $k_tab3_c + 1;
            } else { 
                $k_tab3_star = $k_tab3_star + 1;
            }
        }

        if (isset($limitedResult[47]['gambaran'])) {
            if ($limitedResult[47]['gambaran'] == 1) {
                $k_tab3_s = $k_tab3_s + 1;
            } else if ($limitedResult[47]['gambaran'] == 2) {
                $k_tab3_i = $k_tab3_i + 1;
            } else if ($limitedResult[47]['gambaran'] == 3) {
                $k_tab3_star = $k_tab3_star + 1;
            } else if ($limitedResult[47]['gambaran'] == 4) {
                $k_tab3_star = $k_tab3_star + 1;
            } else { 
                $k_tab3_star = $k_tab3_star + 1;
            }
        }

        /////////////// EXCEL TAHAP 3 - TAB RESULT H2S ////////////////

        //Line 1 D
        $sum_p_d = $p_tab1_d + $p_tab2_d + $p_tab3_d;

        //Line 2 D
        $sum_k_d = $k_tab1_d + $k_tab2_d + $k_tab3_d;

        //Line 1 I
        $sum_p_i = $p_tab1_i + $p_tab2_i + $p_tab3_i;
        
        //Line 2 I
        $sum_k_i = $k_tab1_i + $k_tab2_i + $k_tab3_i;

        //Line 1 S
        $sum_p_s = $p_tab1_s + $p_tab2_s + $p_tab3_s;

        //Line 2 S
        $sum_k_s = $k_tab1_s + $k_tab2_s + $k_tab3_s;
        
        //Line 1 C
        $sum_p_c = $p_tab1_c + $p_tab2_c + $p_tab3_c;

        //Line 2 C
        $sum_k_c = $k_tab1_c + $k_tab2_c + $k_tab3_c;
        
        //Line 1 Star
        $sum_p_star = $p_tab1_star + $p_tab2_star + $p_tab3_star;

        //Line 2 Star
        $sum_k_star = $k_tab1_star + $k_tab2_star + $k_tab3_star;


        ////////// Mencari nilai Line 3 dengan parameter ///////////////
        
        //LINE 3 D
        $line3_d = $sum_p_d - $sum_k_d;

        //LINE 3 I
        $line3_i = $sum_p_i - $sum_k_i;

        //LINE 3 S
        $line3_s = $sum_p_s - $sum_k_s;

        //LINE 3 C
        $line3_c = $sum_p_c - $sum_k_c;

        //Star tidak perlu di total

        ////////// Total Per Line ///////////////

        //total Line 1
        $sum_line_1 = $sum_p_d + $sum_p_i + $sum_p_s + $sum_p_c + $sum_p_star;

        //total Line 2
        $sum_line_2 = $sum_k_d + $sum_k_i + $sum_k_s + $sum_k_c + $sum_k_star;
        
        /////////// buat sheet3 dengan array /////////////////////

        ////////// matrix untuk line 1 dan 2 //////////
        $matrix = array(
            0 => array(-6, -7, -5.7, -6, 7.5, 7, 7.5, 7.5),
            1 => array(-5.3, -4.6, -4.3, -4.7, 6.5, 6, 7, 7),
            2 => array(-4, -2.5, -3.5, -3.5, 4.3, 4, 6, 5.6),
            3 => array(-2.5, -1.3, -1.5, -1.5, 2.5, 2.5, 4, 4),
            4 => array(-1.7, 1, -0.7, 0.5, 1.5, 0.5, 2.5, 2.5),
            5 => array(-1.3, 3, 0.5, 2, 0.5, 0, 1.5, 1.5),
            6 => array(0, 3.5, 1, 3, 0, -2, 0.5, 0.5),
            7 => array(0.5, 5.3, 2.5, 5.3, -1.3, -3.5, -1.3, 0),
            8 => array(1, 5.7, 3, 5.7, -1.5, -4.3, -2, -1.3),
            9 => array(2, 6, 4, 6, -2.5, -5.3, -3, -2.5),
            10 => array(3, 6.5, 4.6, 6.3, -3, -6, -4.3, -3.5),
            11 => array(3.5, 7, 5, 6.5, -3.5, -6.5, -5.3, -5.3),
            12 => array(4, 7, 5.7, 6.7, -4.3, -7, -6, -5.7),
            13 => array(4.7, 7, 6, 7, -5.3, -7.2, -6.5, -6),
            14 => array(5.3, 7, 6.5, 7.3, -5.7, -7.2, -6.7, -6.5),
            15 => array(6.5, 7, 6.5, 7.3, -6, -7.2, -6.7, -7),
            16 => array(7, 7.5, 7, 7.3, -6.5, -7.3, -7, -7.3),
            17 => array(7, 7.5, 7, 7.5, 6.7, -7.3, -7.2, -7.5),
            18 => array(7, 7.5, 7, 8, 7, -7.3, -7.3, -7.7),
            19 => array(7.5, 7.5, 7.5, 8, -7.3, -7.5, -7.5, -7.9),
            20 => array(7.5, 8, 7.5, 8, -7.5, -8, -8, -8)
        );

        ///// buat untuk line 3////
        $matrix2 = array(
            -22 => array(-8, -8, -8, -7.5),
            -21 => array(-7.5, -8, -8, -7.3),
            -20 => array(-7, -8, -8, -7.3),
            -19 => array(-6.8, -8, -8, -7),
            -18 => array(-6.75, -7, -7.5, -6.7),
            -17 => array(-6.7, -6.7, -7.3, -6.7),
            -16 => array(-6.5, -6.7, -7.3, -6.7),
            -15 => array(-6.3, -6.7, -7, -6.5),
            -14 => array(-6.1, -6.7, -6.5, -6.3),
            -13 => array(-5.9, -6.7, -6.5, -6),
            -12 => array(-5.7, -6.7, -6.5, -5.85),
            -11 => array(-5.3, -6.7, -6.5, -5.85),
            -10 => array(-4.3, -6.5, -6, -5.7),
            -9 => array(-3.5, -6, -4.7, -4.7),
            -8 => array(-3.25, -5.7, -4.3, -4.3),
            -7 => array(-3, -4.7, -3.5, -3.5),
            -6 => array(-2.75, -4.3, -3, -3),
            -5 => array(-2.5, -3.5, -2, -2.5),
            -4 => array(-1.5, -3, -1.5, -0.5),
            -3 => array(-1, -2, -1, 0),
            -2 => array(-0.5, -1.5, -0.5, 0.3),
            -1 => array(-0.25, 0, 0, 0.5),
            0 => array(0, 0.5, 1, 1.5),
            1 => array(0.5, 1, 1.5, 3),
            2 => array(0.7, 1.5, 2, 4),
            3 => array(1, 3, 3, 4.3),
            4 => array(1.3, 4, 3.5, 5.5),
            5 => array(1.5, 4.3, 4, 5.7),
            6 => array(2, 5, 0, 6),
            7 => array(2.5, 5.5, 4.7, 6.3),
            8 => array(3.5, 6.5, 5, 6.5),
            9 => array(4, 6.7, 5.5, 6.7),
            10 => array(4.7, 7, 6, 7),
            11 => array(4.85, 7.3, 6.2, 7.3),
            12 => array(5, 7.3, 6.3, 7.3),
            13 => array(5.5, 7.3, 6.5, 7.3),
            14 => array(6, 7.3, 6.7, 7.3),
            15 => array(6.3, 7.3, 7, 7.3),
            16 => array(6.5, 7.3, 7.3, 7.3),
            17 => array(6.7, 7.3, 7.3, 7.5),
            18 => array(7, 7.5, 7.3, 8),
            19 => array(7.3, 8, 7.3, 8),
            20 => array(7.3, 8, 7.5, 8),
            21 => array(7.5, 8, 8, 8),
            22 => array(8, 8, 8, 8)
        );

        ///////////////// VLOOKUP DENGAN MATRIX ////////////////

        //Line 1 D
        $final_line1_d = $matrix[$sum_p_d][0];

        //Line 2 D
        $final_line2_d = $matrix[$sum_k_d][4];

        //Line 3 D
        $final_line3_d = $matrix2[$line3_d][0];

        ////////// END OF D //////////////

        //Line 1 I
        $final_line1_i = $matrix[$sum_p_i][1];

        //Line 2 I
        $final_line2_i = $matrix[$sum_k_i][5];

        //Line 3 I
        $final_line3_i = $matrix2[$line3_i][1];

        ////////// END OF I //////////////

        //Line 1 S
        $final_line1_s = $matrix[$sum_p_s][2];

        //Line 2 S
        $final_line2_s = $matrix[$sum_k_s][6];

        //Line 3 S
        $final_line3_s = $matrix2[$line3_s][2];
        
        ////////// END OF S //////////////

        //Line 1 C
        $final_line1_c = $matrix[$sum_p_c][3];

        //Line 2 C
        $final_line2_c = $matrix[$sum_k_c][7];

        //Line 3 C
        $final_line3_c = $matrix2[$line3_c][3];
        
        ////////// END OF C //////////////

        $akhir_line1 = 0;
        $akhir_line2 = 0;
        $akhir_line3 = 0;
        //////////////////////////////////////////////// Koreksi Akhir //////////////////////////////////////////////

        ////////////////////////////////////// START OF LINE 1 //////////////////////////////////////////
        if ($final_line1_d <= 0 && $final_line1_i <= 0 && $final_line1_s <= 0 && $final_line1_c > 0) {
            $akhir_line1 = 1;
        }
        if ($final_line1_d > 0 && $final_line1_i <= 0 && $final_line1_s <= 0 && $final_line1_c <= 0) {
            $akhir_line1 = 2;
        }
        if ($final_line1_d > 0 && $final_line1_i <= 0 && $final_line1_s <= 0 && $final_line1_c > 0 && $final_line1_c >= $final_line1_d) {
            $akhir_line1 = 3;
        }
        if ($final_line1_d > 0 && $final_line1_i > 0 && $final_line1_s <= 0 && $final_line1_c <= 0 && $final_line1_i >= $final_line1_d) {
            $akhir_line1 = 4;
        }
        if ($final_line1_d > 0 && $final_line1_i > 0 && $final_line1_s <= 0 && $final_line1_c > 0 && $final_line1_i >= $final_line1_d && $final_line1_d >= $final_line1_c) {
            $akhir_line1 = 5;
        }
        if ($final_line1_d > 0 && $final_line1_i > 0 && $final_line1_s > 0 && $final_line1_c <= 0 && $final_line1_i >= $final_line1_d && $final_line1_d >= $final_line1_s) {
            $akhir_line1 = 6;
        }
        if ($final_line1_d > 0 && $final_line1_i > 0 && $final_line1_s > 0 && $final_line1_c <= 0 && $final_line1_i >= $final_line1_s && $final_line1_s >= $final_line1_d) {
            $akhir_line1 = 7;
        }
        if ($final_line1_d > 0 && $final_line1_i <= 0 && $final_line1_s > 0 && $final_line1_c > 0 && $final_line1_s >= $final_line1_d && $final_line1_d >= $final_line1_c) {
            $akhir_line1 = 8;
        }
        if ($final_line1_d > 0 && $final_line1_i > 0 && $final_line1_s <= 0 && $final_line1_c <= 0 && $final_line1_d >= $final_line1_i) {
            $akhir_line1 = 9;
        }
        if ($final_line1_d > 0 && $final_line1_i > 0 && $final_line1_s > 0 && $final_line1_c <= 0 && $final_line1_d >= $final_line1_i && $final_line1_i >= $final_line1_s) {
            $akhir_line1 = 10;
        }
        //END 10 line 1 

        if ($final_line1_d > 0 && $final_line1_i <= 0 && $final_line1_s > 0 && $final_line1_c <= 0 && $final_line1_d >= $final_line1_s) {
            $akhir_line1 = 11;
        }
        if ($final_line1_d <= 0 && $final_line1_i > 0 && $final_line1_s > 0 && $final_line1_c > 0 && $final_line1_c >= $final_line1_i && $final_line1_i >= $final_line1_s) {
            $akhir_line1 = 12;
        }
        if ($final_line1_d <= 0 && $final_line1_i > 0 && $final_line1_s > 0 && $final_line1_c > 0 && $final_line1_c >= $final_line1_s && $final_line1_s >= $final_line1_i) {
            $akhir_line1 = 13;
        }
        if ($final_line1_d <= 0 && $final_line1_i > 0 && $final_line1_s > 0 && $final_line1_c > 0 && $final_line1_i >= $final_line1_s && $final_line1_i >= $final_line1_c) {
            $akhir_line1 = 14;
        }
        if ($final_line1_d <= 0 && $final_line1_i <= 0 && $final_line1_s > 0 && $final_line1_c <= 0) {
            $akhir_line1 = 15;
        }
        if ($final_line1_d <= 0 && $final_line1_i <= 0 && $final_line1_s > 0 && $final_line1_c > 0 && $final_line1_c >= $final_line1_s) {
            $akhir_line1 = 16;
        }
        if ($final_line1_d <= 0 && $final_line1_i <= 0 && $final_line1_s > 0 && $final_line1_c > 0 && $final_line1_s >= $final_line1_c) {
            $akhir_line1 = 17;
        }
        if ($final_line1_i <= 0 && $final_line1_s <= 0 && $final_line1_d > 0 && $final_line1_c > 0 && $final_line1_d >= $final_line1_c) {
            $akhir_line1 = 18;
        }
        if ($final_line1_d > 0 && $final_line1_i > 0 && $final_line1_c > 0 && $final_line1_s <= 0 && $final_line1_d >= $final_line1_i && $final_line1_i >= $final_line1_c) {
            $akhir_line1 = 19;
        }
        if ($final_line1_d > 0 && $final_line1_s > 0 && $final_line1_i > 0 && $final_line1_c <= 0 && $final_line1_d >= $final_line1_s && $final_line1_s >= $final_line1_i) {
            $akhir_line1 = 20;
        }
        //END 20 line 1 
             
        if ($final_line1_d > 0 && $final_line1_s > 0 && $final_line1_c > 0 && $final_line1_i <= 0 && $final_line1_d >= $final_line1_s && $final_line1_s >= $final_line1_c) {
            $akhir_line1 = 21;
        }

        if ($final_line1_d > 0 && $final_line1_i > 0 && $final_line1_c > 0 && $final_line1_s <= 0 && $final_line1_d >= $final_line1_c && $final_line1_c >= $final_line1_i) {
            $akhir_line1 = 22;
        }

        if ($final_line1_d > 0 && $final_line1_s > 0 && $final_line1_c > 0 && $final_line1_i <= 0 && $final_line1_d >= $final_line1_c && $final_line1_c >= $final_line1_s) {
            $akhir_line1 = 23;
        }

        if ($final_line1_d <= 0 && $final_line1_s <= 0 && $final_line1_c <= 0 && $final_line1_i > 0) {
            $akhir_line1 = 24;
        }

        if ($final_line1_i > 0 && $final_line1_s > 0 && $final_line1_d <= 0 && $final_line1_c <= 0 && $final_line1_i >= $final_line1_s) {
            $akhir_line1 = 25;
        }

        if ($final_line1_i > 0 && $final_line1_c > 0 && $final_line1_d <= 0 && $final_line1_s <= 0 && $final_line1_i >= $final_line1_c) {
            $akhir_line1 = 26;
        }

        if ($final_line1_d > 0 && $final_line1_i > 0 && $final_line1_c > 0 && $final_line1_s <= 0 && $final_line1_i >= $final_line1_c && $final_line1_c >= $final_line1_d) {
            $akhir_line1 = 27;
        }

        if ($final_line1_d <= 0 && $final_line1_i > 0 && $final_line1_s > 0 && $final_line1_c > 0 && $final_line1_i >= $final_line1_c && $final_line1_c >= $final_line1_s) {
            $akhir_line1 = 28;
        }

        if ($final_line1_d > 0 && $final_line1_i <= 0 && $final_line1_s > 0 && $final_line1_c <= 0 && $final_line1_s >= $final_line1_d) {
            $akhir_line1 = 29;
        }

        if ($final_line1_i > 0 && $final_line1_s > 0 && $final_line1_d <= 0 && $final_line1_c <= 0 && $final_line1_s >= $final_line1_i) {
            $akhir_line1 = 30;
        }
        //// END LINE 1 30

        if ($final_line1_d > 0 && $final_line1_i > 0 && $final_line1_s > 0 && $final_line1_c <= 0 && $final_line1_s >= $final_line1_d && $final_line1_d >= $final_line1_i) {
            $akhir_line1 = 31;
        }

        if ($final_line1_d > 0 && $final_line1_i > 0 && $final_line1_s > 0 && $final_line1_c <= 0 && $final_line1_s >= $final_line1_i && $final_line1_i >= $final_line1_d) {
            $akhir_line1 = 32;
        }

        if ($final_line1_i > 0 && $final_line1_s > 0 && $final_line1_c > 0 && $final_line1_d <= 0 && $final_line1_s >= $final_line1_i && $final_line1_i >= $final_line1_c) {
            $akhir_line1 = 33;
        }

        if ($final_line1_d > 0 && $final_line1_i <= 0 && $final_line1_s > 0 && $final_line1_c > 0 && $final_line1_s >= $final_line1_c && $final_line1_c >= $final_line1_d) {
            $akhir_line1 = 34;
        }

        if ($final_line1_i > 0 && $final_line1_s > 0 && $final_line1_c > 0 && $final_line1_d <= 0 && $final_line1_s >= $final_line1_c && $final_line1_c >= $final_line1_i) {
            $akhir_line1 = 35;
        }

        if ($final_line1_i > 0 && $final_line1_c > 0 && $final_line1_d <= 0 && $final_line1_s <= 0 && $final_line1_c >= $final_line1_i) {
            $akhir_line1 = 36;
        }

        if ($final_line1_d > 0 && $final_line1_i > 0 && $final_line1_c > 0 && $final_line1_s <= 0 && $final_line1_c >= $final_line1_d && $final_line1_d >= $final_line1_i) {
            $akhir_line1 = 37;
        }

        if ($final_line1_d > 0 && $final_line1_s > 0 && $final_line1_c > 0 && $final_line1_i <= 0 && $final_line1_c >= $final_line1_d && $final_line1_d >= $final_line1_s) {
            $akhir_line1 = 38;
        }

        if ($final_line1_d > 0 && $final_line1_i > 0 && $final_line1_c > 0 && $final_line1_s <= 0 && $final_line1_c >= $final_line1_i && $final_line1_i >= $final_line1_d) {
            $akhir_line1 = 39;
        }

        if ($final_line1_d > 0 && $final_line1_s > 0 && $final_line1_c > 0 && $final_line1_i <= 0 && $final_line1_c >= $final_line1_s && $final_line1_s >= $final_line1_d) {
            $akhir_line1 = 40;
        }
        ////////////////////////////////////// END OF LINE 1 //////////////////////////////////////////

        ////////////////////////////////////// START OF LINE 2 //////////////////////////////////////////
        if ($final_line2_d <= 0 && $final_line2_i <= 0 && $final_line2_s <= 0 && $final_line2_c > 0) {
            $akhir_line2 = 1;
        }
        if ($final_line2_d > 0 && $final_line2_i <= 0 && $final_line2_s <= 0 && $final_line2_c <= 0) {
            $akhir_line2 = 2;
        }
        if ($final_line2_d > 0 && $final_line2_i <= 0 && $final_line2_s <= 0 && $final_line2_c > 0 && $final_line2_c >= $final_line2_d) {
            $akhir_line2 = 3;
        }
        if ($final_line2_d > 0 && $final_line2_i > 0 && $final_line2_s <= 0 && $final_line2_c <= 0 && $final_line2_i >= $final_line2_d) {
            $akhir_line2 = 4;
        }
        if ($final_line2_d > 0 && $final_line2_i > 0 && $final_line2_s <= 0 && $final_line2_c > 0 && $final_line2_i >= $final_line2_d && $final_line2_d >= $final_line2_c) {
            $akhir_line2 = 5;
        }
        if ($final_line2_d > 0 && $final_line2_i > 0 && $final_line2_s > 0 && $final_line2_c <= 0 && $final_line2_i >= $final_line2_d && $final_line2_d >= $final_line2_s) {
            $akhir_line2 = 6;
        }
        if ($final_line2_d > 0 && $final_line2_i > 0 && $final_line2_s > 0 && $final_line2_c <= 0 && $final_line2_i >= $final_line2_s && $final_line2_s >= $final_line2_d) {
            $akhir_line2 = 7;
        }
        if ($final_line2_d > 0 && $final_line2_i <= 0 && $final_line2_s > 0 && $final_line2_c > 0 && $final_line2_s >= $final_line2_d && $final_line2_d >= $final_line2_c) {
            $akhir_line2 = 8;
        }
        if ($final_line2_d > 0 && $final_line2_i > 0 && $final_line2_s <= 0 && $final_line2_c <= 0 && $final_line2_d >= $final_line2_i) {
            $akhir_line2 = 9;
        }
        if ($final_line2_d > 0 && $final_line2_i > 0 && $final_line2_s > 0 && $final_line2_c <= 0 && $final_line2_d >= $final_line2_i && $final_line2_i >= $final_line2_s) {
            $akhir_line2 = 10;
        }
        //END 10 line 2 

        if ($final_line2_d > 0 && $final_line2_i <= 0 && $final_line2_s > 0 && $final_line2_c <= 0 && $final_line2_d >= $final_line2_s) {
            $akhir_line2 = 11;
        }
        if ($final_line2_d <= 0 && $final_line2_i > 0 && $final_line2_s > 0 && $final_line2_c > 0 && $final_line2_c >= $final_line2_i && $final_line2_i >= $final_line2_s) {
            $akhir_line2 = 12;
        }
        if ($final_line2_d <= 0 && $final_line2_i > 0 && $final_line2_s > 0 && $final_line2_c > 0 && $final_line2_c >= $final_line2_s && $final_line2_s >= $final_line2_i) {
            $akhir_line2 = 13;
        }
        if ($final_line2_d <= 0 && $final_line2_i > 0 && $final_line2_s > 0 && $final_line2_c > 0 && $final_line2_i >= $final_line2_s && $final_line2_i >= $final_line2_c) {
            $akhir_line2 = 14;
        }
        if ($final_line2_d <= 0 && $final_line2_i <= 0 && $final_line2_s > 0 && $final_line2_c <= 0) {
            $akhir_line2 = 15;
        }
        if ($final_line2_d <= 0 && $final_line2_i <= 0 && $final_line2_s > 0 && $final_line2_c > 0 && $final_line2_c >= $final_line2_s) {
            $akhir_line2 = 16;
        }
        if ($final_line2_d <= 0 && $final_line2_i <= 0 && $final_line2_s > 0 && $final_line2_c > 0 && $final_line2_s >= $final_line2_c) {
            $akhir_line2 = 17;
        }
        if ($final_line2_i <= 0 && $final_line2_s <= 0 && $final_line2_d > 0 && $final_line2_c > 0 && $final_line2_d >= $final_line2_c) {
            $akhir_line2 = 18;
        }
        if ($final_line2_d > 0 && $final_line2_i > 0 && $final_line2_c > 0 && $final_line2_s <= 0 && $final_line2_d >= $final_line2_i && $final_line2_i >= $final_line2_c) {
            $akhir_line2 = 19;
        }
        if ($final_line2_d > 0 && $final_line2_s > 0 && $final_line2_i > 0 && $final_line2_c <= 0 && $final_line2_d >= $final_line2_s && $final_line2_s >= $final_line2_i) {
            $akhir_line2 = 20;
        }
        //END 20 line 2 
             
        if ($final_line2_d > 0 && $final_line2_s > 0 && $final_line2_c > 0 && $final_line2_i <= 0 && $final_line2_d >= $final_line2_s && $final_line2_s >= $final_line2_c) {
            $akhir_line2 = 21;
        }

        if ($final_line2_d > 0 && $final_line2_i > 0 && $final_line2_c > 0 && $final_line2_s <= 0 && $final_line2_d >= $final_line2_c && $final_line2_c >= $final_line2_i) {
            $akhir_line2 = 22;
        }

        if ($final_line2_d > 0 && $final_line2_s > 0 && $final_line2_c > 0 && $final_line2_i <= 0 && $final_line2_d >= $final_line2_c && $final_line2_c >= $final_line2_s) {
            $akhir_line2 = 23;
        }

        if ($final_line2_d <= 0 && $final_line2_s <= 0 && $final_line2_c <= 0 && $final_line2_i > 0) {
            $akhir_line2 = 24;
        }

        if ($final_line2_i > 0 && $final_line2_s > 0 && $final_line2_d <= 0 && $final_line2_c <= 0 && $final_line2_i >= $final_line2_s) {
            $akhir_line2 = 25;
        }

        if ($final_line2_i > 0 && $final_line2_c > 0 && $final_line2_d <= 0 && $final_line2_s <= 0 && $final_line2_i >= $final_line2_c) {
            $akhir_line2 = 26;
        }

        if ($final_line2_d > 0 && $final_line2_i > 0 && $final_line2_c > 0 && $final_line2_s <= 0 && $final_line2_i >= $final_line2_c && $final_line2_c >= $final_line2_d) {
            $akhir_line2 = 27;
        }

        if ($final_line2_d <= 0 && $final_line2_i > 0 && $final_line2_s > 0 && $final_line2_c > 0 && $final_line2_i >= $final_line2_c && $final_line2_c >= $final_line2_s) {
            $akhir_line2 = 28;
        }

        if ($final_line2_d > 0 && $final_line2_i <= 0 && $final_line2_s > 0 && $final_line2_c <= 0 && $final_line2_s >= $final_line2_d) {
            $akhir_line2 = 29;
        }

        if ($final_line2_i > 0 && $final_line2_s > 0 && $final_line2_d <= 0 && $final_line2_c <= 0 && $final_line2_s >= $final_line2_i) {
            $akhir_line2 = 30;
        }
        //// END LINE 2 30

        if ($final_line2_d > 0 && $final_line2_i > 0 && $final_line2_s > 0 && $final_line2_c <= 0 && $final_line2_s >= $final_line2_d && $final_line2_d >= $final_line2_i) {
            $akhir_line2 = 31;
        }

        if ($final_line2_d > 0 && $final_line2_i > 0 && $final_line2_s > 0 && $final_line2_c <= 0 && $final_line2_s >= $final_line2_i && $final_line2_i >= $final_line2_d) {
            $akhir_line2 = 32;
        }

        if ($final_line2_i > 0 && $final_line2_s > 0 && $final_line2_c > 0 && $final_line2_d <= 0 && $final_line2_s >= $final_line2_i && $final_line2_i >= $final_line2_c) {
            $akhir_line2 = 33;
        }

        if ($final_line2_d > 0 && $final_line2_i <= 0 && $final_line2_s > 0 && $final_line2_c > 0 && $final_line2_s >= $final_line2_c && $final_line2_c >= $final_line2_d) {
            $akhir_line2 = 34;
        }

        if ($final_line2_i > 0 && $final_line2_s > 0 && $final_line2_c > 0 && $final_line2_d <= 0 && $final_line2_s >= $final_line2_c && $final_line2_c >= $final_line2_i) {
            $akhir_line2 = 35;
        }

        if ($final_line2_i > 0 && $final_line2_c > 0 && $final_line2_d <= 0 && $final_line2_s <= 0 && $final_line2_c >= $final_line2_i) {
            $akhir_line2 = 36;
        }

        if ($final_line2_d > 0 && $final_line2_i > 0 && $final_line2_c > 0 && $final_line2_s <= 0 && $final_line2_c >= $final_line2_d && $final_line2_d >= $final_line2_i) {
            $akhir_line2 = 37;
        }

        if ($final_line2_d > 0 && $final_line2_s > 0 && $final_line2_c > 0 && $final_line2_i <= 0 && $final_line2_c >= $final_line2_d && $final_line2_d >= $final_line2_s) {
            $akhir_line2 = 38;
        }

        if ($final_line2_d > 0 && $final_line2_i > 0 && $final_line2_c > 0 && $final_line2_s <= 0 && $final_line2_c >= $final_line2_i && $final_line2_i >= $final_line2_d) {
            $akhir_line2 = 39;
        }

        if ($final_line2_d > 0 && $final_line2_s > 0 && $final_line2_c > 0 && $final_line2_i <= 0 && $final_line2_c >= $final_line2_s && $final_line2_s >= $final_line2_d) {
            $akhir_line2 = 40;
        }
        ////////////////////////////////////// END OF LINE 2 //////////////////////////////////////////

        ////////////////////////////////////// START OF LINE 3 //////////////////////////////////////////
        if ($final_line3_d <= 0 && $final_line3_i <= 0 && $final_line3_s <= 0 && $final_line3_c > 0) {
            $akhir_line3 = 1;
        }
        if ($final_line3_d > 0 && $final_line3_i <= 0 && $final_line3_s <= 0 && $final_line3_c <= 0) {
            $akhir_line3 = 2;
        }
        if ($final_line3_d > 0 && $final_line3_i <= 0 && $final_line3_s <= 0 && $final_line3_c > 0 && $final_line3_c >= $final_line3_d) {
            $akhir_line3 = 3;
        }
        if ($final_line3_d > 0 && $final_line3_i > 0 && $final_line3_s <= 0 && $final_line3_c <= 0 && $final_line3_i >= $final_line3_d) {
            $akhir_line3 = 4;
        }
        if ($final_line3_d > 0 && $final_line3_i > 0 && $final_line3_s <= 0 && $final_line3_c > 0 && $final_line3_i >= $final_line3_d && $final_line3_d >= $final_line3_c) {
            $akhir_line3 = 5;
        }
        if ($final_line3_d > 0 && $final_line3_i > 0 && $final_line3_s > 0 && $final_line3_c <= 0 && $final_line3_i >= $final_line3_d && $final_line3_d >= $final_line3_s) {
            $akhir_line3 = 6;
        }
        if ($final_line3_d > 0 && $final_line3_i > 0 && $final_line3_s > 0 && $final_line3_c <= 0 && $final_line3_i >= $final_line3_s && $final_line3_s >= $final_line3_d) {
            $akhir_line3 = 7;
        }
        if ($final_line3_d > 0 && $final_line3_i <= 0 && $final_line3_s > 0 && $final_line3_c > 0 && $final_line3_s >= $final_line3_d && $final_line3_d >= $final_line3_c) {
            $akhir_line3 = 8;
        }
        if ($final_line3_d > 0 && $final_line3_i > 0 && $final_line3_s <= 0 && $final_line3_c <= 0 && $final_line3_d >= $final_line3_i) {
            $akhir_line3 = 9;
        }
        if ($final_line3_d > 0 && $final_line3_i > 0 && $final_line3_s > 0 && $final_line3_c <= 0 && $final_line3_d >= $final_line3_i && $final_line3_i >= $final_line3_s) {
            $akhir_line3 = 10;
        }
        //END 10 LINE 3 

        if ($final_line3_d > 0 && $final_line3_i <= 0 && $final_line3_s > 0 && $final_line3_c <= 0 && $final_line3_d >= $final_line3_s) {
            $akhir_line3 = 11;
        }
        if ($final_line3_d <= 0 && $final_line3_i > 0 && $final_line3_s > 0 && $final_line3_c > 0 && $final_line3_c >= $final_line3_i && $final_line3_i >= $final_line3_s) {
            $akhir_line3 = 12;
        }
        if ($final_line3_d <= 0 && $final_line3_i > 0 && $final_line3_s > 0 && $final_line3_c > 0 && $final_line3_c >= $final_line3_s && $final_line3_s >= $final_line3_i) {
            $akhir_line3 = 13;
        }
        if ($final_line3_d <= 0 && $final_line3_i > 0 && $final_line3_s > 0 && $final_line3_c > 0 && $final_line3_i >= $final_line3_s && $final_line3_i >= $final_line3_c) {
            $akhir_line3 = 14;
        }
        if ($final_line3_d <= 0 && $final_line3_i <= 0 && $final_line3_s > 0 && $final_line3_c <= 0) {
            $akhir_line3 = 15;
        }
        if ($final_line3_d <= 0 && $final_line3_i <= 0 && $final_line3_s > 0 && $final_line3_c > 0 && $final_line3_c >= $final_line3_s) {
            $akhir_line3 = 16;
        }
        if ($final_line3_d <= 0 && $final_line3_i <= 0 && $final_line3_s > 0 && $final_line3_c > 0 && $final_line3_s >= $final_line3_c) {
            $akhir_line3 = 17;
        }
        if ($final_line3_i <= 0 && $final_line3_s <= 0 && $final_line3_d > 0 && $final_line3_c > 0 && $final_line3_d >= $final_line3_c) {
            $akhir_line3 = 18;
        }
        if ($final_line3_d > 0 && $final_line3_i > 0 && $final_line3_c > 0 && $final_line3_s <= 0 && $final_line3_d >= $final_line3_i && $final_line3_i >= $final_line3_c) {
            $akhir_line3 = 19;
        }
        if ($final_line3_d > 0 && $final_line3_s > 0 && $final_line3_i > 0 && $final_line3_c <= 0 && $final_line3_d >= $final_line3_s && $final_line3_s >= $final_line3_i) {
            $akhir_line3 = 20;
        }
        //END 20 LINE 3 
             
        if ($final_line3_d > 0 && $final_line3_s > 0 && $final_line3_c > 0 && $final_line3_i <= 0 && $final_line3_d >= $final_line3_s && $final_line3_s >= $final_line3_c) {
            $akhir_line3 = 21;
        }

        if ($final_line3_d > 0 && $final_line3_i > 0 && $final_line3_c > 0 && $final_line3_s <= 0 && $final_line3_d >= $final_line3_c && $final_line3_c >= $final_line3_i) {
            $akhir_line3 = 22;
        }

        if ($final_line3_d > 0 && $final_line3_s > 0 && $final_line3_c > 0 && $final_line3_i <= 0 && $final_line3_d >= $final_line3_c && $final_line3_c >= $final_line3_s) {
            $akhir_line3 = 23;
        }

        if ($final_line3_d <= 0 && $final_line3_s <= 0 && $final_line3_c <= 0 && $final_line3_i > 0) {
            $akhir_line3 = 24;
        }

        if ($final_line3_i > 0 && $final_line3_s > 0 && $final_line3_d <= 0 && $final_line3_c <= 0 && $final_line3_i >= $final_line3_s) {
            $akhir_line3 = 25;
        }

        if ($final_line3_i > 0 && $final_line3_c > 0 && $final_line3_d <= 0 && $final_line3_s <= 0 && $final_line3_i >= $final_line3_c) {
            $akhir_line3 = 26;
        }

        if ($final_line3_d > 0 && $final_line3_i > 0 && $final_line3_c > 0 && $final_line3_s <= 0 && $final_line3_i >= $final_line3_c && $final_line3_c >= $final_line3_d) {
            $akhir_line3 = 27;
        }

        if ($final_line3_d <= 0 && $final_line3_i > 0 && $final_line3_s > 0 && $final_line3_c > 0 && $final_line3_i >= $final_line3_c && $final_line3_c >= $final_line3_s) {
            $akhir_line3 = 28;
        }

        if ($final_line3_d > 0 && $final_line3_i <= 0 && $final_line3_s > 0 && $final_line3_c <= 0 && $final_line3_s >= $final_line3_d) {
            $akhir_line3 = 29;
        }

        if ($final_line3_i > 0 && $final_line3_s > 0 && $final_line3_d <= 0 && $final_line3_c <= 0 && $final_line3_s >= $final_line3_i) {
            $akhir_line3 = 30;
        }
        //// END LINE 3 30

        if ($final_line3_d > 0 && $final_line3_i > 0 && $final_line3_s > 0 && $final_line3_c <= 0 && $final_line3_s >= $final_line3_d && $final_line3_d >= $final_line3_i) {
            $akhir_line3 = 31;
        }

        if ($final_line3_d > 0 && $final_line3_i > 0 && $final_line3_s > 0 && $final_line3_c <= 0 && $final_line3_s >= $final_line3_i && $final_line3_i >= $final_line3_d) {
            $akhir_line3 = 32;
        }

        if ($final_line3_i > 0 && $final_line3_s > 0 && $final_line3_c > 0 && $final_line3_d <= 0 && $final_line3_s >= $final_line3_i && $final_line3_i >= $final_line3_c) {
            $akhir_line3 = 33;
        }

        if ($final_line3_d > 0 && $final_line3_i <= 0 && $final_line3_s > 0 && $final_line3_c > 0 && $final_line3_s >= $final_line3_c && $final_line3_c >= $final_line3_d) {
            $akhir_line3 = 34;
        }

        if ($final_line3_i > 0 && $final_line3_s > 0 && $final_line3_c > 0 && $final_line3_d <= 0 && $final_line3_s >= $final_line3_c && $final_line3_c >= $final_line3_i) {
            $akhir_line3 = 35;
        }

        if ($final_line3_i > 0 && $final_line3_c > 0 && $final_line3_d <= 0 && $final_line3_s <= 0 && $final_line3_c >= $final_line3_i) {
            $akhir_line3 = 36;
        }

        if ($final_line3_d > 0 && $final_line3_i > 0 && $final_line3_c > 0 && $final_line3_s <= 0 && $final_line3_c >= $final_line3_d && $final_line3_d >= $final_line3_i) {
            $akhir_line3 = 37;
        }

        if ($final_line3_d > 0 && $final_line3_s > 0 && $final_line3_c > 0 && $final_line3_i <= 0 && $final_line3_c >= $final_line3_d && $final_line3_d >= $final_line3_s) {
            $akhir_line3 = 38;
        }

        if ($final_line3_d > 0 && $final_line3_i > 0 && $final_line3_c > 0 && $final_line3_s <= 0 && $final_line3_c >= $final_line3_i && $final_line3_i >= $final_line3_d) {
            $akhir_line3 = 39;
        }

        if ($final_line3_d > 0 && $final_line3_s > 0 && $final_line3_c > 0 && $final_line3_i <= 0 && $final_line3_c >= $final_line3_s && $final_line3_s >= $final_line3_d) {
            $akhir_line3 = 40;
        }
        ////////////////////////////////////// END OF LINE 3 //////////////////////////////////////////

        //INSERT HASIL KOSTIK
        $qs_hrctsth_disc = $editor->db()
            ->query('select', 'hrctsth_disc' )
            ->get(['id'] )
            ->where('kode', $kode )
            ->exec();
        $rs_hrctsth_disc = $qs_hrctsth_disc->fetch();
        $id_hrctsth_disc = $rs_hrctsth_disc['id'];

        $qi_hrctstd_disc = $editor->db()
            ->query('insert', 'hrctstd_disc')
            ->set('transaction_state',1)
            ->set('id_hrctsth_disc',$id_hrctsth_disc)
            ->set('hasil_line1',$akhir_line1)
            ->set('hasil_line2',$akhir_line2)
            ->set('hasil_line3',$akhir_line3)
            ->set('d_line1',$final_line1_d)
            ->set('d_line2',$final_line2_d)
            ->set('d_line3',$final_line3_d)
            ->set('i_line1',$final_line1_i)
            ->set('i_line2',$final_line2_i)
            ->set('i_line3',$final_line3_i)
            ->set('s_line1',$final_line1_s)
            ->set('s_line2',$final_line2_s)
            ->set('s_line3',$final_line3_s)
            ->set('c_line1',$final_line1_c)
            ->set('c_line2',$final_line2_c)
            ->set('c_line3',$final_line3_c)
            ->set('tbl_d1',$sum_p_d)
            ->set('tbl_d2',$sum_k_d)
            ->set('tbl_d3',$line3_d)
            ->set('tbl_i1',$sum_p_i)
            ->set('tbl_i2',$sum_k_i)
            ->set('tbl_i3',$line3_i)
            ->set('tbl_s1',$sum_p_s)
            ->set('tbl_s2',$sum_k_s)
            ->set('tbl_s3',$line3_s)
            ->set('tbl_c1',$sum_p_c)
            ->set('tbl_c2',$sum_k_c)
            ->set('tbl_c3',$line3_c)
            ->set('tanggal',$tanggal)
            
            ->set('tbl_star_1',$sum_p_star)
            ->set('tbl_star_2',$sum_k_star)
            ->set('tbl_total_1',$sum_line_1)
            ->set('tbl_total_2',$sum_line_2)
            ->exec();

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
