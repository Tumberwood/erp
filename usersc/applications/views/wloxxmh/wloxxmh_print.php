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
    if (isset($_GET['ids_wloxxmh'])) {

        $mpdf = new \Mpdf\Mpdf([
            'margin_left' => 5,
            'margin_right' => 5,
            'margin_top' => 2, // table ke header
            'margin_bottom' => 2,
            'margin_header' => 2,	// header
            'margin_footer' => 2,	// footer
            'format' => [80, 50], // dalam mm | 'A4' | 'A5' 
            
        ]);

        $ids_wloxxmh = $_GET['ids_wloxxmh'];
        $idsArray = explode(',', $ids_wloxxmh);
        
        $qs_wloxxmh = $db
            ->raw()
            ->exec('
                SELECT
                    nama
                FROM wloxxmh
                WHERE id IN (' . $ids_wloxxmh . ')'
            );
        $rs_wloxxmh = $qs_wloxxmh->fetchAll();
        
        foreach ($rs_wloxxmh as $row_wloxxmh) {

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
                                <td class="text-center"><barcode code="'. $row_wloxxmh['nama'] .'" disableborder="1" type="qr" size="1.3" class="barcode" /></td>
                            </tr>
                            <tr>
                                <td class="text-center">
                                    '. str_replace(' ', '<br>', htmlspecialchars($row_wloxxmh['nama'])) .'
                                </td>
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
        echo 'No ids_wloxxmh parameter found';
    }
	
	$mpdf->Output();
?>