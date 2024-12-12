<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'hevxxmh';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'htpr_hevxxmh';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblhevxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Kode</th>
                                <th>Nama</th>
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
				<li><a class="nav-link active" data-toggle="tab" href="#tabhtpr_hevxxmh_1"> Komponen</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabhtpr_hevxxmh_1" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblhtpr_hevxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_hevxxmh</th>
										<th>Tanggal Efektif</th>
										<th>Komponen</th>
										<th>Nominal</th>
										<th>Keterangan</th>
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
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_toast.php';
?>

<!-- BEGIN JS -->
<?php 
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_load.php';
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_setup.php';
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_datatables_load.php'; 
?>

<script src="<?=$us_url_root?>usersc/helpers/general_fn.js"></script>
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn2.js"></script>
<script src="<?=$us_url_root?>usersc/helpers/language.js"></script>
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/hevxxmh/fn/hevxxmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edthevxxmh, tblhevxxmh, show_deleted_hevxxmh = 0, id_hevxxmh;
	var edthtpr_hevxxmh, tblhtpr_hevxxmh, show_deleted_htpr_hevxxmh = 0, id_htpr_hevxxmh;
	// ------------- end of default variable
	
	// get tableRelation
	tableRelation('htpr_hevxxmh');

	var id_gctxxmh_old = 0, id_gbuxxmh_old = 0, id_gpvxxmh_old = 0, id_fpytmmh_old = 0;
	var id_hpcxxmh_old = 0;

	$(document).ready(function() {
		// BEGIN hevxxmh

		tblhevxxmh = $('#tblhevxxmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-2',
			},
			ajax: {
				url: "../../models/htpr_hevxxmh/htpr_hevxxmh_h.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hevxxmh = show_deleted_hevxxmh;
				}
			},
			order: [[ 1, "desc" ]],
			columnDefs:[
				{
					searchPanes:{
						show: true,
					},
					targets: [1,2]
				},
				{
					searchPanes:{
						show: false,
					},
					targets: [0]
				}
			],
			responsive: false,
			scrollX: true,
			columns: [
				{ data: "hevxxmh.id",visible:false },
				{ data: "hevxxmh.kode" },
				{ data: "hevxxmh.nama" }
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hevxxmh';
					$table       = 'tblhevxxmh';
					$edt         = 'edthevxxmh';
					$show_status = '_hevxxmh';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= ['sp', 'sb'];
					$arr_buttons_action 	= [];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
				// END breaking generate button
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
				if ( data.hevxxmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.hevxxmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblhevxxmh.searchPanes.container().appendTo('#sphevxxmh');
		tblhevxxmh.searchBuilder.container().appendTo( '#sbhevxxmh' );
		
		tblhevxxmh.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblhtpr_hevxxmh];
			CekInitHeaderHD(tblhevxxmh, tbl_details);
		} );
		
		tblhevxxmh.on( 'select', function( e, dt, type, indexes ) {
			siVarSet('hevxxmh');
			id_gpvxxmh_old      		= hevxxmh_data.id_gpvxxmh;
			id_gbuxxmh_old      		= hevxxmh_data.id_gbuxxmh;
			id_gctxxmh_old      		= hevxxmh_data.id_gctxxmh;
			id_fpytmmh_old      = hevxxmh_data.id_fpytmmh;
			
			// atur hak akses
			tbl_details = [tblhtpr_hevxxmh];
			CekSelectHeaderHD(tblhevxxmh, tbl_details);

		} );
		
		tblhevxxmh.on( 'deselect', function () {
			siVarReset('hevxxmh');
			id_gctxxmh_old = 0, id_gbuxxmh_old = 0, id_gpvxxmh_old = 0, id_fpytmmh_old = 0
			// atur hak akses
			tbl_details = [tblhtpr_hevxxmh];
			CekDeselectHeaderHD(tblhevxxmh, tbl_details);
		} );
		// END hevxxmh

		// BEGIN htpr_hevxxmh
		edthtpr_hevxxmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/htpr_hevxxmh/htpr_hevxxmh_d.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_htpr_hevxxmh = show_deleted_htpr_hevxxmh;
					d.id_hevxxmh = id_hevxxmh;
				}
			},
			table: "#tblhtpr_hevxxmh",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "htpr_hevxxmh.start_at",
					name: "htpr_hevxxmh.start_at",
					type: "hidden"
				},	
				{
					label: "htpr_hevxxmh.finish_at",
					name: "htpr_hevxxmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "htpr_hevxxmh",
					type: "hidden"
				},	
				{
					label: "htpr_hevxxmh.transaction_state",
					name: "htpr_hevxxmh.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_hevxxmh",
					name: "htpr_hevxxmh.id_hevxxmh",
					type: "hidden"
				},	
				{
					label: "Komponen <sup class='text-danger'>*<sup>",
					name: "htpr_hevxxmh.id_hpcxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/hpcxxmh/hpcxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_hpcxxmh_old: id_hpcxxmh_old,
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
					label: "Nominal <sup class='text-danger'>*<sup>",
					name: "htpr_hevxxmh.nominal"
				},
				{
					label: "Tanggal Efektif <sup class='text-danger'>*<sup>",
					name: "htpr_hevxxmh.tanggal_efektif",
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
					name: "htpr_hevxxmh.keterangan",
					type: "textarea"
				}
			]
		} );
			
		edthtpr_hevxxmh.on( 'preOpen', function( e, mode, action ) {
			edthtpr_hevxxmh.field('htpr_hevxxmh.id_hevxxmh').val(id_hevxxmh);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthtpr_hevxxmh.field('htpr_hevxxmh.start_at').val(start_at);
			
			if(action == 'create'){
				tblhtpr_hevxxmh.rows().deselect();
			}
		});

		edthtpr_hevxxmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});
		
		edthtpr_hevxxmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				// BEGIN of validasi htpr_hevxxmh.id_hpcxxmh 
				id_hpcxxmh = edthtpr_hevxxmh.field('htpr_hevxxmh.id_hpcxxmh').val();
				if(!id_hpcxxmh || id_hpcxxmh == ''){
					edthtpr_hevxxmh.field('htpr_hevxxmh.id_hpcxxmh').error( 'Wajib diisi!' );
				}
				// END of validasi htpr_hevxxmh.id_hpcxxmh 

				// BEGIN of validasi htpr_hevxxmh.nominal 
				nominal = edthtpr_hevxxmh.field('htpr_hevxxmh.nominal').val();
				if(!nominal || nominal == ''){
					edthtpr_hevxxmh.field('htpr_hevxxmh.nominal').error( 'Wajib diisi!' );
				}
				if(nominal <= 0 ){
					edthtpr_hevxxmh.field('htpr_hevxxmh.nominal').error( 'Inputan harus > 0' );
				}
				if(isNaN(nominal) ){
					edthtpr_hevxxmh.field('htpr_hevxxmh.nominal').error( 'Inputan harus berupa Angka!' );
				}
				// END of validasi htpr_hevxxmh.nominal 

				// BEGIN of validasi htpr_hevxxmh.tanggal_efektif 
				tanggal_efektif = edthtpr_hevxxmh.field('htpr_hevxxmh.tanggal_efektif').val();
				if(!tanggal_efektif || tanggal_efektif == ''){
					edthtpr_hevxxmh.field('htpr_hevxxmh.tanggal_efektif').error( 'Wajib diisi!' );
				}
				// END of validasi htpr_hevxxmh.tanggal_efektif
			}
			
			if ( edthtpr_hevxxmh.inError() ) {
				return false;
			}
		});

		edthtpr_hevxxmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthtpr_hevxxmh.field('htpr_hevxxmh.finish_at').val(finish_at);
		});
			
		edthtpr_hevxxmh.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edthtpr_hevxxmh.on( 'close', function () {
			edthtpr_hevxxmh.enable();
		} );
		
		tblhtpr_hevxxmh = $('#tblhtpr_hevxxmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/htpr_hevxxmh/htpr_hevxxmh_d.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_htpr_hevxxmh = show_deleted_htpr_hevxxmh;
					d.id_hevxxmh = id_hevxxmh;
				}
			},
			order: [[ 2, "desc" ]],
			columnDefs:[
				{
					searchPanes:{
						show: true,
					},
					targets: [2,3,4,5]
				},
				{
					searchPanes:{
						show: false,
					},
					targets: [0,1]
				}
			],
			columns: [
				{ data: "htpr_hevxxmh.id",visible:false },
				{ data: "htpr_hevxxmh.id_hevxxmh",visible:false },
				{ data: "htpr_hevxxmh.tanggal_efektif" },
				{ data: "hpcxxmh.nama" },
				{ 
					data: "htpr_hevxxmh.nominal" ,
					render: $.fn.dataTable.render.number( ',', '.', 0,'','' ),
					class: "text-right"
				},
				{ data: "htpr_hevxxmh.keterangan" }
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_htpr_hevxxmh';
					$table       = 'tblhtpr_hevxxmh';
					$edt         = 'edthtpr_hevxxmh';
					$show_status = '_htpr_hevxxmh';
					$table_name  = $nama_tabels_d[0];

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
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

		tblhtpr_hevxxmh.searchPanes.container().appendTo('#sphtpr_hevxxmh');
		tblhtpr_hevxxmh.searchBuilder.container().appendTo( '#sbhtpr_hevxxmh' );

		tblhtpr_hevxxmh.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tblhtpr_hevxxmh, 1 );
			CekDrawDetailHDFinal(tblhevxxmh);
		} );

		tblhtpr_hevxxmh.on( 'select', function( e, dt, type, indexes ) {
			siVarSetD('htpr_hevxxmh');
			id_hpcxxmh_old      = htpr_hevxxmh_data.id_hpcxxmh;
			
			// atur hak akses
			CekSelectDetailHD( tblhtpr_hevxxmh );
		} );

		tblhtpr_hevxxmh.on( 'deselect', function() {
			siVarResetD('htpr_hevxxmh');
			id_hpcxxmh_old = 0;
			id_gpvxxmh_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD( tblhtpr_hevxxmh );
		} );

// --------- end _detail --------------- //		
	} );// end of document.ready
	
</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
