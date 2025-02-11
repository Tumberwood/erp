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
									<div class="form-group row">												
										<label class="col-sm-2 col-form-label">Akun Kas & Bank</label>
										<div class="col-sm-4">
											<select class="form-control" id="select_aakxxmh" name="select_id_aakxxmh"></select>
										</div>
									</div>

									<div class="form-group row">
										<label class="col-lg-2 col-form-label">Configuration</label>
										<div class="col-lg-6">
											<fieldset>
												<div class="form-check abc-checkbox form-check-inline">
													<input class="form-check-input" type="checkbox" id="cbakunbertransaksi" checked>
													<label class="form-check-label" for=""> Hanya Akun Bertransaksi </label>
												</div>
												<div class="form-check abc-checkbox abc-checkbox-success form-check-inline">
													<input class="form-check-input" type="checkbox" id="cbakunbernilai" checked>
													<label class="form-check-label" for=""> Hanya Akun Bernilai </label>
												</div>
											</fieldset>
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
                                <th>ID</th>
                                <th data-i18n="account"></th>
                                <th data-i18n="documentNumber"></th>
                                <th data-i18n="date"></th>
                                <th data-i18n="notes"></th>
                                <th data-i18n="debit"></th>
                                <th data-i18n="credit"></th>
                                <th data-i18n="balance"></th>
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
	var is_akunbertransaksi = 1, is_akunbernilai = 1, id_aakxxmh_old = 0;

	// get tableRelation
	tableRelation('aglxxth');
		
	$("#select_aakxxmh").select2({
		placeholder: 'Ketik atau TekanTanda Panah Kanan',
		allowClear: true,
		ajax: {
			url: "../../models/aakxxmh/aakxxmh_type_fn_opt.php",
			dataType: 'json',
			data: function (params) {
				var query = {
					id_aakxxmh_old: id_aakxxmh_old,
					id_aatxxmh: 1,
					search: params.term || '',
					page: params.page || 1
				}
					return query;
			},
			processResults: function (data, params) {
				return {
					results: data.results,
					pagination: {
						more: true
					}
				};
			},
			cache: true,
			minimumInputLength: 1,
			maximum: 10,
			delay: 500,
			maximumSelectionLength: 5,
			minimumResultsForSearch: -1,
		},
	});
	
	$(document).ready(function() {
		start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');	
		id_aakxxmh = $('#select_aakxxmh').val();
		
		tblaglxxth = $('#tblaglxxth').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/aglxxth_kas_bank/aglxxth_kas_bank.php",
				type: 'POST',
				data: function (d){
					d.start_date = start_date;
					d.end_date = end_date;
					d.is_akunbertransaksi = is_akunbertransaksi;
					d.is_akunbernilai = is_akunbernilai;
					d.id_aakxxmh = id_aakxxmh;
				}
			},
			order: [[ 1, "asc" ]],
			rowGroup: {
				dataSrc: 'akun',
				endRender: function (rows, group) {
						var sum_debit = rows
							.data()
							.pluck('debit')
							.map(function (debit) {
								return parseFloat(debit) || 0;
							})
							.reduce(function (a, b) {
								return a + b;
							}, 0);
						
						sum_debit = $.fn.dataTable.render.number(',', '.', 2, '').display(sum_debit);
						
						var sum_kredit = rows
							.data()
							.pluck('kredit')
							.map(function (kredit) {
								return parseFloat(kredit) || 0;
							})
							.reduce(function (a, b) {
								return a + b;
							}, 0);
						
						sum_kredit = $.fn.dataTable.render.number(',', '.', 2, '').display(sum_kredit);
						
						// Create a new <tr> element for the total row
						return $('<tr/>')
							.append('<td class="font-bold text-success">Total</td>')
							.append('<td class="font-bold text-success"></td>')
							.append('<td class="font-bold text-success"></td>')
							.append('<td class="text-right font-bold bg-success">' + sum_debit + '</td>')
							.append('<td class="text-right font-bold bg-success">' + sum_kredit + '</td>')
							.append('<td></td>')
							;
					}
			},
			columnDefs:[
				{
					searchPanes:{
						show: true,
					},
					targets: [1,2,3]
				},
				{
					searchPanes:{
						show: false,
					},
					targets: '_all'
				}
			],
			columns: [
				{ data: "id",visible:false },
				{ data: "akun", visible: false },
				{ data: "kode_transaksi" },
				{ data: "tanggal" },
				{ data: "keterangan" },
				{ 
					data: "debit" ,
					...renderNumber(2)
				},
				{ 
					data: "kredit" ,
					...renderNumber(2)
				},
				{ 
					data: "saldo" ,
					...renderNumber(2)
				}
			],
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
			}
		} );

		tblaglxxth.searchPanes.container().appendTo('#spaglxxth');
		tblaglxxth.searchBuilder.container().appendTo( '#sbaglxxth' );
		
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
				id_aakxxmh = $('#select_aakxxmh').val();

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
