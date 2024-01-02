<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'podxxth';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'podittd';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
					
					<!-- start Custom Form Datatables Editor -->
					<div id="custom_podxxth">
						<div class="panel-body">
							<div class="row">
								<div class="col-lg-6">
									<editor-field name="podxxth.tanggal"></editor-field>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<editor-field name="podxxth.id_iittpmh"></editor-field>
								</div>
								<div class="col-lg-6">
									<editor-field name="podxxth.id_fcrxxmh"></editor-field>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<editor-field name="podxxth.id_fpytmmh"></editor-field>
								</div>
								<div class="col-lg-6">
									<editor-field name="podxxth.id_psuxxmh"></editor-field>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<editor-field name="podxxth.is_diskon_persen"></editor-field>
								</div>
								<div class="col-lg-6">
									<editor-field name="podxxth.diskon_persen"></editor-field>
									<editor-field name="podxxth.diskon_value"></editor-field>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<editor-field name="podxxth.diskon_final"></editor-field>
								</div>
								<div class="col-lg-6">
									<editor-field name="podxxth.subtotal"></editor-field>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<editor-field name="podxxth.dpp"></editor-field>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<editor-field name="podxxth.keterangan"></editor-field>
								</div>
							</div>
						</div>
					</div>
					<!-- end Custom Form Datatables Editor -->
                    <table id="tblpodxxth" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tanggal</th>
                                <th>Kode</th>
                                <th>Type</th>
                                <th>Total</th>
                                <th>TX</th>
                                <th>Approval</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

	<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 p-w-xs">
		<div class="tabs-container">
			<ul class="nav nav-tabs" role="tablist">
				<li><a class="nav-link active" data-toggle="tab" href="#tabpodittd_1"> Detail</a></li>
				<li><a class="nav-link" data-toggle="tab" href="#tabpodittd_2"> Tab 2</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabpodittd_1" class="tab-pane active">
					<div class="panel-body">
					<!-- start Custom Form Datatables Editor -->
					<div id="custom_podittd">
						<div class="panel-body">
							<div class="row">
								<div class="col-lg-6">
									<editor-field name="podittd.id_prqittd"></editor-field>
								</div>
								<div class="col-lg-6">
									<editor-field name="podittd.id_iimxxmh"></editor-field>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<editor-field name="podittd.id_iumxxmh"></editor-field>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<editor-field name="podittd.harga_unit"></editor-field>
								</div>
								<div class="col-lg-6">
									<editor-field name="podittd.jumlah_unit"></editor-field>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<editor-field name="podittd.is_diskon_persen"></editor-field>
								</div>
								<div class="col-lg-6">
									<editor-field name="podittd.diskon_persen"></editor-field>
									<editor-field name="podittd.diskon_value"></editor-field>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<editor-field name="podittd.diskon_final"></editor-field>
								</div>
								<div class="col-lg-6">
									<editor-field name="podittd.subtotal"></editor-field>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<editor-field name="podittd.dpp"></editor-field>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<editor-field name="podittd.tanggal"></editor-field>
								</div>
								<div class="col-lg-6">
									<editor-field name="podittd.keterangan"></editor-field>
								</div>
							</div>
						</div>
					</div>
					<!-- end Custom Form Datatables Editor -->
						<div class="table-responsive">
							<table id="tblpodittd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_podxxth</th>
										<th>Item PR</th>
										<th>Item</th>
										<th>UoM</th>
										<th>Quantity</th>
										<th>Price</th>
										<th>Subtotal</th>
										<th>Discount</th>
										<th>Total</th>
									</tr>
								</thead>
								<tfoot>
									<th></th>
									<th>Total</th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th id="sum7"></th>
									<th id="sum8"></th>
									<th id="sum9"></th>
								</tfoot>
							</table>
						</div> <!-- end of table -->

					</div>
				</div>
				<div role="tabpanel" id="tabpodittd_2" class="tab-pane">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblpodittd_2" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_podxxth</th>
										<th>Kode</th>
										<th>Nama</th>
										<th>Keterangan</th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div> <!-- end of right col -->

</div> <!-- end of row -->

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
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn.js"></script>

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/podxxth/fn/podxxth_fn.php'; ?>

<!-- Untuk Kalkulasi Subtotal dan Diskon -->
<?php require_once $abs_us_root . $us_url_root . 'usersc/helpers/fn_kalkulasi_header_detail.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtpodxxth, tblpodxxth, show_deleted_podxxth = 0, id_podxxth;
	var edtpodittd, tblpodittd, show_deleted_podittd = 0, id_podittd;
	// ------------- end of default variable
	var id_iittpmh_old = 0;
	var id_psuxxmh_old = 0;
	var id_fcrxxmh_old = 0;
	var id_fpytmmh_old = 0;
	var id_iumxxmh_old = 0;
	var id_iimxxmh_old = 0;
	var id_prqittd_old = 0;
	var is_need_generate_kode = 1;

	$(document).ready(function() {
		//start datatables editor
		edtpodxxth = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/podxxth/podxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_podxxth = show_deleted_podxxth;
				}
			},
			template: "#custom_podxxth",
			table: "#tblpodxxth",
			fields: [ 
				{
					// untuk generate_kode
					label: "kategori_dokumen",
					name: "kategori_dokumen",
					type: "hidden"
				},	{
					// untuk generate_kode
					label: "kategori_dokumen_value",
					name: "kategori_dokumen_value",
					type: "hidden"
				},	{
					// untuk generate_kode
					label: "field_tanggal",
					name: "field_tanggal",
					type: "hidden"
				},
				{
					label: "podxxth.start_at",
					name: "podxxth.start_at",
					type: "hidden"
				},	
				{
					label: "podxxth.finish_at",
					name: "podxxth.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "podxxth",
					type: "hidden"
				},	
				{
					label: "podxxth.transaction_state",
					name: "podxxth.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: "Type <sup class='text-danger'>*<sup>",
					name: "podxxth.id_iittpmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/iittpmh/iittpmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_iittpmh_old: id_iittpmh_old,
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
					label: "Payment Terms <sup class='text-danger'>*<sup>",
					name: "podxxth.id_fpytmmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/fpytmmh/fpytmmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_fpytmmh_old: id_fpytmmh_old,
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
					label: "Supplier <sup class='text-danger'>*<sup>",
					name: "podxxth.id_psuxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/psuxxmh/psuxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_psuxxmh_old: id_psuxxmh_old,
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
					label: "Currency <sup class='text-danger'>*<sup>",
					name: "podxxth.id_fcrxxmh",
					id: "select_id_fcrxxmh", //tambahkan id di select2nya
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/fcrxxmh/fcrxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {

								var query = {
									id_fcrxxmh_old: id_fcrxxmh_old,
									search: params.term || '',
									page: params.page || 1
								}
									return query;
							},
							processResults: function (data, params) {
								var options = data.results.map(function (result) {
									return {
										id: result.id,
										text: result.text
									};
								});

								defaultCurrency();
								// console.log(id_def);
								// console.log(nama_def);

								if (params.page && params.page === 1) {
									$('#select_id_fcrxxmh').empty().select2({ data: options });
								} else {
									$('#select_id_fcrxxmh').append(new Option(nama_def, id_def, false, false)).trigger('change');
								}

								return {
									results: options,
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
					label: "Tanggal <sup class='text-danger'>*<sup>",
					name: "podxxth.tanggal",
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
					label: "Subtotal",
					name: "podxxth.subtotal",
					type: "readonly"
				},
				{
					label: "Diskon",
					name: "podxxth.is_diskon_persen",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": "-", "value": 0 },
						{ "label": "Percent", "value": 1 },
						{ "label": "Value", "value": 2 }
					]
				},
				{
					label: "Diskon (%)",
					name: "podxxth.diskon_persen"
				}, 	{
					label: "Diskon (Rp)",
					name: "podxxth.diskon_value"
				}, 	{
					label: "Diskon Final",
					name: "podxxth.diskon_final",
					type: "readonly"
				},
				{
					label: "Total",
					name: "podxxth.dpp",
					type: "readonly"
				},
				{
					label: "Keterangan",
					name: "podxxth.keterangan",
					type: "textarea"
				},
			]
		} );
		
		edtpodxxth.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtpodxxth.field('podxxth.start_at').val(start_at);

			if(action == 'create'){
				tblpodxxth.rows().deselect();
				edtpodxxth.field('kategori_dokumen').val('');
				edtpodxxth.field('kategori_dokumen_value').val('');
				edtpodxxth.field('field_tanggal').val('start_at');
			}
		});

		edtpodxxth.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-xl");
			
			$('#select_id_fcrxxmh').select2('open');

			setTimeout(function() {
				$('#select_id_fcrxxmh').select2('close');
			}, 5);
		});
		
		edtpodxxth.dependent( 'podxxth.is_diskon_persen', function ( val, data, callback ) {
			if (val == 1) {
				edtpodxxth.field('podxxth.diskon_persen').show();
				edtpodxxth.field('podxxth.diskon_value').hide();
				
				edtpodxxth.field('podxxth.diskon_persen').val();
				edtpodxxth.field('podxxth.diskon_value').val('');
			} else if (val == 2) {
				edtpodxxth.field('podxxth.diskon_persen').hide();
				edtpodxxth.field('podxxth.diskon_value').show();
				
				edtpodxxth.field('podxxth.diskon_persen').val('');
				edtpodxxth.field('podxxth.diskon_value').val();
			} else {
				edtpodxxth.field('podxxth.diskon_persen').hide();
				edtpodxxth.field('podxxth.diskon_value').hide();
				
				edtpodxxth.field('podxxth.diskon_persen').val(0);
				edtpodxxth.field('podxxth.diskon_value').val(0);
				edtpodxxth.field('podxxth.diskon_final').val(0);
			}
			return {}
		}, {event: 'keyup change'});
		
		edtpodxxth.dependent( 'podxxth.diskon_persen', function ( val, data, callback ) {
			if (val != null) {
				hitungDiskon(edtpodxxth, 'podxxth');
			}
			return {}
		}, {event: 'keyup change'});
		
		edtpodxxth.dependent( 'podxxth.diskon_value', function ( val, data, callback ) {
			if (val != null) {
				hitungDiskon(edtpodxxth, 'podxxth');
			}
			return {}
		}, {event: 'keyup change'});
		
		edtpodxxth.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				// BEGIN of validasi podxxth.id_psuxxmh 
				id_psuxxmh = edtpodxxth.field('podxxth.id_psuxxmh').val();
				if(!id_psuxxmh || id_psuxxmh == ''){
					edtpodxxth.field('podxxth.id_psuxxmh').error( 'Wajib diisi!' );
				}
				// END of validasi podxxth.id_psuxxmh 

				// BEGIN of validasi podxxth.id_fpytmmh 
				id_fpytmmh = edtpodxxth.field('podxxth.id_fpytmmh').val();
				if(!id_fpytmmh || id_fpytmmh == ''){
					edtpodxxth.field('podxxth.id_fpytmmh').error( 'Wajib diisi!' );
				}
				// END of validasi podxxth.id_fpytmmh 

				// BEGIN of validasi podxxth.id_fcrxxmh 
				id_fcrxxmh = edtpodxxth.field('podxxth.id_fcrxxmh').val();
				if(!id_fcrxxmh || id_fcrxxmh == ''){
					edtpodxxth.field('podxxth.id_fcrxxmh').error( 'Wajib diisi!' );
				}
				// END of validasi podxxth.id_fcrxxmh 

				// BEGIN of validasi podxxth.id_iittpmh 
				id_iittpmh = edtpodxxth.field('podxxth.id_iittpmh').val();
				if(!id_iittpmh || id_iittpmh == ''){
					edtpodxxth.field('podxxth.id_iittpmh').error( 'Wajib diisi!' );
				}
				// END of validasi podxxth.id_iittpmh 

				// BEGIN of validasi podxxth.tanggal 
				tanggal = edtpodxxth.field('podxxth.tanggal').val();
				if(!tanggal || tanggal == ''){
					edtpodxxth.field('podxxth.tanggal').error( 'Wajib diisi!' );
				}
				// END of validasi podxxth.tanggal
				
				validasiDiskon(edtpodxxth, 'podxxth');
			}
			
			if ( edtpodxxth.inError() ) {
				return false;
			}
		});

		edtpodxxth.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtpodxxth.field('podxxth.finish_at').val(finish_at);
		});
		
		edtpodxxth.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edtpodxxth.on( 'close', function () {
			edtpodxxth.enable();
		} );
		
		//start datatables
		tblpodxxth = $('#tblpodxxth').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/podxxth/podxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_podxxth = show_deleted_podxxth;
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
					targets: [0]
				}
			],
			columns: [
				{ data: "podxxth.id",visible:false },
				{ data: "podxxth.tanggal" },
				{ data: "podxxth.kode" },
				{ data: "iittpmh.nama" },
				{ 
					data: "podxxth.dpp",
					render: $.fn.dataTable.render.number( ',', '.', 0,'','' ),
					class: "text-right" 
				},
				{ 
					data: "podxxth.transaction_state" ,
					render: $.fn.dataTable.render.transactionStatus()
				},
				{ 
					data: "podxxth.approval_state" ,
					render: $.fn.dataTable.render.approvalStatus()
				}
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_podxxth';
					$table       = 'tblpodxxth';
					$edt         = 'edtpodxxth';
					$show_status = '_podxxth';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= ['sp', 'sb'];
					$arr_buttons_action 	= ['create', 'edit', 'remove_hd', 'confirm', 'nonaktif_hd', 'close', 'view', 'log','noaction'];
					$arr_buttons_approve 	= ['approve', 'cancel_approve', 'void','noapprove'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
				// END breaking generate button
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
				if ( data.podxxth.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.podxxth.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblpodxxth.searchPanes.container().appendTo('#sppodxxth');
			tblpodxxth.searchBuilder.container().appendTo( '#sbpodxxth' );
		
		tblpodxxth.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblpodittd];
			CekInitHeaderHD(tblpodxxth, tbl_details);
		} );
		
		tblpodxxth.on( 'select', function( e, dt, type, indexes ) {
			podxxth_data    		= tblpodxxth.row( { selected: true } ).data().podxxth;
			id_podxxth      		= podxxth_data.id;
			id_transaksi_h 		= id_podxxth; // dipakai untuk general
			id_transaksi_log	= id_podxxth; // dipakai untuk general
			transaction_state   = podxxth_data.transaction_state;
			approval_state   	= podxxth_data.approval_state;
			is_nextprocess 		= podxxth_data.is_nextprocess;
			is_jurnal      		= podxxth_data.is_jurnal;
			id_iittpmh_old		= podxxth_data.id_iittpmh;
			id_iittpmh			= podxxth_data.id_iittpmh;
			id_fcrxxmh_old		= podxxth_data.id_fcrxxmh;
			id_fpytmmh_old		= podxxth_data.id_fpytmmh;
			id_psuxxmh_old		= podxxth_data.id_psuxxmh;
			
			// atur hak akses
			tbl_details = [tblpodittd];
			CekSelectHeaderHD(tblpodxxth, tbl_details);

		} );
		
		tblpodxxth.on( 'deselect', function () {
			// reload dipanggil di function CekDeselectHeader
			id_podxxth = 0;
			id_psuxxmh_old = 0;
			id_fpytmmh_old = 0;
			id_fcrxxmh_old = 0;
			id_iittpmh_old = 0;

			// atur hak akses
			tbl_details = [tblpodittd];
			CekDeselectHeaderHD(tblpodxxth, tbl_details);
		} );
		
// --------- start _detail --------------- //

		//start datatables editor
		edtpodittd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/podxxth/podittd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_podittd = show_deleted_podittd;
					d.id_podxxth = id_podxxth;
				}
			},
			template: "#custom_podittd",
			table: "#tblpodittd",
			formOptions: {
				main: {
					focus: 5,
					onBackground: 'none'
				}
			},
			fields: [ 
				{
					label: "podittd.start_at",
					name: "podittd.start_at",
					type: "hidden"
				},	
				{
					label: "podittd.finish_at",
					name: "podittd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "podittd",
					type: "hidden"
				},	
				{
					label: "podittd.transaction_state",
					name: "podittd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_podxxth",
					name: "podittd.id_podxxth",
					type: "hidden"
				},	
				{
					label: "Item PR<sup class='text-danger'>*<sup>",
					name: "podittd.id_prqittd",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/prqxxth/prqittd_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_prqittd_old: id_prqittd_old,
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
					label: "Item <sup class='text-danger'>*<sup>",
					name: "podittd.id_iimxxmh",
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
									ids_iittpmh: id_iittpmh,
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
					label: "UoM <sup class='text-danger'>*<sup>",
					name: "podittd.id_iumxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/iumxxmh/iumxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_iumxxmh_old: id_iumxxmh_old,
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
					label: "Quantity <sup class='text-danger'>*<sup>",
					name: "podittd.jumlah_unit"
				}, 	
				{
					label: "Price <sup class='text-danger'>*<sup>",
					name: "podittd.harga_unit"
				},
				{
					label: "Subtotal",
					name: "podittd.subtotal",
					type: "readonly"
				},
				{
					label: "Diskon",
					name: "podittd.is_diskon_persen",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": "-", "value": 0 },
						{ "label": "Percent", "value": 1 },
						{ "label": "Value", "value": 2 }
					]
				},
				{
					label: "Diskon (%)",
					name: "podittd.diskon_persen"
				}, 	{
					label: "Diskon (Rp)",
					name: "podittd.diskon_value"
				}, 	{
					label: "Diskon Final",
					name: "podittd.diskon_final",
					type: "readonly"
				},
				{
					label: "Total",
					name: "podittd.dpp",
					type: "readonly"
				},
				{
					label: "Tanggal Dibutuhkan",
					name: "podittd.tanggal",
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
					label: "Keterangan",
					name: "podittd.keterangan",
					type: "textarea"
				}
			]
		} );
			
		edtpodittd.on( 'preOpen', function( e, mode, action ) {
			edtpodittd.field('podittd.id_podxxth').val(id_podxxth);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtpodittd.field('podittd.start_at').val(start_at);
			
			if(action == 'create'){
				tblpodittd.rows().deselect();
			}
		});

		edtpodittd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-xl");
		});
		
		edtpodittd.dependent( 'podittd.harga_unit', function ( val, data, callback ) {
			if (val != null) {
				totalDetail(edtpodittd, 'podittd');
			}
			return {}
		}, {event: 'keyup change'});
		
		edtpodittd.dependent( 'podittd.jumlah_unit', function ( val, data, callback ) {
			if (val != null) {
				totalDetail(edtpodittd, 'podittd');
			}
			return {}
		}, {event: 'keyup change'});
		
		edtpodittd.dependent( 'podittd.is_diskon_persen', function ( val, data, callback ) {
			if (val == 1) {
				edtpodittd.field('podittd.diskon_persen').show();
				edtpodittd.field('podittd.diskon_value').hide();
				
				edtpodittd.field('podittd.diskon_persen').val();
				edtpodittd.field('podittd.diskon_value').val('');
			} else if (val == 2) {
				edtpodittd.field('podittd.diskon_persen').hide();
				edtpodittd.field('podittd.diskon_value').show();
				
				edtpodittd.field('podittd.diskon_persen').val('');
				edtpodittd.field('podittd.diskon_value').val();
			} else {
				edtpodittd.field('podittd.diskon_persen').hide();
				edtpodittd.field('podittd.diskon_value').hide();
				edtpodittd.field('podittd.diskon_persen').val(0);
				edtpodittd.field('podittd.diskon_value').val(0);
				edtpodittd.field('podittd.diskon_final').val(0);
			}
			return {}
		}, {event: 'keyup change'});
		
		edtpodittd.dependent( 'podittd.diskon_persen', function ( val, data, callback ) {
			if (val != null) {
				hitungDiskon(edtpodittd, 'podittd');
			}
			return {}
		}, {event: 'keyup change'});
		
		edtpodittd.dependent( 'podittd.diskon_value', function ( val, data, callback ) {
			if (val != null) {
				hitungDiskon(edtpodittd, 'podittd');
			}
			return {}
		}, {event: 'keyup change'});

		edtpodittd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				id_prqittd = edtpodittd.field('podittd.id_prqittd').val();
				if(!id_prqittd || id_prqittd == ''){
					edtpodittd.field('podittd.id_prqittd').error( 'Wajib diisi!' );
				}
				
				id_iumxxmh = edtpodittd.field('podittd.id_iumxxmh').val();
				if(!id_iumxxmh || id_iumxxmh == ''){
					edtpodittd.field('podittd.id_iumxxmh').error( 'Wajib diisi!' );
				}
				
				id_iimxxmh = edtpodittd.field('podittd.id_iimxxmh').val();
				if(!id_iimxxmh || id_iimxxmh == ''){
					edtpodittd.field('podittd.id_iimxxmh').error( 'Wajib diisi!' );
				}
				
				jumlah_unit = edtpodittd.field('podittd.jumlah_unit').val();
				if(!jumlah_unit || jumlah_unit == ''){
					edtpodittd.field('podittd.jumlah_unit').error( 'Wajib diisi!' );
				}

				// validasi min atau max angka
				if(jumlah_unit <= 0 ){
					edtpodittd.field('podittd.jumlah_unit').error( 'Inputan harus > 0' );
				}
				
				// validasi angka
				if(isNaN(jumlah_unit) ){
					edtpodittd.field('podittd.jumlah_unit').error( 'Inputan harus berupa Angka!' );
				}

				harga_unit = edtpodittd.field('podittd.harga_unit').val();
				if(!harga_unit || harga_unit == ''){
					edtpodittd.field('podittd.harga_unit').error( 'Wajib diisi!' );
				}

				// validasi min atau max angka
				if(harga_unit <= 0 ){
					edtpodittd.field('podittd.harga_unit').error( 'Inputan harus > 0' );
				}
				
				// validasi angka
				if(isNaN(harga_unit) ){
					edtpodittd.field('podittd.harga_unit').error( 'Inputan harus berupa Angka!' );
				}
				validasiDiskon(edtpodittd, 'podittd');

			}
			
			if ( edtpodittd.inError() ) {
				return false;
			}
		});

		edtpodittd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtpodittd.field('podittd.finish_at').val(finish_at);
		});
			
		edtpodittd.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
			
			if (action != 'remove') {
				id_last_insert = json.data[0].podittd.id;
				console.log(id_last_insert);

				// Memangging funtion Konversi Terkecil, isi paremeter last insert dan table detail/table yang dipilih
				konversiTerkecil('podittd', id_last_insert);
				tblpodittd.rows().deselect();
				
			}
			//Memangging function totalHeader, isi parameter sesuai urutan:
			// Urutan Parameter = id_header, nama tabel detail, nama tabel Header,
			// Parameter Terakhir isi 1 jika ingin kalkulasi diskon, kosongkan jika tidak ingin kalkulasi diskon
			totalHeader(id_transaksi_h, 'podittd', 'podxxth', 1);


			// tblpodxxth.rows().deselect();
			tblpodxxth.ajax.reload(null, false);
			tblpodittd.ajax.reload(null, false);
		} );

		edtpodittd.on( 'close', function () {
			edtpodittd.enable();
		} );
		
		//start datatables
		tblpodittd = $('#tblpodittd').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/podxxth/podittd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_podittd = show_deleted_podittd;
					d.id_podxxth = id_podxxth;
				}
			},
			order: [[ 2, "desc" ]],
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
					targets: [0,4]
				}
			],
			responsive: false,
			scrollX: true,
			columns: [
				{ data: "podittd.id",visible:false },
				{ data: "podittd.id_podxxth",visible:false },
				{ data: "pr" },
				{ data: "iimxxmh.nama" },
				{ data: "iumxxmh.nama" },
				{ 
					data: "podittd.jumlah_unit",
					render: $.fn.dataTable.render.number( ',', '.', 0,'','' ),
					class: "text-right"
				},
				{ 
					data: "podittd.harga_unit",
					render: $.fn.dataTable.render.number( ',', '.', 0,'','' ),
					class: "text-right"
				},
				{ 
					data: "podittd.subtotal",
					render: $.fn.dataTable.render.number( ',', '.', 0,'','' ),
					class: "text-right"
				},
				{ 
					data: "podittd.diskon_final",
					render: $.fn.dataTable.render.number( ',', '.', 0,'','' ),
					class: "text-right"
				},
				{ 
					data: "podittd.dpp",
					render: $.fn.dataTable.render.number( ',', '.', 0,'','' ),
					class: "text-right"
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_podittd';
					$table       = 'tblpodittd';
					$edt         = 'edtpodittd';
					$show_status = '_podittd';
					$table_name  = $nama_tabels_d[0];

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_action 	= ['create', 'edit', 'remove','view', 'log','noactionD'];
					$arr_buttons_approve 	= ['noapprove'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php';
				?>
				// END breaking generate button
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
			},
			footerCallback: function ( row, data, start, end, display ) {
				var api = this.api();
				var numFormat = $.fn.dataTable.render.number( '\,', '.', 2, '' ).display; 

				for (var i = 7; i <= 9; i++) {
					var columnIndex = i;
					var sum_all = api.column(columnIndex).data().sum();
					// Bisa dilakukan sum berdasarkan paginasi (sum per paginasi / tidak sum semua data) dengan menambahkan { page: 'current' }
					var sum = api.column(columnIndex, { page: 'current' }).data().sum();
					$('#sum' + columnIndex).html(numFormat(sum_all));

					// console.log('Number of Pages: ' + api.page.info().pages);
				}
			}
		} );

		tblpodittd.searchPanes.container().appendTo('#sppodittd');
		tblpodittd.searchBuilder.container().appendTo( '#sbpodittd' );

		tblpodittd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			cek_c_detail= 1;
			CekDrawDetailHD(tblpodxxth, tblpodittd, 'podittd' );
			CekDrawDetailHDFinal(tblpodxxth);
		} );

		tblpodittd.on( 'select', function( e, dt, type, indexes ) {
			data_podittd 		= tblpodittd.row( { selected: true } ).data().podittd;
			id_podittd   		= data_podittd.id;
			id_transaksi_d 		= id_podittd; // dipakai untuk general
			id_transaksi_log 	= id_podittd; // dipakai untuk log

			transaction_state_d   = data_podittd.transaction_state;
			id_iimxxmh_old   = data_podittd.id_iimxxmh;
			id_iumxxmh_old   = data_podittd.id_iumxxmh;
			id_prqittd_old   = data_podittd.id_prqittd;
			
			// atur hak akses
			CekSelectDetailHD(tblpodxxth, tblpodittd );
		} );

		tblpodittd.on( 'deselect', function() {
			id_podittd = 0;
			is_active_d = 0;
			id_iimxxmh_old = 0;
			id_prqittd_old = 0;
			id_iumxxmh_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD(tblpodxxth, tblpodittd );
		} );

// --------- end _detail --------------- //		
	} );// end of document.ready
	
</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
