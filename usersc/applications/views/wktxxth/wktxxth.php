<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'wktxxth';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'wktittd';
    $nama_tabels_d[1] = 'wktlptd';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">

				<div class="modal" id="modalSFwktxxth" tabindex="-1" role="dialog" aria-hidden="true">
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
                    <table id="tblwktxxth" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Kode</th>
                                <th>Tanggal</th>
                                <th>Picking Method</th>
                                <th>Cross Docking</th>
                                <th>TX</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

	<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 p-w-xs">
		<div class="alert alert-info alert-dismissable">
			<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
			Harap isi Quantity per satu paket Kit pada detail Item!
			<br>
			Harap Picking semua detail Kitting di Menu Picking agar dapat melanjutkan ke Finalisasi Kitting!	
		</div>
		<div class="tabs-container">
			<ul class="nav nav-tabs" role="tablist">
				<li><a class="nav-link active" data-toggle="tab" href="#tabwktittd_1"> Item</a></li>
				<li><a class="nav-link" data-toggle="tab" href="#tabwktlptd"> LPN</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabwktittd_1" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblwktittd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
										<tr>
											<th>ID</th>
											<th>id_wktxxth</th>
											<th>Item Code</th>
											<th>Item Name</th>
											<th>UoM</th>
											<th>Qty</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th></th>
											<th></th>
											<th></th>
											<th id="c_item"></th>
											<th></th>
											<th></th>
										</tr>
									</tfoot>
							</table>
						</div> <!-- end of table -->

					</div>
				</div>
				<div role="tabpanel" id="tabwktlptd" class="tab-pane">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblwktlptd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th rowspan="2">ID</th>
										<th rowspan="2">id_wktxxth</th>
										<th rowspan="2">Kode PC</th>
										<th rowspan="2">LPN</th>
										<th rowspan="2">Location</th>
										<th rowspan="2">Item Code</th>
										<th rowspan="2">Item Name</th>
										<th colspan="2">Terkecil</th>
										<th colspan="2">Default</th>
										<th rowspan="2">Batch Number</th>
										<th rowspan="2">Expired Date</th>
									</tr>
									<tr>
										<th>Jumlah</th>
										<th>UoM</th>
										<th>Jumlah</th>
										<th>UoM</th>
									</tr>
								</thead>
								<tfoot>
									<th></th>
									<th></th>
									<th>Total</th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th id="s_7"></th>
									<th></th>
									<th id="s_9"></th>
									<th></th>
									<th></th>
									<th></th>
								</tfoot>
							</table>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div> <!-- end of right col -->

</div> <!-- end of row -->

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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/wktxxth/fn/wktxxth_fn.php'; ?>


<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edtwktxxth, tblwktxxth, show_deleted_wktxxth = 0, id_wktxxth;
	var edtwktittd, tblwktittd, show_deleted_wktittd = 0, id_wktittd;
	var edtwktlptd, tblwktlptd, show_deleted_wktlptd = 0, id_wktlptd;
	var edtwktrstd_create;
	// ------------- end of default variable

	// get tableRelation
	tableRelation('wktxxth');
	var id_iimxxmh_old_kitting = 0, id_iumxxmh_unit_old = 0, id_iumxxmh_unit_old_kitting = 0, id_iimxxmh = 0, id_iwhxxmh_old =0, id_iwhxxmh = 0, id_wloxxmh_old = 0;
	var id_wpmxxmh_old = 0, id_iimxxmh_old = 0, id_iumxxmh_old = 0;
	
	uniqueToken = '';
	var c_id = 0;

	$(document).ready(function() {
		cekBelumConfirm();

		start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');

		// BEGIN wktxxth
		edtwktxxth = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/wktxxth/wktxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_wktxxth = show_deleted_wktxxth;
					d.start_date = start_date;
					d.end_date = end_date;
				}
			},
			table: "#tblwktxxth",
			fields: [ 
				{
					label: "wktxxth.start_at",
					name: "wktxxth.start_at",
					type: "hidden"
				},	
				{
					label: "wktxxth.finish_at",
					name: "wktxxth.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "wktxxth",
					type: "hidden"
				},	
				{
					label: "wktxxth.transaction_state",
					name: "wktxxth.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: "Tanggal <sup class='text-danger'>*<sup>",
					name: "wktxxth.tanggal",
					type: "datetime",
					def: function () { 
						return new Date(); 
					},
					opts:{
						minDate: new Date('1900-01-01'),
						firstDay: 0
					},
					format: 'DD MMM YYYY'
				},
				{
					label: "Item Kitting <sup class='text-danger'>*<sup>",
					name: "wktxxth.id_iimxxmh",
					id: "wdoxxth",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/iimxxmh/iimxxmh_fn_opt_iicxxmh.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_iimxxmh_old: id_iimxxmh_old_kitting,
									ids_iicxxmh: 4,
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
					}
				},
				{
					label: "UoM <sup class='text-danger'>*<sup>",
					name: "wktxxth.id_iumxxmh_unit",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/iumxxmh/iumxxmh_fn_opt_iimummd.php",
							dataType: 'json',
							data: function (params) {
								id_iimxxmh = edtwktxxth.field('wktxxth.id_iimxxmh').val();
								var query = {
									id_iimxxmh: id_iimxxmh,
									id_iumxxmh_unit_old: id_iumxxmh_unit_old_kitting,
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
					}
				},	
				{
					label: "Quantity <sup class='text-danger'>*<sup>",
					name: "wktxxth.jumlah_unit"
				}, 		
				{
					label: "Picking Method <sup class='text-danger'>*<sup>",
					name: "wktxxth.id_wpmxxmh",
					id: "select2_wpm", //tambahkan id di select2nya
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/wpmxxmh/wpmxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_wpmxxmh_old: id_wpmxxmh_old,
									search: params.term || '',
									page: params.page || 1
								}
									return query;
							},
							processResults: function (data, params) {
								var options = data.results.map(function (result) {
									return {
										id: result.id,
										text: result.text
									};
								});

								//add by ferry agar auto select 07 sep 23
								if (params.page && params.page === 1) {
									$('#select2_wpm').empty().select2({ data: options });
								} else {
									$('#select2_wpm').append(new Option(options[0].text, options[0].id, false, false)).trigger('change');
								}

								return {
									results: options,
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
					}
				},
				{
					label: "All WH",
					name: "wktxxth.is_all_wh",
					type: "select",
					placeholder : "Select",
					def:1,
					options: [
						{ "label": "Ya", "value": 1 },
						{ "label": "Tidak", "value": 0 }
					]
				},
				{
					label: "Warehouse<sup class='text-danger'>*<sup>",
					name: "wktxxth.id_iwhxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/iwhxxmh/iwhxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_iwhxxmh_old: id_iwhxxmh_old,
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
					}
				},
				{
					label: "Location<sup class='text-danger'>*<sup>",
					name: "wktxxth.id_wloxxmh_out",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/wloxxmh/wloxxmh_fn_opt_wloctmh.php",
							dataType: 'json',
							data: function (params) {
								id_iwhxxmh = edtwktxxth.field('wktxxth.id_iwhxxmh').val();
								console.log(id_iwhxxmh);
								var query = {
									id_wloxxmh_old: id_wloxxmh_old,
									ids_wloctmh: 4,
									id_iwhxxmh: id_iwhxxmh,
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
					}
				},
				{
					label: "Cross Docking?",
					name: "wktxxth.is_crossdocking",
					type: "select",
					def: 1,
					options: [
						{ "label": "Ya", "value": 1 },
						{ "label": "Tidak", "value": 0 }
					]
				},
				{
					label: "Keterangan",
					name: "wktxxth.keterangan",
					type: "textarea"
				},
			]
		} );
		
		edtwktxxth.field('wktxxth.id_iwhxxmh').hide();

		edtwktxxth.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtwktxxth.field('wktxxth.start_at').val(start_at);

			if(action == 'create'){
				tblwktxxth.rows().deselect();
			}
		});

		edtwktxxth.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			edtFormButtonSaveConfirmHD();
			
			$('#select2_wpm').select2('open');

			setTimeout(function() {
				$('#select2_wpm').select2('close');
			}, 5);
		});
		
		edtwktxxth.dependent( 'wktxxth.is_all_wh', function ( val, data, callback ) {
			if (val == 1) {
				edtwktxxth.field('wktxxth.id_iwhxxmh').hide();
			} else {
				edtwktxxth.field('wktxxth.id_iwhxxmh').show();
			}
			return {}
		}, {event: 'keyup change'});
		
		edtwktxxth.dependent( 'wktxxth.id_iwhxxmh', function ( val, data, callback ) {
			id_iwhxxmh = val;
			// id_wloxxmh_old = 0;

			if (id_wloxxmh_old == 0) {
				edtwktxxth.field('wktxxth.id_wloxxmh_out').val('');
			}
			return {}
		}, {event: 'keyup change'});

		edtwktxxth.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				id_iimxxmh = edtwktxxth.field('wktxxth.id_iimxxmh').val();
				id_iumxxmh_unit = edtwktxxth.field('wktxxth.id_iumxxmh_unit').val();
				jumlah_unit = edtwktxxth.field('wktxxth.jumlah_unit').val();
				tanggal = edtwktxxth.field('wktxxth.tanggal').val();
				id_wpmxxmh = edtwktxxth.field('wktxxth.id_wpmxxmh').val();
				id_iwhxxmh = edtwktxxth.field('wktxxth.id_iwhxxmh').val();
				is_all_wh = edtwktxxth.field('wktxxth.is_all_wh').val();
				id_wloxxmh_out = edtwktxxth.field('wktxxth.id_wloxxmh_out').val();

				validasiRequired(
					edtwktxxth,
					'wktxxth',
					{
						'id_iimxxmh': id_iimxxmh,
						'id_iumxxmh_unit': id_iumxxmh_unit,
						'jumlah_unit': jumlah_unit,
						'tanggal': tanggal,
						'id_wpmxxmh': id_wpmxxmh,
						// 'id_iwhxxmh': id_iwhxxmh,
						'id_wloxxmh_out': id_wloxxmh_out,
					}
				);

				if (is_all_wh == 0) {
					
					validasiRequired(
						edtwktxxth,
						'wktxxth',
						{
							'id_iwhxxmh': id_iwhxxmh,
						}
					);
				}

			}
			
			if ( edtwktxxth.inError() ) {
				return false;
			}
		});

		edtwktxxth.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtwktxxth.field('wktxxth.finish_at').val(finish_at);
		});
		
		edtwktxxth.on( 'postSubmit', function (e, json, data, action, xhr) {
			if (action != 'remove') {
				id_transaksi = json.data[0].wktxxth.id;
            	konversiUom('wktxxth', id_transaksi );

				tblwktxxth.rows().deselect();
			}
			tblwktxxth.ajax.reload(null, false);
			tblwktittd.ajax.reload(null, false);
			tblwktittd.rows().deselect();
		} );

		edtwktxxth.on( 'close', function () {
			edtwktxxth.enable();
		} );

		
		// BEGIN wktrstd_create
		edtwktrstd_create = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/wktxxth/wktrstd_create.php",
				type: 'POST',
				data: function (d){
					d.id_wktxxth = id_wktxxth;
				}
			},
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "start_at",
					name: "start_at",
					type: "hidden"
				},	
				{
					label: "finish_at",
					name: "finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "wktrstd",
					type: "hidden"
				},	
				{
					label: "wktrstd.id_wktxxth",
					name: "wktrstd.id_wktxxth",
					type: "hidden"
				},
				{
					label: "wktrstd.id_iimxxmh",
					name: "wktrstd.id_iimxxmh",
					type: "hidden"
				},
				{
					label: "wktrstd.id_iumxxmh_unit",
					name: "wktrstd.id_iumxxmh_unit",
					type: "hidden"
				},
				{
					label: "wktrstd.id_wloxxmh",
					name: "wktrstd.id_wloxxmh",
					type: "hidden"
				},
				{
					label: "wktrstd.wloxxmh_nama",
					name: "wktrstd.wloxxmh_nama",
					type: "hidden"
				},
				{
					label: "wktrstd.id_iwhxxmh",
					name: "wktrstd.id_iwhxxmh",
					type: "hidden"
				},
				{
					label: "Jumlah Finalisasi <sup class='text-danger'>*<sup>" ,
					name: "wktrstd.jumlah_unit"
				},
			]
			} );

			edtwktrstd_create.on( 'preOpen', function( e, mode, action ) {
				edtwktrstd_create.field('wktrstd.id_wktxxth').val(id_wktxxth);
				edtwktrstd_create.field('wktrstd.id_wloxxmh').val(id_wloxxmh_out_old);
				autofillField('wloxxmh', id_wloxxmh_out_old, 'id_iwhxxmh, nama');
				id_iwhxxmh = autofillData.id_iwhxxmh;
				wloxxmh_nama = autofillData.nama;

				edtwktrstd_create.field('wktrstd.id_iwhxxmh').val(id_iwhxxmh);
				edtwktrstd_create.field('wktrstd.wloxxmh_nama').val(wloxxmh_nama);
				edtwktrstd_create.field('wktrstd.id_iimxxmh').val(id_iimxxmh_old_kitting);
				edtwktrstd_create.field('wktrstd.id_iumxxmh_unit').val(id_iumxxmh_unit_old_kitting);
				
				start_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtwktrstd_create.field('start_at').val(start_at);

				sisa = min_jumlah_unit - s_jumlah_unit;
				edtwktrstd_create.field('wktrstd.jumlah_unit').fieldInfo('Jumlah Finalisasi tidak boleh lebih dari '+sisa);
			});

			edtwktrstd_create.on("open", function (e, mode, action) {
				$(".modal-dialog").addClass("modal-lg");
				$('div.DTE_Form_Buttons button:eq(2)').hide();
			});

			edtwktrstd_create.on( 'preSubmit', function (e, data, action) {
				if(action != 'remove'){
					jumlah_unit = edtwktrstd_create.field('wktrstd.jumlah_unit').val();
					validasiNumber(
						edtwktrstd_create,
						'wktrstd',
						{
							'jumlah_unit': jumlah_unit
						},
						0,
						'>'
					);

					// console.log(s_jumlah_unit);
					// console.log(min_jumlah_unit);
					sisa = min_jumlah_unit - s_jumlah_unit;

					if (jumlah_unit > sisa) {
						edtwktrstd_create.field('wktrstd.jumlah_unit').error('Jumlah Finalisasi tidak boleh lebih dari '+sisa);
					}
				}

				if ( edtwktrstd_create.inError() ) {
					return false;
				}
			});

			edtwktrstd_create.on('initSubmit', function(e, action) {
				finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtwktrstd_create.field('finish_at').val(finish_at);
			});

			edtwktrstd_create.on( 'postSubmit', function (e, json, data, action, xhr) {
				if (xhr.status == 200) {
					toastr["success"]("Finalisasi Kitting Berhasil","INFO");
				} else {
					toastr["error"]("Finalisasi Kitting Gagal","INFO");
				}
				tblwktxxth.ajax.reload(null,false);
			} );

			edtwktrstd_create.on( 'close', function () {
				edtwktrstd_create.enable();
			} );
		
		tblwktxxth = $('#tblwktxxth').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/wktxxth/wktxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_wktxxth = show_deleted_wktxxth;
					d.start_date = start_date;
					d.end_date = end_date;
				}
			},
			order: [[ 1, "desc" ]],
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
				{ data: "wktxxth.id",visible:false },
				{ data: "wktxxth.kode" },
				{ data: "wktxxth.tanggal" },
				{ data: "wpmxxmh.nama" },
				{ 
					data: "wktxxth.is_crossdocking",
					...renderYaTidak()
				},
				{ 
					data: "wktxxth.transaction_state",
					...renderTransactionStatus()
				},
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_wktxxth';
					$table       = 'tblwktxxth';
					$edt         = 'edtwktxxth';
					$show_status = '_wktxxth';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= ['sf', 'sp', 'sb'];
					$arr_buttons_action 	= ['create', 'edit', 'remove_hd', 'confirm', 'nonaktif_hd', 'close', 'view', 'log','noaction'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
				// END breaking generate button
				{
					text: '<i class="fa fa-google"></i>',
					name: 'btnGenerateLPN',
					className: 'btn btn-xs btn-outline',
					titleAttr: 'Generate LPN',
					action: function ( e, dt, node, config ) {
						e.preventDefault(); 
						var date = new Date().getTime();
						var timestamp = moment(timestamp).format('YYYY-MM-DD HH:mm:ss');
						console.log(uniqueToken);
						toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")

						$.ajax( {
							url: "../../models/wktxxth/wktxxth_fn_gen_lpn.php",
							dataType: 'json',
							type: 'POST',
							data: {
								id_transaksi_h: id_transaksi_h,
								uniqueToken: uniqueToken,
								timestamp: timestamp
							},
							success: function ( json ) {
								status_code = json.data.status_code;
								if (status_code == 200) {
									toastr[json.data.type_message](json.data.message,"INFO");
									cekBelumConfirm();
									tblwktxxth.ajax.reload(null, false);
									tblwktlptd.ajax.reload(null, false);
									tblwktxxth.rows().deselect();
								}
							}
						} );
					}
				},
				{
					text: '<i class="fa fa-refresh"></i>',
					name: 'btnReset',
					className: 'btn btn-xs btn-outline',
					titleAttr: 'Reset',
					action: function ( e, dt, node, config ) {
						e.preventDefault(); 
						var date = new Date().getTime();
						var timestamp = moment(timestamp).format('YYYY-MM-DD HH:mm:ss');
						console.log(uniqueToken);
						toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
						
						$.ajax( {
							url: "../../models/wktxxth/wktxxth_fn_reset_lpn.php",
							dataType: 'json',
							type: 'POST',
							data: {
								id_transaksi_h: id_transaksi_h,
								uniqueToken: uniqueToken,
								timestamp: timestamp
							},
							success: function ( json ) {
								status_code = json.data.status_code;
								if (status_code == 200) {
									toastr[json.data.type_message](json.data.message,"INFO");
									cekBelumConfirm();
									tblwktxxth.ajax.reload(null, false);
									tblwktlptd.ajax.reload(null, false);
									tblwktxxth.rows().deselect();
								}
							}
						} );
					}
				},
				{
					extend: 'create',
					text: 'Finalisasi',
					name: 'btnFinalisasi',
					className: 'btn btn-xs btn-outline',
					editor: edtwktrstd_create, 
					titleAttr: 'Finalisasi',
				},
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
				if ( data.wktxxth.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.wktxxth.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblwktxxth.searchPanes.container().appendTo('#spwktxxth');
		tblwktxxth.searchBuilder.container().appendTo( '#sbwktxxth' );
		
		tblwktxxth.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblwktittd, tblwktlptd];
			CekInitHeaderHD(tblwktxxth, tbl_details);
			tblwktxxth.button('btnGenerateLPN:name').disable();
			tblwktxxth.button('btnFinalisasi:name').disable();
			tblwktxxth.button('btnReset:name').disable();
			tblwktxxth.button('btnReset:name')
				.nodes()
				.css( 'display', 'none' );
			tblwktxxth.button('btnEdit:name').disable();
		} );
		
		tblwktxxth.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('wktxxth');
			
			id_iimxxmh_old_kitting      = wktxxth_data.id_iimxxmh;
			id_iumxxmh_unit_old_kitting      = wktxxth_data.id_iumxxmh_unit;
			is_generate_lpn      = wktxxth_data.is_generate_lpn;
			id_wpmxxmh_old      = wktxxth_data.id_wpmxxmh;
			id_iwhxxmh_old = wktxxth_data.id_iwhxxmh;
			id_wloxxmh_old = wktxxth_data.id_wloxxmh_out;
			id_wloxxmh_out_old = wktxxth_data.id_wloxxmh_out;
			// atur hak akses
			tbl_details = [tblwktittd, tblwktlptd];
			CekSelectHeaderHD(tblwktxxth, tbl_details);
			uniqueToken = 'wktxxth_id_'+id_transaksi_h;

			
			// console.log(transaction_state);
			if (transaction_state != 0) {
				tblwktxxth.button('btnGenerateLPN:name').disable();
				tblwktxxth.button('btnReset:name').disable();
			} else {
				if (is_generate_lpn == 1) {
					tblwktxxth.button('btnReset:name')
						.nodes()
						.css( 'display', 'block' );
					tblwktxxth.button('btnGenerateLPN:name')
						.nodes()
						.css( 'display', 'none' );
					tblwktxxth.button('btnGenerateLPN:name').disable();
					tblwktxxth.button('btnReset:name').enable();
					tblwktittd.button('btnCreate:name').disable();
					tblwktittd.button('btnRemove:name').disable();
					tblwktxxth.button('btnEdit:name').disable();
				} else {
					tblwktxxth.button('btnReset:name')
						.nodes()
						.css( 'display', 'none' );
					tblwktxxth.button('btnGenerateLPN:name')
						.nodes()
						.css( 'display', 'block' );
					tblwktxxth.button('btnGenerateLPN:name').enable();
					tblwktxxth.button('btnReset:name').disable();
					tblwktittd.button('btnCreate:name').enable();
					tblwktittd.button('btnRemove:name').disable();
					tblwktxxth.button('btnEdit:name').enable();
				}
			}
			cekBelumConfirm();
			cekDonePicking();
		} );
		
		tblwktxxth.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('wktxxth');
			is_generate_lpn = 0, id_iwhxxmh_old = 0, id_wloxxmh_old = 0;
			id_iwhxxmh = 0;
			id_iimxxmh_old_kitting = 0;
			id_iumxxmh_unit_old_kitting = 0;
			id_wpmxxmh_old = 0;
			id_wloxxmh_out_old = 0;
			uniqueToken = '';

			// atur hak akses
			tbl_details = [tblwktittd, tblwktlptd];
			CekDeselectHeaderHD(tblwktxxth, tbl_details);
			tblwktxxth.button('btnGenerateLPN:name').disable();
			tblwktxxth.button('btnReset:name').disable();

			tblwktxxth.button('btnReset:name')
				.nodes()
				.css( 'display', 'none' );
			tblwktxxth.button('btnGenerateLPN:name')
				.nodes()
				.css( 'display', 'block' );
			tblwktxxth.button('btnEdit:name').disable();
			tblwktxxth.button('btnFinalisasi:name').disable();
		} );
		// END wktxxth

		// BEGIN wktittd
		edtwktittd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/wktxxth/wktittd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_wktittd = show_deleted_wktittd;
					d.id_wktxxth = id_wktxxth;
				}
			},
			table: "#tblwktittd",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "wktittd.start_at",
					name: "wktittd.start_at",
					type: "hidden"
				},	
				{
					label: "wktittd.finish_at",
					name: "wktittd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "wktittd",
					type: "hidden"
				},	
				{
					label: "wktittd.transaction_state",
					name: "wktittd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_wktxxth",
					name: "wktittd.id_wktxxth",
					type: "hidden"
				},	
				{
					label: "Item <sup class='text-danger'>*<sup>",
					name: "wktittd.id_iimxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/iimxxmh/iimxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_iimxxmh_old: id_iimxxmh_old,
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
					}
				}, 	
				{
					label: "UoM <sup class='text-danger'>*<sup>",
					name: "wktittd.id_iumxxmh_unit",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/iumxxmh/iumxxmh_fn_opt_iimummd.php",
							dataType: 'json',
							data: function (params) {
								id_iimxxmh = edtwktittd.field('wktittd.id_iimxxmh').val();
								var query = {
									id_iimxxmh: id_iimxxmh,
									id_iumxxmh_unit_old: id_iumxxmh_unit_old,
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
					}
				},	
				{
					label: "Quantity <sup class='text-danger'>*<sup>",
					name: "wktittd.jumlah_unit",
					fieldInfo: "Harap isi jumlah per satu paket. Contoh: Indomie 1, Kopi 2"
				}, 	
				{
					label: "Keterangan",
					name: "wktittd.keterangan",
					type: "textarea"
				}
			]
		} );
			
		edtwktittd.field('wktittd.jumlah_unit').input().addClass('text-right');
		
		edtwktittd.on( 'preOpen', function( e, mode, action ) {
			edtwktittd.field('wktittd.id_wktxxth').val(id_wktxxth);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtwktittd.field('wktittd.start_at').val(start_at);
			
			if(action == 'create'){
				tblwktittd.rows().deselect();
			}
		});

		edtwktittd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});

		edtwktittd.on( 'preSubmit', function (e, data, action) {
			if(action == 'create'){
				id_transaksi = 0;
			}else{
				id_transaksi = id_wktittd;
			}
			
			if(action != 'remove'){
				
				id_iumxxmh_unit = edtwktittd.field('wktittd.id_iumxxmh_unit').val();
				id_iimxxmh      = edtwktittd.field('wktittd.id_iimxxmh').val();
				jumlah_unit     = edtwktittd.field('wktittd.jumlah_unit').val();

				validasiRequired(
					edtwktittd,
					'wktittd',
					{
						'id_iumxxmh_unit': id_iumxxmh_unit,
						'id_iimxxmh': id_iimxxmh,
					}
				);
				
				validasiNumber(
					edtwktittd,
					'wktittd',
					{
						'jumlah_unit': jumlah_unit
					},
					0,
					'>'
				);
				
			}
			
			if ( edtwktittd.inError() ) {
				return false;
			}
		});

		edtwktittd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtwktittd.field('wktittd.finish_at').val(finish_at);
		});
			
		edtwktittd.on( 'postSubmit', function (e, json, data, action, xhr) {
			if (action != 'remove') {
				id_transaksi = json.data[0].wktittd.id;
            	konversiUom('wktittd', id_transaksi );

				tblwktittd.rows().deselect();
			}
			
			tblwktxxth.ajax.reload(null, false);
			tblwktittd.ajax.reload(null, false);
		} );

		edtwktittd.on( 'close', function () {
			edtwktittd.enable();
		} );
		
		tblwktittd = $('#tblwktittd').DataTable( {
			ajax: {
				url: "../../models/wktxxth/wktittd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_wktittd = show_deleted_wktittd;
					d.id_wktxxth = id_wktxxth;
				}
			},
			order: [[ 2, "asc" ]],
			columns: [
				{ data: "wktittd.id",visible:false },
				{ data: "wktittd.id_wktxxth",visible:false },
				{ data: "iimxxmh.kode" },
				{ data: "iimxxmh.nama" },
				{ data: "iumxxmh.nama" },
				{ 
					data: "wktittd.jumlah_unit",
					...renderNumber( 0, "")
				},
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_wktittd';
					$table       = 'tblwktittd';
					$edt         = 'edtwktittd';
					$show_status = '_wktittd';
					$table_name  = $nama_tabels_d[0];

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= [];
					$arr_buttons_action 	= ['create', 'edit', 'remove','view', 'log','noactionD'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php';
				?>
				// END breaking generate button
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
				// if ( data.wktittd.subtotal_jumlah_unit == 0 ) {
				// 	// console.log($('td:eq(8)', row));
				// 	$('td:eq(4)', row).addClass('bg-warning');
				// } else if ( data.wktittd.subtotal_jumlah_unit != data.wktittd.jumlah_unit ) {
				// 	$('td:eq(4)', row).addClass('bg-warning');
				// }
			},
			footerCallback: function ( row, data, start, end, display ) {
				var api       	= this.api(), data;
				var c_item 		= api.column(0).data().count();

				$( '#c_item' ).html( "Total Item(s): " + c_item);
			}
		} );

		tblwktittd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tblwktittd, 1 );
			CekDrawDetailHDFinal(tblwktxxth);
		} );

		tblwktittd.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSetD('wktittd');
			
			// atur hak akses
			CekSelectDetailHD( tblwktittd );

			id_iimxxmh          = wktittd_data.id_iimxxmh;
			id_iimxxmh_old      = wktittd_data.id_iimxxmh;
			id_iumxxmh_unit_old = wktittd_data.id_iumxxmh_unit;
			
			if (is_generate_lpn == 1) {
				tblwktittd.button('btnEdit:name').disable();
				tblwktittd.button('btnRemove:name').disable();
			} else {
				tblwktittd.button('btnEdit:name').enable();
				tblwktittd.button('btnRemove:name').disable();
			}
		} );

		tblwktittd.on( 'deselect', function() {
			// reset variable standar framework
			siVarResetD('wktittd');
			id_iimxxmh_old = 0;
			id_iumxxmh_unit_old= 0;
			
			// atur hak akses
			CekDeselectDetailHD( tblwktittd );
		} );
		// END wktittd
		
		tblwktlptd = $('#tblwktlptd').DataTable( {
			ajax: {
				url: "../../models/wktxxth/wktlptd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_wktlptd = show_deleted_wktlptd;
					d.id_wktxxth = id_wktxxth;
				}
			},
			responsive: false,
			order: [[ 1, "asc" ]],
			columns: [
				{ data: "wktlptd.id",visible:false },
				{ data: "wktlptd.id_wktxxth",visible:false },
				{ data: "wpcxxth.kode" },
				{ data: "wktlptd.wlpxxmh_kode" },
				{ data: "wloxxmh.nama" },
				{ data: "iimxxmh.kode",visible:false },
				{ data: "iimxxmh.nama",visible:false },
				{ 
					data: "wktlptd.jumlah_terkecil",
					...renderNumber( 0, "")
				},
				{ data: "uom_terkecil.kode" },
				{ 
					data: "wktlptd.jumlah_default",
					...renderNumber(2)
				},
				{ data: "uom_default.kode" },
				{ data: "wktlptd.batch_number" },
				{ data: "wktlptd.expired_date" },
			],
			rowGroup: {
				dataSrc: function (row) {
					return  row.iimxxmh.kode+' - '+row.iimxxmh.nama
				},
				endRender: function (rows, group) {
					var sum_terkecil = rows
						.data()
						.pluck('wktlptd.jumlah_terkecil')
						.map(function (terkecil) {
							return parseFloat(terkecil) || 0;
						})
						.reduce(function (a, b) {
							return a + b;
						}, 0);
					
					sum_terkecil = $.fn.dataTable.render.number(',', '.', 0, '').display(sum_terkecil);
					
					var sum_default = rows
						.data()
						.pluck('wktlptd.jumlah_default')
						.map(function (def) {
							return parseFloat(def) || 0;
						})
						.reduce(function (a, b) {
							return a + b;
						}, 0);
					
					sum_default = $.fn.dataTable.render.number(',', '.', 2, '').display(sum_default);

					return $('<tr/>')
						.append('<td class="font-bold text-success">Total</td>')
						.append('<td></td>')
						.append('<td></td>')
						// .append('<td></td>')
						// .append('<td></td>')
						.append('<td class="text-right font-bold bg-success">' + sum_terkecil + '</td>')
						.append('<td></td>')
						.append('<td class="text-right font-bold bg-success">' + sum_default + '</td>')
						.append('<td></td>')
						.append('<td></td>')
						.append('<td></td>')
						;
				}
			},
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_wktlptd';
					$table       = 'tblwktlptd';
					$edt         = 'edtwktlptd';
					$show_status = '_wktlptd';
					$table_name  = $nama_tabels_d[1];

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= [];
					$arr_buttons_action 	= [];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php';
				?>
				// END breaking generate button
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
			},
			footerCallback: function ( row, data, start, end, display ) {
				var api = this.api();
				var numFormat = $.fn.dataTable.render.number( '\,', '.', 0, '' ).display; 
				
				for (var i = 7; i <= 9; i+=2) {
					if (i == 9) {
						numFormat = $.fn.dataTable.render.number( '\,', '.', 2, '' ).display; 
					}
					var columnIndex = i;
					var sum_all = api.column(columnIndex).data().sum();
					// Bisa dilakukan sum berdasarkan paginasi (sum per paginasi / tidak sum semua data) dengan menambahkan { page: 'current' }
					var sum = api.column(columnIndex, { page: 'current' }).data().sum();
					$('#s_' + columnIndex).html(numFormat(sum_all));

					// console.log('Number of Pages: ' + api.page.info().pages);
				}
			}
		} );

		tblwktlptd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tblwktlptd, 1 );
			CekDrawDetailHDFinal(tblwktxxth);
		} );

		tblwktlptd.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSetD('wktlptd');
			
			// atur hak akses
			CekSelectDetailHD( tblwktlptd );

			id_iimxxmh          = wktlptd_data.id_iimxxmh;
			id_iimxxmh_old      = wktlptd_data.id_iimxxmh;
			id_iumxxmh_unit_old = wktlptd_data.id_iumxxmh_unit;
		} );

		tblwktlptd.on( 'deselect', function() {
			// reset variable standar framework
			siVarResetD('wktlptd');
			id_iimxxmh_old = 0;
			id_iumxxmh_unit_old= 0;
			
			// atur hak akses
			CekDeselectDetailHD( tblwktlptd );
		} );
		// END wktittd

		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
			},
			submitHandler: function(frmFilter) {
				start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
				tblwktxxth.rows().deselect();
				tblwktxxth.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSFwktxxth').modal('toggle');
			}, false);
				return false;
			}
		});
		
	} );// end of document.ready
	
</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
