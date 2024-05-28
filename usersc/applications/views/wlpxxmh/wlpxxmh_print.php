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
    if (isset($_GET['ids_wlpxxmh'])) {

        $mpdf = new \Mpdf\Mpdf([
            'margin_left' => 5,
            'margin_right' => 5,
            'margin_top' => 2, // table ke header
            'margin_bottom' => 2,
            'margin_header' => 2,	// header
            'margin_footer' => 2,	// footer
            'format' => [80, 50], // dalam mm | 'A4' | 'A5' 
            
        ]);

        $ids_wlpxxmh = $_GET['ids_wlpxxmh'];
        $idsArray = explode(',', $ids_wlpxxmh);
        
        $qs_wlpxxmh = $db
            ->raw()
            ->exec('
                SELECT
                    kode
                FROM wlpxxmh
                WHERE id IN (' . $ids_wlpxxmh . ')'
            );
        $rs_wlpxxmh = $qs_wlpxxmh->fetchAll();
        
        foreach ($rs_wlpxxmh as $row_wlpxxmh) {

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
                                <td class="text-center"><barcode code="'. $row_wlpxxmh['kode'] .'" disableborder="1" type="qr" size="1.3" class="barcode" /></td>
                            </tr>
                            <tr>
                                <td class="text-center">'. $row_wlpxxmh['kode'] .'</td>
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

        }   // end foreach
    } else {
        echo 'No ids_wlpxxmh parameter found';
    }
	
	$mpdf->Output();
?>