<?php
    namespace SolusiIndonesia\Utilities;

    use
		DataTables\Editor,
		DataTables\Editor\Query,
		DataTables\Editor\Result;

    class Converter {
        /**
         * Digunakan untuk konversi dari text ke number
         * Contoh: 
         *  A menjadi 1, AA menjadi 27, dan seterusnya
         *  01 menjadi 1, 001 menjadi 1, dan seterusnya
         * Parameter:
         *  @param String $input Text yang akan di konversi
         */
        public static function convertAllToNumber($input) {
            if (preg_match('/^\d+$/', $input)) {
                $number = intval($input);
            } elseif (preg_match('/^[A-Z]+$/', $input)) {
                $input = strtoupper($input);
                $length = strlen($input);
                $number = 0;
            
                for ($i = 0; $i < $length; $i++) {
                    $number = $number * 26 + (ord($input[$i]) - ord('A') + 1);
                }
            } else {
                $number = 0;
            }

            return $number;
        } // end of function convertAllToNumber

        /**
         * Digunakan untuk memecah sekumpulan text menjadi single text, dipisahkan berdasarkan koma (,)
         * Contoh: 
         *  A-D menjadi A, B, C, D
         * Parameter:
         *  @param String $input Text yang akan di ekstrak
         */
        public static function extractText($input) {
            // Pisahkan berdasarkan koma
            $parts = explode(',', $input);
            $result = [];

            foreach ($parts as $part) {
                // Trim setiap bagian untuk menghilangkan spasi ekstra
                $part = trim($part);
        
                if (preg_match('/^(\d+)-(\d+)$/', $part, $matches)) {
                    // Jika bagian ini adalah rentang angka (misal, 01-10)
                    $start = intval($matches[1]);
                    $end = intval($matches[2]);
                    for ($i = $start; $i <= $end; $i++) {
                        // Tambahkan kembali prefiks nol jika ada
                        $result[] = str_pad($i, strlen($matches[1]), '0', STR_PAD_LEFT);
                    }
                } elseif (preg_match('/^([A-Za-z])\s*-\s*([A-Za-z])$/', $part, $matches)) {
                    // Jika bagian ini adalah rentang huruf (misal, P-S atau H - K)
                    $start = ord($matches[1]);
                    $end = ord($matches[2]);
                    for ($i = $start; $i <= $end; $i++) {
                        $result[] = chr($i);
                    }
                } else {
                    // Jika bagian ini adalah nilai tunggal
                    $result[] = $part;
                }
            }

            return $result;
        } // end of function extractText

    } // end of class Converter

    class General {
        /**
         * logChange
         * Digunakan untuk insert data log ke table activity_log_ml
         * Function ini dipanggil dari helpers/edt_log.php
         * Parameter:
         * @param Object    $db database connection, biasanya diisi $editor->db()
         * @param String    $nama_table nama tabel database yang akan dicatatakan log nya
         * @param Number    $s_id_users didapat otomatis dari file helpers/hakakses_s_fn.php
         * @param String    $s_username didapat otomatis dari file helpers/hakakses_s_fn.php
         * @param String    $action CREATE | EDIT | DELETE | CONFIRM | APPROVE | GENERATE
         * @param Number    $id id transaksi yang akan dicatatkan log nya
         * @param String    $values data atau catatan terkait log
         * @param Datetime  $start_at date time awal data
         * @param Datetime  $finish_at date time akhir data
         * 
         */
        public static function logChange ( $db, $nama_table, $s_id_users, $s_username, $action, $id, $values, $start_at, $finish_at )  {
            $start_at     = date('Y-m-d H:i:s', strtotime($start_at));
            $finish_at    = date('Y-m-d H:i:s', strtotime($finish_at));
            $durasi_detik = strtotime($finish_at) - strtotime($start_at);
    
            $db->insert( 'activity_log_ml', array(
                'id_transaksi' 	=> $id,
                'kode' 			=> $action,
                'nama' 			=> $nama_table,
                'keterangan' 	=> json_encode($values, JSON_UNESCAPED_SLASHES),
                'created_by'   	=> $s_id_users,
                'username'   	=> $s_username,
                'start_on'   	=> $start_at,
                'finish_on'   	=> $finish_at,
                'durasi_detik'  => $durasi_detik
            ) );

            return $durasi_detik;
        } // end function logChange

        /**
         * isNextProcess
         * Digunakan untuk melakukan pengecekan apakah sebuah data atau transaksi sudah ditarik ke proses selanjutnya.
         * Ini hanya memberikan flag is_nexprocess = 1 pada table database. Default: null
         * Term:
         *  asal    : table yang akan dicek apakah sudah ditarik atau belum ke proses selanjutnya
         *  tujuan  : table next proses yang menggunakan data atau transaksi tersebut
         * Function ini dipanggil pada file model _extra, pada event postCreate, postEdit, dan preRemove
         * Parameter:
         *  @param Object   $db database connection, biasanya diisi $editor->db()
         *  @param String   $tbl_name_asal_h nama tabel asal pada database
         *  @param String   $tbl_name_asal_d nama tabel asal pada database
         *  @param String   $tbl_name_tujuan_d nama tabel tujuan pada database
         *  @param String   $id_transaksi_tujuan_d, biasanya diisi $id
         *  @param String   $action : CREATE | EDIT | REMOVE
         *  @param Object   $dt_values : diisi $values dari form datatables editor
         * 
         */

         public static function isNextProcess( $db, $tbl_name_asal_h, $tbl_name_asal_d, $tbl_name_tujuan_d, $id_transaksi_tujuan_d, $action, $dt_values ) {

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
                    // ini harus diubah. harus ada cek lagi selain di transaksi ini apakah dipakai di transaksi lain
                    // jika memang sudah tidak ada, baru dijadikan null
                    // $qu_detail_asal_before = $db
                    //     ->raw()
                    //     ->bind(':id_transaksi_asal_d', $id_transaksi_asal_d_before)
                    //     ->exec('
                    //         UPDATE '.$tbl_name_asal_d.'
                    //         SET is_nextprocess = null
                    //         WHERE  1
                    //             AND id = :id_transaksi_asal_d
                    //     ');
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
        } // end of function isNextProcess

        /**
         * Digunakan untuk menghitung konversi UoM
         * Function ini dipanggil di extra, postCreate, postEdit
         * Parameter:
         *  @param Object   $db database connection, biasanya diisi $editor->db()
         *  @param String   $nama_table nama tabel database yang akan dihitung konversinya
         *  @param Number   $id id transaksi yang akan dihitung konversinya
         
         */
        public static function konversiUom( $db, $nama_table, $id) {
            
            $qs_transaksi = $db
                ->query('select', $nama_table )
                ->get([
                    'id_iimxxmh as id_iimxxmh',
                    'id_iumxxmh_unit as id_iumxxmh_unit',
                    'jumlah_unit as jumlah_unit'
                ] )
                ->where('id', $id )
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
            //ini dibuat round, karena terkecil itu harusnya tidak perlu koma, ada case jumlah terkecil koma
            //seperti 0,63 box, 1 box = 24 pcs, hasil hitung jumlah terkecil jadi 15,12. Harusnya 15 saja
            $jumlah_terkecil    = round($jumlah_konversi * $jumlah_unit); //1 * 30
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

            $id_iumxxmh_terkecil = $rs_iumxxmh_terkecil['id_iumxxmh_terkecil']; //pcs
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
                ->query('update', $nama_table)
                ->set('id_iumxxmh_terkecil',$id_iumxxmh_terkecil)
                ->set('id_iumxxmh_default',$id_iumxxmh_default)
                ->set('jumlah_konversi',$jumlah_konversi)
                ->set('jumlah_terkecil',$jumlah_terkecil) 
                ->set('jumlah_default',$jumlah_default) 
                ->set('jumlah_unit_os',$jumlah_unit) 
                ->set('jumlah_terkecil_os',$jumlah_terkecil) 
                ->where('id',$id)
                ->exec();
        }
        
    } // end of class General
?>
