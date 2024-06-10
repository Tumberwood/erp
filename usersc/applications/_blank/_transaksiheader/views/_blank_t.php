<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = '_blank_t';
	$nama_tabels_d = [];

	// BEGIN single data view
	if (isset($_GET['rowid']) && $_GET['rowid'] > 0) {
		$rowid = $_GET['rowid'];
	} else {
		$rowid = 0;
	}
	// END single data view
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="modal" id="modalSF_blank_t" tabindex="-1" role="dialog" aria-hidden="true">
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
                    <table id="tbl_blank_t" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Kode</th>
                                <th>Nama</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/_blank_t/fn/_blank_t_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edt_blank_t, tbl_blank_t, show_deleted__blank_t = 0, id__blank_t;
	var rowid = <?php echo $rowid; ?>;
	// ------------- end of default variable

	// get tableRelation
	tableRelation('_blank_theader');
	
	$(document).ready(function() {
		start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		
		// BEGIN _blank_t
		edt_blank_t = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/_blank_t/_blank_t.php",
				type: 'POST',
				data: function (d){
					d.show_deleted__blank_t = show_deleted__blank_t;
					d.start_date = start_date;
					d.end_date = end_date;
					d.rowid = rowid;
				}
			},
			table: "#tbl_blank_t",
			fields: [ 
				{
					label: "_blank_t.start_at",
					name: "_blank_t.start_at",
					type: "hidden"
				},	
				{
					label: "_blank_t.finish_at",
					name: "_blank_t.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "_blank_t",
					type: "hidden"
				},	
				{
					label: "_blank_t.transaction_state",
					name: "_blank_t.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "Kode <sup class='text-danger'>*<sup>",
					name: "_blank_t.kode"
				}, 	
				{
					label: "Nama <sup class='text-danger'>*<sup>",
					name: "_blank_t.nama"
				}, 	
				{
					label: "Keterangan",
					name: "_blank_t.keterangan",
					type: "textarea"
				}
			]
		} );

		edt_blank_t.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edt_blank_t.field('_blank_t.start_at').val(start_at);
			
			if(action == 'create'){
				tbl_blank_t.rows().deselect();
			}
		});

		edt_blank_t.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edt_blank_t.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				kode = edt_blank_t.field('_blank_t.kode').val();
				nama = edt_blank_t.field('_blank_t.nama').val();

				validasiRequired(
					edt_blank_t,
					'_blank_t',
					{
						'kode': kode,
						'nama': nama
					}
				);

				validasiUnique(
					action,
					edt_blank_t,
					'_blank_t',
					'kode',
					'kode',
					'"'+kode+'"',
					id__blank_t
				);

				validasiUnique(
					action,
					edt_blank_t,
					'_blank_t',
					'nama',
					'nama',
					'"'+nama+'"',
					id__blank_t
				);
			}
			
			if ( edt_blank_t.inError() ) {
				return false;
			}
		});
		
		edt_blank_t.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edt_blank_t.field('_blank_t.finish_at').val(finish_at);
		});

		edt_blank_t.on( 'close', function () {
			edt_blank_t.enable();
		} );

		tbl_blank_t = $('#tbl_blank_t').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/_blank_t/_blank_t.php",
				type: 'POST',
				data: function (d){
					d.show_deleted__blank_t = show_deleted__blank_t;
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
					targets: [1,2,3]
				},
				{
					searchPanes:{
						show: false,
					},
					targets: [0]
				}
			],
			columns: [
				{ data: "_blank_t.id",visible:false },
				{ data: "_blank_t.kode" },
				{ data: "_blank_t.nama" },
				{ data: "_blank_t.keterangan" },
				{ 
					data: "_blank_t.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id__blank_t';
					$table       = 'tbl_blank_t';
					$edt         = 'edt_blank_t';
					$show_status = '__blank_t';
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
				if ( data._blank_t.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data._blank_t.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tbl_blank_t.searchPanes.container().appendTo('#sp_blank_t');
		tbl_blank_t.searchBuilder.container().appendTo( '#sb_blank_t' );
		
		tbl_blank_t.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tbl_blank_t);
		} );
		
		tbl_blank_t.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('_blank_t');

			// atur hak akses
			CekSelectHeaderH(tbl_blank_t);
		} );

		tbl_blank_t.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('_blank_t');

			// atur hak akses
			CekDeselectHeaderH(tbl_blank_t);
		} );

		// END _blank_t

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
				tbl_blank_t.rows().deselect();
				tbl_blank_t.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSF_blank_t').modal('toggle');
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
