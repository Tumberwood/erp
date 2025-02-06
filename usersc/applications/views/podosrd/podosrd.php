<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'prqittd';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">

				<div class="modal" id="modalSFprqittd" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog modal-lg">
						<div class="modal-content animated bounceInRight">
							<form class="form-horizontal" id="frmFilter">
								<div class="modal-header">
									<h4 class="modal-title">Filter</h4>
								</div>
								<div class="modal-body">
									<div class="form-group row">
										<label class="col-lg-2 col-form-label">Tanggal PO</label>
										<div class="col-lg-5">
											<div class="input-group input-daterange" id="periode_po">
												<input type="text" id="start_date_po" class="form-control">
												<div class="input-group-addon">
													<span class="fa fa-calendar"></span>
												</div>
												<input type="text" id="end_date_po" class="form-control">
											</div>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-lg-2 col-form-label">Tanggal GR</label>
										<div class="col-lg-5">
											<div class="input-group input-daterange" id="periode_prc">
												<input type="text" id="start_date_prc" class="form-control">
												<div class="input-group-addon">
													<span class="fa fa-calendar"></span>
												</div>
												<input type="text" id="end_date_prc" class="form-control">
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
                    <table id="tblprqittd" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Purchase Order</th>
                                <th>Tanggal PO</th>
                                <th>Tanggal GR</th>
                                <th>Goods Receive</th>
                                <th>Item PO</th>
                                <th>Item Code</th>
                                <th>Item GR</th>
                                <th>PO Qty</th>
                                <th>PO UoM</th>
                                <th>GR Qty</th>
                                <th>GR UoM</th>
                                <th>Pemenuhan (Hari)</th>
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
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn2.js"></script>
<script src="<?=$us_url_root?>usersc/helpers/language.js"></script>
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/podosrd/fn/podosrd_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtprqittd, tblprqittd, show_deleted_prqittd = 0, id_prqittd;
	// ------------- end of default variable
	
	// BEGIN datepicker init
	$('#periode_prc').datepicker({
		setDate: new Date(),
		autoclose: true,
		todayHighlight: true,
		clearBtn: true,
		format: "dd M yyyy",
		minViewMode: 'month' 
	});
	// $('#start_date_prc').datepicker('setDate', awal_tahun_dmy);
	// $('#end_date_prc').datepicker('setDate', today_add_m_dmy);
	// END datepicker init
	
	// BEGIN datepicker init
	$('#periode_po').datepicker({
		setDate: new Date(),
		autoclose: true,
		todayHighlight: true,
		clearBtn: true,
		format: "dd M yyyy",
		minViewMode: 'month' 
	});
	$('#start_date_po').datepicker('setDate', awal_tahun_dmy);
	$('#end_date_po').datepicker('setDate', today_add_m_dmy);
	// END datepicker init

	$(document).ready(function() {
		start_date_prc = moment($('#start_date_prc').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date_prc = moment($('#end_date_prc').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		
		start_date_po = moment($('#start_date_po').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date_po = moment($('#end_date_po').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		
		//start datatables
		tblprqittd = $('#tblprqittd').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/podosrd/podosrd.php",
				type: 'POST',
				data: function (d){
					d.start_date_po = start_date_po;
					d.end_date_po = end_date_po;
					d.start_date_prc = start_date_prc;
					d.end_date_prc = end_date_prc;
				}
			},
			order: [[ 1, "asc" ], [ 2, "asc" ]],
			columnDefs:[
				{
					searchPanes:{
						show: true,
					},
					targets: [1,2,3,5]
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
				{ data: "id",visible:false },
				{ data: "kode_po",visible:false },
				{ data: "tanggal_po" },
				{ data: "tanggal_prc" },
				{ data: "kode_prc" },
				{ data: "item_po" },
				{ data: "item_code" },
				{ data: "item_prc" },
				{ 
					data: "qty_po",
					...renderNumber(0)
				},
				{ data: "uom_po" },
				{ 
					data: "qty_prc" ,
					...renderNumber(0)
				},
				{ data: "uom_prc" },
				{ 
					data: "pemenuhan" ,
					...renderNumber(0)
				},
			],
			rowGroup: {
				dataSrc: function (row) {
					return  row.kode_po
				},
				endRender: function (rows, group) {
					
				}
			},
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_prqittd';
					$table       = 'tblprqittd';
					$edt         = 'edtprqittd';
					$show_status = '_prqittd';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= ['sf','sp', 'sb'];
					$arr_buttons_action 	= [];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
				// END breaking generate button
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			}
		} );

		tblprqittd.searchPanes.container().appendTo('#spprqittd');
		tblprqittd.searchBuilder.container().appendTo( '#sbprqittd' );
		
		tblprqittd.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblprqittd);
		} );
		
		tblprqittd.on( 'select', function( e, dt, type, indexes ) {
			prqittd_data    		= tblprqittd.row( { selected: true } ).data();
			id_prqittd      		= prqittd_data.id;
			console.log(id_prqittd);

			// atur hak akses
			CekSelectHeaderH(tblprqittd);
		} );

		tblprqittd.on( 'deselect', function () {
			// reload dipanggil di function CekDeselectHeader
			id_prqittd = 0;

			// atur hak akses
			CekDeselectHeaderH(tblprqittd);
		} );
		
		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
			},
			submitHandler: function(frmFilter) {
				start_date_prc = moment($('#start_date_prc').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date_prc = moment($('#end_date_prc').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				start_date_po = moment($('#start_date_po').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date_po = moment($('#end_date_po').val(), 'DD MMM YYYY').format('YYYY-MM-DD');

				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
				tblprqittd.rows().deselect();
				tblprqittd.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSFprqittd').modal('toggle');
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
