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

	$qs_wdnxxth = $db
		->raw()
		->bind(':id_transaksi', $id_transaksi)
		->exec('SELECT
					b.kode kode_transaksi,
					b.id_grlxxmh_expedition,
					b.keterangan,
					b.supir_nama,
					b.mobil_nomor,
					cust.nama AS nama_customer,
					expedisi.nama AS nama_expedisi,
					c.nama AS iimxxmh_nama,
					c.kode AS iimxxmh_kode,
					d.kode AS iumxxmh_kode,
					a.jumlah_unit,
					b.tanggal
				FROM wdnittd a
				LEFT JOIN wdnxxth b ON b.id = a.id_wdnxxth
				LEFT JOIN iimxxmh c ON c.id = a.id_iimxxmh
				LEFT JOIN iumxxmh d ON d.id = a.id_iumxxmh_unit
				LEFT JOIN grlxxmh expedisi ON expedisi.id = b.id_grlxxmh_expedition
				LEFT JOIN grlxxmh cust ON cust.id = b.id_grlxxmh_customer
				WHERE b.id = :id_transaksi
		'
		);
	$rs_wdnxxth = $qs_wdnxxth->fetchAll();
	$tanggal = new Carbon($rs_wdnxxth[0]['tanggal']);

	$tbody = '';
	foreach ($rs_wdnxxth as $key => $wdnxxth) {
		$tbody = $tbody . '<tr>';
		$tbody = $tbody .  '<td class="bls" width="15%">'.$wdnxxth['iimxxmh_kode'].'</td>';
		$tbody = $tbody .  '<td class="bls" width="45%">'.$wdnxxth['iimxxmh_nama'].'</td>';
		$tbody = $tbody .  '<td class="text-right bls" width="20%">'. number_format($wdnxxth['jumlah_unit'],2) .'</td>';
		$tbody = $tbody .  '<td class="bls brs" width="20%">'. $wdnxxth['iumxxmh_kode'] .'</td>';
		$tbody = $tbody .  '</tr>';
	}

	// generate tampilan
	$html = '
		<html>
			<head>
				
			</head>
			<body>
	
			<!--mpdf
			<htmlpageheader name="myheader">
				<table width="100%">
					<tr>
						<td colspan="12" class="text-center"><h3>Delivery Note</h3></td>
					</tr>
					<br>
					<tr>
						<td width="10%">Tanggal</td>
						<td width="1%">:</td>
						<td width="15%">'.$tanggal->format('d M Y').'</td>
                        <td width="2%"></td>

						<td width="14%">Kode DN</td>
						<td width="1%">:</td>
						<td width="18%">'.$rs_wdnxxth[0]['kode_transaksi'].'</td>
                        <td width="2%"></td>
						
						<td width="12%">Customer</td>
						<td width="1%">:</td>
						<td width="18%">'.$rs_wdnxxth[0]['nama_customer'].'</td>

					</tr>
					<tr>
						<td width="10%">Expedition</td>
						<td width="1%">:</td>
						<td width="15%">'.$rs_wdnxxth[0]['nama_expedisi'].'</td>
                        <td width="2%"></td>

						<td width="14%">Nama Supir</td>
						<td width="1%">:</td>
						<td width="18%">'.$rs_wdnxxth[0]['supir_nama'].'</td>
                        <td width="2%"></td>
						
						<td width="12%">Plat Nomor</td>
						<td width="1%">:</td>
						<td width="18%">'.$rs_wdnxxth[0]['mobil_nomor'].'</td>

					</tr>
				</table>
			</htmlpageheader>
			<br>
			<br>
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
	
		<table width="100%">
			<thead>
				<tr>
					<td class="text-center font-bold bas">Item Code</td>
					<td class="text-center font-bold bas">Item Name</td>
					<td class="text-center font-bold bas">Quantity</td>
					<td class="text-center font-bold bas">UoM</td>
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
				</tr>
			</tfoot>
		</table>
	</body>
</html>
';

	$stylesheet = file_get_contents('../../../templates/inspinia-side/assets/css/print_mpdf.css');

	// render ke mpdf
	$mpdf = new \Mpdf\Mpdf([
		'margin_left' => 5,
		'margin_right' => 5,
		'margin_top' => 25, // table ke header
		'margin_bottom' => 5,
		'margin_header' => 5,	// header
		'margin_footer' => 5,	// footer
		'format' => 'A5', // dalam mm | 'A4' | 'A5' 
		
	]);
	$mpdf->AddPage('L');	// L: Landscape
	$mpdf->SetProtection(array('print'));
	$mpdf->SetTitle("Delivery Note");
	$mpdf->SetDisplayMode('fullpage');
	$mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);
	$mpdf->WriteHTML($html);
	$mpdf->Output();
?>