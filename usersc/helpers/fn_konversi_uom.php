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

        $qs_transaksi = $db
            ->query('select', $table_name )
            ->get([
                'id_iimxxmh as id_iimxxmh',
                'id_iumxxmh_unit as id_iumxxmh_unit',
                'jumlah_unit as jumlah_unit'
            ] )
            // ->join('namatable2','namatable2.fieldjoin = _blank.id_namatable2','LEFT' )
            ->where('id', $id_transaksi )
            // ->group_by('_blank.fieldgroupby')
            ->exec();
        $rs_transaksi = $qs_transaksi->fetch();

        $id_iimxxmh         = $rs_transaksi['id_iimxxmh'];
        $id_iumxxmh_unit    = $rs_transaksi['id_iumxxmh_unit'];
        $jumlah_unit        = $rs_transaksi['jumlah_unit'];

        // BEGIN get jumlah_konversi
        $qs_jumlah_konversi = $db
            ->query('select', 'iimummd')
            ->get('jumlah_konversi')
            ->where('id_iimxxmh',$id_iimxxmh)
            ->where('id_iumxxmh',$id_iumxxmh_unit)
            ->exec();
        $rs_jumlah_konversi = $qs_jumlah_konversi->fetch();

        $jumlah_konversi    = $rs_jumlah_konversi['jumlah_konversi'];
        $jumlah_terkecil    = $jumlah_konversi * $jumlah_unit; 
        // END get jumlah_konversi

        // BEGIN get UoM terkecil
        $qs_iumxxmh_terkecil = $db
            ->query('select', 'iimummd' )
            ->get([
                'id_iumxxmh as id_iumxxmh_terkecil'
            ] )
            ->where('iimummd.id_iimxxmh', $id_iimxxmh )
            ->where('iimummd.is_terkecil', 1 )
            ->exec();
        $rs_iumxxmh_terkecil = $qs_iumxxmh_terkecil->fetch();

        $id_iumxxmh_terkecil = $rs_iumxxmh_terkecil['id_iumxxmh_terkecil'];
        // END get UoM terkecil

        // BEGIN get UoM default
        $qs_iumxxmh_default = $db
            ->query('select', 'iimummd' )
            ->get([
                'id_iumxxmh as id_iumxxmh_default',
                'jumlah_konversi as jumlah_konversi_default'
            ] )
            ->where('iimummd.id_iimxxmh', $id_iimxxmh )
            ->where('iimummd.is_default', 1 )
            ->exec();
        $rs_iumxxmh_default = $qs_iumxxmh_default->fetch();

        $id_iumxxmh_default         = $rs_iumxxmh_default['id_iumxxmh_default'];
        $jumlah_konversi_default    = $rs_iumxxmh_default['jumlah_konversi_default'];

        $jumlah_default = $jumlah_konversi * $jumlah_unit / $jumlah_konversi_default;
        // END get UoM default

        // update
        $qu_transaksi = $db
            ->query('update', $table_name)
            ->set('id_iumxxmh_terkecil',$id_iumxxmh_terkecil)
            ->set('id_iumxxmh_default',$id_iumxxmh_default)
            ->set('jumlah_konversi',$jumlah_konversi)
            ->set('jumlah_terkecil',$jumlah_terkecil) 
            ->set('jumlah_default',$jumlah_default) 
            ->set('jumlah_unit_os',$jumlah_unit) 
            ->set('jumlah_terkecil_os',$jumlah_terkecil) 
            ->where('id',$id_transaksi)
            ->exec();

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