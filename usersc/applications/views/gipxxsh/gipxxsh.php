<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'gipxxsh';
	$nama_tabels_d = [];
?>

<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				<h3 class="text-info">Format file harus dalam .xlsx dan disesuaikan dengan format template</h3>
				<hr>
				<div>
					<button type="button" class="btn btn-success" onclick="window.open('../../../files/uploads/template_checkclock.xls');">
						<i class="fa fa-download"></i>&nbsp;&nbsp;<span class="bold">Template</span>
					</button>
				</div>
				<form id="frmUploadthimportcheckclock" enctype="multipart/form-data">
					<div class="form-group row">
						<label class="col-lg-2 col-form-label">File Checkclock</label>
						<div class="col-sm-4">
							<div class="input-group">
								<input type="file" name="filename" class="form-control" id="inputfilethimportcheckclock_staff">
							</div>
						</div>
					</div>

					<span class="input-group-append"> 
						<button type="submit" id="submit_ceklok" class="btn btn-primary">Import</button>
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
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn2.js"></script>
<script src="<?=$us_url_root?>usersc/helpers/language.js"></script>

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/gipxxsh/fn/gipxxsh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtgipxxsh, tblgipxxsh, show_deleted_gipxxsh = 0, id_gipxxsh;
	// ------------- end of default variable
	
	$(document).ready(function() {

//Edit by Ferry, revisi dijadikan 1 button untuk semua inputan
var frmUploadthimportcheckclock = $("#frmUploadthimportcheckclock").submit(function(e) {
	e.preventDefault();
	// $('#submit_ceklok').hide();
}).validate({

	submitHandler: function(form) { 
		
		var notifyprogress = $.notify({
			message: 'Processing ...</br> Jangan tutup window sampai ada notifikasi hasil upload!'
		},{
			z_index: 9999,
			allow_dismiss: false,
			type: 'danger',
			delay: 0
		});

		
		//STAFF
		var fd_staff = new FormData();
		var staff = $('#inputfilethimportcheckclock_staff')[0].files[0];
		if (staff != undefined) {
			fd_staff.append('filename',staff);

			$.ajax( {
				url: "../../models/gipxxsh/gipxxsh_fn_checkclock_staff.php",
				type: 'POST',
				dataType: 'json',
				data: fd_staff,
				async: false,
				contentType: false,
				processData: false,
				success: function ( json ) {
					
					$.notify({
						message: json.data.message
					},{
						type: json.data.type_message,
						delay: 0,
						showProgressbar: true, // To show a progress bar
						template: 
							'<div class="alert alert-{0} alert-dismissible" role="alert">' +
								'<button type="button" class="close" data-notify="dismiss">×</button>' +
								'<div data-notify="message">{2}</div>' +
							'</div>'
					});
					$("#inputfilethimportcheckclock_staff").val('');
					notifyprogress.close();
					$('#submit_ceklok').show();
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
