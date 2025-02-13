<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'aglxxth';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="modal" id="modalSFaglxxth" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog modal-lg">
						<div class="modal-content animated bounceInRight">
							<form class="form-horizontal" id="frmFilter">
								<div class="modal-header">
									<h4 class="modal-title">Filter</h4>
								</div>
								<div class="modal-body">
									<div class="form-group row">
										<label class="col-lg-2 col-form-label">Periode</label>
										<div class="col-lg-5">
											<div class="input-group input-daterange" id="periode">
												<input type="text" id="start_date" class="form-control">
												<div class="input-group-addon">
													<span class="fa fa-calendar"></span>
												</div>
												<input type="text" id="end_date" class="form-control">
											</div>
										</div>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
									<button class="btn btn-primary" type="submit">Submit</button>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="table-responsive">
                    <table id="tblaglxxth" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>ID</th>
                                <th>Urutan</th>
                                <th data-i18n="accountName"></th>
                                <!-- <th data-i18n="beginningBalance"></th>
                                <th data-i18n="debit"></th>
                                <th data-i18n="credit"></th> -->
                                <th data-i18n="balance"></th>
                            </tr>
                        </thead>
						<!-- <tfoot>
							<tr>
								<th></th>
								<th></th>
								<th>Total</th>
								<th id="total_3"></th>
								<th id="total_4"></th>
								<th id="total_5"></th>
								<th id="total_6"></th>
							</tr>
						</tfoot> -->
                    </table>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_modal_log.php';
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_modal_dt_fs.php';
?>

<!-- BEGIN JS -->
<?php 
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_load.php';
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_setup.php';
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_datatables_load.php'; 
?>

<script src="<?=$us_url_root?>usersc/helpers/general_fn.js"></script>
<script src="<?=$us_url_root?>usersc/helpers/validation_fn.js"></script>
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn2.js"></script>
<script src="<?=$us_url_root?>usersc/helpers/language.js"></script>
<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edtaglxxth, tblaglxxth, show_deleted_aglxxth = 0, id_aglxxth;
	// ------------- end of default variable
	var is_akunbertransaksi = 1, is_akunbernilai = 1;

	// get tableRelation
	tableRelation('aglxxth');
	$('#end_date').datepicker('setDate', tanggal_hariini_dmy);
	
	$(document).ready(function() {
		start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');	
		
		tblaglxxth = $('#tblaglxxth').DataTable( {
			dom: domPQ,
			pageLength: -1,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/aglxxth_laba_rugi/aglxxth_laba_rugi.php",
				type: 'POST',
				data: function (d){
					d.start_date = start_date;
					d.end_date = end_date;
					d.is_akunbertransaksi = is_akunbertransaksi;
					d.is_akunbernilai = is_akunbernilai;
				}
			},
			columnDefs:[
				{
					searchPanes:{
						show: true,
					},
					targets: [1]
				},
				{
					searchPanes:{
						show: false,
					},
					targets: '_all'
				},
			],
			order: [[ 2, "asc" ], [ 1, "asc" ]],
			columns: [
				{ data: "aatxxmh_nama",visible:false },
				{ data: "id",visible:false },
				{ data: "urutan",visible:false },
				{
					data: "nama",
					render: function(data, type, row) {
						return '<span style="padding-left: 40px;">' + data + '</span>';
					}
				},
				// { 
				// 	data: "saldo_awal" ,
				// 	...renderNumber(2)
				// },
				// { 
				// 	data: "debit" ,
				// 	...renderNumber(2)
				// },
				// { 
				// 	data: "kredit" ,
				// 	...renderNumber(2)
				// },
				{ 
					data: "saldo_akhir" ,
					...renderNumber(2)
				}
			],
			rowGroup: {
				dataSrc: ['aatxxmh_nama'], // Group berdasarkan kolom pertama dan kedua
				startRender: function(rows, group, level) {

					return $('<tr/>')
						.append('<td colspan="5" style="padding-left: 20px;"><strong>' + group + '</strong></td>');
				},
				// endRender: function (rows, group, level) {
				// 	var sum_saldo_akhir = rows
				// 		.data()
				// 		.pluck('saldo_akhir')
				// 		.map(s => {
				// 			var num = parseFloat(s);
				// 			return isNaN(num) ? 0 : num; // Pastikan bukan NaN
				// 		})
				// 		.reduce((a, b) => a + b, 0);

				// 	sum_saldo_akhir = $.fn.dataTable.render.number(',', '.', 2, '').display(sum_saldo_akhir);

				// 	var indent = level * 20;
				// 	var label = '<strong>Total ' + group + '</strong>';

				// 	var $row = $('<tr/>')
				// 		.append('<td class="font-bold text-success" style="padding-left: ' + indent + 'px;">' + label + '</td>')
				// 		.append('<td class="text-right font-bold bg-success">' + sum_saldo_akhir + '</td>');

				// 	// Simpan total pendapatan & total BEBAN POKOK PENJUALAN
				// 	if (group === 'PENDAPATAN') {
				// 		window.totalPendapatan = parseFloat(sum_saldo_akhir.replace(/,/g, '')) || 0;
				// 	} 
					
				// 	if (group === 'BEBAN POKOK PENJUALAN') {
				// 		window.totalBebanPokok = parseFloat(sum_saldo_akhir.replace(/,/g, '')) || 0;

				// 		// Jika total pendapatan ada, hitung laba kotor
				// 		if (!isNaN(window.totalPendapatan) && !isNaN(window.totalBebanPokok)) {
				// 			var labaKotor = window.totalPendapatan - window.totalBebanPokok;
				// 			var labaKotorFormatted = $.fn.dataTable.render.number(',', '.', 2, '').display(labaKotor);

				// 			// Tambahkan row untuk LABA KOTOR
				// 			return $row.add(
				// 				$('<tr/>')
				// 					.append('<td class="font-bold text-danger"><strong>LABA KOTOR</strong></td>')
				// 					.append('<td class="text-right font-bold bg-danger">' + labaKotorFormatted + '</td>')
				// 			);
				// 		}
				// 	}

				// 	return $row;
				// }
				endRender: function (rows, group, level) {
					var sum_saldo_akhir = rows
						.data()
						.pluck('saldo_akhir')
						.map(s => {
							var num = parseFloat(s);
							return isNaN(num) ? 0 : num; // Pastikan bukan NaN
						})
						.reduce((a, b) => a + b, 0);

					sum_saldo_akhir = $.fn.dataTable.render.number(',', '.', 2, '').display(sum_saldo_akhir);

					var label = '<strong>Total ' + group + '</strong>';

					var $row = $('<tr/>')
						.append('<td class="font-bold text-success" style="padding-left: 20px;">' + label + '</td>')
						.append('<td class="text-right font-bold bg-success">' + sum_saldo_akhir + '</td>');

					// Simpan total pendapatan & total BEBAN POKOK PENJUALAN
					if (group === 'PENDAPATAN') {
						window.totalPendapatan = parseFloat(sum_saldo_akhir.replace(/,/g, '')) || 0;
					} 
					
					if (group === 'BEBAN POKOK PENJUALAN') {
						window.totalBebanPokok = parseFloat(sum_saldo_akhir.replace(/,/g, '')) || 0;

						// Jika total pendapatan ada, hitung laba kotor
						if (!isNaN(window.totalPendapatan) && !isNaN(window.totalBebanPokok)) {
							var labaKotor = window.totalPendapatan - window.totalBebanPokok;
							var labaKotorFormatted = $.fn.dataTable.render.number(',', '.', 2, '').display(labaKotor);

							// Simpan nilai LABA KOTOR
							window.totalLabaKotor = labaKotor;

							// Tambahkan row untuk LABA KOTOR
							return $row.add(
								$('<tr/>').append('<td colspan="2"><br></td>') // Tambahkan br sebelum
							).add(
								$('<tr/>')
									.append('<td class="font-bold text-danger" ><strong data-toggle="tooltip" data-placement="right" title="PENDAPATAN - BEBAN POKOK PENJUALAN">LABA KOTOR</strong></td>')
									.append('<td class="text-right font-bold bg-danger">' + labaKotorFormatted + '</td>')
							).add(
								$('<tr/>').append('<td colspan="2"><br></td>')
							);
						}
					}

					// Simpan total BEBAN
					if (group === 'BEBAN') {
						window.totalBeban = parseFloat(sum_saldo_akhir.replace(/,/g, '')) || 0;

						// Jika total laba kotor ada, hitung PENDAPATAN OPERASIONAL
						if (!isNaN(window.totalLabaKotor)) {
							var pendapatanOperasional = window.totalLabaKotor - window.totalBeban;
							var pendapatanOperasionalFormatted = $.fn.dataTable.render.number(',', '.', 2, '').display(pendapatanOperasional);
							window.pendapatanOperasionalFormatted = pendapatanOperasionalFormatted;
							// Tambahkan row untuk PENDAPATAN OPERASIONAL
							return $row.add(
								$('<tr/>').append('<td colspan="2"><br></td>') // Tambahkan br sebelum
							).add(
								$('<tr/>')
									.append('<td class="font-bold text-danger"><strong data-toggle="tooltip" data-placement="right" title="LABA KOTOR - BEBAN">PENDAPATAN OPERASIONAL</strong></td>')
									.append('<td class="text-right font-bold bg-danger">' + pendapatanOperasionalFormatted + '</td>')
							).add(
								$('<tr/>').append('<td colspan="2"><br></td>')
							).add(
								$('<tr/>').append('<td class="font-bold"><strong>PENDAPATAN & BEBAN LAINNYA</strong></td>')
							);
						}
					}

					if (group === 'PENDAPATAN LAINNYA') {
						window.totalPendapatanLainya = parseFloat(sum_saldo_akhir.replace(/,/g, '')) || 0;
					} 

					// Simpan total BEBAN LAINNYA
					if (group === 'BEBAN LAINNYA') {
						window.totalBebanLainnya = parseFloat(sum_saldo_akhir.replace(/,/g, '')) || 0;

						// Jika total laba kotor ada, hitung PENDAPATAN OPERASIONAL
						if (!isNaN(window.totalPendapatanLainya)) {
							var pendapatanBebanLainnya = window.totalPendapatanLainya - window.totalBebanLainnya;
							var pendapatanBebanLainnyaFormatted = $.fn.dataTable.render.number(',', '.', 2, '').display(pendapatanBebanLainnya);
							
							var pendapatanOperasional = parseFloat(window.pendapatanOperasionalFormatted.replace(/,/g, '')) || 0;
							var pendapatanBebanLainnya = parseFloat(pendapatanBebanLainnyaFormatted.replace(/,/g, '')) || 0;
							
							var labaBersihSebelum = pendapatanOperasional + pendapatanBebanLainnya;
							var labaBersihSebelumFormatted = $.fn.dataTable.render.number(',', '.', 2, '').display(labaBersihSebelum);

							// Tambahkan row untuk PENDAPATAN OPERASIONAL
							return $row.add(
								$('<tr/>')
									.append('<td class="font-bold text-danger"><strong>TOTAL PENDAPATAN & BEBAN LAINNYA</strong></td>')
									.append('<td class="text-right font-bold bg-danger">' + pendapatanBebanLainnyaFormatted + '</td>')
								).add(
									$('<tr/>').append('<td colspan="2"><br></td>')
								).add(
									$('<tr/>')
									.append('<td class="font-bold text-danger"><strong data-toggle="tooltip" data-placement="right" title="PENDAPATAN OPERASIONAL + TOTAL PENDAPATAN & BEBAN LAINNYA">LABA BERSIH (Sebelum Pajak)</strong></td>')
									.append('<td class="text-right font-bold bg-danger">' + labaBersihSebelumFormatted + '</td>')
								).add(
									$('<tr/>')
									.append('<td class="font-bold text-danger"><strong data-toggle="tooltip" data-placement="right" title="PENDAPATAN OPERASIONAL + TOTAL PENDAPATAN & BEBAN LAINNYA">LABA BERSIH (Setelah Pajak)</strong></td>')
									.append('<td class="text-right font-bold bg-danger">' + labaBersihSebelumFormatted + '</td>')
							);
						}
					}

					return $row;
				}
			},
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_aglxxth';
					$table       = 'tblaglxxth';
					$edt         = 'edtaglxxth';
					$show_status = '_aglxxth';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= ['sf', 'sp', 'sb'];
					$arr_buttons_action 	= [];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
				// END breaking generate button
			],
			// footerCallback: function ( row, data, start, end, display ) {
			// 	var api = this.api();
			// 	var numFormat = $.fn.dataTable.render.number( '\,', '.', 0, '' ).display; 

			// 	for (var i = 3; i <= 6; i++) {
			// 		var columnIndex = i;
			// 		var sum_all = api.column(columnIndex).data().sum();
			// 		// Bisa dilakukan sum berdasarkan paginasi (sum per paginasi / tidak sum semua data) dengan menambahkan { page: 'current' }
			// 		var sum = api.column(columnIndex, { page: 'current' }).data().sum();
			// 		$('#total_' + columnIndex).html(numFormat(sum_all));

			// 		// console.log('Number of Pages: ' + api.page.info().pages);
			// 	}
			// },
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
		} );

		tblaglxxth.searchPanes.container().appendTo('#spaglxxth');
		tblaglxxth.searchBuilder.container().appendTo( '#sbaglxxth' );
		
		$('#tblaglxxth').on('draw.dt', function () {
			$('[data-toggle="tooltip"]').tooltip(); // Re-inisialisasi tooltip
		});

		tblaglxxth.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblaglxxth);
		} );
		
		tblaglxxth.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			// siVarSet('aglxxth');

			// atur hak akses
			CekSelectHeaderH(tblaglxxth);
		} );

		tblaglxxth.on( 'deselect', function () {
			// reset variable standar framework
			// siVarReset('aglxxth');

			// atur hak akses
			CekDeselectHeaderH(tblaglxxth);
		} );

		// END aglxxth

		// BEGIN form filter
		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
				start_date: {
					required: true,
					validDate: "DD MMM YYYY"
				},
				end_date: {
					required: true,
					validDate: "DD MMM YYYY"
				}
			},
			messages: {
				start_date: {
					required: "Start Date Wajib Diisi!"
				},
				end_date: {
					required: "End Date Wajib Diisi!"
				}
			},
			submitHandler: function(frmFilter) {
				start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');

				// BEGIN parameter tambahan
				if( $('#cbakunbertransaksi').is(':checked') ){
					is_akunbertransaksi = 1;
				}else{
					is_akunbertransaksi = 0;
				}

				if( $('#cbakunbertransaksi').is(':checked') ){
					is_akunbernilai = 1;
				}else{
					is_akunbernilai = 0;
				}

				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
				tblaglxxth.rows().deselect();
				tblaglxxth.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSFaglxxth').modal('toggle');
			}, false);
				return false;
			}
		});
		// END form filter
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
