<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'hrremth';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'hrrertd';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">

				<div class="modal" id="modalSFhrremth" tabindex="-1" role="dialog" aria-hidden="true">
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
					<div id="frmhrremth">
						<div class="tabs-container">
							<ul class="nav nav-tabs" role="tablist">
								<li><a class="nav-link active" data-toggle="tab" href="#tabprofile"> Profile</a></li>
								<li><a class="nav-link" data-toggle="tab" href="#tabalasan"> Alasan</a></li>
								<li><a class="nav-link" data-toggle="tab" href="#tabspesifikasi"> Spesifikasi</a></li>
							</ul>
							<div class="tab-content">
								<div role="tabpanel" id="tabprofile" class="tab-pane active">
									<div class="panel-body">
										<div class="row">
											<div class="col-lg-6">
												<editor-field name="hrremth.id_heyxxmh"></editor-field>
											</div>
											<div class="col-lg-6">
												<editor-field name="hrremth.id_hetxxmh"></editor-field>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-6">
												<editor-field name="hrremth.id_hevxxmh"></editor-field>
											</div>
											<div class="col-lg-6">
												<editor-field name="hrremth.id_hovxxmh"></editor-field>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-6">
												<editor-field name="hrremth.id_hodxxmh"></editor-field>
											</div>
											<div class="col-lg-6">
												<editor-field name="hrremth.id_hosxxmh"></editor-field>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-6">
												<editor-field name="hrremth.keterangan"></editor-field>
											</div>
										</div>
									</div>
								</div>
								<div role="tabpanel" id="tabalasan" class="tab-pane">
									<div class="panel-body">
										<div class="row">
											<div class="col-lg-6">
												<editor-field name="hrremth.addition"></editor-field>
											</div>
											<div class="col-lg-6">
												<editor-field name="hrremth.replacement"></editor-field>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-6">
												<editor-field name="hrremth.jumlah"></editor-field>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-6">
												<editor-field name="pengaju"></editor-field>
											</div>
											<div class="col-lg-6">
												<editor-field name="hrremth.tanggal_dibutuhkan"></editor-field>
											</div>
										</div>
									</div>
								</div>
								<div role="tabpanel" id="tabspesifikasi" class="tab-pane">
									<div class="panel-body">
										<div class="row">
											<div class="col-lg-6">
												<editor-field name="hgnlgmh[].id"></editor-field>
											</div>
											<div class="col-lg-6">
												<editor-field name="hrremth.id_hgnedmh"></editor-field>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-6">
												<editor-field name="hrremth.jenis_kelamin"></editor-field>
											</div>
											<div class="col-lg-6">
												<editor-field name="hrremth.is_batasan_usia"></editor-field>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-6">
												<editor-field name="hrremth.usia_min"></editor-field>
											</div>
											<div class="col-lg-6">
												<editor-field name="hrremth.usia_max"></editor-field>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-6">
												<editor-field name="hrremth.pengalaman"></editor-field>
											</div>
											<div class="col-lg-6">
												<editor-field name="hrremth.tahun_pengalaman"></editor-field>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-6">
												<editor-field name="hrremth.jurusan"></editor-field>
											</div>
											<div class="col-lg-6">
												<editor-field name="hrremth.tugas_umum"></editor-field>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-6">
												<editor-field name="hrremth.kemampuan_tambahan"></editor-field>
											</div>
											<div class="col-lg-6">
												<editor-field name="hrremth.kemampuan_wajib"></editor-field>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>	
					</div>	
                    <table id="tblhrremth" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Kode</th>
                                <th>Tanggal</th>
                                <th>Tanggal Dibutuhkan</th>
                                <th>Jumlah</th>
                                <th>Employee Title</th>
                                <th>Employee Type</th>
                                <th>State</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

	<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="tabs-container">
			<ul class="nav nav-tabs" role="tablist">
				<li><a class="nav-link active" data-toggle="tab" href="#tabhrrertd_1"> Detail</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabhrrertd_1" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblhrrertd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_hrremth</th>
										<th>NIP</th>
										<th>Nama</th>
									</tr>
								</thead>
							</table>
						</div> <!-- end of table -->

					</div>
				</div>
			</div>

		</div>
	</div> <!-- end of right col -->

</div> <!-- end of row -->

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
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/hrremth/fn/hrremth_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edthrremth, tblhrremth, show_deleted_hrremth = 0, id_hrremth;
	var edthrrertd, tblhrrertd, show_deleted_hrrertd = 0, id_hrrertd;
	// ------------- end of default variable
	var replacement_select = 0, id_hgnedmh_old = 0, id_hemxxmh_old = 0, id_hemxxmh_pengaju_old = 0, ids_hgnlgmh_old = '', id_hovxxmh_old = 0, id_hodxxmh_old = 0, id_hosxxmh_old = 0, id_hetxxmh_old = 0, id_hevxxmh_old = 0, id_heyxxmh_old = 0, id_hosxxmh_old = 0;

	// get tableRelation
	tableRelation('hrremth');

	$(document).ready(function() {
		start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');

		// BEGIN hrremth
		edthrremth = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/hrremth/hrremth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hrremth = show_deleted_hrremth;
					d.start_date = start_date;
					d.end_date = end_date;
				}
			},
			template: "#frmhrremth",
			table: "#tblhrremth",
			fields: [ 
				{
					label: "kategori_dokumen",
					name: "kategori_dokumen",
					type: "hidden"
				},	{
					label: "kategori_dokumen_value",
					name: "kategori_dokumen_value",
					type: "hidden"
				},	{
					label: "field_tanggal",
					name: "field_tanggal",
					type: "hidden"
				},
				{
					label: "hrremth.start_at",
					name: "hrremth.start_at",
					type: "hidden"
				},	
				{
					label: "hrremth.finish_at",
					name: "hrremth.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "hrremth",
					type: "hidden"
				},	
				{
					label: "hrremth.transaction_state",
					name: "hrremth.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: "Tanggal",
					name: "hrremth.tanggal",
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
					label: "Employee Type <sup class='text-danger'>*<sup>",
					name: "hrremth.id_heyxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/heyxxmh/heyxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_heyxxmh_old: id_heyxxmh_old,
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
					label: "Employee Title <sup class='text-danger'>*<sup>",
					name: "hrremth.id_hetxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/hetxxmh/hetxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_hetxxmh_old: id_hetxxmh_old,
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
					label: "Employee Level <sup class='text-danger'>*<sup>",
					name: "hrremth.id_hevxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/hevxxmh/hevxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_hevxxmh_old: id_hevxxmh_old,
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
					label: "Division <sup class='text-danger'>*<sup>",
					name: "hrremth.id_hovxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/hovxxmh/hovxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_hovxxmh_old: id_hovxxmh_old,
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
					label: "Department <sup class='text-danger'>*<sup>",
					name: "hrremth.id_hodxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/hodxxmh/hodxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_hodxxmh_old: id_hodxxmh_old,
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
					label: "Section ",
					name: "hrremth.id_hosxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/hosxxmh/hosxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_hosxxmh_old: id_hosxxmh_old,
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
					label: "Notes",
					name: "hrremth.keterangan",
					type: "textarea"
				},
				{
					label: "Addition",
					name: "hrremth.addition"
				}, 	
				{
					label: "Replacement",
					name: "hrremth.replacement"
				}, 	
				{
					label: "Jumlah",
					name: "hrremth.jumlah",
					type: "readonly"
				}, 	
				{
					label: "Required Date",
					name: "hrremth.tanggal_dibutuhkan",
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
					label: "Tugas Umum",
					name: "hrremth.tugas_umum",
					type: "textarea"
				},
				{
					label: "Jenis Kelamin <sup class='text-danger'>*<sup>",  
					name: "hrremth.jenis_kelamin",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": "Pria", "value": "Pria" },
						{ "label": "Wanita", "value": "Wanita" },
						{ "label": "Bebas", "value": "Bebas" },
					]
				},
				{
					label: "Batasan Usia",
					name: "hrremth.is_batasan_usia",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": "Ya", "value": 1 },
						{ "label": "Tidak", "value": 0 }
					]
				},
				{
					label: "Usia Min <sup class='text-danger'>*<sup>",
					name: "hrremth.usia_min"
				}, 
				{
					label: "Usia Max <sup class='text-danger'>*<sup>",
					name: "hrremth.usia_max"
				}, 
				{
					label: "Pengalaman <sup class='text-danger'>*<sup>",  
					name: "hrremth.pengalaman",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": "Fresh Graduated", "value": "Fresh Graduated" },
						{ "label": "Pengalaman", "value": "Pengalaman" },
						{ "label": "Bebas", "value": "Bebas" },
					]
				},
				{
					label: "Tahun Pengalaman <sup class='text-danger'>*<sup>",
					name: "hrremth.tahun_pengalaman"
				}, 
				{
					label: "Pendidikan",
					name: "hrremth.id_hgnedmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/hgnedmh/hgnedmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_hgnedmh_old: id_hgnedmh_old,
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
					label: "Jurusan",
					name: "hrremth.jurusan"
				}, 
				{
					label: "Diajukan Oleh",
					name: "pengaju",
					type: "readonly"
				}, 
				{
					label: "Kemampuan Wajib",
					name: "hrremth.kemampuan_wajib",
					type: "textarea"
				}, 
				{
					label: "Kemampuan Tambahan",
					name: "hrremth.kemampuan_tambahan",
					type: "textarea"
				}, 
				{
					label: "Bahasa",
					name: "hgnlgmh[].id",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: true,
						ajax: {
							url: "../../models/hgnlgmh/hgnlgmh_fn_opt_multiple.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									ids_hgnlgmh_old: ids_hgnlgmh_old,
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
			]
		} );
		
		edthrremth.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthrremth.field('hrremth.start_at').val(start_at);
			
			if(action == 'create'){
				tblhrremth.rows().deselect();
				getNamaPengaju();
				console.log(namaPengaju);
				edthrremth.field('pengaju').val(namaPengaju);
			} else if (action == 'edit'){
				autofillField('hemxxmh', id_hemxxmh_pengaju_old, 'nama');
				nama = autofillData.nama;
				console.log(nama);
				edthrremth.field('pengaju').val(nama);
			}
		});

		edthrremth.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-xl");
			edtFormButtonSaveConfirmHD();
		});

		edthrremth.dependent( 'hrremth.addition', function ( val, data, callback ) {
				addition = parseFloat(edthrremth.field('hrremth.addition').val()) || 0; 
				replacement = parseFloat(edthrremth.field('hrremth.replacement').val()) || 0;
				jumlah = addition + replacement; 

				edthrremth.field('hrremth.jumlah').val(jumlah);
			return {}
		}, {event: 'keyup change'});

		edthrremth.dependent( 'hrremth.replacement', function ( val, data, callback ) {
				addition = parseFloat(edthrremth.field('hrremth.addition').val()) || 0; 
				replacement = parseFloat(edthrremth.field('hrremth.replacement').val()) || 0;
				jumlah = addition + replacement; 
				edthrremth.field('hrremth.jumlah').val(jumlah);
			return {}
		}, {event: 'keyup change'});

		edthrremth.dependent( 'hrremth.pengalaman', function ( val, data, callback ) {
				if (val == "Pengalaman") {
					edthrremth.field('hrremth.tahun_pengalaman').show();
					edthrremth.field('hrremth.tahun_pengalaman').val();
				} else {
					edthrremth.field('hrremth.tahun_pengalaman').hide();
					edthrremth.field('hrremth.tahun_pengalaman').val('');
				}
			return {}
		}, {event: 'keyup change'});
		
		edthrremth.dependent( 'hrremth.is_batasan_usia', function ( val, data, callback ) {
				if (val == 1) {
					edthrremth.field('hrremth.usia_min').show();
					edthrremth.field('hrremth.usia_max').show();
					edthrremth.field('hrremth.usia_min').val();
					edthrremth.field('hrremth.usia_max').val();
				} else {
					edthrremth.field('hrremth.usia_min').hide();
					edthrremth.field('hrremth.usia_max').hide();
					edthrremth.field('hrremth.usia_min').val('');
					edthrremth.field('hrremth.usia_max').val('');
				}
			return {}
		}, {event: 'keyup change'});
		
		edthrremth.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				id_heyxxmh = edthrremth.field('hrremth.id_heyxxmh').val();
				id_hetxxmh = edthrremth.field('hrremth.id_hetxxmh').val();
				id_hevxxmh = edthrremth.field('hrremth.id_hevxxmh').val();
				id_hovxxmh = edthrremth.field('hrremth.id_hovxxmh').val();
				id_hodxxmh = edthrremth.field('hrremth.id_hodxxmh').val();
				jumlah = edthrremth.field('hrremth.jumlah').val();
				jenis_kelamin = edthrremth.field('hrremth.jenis_kelamin').val();
				addition = edthrremth.field('hrremth.addition').val();
				replacement = edthrremth.field('hrremth.replacement').val();
				tugas_umum = edthrremth.field('hrremth.tugas_umum').val();
				kemampuan_wajib = edthrremth.field('hrremth.kemampuan_wajib').val();
				kemampuan_tambahan = edthrremth.field('hrremth.kemampuan_tambahan').val();
				pengalaman = edthrremth.field('hrremth.pengalaman').val();
				tahun_pengalaman = edthrremth.field('hrremth.tahun_pengalaman').val();
				is_batasan_usia = edthrremth.field('hrremth.is_batasan_usia').val();
				usia_min = edthrremth.field('hrremth.usia_min').val();
				usia_max = edthrremth.field('hrremth.usia_max').val();

				validasiRequired(
					edthrremth,
					'hrremth',
					{
						'id_heyxxmh': id_heyxxmh,
						'id_hetxxmh': id_hetxxmh,
						'id_hevxxmh': id_hevxxmh,
						'id_hovxxmh': id_hovxxmh,
						'id_hodxxmh': id_hodxxmh,
						'jumlah': jumlah,
						'jenis_kelamin': jenis_kelamin,
						'pengalaman': pengalaman,
					
					}
				);

				if (replacement == '' && addition == '') {
					validasiNumber(
						edthrremth,
						'hrremth',
						{
							'replacement': replacement,
							'addition': addition,
						},
						0,
						'>='
					);
				} else {
					if (replacement != '') {
						validasiNumber(
							edthrremth,
							'hrremth',
							{
								'replacement': replacement
							},
							0,
							'>='
						);
					}

					if (addition != '') {
						validasiNumber(
							edthrremth,
							'hrremth',
							{
								'addition': addition
							},
							0,
							'>='
						);
					}
				}
				

				if (pengalaman == "Pengalaman") {
					validasiNumber(
						edthrremth,
						'hrremth',
						{
							'tahun_pengalaman': tahun_pengalaman
						},
						0,
						'>'
					);
				}

				if (is_batasan_usia == 1) {
					validasiNumber(
						edthrremth,
						'hrremth',
						{
							'usia_min': usia_min,
							'usia_max': usia_max,
						},
						0,
						'>'
					);
					
					if (parseFloat(usia_min) < 17) {
						edthrremth.field('hrremth.usia_min').error( 'Batas Usia wajib 17 tahun keatas!' );
					}
					if (parseFloat(usia_max) < 17) {
						edthrremth.field('hrremth.usia_max').error( 'Batas Usia wajib 17 tahun keatas!' );
					}

					if (parseFloat(usia_min) > parseFloat(usia_max)) {
						edthrremth.field('hrremth.usia_min').error('Usia Min harus lebih kecil atau sama dengan Usia Max!');
						edthrremth.field('hrremth.usia_max').error('Usia Max harus lebih besar atau sama dengan Usia Min!');
					}
				}
				

				if (tugas_umum.length > 500) {
					edthrremth.field('hrremth.tugas_umum').error( 'Maximum 500 karakter' );
				}

				if (kemampuan_wajib.length > 500) {
					edthrremth.field('hrremth.kemampuan_wajib').error( 'Maximum 500 karakter' );
				}

				if (kemampuan_tambahan.length > 500) {
					edthrremth.field('hrremth.kemampuan_tambahan').error( 'Maximum 500 karakter' );
				}
			}
			
			if ( edthrremth.inError() ) {
				return false;
			}
		});

		edthrremth.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthrremth.field('hrremth.finish_at').val(finish_at);
		});
		
		edthrremth.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
			tblhrremth.ajax.reload(null, false);
		} );

		edthrremth.on( 'close', function () {
			edthrremth.enable();
		} );
		
		tblhrremth = $('#tblhrremth').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/hrremth/hrremth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hrremth = show_deleted_hrremth;
					d.start_date = start_date;
					d.end_date = end_date;
				}
			},
			order: [[ 1, "desc" ]],
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
				{ data: "hrremth.id",visible:false },
				{ data: "hrremth.kode" },
				{ data: "hrremth.tanggal" },
				{ data: "hrremth.tanggal_dibutuhkan" },
				{ data: "hrremth.jumlah" },
				{ data: "hetxxmh.nama" },
				{ data: "heyxxmh.nama" },
				{ 
					data: "hrremth.transaction_state" ,
					...renderTransactionStatus()
				},
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hrremth';
					$table       = 'tblhrremth';
					$edt         = 'edthrremth';
					$show_status = '_hrremth';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= ['sf', 'sp', 'sb'];
					$arr_buttons_action 	= ['create', 'edit', 'remove_hd', 'confirm', 'nonaktif_hd', 'close', 'view', 'log','noaction'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
				// END breaking generate button
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
				if ( data.hrremth.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.hrremth.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblhrremth.searchPanes.container().appendTo('#sphrremth');
		tblhrremth.searchBuilder.container().appendTo( '#sbhrremth' );
		
		tblhrremth.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblhrrertd];
			CekInitHeaderHD(tblhrremth, tbl_details);
		} );
		
		tblhrremth.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('hrremth');
			id_hovxxmh_old   = hrremth_data.id_hovxxmh;
			id_hodxxmh_old   = hrremth_data.id_hodxxmh;
			id_hevxxmh_old   = hrremth_data.id_hevxxmh;
			id_hetxxmh_old   = hrremth_data.id_hetxxmh;
			id_heyxxmh_old   = hrremth_data.id_heyxxmh;
			id_hosxxmh_old   = hrremth_data.id_hosxxmh;
			id_hgnedmh_old   = hrremth_data.id_hgnedmh;
			id_hemxxmh_pengaju_old   = hrremth_data.id_hemxxmh_pengaju;
			replacement_select   = hrremth_data.replacement;
			tblhrremth.rows( { selected: true } ).data().each(function (row) {
				if (row.hgnlgmh) {
					ids_hgnlgmh_old = "";
					row.hgnlgmh.forEach(function (hgnlgmh_data) {
						ids_hgnlgmh_old = ids_hgnlgmh_old + "," + hgnlgmh_data.id;
					});
					ids_hgnlgmh_old = ids_hgnlgmh_old.substring(1);
				}
			});
			
			// atur hak akses
			tbl_details = [tblhrrertd];
			CekSelectHeaderHD(tblhrremth, tbl_details);

			cekDetail();
			console.log(c_id);
			console.log(replacement_select);

			if (replacement_select > 0) {
				if (c_id < replacement_select) {
					tblhrrertd.button('btnCreate:name').enable();
				} else {
					tblhrrertd.button('btnCreate:name').disable();
				}
			} else {
				tblhrrertd.button('btnCreate:name').disable();
			}
		} );
		
		tblhrremth.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('hrremth');
			id_hovxxmh_old   = 0;
			id_hodxxmh_old   = 0;
			id_hevxxmh_old   = 0;
			id_hetxxmh_old   = 0;
			id_heyxxmh_old   = 0;
			id_hosxxmh_old   = 0;
			id_hgnedmh_old   = 0;
			id_hemxxmh_pengaju_old   = 0;
			replacement_select   = 0;
			ids_hgnlgmh_old = '';

			// atur hak akses
			tbl_details = [tblhrrertd];
			CekDeselectHeaderHD(tblhrremth, tbl_details);
		} );
		// END hrremth

		// BEGIN hrrertd
		edthrrertd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/hrremth/hrrertd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hrrertd = show_deleted_hrrertd;
					d.id_hrremth = id_hrremth;
				}
			},
			table: "#tblhrrertd",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "hrrertd.start_at",
					name: "hrrertd.start_at",
					type: "hidden"
				},	
				{
					label: "hrrertd.finish_at",
					name: "hrrertd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "hrrertd",
					type: "hidden"
				},	
				{
					label: "hrrertd.transaction_state",
					name: "hrrertd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_hrremth",
					name: "hrrertd.id_hrremth",
					type: "hidden"
				},	
				{
					label: "Employeee Name  <sup class='text-danger'>*<sup>", 
					name: "hrrertd.id_hemxxmh",
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
			]
		} );
			
		edthrrertd.on( 'preOpen', function( e, mode, action ) {
			edthrrertd.field('hrrertd.id_hrremth').val(id_hrremth);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthrrertd.field('hrrertd.start_at').val(start_at);
			
			if(action == 'create'){
				tblhrrertd.rows().deselect();
			}
		});

		edthrrertd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});
		
		edthrrertd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				id_hemxxmh = edthrrertd.field('hrrertd.id_hemxxmh').val();

				validasiRequired(
					edthrrertd,
					'hrrertd',
					{
						'id_hemxxmh': id_hemxxmh
					}
				);

				validasiUnique(
					action,
					edthrrertd,
					'hrrertd',
					'id_hemxxmh',
					'id_hemxxmh',
					id_hemxxmh,
					id_hrrertd
				);	
			}
			
			if ( edthrrertd.inError() ) {
				return false;
			}
		});

		edthrrertd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthrrertd.field('hrrertd.finish_at').val(finish_at);
		});
			
		edthrrertd.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
			tblhrremth.ajax.reload(null, false);
		} );

		edthrrertd.on( 'close', function () {
			edthrrertd.enable();
		} );
		
		tblhrrertd = $('#tblhrrertd').DataTable( {
			ajax: {
				url: "../../models/hrremth/hrrertd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hrrertd = show_deleted_hrrertd;
					d.id_hrremth = id_hrremth;
				}
			},
			order: [[ 2, "desc" ]],
			columns: [
				{ data: "hrrertd.id",visible:false },
				{ data: "hrrertd.id_hrremth",visible:false },
				{ data: "hemxxmh.kode" },
				{ data: "hemxxmh.nama" },
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hrrertd';
					$table       = 'tblhrrertd';
					$edt         = 'edthrrertd';
					$show_status = '_hrrertd';
					$table_name  = $nama_tabels_d[0];

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= [];
					$arr_buttons_action 	= ['create', 'edit', 'remove','view', 'log','noactionD'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php';
				?>
				// END breaking generate button
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
			}
		} );

		tblhrrertd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tblhrrertd, 0 );
			CekDrawDetailHDFinal(tblhrremth);
		} );

		tblhrrertd.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSetD('hrrertd');
			id_hemxxmh_old   = hrrertd_data.id_hemxxmh;
			
			// atur hak akses
			CekSelectDetailHD( tblhrrertd );
			

			if (replacement_select > 0) {
				if (c_id < replacement_select) {
					tblhrrertd.button('btnEdit:name').enable();
					tblhrrertd.button('btnRemove:name').enable();
				} else {
					tblhrrertd.button('btnEdit:name').disable();
					tblhrrertd.button('btnRemove:name').disable();
				}
			} else {
				tblhrrertd.button('btnEdit:name').disable();
				tblhrrertd.button('btnRemove:name').disable();
			}
		} );

		tblhrrertd.on( 'deselect', function() {
			// reset variable standar framework
			siVarResetD('hrrertd');
			id_hemxxmh_old   = 0;
			
			// atur hak akses
			CekDeselectDetailHD( tblhrrertd );
		} );
		// END hrrertd

		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
			},
			submitHandler: function(frmFilter) {
				start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
				tblhrremth.rows().deselect();
				tblhrremth.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSFhrremth').modal('toggle');
			}, false);
				return false;
			}
		});
		
	} );// end of document.ready
	
</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
