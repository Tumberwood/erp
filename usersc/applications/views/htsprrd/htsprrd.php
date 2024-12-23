<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'htsprrd';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="modal" id="modalSFhtsprrd" tabindex="-1" role="dialog" aria-hidden="true">
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
                    <table id="tblhtsprrd" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>NIP</th>
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th>Tanggal</th>
                                <th>Jadwal</th>
                                <th>Clock In</th>
                                <th>Clock Out</th>
                                <!-- <th>Check CI</th>
                                <th>Check CO</th> -->
                                <th>Status In</th>
                                <th>Status Out</th>
                                <th>Keterangan</th>
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
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/htsprrd/fn/htsprrd_fn.php'; ?>

<!-- BEGIN datatables here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edthtsprrd, tblhtsprrd, show_deleted_htsprrd = 0, id_htsprrd;
	// ------------- end of default variable
	var id_users_old = 0;
	var id_hemxxmh_old = 0;
	// console.log(id_users_old);

	// get tableRelation
	tableRelation('htsprrd');

	$('#start_date').datepicker('setDate', moment().toDate());
	$('#end_date').datepicker('setDate', moment().toDate());

	$(document).ready(function() {
		
		start_date = moment($('#start_date').val()).format('YYYY-MM-DD');
		end_date   = moment($('#end_date').val()).format('YYYY-MM-DD');

		// BEGIN htsprrd
		edthtsprrd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/htsprrd/htsprrd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_htsprrd = show_deleted_htsprrd;
					d.start_date = start_date;
					d.end_date = end_date;
					// d.status_approve = status_approve;
				}
			},
			table: "#tblhtsprrd",
			fields: [ 
				{
					label: "htsprrd.start_at",
					name: "htsprrd.start_at",
					type: "hidden"
				},	
				{
					label: "htsprrd.finish_at",
					name: "htsprrd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "htsprrd",
					type: "hidden"
				},	
				{
					label: "htsprrd.transaction_state",
					name: "htsprrd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "Tanggal <sup class='text-danger'>*<sup>",
					name: "htsprrd.tanggal",
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
					name: "htsprrd.keterangan",
					type: "textarea"
				},	
			]
		} );

		edthtsprrd.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthtsprrd.field('htsprrd.start_at').val(start_at);
			
			if(action == 'create'){
				tblhtsprrd.rows().deselect();
			}
		});

		edthtsprrd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			edtFormButtonSaveConfirm();
		});

		edthtsprrd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				tanggal = edthtsprrd.field('htsprrd.tanggal').val();

				validasiRequired(
					edthtsprrd,
					'htsprrd',
					{
						'tanggal': tanggal,
					}
				);
			}
			
			if ( edthtsprrd.inError() ) {
				return false;
			}
		});
		
		edthtsprrd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthtsprrd.field('htsprrd.finish_at').val(finish_at);
		});

		edthtsprrd.on( 'postSubmit', function (e, json, data, action, xhr) {
			tblhtsprrd.rows().deselect();
			tblhtsprrd.ajax.reload(null, false);
		} );
		
		edthtsprrd.on( 'close', function () {
			edthtsprrd.enable();
		} );

		tblhtsprrd = $('#tblhtsprrd').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/htsprrd/htsprrd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_htsprrd = show_deleted_htsprrd;
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
					targets: [0]
				}
			],
			responsive: false,
			scrollX: true,
			columns: [
				{ data: "htsprrd.id",visible:false },
				{ data: "hemxxmh.kode" },
				{ data: "hemxxmh.nama" },
				{ data: "hetxxmh.nama" },
				{ data: "htsprrd.tanggal" },
				{ data: "htsprrd.st_jadwal" },
				{ data: "htsprrd.clock_in" },
				{ data: "htsprrd.clock_out" },
				// { data: "htsprrd.st_clock_in" },
				// { data: "htsprrd.st_clock_out" },
				{ data: "htsprrd.status_presensi_in" },
				{ data: "htsprrd.status_presensi_out" },
				{ data: "htsprrd.keterangan" },
				
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_htsprrd';
					$table       = 'tblhtsprrd';
					$edt         = 'edthtsprrd';
					$show_status = '_htsprrd';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= ['sf','sp', 'sb'];
					$arr_buttons_action 	= [];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
				if ( data.htsprrd.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.htsprrd.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblhtsprrd.searchPanes.container().appendTo('#sphtsprrd');
		tblhtsprrd.searchBuilder.container().appendTo( '#sbhtsprrd' );
		
		tblhtsprrd.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblhtsprrd);
		} );
		
		tblhtsprrd.on( 'select', function( e, dt, type, indexes ) {
			siVarSet('htsprrd');
			tanggal_select = htsprrd_data.tanggal;
			// atur hak akses
			CekSelectHeaderH(tblhtsprrd);
		} );

		tblhtsprrd.on( 'deselect', function () {
			siVarReset('htsprrd');
			tanggal_select = null;

			// atur hak akses
			CekDeselectHeaderH(tblhtsprrd);
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
				tblhtsprrd.rows().deselect();
				tblhtsprrd.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSFhtsprrd').modal('toggle');
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
