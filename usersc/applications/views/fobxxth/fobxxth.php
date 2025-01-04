<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'fobxxth';
	$nama_tabels_d = [];

	// self view
	if (isset($_GET['rowid']) && $_GET['rowid'] > 0) {
		$rowid = $_GET['rowid'];
	} else {
		$rowid = 0;
	}
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="modal" id="modalSFfobxxth" tabindex="-1" role="dialog" aria-hidden="true">
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
                    <table id="tblfobxxth" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th data-i18n="date"></th>
                                <th data-i18n="code"></th>
                                <th data-i18n="from"></th>
                                <th data-i18n="to"></th>
                                <th data-i18n="nominal"></th>
                                <th data-i18n="notes"></th>
                                <th data-i18n="state"></th>
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
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/fobxxth/fn/fobxxth_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtfobxxth, tblfobxxth, show_deleted_fobxxth = 0, id_fobxxth;
	var rowid = <?php echo $rowid; ?>;
	// ------------- end of default variable
	id_aakxxmh_asal_old = 0, id_aakxxmh_tujuan_old = 0;

	// get tableRelation
	tableRelation('fobxxth');
	
	$(document).ready(function() {
		start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		
		// BEGIN fobxxth
		edtfobxxth = new $.fn.dataTable.Editor( {
			formOptions: {
				main: {
					focus: 5,
				}
			},
			ajax: {
				url: "../../models/fobxxth/fobxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_fobxxth = show_deleted_fobxxth;
					d.start_date = start_date;
					d.end_date = end_date;
					d.rowid = rowid;
				}
			},
			table: "#tblfobxxth",
			fields: [ 
				{
					label: "kategori_dokumen",
					name: "kategori_dokumen",
					type: "hidden"
				},
				{
					label: "kategori_dokumen_value",
					name: "kategori_dokumen_value",
					type: "hidden"
				},
				{
					label: "field_tanggal",
					name: "field_tanggal",
					type: "hidden"
				},
				{
					label: "fobxxth.start_at",
					name: "fobxxth.start_at",
					type: "hidden"
				},	
				{
					label: "fobxxth.finish_at",
					name: "fobxxth.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "fobxxth",
					type: "hidden"
				},	
				{
					label: "fobxxth.transaction_state",
					name: "fobxxth.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: getTranslation('date') + "<sup class='text-danger'>*<sup>",
					name: "fobxxth.tanggal",
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
					label: getTranslation('from') + "<sup class='text-danger'>*<sup>",
					name: "fobxxth.id_aakxxmh_asal",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/aakxxmh/aakxxmh_fn_opt_kasbank.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_aakxxmh_old: id_aakxxmh_asal_old,
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
					label: getTranslation('to') + "<sup class='text-danger'>*<sup>",
					name: "fobxxth.id_aakxxmh_tujuan",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/aakxxmh/aakxxmh_fn_opt_kasbank.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_aakxxmh_old: id_aakxxmh_tujuan_old,
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
					label: getTranslation('nominal') + "<sup class='text-danger'>*<sup>",
					name: "fobxxth.amount"
				},
				{
					label: getTranslation('notes') + "<sup class='text-danger'>*<sup>",
					name: "fobxxth.keterangan",
					type: "textarea"
				}
			]
		} );

		edtfobxxth.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtfobxxth.field('fobxxth.start_at').val(start_at);
			
			if(action == 'create'){
				edtfobxxth.field('kategori_dokumen').val('');
				edtfobxxth.field('kategori_dokumen_value').val('');
				edtfobxxth.field('field_tanggal').val('tanggal');
				tblfobxxth.rows().deselect();
			}
		});

		edtfobxxth.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
		});

		edtfobxxth.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				
				tanggal           = edtfobxxth.field('fobxxth.tanggal').val();
				id_aakxxmh_asal   = edtfobxxth.field('fobxxth.id_aakxxmh_asal').val();
				id_aakxxmh_tujuan = edtfobxxth.field('fobxxth.id_aakxxmh_tujuan').val();
				amount            = edtfobxxth.field('fobxxth.amount').val();
				keterangan        = edtfobxxth.field('fobxxth.keterangan').val();

				validasiRequired(
					edtfobxxth,
					'fobxxth',
					{
						'tanggal'          : tanggal,
						'id_aakxxmh_asal'  : id_aakxxmh_asal,
						'id_aakxxmh_tujuan': id_aakxxmh_tujuan,
						'amount'           : amount,
						'keterangan'       : keterangan
					}
				);

				validasiNumber(
					edtfobxxth,
					'fobxxth',
					{
						'amount': amount
					},
					0,
					'>'
				);

				validasiDifferent(
					edtfobxxth,
					'fobxxth',
					{
						'id_aakxxmh_asal': id_aakxxmh_asal,
						'id_aakxxmh_tujuan': id_aakxxmh_tujuan
					}
				)
			
			}
			
			if ( edtfobxxth.inError() ) {
				return false;
			}
		});
		
		edtfobxxth.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtfobxxth.field('fobxxth.finish_at').val(finish_at);
		});

		edtfobxxth.on( 'close', function () {
			edtfobxxth.enable();
		} );

		tblfobxxth = $('#tblfobxxth').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/fobxxth/fobxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_fobxxth = show_deleted_fobxxth;
					d.start_date = start_date;
					d.end_date = end_date;
					d.rowid = rowid;
				}
			},
			order: [[ 1, "asc" ]],
			columnDefs:[
				{
					searchPanes:{
						show: true,
					},
					targets: [1,2,3,4]
				},
				{
					searchPanes:{
						show: false,
					},
					targets: '_all'
				}
			],
			columns: [
				{ data: "fobxxth.id",visible:false },
				{ data: "fobxxth.tanggal" },
				{ data: "fobxxth.kode" },
				{ data: "aakxxmh_asal.nama" },
				{ data: "aakxxmh_tujuan.nama" },
				{ 
					data: "fobxxth.amount" ,
					...renderNumber(2)
				},
				{ data: "fobxxth.keterangan" },
				{ 
					data: "fobxxth.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_fobxxth';
					$table       = 'tblfobxxth';
					$edt         = 'edtfobxxth';
					$show_status = '_fobxxth';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= ['sf', 'sp', 'sb'];
					$arr_buttons_action 	= ['create', 'edit', 'remove', 'confirm', 'nonaktif_h', 'close', 'view', 'log','noaction'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
				// END breaking generate button
				{
					text: '<i class="fa fa-print"></i>',
					name: 'btnPrintJurnal',
					className: 'btn btn-sm btn-outline',
					titleAttr: 'Print Jurnal',
					action: function ( e, dt, node, config ) {
						e.preventDefault(); 
						var url = $(this).attr('href'); 
						window.open('../../views/core/jv_print.php?jenis_transaksi=Overbook&id_transaksi='+id_fobxxth, '_blank');
					}
				}
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
				if ( data.fobxxth.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.fobxxth.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblfobxxth.searchPanes.container().appendTo('#spfobxxth');
		tblfobxxth.searchBuilder.container().appendTo( '#sbfobxxth' );
		
		tblfobxxth.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblfobxxth);
		} );
		
		tblfobxxth.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('fobxxth');
			id_aakxxmh_asal_old = fobxxth_data.id_aakxxmh_asal;
			id_aakxxmh_tujuan_old = fobxxth_data.id_aakxxmh_tujuan;

			// atur hak akses
			CekSelectHeaderH(tblfobxxth);
		} );

		tblfobxxth.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('fobxxth');
			id_aakxxmh_asal_old = 0, id_aakxxmh_tujuan_old = 0;

			// atur hak akses
			CekDeselectHeaderH(tblfobxxth);
		} );
		
		// END fobxxth

		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
			},
			submitHandler: function(frmFilter) {
				start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
				tblfobxxth.rows().deselect();
				tblfobxxth.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSFfobxxth').modal('toggle');
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
