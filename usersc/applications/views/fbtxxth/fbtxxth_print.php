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
	$id_fbtxxth = $_GET['id_fbtxxth'];

	$qs_aglxxth = $db
		->query('select', 'aglxxth' )
		->get([
			'aglxxth.kode as kode',
			'aglxxth.keterangan as keterangan',
			'aglxxth.tanggal as tanggal',
			'aglxxth.jenis_transaksi as jenis_transaksi',
			'aglxxth.total_debit as total_debit',
			'aglxxth.total_kredit as total_kredit'
		] )
		->where('aglxxth.id_transaksi_h', $id_fbtxxth )
		->where('aglxxth.jenis_transaksi', 'Kas Bank Transfer' )
		->exec();
	$rs_aglxxth = $qs_aglxxth->fetch();

	$qs_aglaktd = $db
		->query('select', 'aglaktd' )
		->get([
			'aglaktd.kode as kode',
			'aglaktd.id_aakxxmh as id_aakxxmh',
			'aglaktd.debit_kredit as debit_kredit',
			'aglaktd.debit as debit',
			'aglaktd.kredit as kredit',
			'aakxxmh.kode as aakxxmh_kode',
			'aakxxmh.nama as aakxxmh_nama'
		] )
		->join('aakxxmh','aakxxmh.id = aglaktd.id_aakxxmh','LEFT' )
		->where('aglaktd.id_aglxxth', $id_fbtxxth )
		->exec();
	$rs_aglaktd = $qs_aglaktd->fetchAll();
	$tanggal = new Carbon($rs_aglxxth['tanggal']);

	$tbody = '';
	foreach ($rs_aglaktd as $key => $row_aglaktd) {
		$tbody = $tbody . '<tr>';
		$tbody = $tbody .  '<td class="bls" width="15%">'.$row_aglaktd['aakxxmh_kode'].'</td>';
		$tbody = $tbody .  '<td class="bls" width="45%">'.$row_aglaktd['aakxxmh_nama'].'</td>';
		$tbody = $tbody .  '<td class="text-right bls" width="20%">'. number_format($row_aglaktd['debit'],2) .'</td>';
		$tbody = $tbody .  '<td class="text-right bls brs" width="20%">'. number_format($row_aglaktd['kredit'],2) .'</td>';
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
						<td colspan="6" class="text-center"><h3>Jurnal</h3></td>
					</tr>
					<tr>
						<td width="14%">Tanggal</td>
						<td width="1%">:</td>
						<td width="20%">'.$tanggal->format('d M Y').'</td>

						<td width="10%">Deskripsi</td>
						<td width="1%">:</td>
						<td>'.$rs_aglxxth['keterangan'].'</td>
					</tr>
					<tr>
						<td>Jenis Transaksi</td>
						<td>:</td>
						<td>'.$rs_aglxxth['jenis_transaksi'].'</td>

						<td></td>
						<td></td>
						<td></td>
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
	
		<table width="100%">
			<thead>
				<tr>
					<td class="text-center font-bold bas">Kode</td>
					<td class="text-center font-bold bas">Nama</td>
					<td class="text-center font-bold bas">Debit</td>
					<td class="text-center font-bold bas">Kredit</td>
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
					<td class="text-right font-bold bas">'. number_format($rs_aglxxth['total_debit'],2) .'</td>
					<td class="text-right font-bold bas">'. number_format($rs_aglxxth['total_kredit'],2) .'</td>
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
	$mpdf->SetTitle("Jurnal");
	$mpdf->SetDisplayMode('fullpage');
	$mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);
	$mpdf->WriteHTML($html);
	$mpdf->Output();
?>