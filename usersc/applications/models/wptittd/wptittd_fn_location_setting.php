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
    $wloxxmh_nama_scan = $_POST['wloxxmh_nama_scan'];
    $wlpxxmh_kode = $_POST['wlpxxmh_kode'];
    $id_iimxxmh = $_POST['id_iimxxmh'];
    $id_iumxxmh_unit = $_POST['id_iumxxmh_unit'];
    $keterangan = $_POST['keterangan'];
    
    $is_next = 0;
    $is_inventory = 0;
    // print_r($wloxxmh_nama_scan);
    // print_r($id_iimxxmh);
    
    $qs_loc_pref = $db
        ->raw()
        ->bind(':wloxxmh_nama_scan', $wloxxmh_nama_scan)
        ->bind(':id_iimxxmh', $id_iimxxmh)
        ->exec('SELECT
                    b.id id_wloxxmh_tujuan,
                    b.nama,
                    a.urutan,
                    a.id_iimxxmh,
                    b.kapasitas,
                    b.id_iumxxmh_kapasitas,
                    c.kode
                FROM wimlotd a
                LEFT JOIN wloxxmh b ON b.id = a.id_wloxxmh OR (b.id_wloctmh = 8 AND b.is_default = 1)
                LEFT JOIN iumxxmh c ON c.id = b.id_iumxxmh_kapasitas
                WHERE a.id_iimxxmh = :id_iimxxmh AND b.nama = :wloxxmh_nama_scan
                GROUP BY b.id
                ORDER BY
                CASE
                    WHEN b.nama NOT LIKE "Overflow%" THEN a.urutan
                    ELSE 9999
                END ASC,
                b.nama ASC; 
        '
        );

    $rs_loc_pref = $qs_loc_pref->fetch();

    if(empty($rs_loc_pref)){
        $status_code = 500;
        $message = 'Lokasi tidak terdaftar di Location Preference!';
        $type_message = 'error';
        $id_wloxxmh_tujuan = 0;
        
    }else{
        //jika ada di location preference, maka dilihat di inventory, apakah masih ada ruang
        
        $id_wloxxmh_tujuan = $rs_loc_pref['id_wloxxmh_tujuan'];
        $id_iumxxmh_kapasitas = $rs_loc_pref['id_iumxxmh_kapasitas'];
        $kode = $rs_loc_pref['kode'];
        $kapasitas = $rs_loc_pref['kapasitas'];
        
        $qs_kapasitas = $db
        ->raw()
        ->bind(':id_wloxxmh_tujuan', $id_wloxxmh_tujuan)
        ->bind(':id_iumxxmh_unit', $id_iumxxmh_unit)
        ->exec('SELECT
                    COUNT(a.id) AS c_id,
                    a.id_iumxxmh_terkecil,
                    SUM(a.jumlah_terkecil) AS s_terkecil,
                    b.jumlah_konversi,
                    SUM((a.jumlah_terkecil) / b.jumlah_konversi) AS jumlah_unit,
                    c.kode
                FROM iivxxrd a
                LEFT JOIN iimummd b ON b.id_iimxxmh = a.id_iimxxmh AND b.id_iumxxmh = :id_iumxxmh_unit
                LEFT JOIN iumxxmh c ON c.id = b.id_iumxxmh
                WHERE a.id_wloxxmh = :id_wloxxmh_tujuan AND a.is_fisik = 1
                GROUP BY a.wlpxxmh_kode
                HAVING s_terkecil > 0;
        '
        );
        $rs_kapasitas = $qs_kapasitas->fetchAll();

        $qs_inputan = $db
        ->raw()
        ->bind(':keterangan', $keterangan)
        ->exec('SELECT
                    (a.jumlah_terkecil * -1) terkecil_input,
                    (a.jumlah_terkecil * -1) / b.jumlah_konversi AS jumlah_unit
                FROM iivxxrd a
                LEFT JOIN iimummd b ON b.id_iimxxmh = a.id_iimxxmh AND b.id_iumxxmh = 2
                LEFT JOIN iumxxmh c ON c.id = b.id_iumxxmh
                WHERE a.keterangan = :keterangan
                ;
        '
        );
        $rs_inputan = $qs_inputan->fetch();
        $jumlah_unit_inputan = $rs_inputan['jumlah_unit'];

        $is_melebihi_kapasitas = 0;

        if (empty($rs_kapasitas)) {
            // echo 1111;
            if ($id_iumxxmh_kapasitas != 14) {
                if ($jumlah_unit_inputan > $kapasitas) {
                    $is_melebihi_kapasitas = 1;
                    $uom_kapasitas = $kode;
                } else {
                    $is_next = 1;
                }
            } else {
                $is_next = 1;
            }
            //kalau kosong itu berarti lokasi masih belum ada di iiv, bisa digunakan
            // print_r($is_inventory);
            
        } else {
            $lpn = 0;
            $jumlah_unit = $jumlah_unit_inputan;
            
            foreach ($rs_kapasitas as $key => $loc_cap) {
                $lpn++;
                $jumlah_unit = $jumlah_unit + $loc_cap['jumlah_unit'];
                $c_id = $loc_cap['c_id'];
                $kode = $loc_cap['kode'];
            }
            

            // print_r($c_id);
            // if ($c_id > 0) {
            //     $is_inventory = 0;
            // } else {
                $is_inventory = 1;
            // }

            //jika LPN
            if ($id_iumxxmh_kapasitas == 14) {
                if ($lpn >= $kapasitas) {
                    $is_melebihi_kapasitas = 1;
                    $uom_kapasitas = "LPN";
                    $is_next = 0;
                } else {
                    $is_next = 1;
                }
            //Jika bukan LPN seperti Box pcs dsb 
            } else {
                if ($jumlah_unit > $kapasitas) {
                    $is_melebihi_kapasitas = 1;
                    $uom_kapasitas = $kode;
                    $is_next = 0;
                } else {
                    $is_next = 1;
                }
            }

        }

        if($is_melebihi_kapasitas){
            $status_code = 500;
            $message = 'Kapasitas di lokasi tujuan sudah penuh! (Max '.$kapasitas. ' ' .$uom_kapasitas.')<br>Silahkan ganti lokasi atau gunakan gabung LPN!';
            $type_message = 'error';
            $id_wloxxmh_tujuan = 0;
        }
        
        if ($is_next == 1) {
            $status_code = 200;
            $message = '';
            $type_message = 'success';
        }
        
    }

    // $qs_iiv = $db
    //     ->raw()
    //     ->bind(':wloxxmh_nama_scan', $wloxxmh_nama_scan)
    //     ->exec('SELECT
    //                 SUM(xr.jumlah_terkecil) s_terkecil,
    //                 xr.id_wloxxmh,
    //                 b.nama
    //             FROM iivxxrd xr
    //             LEFT JOIN wloxxmh b ON b.id = xr.id_wloxxmh
    //             WHERE xr.is_fisik = 1 AND b.nama = :wloxxmh_nama_scan
    //             GROUP BY xr.id_wloxxmh
    //             HAVING s_terkecil > 0
    //     '
    //     );

    // $rs_iiv = $qs_iiv->fetch();

    $data = array(
        'status_code'       => $status_code,
        'message'           => $message,
        'type_message'      => $type_message,

        'id_wloxxmh_tujuan'        => $id_wloxxmh_tujuan,
        'is_inventory'        => $is_inventory,
    );

    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>