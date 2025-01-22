<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'pmi_cylinder_problem_t';
	$nama_tabels_d = [];
?>

<!-- begin content here -->

 <!-- Modal Table-->
<div class="modal fade" id="dataModal" tabindex="-1" aria-labelledby="dataModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="dataModalLabel">Table History</h5>
				<button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="table-responsive" id="proteksi">
					<table id="tableHistory" class="table table-striped table-bordered table-hover nowrap" width="100%">
						<thead>
							<tr>
								<th>ID Action</th>
								<th>Tanggal</th>
								<th>Action</th>
								<th>Verified by</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<!-- Tombol Close -->
				<button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>


<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblpmi_cylinder_problem_t" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Cyl</th>
                                <th>Warna</th>
                                <th>Keterangan (1)</th>
                                <th>Ditemukan pada</th>
                                <th>Action</th>
                                <th>State</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/pmi_cylinder_problem_t/fn/pmi_cylinder_problem_t_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtpmi_cylinder_problem_t, tblpmi_cylinder_problem_t, show_deleted_pmi_cylinder_problem_t = 0, id_pmi_cylinder_problem_t;
	var id_pmi_cylinder_m_old = 0, id_pmi_cylinder_m_color_old = 0, id_pmi_cylinder_m = 0;
	// ------------- end of default variable
	
	// get tableRelation
	tableRelation('pmi_cylinder_problem_t');

	$(document).ready(function() {
		// BEGIN pmi_cylinder_problem_t
		edtpmi_cylinder_problem_t = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/pmi_cylinder_problem_t/pmi_cylinder_problem_t.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_pmi_cylinder_problem_t = show_deleted_pmi_cylinder_problem_t;
				}
			},
			table: "#tblpmi_cylinder_problem_t",
			fields: [ 
				{
					label: "pmi_cylinder_problem_t.start_at",
					name: "pmi_cylinder_problem_t.start_at",
					type: "hidden"
				},	
				{
					label: "pmi_cylinder_problem_t.finish_at",
					name: "pmi_cylinder_problem_t.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "pmi_cylinder_problem_t",
					type: "hidden"
				},	
				{
					label: "pmi_cylinder_problem_t.transaction_state",
					name: "pmi_cylinder_problem_t.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "Nama Cyl <sup class='text-danger'>*<sup>",
					name: "pmi_cylinder_problem_t.id_pmi_cylinder_m",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/pmi_cylinder_m/pmi_cylinder_m_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_pmi_cylinder_m_old: id_pmi_cylinder_m_old,
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
					label: "Warna <sup class='text-danger'>*<sup>",
					name: "pmi_cylinder_problem_t.id_pmi_cylinder_m_color",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/pmi_cylinder_m/pmi_cylinder_m_color_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								id_pmi_cylinder_m = edtpmi_cylinder_problem_t.field('pmi_cylinder_problem_t.id_pmi_cylinder_m').val();
								var query = {
									id_pmi_cylinder_m_color_old: id_pmi_cylinder_m_color_old,
									id_pmi_cylinder_m: id_pmi_cylinder_m,
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
					label: "Keterangan <sup class='text-danger'>*<sup>",
					name: "pmi_cylinder_problem_t.keterangan",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": "Tipis", "value": 'Tipis' },
						{ "label": "Cacat", "value": 'Cacat' },
						{ "label": "Korosi", "value": 'Korosi' },
						{ "label": "Oksidasi", "value": 'Oksidasi' },
					]
				},
				{
					label: "Ditemukan Pada <sup class='text-danger'>*<sup>",
					name: "pmi_cylinder_problem_t.ditemukan_pada",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": "Turun Cetak", "value": 'Turun Cetak' },
						{ "label": "Sebelum Naik", "value": 'Sebelum Naik' },
					]
				},
				{
					label: "Action <sup class='text-danger'>*<sup>",
					name: "pmi_cylinder_problem_t.action",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": "Rechrome", "value": 'Rechrome' },
						{ "label": "Repair", "value": 'Repair' },
						{ "label": "ROTP", "value": 'ROTP' },
						{ "label": "Coba Lagi", "value": 'Coba Lagi' },
					]
				}
			]
		} );

		edtpmi_cylinder_problem_t.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtpmi_cylinder_problem_t.field('pmi_cylinder_problem_t.start_at').val(start_at);
			
			if(action == 'create'){
				tblpmi_cylinder_problem_t.rows().deselect();
			}
		});

		edtpmi_cylinder_problem_t.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edtpmi_cylinder_problem_t.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				id_pmi_cylinder_m = edtpmi_cylinder_problem_t.field('pmi_cylinder_problem_t.id_pmi_cylinder_m').val();
				id_pmi_cylinder_m_color = edtpmi_cylinder_problem_t.field('pmi_cylinder_problem_t.id_pmi_cylinder_m_color').val();
				keterangan = edtpmi_cylinder_problem_t.field('pmi_cylinder_problem_t.keterangan').val();
				ditemukan_pada = edtpmi_cylinder_problem_t.field('pmi_cylinder_problem_t.ditemukan_pada').val();
				action = edtpmi_cylinder_problem_t.field('pmi_cylinder_problem_t.action').val();

				validasiRequired(
					edtpmi_cylinder_problem_t,
					'pmi_cylinder_problem_t',
					{
						'id_pmi_cylinder_m': id_pmi_cylinder_m,
						'id_pmi_cylinder_m_color': id_pmi_cylinder_m_color,
						'keterangan': keterangan,
						'ditemukan_pada': ditemukan_pada,
						'action': action,
					}
				);

			}
			
			if ( edtpmi_cylinder_problem_t.inError() ) {
				return false;
			}
		});
		
		edtpmi_cylinder_problem_t.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtpmi_cylinder_problem_t.field('pmi_cylinder_problem_t.finish_at').val(finish_at);
		});

		edtpmi_cylinder_problem_t.on( 'close', function () {
			edtpmi_cylinder_problem_t.enable();
		} );

		tblpmi_cylinder_problem_t = $('#tblpmi_cylinder_problem_t').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/pmi_cylinder_problem_t/pmi_cylinder_problem_t.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_pmi_cylinder_problem_t = show_deleted_pmi_cylinder_problem_t;
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
				{ data: "pmi_cylinder_problem_t.id",visible:false },
				{ data: "pmi_cylinder_m.nama" },
				{ data: "pmi_cylinder_m_color.nama" },
				{ data: "pmi_cylinder_problem_t.keterangan" },
				{ data: "pmi_cylinder_problem_t.ditemukan_pada" },
				{ data: "pmi_cylinder_problem_t.action" },
				{ 
					data: "pmi_cylinder_problem_t.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_pmi_cylinder_problem_t';
					$table       = 'tblpmi_cylinder_problem_t';
					$edt         = 'edtpmi_cylinder_problem_t';
					$show_status = '_pmi_cylinder_problem_t';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= ['sp', 'sb'];
					$arr_buttons_action 	= ['create', 'edit', 'remove', 'confirm', 'nonaktif_h', 'close', 'view', 'log','noaction'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
				// END breaking generate button
				{ 
					text: '<span class="fa fa-clock-o"></span>', 
					name: 'btnHistory',
					className: 'btn btn-sm btn-success',
					titleAttr: 'History',
					action: function ( e, dt, node, config ) {
						tableHistory(id_pmi_cylinder_problem_t);
						$('#dataModal').modal('show');
					}
				},
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
				if ( data.pmi_cylinder_problem_t.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.pmi_cylinder_problem_t.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblpmi_cylinder_problem_t.searchPanes.container().appendTo('#sppmi_cylinder_problem_t');
		tblpmi_cylinder_problem_t.searchBuilder.container().appendTo( '#sbpmi_cylinder_problem_t' );
		
		tblpmi_cylinder_problem_t.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblpmi_cylinder_problem_t);
			tblpmi_cylinder_problem_t.button('btnHistory:name').disable();
		} );
		
		tblpmi_cylinder_problem_t.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('pmi_cylinder_problem_t');
			id_pmi_cylinder_m_old = pmi_cylinder_problem_t_data.id_pmi_cylinder_m;
			id_pmi_cylinder_m_color_old = pmi_cylinder_problem_t_data.id_pmi_cylinder_m_color;

			// atur hak akses
			CekSelectHeaderH(tblpmi_cylinder_problem_t);
			tblpmi_cylinder_problem_t.button('btnHistory:name').enable();
		} );

		tblpmi_cylinder_problem_t.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('pmi_cylinder_problem_t');
			id_pmi_cylinder_m_old = 0;
			id_pmi_cylinder_m_color_old = 0;

			// atur hak akses
			CekDeselectHeaderH(tblpmi_cylinder_problem_t);
			tblpmi_cylinder_problem_t.button('btnHistory:name').disable();
		} );

		// END pmi_cylinder_problem_t
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
