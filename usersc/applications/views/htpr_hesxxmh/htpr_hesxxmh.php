<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'hesxxmh';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'htpr_hesxxmh';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblhesxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
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
				<li><a class="nav-link active" data-toggle="tab" href="#tabhtpr_hesxxmh_1"> Komponen</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabhtpr_hesxxmh_1" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblhtpr_hesxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_hesxxmh</th>
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
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/htpr_hesxxmh/fn/htpr_hesxxmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edthesxxmh, tblhesxxmh, show_deleted_hesxxmh = 0, id_hesxxmh;
	var edthtpr_hesxxmh, tblhtpr_hesxxmh, show_deleted_htpr_hesxxmh = 0, id_htpr_hesxxmh;
	// ------------- end of default variable
	
	// get tableRelation
	tableRelation('htpr_hesxxmh');

	var id_gctxxmh_old = 0, id_gbuxxmh_old = 0, id_gpvxxmh_old = 0, id_fpytmmh_old = 0;
	var id_hpcxxmh_old = 0;

	$(document).ready(function() {
		// BEGIN hesxxmh

		tblhesxxmh = $('#tblhesxxmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-2',
			},
			ajax: {
				url: "../../models/htpr_hesxxmh/htpr_hesxxmh_h.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hesxxmh = show_deleted_hesxxmh;
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
				{ data: "hesxxmh.id",visible:false },
				{ data: "hesxxmh.kode" },
				{ data: "hesxxmh.nama" }
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hesxxmh';
					$table       = 'tblhesxxmh';
					$edt         = 'edthesxxmh';
					$show_status = '_hesxxmh';
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
				if ( data.hesxxmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.hesxxmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblhesxxmh.searchPanes.container().appendTo('#sphesxxmh');
		tblhesxxmh.searchBuilder.container().appendTo( '#sbhesxxmh' );
		
		tblhesxxmh.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblhtpr_hesxxmh];
			CekInitHeaderHD(tblhesxxmh, tbl_details);
		} );
		
		tblhesxxmh.on( 'select', function( e, dt, type, indexes ) {
			siVarSet('hesxxmh');
			id_gpvxxmh_old      		= hesxxmh_data.id_gpvxxmh;
			id_gbuxxmh_old      		= hesxxmh_data.id_gbuxxmh;
			id_gctxxmh_old      		= hesxxmh_data.id_gctxxmh;
			id_fpytmmh_old      = hesxxmh_data.id_fpytmmh;
			
			// atur hak akses
			tbl_details = [tblhtpr_hesxxmh];
			CekSelectHeaderHD(tblhesxxmh, tbl_details);

		} );
		
		tblhesxxmh.on( 'deselect', function () {
			siVarReset('hesxxmh');
			id_gctxxmh_old = 0, id_gbuxxmh_old = 0, id_gpvxxmh_old = 0, id_fpytmmh_old = 0
			// atur hak akses
			tbl_details = [tblhtpr_hesxxmh];
			CekDeselectHeaderHD(tblhesxxmh, tbl_details);
		} );
		// END hesxxmh

		// BEGIN htpr_hesxxmh
		edthtpr_hesxxmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/htpr_hesxxmh/htpr_hesxxmh_d.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_htpr_hesxxmh = show_deleted_htpr_hesxxmh;
					d.id_hesxxmh = id_hesxxmh;
				}
			},
			table: "#tblhtpr_hesxxmh",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "htpr_hesxxmh.start_at",
					name: "htpr_hesxxmh.start_at",
					type: "hidden"
				},	
				{
					label: "htpr_hesxxmh.finish_at",
					name: "htpr_hesxxmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "htpr_hesxxmh",
					type: "hidden"
				},	
				{
					label: "htpr_hesxxmh.transaction_state",
					name: "htpr_hesxxmh.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_hesxxmh",
					name: "htpr_hesxxmh.id_hesxxmh",
					type: "hidden"
				},	
				{
					label: "Komponen <sup class='text-danger'>*<sup>",
					name: "htpr_hesxxmh.id_hpcxxmh",
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
					name: "htpr_hesxxmh.nominal"
				},
				{
					label: "Tanggal Efektif <sup class='text-danger'>*<sup>",
					name: "htpr_hesxxmh.tanggal_efektif",
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
					name: "htpr_hesxxmh.keterangan",
					type: "textarea"
				}
			]
		} );
			
		edthtpr_hesxxmh.on( 'preOpen', function( e, mode, action ) {
			edthtpr_hesxxmh.field('htpr_hesxxmh.id_hesxxmh').val(id_hesxxmh);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthtpr_hesxxmh.field('htpr_hesxxmh.start_at').val(start_at);
			
			if(action == 'create'){
				tblhtpr_hesxxmh.rows().deselect();
			}
		});

		edthtpr_hesxxmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});
		
		edthtpr_hesxxmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				// BEGIN of validasi htpr_hesxxmh.id_hpcxxmh 
				id_hpcxxmh = edthtpr_hesxxmh.field('htpr_hesxxmh.id_hpcxxmh').val();
				if(!id_hpcxxmh || id_hpcxxmh == ''){
					edthtpr_hesxxmh.field('htpr_hesxxmh.id_hpcxxmh').error( 'Wajib diisi!' );
				}
				// END of validasi htpr_hesxxmh.id_hpcxxmh 

				// BEGIN of validasi htpr_hesxxmh.nominal 
				nominal = edthtpr_hesxxmh.field('htpr_hesxxmh.nominal').val();
				if(!nominal || nominal == ''){
					edthtpr_hesxxmh.field('htpr_hesxxmh.nominal').error( 'Wajib diisi!' );
				}
				if(nominal <= 0 ){
					edthtpr_hesxxmh.field('htpr_hesxxmh.nominal').error( 'Inputan harus > 0' );
				}
				if(isNaN(nominal) ){
					edthtpr_hesxxmh.field('htpr_hesxxmh.nominal').error( 'Inputan harus berupa Angka!' );
				}
				// END of validasi htpr_hesxxmh.nominal 

				// BEGIN of validasi htpr_hesxxmh.tanggal_efektif 
				tanggal_efektif = edthtpr_hesxxmh.field('htpr_hesxxmh.tanggal_efektif').val();
				if(!tanggal_efektif || tanggal_efektif == ''){
					edthtpr_hesxxmh.field('htpr_hesxxmh.tanggal_efektif').error( 'Wajib diisi!' );
				}
				// END of validasi htpr_hesxxmh.tanggal_efektif
			}
			
			if ( edthtpr_hesxxmh.inError() ) {
				return false;
			}
		});

		edthtpr_hesxxmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthtpr_hesxxmh.field('htpr_hesxxmh.finish_at').val(finish_at);
		});
			
		edthtpr_hesxxmh.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edthtpr_hesxxmh.on( 'close', function () {
			edthtpr_hesxxmh.enable();
		} );
		
		tblhtpr_hesxxmh = $('#tblhtpr_hesxxmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/htpr_hesxxmh/htpr_hesxxmh_d.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_htpr_hesxxmh = show_deleted_htpr_hesxxmh;
					d.id_hesxxmh = id_hesxxmh;
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
				{ data: "htpr_hesxxmh.id",visible:false },
				{ data: "htpr_hesxxmh.id_hesxxmh",visible:false },
				{ data: "htpr_hesxxmh.tanggal_efektif" },
				{ data: "hpcxxmh.nama" },
				{ 
					data: "htpr_hesxxmh.nominal" ,
					render: $.fn.dataTable.render.number( ',', '.', 0,'','' ),
					class: "text-right"
				},
				{ data: "htpr_hesxxmh.keterangan" }
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_htpr_hesxxmh';
					$table       = 'tblhtpr_hesxxmh';
					$edt         = 'edthtpr_hesxxmh';
					$show_status = '_htpr_hesxxmh';
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

		tblhtpr_hesxxmh.searchPanes.container().appendTo('#sphtpr_hesxxmh');
		tblhtpr_hesxxmh.searchBuilder.container().appendTo( '#sbhtpr_hesxxmh' );

		tblhtpr_hesxxmh.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tblhtpr_hesxxmh, 1 );
			CekDrawDetailHDFinal(tblhesxxmh);
		} );

		tblhtpr_hesxxmh.on( 'select', function( e, dt, type, indexes ) {
			siVarSetD('htpr_hesxxmh');
			id_hpcxxmh_old      = htpr_hesxxmh_data.id_hpcxxmh;
			
			// atur hak akses
			CekSelectDetailHD( tblhtpr_hesxxmh );
		} );

		tblhtpr_hesxxmh.on( 'deselect', function() {
			siVarResetD('htpr_hesxxmh');
			id_hpcxxmh_old = 0;
			id_gpvxxmh_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD( tblhtpr_hesxxmh );
		} );

// --------- end _detail --------------- //		
	} );// end of document.ready
	
</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
