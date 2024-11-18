<?php
	include_once( "../../../../users/init.php" );
	include( "../../../../usersc/lib/DataTables.php" );
	require '../../../../usersc/vendor/autoload.php';

	// carbon
	use Carbon\Carbon;

	/**
	 * referensi: https://mpdf.github.io/reference/html-control-tags/overview.html
	 * htmlpageheader
	 * htmlpagefooter
	 */

	// get data
	$id_transaksi    = $_GET['id_transaksi'];

	$qs_wrexxth = $db
		->raw()
		->bind(':id_transaksi', $id_transaksi)
		->exec('SELECT DISTINCT
                    b.kode kode_transaksi,
                    b.keterangan,
                    a.wlpxxmh_kode,
                    if(driver = "" OR driver IS NULL, " - ", driver) driver,
                    if(b.plat_nomor = "" OR plat_nomor IS NULL, " - ", plat_nomor) plat_nomor,
                    supplier.nama AS nama_supplier,
                    e.nama AS iwhxxmh_nama,
                    c.nama AS iimxxmh_nama,
                    c.kode AS iimxxmh_kode,
                    d.kode AS iumxxmh_kode,
                    a.jumlah_unit,
                    f.username user_create,
                    IFNULL(g.username, IF(b.transaction_state = 1, "Auto Approve by System", "")) user_approve,
                    b.tanggal
                FROM wreittd a
                LEFT JOIN wrexxth_wreittd slip on slip.id_wreittd = a.id
                LEFT JOIN wrexxth b ON b.id = slip.id_wrexxth
                LEFT JOIN iimxxmh c ON c.id = a.id_iimxxmh
                LEFT JOIN iumxxmh d ON d.id = a.id_iumxxmh_unit
                LEFT JOIN grlxxmh supplier ON supplier.id = a.id_grlxxmh_supplier
                LEFT JOIN iwhxxmh e ON e.id = a.id_iwhxxmh
                LEFT JOIN activity_log_ml f ON f.id_transaksi = b.id AND f.kode = "CREATE" AND f.nama = "wrexxth"
                LEFT JOIN activity_log_ml g ON g.id_transaksi = b.id AND g.kode = "APPROVE" AND g.nama = "wrexxth"
                WHERE b.id = :id_transaksi
		'
		);
	$rs_wrexxth = $qs_wrexxth->fetchAll();

    if (!empty($rs_wrexxth)) {
        $tanggal = new Carbon($rs_wrexxth[0]['tanggal']);
    
        $tbody = '';
        foreach ($rs_wrexxth as $key => $wrexxth) {
            $tbody = $tbody . '<tr>';
            $tbody = $tbody .  '<td class="bls" width="15%">'.$wrexxth['iimxxmh_kode'].'</td>';
            $tbody = $tbody .  '<td class="bls" width="45%">'.$wrexxth['iimxxmh_nama'].'</td>';
            $tbody = $tbody .  '<td class="text-right bls" width="20%">'. number_format($wrexxth['jumlah_unit'],2) .'</td>';
            $tbody = $tbody .  '<td class="bls brs" width="20%">'. $wrexxth['iumxxmh_kode'] .'</td>';
            $tbody = $tbody .  '</tr>';
        }
    
        // generate tampilan
        
        $html = '
        <html>
            <head>
                <style>
                    .header-table {
                        margin-bottom: 40px; /* Jarak bawah untuk tabel header */
                    }
                    .content-table {
                        margin-top: 20px; /* Jarak atas untuk tabel konten */
                    }
                </style>
            </head>
            <body>
    
            <!--mpdf
            <htmlpageheader name="myheader">
                <table width="100%" class="header-table">
                    <tr>
                        <td colspan="12" class="text-center"><h3>Receive Entry</h3></td>
                    </tr>
                    <tr>
                        <td width="10%">Tanggal</td>
                        <td width="1%">:</td>
                        <td width="45%">'.$tanggal->format('d M Y').'</td>
                        <td width="2%"></td>
                        
                        <td width="17%">Supplier</td>
                        <td width="1%">:</td>
                        <td width="">'.$rs_wrexxth[0]['nama_supplier'].'</td>
                    </tr>
                    <tr>
                        <td width="14%">No Transaksi</td>
                        <td width="1%">:</td>
                        <td width="45%">'.$rs_wrexxth[0]['kode_transaksi'].'</td>
                        <td width="2%"></td>
                        
                        <td width="17%">Kendaraan / Supir</td>
                        <td width="1%">:</td>
                        <td width="">'.$rs_wrexxth[0]['plat_nomor'].' / '.$rs_wrexxth[0]['driver'].'</td>
                    </tr>
                    <tr>
                        <td width="14%">Warehouse</td>
                        <td width="1%">:</td>
                        <td width="45%">'.$rs_wrexxth[0]['iwhxxmh_nama'].'</td>
                        <td width="2%"></td>
                    </tr>
                </table>
            </htmlpageheader>
            <htmlpagefooter name="myfooter">
                <table width="100%">
                </table>
                
                <div class="hr-footer">
                    Page {PAGENO} of {nb}
                </div>
            </htmlpagefooter>
            
            <sethtmlpageheader name="myheader" value="on" show-this-page="1" />
            <sethtmlpagefooter name="myfooter" value="on" />
            mpdf-->
    
            <table width="100%" class="content-table">
                <thead>
                    <tr>
                        <td class="text-center font-bold bas">Kode</td>
                        <td class="text-center font-bold bas">Nama</td>
                        <td class="text-center font-bold bas">Quantity</td>
                        <td class="text-center font-bold bas">UOM</td>
                    </tr>
                </thead>
                <tbody>
                    <!-- BEGIN ITEMS HERE -->
                    '.$tbody.'
                    <!-- END ITEMS HERE -->
                </tbody>
                <tfoot>
                    <tr>
                        <td class="bls bbs"></td>
                        <td class="bls bbs"></td>
                        <td class="bls bbs"></td>
                        <td class="bls bbs"></td>
                        <td class="bls"></td>
                    </tr>
                </tfoot>
            </table>
    
            <table width="100%">
            </table>
            <br>
            <br>
            <table width="100%">
                <tr>
                    <td width="15%"></td>
                    <td width="50%">Created By</td>
                    
                    <td width="35%">Approved By</td>
                </tr>
            </table>
            <br>
            <br>
            <br>
            <br>
            <br>
            <table width="100%">
                <tr>
                    <td width="8%" class="text-center"></td>
                    <td width="25%" class="text-center">'.$wrexxth['user_create'].'</td>
                    <td width="20%" class="text-center"></td>
                    
                    <td width="6%" class="text-center"></td>
                    <td width="25%" class="text-center">'.$wrexxth['user_approve'].'</td>
                    <td width="16%" class="text-center"></td>
                </tr>
            </table>
        </body>
    </html>';
    } else {
        
        $html = '
        <html>
            <head>
                <style>
                    .header-table {
                        margin-bottom: 40px; /* Jarak bawah untuk tabel header */
                    }
                    .content-table {
                        margin-top: 20px; /* Jarak atas untuk tabel konten */
                    }
                </style>
            </head>
            <body>
    
            <!--mpdf
            <htmlpageheader name="myheader">
                <h3 class="text-center">Data Receive Entry Tidak Valid</h3>
            </htmlpageheader>
            <htmlpagefooter name="myfooter">
                <table width="100%">
                </table>
                
                <div class="hr-footer">
                    Page {PAGENO} of {nb}
                </div>
            </htmlpagefooter>
            
            <sethtmlpageheader name="myheader" value="on" show-this-page="1" />
            <sethtmlpagefooter name="myfooter" value="on" />
            mpdf-->
        </body>
    </html>';
    }


	$stylesheet = file_get_contents('../../../templates/inspinia-side/assets/css/print_mpdf.css');

	// render ke mpdf
	$mpdf = new \Mpdf\Mpdf([
		'margin_left' => 5,
		'margin_right' => 5,
		'margin_top' => 30, // table ke header
		'margin_bottom' => 5,
		'margin_header' => 5,	// header
		'margin_footer' => 2,	// footer
		'format' => 'A5', // dalam mm | 'A4' | 'A5' 
		
	]);
	$mpdf->AddPage('L');	// L: Landscape
	$mpdf->SetProtection(array('print'));
	$mpdf->SetTitle("Slip");
	$mpdf->SetDisplayMode('fullpage');
	$mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);
	$mpdf->WriteHTML($html);
	$mpdf->Output();
?>