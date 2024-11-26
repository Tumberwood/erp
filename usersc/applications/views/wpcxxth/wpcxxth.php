<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'wpcxxth';
	$nama_tabels_d = [];
?>

<div class="modal" id="modalFloatingFilter" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content animated bounceInRight">
			<form class="form-horizontal" id="frmFilter">
				<div class="modal-header">
					<h4 class="modal-title">Filter</h4>
				</div>
				<div class="modal-body">
					<div class="form-group row">
						<label class="col-lg-2 col-md-2">Kode Picking</label>
						<div class="col-lg-4 col-sm-4">
							<select class="form-control" id="selectKode" name="selectKode" multiple="multiple"></select>
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

<div class="ibox" id="tableLPN" style="display: none">
	<div class="ibox-content">
		
		<div class="modal" id="modalLPN" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog modal-lg">
				<div class="modal-content animated bounceInRight">
					<div class="modal-header">
						<h4 class="modal-title">Picking</h4>
					</div>
					<div class="modal-body">
						<div class="row" id="konten">
						</div>
					</div>
					<div class="modal-footer btnLPN">
						<button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>

		
		<div class="modal" id="modalDispatch" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog modal-lg">
				<div class="modal-content animated bounceInRight">
					<div class="modal-header">
						<h4 class="modal-title" id="h4_dispatch"></h4>
					</div>
					<div class="modal-body">
						<div class="row" id="kontenDispatch">
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary submit-button" id="confirmInput" onClick="confirmData()" style="display: none">Submit</button>
						<button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
	
		<div class="table-responsive">
			<table id="tblwpcxxth" class="table table-striped table-bordered table-hover nowrap" width="100%">
				<thead>
					<tr>
						<th>id_wpllptd</th>
						<th>id_wktlptd</th>
						<th>id_wdoxxth</th>
						<th>status_picking_number</th>
						<th>LPN</th>
						<th>Location</th>
						<th>Item Code</th>
						<th>Item Name</th>
						<th>UoM</th>
						<th id="jumlah_asal"></th>
						<th>Jumlah Pick</th>
						<th>Jumlah Sisa</th>
						<th>Status Picking</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/wpcxxth/fn/wpcxxth_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
		cekNotification();
		// ------------- default variable, do not erase
		var edtwpcxxth, tblwpcxxth, show_deleted_wpcxxth = 0, id_wpcxxth;
		// ------------- end of default variable
		var id_wpllptd = 0;
		var id_wktlptd = 0;
		var id_wpcxxth_old = 0;
		var selectedValues = 0;
		var start_at = "";
		var wloxxmh_out_nama = "";
		var finish_at = "";
		var confirm_at = "";
		var uniqueToken = '';


		// get tableRelation
		tableRelation('wpcxxth');
		
		//Aktivasi Filter Floating
		filterFloating();
		
		$("#selectKode").select2({
			placeholder : "Select",
			allowClear: true,
			multiple: false,
			ajax: {
				url: "../../models/wpcxxth/wpcxxth_fn_opt.php",
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
			function resetInput() {
				$('#locDispatch').val('');
            	$('#confirmInput').hide();
			}

			$('#modalDispatch').on('hidden.bs.modal', function (e) {
				resetInput();
			});
			tblwpcxxth = $('#tblwpcxxth').DataTable( {
				ajax: {
					url: "../../models/wpcxxth/wpcxxth_iivxxrd_table.php",
					type: 'POST',
					data: function (d){
						d.id_wpcxxth_old = id_wpcxxth_old;
						d.uniqueToken = uniqueToken;
					}
				},
				order: [[ 2, "asc" ], [4, "asc"]],
				columns: [
					{ data: "id_wpllptd",visible:false },
					{ data: "id_wktlptd",visible:false },
					{ data: "id_wpcxxth",visible:false },
					{ 
						data: "status_picking",visible:false },
					{ data: "wlpxxmh_kode",visible:false },
					{ data: "wloxxmh_nama",visible:false },
					{ data: "iimxxmh_kode" },
					{ data: "iimxxmh_nama" },
					{ data: "uom_pl" },
					{ 
						data: "jumlah_default_os",
						...renderNumber( 0, "")
					},
					{ 
						data: "jumlah_default_now",
						...renderNumber( 0, "")
					},
					{ 
						data: "sisa_default",
						...renderNumber( 0, "")
					},
					{
						data: "status_picking",
						render: function (data) {
							if (data == 1){
								return '<span class="badge badge-lain">Open</span>';
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
						$id_table    = 'id_wpcxxth';
						$table       = 'tblwpcxxth';
						$edt         = 'edtwpcxxth';
						$show_status = '_wpcxxth';
						$table_name  = $nama_tabel;

						$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
						$arr_buttons_tools2 	= [];
						$arr_buttons_action 	= [];
						include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php';
					?>
					// END breaking generate button
					{ 
						text: '<i class="fa fa-save"></i>&nbsp;Confirm',
						name: 'btnConfirmPicking',
						className: 'btn btn-warning',
						titleAttr: 'Confirm',
						action: function ( e, dt, node, config ) {
							var rowData = dt.row(0).data();
            
							if (rowData) {
								wloxxmh_out_nama = rowData.wloxxmh_out_nama;
								// console.log('wloxxmh_out_nama from first row:', wloxxmh_out_nama);
								$.ajax( {
									url: "../../models/wpcxxth/wpcxxth_fn_cek_confirm.php",
									dataType: 'json',
									type: 'POST',
									async: false,
									data: {
										id_wpcxxth_old: id_wpcxxth_old
									},
									success: function ( json ) {
										c_id_d = json.data.c_id_d;
										var isCanConfirm = 0;
										if (c_id_d > 0) {
											swal({
												text: 'Apakah Anda yakin? Terdapat '+c_id_d+' data dengan Status Picking belum Full',
												icon: "info",
												buttons: {
													cancel: true,
													confirm: true
												},
											})
											.then((willConfirm) => {
												if (willConfirm) {
													$('#modalDispatch').modal('toggle');
												} else {
													console.log('NOT OK');
												}
											});
										} else {
											$('#modalDispatch').modal('toggle');
										}
									}
								});
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

			tblwpcxxth.on( 'init', function () {
				// atur hak akses
				// CekInitHeaderH(tblwpcxxth);
				cekDetailSubmit();
			} );

			tblwpcxxth.on( 'draw', function () {
				// atur hak akses
				// CekInitHeaderH(tblwpcxxth);
				cekDetailSubmit();
				cekDetailSubmit();
			} );
			
			tblwpcxxth.on( 'select', function( e, dt, type, indexes ) {
				var selectedRowData = tblwpcxxth.rows({ selected: true }).data()[0];
				if (selectedRowData) {
					// console.log('Selected ID:', selectedRowData.id);
					id_wpllptd = selectedRowData.id_wpllptd;
					id_wktlptd = selectedRowData.id_wktlptd;

					console.log(id_wpllptd);
					console.log(id_wktlptd);
					$('#modalLPN').modal('toggle');

					if (id_wpllptd > 0 && id_wktlptd == 0) {
						generateKonten();
						setTimeout(function() {
							$(`#locAsal${id_wpllptd}`).focus();
						}, 800);
					} else if (id_wktlptd > 0 && id_wpllptd == 0) {
						generateKontenKitting();
						setTimeout(function() {
							$(`#locAsal${id_wktlptd}`).focus();
						}, 800);
						
					}
				}
			} );

			tblwpcxxth.on( 'deselect', function () {
				id_wpllptd = 0;
				id_wktlptd = 0;
				$('#konten').empty();
				// siVarReset('wpcxxth');

				// atur hak akses
				// CekDeselectHeaderH(tblwpcxxth);
			} );
			// tblwpcxxth.searchPanes.container().appendTo('#spwpcxxth');
			// tblwpcxxth.searchBuilder.container().appendTo( '#sbwpcxxth' );
			// END wpcxxth
			
			$('#selectKode').change(function() {
				// Get selected values
				uniqueToken = "wpcxxth_" + generateUniqueToken();
				selectedValues = $(this).val();
				
				$('#selectKode').prop('disabled', true);
				// Log selected values
				id_wpcxxth_old  = $('#selectKode').val();
				autofillField('wpcxxth', id_wpcxxth_old, 'id_wplxxth, id_wktxxth');
				id_wktxxth = autofillData.id_wktxxth;
				id_wplxxth = autofillData.id_wplxxth;

				if (id_wplxxth > 0 && id_wktxxth == 0) {
					wloxxmh_out = "Dispatch";
					formModalDispatch(wloxxmh_out);
					$('#h4_dispatch').html(wloxxmh_out);
					$('#jumlah_asal').html('Jumlah PL');
				} else if (id_wplxxth == 0 && id_wktxxth > 0) {
					wloxxmh_out = "Lokasi Kitting";
					formModalDispatch(wloxxmh_out)
					$('#h4_dispatch').html(wloxxmh_out);
					$('#jumlah_asal').html('Jumlah Kitting');
				}
				console.log(wloxxmh_out);

				tblwpcxxth.ajax.reload(null, false);
				//Jika dipilih kodenya maka akan ada flag bahwa kode picking ini masih digunakan
				isPickingUsed(id_wpcxxth_old, 1, uniqueToken);
				$('#tableLPN').show();
				// generateKonten();
				$('#modalFloatingFilter').modal('toggle');
				
				//event jika direload, maka flag used jadi 0 lagi
				$(window).on('unload', function() {
					isPickingUsed(id_wpcxxth_old, 0, uniqueToken);
				});
			});

		} );// end of document.ready
	
	</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
