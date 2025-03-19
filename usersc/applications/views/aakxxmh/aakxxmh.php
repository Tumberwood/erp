<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'aakxxmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->

<div class="modal" id="modalUpload" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content animated bounceInRight">
			<form class="form-horizontal" id="frmUploadMaster" enctype="multipart/form-data">
				<div class="modal-header">
					<h4 class="modal-title">Upload Master Akun</h4>
				</div>
				<div class="modal-body">
					<div class="form-group row">
						<label class="col-lg-2 col-form-label">File Excel</label>
						<div class="col-sm-4">
							<div class="input-group">
								<input type="file" name="filename" class="form-control" id="frmUploadAkun">
							</div>
						</div>
						<div class="col-sm-4">
							<button type="button" class="btn btn-success" onclick="window.open('../../../files/template_file_upload/Template Master COA.xlsx');">
								<i class="fa fa-download"></i>&nbsp;&nbsp;<span class="bold">Template</span>
							</button>
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

<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblaakxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th data-i18n="code"></th>
                                <th data-i18n="name"></th>
                                <th data-i18n="parentAccount"></th>
                                <th>Account Type</th>
                                <th data-i18n="state"></th>
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
<script src="<?=$us_url_root?>usersc/helpers/language.js"></script>
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/aakxxmh/fn/aakxxmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtaakxxmh, tblaakxxmh, show_deleted_aakxxmh = 0, id_aakxxmh;
	// ------------- end of default variable
	var id_aatxxmh_old = 0, id_aakxxmh_parent_old = 0;

	// get tableRelation
	tableRelation('aakxxmh');

	$(document).ready(function() {
		
		// BEGIN aakxxmh
		edtaakxxmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/aakxxmh/aakxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_aakxxmh = show_deleted_aakxxmh;
				}
			},
			table: "#tblaakxxmh",
			fields: [ 
				{
					label: "aakxxmh.start_at",
					name: "aakxxmh.start_at",
					type: "hidden"
				},	
				{
					label: "aakxxmh.finish_at",
					name: "aakxxmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "aakxxmh",
					type: "hidden"
				},	
				{
					label: "aakxxmh.transaction_state",
					name: "aakxxmh.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: getTranslation('code') + " <sup class='text-danger'>*<sup>",
					name: "aakxxmh.kode"
				}, 	
				{
					label: getTranslation('name') + " <sup class='text-danger'>*<sup>",
					name: "aakxxmh.nama"
				},
				{
					label: getTranslation('isParentAccount') + " <sup class='text-danger'>*<sup>",
					name: "aakxxmh.is_parent",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": "Yes", "value": 1 },
						{ "label": "No", "value": 0 }
					]
				},
				{
					label: getTranslation('parentAccount'),
					name: "aakxxmh.id_aakxxmh_parent",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/aakxxmh/aakxxmh_fn_opt_parent.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_aakxxmh_old: id_aakxxmh_parent_old,
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
					label: "Account Type <sup class='text-danger'>*<sup>",
					name: "aakxxmh.id_aatxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/aatxxmh/aatxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_aatxxmh_old: id_aatxxmh_old,
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
					label: getTranslation('beginningBalance') + "<sup class='text-danger'>*<sup>",
					name: "aakxxmh.saldo_awal"
				},
				{
					label: getTranslation('beginningBalanceDate') + "<sup class='text-danger'>*<sup>",
					name: "aakxxmh.saldo_awal_tanggal",
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
			]
		} );

		
		unmaskedData = maskingNumber(
			edtaakxxmh, 
			"aakxxmh", 
			[
				"saldo_awal", 
			],
			0, //digit belakang koma
			0, //validasiNumber 
			'>=' // val >= 0
		);

		edtaakxxmh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtaakxxmh.field('aakxxmh.start_at').val(start_at);
			
			if(action == 'create'){
				tblaakxxmh.rows().deselect();
			}else if(action == 'edit'){
				
				if(transaction_state == 0){
					edtaakxxmh.field('aakxxmh.kode').enable();
					edtaakxxmh.field('aakxxmh.nama').enable();
				}else{
					edtaakxxmh.field('aakxxmh.kode').disable();
					edtaakxxmh.field('aakxxmh.nama').disable();
				}

				if(saldo_awal !=null && saldo_awal_tanggal != null ){
					edtaakxxmh.field('aakxxmh.saldo_awal').disable();
					edtaakxxmh.field('aakxxmh.saldo_awal_tanggal').disable();
				}else{
					edtaakxxmh.field('aakxxmh.saldo_awal').enable();
					edtaakxxmh.field('aakxxmh.saldo_awal_tanggal').enable();
				}
			}
		});

		edtaakxxmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edtaakxxmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				kode = edtaakxxmh.field('aakxxmh.kode').val();
				id_aatxxmh = edtaakxxmh.field('aakxxmh.id_aatxxmh').val();
				nama = edtaakxxmh.field('aakxxmh.nama').val();
				saldo_awal_tanggal = edtaakxxmh.field('aakxxmh.saldo_awal_tanggal').val();

				validasiRequired(
					edtaakxxmh,
					'aakxxmh',
					{
						'kode': kode,
						'id_aatxxmh': id_aatxxmh,
						'nama': nama,
						'saldo_awal_tanggal': saldo_awal_tanggal,
					}
				);

				validasiUnique(
					action,
					edtaakxxmh,
					'aakxxmh',
					'kode',
					'kode',
					'"'+kode+'"',
					id_aakxxmh
				);

				validasiUnique(
					action,
					edtaakxxmh,
					'aakxxmh',
					'nama',
					'nama',
					'"'+nama+'"',
					id_aakxxmh
				);

			}
			
			if ( edtaakxxmh.inError() ) {
				return false;
			}
		});
		
		edtaakxxmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtaakxxmh.field('aakxxmh.finish_at').val(finish_at);
		});

		edtaakxxmh.on('postSubmit', function(e, json, data, action, xhr) {
			tblaakxxmh.rows().deselect();
			tblaakxxmh.ajax.reload(null, false);
		});

		edtaakxxmh.on( 'close', function () {
			edtaakxxmh.enable();
		} );

		tblaakxxmh = $('#tblaakxxmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/aakxxmh/aakxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_aakxxmh = show_deleted_aakxxmh;
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
				{ data: "aakxxmh.id",visible:false },
				{ data: "aakxxmh.kode" , type: 'string'},
				{ data: "aakxxmh.nama" },
				{ data: "aakxxmh_parent.nama" },
				{ data: "aatxxmh.nama" },
				{ 
					data: "aakxxmh.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_aakxxmh';
					$table       = 'tblaakxxmh';
					$edt         = 'edtaakxxmh';
					$show_status = '_aakxxmh';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= ['sp', 'sb'];
					$arr_buttons_action 	= ['create', 'edit', 'remove', 'confirm', 'nonaktif_h', 'close', 'view', 'log','noaction'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
				{
					name: 'btnUpload',
					text: '<i class="fa fa-file-excel-o"></i>',
					className: 'btn btn-primary',
					titleAttr: 'Upload Master Akun',
					action: function ( e, dt, node, config ) {
						$('#modalUpload').modal('toggle');
					}
				}
				// END breaking generate button
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
				if ( data.aakxxmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.aakxxmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblaakxxmh.searchPanes.container().appendTo('#spaakxxmh');
		tblaakxxmh.searchBuilder.container().appendTo( '#sbaakxxmh' );
		
		tblaakxxmh.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblaakxxmh);
		} );
		
		tblaakxxmh.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('aakxxmh');
			id_aakxxmh_parent_old = aakxxmh_data.id_aakxxmh_parent;
			id_aatxxmh_old = aakxxmh_data.id_aatxxmh;
			saldo_awal = aakxxmh_data.saldo_awal;
			saldo_awal_tanggal = aakxxmh_data.saldo_awal_tanggal;
			
			// atur hak akses
			CekSelectHeaderH(tblaakxxmh);
		} );

		tblaakxxmh.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('aakxxmh');
			id_aakxxmh_parent_old = 0;
			id_aatxxmh_old = 0;
			saldo_awal = null, saldo_awal_tanggal = null;

			// atur hak akses
			CekDeselectHeaderH(tblaakxxmh);
		} );
		
		// END aakxxmh
	
		//upload master aakxxmh
		var frmUploadMaster = $("#frmUploadMaster").submit(function(e) {
			e.preventDefault();
			// $('#submit_ceklok').hide();
		}).validate({

			submitHandler: function(form) { 
				
				toastr.info("Processing ...\nJangan tutup halaman sampai notifikasi ini hilang!", "INFO");

				//aakxxmh
				var fd_aakxxmh = new FormData();
				var aakxxmh = $('#frmUploadAkun')[0].files[0];
				if (aakxxmh != undefined) {
					fd_aakxxmh.append('filename',aakxxmh);
		
					$.ajax( {
						url: "../../models/aakxxmh/aakxxmh_upload.php",
						type: 'POST',
						dataType: 'json',
						data: fd_aakxxmh,
						async: false,
						contentType: false,
						processData: false,
						success: function ( json ) {
							
							full_message = json.data.message + '</br>';
							toast_type   = json.data.type_message;
							toastr[toast_type](full_message, 'INFO');
							$("#frmUploadAkun").val('');
							tblaakxxmh.ajax.reload(null,false);
							$('#modalUpload').modal('toggle');
							// $('#submit_ceklok').show();
						},
						error: function (xhr, Status, err){
							// console.log('x');
						}
					} );
				}
			}
		});
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
