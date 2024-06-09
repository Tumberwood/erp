<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'htoxxth';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'htoemtd';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">

				<div class="modal" id="modalSFhtoxxth" tabindex="-1" role="dialog" aria-hidden="true">
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
                    <table id="tblhtoxxth" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Kode</th>
                                <th>Tanggal</th>
                                <th>Keterangan</th>
                                <th>TX</th>
                                <th>Approval</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

	<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 p-w-xs">
		<div class="tabs-container">
			<ul class="nav nav-tabs" role="tablist">
				<li><a class="nav-link active" data-toggle="tab" href="#tabhtoemtd_1"> Employee</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabhtoemtd_1" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblhtoemtd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th rowspan=2 class="text-center">ID</th>
										<th rowspan=2 class="text-center">id_htoxxth</th>
										<th data-priority="1" rowspan=2 class="text-center">Tipe</th>
										<th data-priority="2" rowspan=2 class="text-center">Karyawan</th>
										<th colspan=2 class="text-center">Jam Lembur</th>
										<th rowspan=2 class="text-center">Istirahat</th>	
										<th data-priority="3" rowspan=2 class="text-center">Durasi (Jam)</th>	
										<th rowspan=2 class="text-center">Keterangan</th>
										<th data-priority="4" rowspan=2 class="text-center">Valid</th>
									</tr>
									<tr>
										<th class = "text-center">Mulai</th>
										<th class = "text-center">Selesai</th>
									</tr>
								</thead>
								<tfoot>
									<tr>
										<th></th>
										<th></th>
										<th>Total</th>
										<th></th>
										<th></th>
										<th></th>
										<th></th>
										<th id="sum_durasi_lembur_jam"></th>
										<th></th>
										<th></th>
									</tr>
								</tfoot>
							</table>
						</div> <!-- end of table -->

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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/htoxxth/fn/htoxxth_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edthtoxxth, tblhtoxxth, show_deleted_htoxxth = 0, id_htoxxth;
	var edthtoemtd, tblhtoemtd, show_deleted_htoemtd = 0, id_htoemtd;
	// ------------- end of default variable
	
	var id_holxxmd_old = 0, id_heyxxmh_old = 0;
	var id_heyxxmh = 0, id_htotpmh_old  = 0, id_hemxxmh_old = 0;
	var tanggal, is_valid_checkclock;

	kategori_dokumen = "";
	kategori_dokumen_value = "";

	// get tableRelation
	tableRelation('htoxxth');

	$(document).ready(function() {
		start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		
		// BEGIN htoxxth
		edthtoxxth = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/htoxxth/htoxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_htoxxth = show_deleted_htoxxth;
					d.start_date = start_date;
					d.end_date = end_date;
				}
			},
			table: "#tblhtoxxth",
			fields: [ 
				{
					label: "kategori_dokumen",
					name: "kategori_dokumen",
					type: "hidden"
				},	{
					label: "kategori_dokumen_value",
					name: "kategori_dokumen_value",
					type: "hidden"
				},	{
					label: "field_tanggal",
					name: "field_tanggal",
					type: "hidden"
				},
				{
					label: "htoxxth.start_at",
					name: "htoxxth.start_at",
					type: "hidden"
				},	
				{
					label: "htoxxth.finish_at",
					name: "htoxxth.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "htoxxth",
					type: "hidden"
				},	
				{
					label: "htoxxth.transaction_state",
					name: "htoxxth.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: "Tanggal <sup class='text-danger'>*<sup>",
					name: "htoxxth.tanggal",
					type: "datetime",
					def: function () { 
						return moment($('#end_date').val()).format('DD MMM YYYY'); 
					},
					format: 'DD MMM YYYY'
				},		
				{
					label: "Keterangan",
					name: "htoxxth.keterangan",
					type: "textarea"
				}
			]
		} );
		
		edthtoxxth.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthtoxxth.field('htoxxth.start_at').val(start_at);

			if(action == 'create'){
				tblhtoxxth.rows().deselect();
			}
		});

		edthtoxxth.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			edtFormButtonSaveConfirmHD();
		});
		
		edthtoxxth.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				tanggal = edthtoxxth.field('htoxxth.tanggal').val();

				validasiRequired(
					edthtoxxth,
					'htoxxth',
					{
						'tanggal': tanggal,
					}
				);
			}
			
			if ( edthtoxxth.inError() ) {
				return false;
			}
		});

		edthtoxxth.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthtoxxth.field('htoxxth.finish_at').val(finish_at);
		});
		
		edthtoxxth.on( 'postSubmit', function (e, json, data, action, xhr) {
			tblhtoxxth.rows().deselect();
			tblhtoxxth.ajax.reload(null, false);
		} );

		edthtoxxth.on( 'close', function () {
			edthtoxxth.enable();
		} );
		
		tblhtoxxth = $('#tblhtoxxth').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/htoxxth/htoxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_htoxxth = show_deleted_htoxxth;
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
					targets: [1,2,4,5]
				},
				{
					searchPanes:{
						show: false,
					},
					targets: '_all'
				}
			],
			columns: [
				{ data: "htoxxth.id",visible:false },
				{ data: "htoxxth.kode" },
				{ data: "htoxxth.tanggal" },
				{ data: "htoxxth.keterangan" },
				{ 
					data: "htoxxth.transaction_state" ,
					...renderTransactionStatus()
				},
				{ 
					data: "htoxxth.approval_state" ,
					...renderApprovalStatus()
				}
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_htoxxth';
					$table       = 'tblhtoxxth';
					$edt         = 'edthtoxxth';
					$show_status = '_htoxxth';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= ['sf', 'sp', 'sb'];
					$arr_buttons_action 	= ['create', 'edit', 'remove_hd', 'confirm', 'nonaktif_hd', 'close', 'view', 'log','noaction'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
				// END breaking generate button
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
				if ( data.htoxxth.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.htoxxth.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblhtoxxth.searchPanes.container().appendTo('#sphtoxxth');
		tblhtoxxth.searchBuilder.container().appendTo( '#sbhtoxxth' );
		
		tblhtoxxth.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblhtoemtd];
			CekInitHeaderHD(tblhtoxxth, tbl_details);
		} );
		
		tblhtoxxth.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('htoxxth');
			tanggal    = htoxxth_data.tanggal;
			
			// atur hak akses
			tbl_details = [tblhtoemtd];
			CekSelectHeaderHD(tblhtoxxth, tbl_details);
		} );
		
		tblhtoxxth.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('htoxxth');

			// atur hak akses
			tbl_details = [tblhtoemtd];
			CekDeselectHeaderHD(tblhtoxxth, tbl_details);
		} );
		// END htoxxth

		// BEGIN htoemtd
		edthtoemtd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/htoxxth/htoemtd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_htoemtd = show_deleted_htoemtd;
					d.id_htoxxth = id_htoxxth;
				}
			},
			table: "#tblhtoemtd",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "htoemtd.start_at",
					name: "htoemtd.start_at",
					type: "hidden"
				},	
				{
					label: "htoemtd.finish_at",
					name: "htoemtd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "htoemtd",
					type: "hidden"
				},	
				{
					label: "htoemtd.transaction_state",
					name: "htoemtd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_htoxxth",
					name: "htoemtd.id_htoxxth",
					type: "hidden"
				},	
				{
					label: "Tipe <sup class='text-danger'>*</sup>",
					name: "htoemtd.id_htotpmh",
					id: "select2_tipe", //tambahkan id di select2nya
					type: "select2",
					opts: {
						placeholder: "Select",
						allowClear: true,
						multiple: false,
						async: false,
						ajax: {
							url: "../../models/htotpmh/htotpmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_htotpmh_old: id_htotpmh_old,
									search: params.term || '',
									page: params.page || 1
								};
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
									$('#select2_tipe').empty().select2({ data: options });
								} else {
									$('#select2_tipe').append(new Option(options[1].text, options[1].id, false, false)).trigger('change');
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
						}
					}
				},

				{
					label: "Karyawan <sup class='text-danger'>*<sup>",
					name: "htoemtd.id_hemxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/hemxxmh/hemxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_hemxxmh_old: id_hemxxmh_old,
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
					label: "Jadwal",
					name: "jadwal",
					type: "readonly"
				},	
				{
					label: "Jam Mulai <sup class='text-danger'>*<sup>",
					name: "htoemtd.jam_awal",
					type: "datetime",
					format: 'HH:mm'
				},	
				{
					label: "Jam Selesai <sup class='text-danger'>*<sup>",
					name: "htoemtd.jam_akhir",
					type: "datetime",
					format: 'HH:mm'
				},	
				{
					label: "Istirahat",
					name: "htoemtd.is_istirahat",
					type: "select",
					options: [
						{ "label": "Ya", "value": 1 },
						{ "label": "TI", "value":2 },
						{ "label": "Tidak", "value": 0 }
					]
				}, 	
				{
					label: "Checkclock Valid",
					name: "htoemtd.is_valid_checkclock",
					type: "readonly"
				},
				{
					label: "Keterangan",
					name: "htoemtd.keterangan",
					type: "textarea"
				}
			]
		} );
			
		edthtoemtd.on( 'preOpen', function( e, mode, action ) {
			edthtoemtd.field('htoemtd.id_htoxxth').val(id_htoxxth);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthtoemtd.field('htoemtd.start_at').val(start_at);
			
			if(action == 'create'){
				edthtoxxth.field('field_tanggal').val('tanggal');
				tblhtoemtd.rows().deselect();
			}
		});

		edthtoemtd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});
		
		edthtoemtd.dependent( 'htoemtd.id_htotpmh', function ( val, data, callback ) {
			get_htsxxmh();
			return {}
		}, {event: 'keyup change'});

		edthtoemtd.dependent( 'htoemtd.id_hemxxmh', function ( val, data, callback ) {
			get_htsxxmh();
			return {}
		}, {event: 'keyup change'});
		
		edthtoemtd.dependent( 'htoemtd.id_htotpmh', function ( val, data, callback ) {
			id_htotpmh = edthtoemtd.field('htoemtd.id_htotpmh').val();
			if (id_htotpmh == 5 || id_htotpmh == 6 || id_htotpmh == 7){
				// jika tipe overtime = Istirahat1, Istirahat2, atau Istirahat3
				edthtoemtd.field('htoemtd.jam_awal').hide();
				edthtoemtd.field('htoemtd.jam_awal').val('');
				edthtoemtd.field('htoemtd.jam_akhir').hide();
				edthtoemtd.field('htoemtd.jam_akhir').val('');
				edthtoemtd.field('htoemtd.is_istirahat').hide();
				edthtoemtd.field('htoemtd.is_istirahat').val(2);
			}else{
				edthtoemtd.field('htoemtd.jam_awal').show();
				edthtoemtd.field('htoemtd.jam_akhir').show();
				edthtoemtd.field('htoemtd.is_istirahat').show();
			}
			return {}
		}, {event: 'keyup change'});

		edthtoemtd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				id_hemxxmh = edthtoemtd.field('htoemtd.id_hemxxmh').val();
				id_htotpmh = edthtoemtd.field('htoemtd.id_htotpmh').val();
				jam_akhir = edthtoemtd.field('htoemtd.jam_akhir').val();
				jam_awal = edthtoemtd.field('htoemtd.jam_awal').val();

				validasiRequired(
					edthtoemtd,
					'htoemtd',
					{
						'id_hemxxmh': id_hemxxmh,
						'id_htotpmh': id_htotpmh,
						'jam_akhir': jam_akhir,
						'jam_awal': jam_awal,
					}
				);

				validasiUnique(
					action,
					edthtoemtd,
					'htoemtd',
					'id_hemxxmh',
					'id_htoxxth,id_htotpmh,id_hemxxmh',
					id_htoxxth+','+id_htotpmh+','+id_hemxxmh,
					id_htoemtd
				);

				// BEGIN validasi jadwal
				jadwal = edthtoemtd.field('jadwal').val();
				if(jadwal == ''){
					edthtoemtd.field('jadwal').error( 'Jadwal belum ada!' );
				}
				// END validasi jadwal

				// BEGIN validasi checkclock
				check_valid_checkclock();
				if(is_valid_checkclock == 0){
					edthtoemtd.field('htoemtd.is_valid_checkclock').error( 'Checkclock belum valid!' );
				}
				// END validasi checkclock
			}
			
			if ( edthtoemtd.inError() ) {
				return false;
			}
		});

		edthtoemtd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthtoemtd.field('htoemtd.finish_at').val(finish_at);
			
			check_valid_checkclock();
			if(is_valid_checkclock > 0){
				edthtoemtd.field('htoemtd.is_valid_checkclock').val(1);
			}
			// END up
		});
			
		edthtoemtd.on( 'postSubmit', function (e, json, data, action, xhr) {
			tblhtoemtd.ajax.reload(null, false);
			tblhtoxxth.ajax.reload(null, false);
		} );

		edthtoemtd.on( 'close', function () {
			edthtoemtd.enable();
		} );
		
		tblhtoemtd = $('#tblhtoemtd').DataTable( {
			ajax: {
				url: "../../models/htoxxth/htoemtd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_htoemtd = show_deleted_htoemtd;
					d.id_htoxxth = id_htoxxth;
				}
			},
			order: [[ 2, "desc" ]],
			columns: [
				{ data: "htoemtd.id",visible:false },
				{ data: "htoemtd.id_htoxxth",visible:false },
				{ data: "htotpmh.nama"},
				{ data: "hemxxmh_data"},
				{ data: "htoemtd.jam_awal"},
				{ data: "htoemtd.jam_akhir"},
				{ 
					data: "htoemtd.is_istirahat",
					render: function (data){
						if(data == 0){
							return 'Tidak';
						}else if(data == 1){
							return 'Ya';
						}else if(data == 2){
							return 'TI';
						}else{
							return '';
						}
					}
				},
				{ 
					data: "htoemtd.durasi_lembur_jam",
					render: $.fn.dataTable.render.number( ',', '.', 1,'','' ),
					class: "text-right"
				},
				{ data: "htoemtd.keterangan"},
				{ 
					data: "htoemtd.is_valid_checkclock" ,
					render: function (data){
						if (data == 0){
							return '<i class="fa fa-remove text-danger"></i>';
						}else if(data == 1){
							return '<i class="fa fa-check text-navy"></i>';
						}else if(data == 2){
							return '<i class="fa fa-check text-warning"></i>';
						}else{
							return '';
						}
					}
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_htoemtd';
					$table       = 'tblhtoemtd';
					$edt         = 'edthtoemtd';
					$show_status = '_htoemtd';
					$table_name  = $nama_tabels_d[0];

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= [];
					$arr_buttons_action 	= ['create', 'edit', 'remove','view', 'log','noactionD'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php';
				?>
				// END breaking generate button
			],
			initComplete: function() {
			},
			rowCallback: function( row, data, index ) {
			},
			footerCallback: function ( row, data, start, end, display ) {
				var api       = this.api(), data;
				var numFormat = $.fn.dataTable.render.number( '\,', '.', 1, '' ).display; 
				// hitung jumlah 
				sum_durasi_lembur_jam = api.column( 7 ).data().sum();

				// Update footer v1
				$( '#sum_durasi_lembur_jam' ).html( numFormat(sum_durasi_lembur_jam) );
			}
		} );

		tblhtoemtd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tblhtoemtd, 1 );
			CekDrawDetailHDFinal(tblhtoxxth);
		} );

		tblhtoemtd.on( 'select', function( e, dt, type, indexes ) {
			siVarSetD('htoemtd');
			id_hemxxmh_old   = data_htoemtd.id_hemxxmh;
			id_htotpmh_old   = data_htoemtd.id_htotpmh;
			
			// atur hak akses
			CekSelectDetailHD( tblhtoemtd );
		} );

		tblhtoemtd.on( 'deselect', function() {
			siVarResetD('htoemtd');
			id_hemxxmh_old = 0;
			id_htotpmh_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD( tblhtoemtd );
		} );
		// END htoemtd

		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
			},
			submitHandler: function(frmFilter) {
				start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
				tblhtoxxth.rows().deselect();
				tblhtoxxth.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSFhtoxxth').modal('toggle');
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
