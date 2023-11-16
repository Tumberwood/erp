<?php
    require '../../../../usersc/vendor/autoload.php';
    use Carbon\Carbon;

    // BEGIN generate kode JV
    $tanggal  = Carbon::parse( $result_select_header['tanggal'] );
    $tahun = $tanggal->format('y');
    $bulan = $tanggal->format('m');
    
    $tahunbulan = $tahun . $bulan;

    $qs_aglxxth = $db
        ->query('select', 'aglxxth')
        ->get('COUNT(aglxxth.id) as c_id_aglxxth')
        ->where('MONTH(aglxxth.tanggal)', $tanggal->format('m') )
        ->where('YEAR(aglxxth.tanggal)', $tanggal->format('Y') )
        ->exec();

    $rs_aglxxth            = $qs_aglxxth->fetch();
    $c_id_aglxxth_next     = $rs_aglxxth['c_id_aglxxth'] + 1;
    $len_c_id_aglxxth_next = strlen($c_id_aglxxth_next);
    $zero = "";

    for ($x = 0; $x < (4 - $len_c_id_aglxxth_next); $x++) {
        $zero = $zero . "0";
    } 
    
    $new_number = $zero . $c_id_aglxxth_next;
    $kode = 'JV/' . $tahunbulan . '/' . $new_number;
    
    // END generate kode JV

?>