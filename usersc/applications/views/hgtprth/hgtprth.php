<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'hgtprth';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="modal" id="modalSFhgtprth" tabindex="-1" role="dialog" aria-hidden="true">
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
                    <table id="tblhgtprth" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tanggal</th>
                                <th>Digenerate Tanggal</th>
                                <th>Keterangan</th>
                                <th>TX</th>
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
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_toast.php';
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
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/hgtprth/fn/hgtprth_fn.php'; ?>

<!-- BEGIN datatables here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edthgtprth, tblhgtprth, show_deleted_hgtprth = 0, id_hgtprth;
	// ------------- end of default variable
	var id_users_old = 0;
	var id_hemxxmh_old = 0;
	
	// get tableRelation
	tableRelation('hgtprth');

	$(document).ready(function() {
		start_date 		= moment($('#start_date').val()).format('YYYY-MM-DD');
		end_date 		= moment($('#end_date').val()).format('YYYY-MM-DD');
		
		// BEGIN hgtprth
		edthgtprth = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/hgtprth/hgtprth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hgtprth = show_deleted_hgtprth;
					d.start_date = start_date;
					d.end_date = end_date;
				}
			},
			table: "#tblhgtprth",
			fields: [ 
				{
					label: "hgtprth.start_at",
					name: "hgtprth.start_at",
					type: "hidden"
				},	
				{
					label: "hgtprth.finish_at",
					name: "hgtprth.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "hgtprth",
					type: "hidden"
				},	
				{
					label: "hgtprth.transaction_state",
					name: "hgtprth.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "Tanggal <sup class='text-danger'>*<sup>",
					name: "hgtprth.tanggal",
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
					name: "hgtprth.keterangan",
					type: "textarea"
				},	
			]
		} );

		edthgtprth.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthgtprth.field('hgtprth.start_at').val(start_at);
			
			if(action == 'create'){
				tblhgtprth.rows().deselect();
			}
		});

		edthgtprth.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edthgtprth.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				tanggal = edthgtprth.field('hgtprth.tanggal').val();

				validasiRequired(
					edthgtprth,
					'hgtprth',
					{
						'tanggal': tanggal,
					}
				);
			}
			
			if ( edthgtprth.inError() ) {
				return false;
			}
		});
		
		edthgtprth.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthgtprth.field('hgtprth.finish_at').val(finish_at);
		});

		edthgtprth.on( 'postSubmit', function (e, json, data, action, xhr) {
			tblhgtprth.rows().deselect();
			tblhgtprth.ajax.reload(null, false);
		} );
		
		edthgtprth.on( 'close', function () {
			edthgtprth.enable();
		} );

		tblhgtprth = $('#tblhgtprth').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/hgtprth/hgtprth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hgtprth = show_deleted_hgtprth;
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
					targets: [1,2,4]
				},
				{
					searchPanes:{
						show: false,
					},
					targets: '_all'
				}
			],
			responsive: false,
			scrollX: true,
			columns: [
				{ data: "hgtprth.id",visible:false },
				{ data: "hgtprth.tanggal" },
				{ data: "hgtprth.generated_on" },
				{ data: "hgtprth.keterangan" },
				{ 
					data: "hgtprth.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hgtprth';
					$table       = 'tblhgtprth';
					$edt         = 'edthgtprth';
					$show_status = '_hgtprth';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= ['sf','sp', 'sb'];
					$arr_buttons_action 	= ['create' ,'edit', 'confirm', 'close', 'view', 'log','noaction'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
				// END breaking generate button
				{
					text: '<i class="fa fa-google"></i>',
					name: 'btnGeneratePresensi',
					className: 'btn btn-xs btn-outline',
					titleAttr: '',
					action: function ( e, dt, node, config ) {
						e.preventDefault(); 
						var date = new Date().getTime();
						var timestamp = moment(timestamp).format('YYYY-MM-DD HH:mm:ss');

						notifyprogress = $.notify({
							message: 'Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!'
						},{
							z_index: 9999,
							allow_dismiss: false,
							type: 'info',
							delay: 0
						});

						$.ajax( {
							url: "../../models/hgtprth/hgtprth_fn_gen_presensi_ferry_v3.php",
							dataType: 'json',
							type: 'POST',
							data: {
								tanggal_select: tanggal_select,
								timestamp: timestamp
							},
							success: function ( json ) {

								$.notify({
									message: json.data.message
								},{
									type: json.data.type_message
								});

								tblhgtprth.ajax.reload(function ( json ) {
									notifyprogress.close();
								}, false);
							}
						} );
					}
				},
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
				if ( data.hgtprth.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.hgtprth.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblhgtprth.searchPanes.container().appendTo('#sphgtprth');
		tblhgtprth.searchBuilder.container().appendTo( '#sbhgtprth' );
		
		tblhgtprth.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblhgtprth);
			tblhgtprth.button( 'btnGeneratePresensi:name' ).disable();
		} );
		
		tblhgtprth.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('hgtprth');
			tanggal_select      		= hgtprth_data.tanggal;
			// atur hak akses
			CekSelectHeaderH(tblhgtprth);
			tblhgtprth.button( 'btnGeneratePresensi:name' ).enable();
		} );

		tblhgtprth.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('hgtprth');
			tanggal_select = null;

			// atur hak akses
			CekDeselectHeaderH(tblhgtprth);
			tblhgtprth.button( 'btnGeneratePresensi:name' ).disable();
		} );
		
		// BEGIN form filter
		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
			},
			submitHandler: function(frmFilter) {
				start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
				tblhgtprth.rows().deselect();
				tblhgtprth.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSFhgtprth').modal('toggle');
			}, false);
				return false;
			}
		});
		// END form filter

	} );// end of document.ready

</script>

<!-- END datatables here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
