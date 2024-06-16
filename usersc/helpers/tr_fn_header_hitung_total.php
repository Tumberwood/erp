<?php
	/**
     * Digunakan untuk nilai-nilai di header, saat transaksi detail di submit
     * Parameter:
     *  @param {String} tbl_name_h
     *  @param {String} tbl_name_d
     *  @param {Number} id_transaksi_h
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

    
    $tbl_name_h     = $_POST['tbl_name_h'];
    $tbl_name_d     = $_POST['tbl_name_d'];
    $id_transaksi_h = $_POST['id_transaksi_h'];

    try{
        $db->transaction();

        /**
         * ambil nilai sum dpp dari detail. 
         * ini akan menjadi nilai subtotal pada header
         */
        $qs_detail = $db
            ->raw()
            ->bind(':id_transaksi_h', $id_transaksi_h)
            ->exec('
                SELECT
                    SUM(dpp) as s_subtotal
                FROM '.$tbl_name_d.'
                WHERE 1
                    AND id_' . $tbl_name_h . '=:id_transaksi_h
            ');
        $rs_detail  = $qs_detail->fetch();
        $s_subtotal = $rs_detail['s_subtotal'];

        $qs_header = $db
            ->raw()
            ->bind(':id_transaksi_h', $id_transaksi_h)
            ->exec('
                SELECT
                    diskon_jenis,
                    diskon_value,
                    diskon_persen,
                    is_pajak,
                    pajak_in_ex,
                    pajak_persen
                FROM '.$tbl_name_h.'
                WHERE 1
                    AND id = :id_transaksi_h
            ');
        $rs_header      = $qs_header->fetch();
        $is_pajak       = $rs_header['is_pajak'];
        $pajak_in_ex    = $rs_header['pajak_in_ex'];
        $tarif          = $rs_header['pajak_persen'];

        // hitung ulang nilai diskon_final
        if($rs_header['diskon_jenis'] == 0){
            $diskon_final_h = 0;
        }elseif($rs_header['diskon_jenis'] == 1){
            $diskon_final_h = ($rs_header['diskon_persen'] / 100 * $s_subtotal);
        }elseif($rs_header['diskon_jenis'] == 2){
            $diskon_final_h = $rs_header['diskon_value'];
        }else{
            // harusnya tidak masuk ke sini karena pilihan di form hanya 0|1|2
        }

        $dpp_h = $s_subtotal - $diskon_final_h;

        if($dpp_h > 0){
            if($is_pajak == 1){
                // jika menggunakan pajak
                // cek pajak include atau exclude

                if($pajak_in_ex == 1){
                    // include
                    $dpp_final = 100 / ($tarif + 100) * $dpp_h;
                    $dpp_final = round($dpp_final * 100) / 100;
                    
                    $pajak_final = $dpp_h - $dpp_final;
                    $pajak_final = round($pajak_final * 100) / 100;
                    
                    $grand_total = $dpp_h;
                    $grand_total = round($grand_total * 100) / 100;
                }else{
                    //exclude
                    $pajak_final = $tarif / 100 * $dpp_h;
                    $pajak_final = round($pajak_final * 100) / 100;
    
                    $dpp_final   = $dpp_h;
                    $dpp_final   = round($dpp_final * 100) / 100;
    
                    $grand_total = $dpp_final + $pajak_final;
                    $grand_total = round($grand_total * 100) / 100;
                }
            }else{
                // jika tanpa pajak
                $dpp_final   = $dpp_h;
                $pajak_final = 0;
                $grand_total = $dpp_final + $pajak_final;
                $grand_total = round($grand_total * 100) / 100;
            }

            // update header
            $qu_header = $db
                ->raw()
                ->bind(':diskon_final', $diskon_final_h)
                ->bind(':dpp', $dpp_h)
                ->bind(':dpp_final', $dpp_final)
                ->bind(':pajak_final', $pajak_final)
                ->bind(':grand_total', $grand_total)
                ->bind(':id_transaksi_h', $id_transaksi_h)
                ->exec('
                    UPDATE ' .$tbl_name_h. '
                    SET
                        diskon_final = :diskon_final,
                        dpp          = :dpp,
                        dpp_final    = :dpp_final,
                        pajak_final  = :pajak_final,
                        grand_total  = :grand_total
                    WHERE 1
                        AND id =:id_transaksi_h
                ');
            
        }else{
            // tidak melakukan update
            // harusnya tidak masuk sini, karena script ini dipanggil saat detail transaksi di submit
            // saat detail transaksi di submit, sudah divalidasi harus ada subtotalnya
        }

        $status_code  = 500;
        $message      = 'Kalkulasi Header Berhasil Dilakukan!';
        $type_message = 'success';

        // commit transaction
        $db->commit();

        
        
    }catch(Exception $e){
        // rollback on error
        $db->rollback();

        $status_code  = 500;
        $message      = 'Kalkulasi Header Gagal Dilakukan!' . $e->getMessage();
        $type_message = 'danger';

    }
    
    $data = array(
		'diskon_final_h'      => $diskon_final_h,
		'is_pajak'      => $is_pajak,
		'pajak_in_ex'      => $pajak_in_ex,
		'tarif'      => $tarif,
		's_subtotal'      => $s_subtotal,
		'dpp_h'      => $dpp_h,
		'pajak_final'      => $pajak_final,
		'dpp_final'      => $dpp_final,
		'grand_total'      => $grand_total,
		'message'      => $message,
		'type_message' => $type_message
	);

    // tampilkan results
    require_once( "fn_ajax_results.php" );  
?>