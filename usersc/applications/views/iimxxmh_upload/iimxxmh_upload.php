<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'iimxxmh_upload';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="modal" id="modalUpload" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content animated bounceInRight">
			<form class="form-horizontal" id="frmUploadMaster" enctype="multipart/form-data">
				<div class="modal-header">
					<h4 class="modal-title">Upload Master Item</h4>
				</div>
				<div class="modal-body">
					<div class="form-group row">
						<label class="col-lg-2 col-form-label">File Excel</label>
						<div class="col-sm-4">
							<div class="input-group">
								<input type="file" name="filename" class="form-control" id="frmUploadItem">
							</div>
						</div>
						<div class="col-sm-4">
							<button type="button" class="btn btn-success" onclick="window.open('../../../files/uploads/template_master_item.xlsx');">
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
                    <table id="tbliimxxmh_upload" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Company</th>
                                <th>Cabang</th>
                                <th>Satuan</th>
                                <th>Kode Item</th>
                                <th>Nama Item</th>
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
<script src="<?=$us_url_root?>usersc/helpers/language.js"></script>
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/iimxxmh_upload/fn/iimxxmh_upload_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
		// ------------- default variable, do not erase
		var edtiimxxmh_upload, tbliimxxmh_upload, show_deleted_iimxxmh_upload = 0, id_iimxxmh_upload;
		// ------------- end of default variable

		// get tableRelation
		tableRelation('iimxxmh_upload');

		$(document).ready(function() {
			// BEGIN iimxxmh_upload
			edtiimxxmh_upload = new $.fn.dataTable.Editor( {
				ajax: {
					url: "../../models/iimxxmh_upload/iimxxmh_upload.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_iimxxmh_upload = show_deleted_iimxxmh_upload;
					}
				},
				table: "#tbliimxxmh_upload",
				fields: [ 
					{
						label: "iimxxmh_upload.start_at",
						name: "iimxxmh_upload.start_at",
						type: "hidden"
					},	
					{
						label: "iimxxmh_upload.finish_at",
						name: "iimxxmh_upload.finish_at",
						type: "hidden"
					},	
					{
						label: "nama_tabel",
						name: "nama_tabel",
						def: "iimxxmh_upload",
						type: "hidden"
					},	
					{
						label: "iimxxmh_upload.transaction_state",
						name: "iimxxmh_upload.transaction_state",
                        type: "hidden",
						def: 0
					},	
					{
						label: "Company <sup class='text-danger'>*<sup>",
						name: "iimxxmh_upload.company"
					}, 	
					{
						label: "Cabang <sup class='text-danger'>*<sup>",
						name: "iimxxmh_upload.cabang"
					}, 	
					{
						label: "Satuan <sup class='text-danger'>*<sup>",
						name: "iimxxmh_upload.satuan",
						fieldInfo: "Gunakan Hurug Kapital: KG, PCS, FEET, ROLL"
					}, 	
					{
						label: "Kode <sup class='text-danger'>*<sup>",
						name: "iimxxmh_upload.kode"
					}, 	
					{
						label: "Nama <sup class='text-danger'>*<sup>",
						name: "iimxxmh_upload.nama"
					}
				]
			} );

			edtiimxxmh_upload.on( 'preOpen', function( e, mode, action ) {
				start_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtiimxxmh_upload.field('iimxxmh_upload.start_at').val(start_at);

				if(action == 'create'){
					tbliimxxmh_upload.rows().deselect();
					edtiimxxmh_upload.field('iimxxmh_upload.kode').enable();
					edtiimxxmh_upload.field('iimxxmh_upload.nama').enable();
				}else if(action == 'edit'){
					if(transaction_state == 0){
						edtiimxxmh_upload.field('iimxxmh_upload.kode').enable();
						edtiimxxmh_upload.field('iimxxmh_upload.nama').enable();
					}else{
						edtiimxxmh_upload.field('iimxxmh_upload.kode').disable();
						edtiimxxmh_upload.field('iimxxmh_upload.nama').disable();
					}
				}
			});

			edtiimxxmh_upload.on("open", function (e, mode, action) {
				$(".modal-dialog").addClass("modal-lg");

				// enable disable tombol Save & Confirm
				edtFormButtonSaveConfirm();
			});

            edtiimxxmh_upload.on( 'preSubmit', function (e, data, action) {
				if(action != 'remove'){
					kode = edtiimxxmh_upload.field('iimxxmh_upload.kode').val();
					cabang = edtiimxxmh_upload.field('iimxxmh_upload.cabang').val();
					company = edtiimxxmh_upload.field('iimxxmh_upload.company').val();
					satuan = edtiimxxmh_upload.field('iimxxmh_upload.satuan').val();
					nama = edtiimxxmh_upload.field('iimxxmh_upload.nama').val();

					validasiRequired(
						edtiimxxmh_upload,
						'iimxxmh_upload',
						{
							'kode': kode,
							'cabang': cabang,
							'company': company,
							'satuan': satuan,
							'nama': nama
						}
					);

					validasiUnique(
						action,
						edtiimxxmh_upload,
						'iimxxmh_upload',
						'kode',
						'kode',
						'"'+kode+'"',
						id_iimxxmh_upload
					);

					validasiUnique(
						action,
						edtiimxxmh_upload,
						'iimxxmh_upload',
						'nama',
						'nama',
						'"'+nama+'"',
						id_iimxxmh_upload
					);
				}
				
				if ( edtiimxxmh_upload.inError() ) {
					return false;
				}
			});
			
			edtiimxxmh_upload.on('initSubmit', function(e, action) {
				finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtiimxxmh_upload.field('iimxxmh_upload.finish_at').val(finish_at);
			});

			edtiimxxmh_upload.on( 'close', function () {
				edtiimxxmh_upload.enable();
			} );

			tbliimxxmh_upload = $('#tbliimxxmh_upload').DataTable( {
				dom: domPQ,
				searchPanes:{
					layout: 'columns-4',
				},
				ajax: {
					url: "../../models/iimxxmh_upload/iimxxmh_upload.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_iimxxmh_upload = show_deleted_iimxxmh_upload;
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
					{ data: "iimxxmh_upload.id",visible:false },
					{ data: "iimxxmh_upload.company" },
					{ data: "iimxxmh_upload.cabang" },
					{ data: "iimxxmh_upload.satuan" },
					{ data: "iimxxmh_upload.kode" , type: 'string'},
					{ data: "iimxxmh_upload.nama" },
					{ 
						data: "iimxxmh_upload.transaction_state" ,
						...renderTransactionStatus()
					}
				],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_iimxxmh_upload';
						$table       = 'tbliimxxmh_upload';
						$edt         = 'edtiimxxmh_upload';
						$show_status = '_iimxxmh_upload';
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
						titleAttr: 'Upload Master Item',
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
					if ( data.iimxxmh_upload.transaction_state == -9 ) {
						$('td', row).addClass('text-danger');
					}else if ( data.iimxxmh_upload.transaction_state == 0 ) {
						$('td', row).addClass('text-warning');
					}
				}
			} );

			tbliimxxmh_upload.searchPanes.container().appendTo('#spiimxxmh_upload');
			tbliimxxmh_upload.searchBuilder.container().appendTo( '#sbiimxxmh_upload' );
			
			tbliimxxmh_upload.on( 'init', function () {
				// atur hak akses
				CekInitHeaderH(tbliimxxmh_upload);
			} );
			
			tbliimxxmh_upload.on( 'select', function( e, dt, type, indexes ) {
				// set variable standar framework
				siVarSet('iimxxmh_upload');
				
				id_iimxxmh_upload_parent_old = iimxxmh_upload_data.id_iimxxmh_upload_parent;

				// atur hak akses
				CekSelectHeaderH(tbliimxxmh_upload);
			} );

			tbliimxxmh_upload.on( 'deselect', function () {
				// reset variable standar framework
				siVarReset('iimxxmh_upload');
				id_iimxxmh_upload_parent_old = 0;

				// atur hak akses
				CekDeselectHeaderH(tbliimxxmh_upload);
			} );

			// END iimxxmh_upload
			
			//upload master item
			var frmUploadMaster = $("#frmUploadMaster").submit(function(e) {
				e.preventDefault();
				// $('#submit_ceklok').hide();
			}).validate({

				submitHandler: function(form) { 
					
					toastr.info("Processing ...\nJangan tutup halaman sampai notifikasi ini hilang!", "INFO");

					//item
					var fd_item = new FormData();
					var item = $('#frmUploadItem')[0].files[0];
					if (item != undefined) {
						fd_item.append('filename',item);
			
						$.ajax( {
							url: "../../models/isoxxth_upload/isoxxth_upload_master_item.php",
							type: 'POST',
							dataType: 'json',
							data: fd_item,
							async: false,
							contentType: false,
							processData: false,
							success: function ( json ) {
								
								full_message = json.data.message + '</br>';
								toast_type   = json.data.type_message;
								toastr[toast_type](full_message, 'INFO');
								$("#frmUploadItem").val('');
								tbliimxxmh_upload.ajax.reload(null,false);
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
