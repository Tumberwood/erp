<?php 
    require_once( "../../../../users/init.php" );
    require_once( "../../../../usersc/lib/DataTables.php" );
    require_once( "../../../../usersc/helpers/datatables_fn_debug.php" );
	require_once( "../../../../usersc/vendor/autoload.php");
	require_once( "../../../helpers/hakakses_s_fn.php" );

	use Carbon\Carbon;

    // BEGIN definisi variable untuk fn_ajax_results.php
    $data      = array();
    $rs_opt    = array();
    // END definisi variable untuk fn_ajax_results.php

    // ambil variable dari ajax data
    $wlpxxmh_kode = $_POST['wlpxxmh_kode'];
    $uniqueToken = $_POST['uniqueToken'];
    $id_wpttpmh = $_POST['id_wpttpmh'];
    
    if ($id_wpttpmh == 2) {
        $where_wloctmh = 'AND iivxxrd.id_wloctmh IN (1,6)';
    } else {
        $where_wloctmh = 'AND iivxxrd.id_wloctmh = 1';
    }

    if ($uniqueToken == '') {
        $where_keterangan = '';
    } else {
        $where_keterangan = ' AND iivxxrd.keterangan <> "'.$uniqueToken.'"';
    }
    // echo $id_wpttpmh;

    $qs_iivxxrd = $db
        // ->query('select', 'iivxxrd' )
        // ->get([
        //     'iivxxrd.id_iimxxmh as id_iimxxmh',
        //     'iivxxrd.iimxxmh_kode as iimxxmh_kode',
        //     'iivxxrd.iimxxmh_nama as iimxxmh_nama',
        //     'iivxxrd.iumxxmh_unit_kode as iumxxmh_unit_kode',
        //     'SUM(iivxxrd.jumlah_unit * iivxxrd.is_fisik) as s_jumlah_unit'
        // ] )
        // ->where('iivxxrd.wlpxxmh_kode', "LPN240001" )
        // ->where('iivxxrd.id_wloctmh', 1 )
        // ->exec();

        
        ->raw()
        ->bind(':wlpxxmh_kode', $wlpxxmh_kode)
        ->exec('SELECT 
                    iivxxrd.id_iimxxmh as id_iimxxmh,
                    iivxxrd.iimxxmh_kode as iimxxmh_kode,
                    iivxxrd.iimxxmh_nama as iimxxmh_nama,
                    iivxxrd.id_iumxxmh_unit as id_iumxxmh_unit,
                    def.id_iumxxmh id_iumxxmh_default, -- DEFAULT dari master
                    iivxxrd.id_iumxxmh_terkecil as id_iumxxmh_terkecil,
                    iivxxrd.iumxxmh_unit_kode as iumxxmh_unit_kode,
                    m_def.kode as iumxxmh_default_kode,
                    SUM(
                        unit.jumlah_konversi * iivxxrd.jumlah_unit / def.jumlah_konversi
                        ) AS s_jumlah_unit,
                        
                    SUM(
                        unit.jumlah_konversi * iivxxrd.jumlah_unit / def.jumlah_konversi
                        ) AS sisa_default,
                    SUM(iivxxrd.jumlah_terkecil) AS sisa_terkecil
                    
                FROM 
                    iivxxrd
                LEFT JOIN iimummd def ON def.id_iimxxmh = iivxxrd.id_iimxxmh AND def.is_default = 1
                LEFT JOIN iimummd unit ON unit.id_iimxxmh = iivxxrd.id_iimxxmh AND unit.id_iumxxmh = iivxxrd.id_iumxxmh_unit
                LEFT JOIN iumxxmh m_def ON m_def.id = def.id_iumxxmh
                WHERE 
                    iivxxrd.wlpxxmh_kode = :wlpxxmh_kode AND iivxxrd.iimxxmh_status = 1
                    '.$where_wloctmh.'
                    '.$where_keterangan.'
                GROUP BY
                    iivxxrd.id_iimxxmh,
                    iivxxrd.iimxxmh_kode,
                    iivxxrd.iimxxmh_nama;
    
        '
        );
    $rs_iivxxrd = $qs_iivxxrd->fetch();

    if(empty($rs_iivxxrd)){
        $status_code = 500;
        $message = 'Stok di Lokasi Receiving Sudah Tidak Ada!';
        $type_message = 'error';
        
        $id_iimxxmh        = 0;
        $iimxxmh_kode      = '';
        $iimxxmh_nama      = '';
        $s_jumlah_unit     = 0;
        $id_iumxxmh_unit     = 0;
        $id_iumxxmh_default     = 0;
        $id_iumxxmh_terkecil     = 0;
        $iumxxmh_unit_kode = '';
        $iumxxmh_default_kode = '';
        $sisa_terkecil = '';
        $sisa_default = '';

    }else{
        $status_code = 200;
        $message = '';
        $type_message = 'success';

        $id_iimxxmh        = $rs_iivxxrd['id_iimxxmh'];
        $iimxxmh_kode      = $rs_iivxxrd['iimxxmh_kode'];
        $iimxxmh_nama      = $rs_iivxxrd['iimxxmh_nama'];
        $s_jumlah_unit     = $rs_iivxxrd['s_jumlah_unit'];
        $id_iumxxmh_unit     = $rs_iivxxrd['id_iumxxmh_unit'];
        $id_iumxxmh_default     = $rs_iivxxrd['id_iumxxmh_default'];
        $id_iumxxmh_terkecil     = $rs_iivxxrd['id_iumxxmh_terkecil'];
        $iumxxmh_unit_kode = $rs_iivxxrd['iumxxmh_unit_kode'];
        $iumxxmh_default_kode = $rs_iivxxrd['iumxxmh_default_kode'];
        $sisa_terkecil = $rs_iivxxrd['sisa_terkecil'];
        $sisa_default = $rs_iivxxrd['sisa_default'];
        
    }

    $data = array(
        'status_code'       => $status_code,
        'message'           => $message,
        'type_message'      => $type_message,

        'id_iimxxmh'        => $id_iimxxmh,
        'iimxxmh_kode'      => $iimxxmh_kode,
        'iimxxmh_nama'      => $iimxxmh_nama,
        's_jumlah_unit'     => $s_jumlah_unit,
        'id_iumxxmh_unit'     => $id_iumxxmh_unit,
        'id_iumxxmh_default'     => $id_iumxxmh_default,
        'id_iumxxmh_terkecil'     => $id_iumxxmh_terkecil,
        'iumxxmh_unit_kode' => $iumxxmh_unit_kode,
        'iumxxmh_default_kode' => $iumxxmh_default_kode,
        'sisa_terkecil' => $sisa_terkecil,
        'sisa_default' => $sisa_default,
    );

    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>