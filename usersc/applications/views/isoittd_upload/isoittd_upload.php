<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'isoittd_upload';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'isoittd_upload_fisik';
?>

<!-- begin content here -->

<div id="tabel_atas">
	<div class="row">
		<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12 p-w-xs">
			<div class="ibox ">
				<div class="ibox-content">

					<div class="modal" id="modalSFisoittd_upload" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-lg">
							<div class="modal-content animated bounceInRight">
								<form class="form-horizontal" id="frmFilter">
									<div class="modal-header">
										<h4 class="modal-title">Filter</h4>
									</div>
									<div class="modal-body">
										<div class="form-group row">
											<label class="col-lg-2 col-md-2">Kode</label>
											<div class="col-lg-8 col-sm-8">
												<select class="form-control" id="selectKode" name="selectKode" multiple="multiple"></select>
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

					<div class="modal" id="modalUpload" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-lg">
							<div class="modal-content animated bounceInRight">
								<form class="form-horizontal" id="frmUpload" enctype="multipart/form-data">
									<div class="modal-header">
										<h4 class="modal-title">Upload Excel Transaksi In & Transaksi Out</h4>
									</div>
									<div class="modal-body">
										<div class="form-group row">
											<label class="col-lg-2 col-form-label">File Excel</label>
											<div class="col-sm-4">
												<div class="input-group">
													<input type="file" name="filename" class="form-control" id="frmUploadExcel" accept=".xls,.xlsx">
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

					<!-- start Custom Form Datatables Editor -->
					<div id="custom_isoittd_upload">
						<div class="panel-body">
							<div class="row">
								<div class="col-lg-6">
									<editor-field name="isoittd_upload.select_item"></editor-field>
									<editor-field name="isoittd_upload.kode"></editor-field>
								</div>
								<div class="col-lg-6">
									<editor-field name="isoittd_upload.nama"></editor-field>
									<editor-field name="isoittd_upload.select_satuan"></editor-field>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<editor-field name="isoittd_upload.select_lokasi"></editor-field>
									<editor-field name="isoittd_upload.satuan"></editor-field>
								</div>
								<div class="col-lg-6">
									<editor-field name="isoittd_upload.lokasi"></editor-field>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<editor-field name="isoittd_upload.jumlah_terkecil"></editor-field>
								</div>
								<div class="col-lg-6">
									<editor-field name="isoittd_upload.fisik"></editor-field>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<editor-field name="isoittd_upload.transaksi_in"></editor-field>
								</div>
								<div class="col-lg-6">
									<editor-field name="isoittd_upload.transaksi_out"></editor-field>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<editor-field name="isoittd_upload.batch_number"></editor-field>
								</div>
								<div class="col-lg-6">
									<editor-field name="isoittd_upload.lpn"></editor-field>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<editor-field name="isoittd_upload.expired_date"></editor-field>
								</div>
								<div class="col-lg-6">
									<editor-field name="isoittd_upload.keterangan"></editor-field>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<editor-field name="isoittd_upload.alasan_skip"></editor-field>
								</div>
								<div class="col-lg-6">
									<editor-field name="isoittd_upload.id_files_skip"></editor-field>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<editor-field name="isoittd_upload.id_files_pointer"></editor-field>
								</div>
								<div class="col-lg-6">
									<editor-field name="isoittd_upload.keterangan_pointer"></editor-field>
								</div>
							</div>
						</div>
					</div>
					<div id="custom_isoittd_upload_duplicate">
						<div class="panel-body">
							<div class="row">
								<div class="col-lg-6">
									<editor-field name="isoittd_upload.select_item"></editor-field>
									<editor-field name="isoittd_upload.kode"></editor-field>
								</div>
								<div class="col-lg-6">
									<editor-field name="isoittd_upload.nama"></editor-field>
									<editor-field name="isoittd_upload.select_satuan"></editor-field>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<editor-field name="isoittd_upload.select_lokasi"></editor-field>
									<editor-field name="isoittd_upload.satuan"></editor-field>
								</div>
								<div class="col-lg-6">
									<editor-field name="isoittd_upload.lokasi"></editor-field>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<editor-field name="isoittd_upload.jumlah_terkecil"></editor-field>
								</div>
								<div class="col-lg-6">
									<editor-field name="isoittd_upload.fisik"></editor-field>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<editor-field name="isoittd_upload.transaksi_in"></editor-field>
								</div>
								<div class="col-lg-6">
									<editor-field name="isoittd_upload.transaksi_out"></editor-field>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<editor-field name="isoittd_upload.batch_number"></editor-field>
								</div>
								<div class="col-lg-6">
									<editor-field name="isoittd_upload.lpn"></editor-field>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<editor-field name="isoittd_upload.expired_date"></editor-field>
								</div>
								<div class="col-lg-6">
									<editor-field name="isoittd_upload.keterangan"></editor-field>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<editor-field name="isoittd_upload.id_files_skip"></editor-field>
								</div>
								<div class="col-lg-6">
									<editor-field name="isoittd_upload.id_files_pointer"></editor-field>
								</div>
							</div>
						</div>
					</div>
					<!-- end Custom Form Datatables Editor -->
					<div class="table-responsive">
						<table id="tblisoittd_upload" class="table table-striped table-bordered table-hover nowrap" width="100%">
							<thead>
								<tr>
									<th>ID</th>
									<th>Hitung</th>
									<th>Loc</th>
									<th>LPN</th>
									<th>SKU</th>
									<th>Name</th>
									<th>Batch</th>
									<th>ED</th>
									<th>UoM</th>
									<th>Quantity</th>
									<th>Fisik</th>
									<th>Selisih</th>
									<th>Transaksi In</th>
									<th>Transaksi Out</th>
									<th>Selisih Final</th>
									<th>SKIP</th>
									<!-- <th>Location Zone</th> -->
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</div>
		
		<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 p-w-xs">
			<div class="tabs-container">
				<ul class="nav nav-tabs" role="tablist">
					<li><a class="nav-link active" data-toggle="tab" href="#tabisoittd_upload_fisik_1"> Fisik</a></li>
					<!-- <li><a class="nav-link" data-toggle="tab" href="#tabpsuctmd"> Kontak</a></li> -->
				</ul>
				<div class="tab-content">
					<div role="tabpanel" id="tabisoittd_upload_fisik_1" class="tab-pane active">
						<div class="panel-body">
							<div class="table-responsive">
								<table id="tblisoittd_upload_fisik" class="table table-striped table-bordered table-hover nowrap" width="100%">
									<thead>
										<tr>
											<th>ID</th>
											<th>id_isoittd_upload</th>
											<th>Fisik</th>
										</tr>
									</thead>
								</table>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
 <!-- end of right col -->
</div> <!-- end of right col -->

<?php
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_modal_log.php';
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_modal_dt_fs.php';
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_toast.php';
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
<!-- <script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn.js"></script> -->

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/isoittd_upload/fn/isoittd_upload_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtisoittd_upload, tblisoittd_upload, show_deleted_isoittd_upload = 0, id_isoittd_upload;
	var edtisoittd_upload_fisik, tblisoittd_upload_fisik, show_deleted_isoittd_upload_fisik = 0, id_isoittd_upload_fisik;
	// ------------- end of default variable
	
	var id_gcpxxmh_old = 0, id_gbrxxmh_old = 0, id_gpvxxmh_old = 0, id_fpytmmh_old = 0;
	var id_isoxxth_upload_old = 0;
	var id_iwhxxmh_old = 0;
	var id_iimxxmh_old = 0;
	var id_wloxxmh_upload_old = 0;
	var id_iimxxmh_upload_old = 0;
	var id_iumxxmh_old = 0;
	var is_skip_select = 0;
	var id_isoxxth_upload_old = 0;
	var id_isoxxth_upload_filter = 0;
	var id_files_pointer_old = 0;
	var id_foto_pointer_old = 0;
	var selectedText = null;
	var start_button = "";
	var company = '';
	var cabang = '';

	// get tableRelation
	tableRelation('isoittd_upload');

	$("#selectKode").select2({
		placeholder : "Select",
		allowClear: true,
		multiple: false,
		ajax: {
			url: "../../models/isoxxth_upload/isoxxth_upload_fn_opt.php",
			dataType: 'json',
			data: function (params) {
				var query = {
					id_isoxxth_upload_old: id_isoxxth_upload_filter,
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
		}
	});

	$(document).ready(function() {
		var selectedOption = $('#selectKode').select2('data')[0];
		if (selectedOption) {
			selectedText = selectedOption.text
		}

		// BEGIN isoittd_upload
		edtisoittd_upload_skip = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/isoittd_upload/isoittd_upload.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_isoittd_upload = show_deleted_isoittd_upload;
					d.id_isoxxth_upload_filter = id_isoxxth_upload_filter;
				}
			},
			table: "#tblisoittd_upload",
			fields: [ 
				{
					label: "isoittd_upload.start_at",
					name: "isoittd_upload.start_at",
					type: "hidden"
				},	
				{
					label: "isoittd_upload.finish_at",
					name: "isoittd_upload.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "isoittd_upload",
					type: "hidden"
				},	
				{
					label: "isoittd_upload.id_isoxxth_upload",
					name: "isoittd_upload.id_isoxxth_upload",
					type: "hidden"
				},
				{
					label: "isoittd_upload.transaction_state",
					name: "isoittd_upload.transaction_state",
					type: "hidden",
					def: 1
				},
				{
					label: "Transaksi In",
					name: "isoittd_upload.transaksi_in",
					type: "hidden"
				}, 	
				
				{
					label: "Transaksi Out",
					name: "isoittd_upload.transaksi_out",
					type: "hidden"
				}, 	
				{
					label: "Alasan Skip <sup class='text-danger'>*<sup>",
					name: "isoittd_upload.alasan_skip",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": "Label LPN Tidak Ada / Salah", "value": "Label LPN Tidak Ada / Salah" },
						{ "label": "Label Lokasi Tidak Ada / Salah", "value": "Label Lokasi Tidak Ada / Salah" },
						{ "label": "Penataan belum sesuai standart", "value": "Penataan belum sesuai standart" },
					]
				},
				{
					label: "Foto",
					name: "isoittd_upload.id_files_skip",
					type: "upload",
					display: function ( fileId, counter ) {
						if (fileId == 0){
							return 'Belum ada lampiran';
						}else{
							return '<a href="'+edtisoittd_upload_skip.file( 'files', fileId ).web_path+'" target="_blank">'+ edtisoittd_upload_skip.file( 'files', fileId ).filename + '</a>'; 
						}
					},
					noFileText: 'Belum ada gambar'
				},
			]
		} );
		
		edtisoittd_upload_skip.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtisoittd_upload_skip.field('isoittd_upload.start_at').val(start_at);
			edtisoittd_upload_skip.field('isoittd_upload.id_isoxxth_upload').val(id_isoxxth_upload_filter);
		});

		edtisoittd_upload_skip.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
		});

		edtisoittd_upload_skip.on( 'preSubmit', function (e, data, action) {

				id_files_skip      = edtisoittd_upload_skip.field('isoittd_upload.id_files_skip').val();
				alasan_skip      = edtisoittd_upload_skip.field('isoittd_upload.alasan_skip').val();
				console.log(id_files_skip);

				if (alasan_skip == '') {
					edtisoittd_upload_skip.field('isoittd_upload.alasan_skip').error( 'Wajib diisi!' )
				}
			
			if ( edtisoittd_upload_skip.inError() ) {
				return false;
			}
		});

		edtisoittd_upload_skip.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtisoittd_upload_skip.field('isoittd_upload.finish_at').val(finish_at);
		});

		edtisoittd_upload_skip.on( 'postSubmit', function (e, json, data, action, xhr) {
			$.ajax( {
				url: '../../models/isoittd_upload/fn_button_skip.php',
				dataType: 'json',
				type: 'POST',
				data: {
					id_transaksi_h: id_transaksi_h,
					start_button: start_button
				},
				success: function ( json ) {
					full_message = json.message + '</br>';
					toast_type   = json.type_message;
					toastr[toast_type](full_message, 'INFO');

					tblisoittd_upload.rows().deselect();
					tblisoittd_upload.ajax.reload(null,false);
				}
			});
		
			// tblisoittd_upload.rows().deselect();
			// tblisoittd_upload.ajax.reload(null,false);
		} );

		edtisoittd_upload_duplicate = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/isoittd_upload/isoittd_upload.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_isoittd_upload = show_deleted_isoittd_upload;
					d.id_isoxxth_upload_filter = id_isoxxth_upload_filter;
				}
			},
			table: "#tblisoittd_upload",
			template: "#custom_isoittd_upload_duplicate",
			fields: [ 
				{
					label: "isoittd_upload.start_at",
					name: "isoittd_upload.start_at",
					type: "hidden"
				},	
				{
					label: "isoittd_upload.finish_at",
					name: "isoittd_upload.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "isoittd_upload",
					type: "hidden"
				},	
				{
					label: "isoittd_upload.id_isoxxth_upload",
					name: "isoittd_upload.id_isoxxth_upload",
					type: "hidden"
				},
				{
					label: "isoittd_upload.transaction_state",
					name: "isoittd_upload.transaction_state",
					type: "hidden",
					def: 1
				},
				{
					label: "isoittd_upload.selisih_final",
					name: "isoittd_upload.selisih_final",
					type: "hidden"
				},
				{
					label: "isoittd_upload.selisih",
					name: "isoittd_upload.selisih",
					type: "hidden"
				},
				{
					label: "isoittd_upload.is_skip",
					name: "isoittd_upload.is_skip",
					type: "hidden"
				},
				{
					label: "Kode Item",
					name: "isoittd_upload.kode",
					type: "readonly"
				},
				{
					label: "Nama Item",
					name: "isoittd_upload.nama",
					type: "readonly"
				},
				{
					label: "Satuan",
					name: "isoittd_upload.satuan",
					type: "readonly"
				},
				{
					label: "Lokasi",
					name: "isoittd_upload.lokasi",
					type: "readonly"
				},
				{
					label: "Item <sup class='text-danger'>*<sup>", 
					name: "isoittd_upload.select_item",
					type: "select2",
					id: "item_opname",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/iimxxmh_upload/iimxxmh_upload_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								// console.log(id_isoxxth_upload_filter);
								var query = {
									id_iimxxmh_upload_old: id_iimxxmh_upload_old,
									company: company,
									cabang: cabang,
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
					label: "Satuan", 
					name: "isoittd_upload.select_satuan",
					type: "readonly",
				},
				{
					label: "Lokasi <sup class='text-danger'>*<sup>", 
					name: "isoittd_upload.select_lokasi",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/wloxxmh_upload/wloxxmh_upload_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								// console.log(id_isoxxth_upload_filter);
								var query = {
									id_wloxxmh_upload_old: id_wloxxmh_upload_old,
									company: company,
									cabang: cabang,
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
					name: "isoittd_upload.jumlah_terkecil"
				}, 	
				{
					label: "Quantity Fisik",
					name: "isoittd_upload.fisik"
				}, 	
				{
					label: "LPN",
					name: "isoittd_upload.lpn"
				}, 	
				
				{
					label: "Transaksi In",
					name: "isoittd_upload.transaksi_in",
					type: "hidden"
				}, 	
				
				{
					label: "Transaksi Out",
					name: "isoittd_upload.transaksi_out",
					type: "hidden"
				}, 	
				{
					label: "Batch Number",
					name: "isoittd_upload.batch_number"
				}, 	
				{
					label: "Expired Date",
					name: "isoittd_upload.expired_date",
					type: "datetime",
					opts:{
						minDate: new Date('1900-01-01'),
						firstDay: 0
					},
					format: 'DD MMM YYYY'
				},
				{
					label: "Foto SKIP",
					name: "isoittd_upload.id_files_skip",
					type: "upload",
					display: function ( fileId, counter ) {
						if (fileId == 0){
							return 'Belum ada lampiran';
						}else{
							return '<a href="'+edtisoittd_upload_duplicate_skip.file( 'files', fileId ).web_path+'" target="_blank">'+ edtisoittd_upload_duplicate_skip.file( 'files', fileId ).filename + '</a>'; 
						}
					},
					noFileText: 'Belum ada gambar'
				},
				{
					label: "Keterangan",
					name: "isoittd_upload.keterangan",
					type: "textarea"
				},
				{
					label: "ID Foto", 
					name: "isoittd_upload.id_files_pointer",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/isoittd_upload/isoittd_upload_files_pointer_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								// console.log(id_isoxxth_upload_filter);
								var query = {
									id_files_pointer_old: id_foto_pointer_old,
									id_isoxxth_upload_old: id_isoxxth_upload_filter,
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
			]
		} );
		edtisoittd_upload_duplicate.field('isoittd_upload.id_files_skip').hide();
		edtisoittd_upload_duplicate.field('isoittd_upload.id_files_skip').disable();
		
		edtisoittd_upload_duplicate.on( 'preOpen', function( e, mode, action ) {
			console.log(id_transaksi_h);

			autofillField('isoittd_upload', id_transaksi_h, '*');
			id_iimxxmh_old = id_transaksi_h;
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtisoittd_upload_duplicate.field('isoittd_upload.start_at').val(start_at);
			edtisoittd_upload_duplicate.field('isoittd_upload.id_isoxxth_upload').val(autofillData.id_isoxxth_upload);

			edtisoittd_upload_duplicate.field('isoittd_upload.select_item').hide();
			edtisoittd_upload_duplicate.field('isoittd_upload.select_item').val(id_transaksi_h);
			edtisoittd_upload_duplicate.field('isoittd_upload.select_satuan').hide();
			edtisoittd_upload_duplicate.field('isoittd_upload.select_satuan').val(id_transaksi_h);
			edtisoittd_upload_duplicate.field('isoittd_upload.select_lokasi').hide();
			edtisoittd_upload_duplicate.field('isoittd_upload.select_lokasi').val(id_transaksi_h);
			edtisoittd_upload_duplicate.field('isoittd_upload.kode').show();
			edtisoittd_upload_duplicate.field('isoittd_upload.kode').val(autofillData.kode);
			edtisoittd_upload_duplicate.field('isoittd_upload.nama').show();
			edtisoittd_upload_duplicate.field('isoittd_upload.nama').val(autofillData.nama);
			edtisoittd_upload_duplicate.field('isoittd_upload.satuan').show();
			edtisoittd_upload_duplicate.field('isoittd_upload.satuan').val(autofillData.satuan);
			edtisoittd_upload_duplicate.field('isoittd_upload.lokasi').show();
			edtisoittd_upload_duplicate.field('isoittd_upload.lokasi').val(autofillData.lokasi);
			edtisoittd_upload_duplicate.field('isoittd_upload.jumlah_terkecil').disable();
			edtisoittd_upload_duplicate.field('isoittd_upload.jumlah_terkecil').val(0);
			edtisoittd_upload_duplicate.field('isoittd_upload.lpn').enable();
			edtisoittd_upload_duplicate.field('isoittd_upload.lpn').val(autofillData.lpn);
			edtisoittd_upload_duplicate.field('isoittd_upload.batch_number').enable();
			edtisoittd_upload_duplicate.field('isoittd_upload.batch_number').val(autofillData.batch_number);
			edtisoittd_upload_duplicate.field('isoittd_upload.expired_date').enable();
			edtisoittd_upload_duplicate.field('isoittd_upload.expired_date').val(moment(autofillData.expired_date).format('DD MMM YYYY'));
			edtisoittd_upload_duplicate.field('isoittd_upload.transaksi_in').val(autofillData.transaksi_in);
			edtisoittd_upload_duplicate.field('isoittd_upload.transaksi_out').val(autofillData.transaksi_out);
			edtisoittd_upload_duplicate.field('isoittd_upload.fisik').val(autofillData.fisik);
			edtisoittd_upload_duplicate.field('isoittd_upload.selisih').val(autofillData.selisih);
			edtisoittd_upload_duplicate.field('isoittd_upload.selisih_final').val(autofillData.selisih_final);
			edtisoittd_upload_duplicate.field('isoittd_upload.is_skip').val(autofillData.is_skip);
			edtisoittd_upload_duplicate.field('isoittd_upload.id_files_pointer').val(autofillData.id_files_pointer);
		});

		edtisoittd_upload_duplicate.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-xl");
		});

		// edtisoittd_upload_duplicate.dependent( 'isoittd_upload.transaksi_in', function ( val, data, callback ) {
		// 	if (val > 0) {
		// 		fisik = edtisoittd_upload_duplicate.field('isoittd_upload.fisik').val();
		// 		transaksi_in = edtisoittd_upload_duplicate.field('isoittd_upload.transaksi_in').val();
		// 		transaksi_out = edtisoittd_upload_duplicate.field('isoittd_upload.transaksi_out').val();

		// 		selisih_final = parseFloat(fisik) + parseFloat(transaksi_out) - 0 - parseFloat(transaksi_in);
		// 		console.log(selisih_final);
		// 		edtisoittd_upload_duplicate.field('isoittd_upload.selisih_final').val(selisih_final);
		// 	}
		// 	return {}
		// }, {event: 'keyup change'});

		// edtisoittd_upload_duplicate.dependent( 'isoittd_upload.transaksi_out', function ( val, data, callback ) {
		// 	if (val > 0) {
		// 		fisik = edtisoittd_upload_duplicate.field('isoittd_upload.fisik').val();
		// 		transaksi_in = edtisoittd_upload_duplicate.field('isoittd_upload.transaksi_in').val();
		// 		transaksi_out = edtisoittd_upload_duplicate.field('isoittd_upload.transaksi_out').val();

		// 		selisih_final = parseFloat(fisik) + parseFloat(transaksi_out) - 0 - parseFloat(transaksi_in);
		// 		console.log(selisih_final);
		// 		edtisoittd_upload_duplicate.field('isoittd_upload.selisih_final').val(selisih_final);
		// 	}
		// 	return {}
		// }, {event: 'keyup change'});

		edtisoittd_upload_duplicate.dependent( 'isoittd_upload.fisik', function ( val, data, callback ) {
			if (val > 0) {
				fisik = edtisoittd_upload_duplicate.field('isoittd_upload.fisik').val();
				edtisoittd_upload_duplicate.field('isoittd_upload.selisih').val(fisik);
			}
			return {}
		}, {event: 'keyup change'});

		edtisoittd_upload_duplicate.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				select_satuan      = edtisoittd_upload_duplicate.field('isoittd_upload.select_satuan').val();
				select_item = edtisoittd_upload_duplicate.field('isoittd_upload.select_item').val();
				select_lokasi         = edtisoittd_upload_duplicate.field('isoittd_upload.select_lokasi').val();
				satuan      = edtisoittd_upload_duplicate.field('isoittd_upload.satuan').val();
				kode = edtisoittd_upload_duplicate.field('isoittd_upload.kode').val();
				nama = edtisoittd_upload_duplicate.field('isoittd_upload.nama').val();
				lokasi         = edtisoittd_upload_duplicate.field('isoittd_upload.lokasi').val();
				jumlah_terkecil           = edtisoittd_upload_duplicate.field('isoittd_upload.jumlah_terkecil').val();
				lpn          = edtisoittd_upload_duplicate.field('isoittd_upload.lpn').val();
				fisik          = edtisoittd_upload_duplicate.field('isoittd_upload.fisik').val();
				batch_number              = edtisoittd_upload_duplicate.field('isoittd_upload.batch_number').val();
				// expired_date              = edtisoittd_upload_duplicate.field('isoittd_upload.expired_date').val();
				
				expired_date = moment(edtisoittd_upload_duplicate.field('isoittd_upload.expired_date').val()).format("YYYY-MM-DD");

				validasiRequired(
					edtisoittd_upload_duplicate,
					'isoittd_upload',
					{
						'select_satuan': select_satuan,
						'select_item': select_item,
						'select_lokasi': select_lokasi,
						'jumlah_terkecil': jumlah_terkecil,
					}
				);
				
				// panggil validasi
				validasiUnique(
					action,
					edtisoittd_upload_duplicate,
					'isoittd_upload',
					'select_item,select_lokasi,select_satuan,lpn,batch_number,expired_date',
					'kode,lokasi,satuan,lpn,batch_number,expired_date,id_isoxxth_upload',
					"'"+kode+"', '"+lokasi+"', '"+satuan+"', '"+lpn+"', '"+batch_number+"', '"+expired_date+"',"+id_isoxxth_upload_filter,
					id_isoittd_upload
				);

				validasiNumber(
					edtisoittd_upload_duplicate,
					'isoittd_upload',
					{
					},
					0,
					'>='
				);
			}
			
			if ( edtisoittd_upload_duplicate.inError() ) {
				return false;
			}
		});

		edtisoittd_upload_duplicate.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtisoittd_upload_duplicate.field('isoittd_upload.finish_at').val(finish_at);
		});
		
		edtisoittd_upload_duplicate.on( 'postSubmit', function (e, json, data, action, xhr) {
			tblisoittd_upload.rows().deselect();
			tblisoittd_upload.ajax.reload(null,false);
		} );

		edtisoittd_upload_duplicate.on( 'close', function () {
			edtisoittd_upload_duplicate.enable();
		} );

		//Upload foto pointer
		

		// BEGIN isoittd_upload
		edtisoittd_upload_pointer = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/isoittd_upload/isoittd_upload.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_isoittd_upload = show_deleted_isoittd_upload;
					d.id_isoxxth_upload_filter = id_isoxxth_upload_filter;
				}
			},
			table: "#tblisoittd_upload",
			fields: [ 
				{
					label: "isoittd_upload.start_at",
					name: "isoittd_upload.start_at",
					type: "hidden"
				},	
				{
					label: "isoittd_upload.finish_at",
					name: "isoittd_upload.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "isoittd_upload",
					type: "hidden"
				},	
				{
					label: "isoittd_upload.id_isoxxth_upload",
					name: "isoittd_upload.id_isoxxth_upload",
					type: "hidden"
				},
				{
					label: "isoittd_upload.transaction_state",
					name: "isoittd_upload.transaction_state",
					type: "hidden",
					def: 1
				},
				{
					label: "Transaksi In",
					name: "isoittd_upload.transaksi_in",
					type: "hidden"
				}, 	
				
				{
					label: "Transaksi Out",
					name: "isoittd_upload.transaksi_out",
					type: "hidden"
				}, 	
				{
					label: "Foto <sup class='text-danger'>*<sup>",
					name: "isoittd_upload.id_files_pointer",
					type: "upload",
					display: function ( fileId, counter ) {
						if (fileId == 0){
							return 'Belum ada lampiran';
						}else{
							return '<a href="'+edtisoittd_upload_pointer.file( 'files', fileId ).web_path+'" target="_blank">'+ edtisoittd_upload_pointer.file( 'files', fileId ).filename + '</a>'; 
						}
					},
					noFileText: 'Belum ada gambar'
				},
				{
					label: "Keterangan Pointer <sup class='text-danger'>*<sup>",
					name: "isoittd_upload.keterangan_pointer",
					fieldInfo: "Contoh: Hanya hitung pipa yang berisi 4"
				}, 	
			]
		} );
		
		edtisoittd_upload_pointer.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtisoittd_upload_pointer.field('isoittd_upload.start_at').val(start_at);
			edtisoittd_upload_pointer.field('isoittd_upload.id_isoxxth_upload').val(id_isoxxth_upload_filter);
		});

		edtisoittd_upload_pointer.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
		});

		edtisoittd_upload_pointer.on( 'preSubmit', function (e, data, action) {

				id_files_pointer      = edtisoittd_upload_pointer.field('isoittd_upload.id_files_pointer').val();
				console.log(id_files_pointer);

				if (id_files_pointer == 0) {
					edtisoittd_upload_pointer.field('isoittd_upload.id_files_pointer').error( 'Wajib diisi!' )
				}

				keterangan_pointer      = edtisoittd_upload_pointer.field('isoittd_upload.keterangan_pointer').val();
				console.log(keterangan_pointer);

				if (keterangan_pointer == '') {
					edtisoittd_upload_pointer.field('isoittd_upload.keterangan_pointer').error( 'Wajib diisi!' )
				}
			
			if ( edtisoittd_upload_pointer.inError() ) {
				return false;
			}
		});

		edtisoittd_upload_pointer.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtisoittd_upload_pointer.field('isoittd_upload.finish_at').val(finish_at);
		});

		edtisoittd_upload_pointer.on( 'postSubmit', function (e, json, data, action, xhr) {
			// tblisoittd_upload.rows().deselect();
			tblisoittd_upload.ajax.reload(null,false);
		} );

		edtisoittd_upload = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/isoittd_upload/isoittd_upload.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_isoittd_upload = show_deleted_isoittd_upload;
					d.id_isoxxth_upload_filter = id_isoxxth_upload_filter;
				}
			},
			table: "#tblisoittd_upload",
			template: "#custom_isoittd_upload",
			fields: [ 
				{
					label: "isoittd_upload.start_at",
					name: "isoittd_upload.start_at",
					type: "hidden"
				},	
				{
					label: "isoittd_upload.finish_at",
					name: "isoittd_upload.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "isoittd_upload",
					type: "hidden"
				},	
				{
					label: "isoittd_upload.id_isoxxth_upload",
					name: "isoittd_upload.id_isoxxth_upload",
					type: "hidden"
				},
				{
					label: "isoittd_upload.transaction_state",
					name: "isoittd_upload.transaction_state",
					type: "hidden",
					def: 1
				},
				{
					label: "Kode Item",
					name: "isoittd_upload.kode",
					type: "readonly"
				},
				{
					label: "Nama Item",
					name: "isoittd_upload.nama",
					type: "readonly"
				},
				{
					label: "Satuan",
					name: "isoittd_upload.satuan",
					type: "readonly"
				},
				{
					label: "Lokasi",
					name: "isoittd_upload.lokasi",
					type: "readonly"
				},
				{
					label: "Item <sup class='text-danger'>*<sup>", 
					name: "isoittd_upload.select_item",
					type: "select2",
					id: "item_opname",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/iimxxmh_upload/iimxxmh_upload_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								// console.log(id_isoxxth_upload_filter);
								var query = {
									id_iimxxmh_upload_old: id_iimxxmh_upload_old,
									company: company,
									cabang: cabang,
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
					label: "Satuan <sup class='text-danger'>*<sup>",", 
					name: "isoittd_upload.select_satuan",
					type: "select2",
					id: "satuan_opname",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/isoittd_upload/satuan_opname_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								// console.log(id_isoxxth_upload_filter);
								var query = {
									id_isoittd_upload_old: id_iimxxmh_old,
									id_isoxxth_upload_old: id_isoxxth_upload_filter,
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
					label: "Lokasi <sup class='text-danger'>*<sup>", 
					name: "isoittd_upload.select_lokasi",
					type: "select2",
					id: "lokasi_opname",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/wloxxmh_upload/wloxxmh_upload_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								// console.log(id_isoxxth_upload_filter);
								var query = {
									id_wloxxmh_upload_old: id_wloxxmh_upload_old,
									company: company,
									cabang: cabang,
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
					name: "isoittd_upload.jumlah_terkecil"
				}, 	
				{
					label: "Quantity Fisik",
					name: "isoittd_upload.fisik",
					type: "readonly"
				}, 	
				{
					label: "LPN",
					name: "isoittd_upload.lpn"
				}, 	
				
				{
					label: "Transaksi In",
					name: "isoittd_upload.transaksi_in"
				}, 	
				
				{
					label: "Transaksi Out",
					name: "isoittd_upload.transaksi_out"
				}, 	
				{
					label: "Batch Number",
					name: "isoittd_upload.batch_number"
				}, 	
				{
					label: "Expired Date",
					name: "isoittd_upload.expired_date",
					type: "datetime",
					opts:{
						minDate: new Date('1900-01-01'),
						firstDay: 0
					},
					format: 'DD MMM YYYY'
				},
				{
					label: "Foto SKIP",
					name: "isoittd_upload.id_files_skip",
					type: "upload",
					display: function ( fileId, counter ) {
						if (fileId == 0){
							return 'Belum ada lampiran';
						}else{
							return '<a href="'+edtisoittd_upload_skip.file( 'files', fileId ).web_path+'" target="_blank">'+ edtisoittd_upload_skip.file( 'files', fileId ).filename + '</a>'; 
						}
					},
					noFileText: 'Belum ada gambar'
				},
				{
					label: "Keterangan",
					name: "isoittd_upload.keterangan",
					type: "textarea"
				},
				{
					label: "Keterangan Pointer<sup class='text-danger'>*<sup>",
					name: "isoittd_upload.keterangan_pointer",
					type: "textarea"
				},
				{
					label: "Alasan Skip",
					name: "isoittd_upload.alasan_skip",
					type: "readonly"
				},
				{
					label: "ID Foto Pointer", 
					name: "isoittd_upload.id_files_pointer",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/isoittd_upload/isoittd_upload_files_pointer_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								// console.log(id_isoxxth_upload_filter);
								var query = {
									id_files_pointer_old: id_files_pointer_old,
									id_isoxxth_upload_old: id_isoxxth_upload_filter,
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
			]
		} );
		edtisoittd_upload.field('isoittd_upload.id_files_skip').hide();
		edtisoittd_upload.field('isoittd_upload.alasan_skip').hide();
		edtisoittd_upload.field('isoittd_upload.id_files_skip').disable();
		
		edtisoittd_upload.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtisoittd_upload.field('isoittd_upload.start_at').val(start_at);
			edtisoittd_upload.field('isoittd_upload.id_isoxxth_upload').val(id_isoxxth_upload_filter);

			edtisoittd_upload.field('isoittd_upload.keterangan_pointer').hide();
			
			autofillField('isoxxth_upload', id_isoxxth_upload_filter, 'company,cabang')
			company = autofillData.company;
			cabang = autofillData.cabang;
			// console.log('company = '+company);
			// console.log('cabang = '+cabang);

			if(action == 'create'){
				tblisoittd_upload.rows().deselect();

				edtisoittd_upload.field('isoittd_upload.select_item').show();
				edtisoittd_upload.field('isoittd_upload.select_satuan').show();
				edtisoittd_upload.field('isoittd_upload.select_lokasi').show();
				edtisoittd_upload.field('isoittd_upload.kode').hide();
				edtisoittd_upload.field('isoittd_upload.nama').hide();
				edtisoittd_upload.field('isoittd_upload.satuan').hide();
				edtisoittd_upload.field('isoittd_upload.lokasi').hide();
				edtisoittd_upload.field('isoittd_upload.jumlah_terkecil').disable();
				edtisoittd_upload.field('isoittd_upload.jumlah_terkecil').val(0);
				edtisoittd_upload.field('isoittd_upload.lpn').enable();
				edtisoittd_upload.field('isoittd_upload.batch_number').enable();
				edtisoittd_upload.field('isoittd_upload.expired_date').enable();
			}else if(action == 'edit'){
				
				edtisoittd_upload.field('isoittd_upload.select_item').hide();
				edtisoittd_upload.field('isoittd_upload.select_satuan').hide();
				edtisoittd_upload.field('isoittd_upload.select_lokasi').hide();
				edtisoittd_upload.field('isoittd_upload.kode').show();
				edtisoittd_upload.field('isoittd_upload.nama').show();
				edtisoittd_upload.field('isoittd_upload.satuan').show();
				edtisoittd_upload.field('isoittd_upload.lokasi').show();
				edtisoittd_upload.field('isoittd_upload.jumlah_terkecil').disable();
				edtisoittd_upload.field('isoittd_upload.lpn').disable();
				edtisoittd_upload.field('isoittd_upload.batch_number').disable();
				edtisoittd_upload.field('isoittd_upload.expired_date').disable();
				
				if (is_skip_select == 1) {
					edtisoittd_upload.field('isoittd_upload.id_files_skip').show();
					edtisoittd_upload.field('isoittd_upload.alasan_skip').show();
				} else {
					edtisoittd_upload.field('isoittd_upload.id_files_skip').hide();
					edtisoittd_upload.field('isoittd_upload.alasan_skip').hide();
				}
			}
		});

		edtisoittd_upload.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-xl");
		});

		edtisoittd_upload.dependent( 'isoittd_upload.select_satuan', function ( val, data, callback ) {
			if (val > 0) {
				var data_satuan_opname = $('#satuan_opname').select2('data')[0];
				if (data_satuan_opname) {
					text_satuan_opname = data_satuan_opname.text
				}

				edtisoittd_upload.field('isoittd_upload.satuan').val(text_satuan_opname);
			}
			return {}
		}, {event: 'keyup change'});

		edtisoittd_upload.dependent( 'isoittd_upload.id_files_pointer', function ( val, data, callback ) {
			if (val > 0) {
				cekKeteranganPointer(val);
				edtisoittd_upload.field('isoittd_upload.keterangan_pointer').show();
				edtisoittd_upload.field('isoittd_upload.keterangan_pointer').val(keterangan_pointer);
			} else {
				edtisoittd_upload.field('isoittd_upload.keterangan_pointer').hide();
				edtisoittd_upload.field('isoittd_upload.keterangan_pointer').val('');

			}
			return {}
		}, {event: 'keyup change'});

		edtisoittd_upload.dependent( 'isoittd_upload.select_item', function ( val, data, callback ) {
			if (val > 0) {
				var data_item_opname = $('#item_opname').select2('data')[0];
				if (data_item_opname) {
					text_item_opname = data_item_opname.text
				}
				// console.log(text_item_opname);
				var separatorIndex = text_item_opname.indexOf(" - ");
				var s_kode = text_item_opname.substring(0, separatorIndex);
				var s_nama = text_item_opname.substring(separatorIndex + 3);

				// console.log(s_kode);
				// console.log(s_nama);

				autofillField('iimxxmh_upload', val, 'satuan');
				satuan = autofillData.satuan;

				edtisoittd_upload.field('isoittd_upload.kode').val(s_kode);
				edtisoittd_upload.field('isoittd_upload.nama').val(s_nama);
				edtisoittd_upload.field('isoittd_upload.select_satuan').val(satuan);
				edtisoittd_upload.field('isoittd_upload.satuan').val(satuan);
			}
			return {}
		}, {event: 'keyup change'});

		edtisoittd_upload.dependent( 'isoittd_upload.select_lokasi', function ( val, data, callback ) {
			if (val > 0) {
				var data_lokasi_opname = $('#lokasi_opname').select2('data')[0];
				if (data_lokasi_opname) {
					text_lokasi_opname = data_lokasi_opname.text
				}

				edtisoittd_upload.field('isoittd_upload.lokasi').val(text_lokasi_opname);
			}
			return {}
		}, {event: 'keyup change'});

		edtisoittd_upload.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				select_satuan      = edtisoittd_upload.field('isoittd_upload.select_satuan').val();
				select_item = edtisoittd_upload.field('isoittd_upload.select_item').val();
				select_lokasi         = edtisoittd_upload.field('isoittd_upload.select_lokasi').val();
				satuan      = edtisoittd_upload.field('isoittd_upload.satuan').val();
				kode = edtisoittd_upload.field('isoittd_upload.kode').val();
				nama = edtisoittd_upload.field('isoittd_upload.nama').val();
				lokasi         = edtisoittd_upload.field('isoittd_upload.lokasi').val();
				jumlah_terkecil           = edtisoittd_upload.field('isoittd_upload.jumlah_terkecil').val();
				lpn          = edtisoittd_upload.field('isoittd_upload.lpn').val();
				fisik          = edtisoittd_upload.field('isoittd_upload.fisik').val();
				batch_number              = edtisoittd_upload.field('isoittd_upload.batch_number').val();
				transaksi_in              = edtisoittd_upload.field('isoittd_upload.transaksi_in').val();
				transaksi_out              = edtisoittd_upload.field('isoittd_upload.transaksi_out').val();
				id_files_pointer              = edtisoittd_upload.field('isoittd_upload.id_files_pointer').val();
				keterangan_pointer              = edtisoittd_upload.field('isoittd_upload.keterangan_pointer').val();
				// expired_date              = edtisoittd_upload.field('isoittd_upload.expired_date').val();
				
				expired_date = moment(edtisoittd_upload.field('isoittd_upload.expired_date').val()).format("YYYY-MM-DD");

				if (action == 'create') {
					validasiRequired(
						edtisoittd_upload,
						'isoittd_upload',
						{
							'select_satuan': select_satuan,
							'select_item': select_item,
							'select_lokasi': select_lokasi,
							'jumlah_terkecil': jumlah_terkecil,
						}
					);
				}
				
				// panggil validasi
				validasiUnique(
					action,
					edtisoittd_upload,
					'isoittd_upload',
					'select_item,select_lokasi,select_satuan,lpn,batch_number,expired_date',
					'kode,lokasi,satuan,lpn,batch_number,expired_date,id_isoxxth_upload',
					"'"+kode+"', '"+lokasi+"', '"+satuan+"', '"+lpn+"', '"+batch_number+"', '"+expired_date+"',"+id_isoxxth_upload_filter,
					id_isoittd_upload
				);

				if (transaksi_in != '' && transaksi_out != '') {
					validasiNumber(
						edtisoittd_upload,
						'isoittd_upload',
						{
							'transaksi_in': transaksi_in,
							'transaksi_out': transaksi_out,
						},
						0,
						'>='
					);
				}

				if (id_files_pointer > 0) {
					validasiRequired(
						edtisoittd_upload,
						'isoittd_upload',
						{
							'keterangan_pointer': keterangan_pointer,
						}
					);
				}
			}
			
			if ( edtisoittd_upload.inError() ) {
				return false;
			}
		});

		edtisoittd_upload.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtisoittd_upload.field('isoittd_upload.finish_at').val(finish_at);
		});
		
		edtisoittd_upload.on( 'postSubmit', function (e, json, data, action, xhr) {
			tblisoittd_upload.rows().deselect();
			tblisoittd_upload.ajax.reload(null,false);
		} );

		edtisoittd_upload.on( 'close', function () {
			edtisoittd_upload.enable();
		} );
		
		var selisihDesc = $.fn.dataTable.absoluteOrderNumber( [
			{ value: null, position: 'bottom' }
		] );

		tblisoittd_upload = $('#tblisoittd_upload').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: window.innerWidth < 768 ? 'columns-1' : 'columns-4'
			},
			// make if phone mobile make colums -1
			ajax: {
				url: "../../models/isoittd_upload/isoittd_upload.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_isoittd_upload = show_deleted_isoittd_upload;
					d.id_isoxxth_upload_filter = id_isoxxth_upload_filter;
				}
			},
			columnDefs:[
				{
					searchPanes:{
						show: true,
					},
					// targets: [1,3,4,10,13,14,15]
					targets: [1,2,4,5,11,14,15]
				},
				{
					searchPanes:{
						show: false,
					},
					targets: '_all'
				},
				{ type: selisihDesc, targets: 11 }
			],
			deferRender: true,
			// serverSide: true,
			order: [[ 2, "asc" ], [ 4, "asc" ], [ 3, "asc" ], [ 6, "asc" ]],
			// responsive: false,
			// scrollX: true,
			columns: [
				{ data: "isoittd_upload.id",visible:false },
				// { data: "wloxxmh.nama" },
				{ 
					data: null,
					render: function (data, type, row) {
						// console.log(row);
						if(row.isoittd_upload.is_skip == 0 && row.isoittd_upload.fisik == null){
							return '<span class="badge badge-plain">Tidak</span>';
						} else {
							return '<span class="badge badge-primary">Ya</span>';
						}
					}
				},
				{ data: "isoittd_upload.lokasi" },
				{ data: "isoittd_upload.lpn" },
				// { data: "iimxxmh.kode" },
				// { data: "iimxxmh.nama" },
				{ data: "isoittd_upload.kode" },
				{ data: "isoittd_upload.nama" },
				{ data: "isoittd_upload.batch_number" },
				{ data: "isoittd_upload.expired_date" },
				// { data: "iumxxmh.kode" },
				{ data: "isoittd_upload.satuan" },
				{ 
					data: "isoittd_upload.jumlah_terkecil" ,
					...renderNumber()
				},
				{ 
					data: "isoittd_upload.fisik",
					...renderNumber()
				},
				{ 
					data: "isoittd_upload.selisih",
					// ...renderNumber()
					render: function(data, type, row) {
						if (type === 'sp') {
							if (data == 0) {
								return "OK";
							} else if (data > 0) {
								return "Lebih"
							} else if (data < 0) {
								return "Kurang"
							} else {
								return "Invalid Value"
							}
						} else {
							return $.fn.dataTable.render.number(',', '.', 0, '', '').display(data);
						}
					},
					class: "text-right",
					searchPanes: {
						orthogonal: 'sp',
						show: true
					}
				},
				{ 
					data: "isoittd_upload.transaksi_in",
					...renderNumber()
				},
				{ 
					data: "isoittd_upload.transaksi_out",
					...renderNumber()
				},
				{ 
					data: "isoittd_upload.selisih_final",
					// ...renderNumber()
					render: function(data, type, row) {
						if (type === 'sp') {
							if (data == 0) {
								return "OK";
							} else if (data > 0) {
								return "Lebih"
							} else if (data < 0) {
								return "Kurang"
							} else {
								return "Invalid Value"
							}
						} else {
							return $.fn.dataTable.render.number(',', '.', 0, '', '').display(data);
						}
					},
					class: "text-right",
					searchPanes: {
						orthogonal: 'sp',
						show: true
					}
				},
				{ 
					data: "isoittd_upload.is_skip",
					...renderYaTidak()
				},
				// { data: "wloznmh.nama" }, 
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_isoittd_upload';
					$table       = 'tblisoittd_upload';
					$edt         = 'edtisoittd_upload';
					$show_status = '_isoittd_upload';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= [ 'sf','sp', 'sb'];
					$arr_buttons_action 	= ['create', 'edit', 'remove_hd', 'confirm', 'nonaktif_hd', 'close', 'view', 'log','noaction'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
				// END breaking generate button
				{
					extend: 'collection',
					name: 'btnSetExcel',
					text: '<i class="fa fa-file-excel-o"></i>',
					className: 'btn btn-primary',
					autoClose: true,
					titleAttr: 'Update Transaksi',
					buttons: [
						{
							extend: "excel",
							name: 'btnDownload',
							title: null,
							text: 'Download Transaksi',
							className: 'btn btn-sm',
							titleAttr: 'Download Transaksi',
							exportOptions: {
                                columns: [0,1,2,3,4,5,6,7,8,9,10,11,12],
								rows: function (idx, data, node) {
									return data.isoittd_upload.fisik != null || data.isoittd_upload.is_skip == 1;
								}
                            },
						},

						{
							name: 'btnUpload',
							text: 'Upload Transaksi',
							className: 'btn btn-sm',
							titleAttr: 'Upload Transaksi',
							action: function ( e, dt, node, config ) {
								$('#modalUpload').modal('toggle');
							}
						}
					]
				},
				{ 
					text: '<i class="fa fa-clone"></i>', 
					name: 'btnDuplicate',
					extend: 'create', 
					editor: edtisoittd_upload_duplicate,
					className: 'btn btn-outline',
					titleAttr: 'Duplicate',
				},

				{ 
					text: '<span>OK</span>', 
					name: 'btnSesuai',
					className: 'btn btn-primary',
					titleAttr: 'Sesuai',
					action: function ( e, dt, node, config ) {
						// console.log(start_button);
						$.ajax( {
							url: '../../models/isoittd_upload/fn_button_fisik_sesuai.php',
							dataType: 'json',
							type: 'POST',
							data: {
								id_transaksi_h: id_transaksi_h,
								start_button: start_button
							},
							success: function ( json ) {
								full_message = json.message + '</br>';
								toast_type   = json.type_message;
								toastr[toast_type](full_message, 'INFO');

								tblisoittd_upload_fisik.rows().deselect();
								tblisoittd_upload_fisik.ajax.reload(null,false);

								tblisoittd_upload.rows().deselect();
								tblisoittd_upload.ajax.reload(null,false);
							}
						});
					}
				},
				{ 
					text: '<span>0</span>', 
					name: 'btnNol',
					titleAttr: 'Fisik Nol',
					action: function ( e, dt, node, config ) {
						swal({
							text: "Apakah Anda Yakin?",
							icon: "info",
							buttons: {
								cancel: true,
								confirm: true
							},
						})
						.then((willConfirm) => {
							if (willConfirm) {
								$.ajax( {
									url: '../../models/isoittd_upload/fn_button_fisik_nol.php',
									dataType: 'json',
									type: 'POST',
									data: {
										id_transaksi_h: id_transaksi_h,
										start_button: start_button
									},
									success: function ( json ) {
										full_message = json.message + '</br>';
										toast_type   = json.type_message;
										toastr[toast_type](full_message, 'INFO');
										
										tblisoittd_upload_fisik.rows().deselect();
										tblisoittd_upload_fisik.ajax.reload(null,false);

										tblisoittd_upload.rows().deselect();
										tblisoittd_upload.ajax.reload(null,false);
									}
								});
							}
						});
					}
				},
				{ 
					text: 'SKIP', 
					extend: 'edit', 
					name: 'btnSkip',
					editor: edtisoittd_upload_skip,
					className: 'btn btn-warning',
					titleAttr: 'Skip',
				},
				{ 
					text: ' <i class="fa fa-upload"></i>', 
					extend: 'edit', 
					name: 'btnPointer',
					editor: edtisoittd_upload_pointer,
					className: 'btn btn-outline',
					titleAttr: 'Upload Foto Pointer',
				},
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
				if ( data.isoittd_upload.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.isoittd_upload.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}

				if ( data.isoittd_upload.selisih < 0 ) {
					$(row).addClass('bg-danger');
				}

				if ( data.isoittd_upload.selisih > 0 ) {
					$(row).addClass('bg-warning');
				}
			}
		} );

		tblisoittd_upload.searchPanes.container().appendTo('#spisoittd_upload');
		tblisoittd_upload.searchBuilder.container().appendTo( '#sbisoittd_upload' );

		tblisoittd_upload.button('btnSetExcel:name').disable();
		tblisoittd_upload.button('btnSetFisik:name').disable();
		tblisoittd_upload.button('btnSesuai:name').disable();
		tblisoittd_upload.button('btnSkip:name').disable();
		tblisoittd_upload.button('btnNol:name').disable();
		tblisoittd_upload.button('btnDuplicate:name').disable();
		tblisoittd_upload.button('btnPointer:name').disable();
		
		tblisoittd_upload.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblisoittd_upload_fisik];
			CekInitHeaderHD(tblisoittd_upload, tbl_details);
			
			tblisoittd_upload.button('btnSetFisik:name').disable();
			tblisoittd_upload.button('btnSesuai:name').disable();
			tblisoittd_upload.button('btnNol:name').disable();
			tblisoittd_upload.button('btnSkip:name').disable();
			tblisoittd_upload.button('btnDuplicate:name').disable();
			tblisoittd_upload.button('btnPointer:name').disable();
		} );
		
		tblisoittd_upload.on( 'select', function( e, dt, type, indexes ) {
			isoittd_upload_data    	= tblisoittd_upload.row( { selected: true } ).data().isoittd_upload;
			id_isoittd_upload      	= isoittd_upload_data.id;
			id_transaksi_h 		= id_isoittd_upload; // dipakai untuk general
			id_transaksi_log	= id_isoittd_upload; // dipakai untuk general
			transaction_state   = isoittd_upload_data.transaction_state;
			approval_state   	= isoittd_upload_data.approval_state;
			lpn   	= isoittd_upload_data.lpn;
			batch_number   	= isoittd_upload_data.batch_number;
			id_iimxxmh_old   	= isoittd_upload_data.id_iimxxmh;
			id_wloxxmh_old   	= isoittd_upload_data.id_wloxxmh;
			id_iumxxmh_old   	= isoittd_upload_data.id_iumxxmh_terkecil;
			expired   	= isoittd_upload_data.expired_date;
			selisih   	= isoittd_upload_data.selisih;
			fisik   	= isoittd_upload_data.fisik;
			
			// iimxxmh_data    	= tblisoittd_upload.row( { selected: true } ).data().iimxxmh;
			nama_item 		= isoittd_upload_data.nama;
			kode_item 		= isoittd_upload_data.kode;
			
			// iumxxmh_data    	= tblisoittd_upload.row( { selected: true } ).data().iumxxmh;
			kode_uom 		= isoittd_upload_data.satuan;
			
			// wloxxmh_data    	= tblisoittd_upload.row( { selected: true } ).data().wloxxmh;
			nama_lokasi 		= isoittd_upload_data.lokasi;
			is_skip_select 		= isoittd_upload_data.is_skip;
			id_files_pointer_old 		= isoittd_upload_data.id_files_pointer;
			id_foto_pointer_old 		= isoittd_upload_data.id_files_pointer;
			
			// atur hak akses
			tbl_details = [tblisoittd_upload_fisik];
			CekSelectHeaderHD(tblisoittd_upload, tbl_details);
			// rowIndex = indexes[0]; // Get the index of the first selected row
			// rowData = tblisoittd_upload.row(rowIndex).data();
			// console.log(rowIndex);		
			// console.log(rowData);
			tblisoittd_upload.button('btnSetFisik:name').enable();

			if (fisik == null) {
				tblisoittd_upload.button('btnNol:name').enable();		
				tblisoittd_upload.button('btnSesuai:name').enable();

			} else {
				tblisoittd_upload.button('btnSesuai:name').disable();
				tblisoittd_upload.button('btnNol:name').disable();
			}
			tblisoittd_upload.button('btnSkip:name').enable();
			tblisoittd_upload.button('btnDuplicate:name').enable();		
			tblisoittd_upload.button('btnPointer:name').enable();		

			//keperluan Button
			start_button = moment().format("YYYY-MM-DD HH:mm:ss");

			console.log(hak_u);
			if (hak_u == 1) {	
				tblisoittd_upload_fisik.button('btnCreate:name')
				.nodes()
				.css( 'display', 'block' );
			} else {
				tblisoittd_upload_fisik.button('btnCreate:name')
				.nodes()
				.css( 'display', 'none' );
			}
		} );
		
		tblisoittd_upload.on( 'deselect', function () {
			// reload dipanggil di function CekDeselectHeader
			id_isoittd_upload = 0, id_iwhxxmh_old = 0, id_iumxxmh_old = 0, id_iimxxmh_old = 0, id_wloxxmh_old = 0;
			nama_item = 0;
			kode_item = 0;
			kode_uom = 0;
			nama_lokasi = 0;
			is_skip_select = 0;
			id_files_pointer_old = 0;
			id_foto_pointer_old = 0;
			lpn = 0;
			batch_number = 0;
			expired = 0;
			start_button = "";
			
			// atur hak akses
			tbl_details = [tblisoittd_upload_fisik];
			CekDeselectHeaderHD(tblisoittd_upload, tbl_details);
			tblisoittd_upload.button('btnSesuai:name').disable();
			tblisoittd_upload.button('btnNol:name').disable();
			tblisoittd_upload.button('btnSetFisik:name').disable();
			tblisoittd_upload.button('btnSkip:name').disable();
			tblisoittd_upload.button('btnDuplicate:name').disable();
			tblisoittd_upload.button('btnPointer:name').disable();
		} );
		
		// END isoittd_upload
		
		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
				
			},
			submitHandler: function(frmFilter) {
				
				id_isoxxth_upload_filter  = $('#selectKode').val();
				selectedOption = $('#selectKode').select2('data')[0];
				if (selectedOption) {
					selectedText = selectedOption.text;
				}

				if (id_isoxxth_upload_filter > 0) {
					toastr["success"]("Load data berhasil","INFO")
					
					tblisoittd_upload.ajax.reload(function ( json ) {
					}, false);
					$('#modalSFisoittd_upload').modal('toggle');

					isUploadTransaksi();
					if (is_update_transaksi_h == 1 ) {
						tblisoittd_upload.button('btnSetExcel:name').disable();
					} else {
						tblisoittd_upload.button('btnSetExcel:name').enable();
					}
					return false; 
				}
				
			}
		});

		$('#frmUpload').submit(function(e) {
            e.preventDefault();

            var fileInput = document.getElementById('frmUploadExcel');
			var start_at = moment().format('YYYY-MM-DD HH:mm:ss');	

            if (fileInput.files.length > 0) {
                var file = fileInput.files[0];
                var fileName = file.name;
                var fileExt = fileName.split('.').pop().toLowerCase();

                // Check if the file extension is .xls or .xlsx
                if (fileExt !== 'xls' && fileExt !== 'xlsx') {
                    console.log('Invalid file type. Please select an Excel file.');
                    return;
                }

                console.log('Selected file:', file);

                var formData = new FormData();
                formData.append('filename', file);
                formData.append('start_at', start_at);
                formData.append('id_isoxxth_upload_filter', id_isoxxth_upload_filter);
				$.ajax( {
					url: "../../models/isoittd_upload/isoittd_upload_excel.php",
					type: 'POST',
					dataType: 'json',
					data: formData,
					contentType: false,
					processData: false,
					success: function ( json ) {
						
						full_message = json.data.message + '</br>';
						toast_type   = json.data.type_message;
						toastr[toast_type](full_message, 'INFO');
						$("#frmUploadExcel").val('');
						$('#modalUpload').modal('toggle');
						
						tblisoittd_upload.ajax.reload(null,false);
						
						isUploadTransaksi();
						if (is_update_transaksi_h == 1 ) {
							tblisoittd_upload.button('btnSetExcel:name').disable();
						} else {
							tblisoittd_upload.button('btnSetExcel:name').enable();
						}
					},
					error: function (xhr, Status, err){
						// console.log('x');
					}
				} );

            } else {
                console.log('No file selected.');
            }
        });

		// BEGIN isoittd_upload_fisik
		edtisoittd_upload_fisik = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/isoittd_upload/isoittd_upload_fisik.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_isoittd_upload_fisik = show_deleted_isoittd_upload_fisik;
					d.id_isoittd_upload = id_isoittd_upload;
				}
			},
			table: "#tblisoittd_upload_fisik",
			formOptions: {
				main: {
					focus: 12,
					onBackground: 'none'
				}
			},
			fields: [ 
				{
					label: "isoittd_upload_fisik.start_at",
					name: "isoittd_upload_fisik.start_at",
					type: "hidden"
				},	
				{
					label: "isoittd_upload_fisik.finish_at",
					name: "isoittd_upload_fisik.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "isoittd_upload_fisik",
					type: "hidden"
				},	
				{
					label: "isoittd_upload_fisik.transaction_state",
					name: "isoittd_upload_fisik.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_isoittd_upload",
					name: "isoittd_upload_fisik.id_isoittd_upload",
					type: "hidden"
				},	
				{
					label: "Kode Item",
					name: "kode_item",
					type: "readonly"
				}, 	
				{
					label: "Nama Item",
					name: "nama_item",
					type: "readonly"
				}, 	
				{
					label: "UoM",
					name: "uom",
					type: "readonly"
				}, 	
				{
					label: "Location",
					name: "location",
					type: "readonly"
				}, 	
				{
					label: "LPN",
					name: "lpn",
					type: "readonly"
				}, 	
				{
					label: "Batch Number",
					name: "batch_number",
					type: "readonly"
				}, 	
				{
					label: "Expired",
					name: "expired",
					type: "readonly"
				}, 	
				{
					label: "Fisik <sup class='text-danger'>*<sup>",
					name: "isoittd_upload_fisik.fisik"
				}, 	
				{
					label: "Images",
					name: "files[].id",
					type: "uploadMany",
					display: function ( fileId, counter ) {
						if (fileId == 0){
							return 'Belum ada lampiran';
						}else{
							return '<a href="'+edtisoittd_upload_fisik.file( 'files', fileId ).web_path+'" target="_blank">'+ edtisoittd_upload_fisik.file( 'files', fileId ).filename + '</a>'; 
						}
					},
				},	
				{
					label: "Keterangan",
					name: "isoittd_upload_fisik.keterangan",
					type: "textarea"
				}
			]
		} );
			
		edtisoittd_upload_fisik.on( 'preOpen', function( e, mode, action ) {
			edtisoittd_upload_fisik.field('isoittd_upload_fisik.id_isoittd_upload').val(id_isoittd_upload);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtisoittd_upload_fisik.field('isoittd_upload_fisik.start_at').val(start_at);
			
			if(action == 'create'){
				tblisoittd_upload_fisik.rows().deselect();
			}
			
			edtisoittd_upload_fisik.field('nama_item').val(nama_item);
			edtisoittd_upload_fisik.field('kode_item').val(kode_item);
			edtisoittd_upload_fisik.field('uom').val(kode_uom);
			edtisoittd_upload_fisik.field('location').val(nama_lokasi);
			edtisoittd_upload_fisik.field('lpn').val(lpn);
			edtisoittd_upload_fisik.field('batch_number').val(batch_number);
			edtisoittd_upload_fisik.field('expired').val(expired);
			
		});

		edtisoittd_upload_fisik.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});

		edtisoittd_upload_fisik.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				fisik           = edtisoittd_upload_fisik.field('isoittd_upload_fisik.fisik').val();

				validasiRequired(
					edtisoittd_upload_fisik,
					'isoittd_upload_fisik',
					{
						'fisik': fisik,
					}
				);

				validasiNumber(
					edtisoittd_upload_fisik,
					'isoittd_upload_fisik',
					{
						'fisik': fisik
					},
					0,
					'>='
				);
			}
			
			if ( edtisoittd_upload_fisik.inError() ) {
				return false;
			}
		});

		edtisoittd_upload_fisik.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtisoittd_upload_fisik.field('isoittd_upload_fisik.finish_at').val(finish_at);
		});
			
		edtisoittd_upload_fisik.on( 'postSubmit', function (e, json, data, action, xhr) {
			subtotalFisik(id_transaksi_h);

			tblisoittd_upload_fisik.rows().deselect();
			tblisoittd_upload_fisik.ajax.reload(null,false);

			tblisoittd_upload.rows().deselect();
			tblisoittd_upload.ajax.reload(null,false);
			// tblisoittd_upload.row(rowIndex).data(rowData).draw(false);
			
		} );

		edtisoittd_upload_fisik.on( 'close', function () {
			edtisoittd_upload_fisik.enable();
		} );
		
		tblisoittd_upload_fisik = $('#tblisoittd_upload_fisik').DataTable( {
			dom: "<'row'<'col-lg-6 col-md-12 col-sm-12 col-xs-12'B>>" +
				"<'row'<'col-lg-12 col-md-12 col-sm-12 col-xs-12'tr>>",
			ajax: {
				url: "../../models/isoittd_upload/isoittd_upload_fisik.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_isoittd_upload_fisik = show_deleted_isoittd_upload_fisik;
					d.id_isoittd_upload = id_isoittd_upload;
				}
			},
			order: [[ 2, "desc" ]],
			responsive: true,
			// scrollX: true,
			columns: [
				{ data: "isoittd_upload_fisik.id",visible:false },
				{ data: "isoittd_upload_fisik.id_isoittd_upload",visible:false },
				{ 
					data: "isoittd_upload_fisik.fisik",
					...renderNumber()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_isoittd_upload_fisik';
					$table       = 'tblisoittd_upload_fisik';
					$edt         = 'edtisoittd_upload_fisik';
					$show_status = '_isoittd_upload_fisik';
					$table_name  = $nama_tabels_d[0];

					$arr_buttons_tools 		= [];
					$arr_buttons_tools2 	= [];
					$arr_buttons_action 	= [];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php';
				?>
				// END breaking generate button
				{ 
					extend: 'create',
					name: 'btnCreate', 
					editor: edtisoittd_upload_fisik, 
					text: '<i class="fa fa-plus"></i>&nbsp;Add New', 
					className: 'btn btn-sm btn-primary', 
					titleAttr: 'Add New',
					formButtons: [
						{
							text: 'Cancel',
							action: function () {
								this.close();
							},
							className: 'btn btn-warning m-r-xs'
						},
						{
							text: 'Save',
							action: function () {
								this.submit();
							},
							className: 'btn btn-primary m-r-xs'
						},
						{
							text: 'Save & Confirm',
							action: function (e, dt, node, config, cb){
								this.submit(
									function (json) {
										id_transaksi_h = json.data[0].tblisoittd_upload_fisik.id;
										fnConfirm('tblisoittd_upload_fisik', tblisoittd_upload_fisik );
									}, 
								);
								
								

							},
							className: 'btn btn-primary'
						}
					]
				},
				
				{ 
					extend: 'edit', 
					name: 'btnEdit', 
					editor: edtisoittd_upload_fisik,
					text: '<i class="fa fa-edit"></i>&nbsp;Edit',
					className: 'btn btn-sm btn-warning',
					titleAttr: 'Edit',
					formButtons: [
						{
							text: 'Cancel',
							action: function () {
								this.close();
							},
							className: 'btn btn-warning m-r-xs'
						},
						{
							text: 'Save',
							action: function () {
								this.submit();
							},
							className: 'btn btn-primary m-r-xs'
						},
						{
							text: 'Save & Confirm',
							action: function (e, dt, node, config, cb){
								this.submit(
									function (json) {
										id_transaksi_h = json.data[0].tblisoittd_upload_fisik.id;
										fnConfirm('tblisoittd_upload_fisik', tblisoittd_upload_fisik ); 
									}, 
								);
								
								

							},
							className: 'btn btn-primary'
						}
					]
				},
				
				{
					extend: 'remove', 
					name: 'btnRemove',
					editor: edtisoittd_upload_fisik, 
					text: '<i class="fa fa-trash"></i>&nbsp;Delete(xH)',
					className: 'btn btn-sm btn-danger',
					titleAttr: 'Remove',
					formButtons: [
						{
							text: 'Cancel',
							action: function () {
								this.close();
							},
							className: 'btn btn-warning m-r-xs'
						},
						{
							text: 'Delete',
							action: function () {
								this.submit();
							},
							className: 'btn btn-danger'
						}
					]
				},
				{
					extend: "selected",
					name: 'btnView',
					text: '<i class="fa fa-window-maximize"></i>&nbsp;View Data',
					className: 'btn btn-sm',
					titleAttr: 'View Data',
					action: function(e, dt, node, config) {
						edtisoittd_upload_fisik.edit(tblisoittd_upload_fisik.row({
							selected: true
						}).index(), {
							title: 'View'
						}).buttons(
							{
								text: 'Close',
								action: function () {
									this.close();
								},
								className: 'btn btn-warning'
							}
						);
						edtisoittd_upload_fisik.disable();
						e.preventDefault();
					}
				},
				{
					extend: "selected",
					name: 'btnLog',
					text: '<i class="fa fa-history"></i>&nbsp;View Log',
					className: 'btn btn-sm',
					titleAttr: 'View Data Log',
					action: function(e, dt, node, config) {
						e.preventDefault();
						$("#mdlLog").modal("show");

						$.ajax({
							url: '../../../helpers/fn_log_view.php',
							dataType: 'json',
							type: 'POST',
							async: false,
							data: {
								table_name	 : 'isoittd_upload_fisik',
								id_transaksi : id_transaksi_log_d,
							},
							success: function(json) {
								str_log = '';
								log_data = json.data.rs_activity_log_ml;
								$.each(log_data, function(index, value) {
									
									switch(log_data[index].kode) {
										case 'CREATE':
											badgeClass = 'warning';
											break;
										case 'EDIT':
											badgeClass = 'info';
											break;
										case 'DELETE':
											badgeClass = 'danger';
											break;
										case 'CONFIRM':
											badgeClass = 'primary';
											break;
										case 'CLOSE':
											badgeClass = 'danger';
											break;
										case 'APPROVE':
											badgeClass = 'primary';
											break;
										case 'VOID':
											badgeClass = 'danger';
											break;
										case 'INVALID CODE':
											badgeClass = 'warning';
											break;
										default:
											badgeClass = 'plain';
									}

									str_log =   str_log + 
												'<span class=\"badge badge-' + 
												badgeClass + '\">' + 
												log_data[index].kode + 
												'</span> by ' + 
												log_data[index].username + 
												' at ' + 
												log_data[index].created_on + 
												'</br>';
								});
								$("#contentLog").html(str_log);
							}
						});
					}
				},
			],
			initComplete: function() {
			}
		} );

		tblisoittd_upload_fisik.on( 'draw', function( e, settings ) { 
			// atur hak akses
			// cek_c_detail= 1;
			// CekDrawDetailHD(tblisoittd_upload, tblisoittd_upload_fisik, 'isoittd_upload_fisik' );
			
			CekDrawDetailHD(tblisoittd_upload_fisik, 1);
			CekDrawDetailHDFinal(tblisoittd_upload);
		} );

		tblisoittd_upload_fisik.on( 'select', function( e, dt, type, indexes ) {
			data_isoittd_upload_fisik 		= tblisoittd_upload_fisik.row( { selected: true } ).data().isoittd_upload_fisik;
			id_isoittd_upload_fisik   		= data_isoittd_upload_fisik.id;
			id_transaksi_d 		= id_isoittd_upload_fisik; // dipakai untuk general
			id_transaksi_log_d  = id_isoittd_upload_fisik; // dipakai untuk log

			transaction_state_d   = data_isoittd_upload_fisik.transaction_state;
			// atur hak akses
			// CekSelectDetailHD(tblisoittd_upload, tblisoittd_upload_fisik );
			CekSelectDetailHD(tblisoittd_upload_fisik );

			console.log(hak_u);
			if (hak_u == 1) {	
				tblisoittd_upload_fisik.button('btnEdit:name')
				.nodes()
				.css( 'display', 'block' );
				tblisoittd_upload_fisik.button('btnRemove:name')
				.nodes()
				.css( 'display', 'block' );
			} else {
				tblisoittd_upload_fisik.button('btnEdit:name')
				.nodes()
				.css( 'display', 'none' );
				tblisoittd_upload_fisik.button('btnRemove:name')
				.nodes()
				.css( 'display', 'none' );
			}
		} );

		tblisoittd_upload_fisik.on( 'deselect', function() {
			id_isoittd_upload_fisik = 0;
			id_fbnxxmh_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD(tblisoittd_upload, tblisoittd_upload_fisik );
		} );

		// END isoittd_upload_fisik
		
	} );// end of document.ready
	
</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
