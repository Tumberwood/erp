<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'wloxxmh_upload';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="modal" id="modalUpload" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content animated bounceInRight">
			<form class="form-horizontal" id="frmUploadMaster" enctype="multipart/form-data">
				<div class="modal-header">
					<h4 class="modal-title">Upload Master Location</h4>
				</div>
				<div class="modal-body">
					<div class="form-group row">
						<label class="col-lg-2 col-form-label">File Excel</label>
						<div class="col-sm-4">
							<div class="input-group">
								<input type="file" name="filename" class="form-control" id="frmUploadLocation">
							</div>
						</div>
						<div class="col-sm-4">
							<button type="button" class="btn btn-success" onclick="window.open('../../../files/uploads/template_master_location.xlsx');">
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
                    <table id="tblwloxxmh_upload" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Company</th>
                                <th>Cabang</th>
                                <th>Warehouse</th>
                                <th>Kode Lokasi</th>
                                <th>Nama Lokasi</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/wloxxmh_upload/fn/wloxxmh_upload_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
		// ------------- default variable, do not erase
		var edtwloxxmh_upload, tblwloxxmh_upload, show_deleted_wloxxmh_upload = 0, id_wloxxmh_upload;
		// ------------- end of default variable

		// get tableRelation
		tableRelation('wloxxmh_upload');

		$(document).ready(function() {
			// BEGIN wloxxmh_upload
			edtwloxxmh_upload = new $.fn.dataTable.Editor( {
				ajax: {
					url: "../../models/wloxxmh_upload/wloxxmh_upload.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_wloxxmh_upload = show_deleted_wloxxmh_upload;
					}
				},
				table: "#tblwloxxmh_upload",
				fields: [ 
					{
						label: "wloxxmh_upload.start_at",
						name: "wloxxmh_upload.start_at",
						type: "hidden"
					},	
					{
						label: "wloxxmh_upload.finish_at",
						name: "wloxxmh_upload.finish_at",
						type: "hidden"
					},	
					{
						label: "nama_tabel",
						name: "nama_tabel",
						def: "wloxxmh_upload",
						type: "hidden"
					},	
					{
						label: "wloxxmh_upload.transaction_state",
						name: "wloxxmh_upload.transaction_state",
                        type: "hidden",
						def: 0
					},	
					{
						label: "Company <sup class='text-danger'>*<sup>",
						name: "wloxxmh_upload.company"
					}, 	
					{
						label: "Cabang <sup class='text-danger'>*<sup>",
						name: "wloxxmh_upload.cabang"
					}, 	
					{
						label: "Warehouse <sup class='text-danger'>*<sup>",
						name: "wloxxmh_upload.warehouse"
					}, 	
					{
						label: "Kode <sup class='text-danger'>*<sup>",
						name: "wloxxmh_upload.kode"
					}, 	
					{
						label: "Nama <sup class='text-danger'>*<sup>",
						name: "wloxxmh_upload.nama"
					}
				]
			} );

			edtwloxxmh_upload.on( 'preOpen', function( e, mode, action ) {
				start_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtwloxxmh_upload.field('wloxxmh_upload.start_at').val(start_at);

				if(action == 'create'){
					tblwloxxmh_upload.rows().deselect();
					edtwloxxmh_upload.field('wloxxmh_upload.kode').enable();
					edtwloxxmh_upload.field('wloxxmh_upload.nama').enable();
				}else if(action == 'edit'){
					if(transaction_state == 0){
						edtwloxxmh_upload.field('wloxxmh_upload.kode').enable();
						edtwloxxmh_upload.field('wloxxmh_upload.nama').enable();
					}else{
						edtwloxxmh_upload.field('wloxxmh_upload.kode').disable();
						edtwloxxmh_upload.field('wloxxmh_upload.nama').disable();
					}
				}
			});

			edtwloxxmh_upload.on("open", function (e, mode, action) {
				$(".modal-dialog").addClass("modal-lg");

				// enable disable tombol Save & Confirm
				edtFormButtonSaveConfirm();
			});

            edtwloxxmh_upload.on( 'preSubmit', function (e, data, action) {
				if(action != 'remove'){
					kode = edtwloxxmh_upload.field('wloxxmh_upload.kode').val();
					cabang = edtwloxxmh_upload.field('wloxxmh_upload.cabang').val();
					company = edtwloxxmh_upload.field('wloxxmh_upload.company').val();
					warehouse = edtwloxxmh_upload.field('wloxxmh_upload.warehouse').val();
					nama = edtwloxxmh_upload.field('wloxxmh_upload.nama').val();

					validasiRequired(
						edtwloxxmh_upload,
						'wloxxmh_upload',
						{
							'kode': kode,
							'cabang': cabang,
							'company': company,
							'warehouse': warehouse,
							'nama': nama
						}
					);

					validasiUnique(
						action,
						edtwloxxmh_upload,
						'wloxxmh_upload',
						'kode',
						'kode',
						'"'+kode+'"',
						id_wloxxmh_upload
					);

					validasiUnique(
						action,
						edtwloxxmh_upload,
						'wloxxmh_upload',
						'nama',
						'nama',
						'"'+nama+'"',
						id_wloxxmh_upload
					);
				}
				
				if ( edtwloxxmh_upload.inError() ) {
					return false;
				}
			});
			
			edtwloxxmh_upload.on('initSubmit', function(e, action) {
				finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtwloxxmh_upload.field('wloxxmh_upload.finish_at').val(finish_at);
			});

			edtwloxxmh_upload.on( 'close', function () {
				edtwloxxmh_upload.enable();
			} );

			tblwloxxmh_upload = $('#tblwloxxmh_upload').DataTable( {
				dom: domPQ,
				searchPanes:{
					layout: 'columns-4',
				},
				ajax: {
					url: "../../models/wloxxmh_upload/wloxxmh_upload.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_wloxxmh_upload = show_deleted_wloxxmh_upload;
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
						targets: [0]
					}
				],
				columns: [
					{ data: "wloxxmh_upload.id",visible:false },
					{ data: "wloxxmh_upload.company" },
					{ data: "wloxxmh_upload.cabang" },
					{ data: "wloxxmh_upload.warehouse" },
					{ data: "wloxxmh_upload.kode" , type: 'string'},
					{ data: "wloxxmh_upload.nama" },
					{ 
						data: "wloxxmh_upload.transaction_state" ,
						...renderTransactionStatus()
					}
				],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_wloxxmh_upload';
						$table       = 'tblwloxxmh_upload';
						$edt         = 'edtwloxxmh_upload';
						$show_status = '_wloxxmh_upload';
						$table_name  = $nama_tabel;

						$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
						$arr_buttons_tools2 	= ['sp', 'sb'];
						$arr_buttons_action 	= ['create', 'edit', 'remove', 'confirm', 'nonaktif_h', 'view', 'log','noaction'];						
						include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
					?>
					{
						name: 'btnUpload',
						text: '<i class="fa fa-file-excel-o"></i>',
						className: 'btn btn-primary',
						titleAttr: 'Upload Master Location',
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
					if ( data.wloxxmh_upload.transaction_state == -9 ) {
						$('td', row).addClass('text-danger');
					}else if ( data.wloxxmh_upload.transaction_state == 0 ) {
						$('td', row).addClass('text-warning');
					}
				}
			} );

			tblwloxxmh_upload.searchPanes.container().appendTo('#spwloxxmh_upload');
			tblwloxxmh_upload.searchBuilder.container().appendTo( '#sbwloxxmh_upload' );
			
			tblwloxxmh_upload.on( 'init', function () {
				// atur hak akses
				CekInitHeaderH(tblwloxxmh_upload);
			} );
			
			tblwloxxmh_upload.on( 'select', function( e, dt, type, indexes ) {
				// set variable standar framework
				siVarSet('wloxxmh_upload');
				
				id_wloxxmh_upload_parent_old = wloxxmh_upload_data.id_wloxxmh_upload_parent;

				// atur hak akses
				CekSelectHeaderH(tblwloxxmh_upload);
			} );

			tblwloxxmh_upload.on( 'deselect', function () {
				// reset variable standar framework
				siVarReset('wloxxmh_upload');
				id_wloxxmh_upload_parent_old = 0;

				// atur hak akses
				CekDeselectHeaderH(tblwloxxmh_upload);
			} );

			// END wloxxmh_upload
			
			//upload master location
			var frmUploadMaster = $("#frmUploadMaster").submit(function(e) {
				e.preventDefault();
				// $('#submit_ceklok').hide();
			}).validate({

				submitHandler: function(form) { 
					
					toastr.info("Processing ...\nJangan tutup halaman sampai notifikasi ini hilang!", "INFO");

					//location
					var fd_location = new FormData();
					var location = $('#frmUploadLocation')[0].files[0];
					if (location != undefined) {
						fd_location.append('filename',location);
			
						$.ajax( {
							url: "../../models/isoxxth_upload/isoxxth_upload_master_location.php",
							type: 'POST',
							dataType: 'json',
							data: fd_location,
							async: false,
							contentType: false,
							processData: false,
							success: function ( json ) {
								
								full_message = json.data.message + '</br>';
								toast_type   = json.data.type_message;
								toastr[toast_type](full_message, 'INFO');
								$("#frmUploadLocation").val('');
								tblwloxxmh_upload.ajax.reload(null,false);
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
