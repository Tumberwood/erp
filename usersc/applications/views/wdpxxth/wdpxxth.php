<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'wdpxxth';
	$nama_tabels_d = [];
?>

<div class="row">
    <div class="col">
        <div class="ibox" id="iboxfilter">
            <div class="ibox-title">
                <h5 class="text-navy">Filter</h5>&nbsp
                <button class="btn btn-primary btn-xs collapse-link"><i class="fa fa-chevron-up"></i></button>
            </div>
            <div class="ibox-content">
                <form class="form-horizontal" id="frmFilter">
					<div class="form-group row">
						<label class="col-lg-2 col-md-2">Kode Picking</label>
						<div class="col-lg-4 col-sm-4">
							<select class="form-control" id="selectKode" name="selectKode" multiple="multiple"></select>
						</div>
					</div>
                    <!-- <div class="form-group row">
                        <div class="col-lg-4">
                            <button class="btn btn-primary" type="submit" id="go">Submit</button>
                        </div>
                    </div> -->
                </form>
				
            </div>
        </div>
    </div>
</div>


<div class="ibox" id="tableLPN" style="display: none">
	<div class="ibox-content">
		
		<div class="modal" id="modalLPN" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content animated bounceInRight">
					<div class="modal-header">
						<h4 class="modal-title">Dispatch</h4>
					</div>
					<div class="modal-body">
						<div class="row" id="konten">
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
	
		<div class="table-responsive">
			<table id="tblwdpxxth" class="table table-striped table-bordered table-hover nowrap" width="100%">
				<thead>
					<tr>
						<th>ID</th>
						<th>id_wdoxxth</th>
						<th>status_dispatch_number</th>
						<th>LPN</th>
						<th>Location</th>
						<th>Kode</th>
						<th>Item Code</th>
						<th>Item Name</th>
						<th>UoM</th>
						<th>Jumlah Pick</th>
						<th>Jumlah Dispatch</th>
						<th>Jumlah Sisa</th>
						<th>Status Dispatch</th>
						<th>Batch Number</th>
						<th>Expired Date</th>
					</tr>
				</thead>
				<tfoot>
					<th></th>
					<th></th>
					<th></th>
					<th></th>
					<th>Total</th>
					<th></th>
					<th></th>
					<th></th>
					<th></th>
					<th id="s_9"></th>
					<th id="s_10"></th>
					<th id="s_11"></th>
					<th></th>
					<th></th>
					<th></th>
				</tfoot>
			</table>
		</div>
	</div>
</div>
<br>

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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/wdpxxth/fn/wdpxxth_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
		cekNotification();
		// ------------- default variable, do not erase
		var edtwdpxxth, tblwdpxxth, show_deleted_wdpxxth = 0, id_wdpxxth;
		// ------------- end of default variable
		var id_wpclptd = 0;
		var id_wpcxxth_old = 0;
		var selectedValues = 0;
		var start_at = "";
		var wloxxmh_out_nama = "";
		var finish_at = "";
		var confirm_at = "";

		// get tableRelation
		tableRelation('wdpxxth');
		
		$("#selectKode").select2({
			placeholder : "Select",
			allowClear: true,
			multiple: false,
			ajax: {
				url: "../../models/wpcxxth/wpcxxth_fn_opt_dispatch.php",
				dataType: 'json',
				data: function (params) {
					var query = {
						id_wpcxxth_old: id_wpcxxth_old,
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
			}
		});

		$(document).ready(function() {

			tblwdpxxth = $('#tblwdpxxth').DataTable( {
				ajax: {
					url: "../../models/wdpxxth/wdpxxth_iivxxrd_table.php",
					type: 'POST',
					data: function (d){
						d.id_wpcxxth_old = id_wpcxxth_old;
					}
				},
				order: [[ 2, "asc" ]],
				columns: [
					{ data: "id",visible:false },
					{ data: "id_wpcxxth",visible:false },
					{ 
						data: "status_dispatch",visible:false },
					{ data: "wlpxxmh_kode",visible:false},
					{ data: "wloxxmh_nama",visible:false },
					{ data: "kode_pl_d",visible:false },
					{ data: "iimxxmh_kode" },
					{ data: "iimxxmh_nama" },
					{ data: "uom_pl" },
					{ 
						data: "jumlah_pl",
						...renderNumber( 0, "")
					},
					{ 
						data: "jumlah_p",
						...renderNumber( 0, "")
					},
					{ 
						data: "jumlah_default_os",
						...renderNumber( 0, "")
					},
					{
						data: "status_dispatch",
						render: function (data) {
							if (data == 1){
								return '<span class="badge badge-plain">Open</span>';
							}else if (data == 2){
								return '<span class="badge badge-warning">Parsial</span>';
							}else if(data == 3){
								return '<span class="badge badge-primary">Full</span>';
							} else {
								return '<span class="badge badge-plain">INVALID DATA</span>';
							}
						}
					},
					{ data: "batch_number" },
					{ data: "expired_date" },
				],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_wdpxxth';
						$table       = 'tblwdpxxth';
						$edt         = 'edtwdpxxth';
						$show_status = '_wdpxxth';
						$table_name  = $nama_tabel;

						$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
						$arr_buttons_tools2 	= [];
						$arr_buttons_action 	= [];
						include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php';
					?>
					// END breaking generate button
					{ 
						text: '<i class="fa fa-save"></i>&nbsp;Confirm',
						name: 'btnConfirmDispatch',
						className: 'btn btn-warning',
						titleAttr: 'Confirm',
						action: function ( e, dt, node, config ) {
							var rowData = dt.row(0).data();
            
							if (rowData) {
								wloxxmh_out_nama = rowData.wloxxmh_out_nama;
								// console.log('wloxxmh_out_nama from first row:', wloxxmh_out_nama);
								confirmData();
							} else {
								alert('No data available in the table.');
							}
						}
					},
				],
				initComplete: function() {
					this.api().searchPanes.rebuildPane();
				},
				rowCallback: function( row, data, index ) {
				},
				footerCallback: function ( row, data, start, end, display ) {
					var api = this.api();
					var numFormat = $.fn.dataTable.render.number( '\,', '.', 0, '' ).display; 
					
					for (var i = 9; i <= 11; i++) {
						var columnIndex = i;
						var sum_all = api.column(columnIndex).data().sum();
						// Bisa dilakukan sum berdasarkan paginasi (sum per paginasi / tidak sum semua data) dengan menambahkan { page: 'current' }
						var sum = api.column(columnIndex, { page: 'current' }).data().sum();
						$('#s_' + columnIndex).html(numFormat(sum_all));

						// console.log('Number of Pages: ' + api.page.info().pages);
					}
				}
			} );

			tblwdpxxth.on( 'init', function () {
				// atur hak akses
				// CekInitHeaderH(tblwdpxxth);
				cekDetailSubmit();
			} );

			tblwdpxxth.on( 'draw', function () {
				// atur hak akses
				// CekInitHeaderH(tblwdpxxth);
				cekDetailSubmit();
				cekDetailSubmit();
			} );
			
			tblwdpxxth.on( 'select', function( e, dt, type, indexes ) {
				var selectedRowData = tblwdpxxth.rows({ selected: true }).data()[0];
				if (selectedRowData) {
					// console.log('Selected ID:', selectedRowData.id);
					id_wpclptd = selectedRowData.id;
					$('#modalLPN').modal('toggle');
					generateKonten();
					setTimeout(function() {
						$(`#input_jumlah${id_wpclptd}`).focus();
					}, 800);
				}
			} );

			tblwdpxxth.on( 'deselect', function () {
				id_wpclptd = 0;
				$('#konten').empty();
				// siVarReset('wdpxxth');

				// atur hak akses
				// CekDeselectHeaderH(tblwdpxxth);
			} );
			// tblwdpxxth.searchPanes.container().appendTo('#spwdpxxth');
			// tblwdpxxth.searchBuilder.container().appendTo( '#sbwdpxxth' );
			// END wdpxxth
			
			$('#selectKode').change(function() {
				// Get selected values
				selectedValues = $(this).val();
				
				$('#selectKode').prop('disabled', true);
				// Log selected values
				id_wpcxxth_old  = $('#selectKode').val();
				tblwdpxxth.ajax.reload(null, false);
				//Jika dipilih kodenya maka akan ada flag bahwa kode picking ini masih digunakan
				isDispatchUsed(id_wpcxxth_old, 1);
				$('#tableLPN').show();
				// generateKonten();
				$('#iboxfilter').addClass('collapsed');
				
				//event jika direload, maka flag used jadi 0 lagi
				$(window).on('unload', function() {
					isDispatchUsed(id_wpcxxth_old, 0);
				});
			});

		} );// end of document.ready
	
	</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
