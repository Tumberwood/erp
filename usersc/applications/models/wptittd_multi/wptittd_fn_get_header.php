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

    $qs_wptxxth = $db
        ->raw()
        ->bind(':s_id_users', $s_id_users)
        ->exec('SELECT 
                    a.id, 
                    a.id_wpttpmh, 
                    wpttpmh.nama
                FROM 
                    wptxxth a
                LEFT JOIN 
                    wpttpmh ON wpttpmh.id = a.id_wpttpmh
                WHERE 
                    a.transaction_state = 0
                    AND a.created_by = :s_id_users'
        );

    $rs_wptxxth = $qs_wptxxth->fetch();

    if(empty($rs_wptxxth)){
        $status_code = 500;
        $message = 'Data Putaway Tidak ditemukan pada user ini!';
        $type_message = 'error';
        $id_wpttpmh = 0;
        $nama = '';
        $id = 0;
        $c_id_confirm = 0;
    }else{
        $status_code = 200;
        $message = '';
        $type_message = 'success';
        $id_wpttpmh = $rs_wptxxth['id_wpttpmh'];
        $nama = $rs_wptxxth['nama'];
        $id = $rs_wptxxth['id'];

        $qs_confirmD = $db
            ->raw()
            ->bind(':id', $id)
            ->exec('SELECT
                        COUNT(a.id) c_id_confirm
                    FROM wptittd a
                    WHERE a.id_wptxxth = :id AND a.transaction_state = 1
                '
            );

        $rs_confirmD = $qs_confirmD->fetch();
        $c_id_confirm = $rs_confirmD['c_id_confirm'];
    }

    $data = array(
        'status_code'    => $status_code,
        'message'        => $message,
        'type_message'   => $type_message,
        'id_wpttpmh' => $id_wpttpmh,
        'nama' => $nama,
        'id' => $id,
        'c_id_confirm' => $c_id_confirm,
    );

    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>