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
if (isset($_POST['result'], $_POST['kode'])) {
    $result = $_POST['result'];
    $kode = $_POST['kode'];
    $tanggal = date('Y-m-d');

    try {
        $db->transaction();

        $qs_find_id = $editor->db()
            ->query('select', 'hrctsth_kostik' )
            ->get(['id'] )
            ->where('kode', $kode )
            ->exec();
        $rs_find_id = $qs_find_id->fetch();
        $id_kostik = $rs_find_id['id'];

        // Update TES CFIT
        $sql_update = $editor->db()
            ->query('update', 'hrctsth_kostik')
            ->set('status', 2)
            ->set('tanggal', $tanggal);

        for ($i = 0; $i < 90; $i++) {
            $columnName = "soal" . ($i + 1);
            $answer = isset($result[$i]['jawaban']) ? $result[$i]['jawaban'] : "";
        
            $sql_update->set($columnName, $answer);
        }
        $sql_update->where('id', $id_kostik);
        $result_update = $sql_update->exec();

        //DEKLARASI VARIABLE Alphabet penilaian
        $G = 0;
        $L = 0;
        $I = 0;
        $T = 0;
        $V = 0;
        $S = 0;
        $R = 0;
        $D = 0;
        $C = 0;
        $E = 0;
        $N = 0;
        $A = 0;
        $P = 0;
        $X = 0;
        $B = 0;
        $O = 0;
        $Z = 0;
        $K = 0;
        $F = 0;
        $W = 0;

        //konversi 90 jawaban menjadi alphabet
        if(isset($result[0]['jawaban'])){ 
            if($result[0]['jawaban'] == 1){ $G = $G+1; } else { $E =  $E+1;}
        }
        if(isset($result[1]['jawaban'])){ 
            if($result[1]['jawaban'] == 1){ $A = $A+1; } else { $N =  $N+1;}
        }
        if(isset($result[2]['jawaban'])){ 
            if($result[2]['jawaban'] == 1){ $P = $P+1; } else { $A =  $A+1;}
        }
        if(isset($result[3]['jawaban'])){ 
            if($result[3]['jawaban'] == 1){ $X = $X+1; } else { $P =  $P+1;}
        }
        if(isset($result[4]['jawaban'])){ 
            if($result[4]['jawaban'] == 1){ $B = $B+1; } else { $X =  $X+1;}
        }
        if(isset($result[5]['jawaban'])){ 
            if($result[5]['jawaban'] == 1){ $O = $O+1; } else { $B =  $B+1;}
        }
        if(isset($result[6]['jawaban'])){ 
            if($result[6]['jawaban'] == 1){ $Z = $Z+1; } else { $O =  $O+1;}
        }
        if(isset($result[7]['jawaban'])){ 
            if($result[7]['jawaban'] == 1){ $K = $K+1; } else { $Z =  $Z+1;}
        }
        if(isset($result[8]['jawaban'])){ 
            if($result[8]['jawaban'] == 1){ $F = $F+1; } else { $K =  $K+1;}
        }
        if(isset($result[9]['jawaban'])){ 
            if($result[9]['jawaban'] == 1){ $W = $W+1; } else { $F =  $F+1;}
        }
        if(isset($result[10]['jawaban'])){ 
            if($result[10]['jawaban'] == 1){ $G = $G+1; } else { $C =  $C+1;}
        }
        if(isset($result[11]['jawaban'])){ 
            if($result[11]['jawaban'] == 1){ $L = $L+1; } else { $E =  $E+1;}
        }
        if(isset($result[12]['jawaban'])){ 
            if($result[12]['jawaban'] == 1){ $P = $P+1; } else { $N =  $N+1;}
        }
        if(isset($result[13]['jawaban'])){ 
            if($result[13]['jawaban'] == 1){ $X = $X+1; } else { $A =  $A+1;}
        }
        if(isset($result[14]['jawaban'])){ 
            if($result[14]['jawaban'] == 1){ $B = $B+1; } else { $P =  $P+1;}
        }
        if(isset($result[15]['jawaban'])){ 
            if($result[15]['jawaban'] == 1){ $O = $O+1; } else { $X =  $X+1;}
        }
        if(isset($result[16]['jawaban'])){ 
            if($result[16]['jawaban'] == 1){ $Z = $Z+1; } else { $B =  $B+1;}
        }
        if(isset($result[17]['jawaban'])){ 
            if($result[17]['jawaban'] == 1){ $K = $K+1; } else { $O =  $O+1;}
        }
        if(isset($result[18]['jawaban'])){ 
            if($result[18]['jawaban'] == 1){ $F = $F+1; } else { $Z =  $Z+1;}
        }
        if(isset($result[19]['jawaban'])){ 
            if($result[19]['jawaban'] == 1){ $W = $W+1; } else { $K =  $K+1;}
        }
        if(isset($result[20]['jawaban'])){ 
            if($result[20]['jawaban'] == 1){ $G = $G+1; } else { $D =  $D+1;}
        }
        if(isset($result[21]['jawaban'])){ 
            if($result[21]['jawaban'] == 1){ $L = $L+1; } else { $C =  $C+1;}
        }
        if(isset($result[22]['jawaban'])){ 
            if($result[22]['jawaban'] == 1){ $I = $I+1; } else { $E =  $E+1;}
        }
        if(isset($result[23]['jawaban'])){ 
            if($result[23]['jawaban'] == 1){ $X = $X+1; } else { $N =  $N+1;}
        }
        if(isset($result[24]['jawaban'])){ 
            if($result[24]['jawaban'] == 1){ $B = $B+1; } else { $A =  $A+1;}
        }
        if(isset($result[25]['jawaban'])){ 
            if($result[25]['jawaban'] == 1){ $O = $O+1; } else { $P =  $P+1;}
        }
        if(isset($result[26]['jawaban'])){ 
            if($result[26]['jawaban'] == 1){ $Z = $Z+1; } else { $X =  $X+1;}
        }
        if(isset($result[27]['jawaban'])){ 
            if($result[27]['jawaban'] == 1){ $K = $K+1; } else { $B =  $B+1;}
        }
        if(isset($result[28]['jawaban'])){ 
            if($result[28]['jawaban'] == 1){ $F = $F+1; } else { $O =  $O+1;}
        }
        if(isset($result[29]['jawaban'])){ 
            if($result[29]['jawaban'] == 1){ $W = $W+1; } else { $Z =  $Z+1;}
        }
        if(isset($result[30]['jawaban'])){ 
            if($result[30]['jawaban'] == 1){ $G = $G+1; } else { $R =  $R+1;}
        }
        if(isset($result[31]['jawaban'])){ 
            if($result[31]['jawaban'] == 1){ $L = $L+1; } else { $D =  $D+1;}
        }
        if(isset($result[32]['jawaban'])){ 
            if($result[32]['jawaban'] == 1){ $I = $I+1; } else { $C =  $C+1;}
        }
        if(isset($result[33]['jawaban'])){ 
            if($result[33]['jawaban'] == 1){ $T = $T+1; } else { $E =  $E+1;}
        }
        if(isset($result[34]['jawaban'])){ 
            if($result[34]['jawaban'] == 1){ $B = $B+1; } else { $N =  $N+1;}
        }
        if(isset($result[35]['jawaban'])){ 
            if($result[35]['jawaban'] == 1){ $O = $O+1; } else { $A =  $A+1;}
        }
        if(isset($result[36]['jawaban'])){ 
            if($result[36]['jawaban'] == 1){ $Z = $Z+1; } else { $P =  $P+1;}
        }
        if(isset($result[37]['jawaban'])){ 
            if($result[37]['jawaban'] == 1){ $K = $K+1; } else { $X =  $X+1;}
        }
        if(isset($result[38]['jawaban'])){ 
            if($result[38]['jawaban'] == 1){ $F = $F+1; } else { $B =  $B+1;}
        }
        if(isset($result[39]['jawaban'])){ 
            if($result[39]['jawaban'] == 1){ $W = $W+1; } else { $O =  $O+1;}
        }
        if(isset($result[40]['jawaban'])){ 
            if($result[40]['jawaban'] == 1){ $G = $G+1; } else { $S =  $S+1;}
        }
        if(isset($result[41]['jawaban'])){ 
            if($result[41]['jawaban'] == 1){ $L = $L+1; } else { $R =  $R+1;}
        }
        if(isset($result[42]['jawaban'])){ 
            if($result[42]['jawaban'] == 1){ $I = $I+1; } else { $D =  $D+1;}
        }
        if(isset($result[43]['jawaban'])){ 
            if($result[43]['jawaban'] == 1){ $T = $T+1; } else { $C =  $C+1;}
        }
        if(isset($result[44]['jawaban'])){ 
            if($result[44]['jawaban'] == 1){ $V = $V+1; } else { $E =  $E+1;}
        }
        if(isset($result[45]['jawaban'])){ 
            if($result[45]['jawaban'] == 1){ $O = $O+1; } else { $N =  $N+1;}
        }
        if(isset($result[46]['jawaban'])){ 
            if($result[46]['jawaban'] == 1){ $Z = $Z+1; } else { $A =  $A+1;}
        }
        if(isset($result[47]['jawaban'])){ 
            if($result[47]['jawaban'] == 1){ $K = $K+1; } else { $P =  $P+1;}
        }
        if(isset($result[48]['jawaban'])){ 
            if($result[48]['jawaban'] == 1){ $F = $F+1; } else { $X =  $X+1;}
        }
        if(isset($result[49]['jawaban'])){ 
            if($result[49]['jawaban'] == 1){ $W = $W+1; } else { $B =  $B+1;}
        }
        if(isset($result[50]['jawaban'])){ 
            if($result[50]['jawaban'] == 1){ $G = $G+1; } else { $V =  $V+1;}
        }
        if(isset($result[51]['jawaban'])){ 
            if($result[51]['jawaban'] == 1){ $L = $L+1; } else { $S =  $S+1;}
        }
        if(isset($result[52]['jawaban'])){ 
            if($result[52]['jawaban'] == 1){ $I = $I+1; } else { $R =  $R+1;}
        }
        if(isset($result[53]['jawaban'])){ 
            if($result[53]['jawaban'] == 1){ $T = $T+1; } else { $D =  $D+1;}
        }
        if(isset($result[54]['jawaban'])){ 
            if($result[54]['jawaban'] == 1){ $V = $V+1; } else { $C =  $C+1;}
        }
        if(isset($result[55]['jawaban'])){ 
            if($result[55]['jawaban'] == 1){ $S = $S+1; } else { $E =  $E+1;}
        }
        if(isset($result[56]['jawaban'])){ 
            if($result[56]['jawaban'] == 1){ $Z = $Z+1; } else { $N =  $N+1;}
        }
        if(isset($result[57]['jawaban'])){ 
            if($result[57]['jawaban'] == 1){ $K = $K+1; } else { $A =  $A+1;}
        }
        if(isset($result[58]['jawaban'])){ 
            if($result[58]['jawaban'] == 1){ $F = $F+1; } else { $P =  $P+1;}
        }
        if(isset($result[59]['jawaban'])){ 
            if($result[59]['jawaban'] == 1){ $W = $W+1; } else { $X =  $X+1;}
        }
        if(isset($result[60]['jawaban'])){ 
            if($result[60]['jawaban'] == 1){ $G = $G+1; } else { $T =  $T+1;}
        }
        if(isset($result[61]['jawaban'])){ 
            if($result[61]['jawaban'] == 1){ $L = $L+1; } else { $V =  $V+1;}
        }
        if(isset($result[62]['jawaban'])){ 
            if($result[62]['jawaban'] == 1){ $I = $I+1; } else { $S =  $S+1;}
        }
        if(isset($result[63]['jawaban'])){ 
            if($result[63]['jawaban'] == 1){ $T = $T+1; } else { $R =  $R+1;}
        }
        if(isset($result[64]['jawaban'])){ 
            if($result[64]['jawaban'] == 1){ $V = $V+1; } else { $D =  $D+1;}
        }
        if(isset($result[65]['jawaban'])){ 
            if($result[65]['jawaban'] == 1){ $S = $S+1; } else { $C =  $C+1;}
        }
        if(isset($result[66]['jawaban'])){ 
            if($result[66]['jawaban'] == 1){ $R = $R+1; } else { $E =  $E+1;}
        }
        if(isset($result[67]['jawaban'])){ 
            if($result[67]['jawaban'] == 1){ $K = $K+1; } else { $N =  $N+1;}
        }
        if(isset($result[68]['jawaban'])){ 
            if($result[68]['jawaban'] == 1){ $F = $F+1; } else { $A =  $A+1;}
        }
        if(isset($result[69]['jawaban'])){ 
            if($result[69]['jawaban'] == 1){ $W = $W+1; } else { $P =  $P+1;}
        }
        if(isset($result[70]['jawaban'])){ 
            if($result[70]['jawaban'] == 1){ $G = $G+1; } else { $I =  $I+1;}
        }
        if(isset($result[71]['jawaban'])){ 
            if($result[71]['jawaban'] == 1){ $L = $L+1; } else { $T =  $T+1;}
        }
        if(isset($result[72]['jawaban'])){ 
            if($result[72]['jawaban'] == 1){ $I = $I+1; } else { $V =  $V+1;}
        }
        if(isset($result[73]['jawaban'])){ 
            if($result[73]['jawaban'] == 1){ $T = $T+1; } else { $S =  $S+1;}
        }
        if(isset($result[74]['jawaban'])){ 
            if($result[74]['jawaban'] == 1){ $V = $V+1; } else { $R =  $R+1;}
        }
        if(isset($result[75]['jawaban'])){ 
            if($result[75]['jawaban'] == 1){ $S = $S+1; } else { $D =  $D+1;}
        }
        if(isset($result[76]['jawaban'])){ 
            if($result[76]['jawaban'] == 1){ $R = $R+1; } else { $C =  $C+1;}
        }
        if(isset($result[77]['jawaban'])){ 
            if($result[77]['jawaban'] == 1){ $D = $D+1; } else { $E =  $E+1;}
        }
        if(isset($result[78]['jawaban'])){ 
            if($result[78]['jawaban'] == 1){ $F = $F+1; } else { $N =  $N+1;}
        }
        if(isset($result[79]['jawaban'])){ 
            if($result[79]['jawaban'] == 1){ $W = $W+1; } else { $A =  $A+1;}
        }
        if(isset($result[80]['jawaban'])){ 
            if($result[80]['jawaban'] == 1){ $G = $G+1; } else { $L =  $L+1;}
        }
        if(isset($result[81]['jawaban'])){ 
            if($result[81]['jawaban'] == 1){ $L = $L+1; } else { $I =  $I+1;}
        }
        if(isset($result[82]['jawaban'])){ 
            if($result[82]['jawaban'] == 1){ $I = $I+1; } else { $T =  $T+1;}
        }
        if(isset($result[83]['jawaban'])){ 
            if($result[83]['jawaban'] == 1){ $T = $T+1; } else { $V =  $V+1;}
        }
        if(isset($result[84]['jawaban'])){ 
            if($result[84]['jawaban'] == 1){ $V = $V+1; } else { $S =  $S+1;}
        }
        if(isset($result[85]['jawaban'])){ 
            if($result[85]['jawaban'] == 1){ $S = $S+1; } else { $R =  $R+1;}
        }
        if(isset($result[86]['jawaban'])){ 
            if($result[86]['jawaban'] == 1){ $R = $R+1; } else { $D =  $D+1;}
        }
        if(isset($result[87]['jawaban'])){ 
            if($result[87]['jawaban'] == 1){ $D = $D+1; } else { $C =  $C+1;}
        }
        if(isset($result[88]['jawaban'])){ 
            if($result[88]['jawaban'] == 1){ $C = $C+1; } else { $E =  $E+1;}
        }
        if(isset($result[89]['jawaban'])){ 
            if($result[89]['jawaban'] == 1){ $W = $W+1; } else { $N =  $N+1;}
        }

        //Check rata-rata = Work Direction dsb
        $sum_wd = (float)($N + $G + $A);
        $work_direction = $sum_wd / 3.0;

        $sum_leader = (float)($L + $P + $I);
        $leadership = $sum_leader / 3.0;

        $sum_active = (float)($T + $V);
        $activiti = $sum_active / 2.0;

        $sum_snature = (float)($X + $S + $B + $O);
        $social_nature = $sum_snature / 4.0;

        $sum_workst = (float)($R + $D + $C);
        $work_style = $sum_workst / 3.0;

        $sum_tempra = (float)($Z + $E + $K);
        $temprament = $sum_tempra / 3.0;

        $sum_follow = (float)($F + $W);
        $follower = $sum_follow / 2.0;

        $hasil_kostik = array( 
            'G' => $G,
            'L' => $L,
            'I' => $I,
            'T' => $T,
            'V' => $V,
            'S' => $S,
            'R' => $R,
            'D' => $D,
            'C' => $C,
            'E' => $E,
            'N' => $N,
            'A' => $A,
            'P' => $P,
            'X' => $X,
            'B' => $B,
            'O' => $O,
            'Z' => $Z,
            'K' => $K,
            'F' => $F,
            'W' => $W,
            'work_direction' => $work_direction,
            'leadership' => $leadership,
            'activiti' => $activiti,
            'social_nature' => $social_nature,
            'work_style' => $work_style,
            'temprament' => $temprament,
            'follower' => $follower
        );

        $qi_hasil_kostik = $db
            ->query('insert', 'hrctstd_kostik')
            ->set('id_hrctsth_kostik', $id_kostik)
            ->set('transaction_state', 1)
            ->set($hasil_kostik)
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
