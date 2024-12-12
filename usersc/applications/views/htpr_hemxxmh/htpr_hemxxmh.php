<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'hemxxmh';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'htpr_hemxxmh';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblhemxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Department</th>
                                <th>Level</th>
                                <th>Jabatan</th>
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
				<li><a class="nav-link active" data-toggle="tab" href="#tabhtpr_hemxxmh_1"> Komponen</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabhtpr_hemxxmh_1" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblhtpr_hemxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_hemxxmh</th>
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
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/hemxxmh/fn/hemxxmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edthemxxmh, tblhemxxmh, show_deleted_hemxxmh = 0, id_hemxxmh;
	var edthtpr_hemxxmh, tblhtpr_hemxxmh, show_deleted_htpr_hemxxmh = 0, id_htpr_hemxxmh;
	// ------------- end of default variable
	
	// get tableRelation
	tableRelation('htpr_hemxxmh');

	var id_gctxxmh_old = 0, id_gbuxxmh_old = 0, id_gpvxxmh_old = 0, id_fpytmmh_old = 0;
	var id_hpcxxmh_old = 0;

	$(document).ready(function() {
		// BEGIN hemxxmh

		tblhemxxmh = $('#tblhemxxmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/htpr_hemxxmh/htpr_hemxxmh_h.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hemxxmh = show_deleted_hemxxmh;
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
			responsive: false,
			scrollX: true,
			columns: [
				{ data: "hemxxmh.id",visible:false },
				{ data: "hemxxmh_data" },
				{ data: "hodxxmh.nama" },
				{ data: "hevxxmh.nama" },
				{ data: "hetxxmh.nama" }
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hemxxmh';
					$table       = 'tblhemxxmh';
					$edt         = 'edthemxxmh';
					$show_status = '_hemxxmh';
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
				if ( data.hemxxmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.hemxxmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblhemxxmh.searchPanes.container().appendTo('#sphemxxmh');
		tblhemxxmh.searchBuilder.container().appendTo( '#sbhemxxmh' );
		
		tblhemxxmh.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblhtpr_hemxxmh];
			CekInitHeaderHD(tblhemxxmh, tbl_details);
		} );
		
		tblhemxxmh.on( 'select', function( e, dt, type, indexes ) {
			siVarSet('hemxxmh');
			id_gpvxxmh_old      		= hemxxmh_data.id_gpvxxmh;
			id_gbuxxmh_old      		= hemxxmh_data.id_gbuxxmh;
			id_gctxxmh_old      		= hemxxmh_data.id_gctxxmh;
			id_fpytmmh_old      = hemxxmh_data.id_fpytmmh;

			uploadDetail(id_hemxxmh, 'htpr_hemxxmh', tblhtpr_hemxxmh, 'files/template_file_upload/Master Gaji Karyawan.xlsx')
			
			// atur hak akses
			tbl_details = [tblhtpr_hemxxmh];
			CekSelectHeaderHD(tblhemxxmh, tbl_details);

		} );
		
		tblhemxxmh.on( 'deselect', function () {
			siVarReset('hemxxmh');
			id_gctxxmh_old = 0, id_gbuxxmh_old = 0, id_gpvxxmh_old = 0, id_fpytmmh_old = 0
			// atur hak akses
			tbl_details = [tblhtpr_hemxxmh];
			CekDeselectHeaderHD(tblhemxxmh, tbl_details);

			uploadDetail(id_hemxxmh, 'htpr_hemxxmh', tblhtpr_hemxxmh, 'files/template_file_upload/Master Gaji Karyawan.xlsx')
		} );
		// END hemxxmh

		// BEGIN htpr_hemxxmh
		edthtpr_hemxxmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/htpr_hemxxmh/htpr_hemxxmh_d.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_htpr_hemxxmh = show_deleted_htpr_hemxxmh;
					d.id_hemxxmh = id_hemxxmh;
				}
			},
			table: "#tblhtpr_hemxxmh",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "htpr_hemxxmh.start_at",
					name: "htpr_hemxxmh.start_at",
					type: "hidden"
				},	
				{
					label: "htpr_hemxxmh.finish_at",
					name: "htpr_hemxxmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "htpr_hemxxmh",
					type: "hidden"
				},	
				{
					label: "htpr_hemxxmh.transaction_state",
					name: "htpr_hemxxmh.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_hemxxmh",
					name: "htpr_hemxxmh.id_hemxxmh",
					type: "hidden"
				},	
				{
					label: "Komponen <sup class='text-danger'>*<sup>",
					name: "htpr_hemxxmh.id_hpcxxmh",
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
					name: "htpr_hemxxmh.nominal"
				},
				{
					label: "Tanggal Efektif <sup class='text-danger'>*<sup>",
					name: "htpr_hemxxmh.tanggal_efektif",
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
					name: "htpr_hemxxmh.keterangan",
					type: "textarea"
				}
			]
		} );
			
		edthtpr_hemxxmh.on( 'preOpen', function( e, mode, action ) {
			edthtpr_hemxxmh.field('htpr_hemxxmh.id_hemxxmh').val(id_hemxxmh);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthtpr_hemxxmh.field('htpr_hemxxmh.start_at').val(start_at);
			
			if(action == 'create'){
				tblhtpr_hemxxmh.rows().deselect();
			}
		});

		edthtpr_hemxxmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});
		
		edthtpr_hemxxmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				// BEGIN of validasi htpr_hemxxmh.id_hpcxxmh 
				id_hpcxxmh = edthtpr_hemxxmh.field('htpr_hemxxmh.id_hpcxxmh').val();
				if(!id_hpcxxmh || id_hpcxxmh == ''){
					edthtpr_hemxxmh.field('htpr_hemxxmh.id_hpcxxmh').error( 'Wajib diisi!' );
				}
				// END of validasi htpr_hemxxmh.id_hpcxxmh 

				// BEGIN of validasi htpr_hemxxmh.nominal 
				nominal = edthtpr_hemxxmh.field('htpr_hemxxmh.nominal').val();
				if(!nominal || nominal == ''){
					edthtpr_hemxxmh.field('htpr_hemxxmh.nominal').error( 'Wajib diisi!' );
				}
				if(nominal <= 0 ){
					edthtpr_hemxxmh.field('htpr_hemxxmh.nominal').error( 'Inputan harus > 0' );
				}
				if(isNaN(nominal) ){
					edthtpr_hemxxmh.field('htpr_hemxxmh.nominal').error( 'Inputan harus berupa Angka!' );
				}
				// END of validasi htpr_hemxxmh.nominal 

				// BEGIN of validasi htpr_hemxxmh.tanggal_efektif 
				tanggal_efektif = edthtpr_hemxxmh.field('htpr_hemxxmh.tanggal_efektif').val();
				if(!tanggal_efektif || tanggal_efektif == ''){
					edthtpr_hemxxmh.field('htpr_hemxxmh.tanggal_efektif').error( 'Wajib diisi!' );
				}
				// END of validasi htpr_hemxxmh.tanggal_efektif
			}
			
			if ( edthtpr_hemxxmh.inError() ) {
				return false;
			}
		});

		edthtpr_hemxxmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthtpr_hemxxmh.field('htpr_hemxxmh.finish_at').val(finish_at);
		});
			
		edthtpr_hemxxmh.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edthtpr_hemxxmh.on( 'close', function () {
			edthtpr_hemxxmh.enable();
		} );
		
		tblhtpr_hemxxmh = $('#tblhtpr_hemxxmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/htpr_hemxxmh/htpr_hemxxmh_d.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_htpr_hemxxmh = show_deleted_htpr_hemxxmh;
					d.id_hemxxmh = id_hemxxmh;
				}
			},
			order: [[ 2, "desc" ]],
			columnDefs:[
				{
					searchPanes:{
						show: true,
					},
					targets: [2,3,,4,5]
				},
				{
					searchPanes:{
						show: false,
					},
					targets: [0,1]
				}
			],
			columns: [
				{ data: "htpr_hemxxmh.id",visible:false },
				{ data: "htpr_hemxxmh.id_hemxxmh",visible:false },
				{ data: "htpr_hemxxmh.tanggal_efektif" },
				{ data: "hpcxxmh.nama" },
				{ 
					data: "htpr_hemxxmh.nominal" ,
					render: $.fn.dataTable.render.number( ',', '.', 0,'','' ),
					class: "text-right"
				},
				{ data: "htpr_hemxxmh.keterangan" }
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_htpr_hemxxmh';
					$table       = 'tblhtpr_hemxxmh';
					$edt         = 'edthtpr_hemxxmh';
					$show_status = '_htpr_hemxxmh';
					$table_name  = $nama_tabels_d[0];

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis','upload'];
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

		tblhtpr_hemxxmh.searchPanes.container().appendTo('#sphtpr_hemxxmh');
		tblhtpr_hemxxmh.searchBuilder.container().appendTo( '#sbhtpr_hemxxmh' );

		tblhtpr_hemxxmh.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tblhtpr_hemxxmh, 1 );
			CekDrawDetailHDFinal(tblhemxxmh);
		} );

		tblhtpr_hemxxmh.on( 'select', function( e, dt, type, indexes ) {
			siVarSetD('htpr_hemxxmh');
			id_hpcxxmh_old      = htpr_hemxxmh_data.id_hpcxxmh;
			
			// atur hak akses
			CekSelectDetailHD( tblhtpr_hemxxmh );
		} );

		tblhtpr_hemxxmh.on( 'deselect', function() {
			siVarResetD('htpr_hemxxmh');
			id_hpcxxmh_old = 0;
			id_gpvxxmh_old = 0;
			
			// atur hak akses
			CekDeselectDetailHD( tblhtpr_hemxxmh );
		} );

// --------- end _detail --------------- //		
	} );// end of document.ready
	
</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
