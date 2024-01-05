<?php
	/**
     * Digunakan untuk menghitung konversi UoM
     * Parameter:
     *  table_name      : nama table database yang akan dihitung
     *  id_transaksi    : id transaksi yang akan dihitung
     */
    require_once( "../../users/init.php" );
	require_once( "../../usersc/lib/DataTables.php" );
    require_once( "datatables_fn_debug.php" );
    require_once( "hakakses_s_fn.php" );

	use
		DataTables\Editor,
		DataTables\Editor\Query,
		DataTables\Editor\Result;

    // BEGIN definisi variable untuk fn_ajax_results.php
    $data      = array();
    $rs_opt    = array();
    $c_rs_opt  = 0;
    $morePages = 0;
    // END definisi variable untuk fn_ajax_results.php

    $table_name   = $_POST['table_name'];
    $id_transaksi = $_POST['id_transaksi'];

    try{
        $db->transaction();

        // BEGIN ambil UoM terkecil
        $qs_iumxxmh = $db
            ->raw()
            ->bind(':id_transaksi', $id_transaksi)
            ->bind(':is_terkecil', 1)
            ->exec('
                SELECT
                    id_iumxxmh as id_iumxxmh_terkecil
                FROM iimummd
                WHERE 
                    id_iimxxmh = (
                        SELECT
                            id_iimxxmh
                        FROM ' . $table_name .
                        ' WHERE
                            id= :id_transaksi
                    ) AND
                    is_terkecil = :is_terkecil
            ');
        $rs_iumxxmh = $qs_iumxxmh->fetch();
        $id_iumxxmh_terkecil = $rs_iumxxmh['id_iumxxmh_terkecil'];
        // END ambil UoM terkecil

        // BEGIN ambil UoM default
        $qs_iumxxmh = $db
            ->raw()
            ->bind(':id_transaksi', $id_transaksi)
            ->bind(':is_default', 1)
            ->exec('
                SELECT
                    id_iumxxmh as id_iumxxmh_default
                FROM iimummd
                WHERE 
                    id_iimxxmh = (
                        SELECT
                            id_iimxxmh
                        FROM ' . $table_name .
                        ' WHERE
                            id= :id_transaksi
                    ) AND
                    is_default = :is_default
            ');
        $rs_iumxxmh = $qs_iumxxmh->fetch();
        $id_iumxxmh_default = $rs_iumxxmh['id_iumxxmh_default'];
        // END ambil UoM default

        $qu_konversi = $db
            ->raw()
            ->exec('
                UPDATE '.$table_name.' AS a
                LEFT JOIN iimummd AS iimummd_terkecil ON iimummd_terkecil.id_iumxxmh = a.id_iumxxmh_unit AND iimummd_terkecil.id_iimxxmh = a.id_iimxxmh
                LEFT JOIN iimummd AS iimummd_default ON iimummd_default.id_iumxxmh = a.id_iumxxmh_default AND iimummd_default.id_iimxxmh = a.id_iimxxmh
                SET
                    a.id_iumxxmh_terkecil = ' . $id_iumxxmh_terkecil . ',
                    a.id_iumxxmh_default = ' . $id_iumxxmh_default . ',
                    a.jumlah_konversi = iimummd_terkecil.jumlah_konversi,
                    a.jumlah_unit_os = a.jumlah_unit, 
                    a.jumlah_terkecil_os = iimummd_terkecil.jumlah_konversi * a.jumlah_unit, 
                    a.jumlah_terkecil = iimummd_terkecil.jumlah_konversi * a.jumlah_unit,
                    a.jumlah_default =  a.jumlah_konversi * a.jumlah_unit / iimummd_default.jumlah_konversi
                WHERE a.id = ' .$id_transaksi
            );
        // commit transaction
        $db->commit();

        $message = 'Konversi UoM Berhasil Diperbaharui';
        $type_message = 'success';
        
    }catch(PDOException $e){
        // rollback on error
        $db->rollback();

        $message = 'Konversi UoM Gagal Berhasil Diperbaharui';
        $type_message = 'success';

    }

    $data = array(
		'message'      => $message,
		'type_message' => $type_message
	);

    // tampilkan results
    require_once( "fn_ajax_results.php" );  
?>