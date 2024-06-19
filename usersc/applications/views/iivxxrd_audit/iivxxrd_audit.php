<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'iivxxrd_audit';
	$nama_tabels_d = [];
?>

<div class="row">
    <div class="col">
        <div class="ibox" id="iboxfilter">
            <div class="ibox-title">
                <h5 class="text-navy">Filter</h5>&nbsp
                <button class="btn btn-primary btn-xs collapse-link"><i class="fa fa-chevron-up"></i></button>
            </div>
            <div class="ibox-content">
                <form class="form-horizontal" id="frmFilter">
					<div class="form-group row">
						<div class="col-lg-4 col-sm-4">
							<input type="text" class="form-control" id="lpnInput" placeholder="LPN">
						</div>
					</div>
					<div class="form-group row">
						<div class="col-lg-4 col-sm-4">
							<input type="text" class="form-control" id="locationInput" placeholder="Location">
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

<div class="row" id="konten">
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/iivxxrd_audit/fn/iivxxrd_audit_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
		cekNotification();
		// ------------- default variable, do not erase
		var edtiivxxrd_audit, tbliivxxrd_audit, show_deleted_iivxxrd_audit = 0, id_iivxxrd_audit;
		// ------------- end of default variable
		var wlpxxmh_filter = '0';
		var wloxxmh_filter = '0';
		var start_at = '';

		// get tableRelation
		tableRelation('iivxxrd_audit');
		
		function generateKonten() {
			$.ajax( {
				url: "../../models/iivxxrd_audit/iivxxrd_audit_iivxxrd.php",
				dataType: 'json',
				type: 'POST',
				async: false,
				data: {
					wlpxxmh_filter: wlpxxmh_filter,
					wloxxmh_filter: wloxxmh_filter,
				},
				success: function ( json ) {
					console.log(json.data);
					dataKonten = json.data;
					if (dataKonten.length >= 2 && dataKonten.length < 3) {
						class_col = "col-lg-6";
					} else if (dataKonten.length > 3) {
						class_col = "col-lg-4";
					} else {
						class_col = "col-lg-12";
					}
					console.log(class_col);

					genKonten = '';
					dataKonten.forEach(kontenData => {
						wloxxmh_nama = kontenData.wloxxmh_nama;
						is_audit = kontenData.is_audit;
						
						// if (is_audit == 0) {
							btnAudit = `<div class="form-group" id="radio${kontenData.id_iimxxmh}${kontenData.batch_number}${kontenData.expired_date_ymd}${kontenData.wlpxxmh_kode}${kontenData.id_wloxxmh}">
											<label>Status Audit:</label>
											<br>
											<div class="form-check form-check-inline justify-content-end">
												<input class="form-check-input" type="radio" name="statusAudit${kontenData.id_iimxxmh}${kontenData.batch_number}${kontenData.expired_date_ymd}${kontenData.wlpxxmh_kode}${kontenData.id_wloxxmh}" id="option1${kontenData.id_iimxxmh}${kontenData.batch_number}${kontenData.expired_date_ymd}${kontenData.wlpxxmh_kode}${kontenData.id_wloxxmh}" value="1">
												<label class="form-check-label" for="option1${kontenData.id_iimxxmh}${kontenData.batch_number}${kontenData.expired_date_ymd}${kontenData.wlpxxmh_kode}${kontenData.id_wloxxmh}">
													OK
												</label>
											</div>
											<div class="form-check form-check-inline">
												<input class="form-check-input" type="radio" name="statusAudit${kontenData.id_iimxxmh}${kontenData.batch_number}${kontenData.expired_date_ymd}${kontenData.wlpxxmh_kode}${kontenData.id_wloxxmh}" id="option0${kontenData.id_iimxxmh}${kontenData.batch_number}${kontenData.expired_date_ymd}${kontenData.wlpxxmh_kode}${kontenData.id_wloxxmh}" value="0">
												<label class="form-check-label" for="option0${kontenData.id_iimxxmh}${kontenData.batch_number}${kontenData.expired_date_ymd}${kontenData.wlpxxmh_kode}${kontenData.id_wloxxmh}">
													Tidak OK
												</label>
											</div>
										</div>
										<button class="btn btn-primary submit-button" data-insert="${kontenData.id_iimxxmh}${kontenData.batch_number}${kontenData.expired_date_ymd}${kontenData.wlpxxmh_kode}${kontenData.id_wloxxmh}">Submit</button>
							`;	
						// } else {
						// 	btnAudit = '';
						// }
						console.log(kontenData);
						genKonten = genKonten+ `
							<div class="${class_col}">
								<div class="ibox">
									<div class="ibox-content">
										<h3>${wloxxmh_nama} (${kontenData.wlpxxmh_kode})</h3>
										<br>
										<p>
											<b>${kontenData.iimxxmh_kode} - ${kontenData.iimxxmh_nama}</b>
										</p>
										<p>
											Batch Number : ${kontenData.batch_number}
											<br>
											Expired Date : ${kontenData.expired_date}
											<br>
											
											Jumlah Terkecil : ${kontenData.jumlah_terkecil.toString().replace(/\.?0+$/, '')} ${kontenData.iumxxmh_terkecil_kode}
											<br>
											Jumlah Default : ${kontenData.jumlah_default.toString().replace(/\.?0+$/, '')} ${kontenData.iumxxmh_default_kode}
										</p>
										${btnAudit}
									</div>
								</div>
								
							</div>
						`;	
					});
					// console.log(genKonten);
					$('#konten').html(genKonten);
					
					// generateKonten();
					$('.submit-button').on('click', function() {
						var insertValue = $(this).attr('data-insert');
						
						var statusAuditValue = $(this).closest('.ibox-content').find('input[name^="statusAudit"]:checked').val();
						
						if (statusAuditValue !== undefined) {
							$.ajax( {
								url: "../../models/iivxxrd_audit/iivxxrd_audit_insert.php",
								dataType: 'json',
								type: 'POST',
								async: false,
								data: {
									start_at: start_at,
									insertValue: insertValue,
									statusAuditValue: statusAuditValue,
								},
								success: function ( json ) {
									status_code = json.data.status_code;
									if (status_code == 200) {
										toastr[json.data.type_message](json.data.message,"INFO");
									}
								}
							} );
							// if (status_code == 200) {
							// 	$(this).hide();
							// 	$('#radio'+insertValue).hide();
							// }
						} else {
							alert('Please select a Status Audit value.');
						}
					});

				}
			} );
		}

		$(document).ready(function() {
			
			$("#frmFilter").submit(function(e) {
				e.preventDefault();
			}).validate({
				rules: {
					
				},
				submitHandler: function(frmFilter) {
					
					wlpxxmh_filter  = $('#lpnInput').val();
					wloxxmh_filter  = $('#locationInput').val();
					if (wlpxxmh_filter != '' || wloxxmh_filter != '') {
						generateKonten();
						$('#iboxfilter').addClass('collapsed');

						//start at itu saat submit filter
						start_at = moment().format("YYYY-MM-DD HH:mm:ss");
					} else {
						alert('harus isi salah satu');
						return false;
					}
				}
			});

			// END iivxxrd_audit
			
		} );// end of document.ready
	
	</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
