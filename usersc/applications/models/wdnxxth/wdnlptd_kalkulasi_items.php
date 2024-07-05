<?php 
    $id_wdnxxth = $values['wdnlptd']['id_wdnxxth'];
    $id_iimxxmh = $values['wdnlptd']['id_iimxxmh'];

    $qs_wdnlptd = $editor->db()
        ->raw()
        ->bind(':id_wdnxxth', $id_wdnxxth)
        ->bind(':id_iimxxmh', $id_iimxxmh)
        ->exec('SELECT
                    a.id_wdnxxth,
                    SUM(a.jumlah_terkecil) AS s_terkecil,
                    SUM(a.jumlah_default) AS s_default,
                    SUM(a.jumlah_default) AS s_unit,
                    a.id_iimxxmh
                FROM wdnlptd a
                WHERE a.id_wdnxxth = :id_wdnxxth AND a.id_iimxxmh = :id_iimxxmh'
    );
    $rs_wdnlptd = $qs_wdnlptd->fetch();
    $s_unit = $rs_wdnlptd['s_unit'];
    $s_default = $rs_wdnlptd['s_default'];
    $s_terkecil = $rs_wdnlptd['s_terkecil'];

    $qu_wdlittd = $editor->db()
        ->query('update', 'wdnittd')
        ->set('jumlah_unit',$s_unit)
        ->set('jumlah_default',$s_default)
        ->set('jumlah_terkecil',$s_terkecil)
        ->where('id_wdnxxth',$id_wdnxxth)
        ->where('id_iimxxmh',$id_iimxxmh)
        ->exec();

?>