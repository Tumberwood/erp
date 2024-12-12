<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'hetxxmh';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'htpr_hetxxmh';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblhetxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
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
				<li><a class="nav-link active" data-toggle="tab" href="#tabhtpr_hetxxmh_1"> Komponen</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabhtpr_hetxxmh_1" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblhtpr_hetxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_hetxxmh</th>
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
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/hetxxmh/fn/hetxxmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edthetxxmh, tblhetxxmh, show_deleted_hetxxmh = 0, id_hetxxmh;
	var edthtpr_hetxxmh, tblhtpr_hetxxmh, show_deleted_htpr_hetxxmh = 0, id_htpr_hetxxmh;
	// ------------- end of default variable
	
	// get tableRelation
	tableRelation('htpr_hetxxmh');

	var id_gctxxmh_old = 0, id_gbuxxmh_old = 0, id_gpvxxmh_old = 0, id_fpytmmh_old = 0;
	var id_hpcxxmh_old = 0;

	$(document).ready(function() {
		// BEGIN hetxxmh

		tblhetxxmh = $('#tblhetxxmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-2',
			},
			ajax: {
				url: "../../models/htpr_hetxxmh/htpr_hetxxmh_h.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hetxxmh = show_deleted_hetxxmh;
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
				{ data: "hetxxmh.id",visible:false },
				{ data: "hetxxmh.kode" },
				{ data: "hetxxmh.nama" }
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hetxxmh';
					$table       = 'tblhetxxmh';
					$edt         = 'edthetxxmh';
					$show_status = '_hetxxmh';
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
				if ( data.hetxxmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.hetxxmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblhetxxmh.searchPanes.container().appendTo('#sphetxxmh');
		tblhetxxmh.searchBuilder.container().appendTo( '#sbhetxxmh' );
		
		tblhetxxmh.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblhtpr_hetxxmh];
			CekInitHeaderHD(tblhetxxmh, tbl_details);
		} );
		
		tblhetxxmh.on( 'select', function( e, dt, type, indexes ) {
			siVarSet('hetxxmh');
			id_gpvxxmh_old      		= hetxxmh_data.id_gpvxxmh;
			id_gbuxxmh_old      		= hetxxmh_data.id_gbuxxmh;
			id_gctxxmh_old      		= hetxxmh_data.id_gctxxmh;
			id_fpytmmh_old      = hetxxmh_data.id_fpytmmh;
			
			// atur hak akses
			tbl_details = [tblhtpr_hetxxmh];
			CekSelectHeaderHD(tblhetxxmh, tbl_details);

		} );
		
		tblhetxxmh.on( 'deselect', function () {
			siVarReset('hetxxmh');
			id_gctxxmh_old = 0, id_gbuxxmh_old = 0, id_gpvxxmh_old = 0, id_fpytmmh_old = 0
			// atur hak akses
			tbl_details = [tblhtpr_hetxxmh];
			CekDeselectHeaderHD(tblhetxxmh, tbl_details);
		} );
		// END hetxxmh

		// BEGIN htpr_hetxxmh
		edthtpr_hetxxmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/htpr_hetxxmh/htpr_hetxxmh_d.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_htpr_hetxxmh = show_deleted_htpr_hetxxmh;
					d.id_hetxxmh = id_hetxxmh;
				}
			},
			table: "#tblhtpr_hetxxmh",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "htpr_hetxxmh.start_at",
					name: "htpr_hetxxmh.start_at",
					type: "hidden"
				},	
				{
					label: "htpr_hetxxmh.finish_at",
					name: "htpr_hetxxmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "htpr_hetxxmh",
					type: "hidden"
				},	
				{
					label: "htpr_hetxxmh.transaction_state",
					name: "htpr_hetxxmh.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_hetxxmh",
					name: "htpr_hetxxmh.id_hetxxmh",
					type: "hidden"
				},	
				{
					label: "Komponen <sup class='text-danger'>*<sup>",
					name: "htpr_hetxxmh.id_hpcxxmh",
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
					name: "htpr_hetxxmh.nominal"
				},
				{
					label: "Tanggal Efektif <sup class='text-danger'>*<sup>",
					name: "htpr_hetxxmh.tanggal_efektif",
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
					name: "htpr_hetxxmh.keterangan",
					type: "textarea"
				}
			]
		} );
			
		edthtpr_hetxxmh.on( 'preOpen', function( e, mode, action ) {
			edthtpr_hetxxmh.field('htpr_hetxxmh.id_hetxxmh').val(id_hetxxmh);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthtpr_hetxxmh.field('htpr_hetxxmh.start_at').val(start_at);
			
			if(action == 'create'){
				tblhtpr_hetxxmh.rows().deselect();
			}
		});

		edthtpr_hetxxmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});
		
		edthtpr_hetxxmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				// BEGIN of validasi htpr_hetxxmh.id_hpcxxmh 
				id_hpcxxmh = edthtpr_hetxxmh.field('htpr_hetxxmh.id_hpcxxmh').val();
				if(!id_hpcxxmh || id_hpcxxmh == ''){
					edthtpr_hetxxmh.field('htpr_hetxxmh.id_hpcxxmh').error( 'Wajib diisi!' );
				}
				// END of validasi htpr_hetxxmh.id_hpcxxmh 

				// BEGIN of validasi htpr_hetxxmh.nominal 
				nominal = edthtpr_hetxxmh.field('htpr_hetxxmh.nominal').val();
				if(!nominal || nominal == ''){
					edthtpr_hetxxmh.field('htpr_hetxxmh.nominal').error( 'Wajib diisi!' );
				}
				if(nominal <= 0 ){
					edthtpr_hetxxmh.field('htpr_hetxxmh.nominal').error( 'Inputan harus > 0' );
				}
				if(isNaN(nominal) ){
					edthtpr_hetxxmh.field('htpr_hetxxmh.nominal').error( 'Inputan harus berupa Angka!' );
				}
				// END of validasi htpr_hetxxmh.nominal 

				// BEGIN of validasi htpr_hetxxmh.tanggal_efektif 
				tanggal_efektif = edthtpr_hetxxmh.field('htpr_hetxxmh.tanggal_efektif').val();
				if(!tanggal_efektif || tanggal_efektif == ''){
					edthtpr_hetxxmh.field('htpr_hetxxmh.tanggal_efektif').error( 'Wajib diisi!' );
				}
				// END of validasi htpr_hetxxmh.tanggal_efektif
			}
			
			if ( edthtpr_hetxxmh.inError() ) {
				return false;
			}
		});

		edthtpr_hetxxmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthtpr_hetxxmh.field('htpr_hetxxmh.finish_at').val(finish_at);
		});
			
		edthtpr_hetxxmh.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edthtpr_hetxxmh.on( 'close', function () {
			edthtpr_hetxxmh.enable();
		} );
		
		tblhtpr_hetxxmh = $('#tblhtpr_hetxxmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/htpr_hetxxmh/htpr_hetxxmh_d.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_htpr_hetxxmh = show_deleted_htpr_hetxxmh;
					d.id_hetxxmh = id_hetxxmh;
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
				{ data: "htpr_hetxxmh.id",visible:false },
				{ data: "htpr_hetxxmh.id_hetxxmh",visible:false },
				{ data: "htpr_hetxxmh.tanggal_efektif" },
				{ data: "hpcxxmh.nama" },
				{ 
					data: "htpr_hetxxmh.nominal" ,
					render: $.fn.dataTable.render.number( ',', '.', 0,'','' ),
					class: "text-right"
				},
				{ data: "htpr_hetxxmh.keterangan" }
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_htpr_hetxxmh';
					$table       = 'tblhtpr_hetxxmh';
					$edt         = 'edthtpr_hetxxmh';
					$show_status = '_htpr_hetxxmh';
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

		tblhtpr_hetxxmh.searchPanes.container().appendTo('#sphtpr_hetxxmh');
		tblhtpr_hetxxmh.searchBuilder.container().appendTo( '#sbhtpr_hetxxmh' );

		tblhtpr_hetxxmh.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tblhtpr_hetxxmh, 1 );
			CekDrawDetailHDFinal(tblhetxxmh);
		} );

		tblhtpr_hetxxmh.on( 'select', function( e, dt, type, indexes ) {
			siVarSetD('htpr_hetxxmh');
			id_hpcxxmh_old      = htpr_hetxxmh_data.id_hpcxxmh;
			
			// atur hak akses
			CekSelectDetailHD( tblhtpr_hetxxmh );
		} );

		tblhtpr_hetxxmh.on( 'deselect', function() {
			siVarResetD('htpr_hetxxmh');
			id_hpcxxmh_old = 0;
			id_gpvxxmh_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD( tblhtpr_hetxxmh );
		} );

// --------- end _detail --------------- //		
	} );// end of document.ready
	
</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
