<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = '_blank';
	$nama_tabels_d = [];
?>

<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-title">
                <h5 class="text-navy">Upload Stok</h5>&nbsp
                <button class="btn btn-primary btn-xs collapse-link"><i class="fa fa-chevron-up"></i></button>
            </div>
			<div class="ibox-content">
				<h3 class="text-info">Format file harus dalam .xlsx dan disesuaikan dengan format template</h3>
				<hr>
				<div>
					<button type="button" class="btn btn-success" onclick="window.open('../../../files/uploads/template_upload_stok.xlsx');">
						<i class="fa fa-download"></i>&nbsp;&nbsp;<span class="bold">Template</span>
					</button>
				</div>
				<br>
				<form id="frmUpload" enctype="multipart/form-data">
					<div class="form-group row">
						<label class="col-lg-2 col-md-2">Kode</label>
						<div class="col-lg-4 col-sm-4">
							<select class="form-control" id="selectKode" name="selectKode" multiple="multiple"></select>
							<small class="form-text text-muted">Harap Pilih Kode, jika merupakan opname lanjutan</small>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-lg-2 col-form-label">Tanggal Upload</label>
						<div class="col-sm-4">
							<div class="input-group input-daterange" id="periode">
								<input type="text" id="end_date" class="form-control">
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-lg-2 col-form-label">File Stok</label>
						<div class="col-sm-4">
							<div class="input-group">
								<input type="file" name="filename" class="form-control" id="frmUploadStok">
							</div>
						</div>
					</div>
					<span class="input-group-append"> 
						<button type="submit" class="btn btn-primary">Import</button>
					</span>
				</form>
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

<!-- BEGIN javascript here -->
<script type="text/javascript">
		cekNotification();
		// ------------- default variable, do not erase
		var edt_blank, tbl_blank, show_deleted__blank = 0, id__blank;
		var id_isoxxth_upload_filter = 0;
		// ------------- end of default variable
		
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
		
		$(document).ready(function() {
			var frmUpload = $("#frmUpload").submit(function(e) {
				e.preventDefault();
			}).validate({

				submitHandler: function(form) { 
					
					var tanggal_upload = $('#end_date').val();
					var id_parent = $('#selectKode').val();
					console.log(tanggal_upload);

					//stok
					var fd_stok = new FormData();
					var stok = $('#frmUploadStok')[0].files[0];
					
					// console.log(stok);
					if (stok != undefined) {
						fd_stok.append('filename',stok);
						fd_stok.append('id_parent',id_parent);
						fd_stok.append('tanggal_upload',tanggal_upload);
						
						$.ajax( {
							url: "../../models/isoxxth_upload/isoxxth_upload.php",
							type: 'POST',
							dataType: 'json',
							data: fd_stok,
							async: false,
							contentType: false,
							processData: false,
							success: function ( json ) {
								
								full_message = json.data.message + '</br>';
								toast_type   = json.data.type_message;
								toastr[toast_type](full_message, 'INFO');
								$("#frmUploadStok").val('');
							},
							error: function (xhr, Status, err){
								// console.log('x');
							}
						} );
					}
				}
			});
			// END upload data

		} );// end of document.ready
	
	</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
