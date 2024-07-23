<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'isoittd_upload';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div id="tabel_atas">
	<div class="col">
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
			
				<div class="table-responsive">
						<table id="tblisoittd_upload" class="table table-striped table-bordered table-hover nowrap" width="100%">
							<thead>
								<tr>
									<th>ID</th>
									<th>id_isoxxth_upload</th>
									<th>Kode SOU</th>
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
									<th>Keterangan</th>
									<th>Hitung</th>
									<th>Link</th>
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
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn.js"></script>

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/pointer_solusi/fn/pointer_solusi_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
		cekNotification();
		// ------------- default variable, do not erase
		var edtisoittd_upload, tblisoittd_upload, show_deleted_isoittd_upload = 0, id_isoittd_upload;
		// ------------- end of default variable
		var id_isoxxth_upload_filter = 0;

		tableRelation('isoittd_upload');
		
		$("#selectKode").select2({
			placeholder : "Select",
			allowClear: true,
			multiple: false,
			ajax: {
				url: "../../models/isoxxth_upload/isoxxth_upload_parent_fn_opt.php",
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
		// get tableRelation
		// tableRelation('isoittd_uploadheader');
		
		$(document).ready(function() {
			
			var selisihDesc = $.fn.dataTable.absoluteOrderNumber( [
				{ value: null, position: 'bottom' }
			] );

			tblisoittd_upload = $('#tblisoittd_upload').DataTable( {
				dom: domPQ,
				searchPanes:{
					layout: window.innerWidth < 768 ? 'columns-1' : 'columns-3'
				},
				ajax: {
					url: "../../models/pointer_solusi/pointer_solusi.php",
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
					targets: [1,2,3,11,12,13]
				},
				{
					searchPanes:{
						show: false,
					},
					targets: '_all'
				},
				{ type: selisihDesc, targets: 11 }
			],
			order: [[ 2, "asc" ]],
			responsive: false,
			scrollX: true,
			columns: [
				{ data: "isoittd_upload.id",visible:false },
				{ data: "isoittd_upload.id_isoxxth_upload",visible:false },
				{ data: "isoxxth_upload.kode" },
				{ data: "isoittd_upload.lokasi" },
				{ data: "isoittd_upload.lpn" },
				{ data: "isoittd_upload.kode" },
				{ data: "isoittd_upload.nama" },
				{ data: "isoittd_upload.batch_number" },
				{ data: "isoittd_upload.expired_date" },
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
				{ data: "isoittd_upload.keterangan_pointer" },
				{ 
					data: "isoittd_upload.is_pointer",
					...renderYaTidak()
				},
				{ 
					data: null ,
					render: function (data, type, row) {
						var id_sou = row.isoittd_upload.id_isoxxth_upload;
						var id_td = row.isoittd_upload.id;
						var url = "../isoxxth_pointer_v2/isoxxth_pointer_v2.php?id_sou=" + id_sou + "&id_td=" + id_td;
						var link = '<a href="' + url + '" target="_blank">Link Pointer</a>';
						return link;
					}
				},
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
						$arr_buttons_tools2 	= ['sf', 'sp', 'sb'];
						$arr_buttons_action 	= [];
						include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
					?>
					// END breaking generate button
				],
				initComplete: function() {
					this.api().searchPanes.rebuildPane();
					$('.dtsp-panesContainer').addClass('col-12');

				},
				rowCallback: function( row, data, index ) {
					if ( data.isoittd_upload.transaction_state == -9 ) {
						$('td', row).addClass('text-danger');
					}else if ( data.isoittd_upload.transaction_state == 0 ) {
						$('td', row).addClass('text-warning');
					}

					if ( data.isoittd_upload.fisik == null &&  data.isoittd_upload.is_skip == 0) {
						$('td', row).addClass('bg-warning');
					}
				}
			} );

			tblisoittd_upload.button('btnCloseStock:name').disable();
			tblisoittd_upload.searchPanes.container().appendTo('#spisoittd_upload');
			tblisoittd_upload.searchBuilder.container().appendTo( '#sbisoittd_upload' );
			
			tblisoittd_upload.on( 'init', function () {
				// atur hak akses
				CekInitHeaderH(tblisoittd_upload);
			} );
			
			tblisoittd_upload.on( 'select', function( e, dt, type, indexes ) {
				// set variable standar framework
				// siVarSet('isoittd_upload');

				// atur hak akses
				CekSelectHeaderH(tblisoittd_upload);
			} );

			tblisoittd_upload.on( 'deselect', function () {
				// reset variable standar framework
				siVarReset('isoittd_upload');

				// atur hak akses
				CekDeselectHeaderH(tblisoittd_upload);
			} );

			// END isoittd_upload
			
			$("#frmFilter").submit(function(e) {
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
						
						full_message = "Sedang Melakukan Load Data" + '</br>';
						toast_type   = "success";
						toastr[toast_type](full_message, 'INFO');
						$('#modalSFisoittd_upload').modal('toggle');

						tblisoittd_upload.ajax.reload(function ( json ) {
						}, false);
						tblisoittd_upload.button('btnCloseStock:name').enable();
						return false; 
					}
				}
			});
			
		} );// end of document.ready
	
	</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
