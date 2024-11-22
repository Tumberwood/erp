<?php 
    require_once( "../../../../users/init.php" );
    require_once( "../../../../usersc/lib/DataTables.php" );
    require_once( "../../../../usersc/helpers/datatables_fn_debug.php" );
	require_once( "../../../../usersc/vendor/autoload.php");
	require_once( "../../../helpers/hakakses_s_fn.php" );
	include_once( "../../../helpers/SolusiIndonesiaUtilities.php" );

	use Carbon\Carbon,
    SolusiIndonesia\Utilities\General;

    // BEGIN definisi variable untuk fn_ajax_results.php
    $data      = array();
    $rs_opt    = array();
    // END definisi variable untuk fn_ajax_results.php

    // ambil variable dari ajax data
    $selectedIds = $_POST['selectedIds']; 

    $ids = implode(',', $selectedIds);
    $start_at = $_POST['start_at'];
    $finish_at = $_POST['finish_at'];

    //insert packing header
    $qi_wpkxxth = $db
        ->raw()
        ->exec('INSERT INTO wpkxxth (
                    tanggal,
                    transaction_state
                )
                SELECT
                    curdate(),
                    1
        '
    );
    
    $id_wpkxxth = $qi_wpkxxth->insertId();

    //generate_kode Item Status
    $nama_tabel = "wpkxxth";
    $qs_gdnxxsh = $db
        ->raw()
        ->exec('
            SELECT
                *
            FROM 
                gdnxxsh
            WHERE 
                nama_tabel = "wpkxxth"'
        );
    $rs_gdnxxsh = $qs_gdnxxsh->fetch();
    $prefix                 = $rs_gdnxxsh['prefix'];
    $total_digit            = $rs_gdnxxsh['total_digit'];
    $separator              = $rs_gdnxxsh['separator'];

    $nama_field_tanggal = 'activity_log_ml.created_on';
    $field_tanggal 		= date('Y-m-d');
    $field_tanggal_dt	= strtotime($field_tanggal);
    $tahun = substr($field_tanggal,2,2);
    $bulan = substr($field_tanggal,5,2);

    $tanggal = $field_tanggal;
    $where = " WHERE activity_log_ml.kode = 'CREATE' AND activity_log_ml.nama = '" . $nama_tabel . "' ";
    $where = $where . " AND YEAR(".$nama_field_tanggal.") = YEAR('" . $tanggal . "') AND MONTH(".$nama_field_tanggal.") = MONTH('" . $tanggal . "') ";

    General::logChange( $db , 'wpkxxth', $s_id_users, $s_username, 'CREATE', $id_wpkxxth, 'Insert from generate', $start_at, $finish_at );
    
    $qs_c_id_new = $db
        ->raw()
        ->exec('
            SELECT
                count(activity_log_ml.id) as c_id_new
            FROM '.$nama_tabel.'
            LEFT JOIN activity_log_ml ON
                activity_log_ml.id_transaksi = '.$nama_tabel.'.id 
                AND  activity_log_ml.kode = "CREATE" 
                AND activity_log_ml.nama = "'.$nama_tabel.'" 
            ' 
            . $where 

        );
    $rs_c_id_new 	= $qs_c_id_new->fetch();
    $new_number  	= $rs_c_id_new['c_id_new'];
    $tr_kode 		= str_pad($new_number,$total_digit,"0",STR_PAD_LEFT);

    $formatted_kode = $prefix . $separator . $tahun . $bulan . $separator . $tr_kode;
    
    $result = $db
        ->query('update', $nama_tabel)
        ->set('kode',$formatted_kode)
        ->where('id',$id_wpkxxth)
    ->exec();

    $qi_wpkittd = $db
        ->raw()
        ->bind(':id_wpkxxth', $id_wpkxxth)
        ->exec('INSERT INTO wpkittd (
                    id_wpkxxth,
                    id_wpcxxth,
                    id_wpllptd,
                    id_iimxxmh,
                    id_wloxxmh_asal,
                    id_wloxxmh_tujuan,
                    id_iwhxxmh,
                    id_iumxxmh_unit,
                    jumlah_unit,
                    wlpxxmh_kode,
                    wloxxmh_nama,
                    batch_number,
                    expired_date,
                    keterangan,
                    id_wdoittd
                )
                SELECT
                    :id_wpkxxth,
                    id_wpcxxth,
                    id_wpllptd,
                    id_iimxxmh,
                    id_wloxxmh_asal,
                    id_wloxxmh_tujuan,
                    id_iwhxxmh,
                    id_iumxxmh_unit,
                    jumlah_unit,
                    wlpxxmh_kode,
                    wloxxmh_nama,
                    batch_number,
                    expired_date,
                    keterangan,
                    id_wdoittd
                FROM wpclptd
                WHERE id IN ('.$ids.')
        '
    );

    //update flag is_packing pada data Picking tadi wpclptd
    $qu_wpclptd = $db
        ->raw()
        ->exec('UPDATE wpclptd
                SET
                    is_packing = 1
                WHERE id IN ('.$ids.')
    ');

    if(empty($qu_wpclptd)){
        $status_code = 500;
        $message = 'Error Kode Picking';
        $type_message = 'error';
        

    }else{
        $status_code = 200;
        $message = '';
        $type_message = 'success';
        
    }

    $data = array(
        'status_code'       => $status_code,
        'message'           => $message,
        'type_message'      => $type_message,

        'ids'        => $ids,
        'qi_wpkittd'        => $qi_wpkittd,
        'qi_wpkxxth'        => $qi_wpkxxth,
        'qu_wpclptd'        => $qu_wpclptd,
    );

    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>