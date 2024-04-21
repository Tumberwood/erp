<?php 
    /**
     * Digunakan untuk insert ke table ndcxxrd
     * Table terkait    : ndcxxrd, ndctotd, ndcxxmh
     * Parameter        : 
     *  - id_transaksi       : id ndctotd, didapatkan saat confirm
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

        $qi_ndcxxrd_minus = $db
            ->raw()
            ->bind(':ndctoth', $_POST['id_transaksi'])
            ->exec('
                INSERT INTO
                    ndcxxrd (
                        id_ndcxxmh,
                        id_transaksi_h,
                        id_transaksi_d,
                        id_users,
                        kode,
                        tanggaljam,
                        dokumen_nomor,
                        transaction_state,
                        jumlah_terkecil
                    )
                SELECT
                    ndctoth.id,
                    ndctotd.id,
                    ndctotd.id,
                    activity_log_ml_c.created_by,
                    ndctoth.kode,
                    ndctoth.tanggal_jam_to,
                    ndcxxmh.dokumen_nomor,
                    1,
                    -1
                FROM ndctotd
                LEFT JOIN ndcxxmh ON ndcxxmh.id = ndctotd.id_ndcxxmh
                LEFT JOIN ndctoth ON ndctoth.id = ndctotd.id_ndctoth
                LEFT JOIN activity_log_ml as activity_log_ml_c ON 
                    activity_log_ml_c.id_transaksi = ndctoth.id 
                    AND activity_log_ml_c.kode = "CREATE" AND activity_log_ml_c.nama = "ndctoth"
                WHERE
                    ndctotd.id_ndctoth = :ndctoth
            ');

        $qi_ndcxxrd_plus = $db
            ->raw()
            ->bind(':ndctoth', $_POST['id_transaksi'])
            ->exec('
                INSERT INTO
                    ndcxxrd (
                        id_ndcxxmh,
                        id_transaksi_h,
                        id_transaksi_d,
                        id_users,
                        kode,
                        tanggaljam,
                        dokumen_nomor,
                        transaction_state,
                        jumlah_terkecil
                    )
                SELECT
                    ndctoth.id,
                    ndctotd.id,
                    ndctotd.id,
                    ndctoth.id_users_penerima,
                    ndctoth.kode,
                    ndctoth.tanggal_jam_to,
                    ndcxxmh.dokumen_nomor,
                    1,
                    1
                FROM ndctotd
                LEFT JOIN ndcxxmh ON ndcxxmh.id = ndctotd.id_ndcxxmh
                LEFT JOIN ndctoth ON ndctoth.id = ndctotd.id_ndctoth
                WHERE
                    ndctotd.id_ndctoth = :ndctoth
            ');


        if(!empty($qi_ndcxxrd_minus) && !empty($qi_ndcxxrd_plus)){
            $db->commit();
            $status_code  = 200;
            $message      = 'Data Dokumen Masuk Berhasil Ditambahkan';
            $type_message = 'success';
            // parameter lain
        }else{
            $db->rollback();
            $status_code  = 500;
            $message      = 'Data Dokumen Masuk Gagal Ditambahkan. Data bermasalah!';
            $type_message = 'error';
            // parameter lain
        }
    }catch(PDOException $e){
        $db->rollback();
        $status_code  = 500;
        $message      = 'Data Dokumen Masuk Gagal Ditambahkan, ' . $e->getMessage();
        $type_message = 'error';
    }catch (Exception $e) {
        $db->rollback();
        $status_code  = 500;
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