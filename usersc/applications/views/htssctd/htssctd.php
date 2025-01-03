<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'htssctd';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="modal" id="modalSFhtssctd" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog modal-lg">
						<div class="modal-content animated bounceInRight">
							<form class="form-horizontal" id="frmFilter">
								<div class="modal-header">
									<h4 class="modal-title">Filter</h4>
								</div>
								<div class="modal-body">
									<div class="form-group row">
										<label class="col-lg-2 col-form-label">Periode</label>
										<div class="col-lg-5">
											<div class="input-group input-daterange" id="periode">
												<input type="text" id="start_date" class="form-control">
												<div class="input-group-addon">
													<span class="fa fa-calendar"></span>
												</div>
												<input type="text" id="end_date" class="form-control">
											</div>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-lg-2 col-md-2">Pegawai</label>
										<div class="col-lg-4 col-sm-4">
											<select class="form-control" id="selectPegawai" name="selectPegawai" multiple="multiple"></select>
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
                    <table id="tblhtssctd" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th rowspan="2">ID</th>
                                <th rowspan="2">Tanggal</th>
                                <th rowspan="2">NIP</th>
                                <th rowspan="2">Nama</th>
                                <th rowspan="2">Department</th>
                                <th colspan="3" class="text-center">Awal</th>
                                <th colspan="3" class="text-center">Akhir</th>
                                <th rowspan="2">TX</th>
                            </tr>
							<tr>
								<th>T1</th>
								<th>T</th>
								<th>T2</th>
								<th>T1</th>
								<th>T</th>
								<th>T2</th>
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
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn2.js"></script>
<script src="<?=$us_url_root?>usersc/helpers/language.js"></script>
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/htssctd/fn/htssctd_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edthtssctd, tblhtssctd, show_deleted_htssctd = 0, id_htssctd;
	// ------------- end of default variable

	id_hemxxmh_filter = 0;
	id_hemxxmh_old = 0;
	
	// get tableRelation
	tableRelation('htssctd');
	
	$("#selectPegawai").select2({
		dropdownParent: $("#modalSFhtssctd"),
		placeholder : "Select",
		allowClear: true,
		multiple: false,
		ajax: {
			url: "../../models/hemxxmh/hemxxmh_fn_opt.php",
			dataType: 'json',
			data: function (params) {
				var query = {
					id_hemxxmh_old: id_hemxxmh_old,
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
	});
	
	$('#start_date').datepicker('setDate', moment().toDate());
	$('#end_date').datepicker('setDate', moment().toDate());

	$(document).ready(function() {
		start_date = moment($('#start_date').val()).format('YYYY-MM-DD');
		end_date   = moment($('#end_date').val()).format('YYYY-MM-DD');

		// BEGIN htssctd
		edthtssctd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/htssctd/htssctd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_htssctd = show_deleted_htssctd;
					d.start_date = start_date;
					d.end_date = end_date;
					d.id_hemxxmh_filter = id_hemxxmh_filter;
				}
			},
			table: "#tblhtssctd",
			fields: [ 
				{
					label: "htssctd.start_at",
					name: "htssctd.start_at",
					type: "hidden"
				},	
				{
					label: "htssctd.finish_at",
					name: "htssctd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "htssctd",
					type: "hidden"
				},	
				{
					label: "htssctd.transaction_state",
					name: "htssctd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "Tanggal <sup class='text-danger'>*<sup>",
					name: "htssctd.tanggal",
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
					label: "Employee <sup class='text-danger'>*<sup>",
					name: "htssctd.id_hemxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/hemxxmh/hemxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_hemxxmh_old: id_hemxxmh_old,
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
					label: "Tanggal Jam Awal T1",
					name: "htssctd.tanggaljam_awal_t1",
					type: "datetime",
					def: function () { 
						return new Date(); 
					},
					opts:{
						minDate: new Date('1900-01-01'),
						firstDay: 0
					},
					format: 'DD MMM YYYY HH:mm'
				},
				{
					label: "Tanggal Jam Awal",
					name: "htssctd.tanggaljam_awal",
					type: "datetime",
					def: function () { 
						return new Date(); 
					},
					opts:{
						minDate: new Date('1900-01-01'),
						firstDay: 0
					},
					format: 'DD MMM YYYY HH:mm'
				},
				{
					label: "Tanggal Jam Awal T2",
					name: "htssctd.tanggaljam_awal_t2",
					type: "datetime",
					def: function () { 
						return new Date(); 
					},
					opts:{
						minDate: new Date('1900-01-01'),
						firstDay: 0
					},
					format: 'DD MMM YYYY HH:mm'
				},
				{
					label: "Tanggal Jam Akhir T1",
					name: "htssctd.tanggaljam_akhir_t1",
					type: "datetime",
					def: function () { 
						return new Date(); 
					},
					opts:{
						minDate: new Date('1900-01-01'),
						firstDay: 0
					},
					format: 'DD MMM YYYY HH:mm'
				},
				{
					label: "Tanggal Jam Akhir",
					name: "htssctd.tanggaljam_akhir",
					type: "datetime",
					def: function () { 
						return new Date(); 
					},
					opts:{
						minDate: new Date('1900-01-01'),
						firstDay: 0
					},
					format: 'DD MMM YYYY HH:mm'
				},
				{
					label: "Tanggal Jam Akhir T2",
					name: "htssctd.tanggaljam_akhir_t2",
					type: "datetime",
					def: function () { 
						return new Date(); 
					},
					opts:{
						minDate: new Date('1900-01-01'),
						firstDay: 0
					},
					format: 'DD MMM YYYY HH:mm'
				},
				{
					label: "Tanggal Jam Awal Istirahat",
					name: "htssctd.tanggaljam_awal_istirahat",
					type: "datetime",
					def: function () { 
						return new Date(); 
					},
					opts:{
						minDate: new Date('1900-01-01'),
						firstDay: 0
					},
					format: 'DD MMM YYYY HH:mm'
				},
				{
					label: "Tanggal Jam Akhir Istirahat",
					name: "htssctd.tanggaljam_akhir_istirahat",
					type: "datetime",
					def: function () { 
						return new Date(); 
					},
					opts:{
						minDate: new Date('1900-01-01'),
						firstDay: 0
					},
					format: 'DD MMM YYYY HH:mm'
				},
			]
		} );

		edthtssctd.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthtssctd.field('htssctd.start_at').val(start_at);
			
			if(action == 'create'){
				tblhtssctd.rows().deselect();
			}
		});

		edthtssctd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edthtssctd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				tanggal = edthtssctd.field('htssctd.tanggal').val();
				tanggal_ymd = moment(tanggal).format("YYYY-MM-DD HH:mm:ss");
				id_hemxxmh = edthtssctd.field('htssctd.id_hemxxmh').val();

				validasiRequired(
					edthtssctd,
					'htssctd',
					{
						'tanggal': tanggal,
						'id_hemxxmh': id_hemxxmh
					}
				);

				validasiUnique(
					action,
					edthtssctd,
					'htssctd',
					'id_hemxxmh,tanggal',
					'id_hemxxmh,tanggal',
					id_hemxxmh + ',"'+tanggal_ymd+'"',
					id_htssctd
				);

			}
			
			if ( edthtssctd.inError() ) {
				return false;
			}
		});
		
		edthtssctd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthtssctd.field('htssctd.finish_at').val(finish_at);
		});

		edthtssctd.on( 'close', function () {
			edthtssctd.enable();
		} );

		tblhtssctd = $('#tblhtssctd').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/htssctd/htssctd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_htssctd = show_deleted_htssctd;
					d.start_date = start_date;
					d.end_date = end_date;
					d.id_hemxxmh_filter = id_hemxxmh_filter;
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
				{ data: "htssctd.id",visible:false },
				{ data: "htssctd.tanggal" },
				{ data: "hemxxmh.kode" },
				{ data: "hemxxmh_fullname" },
				{ data: "hodxxmh.nama" },
				{ data: "htssctd.tanggaljam_awal_t1" },
				{ data: "htssctd.tanggaljam_awal" },
				{ data: "htssctd.tanggaljam_awal_t2" },
				{ data: "htssctd.tanggaljam_akhir_t1" },
				{ data: "htssctd.tanggaljam_akhir" },
				{ data: "htssctd.tanggaljam_akhir_t2" },
				{ 
					data: "htssctd.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_htssctd';
					$table       = 'tblhtssctd';
					$edt         = 'edthtssctd';
					$show_status = '_htssctd';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= ['sf','sp', 'sb'];
					$arr_buttons_action 	= ['create', 'edit', 'remove', 'confirm', 'nonaktif_h', 'close', 'view', 'log','noaction'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
				// END breaking generate button
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
				if ( data.htssctd.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.htssctd.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblhtssctd.searchPanes.container().appendTo('#sphtssctd');
		tblhtssctd.searchBuilder.container().appendTo( '#sbhtssctd' );
		
		tblhtssctd.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblhtssctd);
		} );
		
		tblhtssctd.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('htssctd');
			id_hemxxmh_old = htssctd_data.id_hemxxmh;

			// atur hak akses
			CekSelectHeaderH(tblhtssctd);
		} );

		tblhtssctd.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('htssctd');
			id_hemxxmh_old = 0;

			// atur hak akses
			CekDeselectHeaderH(tblhtssctd);
		} );

		// BEGIN form filter
		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
				start_date: {
					required: true,
					validDate: "DD MMM YYYY"
				},
				end_date: {
					required: true,
					validDate: "DD MMM YYYY"
				}
			},
			messages: {
				start_date: {
					required: "Start Date Wajib Diisi!"
				},
				end_date: {
					required: "End Date Wajib Diisi!"
				}
			},
			submitHandler: function(frmFilter) {
				start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				if( $('#selectPegawai').val() > 0){
					id_hemxxmh_filter  = $('#selectPegawai').val();
				}else{
					id_hemxxmh_filter = '';
				}

				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
				tblhtssctd.rows().deselect();
				tblhtssctd.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSFhtssctd').modal('toggle');
			}, false);
				return false;
			}
		});
		// END form filter

		// END htssctd
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
