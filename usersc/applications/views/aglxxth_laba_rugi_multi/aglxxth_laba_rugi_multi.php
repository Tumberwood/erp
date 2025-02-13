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
										<label class="col-lg-2 col-form-label">Periode Awal</label>
										<div class="col-lg-5">
											<div class="input-group input-daterange" id="periode_awal">
												<input type="text" id="start_date_awal" name="start_date_awal" class="form-control">
												<div class="input-group-addon">
													<span class="fa fa-calendar"></span>
												</div>
												<input type="text" id="end_date_awal" name="end_date_awal" class="form-control">
											</div>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-lg-2 col-form-label">Periode Akhir</label>
										<div class="col-lg-5">
											<div class="input-group input-daterange" id="periode_akhir">
												<input type="text" id="start_date_akhir" name="start_date_akhir" class="form-control">
												<div class="input-group-addon">
													<span class="fa fa-calendar"></span>
												</div>
												<input type="text" id="end_date_akhir" name="end_date_akhir" class="form-control">
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
                                <th id="periodeAwal"></th>
                                <th id="periodeAkhir"></th>
                                <th>Total</th>
                            </tr>
                        </thead>
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
	
	// BEGIN datepicker init
	$('#periode_awal').datepicker({
		setDate: new Date(),
		autoclose: true,
		todayHighlight: true,
		clearBtn: true,
		format: "dd M yyyy",
		minViewMode: 'month' 
	});
	$('#start_date_awal').datepicker('setDate', moment(awal_bulan_dmy).subtract(1, 'months').format('DD MMM YYYY'));
	$('#end_date_awal').datepicker('setDate', moment().subtract(1, 'months').endOf('month').format('DD MMM YYYY'));
	// END datepicker init
	
	// BEGIN datepicker init
	$('#periode_akhir').datepicker({
		setDate: new Date(),
		autoclose: true,
		todayHighlight: true,
		clearBtn: true,
		format: "dd M yyyy",
		minViewMode: 'month' 
	});
	$('#start_date_akhir').datepicker('setDate', awal_bulan_dmy);
	$('#end_date_akhir').datepicker('setDate', tanggal_hariini_dmy);
	// END datepicker init

	$('#periodeAwal').html(moment($('#start_date_awal').val(), 'DD MMM YYYY').format('MMM YYYY'));
	$('#periodeAkhir').html(moment($('#start_date_akhir').val(), 'DD MMM YYYY').format('MMM YYYY'));
	
	$(document).ready(function() {
		start_date_awal = moment($('#start_date_awal').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date_awal = moment($('#end_date_awal').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		
		start_date_akhir = moment($('#start_date_akhir').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date_akhir = moment($('#end_date_akhir').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		
		tblaglxxth = $('#tblaglxxth').DataTable( {
			dom: domPQ,
			pageLength: -1,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/aglxxth_laba_rugi_multi/aglxxth_laba_rugi_multi.php",
				type: 'POST',
				data: function (d){
					d.start_date_awal = start_date_awal;
					d.end_date_awal = end_date_awal;
					d.start_date_akhir = start_date_akhir;
					d.end_date_akhir = end_date_akhir;

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
				{ 
					data: "saldo_akhir1" ,
					...renderNumber(2)
				},
				{ 
					data: "saldo_akhir2" ,
					...renderNumber(2)
				},
				{ 
					data: "saldo_akhir3" ,
					...renderNumber(2)
				},
			],
			rowGroup: {
				dataSrc: ['aatxxmh_nama'], // Group berdasarkan kolom pertama dan kedua
				startRender: function(rows, group, level) {

					return $('<tr/>')
						.append('<td colspan="5" style="padding-left: 20px;"><strong>' + group + '</strong></td>');
				},
				endRender: function (rows, group, level) {
					var sum_saldo_akhir1 = rows
						.data()
						.pluck('saldo_akhir1')
						.map(s => {
							var num = parseFloat(s);
							return isNaN(num) ? 0 : num; // Pastikan bukan NaN
						})
						.reduce((a, b) => a + b, 0);

					sum_saldo_akhir1 = $.fn.dataTable.render.number(',', '.', 2, '').display(sum_saldo_akhir1);
					
					var sum_saldo_akhir2 = rows
						.data()
						.pluck('saldo_akhir2')
						.map(s => {
							var num = parseFloat(s);
							return isNaN(num) ? 0 : num; // Pastikan bukan NaN
						})
						.reduce((a, b) => a + b, 0);

					sum_saldo_akhir2 = $.fn.dataTable.render.number(',', '.', 2, '').display(sum_saldo_akhir2);
					
					var sum_saldo_akhir3 = rows
						.data()
						.pluck('saldo_akhir3')
						.map(s => {
							var num = parseFloat(s);
							return isNaN(num) ? 0 : num; // Pastikan bukan NaN
						})
						.reduce((a, b) => a + b, 0);

					sum_saldo_akhir3 = $.fn.dataTable.render.number(',', '.', 2, '').display(sum_saldo_akhir3);

					var label = '<strong>Total ' + group + '</strong>';

					var $row = $('<tr/>')
						.append('<td class="font-bold text-success" style="padding-left: 20px;">' + label + '</td>')
						.append('<td class="text-right font-bold bg-success">' + sum_saldo_akhir1 + '</td>')
						.append('<td class="text-right font-bold bg-success">' + sum_saldo_akhir2 + '</td>')
						.append('<td class="text-right font-bold bg-success">' + sum_saldo_akhir3 + '</td>')
						;

					// Simpan total pendapatan & total BEBAN POKOK PENJUALAN
					if (group === 'PENDAPATAN') {
						window.totalPendapatan = parseFloat(sum_saldo_akhir1.replace(/,/g, '')) || 0;
						window.totalPendapatan2 = parseFloat(sum_saldo_akhir2.replace(/,/g, '')) || 0;
						window.totalPendapatan3 = parseFloat(sum_saldo_akhir3.replace(/,/g, '')) || 0;
					} 
					
					if (group === 'BEBAN POKOK PENJUALAN') {
						window.totalBebanPokok = parseFloat(sum_saldo_akhir1.replace(/,/g, '')) || 0;
						window.totalBebanPokok2 = parseFloat(sum_saldo_akhir2.replace(/,/g, '')) || 0;
						window.totalBebanPokok3 = parseFloat(sum_saldo_akhir3.replace(/,/g, '')) || 0;

						// Jika total pendapatan ada, hitung laba kotor
						if (!isNaN(window.totalPendapatan) && !isNaN(window.totalBebanPokok)) {
							var labaKotor = window.totalPendapatan - window.totalBebanPokok;
							var labaKotorFormatted = $.fn.dataTable.render.number(',', '.', 2, '').display(labaKotor);

							// Simpan nilai LABA KOTOR
							window.totalLabaKotor = labaKotor;

							var labaKotor2 = window.totalPendapatan2 - window.totalBebanPokok2;
							var labaKotorFormatted2 = $.fn.dataTable.render.number(',', '.', 2, '').display(labaKotor2);

							window.totalLabaKotor2 = labaKotor2;

							var labaKotor3 = window.totalPendapatan3 - window.totalBebanPokok3;
							var labaKotorFormatted3 = $.fn.dataTable.render.number(',', '.', 2, '').display(labaKotor3);

							window.totalLabaKotor3 = labaKotor3;

							// Tambahkan row untuk LABA KOTOR
							return $row.add(
								$('<tr/>').append('<td colspan="2"><br></td>') // Tambahkan br sebelum
							).add(
								$('<tr/>')
									.append('<td class="font-bold text-danger" ><strong data-toggle="tooltip" data-placement="right" title="PENDAPATAN - BEBAN POKOK PENJUALAN">LABA KOTOR</strong></td>')
									.append('<td class="text-right font-bold bg-danger">' + labaKotorFormatted + '</td>')
									.append('<td class="text-right font-bold bg-danger">' + labaKotorFormatted2 + '</td>')
									.append('<td class="text-right font-bold bg-danger">' + labaKotorFormatted3 + '</td>')
							).add(
								$('<tr/>').append('<td colspan="2"><br></td>')
							);
						}
					}

					// Simpan total BEBAN
					if (group === 'BEBAN') {
						window.totalBeban = parseFloat(sum_saldo_akhir1.replace(/,/g, '')) || 0;
						window.totalBeban2 = parseFloat(sum_saldo_akhir2.replace(/,/g, '')) || 0;
						window.totalBeban3 = parseFloat(sum_saldo_akhir3.replace(/,/g, '')) || 0;

						// Jika total laba kotor ada, hitung PENDAPATAN OPERASIONAL
						if (!isNaN(window.totalLabaKotor)) {
							var pendapatanOperasional = window.totalLabaKotor - window.totalBeban;
							var pendapatanOperasionalFormatted = $.fn.dataTable.render.number(',', '.', 2, '').display(pendapatanOperasional);
							window.pendapatanOperasionalFormatted = pendapatanOperasionalFormatted;
							
							var pendapatanOperasional2 = window.totalLabaKotor2 - window.totalBeban2;
							var pendapatanOperasionalFormatted2 = $.fn.dataTable.render.number(',', '.', 2, '').display(pendapatanOperasional2);
							window.pendapatanOperasionalFormatted2 = pendapatanOperasionalFormatted2;
							
							var pendapatanOperasional3 = window.totalLabaKotor3 - window.totalBeban3;
							var pendapatanOperasionalFormatted3 = $.fn.dataTable.render.number(',', '.', 2, '').display(pendapatanOperasional3);
							window.pendapatanOperasionalFormatted3 = pendapatanOperasionalFormatted3;

							// Tambahkan row untuk PENDAPATAN OPERASIONAL
							return $row.add(
								$('<tr/>').append('<td colspan="2"><br></td>') // Tambahkan br sebelum
							).add(
								$('<tr/>')
									.append('<td class="font-bold text-danger"><strong data-toggle="tooltip" data-placement="right" title="LABA KOTOR - BEBAN">PENDAPATAN OPERASIONAL</strong></td>')
									.append('<td class="text-right font-bold bg-danger">' + pendapatanOperasionalFormatted + '</td>')
									.append('<td class="text-right font-bold bg-danger">' + pendapatanOperasionalFormatted2 + '</td>')
									.append('<td class="text-right font-bold bg-danger">' + pendapatanOperasionalFormatted3 + '</td>')
							).add(
								$('<tr/>').append('<td colspan="2"><br></td>')
							).add(
								$('<tr/>').append('<td class="font-bold"><strong>PENDAPATAN & BEBAN LAINNYA</strong></td>')
							);
						}
					}

					if (group === 'PENDAPATAN LAINNYA') {
						window.totalPendapatanLainya = parseFloat(sum_saldo_akhir1.replace(/,/g, '')) || 0;
						window.totalPendapatanLainya2 = parseFloat(sum_saldo_akhir2.replace(/,/g, '')) || 0;
						window.totalPendapatanLainya3 = parseFloat(sum_saldo_akhir3.replace(/,/g, '')) || 0;
					} 

					// Simpan total BEBAN LAINNYA
					if (group === 'BEBAN LAINNYA') {
						window.totalBebanLainnya = parseFloat(sum_saldo_akhir1.replace(/,/g, '')) || 0;
						window.totalBebanLainnya2 = parseFloat(sum_saldo_akhir2.replace(/,/g, '')) || 0;
						window.totalBebanLainnya3 = parseFloat(sum_saldo_akhir3.replace(/,/g, '')) || 0;

						// Jika total laba kotor ada, hitung PENDAPATAN OPERASIONAL
						if (!isNaN(window.totalPendapatanLainya)) {
							var pendapatanBebanLainnya = window.totalPendapatanLainya - window.totalBebanLainnya;
							var pendapatanBebanLainnyaFormatted = $.fn.dataTable.render.number(',', '.', 2, '').display(pendapatanBebanLainnya);
							
							var pendapatanOperasional = parseFloat(window.pendapatanOperasionalFormatted.replace(/,/g, '')) || 0;
							var pendapatanBebanLainnya = parseFloat(pendapatanBebanLainnyaFormatted.replace(/,/g, '')) || 0;
							
							var labaBersihSebelum = pendapatanOperasional + pendapatanBebanLainnya;
							var labaBersihSebelumFormatted = $.fn.dataTable.render.number(',', '.', 2, '').display(labaBersihSebelum);
							
							//Periode 2
							var pendapatanBebanLainnya2 = window.totalPendapatanLainya2 - window.totalBebanLainnya2;
							var pendapatanBebanLainnyaFormatted2 = $.fn.dataTable.render.number(',', '.', 2, '').display(pendapatanBebanLainnya2);
							
							var pendapatanOperasional2 = parseFloat(window.pendapatanOperasionalFormatted2.replace(/,/g, '')) || 0;
							var pendapatanBebanLainnya2 = parseFloat(pendapatanBebanLainnyaFormatted2.replace(/,/g, '')) || 0;
							
							var labaBersihSebelum2 = pendapatanOperasional2 + pendapatanBebanLainnya2;
							var labaBersihSebelumFormatted2 = $.fn.dataTable.render.number(',', '.', 2, '').display(labaBersihSebelum2);
							
							//Periode 3
							var pendapatanBebanLainnya3 = window.totalPendapatanLainya3 - window.totalBebanLainnya3;
							var pendapatanBebanLainnyaFormatted3 = $.fn.dataTable.render.number(',', '.', 2, '').display(pendapatanBebanLainnya3);
							
							var pendapatanOperasional3 = parseFloat(window.pendapatanOperasionalFormatted3.replace(/,/g, '')) || 0;
							var pendapatanBebanLainnya3 = parseFloat(pendapatanBebanLainnyaFormatted3.replace(/,/g, '')) || 0;
							
							var labaBersihSebelum3 = pendapatanOperasional3 + pendapatanBebanLainnya3;
							var labaBersihSebelumFormatted3 = $.fn.dataTable.render.number(',', '.', 2, '').display(labaBersihSebelum3);

							// Tambahkan row untuk PENDAPATAN OPERASIONAL
							return $row.add(
								$('<tr/>')
									.append('<td class="font-bold text-danger"><strong>TOTAL PENDAPATAN & BEBAN LAINNYA</strong></td>')
									.append('<td class="text-right font-bold bg-danger">' + pendapatanBebanLainnyaFormatted + '</td>')
									.append('<td class="text-right font-bold bg-danger">' + pendapatanBebanLainnyaFormatted2 + '</td>')
									.append('<td class="text-right font-bold bg-danger">' + pendapatanBebanLainnyaFormatted3 + '</td>')
								).add(
									$('<tr/>').append('<td colspan="2"><br></td>')
								).add(
									$('<tr/>')
									.append('<td class="font-bold text-danger"><strong data-toggle="tooltip" data-placement="right" title="PENDAPATAN OPERASIONAL + TOTAL PENDAPATAN & BEBAN LAINNYA">LABA BERSIH (Sebelum Pajak)</strong></td>')
									.append('<td class="text-right font-bold bg-danger">' + labaBersihSebelumFormatted + '</td>')
									.append('<td class="text-right font-bold bg-danger">' + labaBersihSebelumFormatted2 + '</td>')
									.append('<td class="text-right font-bold bg-danger">' + labaBersihSebelumFormatted3 + '</td>')
								).add(
									$('<tr/>')
									.append('<td class="font-bold text-danger"><strong data-toggle="tooltip" data-placement="right" title="PENDAPATAN OPERASIONAL + TOTAL PENDAPATAN & BEBAN LAINNYA">LABA BERSIH (Setelah Pajak)</strong></td>')
									.append('<td class="text-right font-bold bg-danger">' + labaBersihSebelumFormatted + '</td>')
									.append('<td class="text-right font-bold bg-danger">' + labaBersihSebelumFormatted2 + '</td>')
									.append('<td class="text-right font-bold bg-danger">' + labaBersihSebelumFormatted3 + '</td>')
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
		
		$.validator.addMethod("validDate", function(value, element) {
			return moment(value, "DD MMM YYYY", true).isValid();
		}, "Format tanggal tidak valid!");

		// Custom validation to check start_date_awal < start_date_akhir
		$.validator.addMethod("dateRange", function(value, element) {
			let start = moment($('#start_date_awal').val(), "DD MMM YYYY");
			let end = moment($('#start_date_akhir').val(), "DD MMM YYYY");

			if (!start.isValid() || !end.isValid()) return true; // Abaikan validasi jika tanggal tidak valid

			return start.isBefore(end); // Pastikan start_date_awal < start_date_akhir
		}, "Periode Awal harus lebih kecil dari Periode Akhir!");

		$("#frmFilter").validate({
			rules: {
				start_date_awal: {
					required: true,
					validDate: true,
					dateRange: true  // Add this rule
				},
				end_date_awal: {
					required: true,
					validDate: true
				},
				start_date_akhir: {
					required: true,
					validDate: true
				},
				end_date_akhir: {
					required: true,
					validDate: true
				}
			},
			messages: {
				start_date_awal: {
					required: "Start Date Awal Wajib Diisi!",
					validDate: "Format harus DD MMM YYYY!",
					dateRange: "Start Date Awal harus kurang dari Start Date Akhir!"
				},
				end_date_awal: {
					required: "End Date Awal Wajib Diisi!",
					validDate: "Format harus DD MMM YYYY!"
				},
				start_date_akhir: {
					required: "Start Date Akhir Wajib Diisi!",
					validDate: "Format harus DD MMM YYYY!"
				},
				end_date_akhir: {
					required: "End Date Akhir Wajib Diisi!",
					validDate: "Format harus DD MMM YYYY!"
				}
			},
			submitHandler: function(frmFilter) {
				start_date_awal = moment($('#start_date_awal').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date_awal = moment($('#end_date_awal').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				start_date_akhir = moment($('#start_date_akhir').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date_akhir = moment($('#end_date_akhir').val(), 'DD MMM YYYY').format('YYYY-MM-DD');

				$('#periodeAwal').html(moment($('#start_date_awal').val(), 'DD MMM YYYY').format('MMM YYYY'));
				$('#periodeAkhir').html(moment($('#start_date_akhir').val(), 'DD MMM YYYY').format('MMM YYYY'));
				
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
