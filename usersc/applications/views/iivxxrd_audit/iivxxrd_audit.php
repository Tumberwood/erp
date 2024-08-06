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

<div class="modal" id="modalFloatingFilter" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content animated bounceInRight">
			<form class="form-horizontal" id="frmFilter">
				<div class="modal-header">
					<h4 class="modal-title">Filter</h4>
				</div>
				<div class="modal-body">
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
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
					<button class="btn btn-primary" type="submit">Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- <div class="row">
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
</div> -->

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
		//Aktivasi Filter Floating
		filterFloating();
		
		function generateKonten() {
			$('#konten').empty();
			id_wlpxxmh_filter = 0;
			id_wloxxmh_filter = 0;
			is_valid = 0;	
			is_valid_lpn = 0;	
			is_valid_loc = 0;	

			if (wlpxxmh_filter != '') {
				//cek lpn apakah terdaftar di master LPN
				$.ajax( {
					url: "../../models/iivxxrd_audit/iivxxrd_audit_fn_cek_lpn_dan_lokasi.php",
					dataType: 'json',
					type: 'POST',
					async: false,
					data: {
						state: 1,
						wlpxxmh_filter: wlpxxmh_filter,
					},
					success: function ( json ) {
						id_wlpxxmh_filter = json.data;
						console.log(id_wlpxxmh_filter);

						if (id_wlpxxmh_filter > 0) {
							is_valid = 1;
							is_valid_lpn = 1;
						} else {
							is_valid_lpn = 0;
							alert('LPN Tidak Terdaftar di master LPN!');
						}
					}
				} );
			}

			if (wloxxmh_filter != '') {
				//cek lpn apakah terdaftar di master LPN
				$.ajax( {
					url: "../../models/iivxxrd_audit/iivxxrd_audit_fn_cek_lpn_dan_lokasi.php",
					dataType: 'json',
					type: 'POST',
					async: false,
					data: {
						state: 2,
						wloxxmh_filter: wloxxmh_filter,
					},
					success: function ( json ) {
						id_wloxxmh_filter = json.data;
						console.log(id_wloxxmh_filter);

						if (id_wloxxmh_filter > 0) {
							is_valid = 1;
							is_valid_loc = 1;
						} else {
							is_valid_loc = 0;
							alert('Location Tidak Terdaftar di master Location!');
						}
					}
				} );
			}

			if (wloxxmh_filter != '' && wlpxxmh_filter != '') {
				if (is_valid_loc == 1 && is_valid_lpn == 1) {
					is_valid = 1;
				} else {
					is_valid = 0;
				}
			}

			if (is_valid == 1) {
				$.ajax( {
					url: "../../models/iivxxrd_audit/iivxxrd_audit_iivxxrd.php",
					dataType: 'json',
					type: 'POST',
					async: false,
					data: {
						id_wlpxxmh_filter: id_wlpxxmh_filter,
						id_wloxxmh_filter: id_wloxxmh_filter,
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
							is_iiv_valid = kontenData.is_iiv_valid;
							is_audit = kontenData.is_audit;
							
							// if (is_audit == 0) {
								btnAudit = `<div class="form-group m-t-n-sm" id="radio${kontenData.id_iimxxmh}${kontenData.batch_number}${kontenData.expired_date_ymd}${kontenData.wlpxxmh_kode}${kontenData.id_wloxxmh}">
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
											<button class="btn btn-primary submit-button" data-cekValid="${is_iiv_valid}" data-insert="${kontenData.id_iimxxmh},${kontenData.batch_number},${kontenData.expired_date_ymd},${kontenData.wlpxxmh_kode},${kontenData.id_wloxxmh}">Submit</button>
								`;	
							if (is_iiv_valid == 1) {
								kontenValid = `<p>
												<b>${kontenData.iimxxmh_kode} - ${kontenData.iimxxmh_nama}</b>
											</p>
											<p class="m-t-n-sm">
												Batch Number : ${kontenData.batch_number}
												<br>
												Expired Date : ${kontenData.expired_date}
												<br>
												
												Jumlah Terkecil : ${kontenData.jumlah_terkecil.toString().replace(/\.?0+$/, '')} ${kontenData.iumxxmh_terkecil_kode}
												<br>
												Jumlah Default : ${kontenData.jumlah_default.toString().replace(/\.?0+$/, '')} ${kontenData.iumxxmh_default_kode}
											</p>`;
							} else {
								kontenValid = '<p>Data Tidak Ditemukan!</p>';
							}
							console.log(kontenData);
							if (kontenData.wlpxxmh_kode != '' && wloxxmh_nama != '') {
								conct = '-';
							} else {
								conct = '';
							}
							genKonten = genKonten+ `
								<div class="${class_col}">
									<div class="ibox">
										<div class="ibox-content">
											<h3>${kontenData.wlpxxmh_kode} ${conct} ${wloxxmh_nama}</h3>
											${kontenValid}
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
							var is_iiv_valid = $(this).attr('data-cekValid');
							console.log(is_iiv_valid);
							
							var statusAuditValue = $(this).closest('.ibox-content').find('input[name^="statusAudit"]:checked').val();
							
							if (statusAuditValue !== undefined) {
								$.ajax( {
									url: "../../models/iivxxrd_audit/iivxxrd_audit_insert.php",
									dataType: 'json',
									type: 'POST',
									async: false,
									data: {
										start_at: start_at,
										is_iiv_valid: is_iiv_valid,
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
						// $('#iboxfilter').addClass('collapsed');
						$('#modalFloatingFilter').modal('toggle');

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
