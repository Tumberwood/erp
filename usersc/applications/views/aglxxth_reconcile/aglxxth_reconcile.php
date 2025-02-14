<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'aglxxth';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="modal" id="modalSFaglxxth" tabindex="-1" role="dialog" aria-hidden="true">
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
									<div class="form-group row">												
										<label class="col-lg-2 col-form-label">Bank</label>
										<div class="col-lg-5">
											<select class="form-control" id="select_id_aakxxmh" name="select_id_aakxxmh"></select>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-lg-2 col-form-label">Reconcile</label>
										<div class="col-lg-5">
											<select class="form-control" id="select_is_reconcile" name="select_is_reconcile">
												<option value="(0)" selected>Not Yet</option>
												<option value="(1)">Done</option>
												<option value="(0,1)">All</option>
											</select>
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
				<h3 id="nama_bank"></h3>
				<div class="table-responsive">
                    <table id="tblaglxxth" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th data-i18n="date"></th>
                                <th data-i18n="documentNumber"></th>
                                <th data-i18n="notes"></th>
                                <th data-i18n="Debit / Credit"></th>
                                <th data-i18n="amount"></th>
                                <th data-i18n="Reconcile"></th>
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
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/aglxxth_reconcile/fn/aglxxth_reconcile_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edtaglxxth, tblaglxxth, show_deleted_aglxxth = 0, id_aglxxth;
	// ------------- end of default variable
	var is_akunbertransaksi = 1, is_akunbernilai = 1, id_aakxxmh_old = 0;

	// get tableRelation
	tableRelation('aglxxth');

	$("#select_id_aakxxmh").select2({
		dropdownParent: $("#modalSFaglxxth"),
		placeholder : "Select",
		allowClear: true,
		multiple: false,
		ajax: {
			url: "../../models/aakxxmh/aakxxmh_fn_opt_child.php",
			dataType: 'json',
			data: function (params) {
				var query = {
					id_aakxxmh_old: id_aakxxmh_old,
					id_aakxxmh_parent: '12',
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
	});
	
	$(document).ready(function() {
		start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');	
		id_aakxxmh = $('#select_id_aakxxmh').val();
		is_reconcile = $('#select_is_reconcile').val();

		tblaglxxth = $('#tblaglxxth').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/aglxxth_reconcile/aglxxth_reconcile.php",
				type: 'POST',
				data: function (d){
					d.start_date = start_date;
					d.end_date = end_date;
					d.is_reconcile = is_reconcile;
					d.id_aakxxmh = id_aakxxmh;
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
				{ data: "id",visible:false },
				{ data: "tanggal" },
				{ data: "kode_transaksi" },
				{ data: "keterangan" },
				{ data: "debit_kredit" },
				{ 
					data: "amount" ,
					...renderNumber(2)
				},
				{ 
					data: "is_reconcile",
					render: function(data, type, row) {
						if (data == 1) {
							return '<i class="fa fa-check text-navy" style="margin-right: 10px;"></i> ' +
									'<button class="btn btn-danger btn-sm cancel-btn" data-id="' + row.id + '">Cancel</button>';
						} else {
							return '<button class="btn btn-primary btn-sm recon-btn" data-id="' + row.id + '">Recon</button>';
						}
					}
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_aglxxth';
					$table       = 'tblaglxxth';
					$edt         = 'edtaglxxth';
					$show_status = '_aglxxth';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= ['sf', 'sp', 'sb'];
					$arr_buttons_action 	= [];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
				// END breaking generate button
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			}
		} );

		tblaglxxth.searchPanes.container().appendTo('#spaglxxth');
		tblaglxxth.searchBuilder.container().appendTo( '#sbaglxxth' );

		$('#tblaglxxth tbody').on('click', '.recon-btn', function() {
			let id = $(this).data('id');
			reconcile(id, 1);
		});

		$('#tblaglxxth tbody').on('click', '.cancel-btn', function() {
			let id = $(this).data('id');
			reconcile(id, 0);
		});

		
		tblaglxxth.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblaglxxth);
		} );
		
		tblaglxxth.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			// siVarSet('aglxxth');

			// atur hak akses
			CekSelectHeaderH(tblaglxxth);
		} );

		tblaglxxth.on( 'deselect', function () {
			// reset variable standar framework
			// siVarReset('aglxxth');

			// atur hak akses
			CekDeselectHeaderH(tblaglxxth);
		} );

		// END aglxxth

		// BEGIN form filter
		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
				start_date: {
					required: true,
					validDate: "DD MMM YYYY"
				},
				end_date: {
					required: true,
					validDate: "DD MMM YYYY"
				}
			},
			messages: {
				start_date: {
					required: "Start Date Wajib Diisi!"
				},
				end_date: {
					required: "End Date Wajib Diisi!"
				}
			},
			submitHandler: function(frmFilter) {
				start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				id_aakxxmh = $('#select_id_aakxxmh').val();
				is_reconcile = $('#select_is_reconcile').val();
				autofillField('aakxxmh', id_aakxxmh, 'CONCAT(kode, " - ", nama) nama');
				nama = autofillData.nama;
				$('#nama_bank').html(nama+' <br>'+ $('#start_date').val() + ' - ' + $('#end_date').val());
				
				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
				tblaglxxth.rows().deselect();
				tblaglxxth.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSFaglxxth').modal('toggle');
			}, false);
				return false;
			}
		});
		// END form filter
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
