<?php

    // function isNextProcess( $db, $tbl_name_h, $tbl_name_d, $id_transaksi_d, $action )  {
    function isNextProcess( $db, $tbl_name_asal_h, $tbl_name_asal_d, $tbl_name_tujuan_d, $id_transaksi_tujuan_d, $action ){

        if($action == 'REMOVE'){

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

        }else{
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
        }
            
        
    
    }
    

?>