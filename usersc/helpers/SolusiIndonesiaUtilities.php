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
                ->set('jumlah_default_os',$jumlah_default) 
                ->where('id',$id)
                ->exec();
        }

        /**
         * konversiUom2
         * Sama seperti konversiUom, hanya tidak meng-update field terkait jumlah_unit
         */
        public static function konversiUom2( $db, $nama_table, $id) {
            
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
                ->set('jumlah_terkecil_os',$jumlah_terkecil)                 
                ->where('id',$id)
                ->exec();
        }

        /**
         * Digunakan untuk menghitung konversi ke UoM Beli
         * Saat ini hanya digunakan di prc
         */
        public static function konversiBuy($db, $nama_table, $id){
            $qs_transaksi = $db
                ->query('select', $nama_table )
                ->get([
                    'id_iimxxmh as id_iimxxmh',
                    'id_iumxxmh_unit as id_iumxxmh_unit',
                    'jumlah_unit as jumlah_unit',
                    'harga_unit as harga_unit',
                    'diskon_jenis as diskon_jenis',
                    'diskon_persen as diskon_persen',
                    'diskon_value as diskon_value'
                ] )
                ->where('id', $id )
                ->exec();
            $rs_transaksi = $qs_transaksi->fetch();

            $id_iimxxmh      = $rs_transaksi['id_iimxxmh'];
            $id_iumxxmh_unit = $rs_transaksi['id_iumxxmh_unit'];
            $jumlah_unit     = $rs_transaksi['jumlah_unit'];
            $harga_unit      = $rs_transaksi['harga_unit'];
            $diskon_jenis    = $rs_transaksi['diskon_jenis'];
            $diskon_persen   = $rs_transaksi['diskon_persen'];
            $diskon_value    = $rs_transaksi['diskon_value'];

            // BEGIN get jumlah_konversi_unit_terkecil
            $qs_jumlah_konversi_unit_terkecil = $db
                ->query('select', 'iimummd')
                ->get('jumlah_konversi')
                ->where('id_iimxxmh',$id_iimxxmh)
                ->where('id_iumxxmh',$id_iumxxmh_unit)
                ->exec();
            $rs_jumlah_konversi_unit_terkecil = $qs_jumlah_konversi_unit_terkecil->fetch();

            $jumlah_konversi_unit_terkecil    = $rs_jumlah_konversi_unit_terkecil['jumlah_konversi'];
            $jumlah_terkecil    = $jumlah_konversi_unit_terkecil * $jumlah_unit;
            // END get jumlah_konversi_unit_terkecil

            // BEGIN get jumlah_konversi_buy_terkecil
            $qs_jumlah_konversi_buy_terkecil = $db
                ->query('select', 'iimummd' )
                ->get([
                    'iimummd.jumlah_konversi as jumlah_konversi_beli_terkecil',
                    'iimummd.id_iumxxmh as id_iumxxmh_beli'
                ] )
                ->where('id_iimxxmh',$id_iimxxmh)
                ->where('is_iumxxmh_beli', 1)
                ->exec();
            $rs_jumlah_konversi_buy_terkecil = $qs_jumlah_konversi_buy_terkecil->fetch();
            if(!empty($rs_jumlah_konversi_buy_terkecil)){
                // jika uom beli didefinisikan
                $jumlah_konversi_beli_terkecil   = $rs_jumlah_konversi_buy_terkecil['jumlah_konversi_beli_terkecil'];
                $jumlah_buy = $jumlah_unit * $jumlah_konversi_unit_terkecil / $jumlah_konversi_beli_terkecil;
            }else{
                // jika uom beli tidak didefinisikan, maka menggunakan jumlah_unit
                $jumlah_buy = $jumlah_unit;
            }

            $subtotal   = $harga_unit * $jumlah_buy;
            if($diskon_jenis == 'persen'){
                $diskon_final = $diskon_persen / 100 * $subtotal;
            }else{
                $diskon_final = $diskon_value;
            }
            $dpp = $subtotal - $diskon_final;
            // END get jumlah_konversi_buy_terkecil

            // update transaksi
            $qu_transaksi = $db
                ->query('update', $nama_table)
                ->set('subtotal',$subtotal)
                ->set('diskon_final',$diskon_final)
                ->set('dpp',$dpp)
                ->where('id',$id)
                ->exec();

            $results = array(
                "jumlah_buy" => $jumlah_buy,
                "diskon_final" => $diskon_final,
                "dpp" => $dpp
            );
        }
        
        /**
         * Digunakan untuk update nilai field terkait jumlah pada transaksi sebelumnya
         * Misal saat melakukan Goods Receipt, akan meng-update field terkait jumlah pada Purchase Order
         * Function ini dipanggil di extra, postCreate, postEdit, preRemove
         * Terminology
	     *  old		: data sebelum di create atau di edit 
	     *  before	: transaksi sebelumnya
         * Parameter:
         *  @param Object   $db database connection, biasanya diisi $editor->db()
         *  @param Number   $id_table id table transaksi
         *  @param Object   $dt_values : diisi $values dari form datatables editor
         *  @param String   $action CREATE | EDIT | DELETE | CONFIRM | APPROVE | GENERATE
         *  @param String   $nama_table nama tabel database transaksi
         *  @param String   $nama_table_before nama tabel database transaksi sebelumnya
         */
        public static function kalkulasiJumlahTransaksiBefore( $db, $id_table, $dt_values, $action, $nama_table, $nama_table_before ){

            // BEGIN get iimummd_default
            $qs_iimummd_default = $db
                ->query('select', 'iimummd' )
                ->get([
                    'iimummd.jumlah_konversi as jumlah_konversi_default_ke_terkecil',
                    'iumxxmh.kode as iumxxmh_default_kode'
                ] )
                ->join('iumxxmh','iumxxmh.id = iimummd.id_iumxxmh','LEFT' )
                ->where('iimummd.id_iimxxmh', $dt_values[$nama_table]['id_iimxxmh'] )
                ->where('iimummd.is_default', 1 )
                ->exec();
            // END get iimummd_default
            $rs_iimummd_default                  = $qs_iimummd_default->fetch();
            $jumlah_konversi_default_ke_terkecil = $rs_iimummd_default['jumlah_konversi_default_ke_terkecil'];

            // ambil nilai jumlah konversi berdasarkan id_iimxxmh dan id_iumxxmh
            $qs_iimummd_terkecil = $db
                ->query('select', 'iimummd' )
                ->get([
                    'iimummd.jumlah_konversi as jumlah_konversi_terkecil'
                ] )
                ->where('iimummd.id_iimxxmh', $dt_values[$nama_table]['id_iimxxmh'] )
                ->where('iimummd.id_iumxxmh', $dt_values[$nama_table]['id_iumxxmh_unit'] )
                ->exec();
            $rs_iimummd_terkecil = $qs_iimummd_terkecil->fetch();
            $jumlah_konversi_terkecil = $rs_iimummd_terkecil['jumlah_konversi_terkecil'];
            
            $qs_table_before_old = $db
                ->query('select', $nama_table_before )
                ->get([
                    $nama_table_before.'.jumlah_unit as jumlah_unit_old',
                    $nama_table_before.'.jumlah_unit_next as jumlah_unit_next_old',
                    $nama_table_before.'.jumlah_unit_os as jumlah_unit_os_old',
                    $nama_table_before.'.jumlah_terkecil as jumlah_terkecil_old',
                    $nama_table_before.'.jumlah_terkecil_next as jumlah_terkecil_next_old',
                    $nama_table_before.'.jumlah_terkecil_os as jumlah_terkecil_os_old'
                ] )
                ->where($nama_table_before.'.id', $dt_values[$nama_table]['id_'.$nama_table_before] )
                ->exec();
            $rs_table_before_old = $qs_table_before_old->fetch();
            
            if($action == 'Create'){
                $jumlah_unit_old = 0;
            }elseif($action == 'Edit'){
                $qs_table_old = $db
                    ->query('select', $nama_table )
                    ->get([
                        $nama_table.'.jumlah_unit as jumlah_unit'
                    ] )
                    ->where($nama_table.'.id', $id_table )
                    ->exec();
                $rs_table_old = $qs_table_old->fetch();
                $jumlah_unit_old = $rs_table_old['jumlah_unit'];
            }elseif($action == 'Remove'){
                $jumlah_unit_old = 0;
            }
    
            $jumlah_unit_next_new     = $rs_table_before_old['jumlah_unit_next_old'] - $jumlah_unit_old + $dt_values[$nama_table]['jumlah_unit'];
            $jumlah_unit_os_new       = $rs_table_before_old['jumlah_unit_old'] - $jumlah_unit_next_new;
            
            $jumlah_terkecil_next_new = $jumlah_unit_next_new * $jumlah_konversi_terkecil;
            $jumlah_terkecil_os_new   = $jumlah_unit_os_new * $jumlah_konversi_terkecil;

            $jumlah_default_next_new = $jumlah_terkecil_next_new / $jumlah_konversi_default_ke_terkecil;
            $jumlah_default_os_new   = $jumlah_terkecil_os_new / $jumlah_konversi_default_ke_terkecil;
    
            $qu_table_before = $db
                ->query('update', $nama_table_before)
                ->set('jumlah_unit_next', $jumlah_unit_next_new )
                ->set('jumlah_unit_os', $jumlah_unit_os_new)
                ->set('jumlah_terkecil_next', $jumlah_terkecil_next_new)
                ->set('jumlah_terkecil_os', $jumlah_terkecil_os_new)
                ->set('jumlah_default_next', $jumlah_default_next_new)
                ->set('jumlah_default_os', $jumlah_default_os_new)
                ->where('id', $dt_values[$nama_table]['id_'.$nama_table_before] )
                ->exec();
        }

        public static function kalkulasiJumlahTransaksiBefore2( $db, $id_table, $dt_values, $action, $nama_table, $nama_table_before ){

            // ambil nilai jumlah konversi berdasarkan id_iimxxmh dan id_iumxxmh
            $qs_iimummd_terkecil = $db
                ->query('select', 'iimummd' )
                ->get([
                    'iimummd.jumlah_konversi as jumlah_konversi_terkecil'
                ] )
                ->where('iimummd.id_iimxxmh', $dt_values[$nama_table]['id_iimxxmh'] )
                ->where('iimummd.id_iumxxmh', $dt_values[$nama_table]['id_iumxxmh_unit'] )
                ->exec();
            $rs_iimummd_terkecil = $qs_iimummd_terkecil->fetch();
            $jumlah_konversi_terkecil = $rs_iimummd_terkecil['jumlah_konversi_terkecil'];
            $jumlah_terkecil_new = $dt_values[$nama_table]['jumlah_unit'] * $jumlah_konversi_terkecil;
                        
            $qs_table_before_old = $db
                ->raw()
                ->bind(':id_table_before', $dt_values[$nama_table]['id_'.$nama_table_before])
                ->exec('SELECT ' . 
                        $nama_table_before.'.jumlah_unit as jumlah_unit_old,'.
                        $nama_table_before.'.jumlah_terkecil as jumlah_terkecil_old,'.
                        $nama_table_before.'.jumlah_terkecil_next as jumlah_terkecil_next_old,'.
                        $nama_table_before.'.jumlah_terkecil_os as jumlah_terkecil_os_old 
                    FROM '.$nama_table_before .'
                    WHERE 1
                        AND '.$nama_table_before.'.id = :id_table_before
                ');
            $rs_table_before_old = $qs_table_before_old->fetch();
            
            /**
             * ambil data sebelum create atau edit
             * jika action == 'create', maka $jumlah_terkecil__old = 0
             * jika action == 'edit', maka $jumlah_terkecil__old di select dari table saat preEdit
             */
            // 
            if($action == 'Create'){
                $jumlah_terkecil_old = 0;
            }elseif($action == 'Edit'){
                $qs_table_old = $db
                    ->raw()
                    ->bind(':id_table', $id_table)
                    ->exec('SELECT
                            id_iumxxmh_unit,
                            jumlah_unit,
                            jumlah_terkecil
                        FROM '.$nama_table.' 
                        LEFT JOIN iimummd ON iimummd.id_iumxxmh = ' . $nama_table.'.id_iumxxmh_unit AND iimummd.id_iimxxmh = ' . $nama_table.'.id_iimxxmh
                        WHERE 1
                            AND ' . $nama_table . '.id = :id_table
                    ');
                
                $rs_table_old = $qs_table_old->fetch();
                $id_iumxxmh_unit_old = $rs_table_old['id_iumxxmh_unit'];
                $jumlah_terkecil_old = $rs_table_old['jumlah_terkecil'];
            }elseif($action == 'Remove'){
                $jumlah_terkecil_old = 0;
            }

            // hasil perhitungan untuk di update ke table before
            $jumlah_terkecil_next_new = $rs_table_before_old['jumlah_terkecil_next_old'] - $jumlah_terkecil_old + $jumlah_terkecil_new;
            $jumlah_terkecil_os_new = $rs_table_before_old['jumlah_terkecil_old'] - $jumlah_terkecil_next_new;
    
            $qu_table_before = $db
                ->query('update', $nama_table_before)
                ->set('jumlah_terkecil_next', $jumlah_terkecil_next_new)
                ->set('jumlah_terkecil_os', $jumlah_terkecil_os_new)
                ->where('id', $dt_values[$nama_table]['id_'.$nama_table_before] )
                ->exec();
            
            $results = array(
                "jumlah_konversi_terkecil" => $jumlah_konversi_terkecil,
                "jumlah_terkecil_new" => $jumlah_terkecil_new,
                "rs_table_before_old" => $rs_table_before_old,
                "jumlah_terkecil_old" => $jumlah_terkecil_old,
                "jumlah_terkecil_next_new" => $jumlah_terkecil_next_new,
                "jumlah_terkecil_os_new" => $jumlah_terkecil_os_new
            );
            // print_r($results); 
        }

        /**
         * Digunakan untuk mendapatkan nilai field terkait harga pada transaksi sebelumnya, dan di update ke tabel transaksi seteelahnya
         */
        public static function getHeaderHargaBefore( $db, $id_table, $nama_table_h, $nama_table_h_before ){
            
            $qu_harga_header = $db
                ->raw()
                ->bind(':id_table', $id_table)
                ->exec('UPDATE '.$nama_table_h.' a
                    LEFT JOIN '.$nama_table_h_before.' b ON b.id = a.id_'.$nama_table_h_before.'
                    SET
                        a.diskon_jenis = b.diskon_jenis,
                        a.diskon_value = b.diskon_value,
                        a.diskon_persen = b.diskon_persen,
                        a.is_pajak = b.is_pajak,
                        a.pajak_jenis = b.pajak_jenis,
                        a.pajak_in_ex = b.pajak_in_ex,
                        a.pajak_persen = b.pajak_persen
                    WHERE
                        a.id = :id_table');
        }


        //---------------------------------------------------------- TO DO

        /**
         * Digunakan untuk menghitung nilai HPP berdasarkan metode average
         * Function ini dipanggil di file _jv atau file model lain yang memperlukan perhitungan HPP
         * Parameter
         *  @param Number   $id_iimxxmh 
         */
        public static function hitungHPPAverage( $db, $id_iimxxmh ){
            // TODO
        }
        
    } // end of class General
?>
