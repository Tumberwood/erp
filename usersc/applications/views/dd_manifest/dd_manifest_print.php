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

    $stylesheet = file_get_contents('../../../templates/inspinia-side/assets/css/print_mpdf.css');

	// get data
    if (isset($_GET['id_dd_manifest'])) {

        $mpdf = new \Mpdf\Mpdf([
            'margin_left' => 5,
            'margin_right' => 5,
            'margin_top' => 2, // table ke header
            'margin_bottom' => 2,
            'margin_header' => 2,	// header
            'margin_footer' => 2,	// footer
            'format' => [100, 150], // dalam mm | 'A4' | 'A5' 
            
        ]);

        $id_dd_manifest = $_GET['id_dd_manifest'];
        
        $qs_dd_manifest = $db
            ->raw()
            ->bind(':id_dd_manifest', $id_dd_manifest)
            ->exec('SELECT * FROM dd_manifest WHERE id = :id_dd_manifest');
        
        $rs_dd_manifest = $qs_dd_manifest->fetch();

        // generate tampilan
        $html = '
        <html>
            <head>
                <style>
                    .barcode {
                        padding: 1.5mm;
                        margin: 0;
                        vertical-align: top;
                        color: #000000;
                    }
                </style>
            </head>
            <body>
                <table width="100%">
                    <tbody>
                        <tr>
                            <td class="text-center" colspan=3>LOGO </td>
                        </tr>
                        <tr>
                            <td>CODE BOX</td>
                            <td>:</td>
                            <td>'. $rs_dd_manifest['kode'] .'</td>
                        </tr>
                        <tr>
                            <td>NAMA PENGIRIM</td>
                            <td>:</td>
                            <td>'. $rs_dd_manifest['nama_pengirim'] .'</td>
                        </tr>
                        <tr>
                            <td>ALAMAT PENGIRIM</td>
                            <td>:</td>
                            <td>'. $rs_dd_manifest['alamat_pengirim'] .'</td>
                        </tr>
                        <tr>
                            <td>TELEPON PENGIRIM</td>
                            <td>:</td>
                            <td>'. $rs_dd_manifest['telepon_pengirim'] .'</td>
                        </tr>
                        <tr>
                            <td>PASSPORT PENGIRIM</td>
                            <td>:</td>
                            <td>'. $rs_dd_manifest['passport_pengirim'] .'</td>
                        </tr>
                        <tr>
                            <td>STATUS PMI</td>
                            <td>:</td>
                            <td>'. $rs_dd_manifest['status_pmi'] .'</td>
                        </tr>
                        <tr>
                            <td>NAMA PENERIMA</td>
                            <td>:</td>
                            <td>'. $rs_dd_manifest['nama_penerima'] .'</td>
                        </tr>
                        <tr>
                            <td>ALAMAT PENERIMA</td>
                            <td>:</td>
                            <td>'. $rs_dd_manifest['alamat_penerima'] .'</td>
                        </tr>
                        <tr>
                            <td>KOLI KE</td>
                            <td>:</td>
                            <td>'. $rs_dd_manifest['koli_ke'] .'</td>
                        </tr>
                        <tr>
                            <td>UKURAN</td>
                            <td>:</td>
                            <td>'. $rs_dd_manifest['ukuran'] .'</td>
                        </tr>
                        <tr>
                            <td>BERAT</td>
                            <td>:</td>
                            <td>'. $rs_dd_manifest['berat'] .'</td>
                        </tr>
                        <tr>
                            <td>URAIAN BARANG</td>
                            <td>:</td>
                            <td>'. $rs_dd_manifest['uraian_barang'] .'</td>
                        </tr>
                        <tr>
                            <td colspan=3 class="text-center"><barcode code="'. $rs_dd_manifest['kode'] .'" disableborder="1" type="CODABAR" size="1.3" class="barcode" /></td>
                        </tr>
                    </tbody>
                </table>
            </body>
        </html>';            

            $mpdf->AddPage();
            $mpdf->SetProtection(array('print'));
            $mpdf->SetDisplayMode('fullpage');
            $mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);
            $mpdf->WriteHTML($html);

        
    } else {
        echo 'No id_dd_manifest parameter found';
    }
	
	$mpdf->Output();
?>