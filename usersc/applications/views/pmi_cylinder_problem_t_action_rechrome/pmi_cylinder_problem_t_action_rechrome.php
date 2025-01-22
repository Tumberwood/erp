<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'pmi_cylinder_problem_t_action';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblpmi_cylinder_problem_t_action" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Antrian</th>
                                <th>Keterangan (1)</th>
                                <th>Keterangan Cyl</th>
                                <th>Verified by</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/pmi_cylinder_problem_t_action_rechrome/fn/pmi_cylinder_problem_t_action_rechrome_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtpmi_cylinder_problem_t_action, tblpmi_cylinder_problem_t_action, show_deleted_pmi_cylinder_problem_t_action = 0, id_pmi_cylinder_problem_t_action;
	var show_deleted_pmi_cylinder_problem_t = 0, id_pmi_cylinder_problem_t = 0, keterangan_problem = '', antrian = 0, verifikasi_by = '';
	// ------------- end of default variable
	
	// get tableRelation
	tableRelation('pmi_cylinder_problem_t_action');

	$(document).ready(function() {
		// BEGIN pmi_cylinder_problem_t_action
		edtpmi_cylinder_problem_t_action = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/pmi_cylinder_problem_t_action_rechrome/pmi_cylinder_problem_t_action_rechrome.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_pmi_cylinder_problem_t_action = show_deleted_pmi_cylinder_problem_t_action;
				}
			},
			table: "#tblpmi_cylinder_problem_t_action",
			fields: [ 
				{
					label: "pmi_cylinder_problem_t_action.start_at",
					name: "pmi_cylinder_problem_t_action.start_at",
					type: "hidden"
				},	
				{
					label: "pmi_cylinder_problem_t_action.finish_at",
					name: "pmi_cylinder_problem_t_action.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "pmi_cylinder_problem_t_action",
					type: "hidden"
				},	
				{
					label: "pmi_cylinder_problem_t_action.transaction_state",
					name: "pmi_cylinder_problem_t_action.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "pmi_cylinder_problem_t_action.id_pmi_cylinder_problem_t",
					name: "pmi_cylinder_problem_t_action.id_pmi_cylinder_problem_t",
					type: "hidden",
				},	
				{
					label: 'Antrian',
					name: "pmi_cylinder_problem_t_action.antrian",
					type: "readonly"
				},
				{
					label: 'Keterangan',
					name: "pmi_cylinder_problem_t_action.keterangan",
					type: "readonly"
				},
				{
					label: "Keterangan Cyl <sup class='text-danger'>*<sup>",
					name: "pmi_cylinder_problem_t_action.keterangan_cyl",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": "OK", "value": "OK" },
						{ "label": "Masih ada", "value": "Masih ada" },
					]
				},
				{
					label: "Verifikasi By  <sup class='text-danger'>*<sup>", 
					name: "pmi_cylinder_problem_t_action.verifikasi_by",
				},
			]
		} );

		edtpmi_cylinder_problem_t_action.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtpmi_cylinder_problem_t_action.field('pmi_cylinder_problem_t_action.start_at').val(start_at);

			edtpmi_cylinder_problem_t_action.field('pmi_cylinder_problem_t_action.id_pmi_cylinder_problem_t').val(id_pmi_cylinder_problem_t);
			// console.log(id_pmi_cylinder_problem_t);

			edtpmi_cylinder_problem_t_action.field('pmi_cylinder_problem_t_action.keterangan').val(keterangan_problem);
			// console.log(keterangan_problem);

			edtpmi_cylinder_problem_t_action.field('pmi_cylinder_problem_t_action.antrian').val(antrian);
			console.log(antrian);

			if(action == 'create'){
				tblpmi_cylinder_problem_t_action.rows().deselect();
			}
		});

		edtpmi_cylinder_problem_t_action.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edtpmi_cylinder_problem_t_action.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				keterangan_cyl = edtpmi_cylinder_problem_t_action.field('pmi_cylinder_problem_t_action.keterangan_cyl').val();
				verifikasi_by = edtpmi_cylinder_problem_t_action.field('pmi_cylinder_problem_t_action.verifikasi_by').val();

				validasiRequired(
					edtpmi_cylinder_problem_t_action,
					'pmi_cylinder_problem_t_action',
					{
						'keterangan_cyl': keterangan_cyl,
						'verifikasi_by': verifikasi_by
					}
				);
			}
			
			if ( edtpmi_cylinder_problem_t_action.inError() ) {
				return false;
			}
		});
		
		edtpmi_cylinder_problem_t_action.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtpmi_cylinder_problem_t_action.field('pmi_cylinder_problem_t_action.finish_at').val(finish_at);
		});

		edtpmi_cylinder_problem_t_action.on( 'postSubmit', function (e, json, data, action, xhr) {
			tblpmi_cylinder_problem_t_action.ajax.reload(null, false);
		} );

		edtpmi_cylinder_problem_t_action.on( 'close', function () {
			edtpmi_cylinder_problem_t_action.enable();
		} );

		tblpmi_cylinder_problem_t_action = $('#tblpmi_cylinder_problem_t_action').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/pmi_cylinder_problem_t_action_rechrome/pmi_cylinder_problem_t_action_rechrome_tbl.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_pmi_cylinder_problem_t = show_deleted_pmi_cylinder_problem_t;
				}
			},
			order: [[ 0, "asc" ]],
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
				{
					data: null, 
					render: function (data, type, row, meta) {
						if (row.pmi_cylinder_problem_t_action.id_pmi_cylinder_problem_t) {
							return row.pmi_cylinder_problem_t_action.id_pmi_cylinder_problem_t
						} else {
							return row.pmi_cylinder_problem_t.id
						}
					}
					,visible:false 
				},
				{
					data: null, 
					render: function (data, type, row, meta) {
						return meta.row + 1;
					}
				},
				{
					data: null, 
					render: function (data, type, row, meta) {
						if (row.pmi_cylinder_problem_t_action.keterangan) {
							return row.pmi_cylinder_problem_t_action.keterangan
						} else {
							return row.pmi_cylinder_problem_t.keterangan
						}
					}
				},
				{ data: "pmi_cylinder_problem_t_action.keterangan_cyl" },
				{ data: "pmi_cylinder_problem_t_action.verifikasi_by" },
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_pmi_cylinder_problem_t_action';
					$table       = 'tblpmi_cylinder_problem_t_action';
					$edt         = 'edtpmi_cylinder_problem_t_action';
					$show_status = '_pmi_cylinder_problem_t_action';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= ['sp', 'sb'];
					$arr_buttons_action 	= [];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
				// END breaking generate button
				{
					extend: 'create',
					text: '<i class="fa fa-edit"></i>',
					name: 'btnRechrome',
					className: 'btn btn-xs btn-outline',
					editor: edtpmi_cylinder_problem_t_action, 
					titleAttr: 'Rechrome',
				},
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
			}
		} );

		tblpmi_cylinder_problem_t_action.searchPanes.container().appendTo('#sppmi_cylinder_problem_t_action');
		tblpmi_cylinder_problem_t_action.searchBuilder.container().appendTo( '#sbpmi_cylinder_problem_t_action' );
		
		tblpmi_cylinder_problem_t_action.on( 'init', function () {
			tblpmi_cylinder_problem_t_action.button('btnRechrome:name').disable();
		} );
		
		tblpmi_cylinder_problem_t_action.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			pmi_cylinder_problem_t_data = tblpmi_cylinder_problem_t_action.row( { selected: true } ).data().pmi_cylinder_problem_t;
			id_pmi_cylinder_problem_t = pmi_cylinder_problem_t_data.id;
			keterangan_problem = pmi_cylinder_problem_t_data.keterangan;
			// console.log(id_pmi_cylinder_problem_t);
			// console.log(keterangan_problem);
			rowIndex = tblpmi_cylinder_problem_t_action.row({ selected: true }).index();
		    antrian = rowIndex + 1; // Incremental dimulai dari 1
			// console.log(nomorIncremental);

			pmi_cylinder_problem_t_action_data = tblpmi_cylinder_problem_t_action.row( { selected: true } ).data().pmi_cylinder_problem_t_action;
			verifikasi_by = pmi_cylinder_problem_t_action_data.verifikasi_by;
			// console.log(verifikasi_by);

			if (verifikasi_by) {
				tblpmi_cylinder_problem_t_action.button('btnRechrome:name').disable();
			} else {
				tblpmi_cylinder_problem_t_action.button('btnRechrome:name').enable();
			}

		} );
		
		tblpmi_cylinder_problem_t_action.on( 'deselect', function () {
			// reset variable standar framework
			id_pmi_cylinder_problem_t = 0;
			antrian = 0;
			keterangan_problem = '';
			verifikasi_by = '';
			tblpmi_cylinder_problem_t_action.button('btnRechrome:name').disable();
		} );

		// END pmi_cylinder_problem_t_action
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
