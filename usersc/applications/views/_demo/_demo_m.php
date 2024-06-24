<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<link href="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/css/plugins/bootstrapTour/bootstrap-tour.css" rel="stylesheet">

<?php
	$nama_tabel    = '_demo_m';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="modal" id="modalSF_demo_m" tabindex="-1" role="dialog" aria-hidden="true">
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

				<div id="frm_demo_m">
					<div class="panel-body">
						<h4>Jenis Field Input</h4>
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="_demo_m.kode"></editor-field>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="_demo_m.nama"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="_demo_m.is_field"></editor-field>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="_demo_m.id_gctxxmh"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="_demo_m.tanggal"></editor-field>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="_demo_m.tanggaljam"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="_demo_m.jam"></editor-field>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="_demo_m.id_files"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="_demo_m.keterangan"></editor-field>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="_demo_m.notes"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="_demo_m.is_show"></editor-field>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="dependent_field"></editor-field>
							</div>
						</div>
					</div>
				</div>
				<div class="table-responsive">
                    <table id="tbl_demo_m" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Tanggal</th>
                                <th>TX</th>
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
<script src="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/js/plugins/bootstrapTour/bootstrap-tour.js"></script>

<script src="<?=$us_url_root?>usersc/helpers/general_fn.js"></script>
<script src="<?=$us_url_root?>usersc/helpers/validation_fn.js"></script>
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn2.js"></script>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edt_demo_m, tbl_demo_m, show_deleted__demo_m = 0, id__demo_m;
	// ------------- end of default variable

	var id_gctxxmh_old = 0;
	
	// get tableRelation
	tableRelation('_demo_m');

	$(document).ready(function() {
		start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');

		// BEGIN _demo_m
		edt_demo_m = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/_demo/_demo_m.php",
				type: 'POST',
				data: function (d){
					d.show_deleted__demo_m = show_deleted__demo_m;
					d.start_date = start_date;
					d.end_date = end_date;
				}
			},
			table: "#tbl_demo_m",
			template: "#frm_demo_m",
			fields: [ 
				{
					label: "_demo_m.start_at",
					name: "_demo_m.start_at",
					type: "hidden"
				},	
				{
					label: "_demo_m.finish_at",
					name: "_demo_m.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "_demo_m",
					type: "hidden"
				},	
				{
					label: "_demo_m.transaction_state",
					name: "_demo_m.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "Input <sup class='text-danger'>*<sup>",
					name: "_demo_m.kode",
					fieldInfo: "Tanda * berarti wajib diisi"
				}, 	
				{
					label: "Input",
					name: "_demo_m.nama",
					fieldInfo: "Tidak wajib diisi, tanpa tanda *"
				}, 	
				{
					label: "Text Area",
					name: "_demo_m.keterangan",
					type: "textarea"
				},
				{
					label: "Select",
					name: "_demo_m.is_field",
					type: "select",
					placeholder : "Select",
					fieldInfo: "Klik untuk memilih",
					options: [
						{ "label": "Yes", "value": 1 },
						{ "label": "No", "value": 0 }
					]
				},
				{
					label: "Select2",
					name: "_demo_m.id_gctxxmh",
					type: "select2",
					fieldInfo: "Klik untuk memilih, ketik untuk mencari. Contoh: Surabaya",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/core/gctxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_gctxxmh_old: id_gctxxmh_old,
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
					label: "Tanggal",
					name: "_demo_m.tanggal",
					type: "datetime",
					fieldInfo: "Klik untuk memilih",
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
					label: "Tanggal Jam",
					name: "_demo_m.tanggaljam",
					type: "datetime",
					fieldInfo: "Klik untuk memilih",
					def: function () { 
						return new Date(); 
					},
					opts:{
						minDate: new Date('1900-01-01'),
						firstDay: 0
					},
					format: 'DD MMM YYYY HH:mm'
				},
				{
					label: "Jam",
					name: "_demo_m.jam",
					type: "datetime",
					fieldInfo: "Klik untuk memilih",
					def: function () { 
						return new Date(); 
					},
					format: 'HH:mm'
				},
				{
					label: "Quill",
					name: "_demo_m.notes",
					type: "quill",
					toolbar: "#toolbar",
				},
				{
					label: "Upload Image",
					name: "_demo_m.id_files",
					type: "upload",
					fieldInfo: "Upload fie format png, jpg, atau jpeg",
					// display: function ( fileId, counter ) {
					// 	return '<img src="'+edt_demo_m.file( 'files', fileId ).web_path+'"/>';
					// },
					noFileText: 'Belum ada lampiran'
				},
				{
					label: "Show Hide Field",
					name: "_demo_m.is_show",
					type: "select",
					fieldInfo: "Pilih untuk menampilkan atau menyembunyikan field lain",
					placeholder : "Select",
					options: [
						{ "label": "Show", "value": 1 },
						{ "label": "Hide", "value": 0 }
					]
				},
				{
					label: "Dependent Field",
					name: "dependent_field",
					fieldInfo: "Show atau Hide berdasarkan Field lain",
				}
			]
		} );

		edt_demo_m.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edt_demo_m.field('_demo_m.start_at').val(start_at);
			
			if(action == 'create'){
				tbl_demo_m.rows().deselect();
			}else if(action == 'edit'){
				
				if(transaction_state == 0){
					edt_demo_m.field('_demo_m.kode').enable();
				}else{
					edt_demo_m.field('_demo_m.kode').disable();
				}
			}
		});

		edt_demo_m.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-xl");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edt_demo_m.dependent( '_demo_m.is_show', function ( val, data, callback ) {
			if(val == 1){
				edt_demo_m.field('dependent_field').show();
			}else{
				edt_demo_m.field('dependent_field').hide();
			}
			return {}
		}, {event: 'keyup change'});

		edt_demo_m.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				kode = edt_demo_m.field('_demo_m.kode').val();

				validasiRequired(
					edt_demo_m,
					'_demo_m',
					{
						'kode': kode
					}
				);

				validasiUnique(
					action,
					edt_demo_m,
					'_demo_m',
					'kode',
					'kode',
					'"'+kode+'"',
					id__demo_m
				);

			}
			
			if ( edt_demo_m.inError() ) {
				return false;
			}
		});
		
		edt_demo_m.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edt_demo_m.field('_demo_m.finish_at').val(finish_at);
		});

		edt_demo_m.on( 'close', function () {
			edt_demo_m.enable();
		} );

		tbl_demo_m = $('#tbl_demo_m').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/_demo/_demo_m.php",
				type: 'POST',
				data: function (d){
					d.show_deleted__demo_m = show_deleted__demo_m;
					d.start_date = start_date;
					d.end_date = end_date;
				}
			},
			order: [[ 1, "asc" ]],
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
				{ data: "_demo_m.id",visible:false },
				{ data: "_demo_m.kode" },
				{ data: "_demo_m.nama" },
				{ data: "_demo_m.tanggal" },
				{ 
					data: "_demo_m.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id__demo_m';
					$table       = 'tbl_demo_m';
					$edt         = 'edt_demo_m';
					$show_status = '__demo_m';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= ['sf','sp', 'sb'];
					$arr_buttons_action 	= ['create', 'edit', 'remove', 'confirm', 'nonaktif_h', 'close', 'view', 'log','noaction'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
				// END breaking generate button
				// {
				// 	text: '<i class="fa fa-icon">Title</i>',
				// 	name: 'btnCustom',
				// 	className: 'btn btn-outline',
				// 	titleAttr: '',
				// 	action: function ( e, dt, node, config ) {
				// 		e.preventDefault();
				// 		tour.restart();
				// 	}
				// },
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
				if ( data._demo_m.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data._demo_m.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tbl_demo_m.searchPanes.container().appendTo('#sp_demo_m');
		tbl_demo_m.searchBuilder.container().appendTo( '#sb_demo_m' );
		
		tbl_demo_m.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tbl_demo_m);
		} );
		
		tbl_demo_m.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('_demo_m');
			id_gctxxmh_old = _demo_m_data.id_gctxxmh;
			// atur hak akses
			CekSelectHeaderH(tbl_demo_m);
		} );

		tbl_demo_m.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('_demo_m');
			id_gctxxmh_old = 0;

			// atur hak akses
			CekDeselectHeaderH(tbl_demo_m);
		} );

		// END _demo_m

		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
			},
			submitHandler: function(frmFilter) {
				start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
				tbl_demo_m.rows().deselect();
				tbl_demo_m.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSF_demo_m').modal('toggle');
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
