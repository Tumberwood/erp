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

<div class="row">
    <div class="col">
        <div class="ibox collapsed" id="iboxfilter">
            <div class="ibox-title">
                <h5 class="text-navy">Filter</h5>&nbsp
                <button class="btn btn-primary btn-xs collapse-link"><i class="fa fa-chevron-up"></i></button>
            </div>
            <div class="ibox-content">
                <form class="form-horizontal" id="frmisoittd_upload">
					<div class="form-group row">
						<label class="col-lg-2 col-md-2">Kode</label>
						<div class="col-lg-4 col-sm-4">
							<select class="form-control" id="selectKode" name="selectKode" multiple="multiple"></select>
						</div>
					</div>
                    <div class="form-group row">
                        <div class="col-lg-4">
                            <button class="btn btn-primary" type="submit" id="go">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="tabel_atas" style="display: none">
	<div class="row">
		<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12 p-w-xs">
			<div class="ibox ">
				<div class="ibox-content">
					<!-- start Custom Form Datatables Editor -->
					<div id="custom_isoittd_upload">
						<div class="panel-body">
							<div class="row">
								<div class="col-lg-6">
									<editor-field name="isoittd_upload.id_iimxxmh"></editor-field>
								</div>
								<div class="col-lg-6">
									<editor-field name="isoittd_upload.id_iumxxmh_terkecil"></editor-field>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<editor-field name="isoittd_upload.id_wloxxmh"></editor-field>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<editor-field name="isoittd_upload.jumlah_terkecil"></editor-field>
								</div>
								<div class="col-lg-6">
									<editor-field name="isoittd_upload.lpn"></editor-field>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<editor-field name="isoittd_upload.batch_number"></editor-field>
								</div>
								<div class="col-lg-6">
									<editor-field name="isoittd_upload.expired_date"></editor-field>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<editor-field name="isoittd_upload.keterangan"></editor-field>
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
									<th>Warehouse</th>
									<th>Item Code</th>
									<th>Item Name</th>
									<th>UoM</th>
									<th>Quantity</th>
									<th>Fisik</th>
									<th>Selisih</th>
									<th>Location</th>
									<th>Location Zone</th>
									<th>LPN</th>
									<th>Batch Number</th>
									<th>Expired Date</th>
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

<div id="tabel_bawah">
	<h3 class="text-center">Tabel Akan muncul ketika melakukan submit Filter dengan mengisi Kode!!!</h3>
</div>

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
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn.js"></script>

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
	var id_iumxxmh_old = 0;
	var id_wloxxmh_old = 0;
	var id_isoxxth_upload_filter = 0;
	var selectedText = null;
	

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
					label: "Item <sup class='text-danger'>*<sup>", 
					name: "isoittd_upload.id_iimxxmh",
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
					name: "isoittd_upload.id_iumxxmh_terkecil",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/iumxxmh/iumxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_iumxxmh_old: id_iumxxmh_old,
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
					label: "Location <sup class='text-danger'>*<sup>", 
					name: "isoittd_upload.id_wloxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/wloxxmh/wloxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_wloxxmh_old: id_wloxxmh_old,
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
					label: "LPN <sup class='text-danger'>*<sup>",
					name: "isoittd_upload.lpn"
				}, 	
				{
					label: "Batch Number <sup class='text-danger'>*<sup>",
					name: "isoittd_upload.batch_number"
				}, 	
				{
					label: "Expired Date",
					name: "isoittd_upload.expired_date",
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
					label: "Keterangan",
					name: "isoittd_upload.keterangan",
					type: "textarea"
				}
			]
		} );
		
		edtisoittd_upload.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtisoittd_upload.field('isoittd_upload.start_at').val(start_at);
			edtisoittd_upload.field('isoittd_upload.id_isoxxth_upload').val(id_isoxxth_upload_filter);

			if(action == 'create'){
				tblisoittd_upload.rows().deselect();

				edtisoittd_upload.field('isoittd_upload.id_iimxxmh').enable();

			}else if(action == 'edit'){

				if(transaction_state == 0){
					edtisoittd_upload.field('isoittd_upload.id_iimxxmh').enable();
				}else{
					edtisoittd_upload.field('isoittd_upload.id_iimxxmh').disable();
				}
			}
		});

		edtisoittd_upload.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-xl");
		});

		edtisoittd_upload.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				id_iumxxmh_terkecil      = edtisoittd_upload.field('isoittd_upload.id_iumxxmh_terkecil').val();
				id_iimxxmh = edtisoittd_upload.field('isoittd_upload.id_iimxxmh').val();
				id_wloxxmh         = edtisoittd_upload.field('isoittd_upload.id_wloxxmh').val();
				jumlah_terkecil           = edtisoittd_upload.field('isoittd_upload.jumlah_terkecil').val();
				lpn          = edtisoittd_upload.field('isoittd_upload.lpn').val();
				batch_number              = edtisoittd_upload.field('isoittd_upload.batch_number').val();
				expired_date              = edtisoittd_upload.field('isoittd_upload.expired_date').val();

				validasiRequired(
					edtisoittd_upload,
					'isoittd_upload',
					{
						'id_iumxxmh_terkecil': id_iumxxmh_terkecil,
						'id_iimxxmh': id_iimxxmh,
						'id_wloxxmh': id_wloxxmh,
						'jumlah_terkecil': jumlah_terkecil,
						'lpn': lpn,
						'batch_number': batch_number,
						'expired_date': expired_date,
					}
				);

				validasiNumber(
					edtisoittd_upload,
					'isoittd_upload',
					{
						'jumlah_terkecil': jumlah_terkecil
					},
					0,
					'>'
				);
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
			tblisoittd_upload.ajax.reload(null,false);
		} );

		edtisoittd_upload.on( 'close', function () {
			edtisoittd_upload.enable();
		} );
		
		tblisoittd_upload = $('#tblisoittd_upload').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			// serverSide : true,
			ajax: {
				url: "../../models/isoittd_upload/isoittd_upload.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_isoittd_upload = show_deleted_isoittd_upload;
					d.id_isoxxth_upload_filter = id_isoxxth_upload_filter;
				}
			},
			order: [[ 1, "asc" ]],
			columnDefs:[
				{
					searchPanes:{
						show: true,
					},
					targets: [2,3,8,9]
				},
				{
					searchPanes:{
						show: false,
					},
					targets: '_all'
				}
			],
			columns: [
				{ data: "isoittd_upload.id",visible:false },
				{ data: "iwhxxmh.nama" },
				{ data: "iimxxmh.kode" },
				{ data: "iimxxmh.nama" },
				{ data: "iumxxmh.kode" },
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
					...renderNumber()
				},
				{ data: "wloxxmh.nama" }, //8
				{ data: "wloznmh.nama" }, //9
				{ data: "isoittd_upload.lpn" },
				{ data: "isoittd_upload.batch_number" },
				{ data: "isoittd_upload.expired_date" },
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
					$arr_buttons_tools2 	= [];
					$arr_buttons_action 	= ['create', 'edit', 'remove_hd', 'confirm', 'nonaktif_hd', 'close', 'view', 'log','noaction'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
				// END breaking generate button
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
			}
		} );

		tblisoittd_upload.searchPanes.container().appendTo('#spisoittd_upload');
		tblisoittd_upload.searchBuilder.container().appendTo( '#sbisoittd_upload' );
		
		tblisoittd_upload.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblisoittd_upload_fisik];
			CekInitHeaderHD(tblisoittd_upload, tbl_details);
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
			
			iimxxmh_data    	= tblisoittd_upload.row( { selected: true } ).data().iimxxmh;
			nama_item 		= iimxxmh_data.nama;
			kode_item 		= iimxxmh_data.kode;
			
			iumxxmh_data    	= tblisoittd_upload.row( { selected: true } ).data().iumxxmh;
			kode_uom 		= iumxxmh_data.kode;
			
			wloxxmh_data    	= tblisoittd_upload.row( { selected: true } ).data().wloxxmh;
			nama_lokasi 		= wloxxmh_data.nama;
			
			// atur hak akses
			tbl_details = [tblisoittd_upload_fisik];
			CekSelectHeaderHD(tblisoittd_upload, tbl_details);
			// rowIndex = indexes[0]; // Get the index of the first selected row
			// rowData = tblisoittd_upload.row(rowIndex).data();
			// console.log(rowIndex);		
			// console.log(rowData);		
		} );
		
		tblisoittd_upload.on( 'deselect', function () {
			// reload dipanggil di function CekDeselectHeader
			id_isoittd_upload = 0, id_iwhxxmh_old = 0, id_iumxxmh_old = 0, id_iimxxmh_old = 0, id_wloxxmh_old = 0;
			nama_item = 0;
			kode_item = 0;
			kode_uom = 0;
			nama_lokasi = 0;
			lpn = 0;
			batch_number = 0;
			expired = 0;
			
			// atur hak akses
			tbl_details = [tblisoittd_upload_fisik];
			CekDeselectHeaderHD(tblisoittd_upload, tbl_details);
		} );
		
		// END isoittd_upload
		
		$("#frmisoittd_upload").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
				
			},
			submitHandler: function(frmisoittd_upload) {
				
				id_isoxxth_upload_filter  = $('#selectKode').val();
				selectedOption = $('#selectKode').select2('data')[0];
				if (selectedOption) {
					selectedText = selectedOption.text;
				}

				if (id_isoxxth_upload_filter > 0) {
					$('#tabel_atas').show();
					
					notifyprogress = $.notify({
						message: 'Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!'
					},{
						z_index: 9999,
						allow_dismiss: false,
						type: 'info',
						delay: 0
					});

					tblisoittd_upload.ajax.reload(function ( json ) {
						notifyprogress.close();
					}, false);
					return false; 
				}
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
					focus: 3
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
					'>'
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
			tblisoittd_upload_fisik.ajax.reload(null, false);
			tblisoittd_upload.ajax.reload(null, false);
			// tblisoittd_upload.row(rowIndex).data(rowData).draw(false);
			
		} );

		edtisoittd_upload_fisik.on( 'close', function () {
			edtisoittd_upload_fisik.enable();
		} );
		
		tblisoittd_upload_fisik = $('#tblisoittd_upload_fisik').DataTable( {
			dom: dom0,
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

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_action 	= ['create', 'edit', 'remove','view', 'log_d','noactionD'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php';
				?>
				// END breaking generate button
			],
			initComplete: function() {
			}
		} );

		tblisoittd_upload_fisik.on( 'draw', function( e, settings ) { 
			// atur hak akses
			cek_c_detail= 1;
			CekDrawDetailHD(tblisoittd_upload, tblisoittd_upload_fisik, 'isoittd_upload_fisik' );
			CekDrawDetailHDFinal(tblisoittd_upload);
		} );

		tblisoittd_upload_fisik.on( 'select', function( e, dt, type, indexes ) {
			data_isoittd_upload_fisik 		= tblisoittd_upload_fisik.row( { selected: true } ).data().isoittd_upload_fisik;
			id_isoittd_upload_fisik   		= data_isoittd_upload_fisik.id;
			id_transaksi_d 		= id_isoittd_upload_fisik; // dipakai untuk general
			id_transaksi_log_d  = id_isoittd_upload_fisik; // dipakai untuk log

			transaction_state_d   = data_isoittd_upload_fisik.transaction_state;
			// atur hak akses
			CekSelectDetailHD(tblisoittd_upload, tblisoittd_upload_fisik );
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
