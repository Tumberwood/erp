<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'ndcrctd';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="modal" id="modalSFndcrctd" tabindex="-1" role="dialog" aria-hidden="true">
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
                    <table id="tblndcrctd" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Document No</th>
                                <th>Tanggal Jam Masuk</th>
                                <th>Pengirim</th>
                                <th>Ditujukan Kepada</th>
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
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/ndcrctd/fn/ndcrctd_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtndcrctd, tblndcrctd, show_deleted_ndcrctd = 0, id_ndcrctd;
	// ------------- end of default variable

	var id_grlxxmh_expedisi_old = 0;
	
	// get tableRelation
	tableRelation('ndcrctd');

	$(document).ready(function() {
		start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');

		// BEGIN ndcrctd
		edtndcrctd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/ndcrctd/ndcrctd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_ndcrctd = show_deleted_ndcrctd;
					d.start_date = start_date;
					d.end_date = end_date;
				}
			},
			table: "#tblndcrctd",
			fields: [ 
				{
					label: "ndcrctd.start_at",
					name: "ndcrctd.start_at",
					type: "hidden"
				},	
				{
					label: "ndcrctd.finish_at",
					name: "ndcrctd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "ndcrctd",
					type: "hidden"
				},	
				{
					label: "ndcrctd.transaction_state",
					name: "ndcrctd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "Document No <sup class='text-danger'>*<sup>",
					name: "ndcxxmh.dokumen_nomor"
				}, 	
				{
					label: "Tanggal Jam Masuk <sup class='text-danger'>*<sup>",
					name: "ndcrctd.tanggal_jam_terima",
					type: "datetime",
					def: function () { 
						return new Date(); 
					},
					opts:{
						minDate: new Date('1900-01-01'),
						firstDay: 0
					},
					format: 'DD MMM YYYY HH:mm'
				},
				{
					label: "Pengirim <sup class='text-danger'>*<sup>",
					name: "ndcrctd.pengirim"
				},
				{
					label: "Ditujukan Kepada <sup class='text-danger'>*<sup>",
					name: "ndcrctd.kepada"
				},
				{
					label: "Courier / Expedition",
					name: "ndcrctd.id_grlxxmh_expedisi",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/lexxxmh/lexxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_grlxxmh_old: id_grlxxmh_expedisi_old,
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
					label: "Keterangan",
					name: "ndcxxmh.keterangan",
					type: "textarea"
				}
			]
		} );

		edtndcrctd.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtndcrctd.field('ndcrctd.start_at').val(start_at);
			
			if(action == 'create'){
				tblndcrctd.rows().deselect();
			}
		});

		edtndcrctd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edtndcrctd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				dokumen_nomor = edtndcrctd.field('ndcxxmh.dokumen_nomor').val();
				tanggal_jam_terima = edtndcrctd.field('ndcrctd.tanggal_jam_terima').val();
				pengirim = edtndcrctd.field('ndcrctd.pengirim').val();
				kepada = edtndcrctd.field('ndcrctd.kepada').val();

				validasiRequired(
					edtndcrctd,
					'ndcrctd',
					{
						'tanggal_jam_terima': tanggal_jam_terima,
						'pengirim': pengirim,
						'kepada': kepada
					}
				);

				validasiRequired(
					edtndcrctd,
					'ndcxxmh',
					{
						'dokumen_nomor': dokumen_nomor
					}
				);

			}
			
			if ( edtndcrctd.inError() ) {
				return false;
			}
		});
		
		edtndcrctd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtndcrctd.field('ndcrctd.finish_at').val(finish_at);
		});

		edtndcrctd.on( 'close', function () {
			edtndcrctd.enable();
		} );

		edtndcrctd.on('postSubmit', function(e, json, data, action, xhr) {
			tblndcrctd.rows().deselect();
			tblndcrctd.ajax.reload(null, false);
		});

		tblndcrctd = $('#tblndcrctd').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/ndcrctd/ndcrctd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_ndcrctd = show_deleted_ndcrctd;
					d.start_date = start_date;
					d.end_date = end_date;
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
				{ data: "ndcrctd.id",visible:false },
				{ data: "ndcxxmh.dokumen_nomor" },
				{ data: "ndcrctd.tanggal_jam_terima" },
				{ data: "ndcrctd.pengirim" },
				{ data: "ndcrctd.kepada" },
				{ data: "ndcrctd.keterangan" },
				{ 
					data: "ndcrctd.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_ndcrctd';
					$table       = 'tblndcrctd';
					$edt         = 'edtndcrctd';
					$show_status = '_ndcrctd';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= ['sf', 'sp', 'sb'];
					$arr_buttons_action 	= ['create', 'edit', 'remove', 'confirm', 'nonaktif_h', 'close', 'view', 'log','noaction'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
				// END breaking generate button
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
				if ( data.ndcrctd.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.ndcrctd.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblndcrctd.searchPanes.container().appendTo('#spndcrctd');
		tblndcrctd.searchBuilder.container().appendTo( '#sbndcrctd' );
		
		tblndcrctd.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblndcrctd);
		} );
		
		tblndcrctd.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('ndcrctd');
			id_grlxxmh_expedisi_old	= ndcrctd_data.id_grlxxmh_expedisi;

			// atur hak akses
			CekSelectHeaderH(tblndcrctd);
		} );

		tblndcrctd.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('ndcrctd');
			id_grlxxmh_expedisi_old = 0;

			// atur hak akses
			CekDeselectHeaderH(tblndcrctd);
		} );

		// END ndcrctd
		
		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
			},
			submitHandler: function(frmFilter) {
				start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
				tblndcrctd.rows().deselect();
				tblndcrctd.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSFndcrctd').modal('toggle');
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
