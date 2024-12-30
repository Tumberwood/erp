<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'hprstmh';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'hprstmd';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">

				<div class="modal" id="modalSFhprstmh" tabindex="-1" role="dialog" aria-hidden="true">
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
                    <table id="tblhprstmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Kode</th>
                                <th>Keterangan</th>
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
				<li><a class="nav-link active" data-toggle="tab" href="#tabhprstmd_1"> Detail</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabhprstmd_1" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<div id="custom_detail">
								<div class="row">
									<div class="col-4">
										<editor-field name="hprstmd.kombinasi1"></editor-field>
									</div>
									<div class="col-4">
										<editor-field name="hprstmd.condition"></editor-field>
									</div>
									<div class="col-4">
										<editor-field name="hprstmd.kombinasi2"></editor-field>
									</div>
								</div>
							</div>
							<table id="tblhprstmd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_hprstmh</th>
										<th>Data</th>
										<th>Condition</th>
										<th>Value</th>
										<th>Keterangan</th>
									</tr>
								</thead>
							</table>
						</div> <!-- end of table -->

					</div>
				</div>
				<div role="tabpanel" id="tabhprstmd_2" class="tab-pane">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tblhprstmd_2" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>id_hprstmh</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/hprstmh/fn/hprstmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edthprstmh, tblhprstmh, show_deleted_hprstmh = 0, id_hprstmh;
	var edthprstmd, tblhprstmd, show_deleted_hprstmd = 0, id_hprstmd;
	// ------------- end of default variable

	// get tableRelation
	tableRelation('hprstmh');

	$(document).ready(function() {
		start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');

		// BEGIN hprstmh
		edthprstmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/hprstmh/hprstmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hprstmh = show_deleted_hprstmh;
					d.start_date = start_date;
					d.end_date = end_date;
				}
			},
			table: "#tblhprstmh",
			fields: [ 
				{
					label: "hprstmh.start_at",
					name: "hprstmh.start_at",
					type: "hidden"
				},	
				{
					label: "hprstmh.finish_at",
					name: "hprstmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "hprstmh",
					type: "hidden"
				},	
				{
					label: "hprstmh.transaction_state",
					name: "hprstmh.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: "Kode <sup class='text-danger'>*<sup>",
					name: "hprstmh.kode"
				}, 	
				{
					label: "Keterangan",
					name: "hprstmh.keterangan",
					type: "textarea"
				}
			]
		} );
		
		edthprstmh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthprstmh.field('hprstmh.start_at').val(start_at);

			if(action == 'create'){
				tblhprstmh.rows().deselect();
			}
		});

		edthprstmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			edtFormButtonSaveConfirmHD();
		});
		
		edthprstmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				kode = edthprstmh.field('hprstmh.kode').val();

				validasiRequired(
					edthprstmh,
					'hprstmh',
					{
						'kode': kode,
					}
				);

				validasiUnique(
					action,
					edthprstmh,
					'hprstmh',
					'kode',
					'kode',
					'"'+kode+'"',
					id_hprstmh
				);
			}
			
			if ( edthprstmh.inError() ) {
				return false;
			}
		});

		edthprstmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthprstmh.field('hprstmh.finish_at').val(finish_at);
		});
		
		edthprstmh.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edthprstmh.on( 'close', function () {
			edthprstmh.enable();
		} );
		
		tblhprstmh = $('#tblhprstmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-2',
			},
			ajax: {
				url: "../../models/hprstmh/hprstmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hprstmh = show_deleted_hprstmh;
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
					targets: [1,2]
				},
				{
					searchPanes:{
						show: false,
					},
					targets: '_all'
				}
			],
			columns: [
				{ data: "hprstmh.id",visible:false },
				{ data: "hprstmh.kode" },
				{ data: "hprstmh.keterangan" }
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hprstmh';
					$table       = 'tblhprstmh';
					$edt         = 'edthprstmh';
					$show_status = '_hprstmh';
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
				if ( data.hprstmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.hprstmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblhprstmh.searchPanes.container().appendTo('#sphprstmh');
		tblhprstmh.searchBuilder.container().appendTo( '#sbhprstmh' );
		
		tblhprstmh.on( 'init', function () {
			// atur hak akses
			tbl_details = [tblhprstmd];
			CekInitHeaderHD(tblhprstmh, tbl_details);
		} );
		
		tblhprstmh.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('hprstmh');
			
			// atur hak akses
			tbl_details = [tblhprstmd];
			CekSelectHeaderHD(tblhprstmh, tbl_details);

		} );
		
		tblhprstmh.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('hprstmh');

			// atur hak akses
			tbl_details = [tblhprstmd];
			CekDeselectHeaderHD(tblhprstmh, tbl_details);
		} );
		// END hprstmh

		// BEGIN hprstmd
		edthprstmd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/hprstmh/hprstmd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hprstmd = show_deleted_hprstmd;
					d.id_hprstmh = id_hprstmh;
				}
			},
			table: "#tblhprstmd",
			template: "#custom_detail",
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "hprstmd.start_at",
					name: "hprstmd.start_at",
					type: "hidden"
				},	
				{
					label: "hprstmd.finish_at",
					name: "hprstmd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "hprstmd",
					type: "hidden"
				},	
				{
					label: "hprstmd.transaction_state",
					name: "hprstmd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "id_hprstmh",
					name: "hprstmd.id_hprstmh",
					type: "hidden"
				},	
				{
					// label: "Kombinasi 1 <sup class='text-danger'>*<sup>",
					name: "hprstmd.kombinasi1",
					type: "select",
					placeholder : "Data",
					options: [
						{ "label": "Schedule", "value": 'st_jadwal' },
						{ "label": "Status Presensi In", "value": 'status_presensi_in' },
						{ "label": "Status Presensi Out", "value": 'status_presensi_out' },
					]
				}, 	
				{
					// label: "Condition <sup class='text-danger'>*<sup>",
					name: "hprstmd.condition",
					type: "select",
					placeholder : "Condition",
					options: [
						{ "label": "Equals", "value": '=' },
						{ "label": "Not", "value": '<>' },
						{ "label": "Empty", "value": 'IS NULL' },
						{ "label": "Not Empty", "value": 'IS NOT NULL' },
					]
				}, 	
				{
					// label: "Kombinasi 2 <sup class='text-danger'>*<sup>",
					name: "hprstmd.kombinasi2",
					attr: {
						placeholder:  "Value"
					}
				}, 	
			]
		} );
			
		edthprstmd.on( 'preOpen', function( e, mode, action ) {
			edthprstmd.field('hprstmd.id_hprstmh').val(id_hprstmh);
			
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthprstmd.field('hprstmd.start_at').val(start_at);
			
			if(action == 'create'){
				tblhprstmd.rows().deselect();
			}
		});

		edthprstmd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
		});

		edthprstmd.dependent( 'hprstmd.condition', function ( val, data, callback ) {
			if (val.includes('NULL')) {
				edthprstmd.field('hprstmd.kombinasi2').hide();
				edthprstmd.field('hprstmd.kombinasi2').val('');
			} else {
				edthprstmd.field('hprstmd.kombinasi2').show();
				edthprstmd.field('hprstmd.kombinasi2').val();
			}
			return {}
		}, {event: 'keyup change'});
		
		edthprstmd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				kombinasi1 = edthprstmd.field('hprstmd.kombinasi1').val();
				condition = edthprstmd.field('hprstmd.condition').val();

				validasiRequired(
					edthprstmd,
					'hprstmd',
					{
						'kombinasi1': kombinasi1,
						'condition': condition,
					}
				);
			}
			
			if ( edthprstmd.inError() ) {
				return false;
			}
		});

		edthprstmd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthprstmd.field('hprstmd.finish_at').val(finish_at);
		});
			
		edthprstmd.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edthprstmd.on( 'close', function () {
			edthprstmd.enable();
		} );
		
		tblhprstmd = $('#tblhprstmd').DataTable( {
			ajax: {
				url: "../../models/hprstmh/hprstmd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hprstmd = show_deleted_hprstmd;
					d.id_hprstmh = id_hprstmh;
				}
			},
			order: [[ 2, "desc" ]],
			columns: [
				{ data: "hprstmd.id",visible:false },
				{ data: "hprstmd.id_hprstmh",visible:false },
				{ 
					data: "hprstmd.kombinasi1",
                        render: function (data){
							if (data == 'st_jadwal'){
								return 'Schedule';
							}else if (data == 'status_presensi_in'){
								return 'Status Presensi In';
							}else if (data == 'status_presensi_out'){
								return 'Status Presensi Out';
							}else{
                                return '';
                            }
						}
				},
				{ 
					data: "hprstmd.condition" ,
                        render: function (data){
							if (data == '='){
								return 'Equals';
							}else if (data == '<>'){
								return 'Not';
							}else if (data == 'IS NULL'){
								return 'Empty';
							}else if (data == 'IS NOT NULL'){
								return 'Not Empty';
							}else{
                                return '';
                            }
						}
				},
				{ 
					data: "hprstmd.kombinasi2" 
				},
				{ data: "hprstmd.keterangan",visible:false }
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hprstmd';
					$table       = 'tblhprstmd';
					$edt         = 'edthprstmd';
					$show_status = '_hprstmd';
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

		tblhprstmd.on( 'draw', function( e, settings ) { 
			// atur hak akses
			CekDrawDetailHD( tblhprstmd, 1 );
			CekDrawDetailHDFinal(tblhprstmh);
		} );

		tblhprstmd.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSetD('hprstmd');
			
			// atur hak akses
			CekSelectDetailHD( tblhprstmd );
		} );

		tblhprstmd.on( 'deselect', function() {
			// reset variable standar framework
			siVarResetD('hprstmd');
			
			// atur hak akses
			CekDeselectDetailHD( tblhprstmd );
		} );
		// END hprstmd

		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
			},
			submitHandler: function(frmFilter) {
				start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
				tblhprstmh.rows().deselect();
				tblhprstmh.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSFhprstmh').modal('toggle');
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
