<?php
    require_once( "../../users/init.php" );
	require_once( "../../usersc/lib/DataTables.php" );
    include_once( "../../usersc/vendor/autoload.php");
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

    header('Content-Type: application/json');

    $qs_api_key = $db
        ->query('select', 'ggsxxsh' )
        ->get(['gemini_api_key'] )
        ->where('id', 1 )
        ->exec();
    $rs_api_key = $qs_api_key->fetch();

    $apiKey = $rs_api_key['gemini_api_key'];
    $userMessage = $_POST['message'] ?? '';

    if (!$userMessage) {
        echo json_encode([
            "data" => [
                "reply" => "Pesan kosong, silakan coba lagi."
            ]
        ]);
        exit;
    }

    $prompt = '';
    $prompt_sql = '
    Jawab dengan SQL query saja. 
    Hanya satu kolom hasil yang ditampilkan di SELECT, dan kolom itu WAJIB memakai alias AS nilai. 
    Tabel hemxxmh (pegawai): id, kode (sebagai NIP), nama, kode_finger. '
    ;
    $prompt_sql_lanjutan = 'Gunakan fungsi SQL standar seperti YEAR(tanggal) atau MONTH(tanggal), bukan strftime. ';
    
    if (stripos($userMessage, 'lembur') !== false && stripos($userMessage, 'pegawai') !== false) {
        $prompt .= $prompt_sql;
        $prompt .= $prompt_sql_lanjutan;
        $prompt .= "Contoh lain: SELECT SUM(durasi_lembur_jam) AS nilai FROM htoxxrd ... ";
        $prompt .= "Tabel htoxxrd (lembur): id_hemxxmh, tanggal, durasi_lembur_jam. ";
        
    } else if ((stripos($userMessage, 'potongan makan') !== false || stripos($userMessage, 'pot makan') !== false) && stripos($userMessage, 'pegawai') !== false) {
        $prompt .= $prompt_sql;
        $prompt .= $prompt_sql_lanjutan;
        $prompt .= "Contoh: SELECT SUM(is_makan) AS nilai FROM htsprrd ... ";
        $prompt .= "Tabel htsprrd (potongan makan): id_hemxxmh, tanggal, is_makan. JOIN hemxxmh ON hemxxmh.id = htsprrd.id_hemxxmh.";
        $prompt .= "Filter dengan hemxxmh.kode = '[NIP]' dan htsprrd.is_makan > 0. ";
    } else if (stripos($userMessage, 'pegawai') !== false) {
        $prompt .= $prompt_sql;
        $prompt .= "Contoh: SELECT tanggal_masuk AS nilai FROM hemjbmh ... ";
        $prompt .= "Tabel hemjbmh (job): id_hemxxmh, id_hesxxmh, id_hetxxmh, id_hosxxmh, id_hodxxmh, tanggal_masuk, tanggal_keluar. ";
        
        if (stripos($userMessage, 'status') !== false) {
            $prompt .= "Tabel hesxxmh (status): id, nama. Join ke hemjbmh.id_hesxxmh untuk ambil hesxxmh.nama as nilai, where hemxxmh.kode = nip  ";
        }

        if (stripos($userMessage, 'depar') !== false) {
            $prompt .= "Tabel hodxxmh (department): id, nama. Join ke hemjbmh.id_hodxxmh untuk ambil hodxxmh.nama as nilai, where hemxxmh.kode = nip  ";
        }

        if (stripos($userMessage, 'jabatan') !== false) {
            $prompt .= "Tabel hetxxmh (jabatan): id, nama. Join ke hemjbmh.id_hetxxmh untuk ambil hetxxmh.nama as nilai. where hemxxmh.kode = nip  ";
        }
        
        if (stripos($userMessage, 'section') !== false) {
            $prompt .= "Tabel hosxxmh (section): id, nama. Join ke hemjbmh.id_hosxxmh untuk ambil hosxxmh.nama as nilai, where hemxxmh.kode = nip  ";
        }
        
        if (stripos($userMessage, 'area') !== false) {
            $prompt .= "Tabel holxxmd_2 (area): id, nama. Join ke hemjbmh.id_holxxmd_2 untuk ambil holxxmd_2.nama as nilai, where hemxxmh.kode = nip  ";
        }
        
        if (stripos($userMessage, 'tipe') !== false) {
            $prompt .= "Tabel heyxxmh (tipe): id, nama. Join ke hemjbmh.id_heyxxmh untuk ambil heyxxmh.nama as nilai, where hemxxmh.kode = nip  ";
        }
        
        if (stripos($userMessage, 'sub tipe') !== false) {
            $prompt .= "Tabel heyxxmd (sub tipe): id, nama. Join ke hemjbmh.id_heyxxmd untuk ambil heyxxmd.nama as nilai, where hemxxmh.kode = nip ";
        }
        
        if (stripos($userMessage, 'level') !== false) {
            $prompt .= "Tabel hevxxmh (level): id, nama. Join ke hemjbmh.id_hevxxmh untuk ambil hevxxmh.nama as nilai, where hemxxmh.kode = nip ";
        }
        
        if (stripos($userMessage, 'ptkp') !== false) {
            $prompt .= "Join ke table hemdcmh.id_hemxxmh ON hemxxmh.id, lalu join ke gtxpkmh.id ON hemdcmh.id_gtxpkmh";
            $prompt .= "Tabel gtxpkmh (ptkp): id, kode. Join ke hemdcmh.id_gtxpkmh untuk ambil ptkp, where hemxxmh.kode = nip ";
        }
        
        if (stripos($userMessage, 'ktp') !== false) {
            $prompt .= "Join ke table hemdcmh.id_hemxxmh ON hemxxmh.id, ambil ktp_no, where hemxxmh.kode = nip ";
        }
        
        if (stripos($userMessage, 'tanggal') !== false) {
            $prompt .= "Format tanggal harus seperti DATE_FORMAT(tanggal, 'd% b% %Y') as nilai";
        }

        $prompt .= "Jika user meminta lebih dari satu kolom (contoh: nama dan tanggal), gabungkan dengan CONCAT dan tampilkan sebagai alias AS nilai. ";
        $prompt .= "Contoh: SELECT CONCAT(h.nama, ' - ', j.tanggal_masuk) AS nilai FROM ... ";
        $prompt .= "SELECT harus dari hemxxmh h sebagai tabel utama, JOIN ke tabel lain jika perlu. ";
        
        // Finger
        if (stripos($userMessage, 'finger') !== false) {
            $prompt .= "Jika user menyebut 'kode finger pegawai [NIP]', maka ambil kode_finger dari hemxxmh WHERE kode = '[NIP]'. ";
            $prompt .= "Jangan cari berdasarkan kode_finger, kecuali user menyebut 'pegawai dengan kode finger [kode_finger]'. ";
        }
        
    }

    //Gemini AI
    $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=$apiKey";

    $payload = json_encode([
        "contents" => [
            [
                "parts" => [
                    ["text" => $prompt . $userMessage]
                ]
            ]
        ]
    ]);

    $options = [
        "http" => [
            "method" => "POST",
            "header" => "Content-Type: application/json",
            "content" => $payload,
            "ignore_errors" => true
        ]
    ];

    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    if ($result === FALSE) {
        echo json_encode([
            "data" => [
                "reply" => "Gagal menghubungi Google Gemini API."
            ]
        ]);
        exit;
    }

    $response = json_decode($result, true);

    $reply_ai = $response['candidates'][0]['content']['parts'][0]['text'] ?? "Gagal membaca balasan dari Gemini API.";
    // ini buat hapus ```sql
    $cleanReply = preg_replace('/```(?:sql)?\s*|\s*```/', '', $reply_ai);
    
    //kalau ada prompt, artinya ini berkaitan dengan query HRIS PMI
    if ($prompt != '') {
        $qs_prompt = $db
            ->raw()    
            ->exec($cleanReply);
        $rs_prompt = $qs_prompt->fetch();
        if (!empty($rs_prompt)) {
            if (is_null($rs_prompt['nilai'])) {
                $reply = "Data Tidak Ditemukan!";
            } else {
                $reply = $rs_prompt['nilai'];
            }
            
        } else {
            $reply = "Data Tidak Valid!";
            // $reply = $cleanReply;
            
        }
    } else {
        //else, maka tanya random bisa dijawab sama Gemini AI
        $reply = $cleanReply;
    }

    // $reply = $cleanReply;

    echo json_encode([
        "data" => [
            "reply" => $reply
        ]
    ]);
?>