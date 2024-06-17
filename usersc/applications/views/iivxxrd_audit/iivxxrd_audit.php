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
        <div class="ibox collapsed" id="iboxfilter">
            <div class="ibox-title">
                <h5 class="text-navy">Filter</h5>&nbsp
                <button class="btn btn-primary btn-xs collapse-link"><i class="fa fa-chevron-up"></i></button>
            </div>
            <div class="ibox-content">
                <form class="form-horizontal" id="frmFilter">
					<div class="form-group row">
						<label class="col-lg-2 col-md-2">LPN</label>
						<div class="col-lg-4 col-sm-4">
							<select class="form-control" id="selectLPN" name="selectLPN" multiple="multiple"></select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-lg-2 col-md-2">Location</label>
						<div class="col-lg-4 col-sm-4">
							<select class="form-control" id="selectLocation" name="selectLocation" multiple="multiple"></select>
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
	
<!-- begin content here -->
<!-- <div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tbliivxxrd_audit" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Keterangan</th>
                                <th>TX</th>
                            </tr>
                        </thead>
                    </table>
				</div>
			</div>
		</div>
	</div>
</div> -->

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
		var id_wlpxxmh_filter = 0;
		var id_wloxxmh_filter = 0;

		// get tableRelation
		tableRelation('iivxxrd_audit');

		$("#selectLPN").select2({
			placeholder : "Select",
			allowClear: true,
			multiple: false,
			ajax: {
				url: "../../models/iivxxrd_audit/wlpxxmh_fn_opt_iiv.php",
				dataType: 'json',
				data: function (params) {
					var query = {
						id_wlpxxmh_old: id_wlpxxmh_filter,
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
		
		$("#selectLocation").select2({
			placeholder : "Select",
			allowClear: true,
			multiple: false,
			ajax: {
				url: "../../models/iivxxrd_audit/wloxxmh_fn_opt_iiv.php",
				dataType: 'json',
				data: function (params) {
					var query = {
						id_wloxxmh_old: id_wloxxmh_filter,
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
		
		
		function generateKonten() {
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
						is_audit = kontenData.is_audit;
						
						if (is_audit == 0) {
							btnAudit = `<div class="form-group" id="radio${kontenData.id_iimxxmh}${kontenData.batch_number}${kontenData.expired_date_ymd}${kontenData.wlpxxmh_kode}${kontenData.id_wloxxmh}">
											<label>Status Audit:</label>
											<div class="form-check">
												<input class="form-check-input" type="radio" name="statusAudit${kontenData.id_iimxxmh}${kontenData.batch_number}${kontenData.expired_date_ymd}${kontenData.wlpxxmh_kode}${kontenData.id_wloxxmh}" id="option1${kontenData.id_iimxxmh}${kontenData.batch_number}${kontenData.expired_date_ymd}${kontenData.wlpxxmh_kode}${kontenData.id_wloxxmh}" value="1">
												<label class="form-check-label" for="option1${kontenData.id_iimxxmh}${kontenData.batch_number}${kontenData.expired_date_ymd}${kontenData.wlpxxmh_kode}${kontenData.id_wloxxmh}">
													OK
												</label>
											</div>
											<div class="form-check">
												<input class="form-check-input" type="radio" name="statusAudit${kontenData.id_iimxxmh}${kontenData.batch_number}${kontenData.expired_date_ymd}${kontenData.wlpxxmh_kode}${kontenData.id_wloxxmh}" id="option0${kontenData.id_iimxxmh}${kontenData.batch_number}${kontenData.expired_date_ymd}${kontenData.wlpxxmh_kode}${kontenData.id_wloxxmh}" value="0">
												<label class="form-check-label" for="option0${kontenData.id_iimxxmh}${kontenData.batch_number}${kontenData.expired_date_ymd}${kontenData.wlpxxmh_kode}${kontenData.id_wloxxmh}">
													Tidak OK
												</label>
											</div>
										</div>
										<button class="btn btn-primary submit-button" data-insert="${kontenData.id_iimxxmh}${kontenData.batch_number}${kontenData.expired_date_ymd}${kontenData.wlpxxmh_kode}${kontenData.id_wloxxmh}">Submit</button>
							`;	
						} else {
							btnAudit = '';
						}
						console.log(kontenData);
						genKonten = genKonten+ `
							<div class="${class_col}">
								<div class="ibox">
									<div class="ibox-title">
										<h5>${wloxxmh_nama}<br>(${kontenData.wlpxxmh_kode})</h5>
										<div class="ibox-tools">
											<a class="collapse-link">
												<i class="fa fa-chevron-up"></i>
											</a>
											<a class="fullscreen-link">
												<i class="fa fa-expand"></i>
											</a>
											<a class="close-link">
												<i class="fa fa-times"></i>
											</a>
										</div>
									</div>
									<div class="ibox-content">
										<p>
											<b>${kontenData.iimxxmh_kode} - ${kontenData.iimxxmh_nama}</b>
										</p>
										<p>
											Batch Number : ${kontenData.batch_number}
											<br>
											Expired Date : ${kontenData.expired_date}
											<br>
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
							if (status_code == 200) {
								$(this).hide();
								$('#radio'+insertValue).hide();
							}
						} else {
							alert('Please select a Status Audit value.');
						}
					});

				}
			} );
		}

		$(document).ready(function() {

			// BEGIN iivxxrd_audit
			edtiivxxrd_audit = new $.fn.dataTable.Editor( {
				ajax: {
					url: "../../models/iivxxrd_audit/iivxxrd_audit.php",
					type: 'POST',
					data: function (d){
						d.id_wlpxxmh_filter = id_wlpxxmh_filter;
						d.id_wloxxmh_filter = id_wloxxmh_filter;
					},
				},
				fields: [ 
					{
						label: "iivxxrd_audit.start_at",
						name: "iivxxrd_audit.start_at",
						type: "hidden"
					},	
					{
						label: "iivxxrd_audit.finish_at",
						name: "iivxxrd_audit.finish_at",
						type: "hidden"
					},	
					{
						label: "nama_tabel",
						name: "nama_tabel",
						def: "iivxxrd_audit",
						type: "hidden"
					},	
					{
						label: "iivxxrd_audit.transaction_state",
						name: "iivxxrd_audit.transaction_state",
                        type: "hidden",
						def: 0
					},
					{
						label: "Status Audit",
						name: "iivxxrd_audit.status_audit",
						type: "radio",
						options: [
							{ "label": "OK", "value": 1 },
							{ "label": "Tidak OK", "value": 0 }
						]
					},
					{
						label: "Keterangan",
						name: "iivxxrd_audit.keterangan",
						type: "textarea"
					}
				]
			} );

			edtiivxxrd_audit.on( 'preOpen', function( e, mode, action ) {
				start_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtiivxxrd_audit.field('iivxxrd_audit.start_at').val(start_at);
				console.log(buttonInsert);
				
				if(action == 'create'){
					tbliivxxrd_audit.rows().deselect();
				}
			});

			edtiivxxrd_audit.on("open", function (e, mode, action) {
				$(".modal-dialog").addClass("modal-lg");

				// enable disable tombol Save & Confirm
				edtFormButtonSaveConfirm();
			});

            edtiivxxrd_audit.on( 'preSubmit', function (e, data, action) {
				if(action != 'remove'){

					status_audit = edtiivxxrd_audit.field('iivxxrd_audit.status_audit').val();

					validasiRequired(
						edtiivxxrd_audit,
						'iivxxrd_audit',
						{
							'status_audit': status_audit,
						}
					);
				}
				
				if ( edtiivxxrd_audit.inError() ) {
					return false;
				}
			});
			
			edtiivxxrd_audit.on('initSubmit', function(e, action) {
				finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtiivxxrd_audit.field('iivxxrd_audit.finish_at').val(finish_at);
			});

			edtiivxxrd_audit.on( 'close', function () {
				edtiivxxrd_audit.enable();
			} );
			
			$("#frmFilter").submit(function(e) {
				e.preventDefault();
			}).validate({
				rules: {
					
				},
				submitHandler: function(frmFilter) {
					
					id_wlpxxmh_filter  = $('#selectLPN').val();
					id_wloxxmh_filter  = $('#selectLocation').val();
					if (id_wlpxxmh_filter > 0 || id_wloxxmh_filter > 0) {
						generateKonten();
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
