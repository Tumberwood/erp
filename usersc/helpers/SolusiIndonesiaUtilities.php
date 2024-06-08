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
        }

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
        }

    }

    class General {
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
        }
    }    
?>
