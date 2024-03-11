<?php
    /**
     * isNextProcess
     * Digunakan untuk melakukan pengecekan apakah sebuah data atau transaksi sudah ditarik ke proses selanjutnya.
     * Ini hanya memberikan flag is_nexprocess = 1 pada table database. Default: null
     * Term:
     *  asal    : table yang akan dicek apakah sudah ditarik atau belum ke proses selanjutnya
     *  tujuan  : table next proses yang menggunakan data atau transaksi tersebut
     * Function ini dipanggil pada file model _extra, pada event postCreate, postEdit, dan preRemove
     * Parameter:
     *  @param object   $db database connection, biasanya diisi $editor->db()
     *  @param string   $tbl_name_asal_h nama tabel asal pada database
     *  @param string   $tbl_name_asal_d nama tabel asal pada database
     *  @param string   $tbl_name_tujuan_d nama tabel tujuan pada database
     *  @param string   $id_transaksi_tujuan_d, biasanya diisi $id
     *  @param string   $action : CREATE | EDIT | REMOVE
     * 
     */

    function isNextProcess( $db, $tbl_name_asal_h, $tbl_name_asal_d, $tbl_name_tujuan_d, $id_transaksi_tujuan_d, $action, $dt_values ) {

        if($action == 'CREATE'){
            // dapatkan id transaksi asal
            $qs_id_asal = $db
                ->raw()
                ->bind(':id_transaksi_tujuan_d', $id_transaksi_tujuan_d)
                ->exec('
                    SELECT
                        id_'.$tbl_name_asal_d.' as id_transaksi_asal_d
                    FROM '.$tbl_name_tujuan_d.'
                    WHERE
                        id =:id_transaksi_tujuan_d
                ');
            $rs_id_asal          = $qs_id_asal->fetch();
            $id_transaksi_asal_d = $rs_id_asal['id_transaksi_asal_d'];

            if($tbl_name_asal_h != ''){
                // jika yang dicari header detail
                $qs_detail_asal = $db
                    ->raw()
                    ->bind(':id_transaksi_asal_d', $id_transaksi_asal_d)
                    ->exec('
                        SELECT
                            id_'.$tbl_name_asal_h.' as id_transaksi_asal_h,
                            is_nextprocess
                        FROM '.$tbl_name_asal_d.'
                        WHERE 1
                            AND id = :id_transaksi_asal_d
                    ');

                $rs_detail_asal      = $qs_detail_asal->fetch();
                $id_transaksi_asal_h = $rs_detail_asal['id_transaksi_asal_h'];
                $is_nextprocess_d    = $rs_detail_asal['is_nextprocess'];

            }else{
                // jika yang dicari hanya header saja
                // tidak perlu mencari $id_transaksi_asal_h
                $qs_detail_asal = $db
                    ->raw()
                    ->bind(':id_transaksi_asal_d', $id_transaksi_asal_d)
                    ->exec('
                        SELECT
                            is_nextprocess
                        FROM '.$tbl_name_asal_d.'
                        WHERE 1
                            AND id = :id_transaksi_asal_d
                    ');

                $rs_detail_asal      = $qs_detail_asal->fetch();
                $is_nextprocess_d    = $rs_detail_asal['is_nextprocess'];
            }
            

            if($is_nextprocess_d == 1){
                // jika sudah pernah diambil sebelumnya
                // tidak perlu lakukan apa-apa
            }else{
                // update detail tabel detail asal:is_nextprocess = 1
                $qu_detail_asal = $db
                    ->raw()
                    ->bind(':id_transaksi_asal_d', $id_transaksi_asal_d)
                    ->exec('
                        UPDATE '.$tbl_name_asal_d.'
                        SET is_nextprocess = 1
                        WHERE  1
                            AND id = :id_transaksi_asal_d
                    ');

                if($tbl_name_asal_h != ''){
                    // jika yang dicari header detail
                    // cek header asal
                    $qs_header_asal = $db
                        ->raw()
                        ->bind(':id_transaksi_asal_h', $id_transaksi_asal_h)
                        ->exec('
                            SELECT
                                is_nextprocess
                            FROM '.$tbl_name_asal_h.'
                            WHERE 1
                                AND id = :id_transaksi_asal_h
                        ');

                    $rs_header_asal   = $qs_header_asal->fetch();
                    $is_nextprocess_h = $rs_header_asal['is_nextprocess'];

                    if($is_nextprocess_h == 1){
                        // do nothing karena sudah di update
                    }else{
                        $qu_header_asal = $db
                            ->raw()
                            ->bind(':id_transaksi_asal_h', $id_transaksi_asal_h)
                            ->exec('
                                UPDATE '.$tbl_name_asal_h.'
                                SET is_nextprocess = 1
                                WHERE  1
                                    AND id = :id_transaksi_asal_h
                            ');
                    }
                }else{
                    // jika yang dicari hanya header saja
                    // tidak perlu cek header asal
                }

                if($qu_detail_asal){
                    $status_code  = 200;
                    $message      = 'Flag Next Process Berhasil Diperbaharui';
                    $type_message = 'success';
                }else{
                    $status_code  = 500;
                    $message      = 'Flag Next Process Gagal Diperbaharui';
                    $type_message = 'error';
                }

            }
        }elseif($action == 'EDIT'){
            // ambil id_transaksi_asal_d sebelum edit
            $qs_id_asal = $db
                ->raw()
                ->bind(':id_transaksi_tujuan_d', $id_transaksi_tujuan_d)
                ->exec('
                    SELECT
                        id_'.$tbl_name_asal_d.' as id_transaksi_asal_d_before
                    FROM '.$tbl_name_tujuan_d.'
                    WHERE
                        id =:id_transaksi_tujuan_d
                ');
            $rs_id_asal                 = $qs_id_asal->fetch();
            $id_transaksi_asal_d_before = $rs_id_asal['id_transaksi_asal_d_before'];

            $id_transaksi_asal_d_after = $dt_values[$tbl_name_tujuan_d]['id_'.$tbl_name_asal_d];
            
            if($id_transaksi_asal_d_before != $id_transaksi_asal_d_after){
                // jika ada perubahan, maka dikembalikan ke null
                $qu_detail_asal_before = $db
                    ->raw()
                    ->bind(':id_transaksi_asal_d', $id_transaksi_asal_d_before)
                    ->exec('
                        UPDATE '.$tbl_name_asal_d.'
                        SET is_nextprocess = null
                        WHERE  1
                            AND id = :id_transaksi_asal_d
                    ');
            }

            $qu_detail_asal = $db
                ->raw()
                ->bind(':id_transaksi_asal_d', $id_transaksi_asal_d_after)
                ->exec('
                    UPDATE '.$tbl_name_asal_d.'
                    SET is_nextprocess = 1
                    WHERE  1
                        AND id = :id_transaksi_asal_d
                ');
            

        }elseif($action == 'REMOVE'){

            // dapatkan id transaksi asal
            $qs_id_asal = $db
                ->raw()
                ->bind(':id_transaksi_tujuan_d', $id_transaksi_tujuan_d)
                ->exec('
                    SELECT
                        id_'.$tbl_name_asal_d.' as id_transaksi_asal_d
                    FROM '.$tbl_name_tujuan_d.'
                    WHERE
                        id =:id_transaksi_tujuan_d
                ');
            $rs_id_asal          = $qs_id_asal->fetch();
            $id_transaksi_asal_d = $rs_id_asal['id_transaksi_asal_d'];

            // update is_nextprocess = null
            $qu_detail_asal = $db
                ->raw()
                ->bind(':id_transaksi_asal_d', $id_transaksi_asal_d)
                ->exec('
                    UPDATE '.$tbl_name_asal_d.'
                    SET is_nextprocess = null
                    WHERE  1
                        AND id = :id_transaksi_asal_d
                ');

            if($tbl_name_asal_h != ''){
                // ambil id_transaksi_asal_h
                $qs_detail_asal = $db
                    ->raw()
                    ->bind(':id_transaksi_asal_d', $id_transaksi_asal_d)
                    ->exec('
                        SELECT
                            id_'.$tbl_name_asal_h.' as id_transaksi_asal_h
                        FROM '.$tbl_name_asal_d.'
                        WHERE 1
                            AND id = :id_transaksi_asal_d
                    ');
                $rs_detail_asal = $qs_detail_asal->fetch();
                $id_transaksi_asal_h = $rs_detail_asal['id_transaksi_asal_h'];

                // cek apakah masih ada is_nextprocess = 1 pada semua baris data tabel detail terkait
                $qs_s_is_nextprocess = $db
                    ->raw()
                    ->bind(':id_transaksi_asal_h', $id_transaksi_asal_h)
                    ->exec('
                        SELECT
                            id_'.$tbl_name_asal_h.' as id_transaksi_asal_h,
                            SUM(is_nextprocess) as s_is_nextprocess
                        FROM '.$tbl_name_asal_d.'
                        WHERE 1
                            AND id_'.$tbl_name_asal_h.' = :id_transaksi_asal_h
                        GROUP BY id_'.$tbl_name_asal_h
                    );
                $rs_s_is_nextprocess = $qs_s_is_nextprocess->fetch();

                if( empty($rs_s_is_nextprocess['s_is_nextprocess']) || $rs_s_is_nextprocess['s_is_nextprocess'] == 0){
                    $qu_header_asal = $db
                        ->raw()
                        ->bind(':id_transaksi_asal_h', $id_transaksi_asal_h)
                        ->exec('
                            UPDATE '.$tbl_name_asal_h.'
                            SET is_nextprocess = null
                            WHERE  1
                                AND id = :id_transaksi_asal_h
                        ');
                }
            }

        }else{
            
        }
    }
    

?>