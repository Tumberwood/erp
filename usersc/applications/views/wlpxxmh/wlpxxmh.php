<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'wlpxxmh';
    $nama_tabels_d 	= [];
    $nama_tabels_d[0] = 'iivxxrd';
?>

<!-- begin content here -->
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content"><div class="modal" id="modalSFwlpxxmh" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog modal-lg">
						<div class="modal-content animated bounceInRight">
							<form class="form-horizontal" id="frmFilter">
								<div class="modal-header">
									<h4 class="modal-title">Filter</h4>
								</div>
								<div class="modal-body">
									<div class="form-group row" id="input_jenis">
										<label class="col-lg-2 col-form-label">Status</label>
										<div class="col-lg-5">
											<div class="input-group">
												<select class="form-control" id="is_in_use" name="is_in_use">
													<option value="0">Open</option>
													<option value="1">In Use</option>
												</select>
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
                    <table id="tblwlpxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>LPN</th>
                                <th>Status</th>
                                <th>TX</th>
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
				<li><a class="nav-link active" data-toggle="tab" href="#tabiivxxrd_1"> Item</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" id="tabiivxxrd_1" class="tab-pane active">
					<div class="panel-body">
						<div class="table-responsive">
							<table id="tbliivxxrd" class="table table-striped table-bordered table-hover nowrap" width="100%">
								<thead>
									<tr>
										<th>Item Code</th>
										<th>Item Name</th>
										<th>Batch Number</th>
										<th>Expired Date</th>
									</tr>
								</thead>
							</table>
						</div> <!-- end of table -->

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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/wlpxxmh/fn/wlpxxmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edtwlpxxmh, tblwlpxxmh, show_deleted_wlpxxmh = 0, id_wlpxxmh;
	var edtiivxxrd, tbliivxxrd, show_deleted_iivxxrd = 0, id_iivxxrd;
	// ------------- end of default variable
	
	var selectedIds;
	var wlpxxmh_kode = '';

	// get tableRelation
	tableRelation('wlpxxmh');

	$(document).ready(function() {
		// BEGIN wlpxxmh
		is_in_use =  $('#is_in_use').val();
		
		edtwlpxxmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/wlpxxmh/wlpxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_wlpxxmh = show_deleted_wlpxxmh;
					d.is_in_use = is_in_use;
				}
			},
			table: "#tblwlpxxmh",
			fields: [ 
				{
					label: "wlpxxmh.start_at",
					name: "wlpxxmh.start_at",
					type: "hidden"
				},	
				{
					label: "wlpxxmh.finish_at",
					name: "wlpxxmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "wlpxxmh",
					type: "hidden"
				},	
				{
					label: "wlpxxmh.transaction_state",
					name: "wlpxxmh.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: "Kode <sup class='text-danger'>*<sup>",
					name: "wlpxxmh.kode"
				}, 	
				{
					label: "Keterangan",
					name: "wlpxxmh.keterangan",
					type: "textarea"
				}
			]
		} );
		
		edtwlpxxmh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtwlpxxmh.field('wlpxxmh.start_at').val(start_at);

			if(action == 'create'){
				tblwlpxxmh.rows().deselect();
			}
		});

		edtwlpxxmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			// edtFormButtonSaveConfirmHD();
		});
		
		edtwlpxxmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				kode = edtwlpxxmh.field('wlpxxmh.kode').val();

				validasiRequired(
					edtwlpxxmh,
					'wlpxxmh',
					{
						'kode': kode,
					}
				);

				validasiUnique(
					action,
					edtwlpxxmh,
					'wlpxxmh',
					'kode',
					'kode',
					'"'+kode+'"',
					id_wlpxxmh
				);
			}
			
			if ( edtwlpxxmh.inError() ) {
				return false;
			}
		});

		edtwlpxxmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtwlpxxmh.field('wlpxxmh.finish_at').val(finish_at);
		});
		
		edtwlpxxmh.on( 'postSubmit', function (e, json, data, action, xhr) {
			// event setelah Create atau Edit, dibedakan dari parameter action
			// action : "create" | "edit"
			// do something
		} );

		edtwlpxxmh.on( 'close', function () {
			edtwlpxxmh.enable();
		} );
		
		tblwlpxxmh = $('#tblwlpxxmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-2',
			},
			ajax: {
				url: "../../models/wlpxxmh/wlpxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_wlpxxmh = show_deleted_wlpxxmh;
					d.is_in_use = is_in_use;
				}
			},
			order: [[ 1, "asc" ]],
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
					targets: [0]
				}
			],
			columns: [
				{ data: "wlpxxmh.id",visible:false },
				{ data: "wlpxxmh.kode" },
				{ 
					data: "wlpxxmh.is_nextprocess" ,
					render: function (data) {
						if (data == 1){
							return '<span class="badge badge-primary">In Use</span>';
						}else if (data == 0){
							return '<span class="badge badge-plain">Open</span>';
						}else{
							return '<span class="badge badge-plain">Open</span>';
						}
					}
				},
				{ 
					data: "wlpxxmh.transaction_state" ,
					...renderTransactionStatus()
				},
			],
			buttons: [

				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_wlpxxmh';
					$table       = 'tblwlpxxmh';
					$edt         = 'edtwlpxxmh';
					$show_status = '_wlpxxmh';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= ['sf','sp', 'sb'];
					$arr_buttons_action 	= ['create', 'edit', 'remove_hd', 'confirm', 'nonaktif_hd', 'close', 'view', 'log','noaction'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
				// END breaking generate button
				
				{
					text: '<i class="fa fa-google"></i>',
					name: 'btnCustom',
					className: 'btn btn-outline',
					titleAttr: 'Generate LPN',
					action: function ( e, dt, node, config ) {
						// e.preventDefault();
						var lpnJumlah = prompt("Generate Berapa LPN?", 1);
						if( typeof parseInt(lpnJumlah) === "number" && parseInt(lpnJumlah) > 0 ){
							$.ajax( {
								url: "../../models/wlpxxmh/wlpxxmh_fn_generate.php",
								dataType: 'json',
								type: 'POST',
								data: {
									lpnJumlah: parseInt(lpnJumlah)
								},
								success: function ( json ) {
									full_message = '';
									status_code  = json.data.status_code;
									full_message = full_message + json.data.message + '</br>';
									toast_type   = json.data.type_message;
									toastr[toast_type](full_message, 'INFO');
									tblwlpxxmh.ajax.reload(null, false);
								}
							} );
						}
						
					}
				},
				{
					text: '<i class="fa fa-print"></i>',
					name: 'btnPrint',
					className: 'btn btn-outline',
					titleAttr: 'Print LPN',
					action: function ( e, dt, node, config ) {
						e.preventDefault();
						var queryString = selectedIds.join(',');
						var url = $(this).attr('href'); 
						window.open('wlpxxmh_print.php?ids_wlpxxmh='+queryString, '_blank');
					}
				},
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
				if ( data.wlpxxmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.wlpxxmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblwlpxxmh.searchPanes.container().appendTo('#spwlpxxmh');
		tblwlpxxmh.searchBuilder.container().appendTo( '#sbwlpxxmh' );
		
		tblwlpxxmh.on( 'init', function () {
			// atur hak akses
			tbl_details = [tbliivxxrd];
			CekInitHeaderHD(tblwlpxxmh, tbl_details);
		} );
		
		tblwlpxxmh.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('wlpxxmh');
			selectedIds = getSelectedRowIds();

			wlpxxmh_kode      = wlpxxmh_data.kode;
			
			// atur hak akses
			tbl_details = [tbliivxxrd];
			CekSelectHeaderHD(tblwlpxxmh, tbl_details);
			
			if (transaction_state == 1) {
				tblwlpxxmh.button('btnConfirm:name')
				.nodes()
				.css( 'display', 'none' );
			} else {
				tblwlpxxmh.button('btnConfirm:name')
				.nodes()
				.css( 'display', 'block' );
			}
		} );
		
		tblwlpxxmh.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('wlpxxmh');
			var selectedIds = getSelectedRowIds();
			wlpxxmh_kode = '';

			// atur hak akses
			tbl_details = [tbliivxxrd];
			CekDeselectHeaderHD(tblwlpxxmh, tbl_details);
		} );

		// BEGIN form filter
		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
			},
			submitHandler: function(frmFilter) {
				is_in_use =  $('#is_in_use').val();
				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
				tblwlpxxmh.rows().deselect();
				tblwlpxxmh.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSFwlpxxmh').modal('toggle');
			}, false);
				return false;
			}
		});
		// END wlpxxmh

		tbliivxxrd = $('#tbliivxxrd').DataTable( {
			ajax: {
				url: "../../models/wlpxxmh/iivxxrd_wlpxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_iivxxrd = show_deleted_iivxxrd;
					d.wlpxxmh_kode = wlpxxmh_kode;
				},
			},
			order: [[ 1, "asc" ]],
			columns: [
				{ data: "iimxxmh_kode" },
				{ data: "iimxxmh_nama" },
				{ data: "batch_number" },
				{ data: "expired_date" },
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_iivxxrd';
					$table       = 'tbliivxxrd';
					$edt         = 'edtiivxxrd';
					$show_status = '_iivxxrd';
					$table_name  = $nama_tabels_d[0];

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= [];
					$arr_buttons_action 	= [];
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
		// END iivxxrd
		
	} );// end of document.ready
	
</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
