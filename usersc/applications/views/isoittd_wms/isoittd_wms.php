<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'isoittd_wms';
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

<button class="btn btn-primary add-button" id="add_button" style="display:none">
  <i class="fa fa-plus"></i> Add New
</button>
<br>
<br>
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
<script src="<?=$us_url_root?>usersc/helpers/language.js"></script>
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/isoittd_wms/fn/isoittd_wms_fn.php'; ?>
<!-- BEGIN javascript here -->
<script type="text/javascript">
		cekNotification();
		// ------------- default variable, do not erase
		var edtisoittd_wms, tblisoittd_wms, show_deleted_isoittd_wms = 0, id_isoittd_wms;
		// ------------- end of default variable
		var wlpxxmh_filter = '0';
		var wloxxmh_filter = '0';
		var start_at = '';
		var id_iimxxmh_old = 0, id_wloxxmh_old = 0, id_iumxxmh_unit_old = 0;

		// get tableRelation
		tableRelation('isoittd_wms');
		//Aktivasi Filter Floating
		filterFloating();

		$(document).ready(function() {
			
		/////////// ADD DETAIL ISO ////////////

			edtisoittd_wms = new $.fn.dataTable.Editor( {
				ajax: {
					url: "../../models/isoittd_wms/isoittd_wms.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_isoittd_wms = show_deleted_isoittd_wms
					}
				},
				formOptions: {
					main: {
						focus: 14
					}
				},
				fields: [ 
					{
						label: "isoittd_wms.start_at",
						name: "isoittd_wms.start_at",
						type: "hidden"
					},	
					{
						label: "isoittd_wms.finish_at",
						name: "isoittd_wms.finish_at",
						type: "hidden"
					},		
					{
						label: "nama_tabel",
						name: "nama_tabel",
						def: "isoittd_wms",
						type: "hidden"
					},	
					{
						label: "isoittd_wms.transaction_state",
						name: "isoittd_wms.transaction_state",
						type: "hidden",
						def: 0
					},
					{
						label: "isoittd_wms.is_add_new",
						name: "isoittd_wms.is_add_new",
						// type: "hidden"
					},
					{
						label: "isoittd_wms.jumlah_iiv_terkecil",
						name: "isoittd_wms.jumlah_iiv_terkecil",
						type: "hidden"
					},
					{
						label: "isoittd_wms.id_gcpxxmh",
						name: "isoittd_wms.id_gcpxxmh",
						type: "hidden"
					},
					{
						label: "isoittd_wms.id_gbrxxmh",
						name: "isoittd_wms.id_gbrxxmh",
						type: "hidden"
					},
					{
						label: "isoittd_wms.id_iwhxxmh",
						name: "isoittd_wms.id_iwhxxmh",
						type: "hidden"
					},
					{
						label: "LPN <sup class='text-danger'>*<sup>",
						name: "isoittd_wms.wlpxxmh_kode",
					},
					{
						label: "Batch Number <sup class='text-danger'>*<sup>",
						name: "isoittd_wms.batch_number",
					},
					{
						label: "Expired Date <sup class='text-danger'>*<sup>",
						name: "isoittd_wms.expired_date",
						type: "datetime",
						opts:{
							minDate: new Date('1900-01-01'),
							firstDay: 0
						},
						format: 'DD MMM YYYY'
					},
					{
						label: "Item <sup class='text-danger'>*<sup>",
						name: "isoittd_wms.id_iimxxmh",
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
								minimumResultsForSearch: -1
							}
						}
					},
					{
						label: "Location <sup class='text-danger'>*<sup>",
						name: "isoittd_wms.id_wloxxmh",
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
								minimumResultsForSearch: -1
							}
						}
					},
					{
						label: "Quantity <sup class='text-danger'>*<sup>",  
						name: "isoittd_wms.jumlah_unit",
					},
					{
						label: "UoM <sup class='text-danger'>*<sup>",  
						name: "isoittd_wms.id_iumxxmh_unit",
						type: "select2",
						opts: {
							placeholder : "Select",
							allowClear: true,
							multiple: false,
							ajax: {
								url: "../../models/iumxxmh/iumxxmh_fn_opt_iimummd.php",
								dataType: 'json',
								data: function (params) {
									var query = {
										id_iimxxmh: edtisoittd_wms.field('isoittd_wms.id_iimxxmh').val(),
										id_iumxxmh_unit_old: id_iumxxmh_unit_old,
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
						label: "Tanggal",
						name: "isoittd_wms.tanggal",
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
						label: "Foto",
						name: "isoittd_wms.id_files_pointer",
						type: "upload",
						display: function ( fileId, counter ) {
							if (fileId == 0){
								return 'Belum ada lampiran';
							}else{
								id_files_pointer = edtisoittd_wms.field('isoittd_wms.id_files_pointer').val();
								console.log('id_files_pointer: '+id_files_pointer);
								if (id_files_pointer) {
    								autofillField('files', id_files_pointer, 'web_path, filename');
									return '<a href="'+autofillData.web_path+'" target="_blank">'+ autofillData.filename + '</a>'; 
								} else {
									return '<a href="'+edtisoittd_wms.file( 'files', fileId ).web_path+'" target="_blank">'+ edtisoittd_wms.file( 'files', fileId ).filename + '</a>'; 
								}
							}
						},
						noFileText: 'Belum ada gambar'
					},
					{
						label: "Keterangan",
						name: "isoittd_wms.keterangan",
						type: "textarea"
					},
				]
			} );

			edtisoittd_wms.on( 'preOpen', function( e, mode, action ) {
				start_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtisoittd_wms.field('isoittd_wms.start_at').val(start_at);
				
				edtisoittd_wms.field('isoittd_wms.is_add_new').hide();
			});
			
			edtisoittd_wms.on("open", function (e, mode, action) {
				$(".modal-dialog").addClass("modal-lg");
				edtisoittd_wms.field('isoittd_wms.tanggal').hide();
				edtisoittd_wms.field('isoittd_wms.wlpxxmh_kode').disable();
				edtisoittd_wms.field('isoittd_wms.batch_number').disable();
			});

			edtisoittd_wms.dependent( 'isoittd_wms.is_add_new', function ( val, data, callback ) {
				console.log('is_add_new: '+ val);
				if (val == 0) {
					edtisoittd_wms.field('isoittd_wms.wlpxxmh_kode').disable();
					edtisoittd_wms.field('isoittd_wms.batch_number').disable();
					edtisoittd_wms.field('isoittd_wms.expired_date').disable();
					edtisoittd_wms.field('isoittd_wms.id_wloxxmh').disable();
					edtisoittd_wms.field('isoittd_wms.id_iimxxmh').disable();
				} else {
					edtisoittd_wms.field('isoittd_wms.wlpxxmh_kode').enable();
					edtisoittd_wms.field('isoittd_wms.batch_number').enable();
					edtisoittd_wms.field('isoittd_wms.expired_date').enable();
					edtisoittd_wms.field('isoittd_wms.id_wloxxmh').enable();
					edtisoittd_wms.field('isoittd_wms.id_iimxxmh').enable();
				}
				return {}
			}, {event: 'keyup change'});

			edtisoittd_wms.dependent( 'isoittd_wms.wlpxxmh_kode', function ( val, data, callback ) {
				is_add_new = edtisoittd_wms.field('isoittd_wms.is_add_new').val();
				console.log(is_add_new);

				if (is_add_new == 1) {
					findIdLpn(val);
				}
				return {}
			}, {event: 'keyup change'});

			edtisoittd_wms.dependent( 'isoittd_wms.id_wloxxmh', function ( val, data, callback ) {
					console.log(val);
				if (val > 0) {
					autofillField('wloxxmh', val, 'id_iwhxxmh');
					edtisoittd_wms.field('isoittd_wms.id_iwhxxmh').val(autofillData.id_iwhxxmh);
					
					autofillField('iwhxxmh', autofillData.id_iwhxxmh, 'id_gbrxxmh');
					edtisoittd_wms.field('isoittd_wms.id_gbrxxmh').val(autofillData.id_gbrxxmh);

					autofillField('gbrxxmh', autofillData.id_gbrxxmh, 'id_gcpxxmh');
					edtisoittd_wms.field('isoittd_wms.id_gcpxxmh').val(autofillData.id_gcpxxmh);
				}
				return {}
			}, {event: 'keyup change'});

			edtisoittd_wms.on( 'preSubmit', function (e, data, action) {
				if(action != 'remove'){
					jumlah_unit = edtisoittd_wms.field('isoittd_wms.jumlah_unit').val();
					id_iumxxmh_unit = edtisoittd_wms.field('isoittd_wms.id_iumxxmh_unit').val();
					id_iimxxmh = edtisoittd_wms.field('isoittd_wms.id_iimxxmh').val();
					id_wloxxmh = edtisoittd_wms.field('isoittd_wms.id_wloxxmh').val();
					wlpxxmh_kode = edtisoittd_wms.field('isoittd_wms.wlpxxmh_kode').val();
					batch_number = edtisoittd_wms.field('isoittd_wms.batch_number').val();
					expired_date = edtisoittd_wms.field('isoittd_wms.expired_date').val();

					is_add_new = edtisoittd_wms.field('isoittd_wms.is_add_new').val();
					console.log(is_add_new);
					
					validasiRequired(
						edtisoittd_wms, 
						"isoittd_wms", 
						{
							"id_iumxxmh_unit": id_iumxxmh_unit,
							"id_iimxxmh": id_iimxxmh,
							"id_wloxxmh": id_wloxxmh,
							"wlpxxmh_kode": wlpxxmh_kode,
							"batch_number": batch_number,
							"expired_date": expired_date,
						}
					);
					
					validasiNumber(
						edtisoittd_wms,
						'isoittd_wms',
						{
							'jumlah_unit': jumlah_unit
						},
						0,
						'>'
					);
				}
				
				if ( edtisoittd_wms.inError() ) {
					return false;
				}
			});

			edtisoittd_wms.on('initSubmit', function(e, action) {

				finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtisoittd_wms.field('isoittd_wms.finish_at').val(finish_at);
			});

			edtisoittd_wms.on( 'postSubmit', function (e, json, data, action, xhr) {
				if (action != 'remove') {
					id_transaksi = json.data[0].isoittd_wms.id;
					konversiUom('isoittd_wms', id_transaksi );
					// generateKonten();
        			$('#konten').empty();
        			$('#add_button').hide();
					setTimeout(function () {
						$('#btnFilterFloating').trigger('click');
					}, 500);
				}
			});

		///////////ADD DETAIL ISO /////////////

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
					
					$('#lpnInput').val('');
					$('#locationInput').val('');
				}
			});

			// END isoittd_wms
			
		} );// end of document.ready
	
	</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
