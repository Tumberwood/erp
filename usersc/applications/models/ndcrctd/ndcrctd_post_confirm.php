<?php 
    /**
     * Digunakan untuk insert ke table ndcxxrd
     * Table terkait    : ndcxxrd, ndcrctd, ndcxxmh
     * Parameter        : 
     *  - id_transaksi       : id ndcrctd, didapatkan saat confirm
     */
    require_once( "../../../../users/init.php" );
	require_once( "../../../../usersc/lib/DataTables.php" );
	require_once( "../../../../usersc/helpers/datatables_fn_debug.php" );

    // BEGIN definisi variable untuk fn_ajax_results.php
    $data      = array();
    $rs_opt    = array();
    // END definisi variable untuk fn_ajax_results.php


    try{
        $db->transaction();

        $qr_ndcxxrd = $db
            ->raw()
            ->bind(':id_ndcrctd', $_POST['id_transaksi'])
            ->exec('
                INSERT INTO
                    ndcxxrd (
                        id_ndcxxmh,
                        id_transaksi_h,
                        id_transaksi_d,
                        tanggaljam,
                        dokumen_nomor,
                        transaction_state
                    )
                SELECT
                    ndcxxmh.id,
                    ndcrctd.id,
                    ndcrctd.id,
                    ndcrctd.tanggal_jam_terima,
                    ndcxxmh.dokumen_nomor,
                    1
                FROM ndcrctd
                LEFT JOIN ndcxxmh ON ndcxxmh.id = ndcrctd.id_ndcxxmh
                WHERE
                    ndcrctd.id = :id_ndcrctd
            ');


        if(!empty($qr_ndcxxrd)){
            $db->commit();
            $status_code  = '200';
            $message      = 'Data Dokumen Masuk Berhasil Ditambahkan';
            $type_message = 'success';
            // parameter lain
        }else{
            $db->rollback();
            $status_code  = '500';
            $message      = 'Data Dokumen Masuk Gagal Ditambahkan. Data bermasalah!';
            $type_message = 'error';
            // parameter lain
        }
    }catch(PDOException $e){
        $db->rollback();
        $status_code  = '500';
        $message      = 'Data Dokumen Masuk Gagal Ditambahkan, ' . $e->getMessage();
        $type_message = 'error';
    }
    // build response
    $data = array(
        'status_code'    => $status_code,
        'message'        => $message,
        'type_message'   => $type_message
    );
    
    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>