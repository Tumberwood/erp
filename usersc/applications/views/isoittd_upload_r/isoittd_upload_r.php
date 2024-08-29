<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'isoittd_upload';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div id="tabel_atas">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				
			<div class="modal" id="modalSFisoittd_upload" tabindex="-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog modal-lg">
					<div class="modal-content animated bounceInRight">
						<form class="form-horizontal" id="frmFilter">
							<div class="modal-header">
								<h4 class="modal-title">Filter</h4>
							</div>
							<div class="modal-body">
								<div class="form-group row">
									<label class="col-lg-2 col-md-2">Kode</label>
									<div class="col-lg-8 col-sm-8">
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
			
				<div class="table-responsive">
						<table id="tblisoittd_upload" class="table table-striped table-bordered table-hover nowrap" width="100%">
							<thead>
								<tr>
									<th>ID</th>
									<th>Kode SOU</th>
									<th>Loc</th>
									<th>LPN</th>
									<th>SKU</th>
									<th>Name</th>
									<th>Batch</th>
									<th>ED</th>
									<th>UoM</th>
									<th>Quantity</th>
									<th>Fisik</th>
									<th>Selisih</th>
									<th>Transaksi In</th>
									<th>Transaksi Out</th>
									<th>Selisih Final</th>
									<th>Qty Penjelasan</th>
									<th>SKIP</th>
									<th>Hitung</th>
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
?>

<!-- BEGIN JS -->
<?php 
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_load.php';
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_setup.php';
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_datatables_load.php'; 
?>

<script src="<?=$us_url_root?>usersc/helpers/general_fn.js"></script>
<script src="<?=$us_url_root?>usersc/helpers/validation_fn.js"></script>
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn.js"></script>

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/isoittd_upload_r/fn/isoittd_upload_r_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
		cekNotification();
		// ------------- default variable, do not erase
		var edtisoittd_upload, tblisoittd_upload, show_deleted_isoittd_upload = 0, id_isoittd_upload;
		// ------------- end of default variable
		var id_isoxxth_upload_filter = 0;
		var qty_penjelasan = 0;
		var keterangan_penjelasan = '';

		tableRelation('isoittd_upload');
		
		$("#selectKode").select2({
			placeholder : "Select",
			allowClear: true,
			multiple: false,
			ajax: {
				url: "../../models/isoxxth_upload/isoxxth_upload_parent_fn_opt.php",
				dataType: 'json',
				data: function (params) {
					var query = {
						id_isoxxth_upload_old: id_isoxxth_upload_filter,
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
		// get tableRelation
		// tableRelation('isoittd_uploadheader');
		
		$(document).ready(function() {
			
			edtisoittd_upload = new $.fn.dataTable.Editor( {
				ajax: {
					url: "../../models/isoittd_upload_r/isoittd_upload_r.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_isoittd_upload = show_deleted_isoittd_upload;
						d.id_isoxxth_upload_filter = id_isoxxth_upload_filter;
					}
				},
				table: "#tblisoittd_upload",
				fields: [ 
					{
						label: "isoittd_upload.start_at",
						name: "isoittd_upload.start_at",
						type: "hidden"
					},	
					{
						label: "isoittd_upload.finish_at",
						name: "isoittd_upload.finish_at",
						type: "hidden"
					},	
					{
						label: "nama_tabel",
						name: "nama_tabel",
						def: "isoittd_upload",
						type: "hidden"
					},	
					{
						label: "isoittd_upload.transaction_state",
						name: "isoittd_upload.transaction_state",
						type: "hidden",
						def: 1
					},
					{
						label: "Qty Penjelasan <sup class='text-danger'>*<sup>", 
						name: "isoittd_upload.qty_penjelasan"
					}, 	
					{
						label: "Keterangan Penjelasan <sup class='text-danger'>*<sup>",
						name: "isoittd_upload.keterangan_penjelasan",
						type: "textarea"
					},
				]
			} );
			
			edtisoittd_upload.on( 'preOpen', function( e, mode, action ) {
				edtisoittd_upload.field('isoittd_upload.qty_penjelasan').val(qty_penjelasan);
				edtisoittd_upload.field('isoittd_upload.keterangan_penjelasan').val(keterangan_penjelasan);
			});

			edtisoittd_upload.on("open", function (e, mode, action) {
				$(".modal-dialog").addClass("modal-xl");
				$('div.DTE_Form_Buttons button:eq(2)').hide();
			});

			edtisoittd_upload.on( 'preSubmit', function (e, data, action) {
				if(action != 'remove'){

					qty_penjelasan              = edtisoittd_upload.field('isoittd_upload.qty_penjelasan').val();
					keterangan_penjelasan              = edtisoittd_upload.field('isoittd_upload.keterangan_penjelasan').val();

					validasiRequired(
						edtisoittd_upload,
						'isoittd_upload',
						{
							'qty_penjelasan': qty_penjelasan,
							'keterangan_penjelasan': keterangan_penjelasan,
						}
					);
					
					validasiNumber(
						edtisoittd_upload,
						'isoittd_upload',
						{
							'qty_penjelasan': qty_penjelasan,
						},
						0,
						'>='
					);
				}
				
				if ( edtisoittd_upload.inError() ) {
					return false;
				}
			});

			edtisoittd_upload.on('initSubmit', function(e, action) {
				finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtisoittd_upload.field('isoittd_upload.finish_at').val(finish_at);
			});
			
			edtisoittd_upload.on( 'postSubmit', function (e, json, data, action, xhr) {
				tblisoittd_upload.rows().deselect();
				tblisoittd_upload.ajax.reload(null,false);
			} );

			edtisoittd_upload.on( 'close', function () {
				edtisoittd_upload.enable();
			} );
			
			var selisihDesc = $.fn.dataTable.absoluteOrderNumber( [
				{ value: null, position: 'bottom' }
			] );

			tblisoittd_upload = $('#tblisoittd_upload').DataTable( {
				dom: domPQ,
				searchPanes:{
					layout: window.innerWidth < 768 ? 'columns-1' : 'columns-3'
				},
				ajax: {
					url: "../../models/isoittd_upload_r/isoittd_upload_r_tabel.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_isoittd_upload = show_deleted_isoittd_upload;
						d.id_isoxxth_upload_filter = id_isoxxth_upload_filter;
					},
        			dataSrc: 'data' 
				},
			columnDefs:[
				{
					searchPanes:{
						show: true,
					},
					targets: [1,2,3,11,12,13]
				},
				{
					searchPanes:{
						show: false,
					},
					targets: '_all'
				},
				{ type: selisihDesc, targets: 11 }
			],
			order: [[ 2, "asc" ]],
			responsive: false,
			scrollX: true,
			columns: [
				{ data: "id",visible:false },
				{ data: "kode_sou" },
				{ data: "lokasi" },
				{ data: "lpn" },
				{ data: "kode" },
				{ data: "nama" },
				{ data: "batch_number" },
				{ data: "expired_date" },
				{ data: "satuan" },
				{ 
					data: "jumlah_terkecil" ,
					...renderNumber(2)
				},
				{ 
					data: "fisik",
					...renderNumber(2)
				},
				{ 
					data: "selisih",
					// ...renderNumber()
					render: function(data, type, row) {
						if (type === 'sp') {
							if (data == 0) {
								return "OK";
							} else if (data > 0) {
								return "Lebih"
							} else if (data < 0) {
								return "Kurang"
							} else {
								return "Invalid Value"
							}
						} else {
							return $.fn.dataTable.render.number(',', '.', 2, '', '').display(data);
						}
					},
					class: "text-right",
					searchPanes: {
						orthogonal: 'sp',
						show: true
					}
				},
				{ 
					data: "transaksi_in",
					...renderNumber(2)
				},
				{ 
					data: "transaksi_out",
					...renderNumber(2)
				},
				{ 
					data: "selisih_final",
					// ...renderNumber()
					render: function(data, type, row) {
						if (type === 'sp') {
							if (data == 0) {
								return "OK";
							} else if (data > 0) {
								return "Lebih"
							} else if (data < 0) {
								return "Kurang"
							} else {
								return "Invalid Value"
							}
						} else {
							return $.fn.dataTable.render.number(',', '.', 2, '', '').display(data);
						}
					},
					class: "text-right",
					searchPanes: {
						orthogonal: 'sp',
						show: true
					}
				},
				{ 
					data: "qty_penjelasan",
					...renderNumber()
				},
				{ 
					data: "is_skip",
					...renderYaTidak()
				},
				{ 
					data: null,
					render: function (data, type, row) {
						if(row.is_skip == 0 && row.fisik == null){
							return '<span class="badge badge-plain">Tidak</span>';
						} else {
							return '<span class="badge badge-primary">Ya</span>';
						}
					}
				},
				{ data: "s_keterangan" },
			],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_isoittd_upload';
						$table       = 'tblisoittd_upload';
						$edt         = 'edtisoittd_upload';
						$show_status = '_isoittd_upload';
						$table_name  = $nama_tabel;

						$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
						$arr_buttons_tools2 	= ['sf', 'sp', 'sb'];
						$arr_buttons_action 	= ['edit'];
						include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
					?>
					// END breaking generate button
					{ 
						text: '<span>Close</span>', 
						name: 'btnCloseStock',
						className: 'btn btn-primary',
						titleAttr: 'Close Transaction Stock Opname',
						action: function ( e, dt, node, config ) {
							start_button = moment().format("YYYY-MM-DD HH:mm:ss");

							$.ajax( {
								url: '../../models/isoittd_upload_r/fn_cek_fisik.php',
								dataType: 'json',
								type: 'POST',
								data: {
									id_isoxxth_upload_filter: id_isoxxth_upload_filter,
								},
								success: function ( json ) {
									c_no_fisik = json.data.c_belum_dihitung;
									console.log(c_no_fisik);

									if (c_no_fisik > 0) {
										alert('Gagal Melakukan Close Transaksi !!! \nTerdapat '+c_no_fisik+' item yang fisiknya belum diisi !')
									} else {
										$.ajax( {
											url: '../../models/isoittd_upload_r/fn_button_close_stock.php',
											dataType: 'json',
											type: 'POST',
											data: {
												id_isoxxth_upload_filter: id_isoxxth_upload_filter,
												start_button: start_button,
											},
											success: function ( json ) {
												full_message = json.message + '</br>';
												toast_type   = json.type_message;
												toastr[toast_type](full_message, 'INFO');

												tblisoittd_upload.rows().deselect();
												tblisoittd_upload.ajax.reload(null,false);
											}
										});
									}
									full_message = json.message + '</br>';
									toast_type   = json.type_message;
									toastr[toast_type](full_message, 'INFO');

									tblisoittd_upload.rows().deselect();
									tblisoittd_upload.ajax.reload(null,false);
								}
							});
						}
					},
				],
				initComplete: function() {
					this.api().searchPanes.rebuildPane();
					$('.dtsp-panesContainer').addClass('col-12');

				},
				rowCallback: function( row, data, index ) {
					// if ( data.isoittd_upload.transaction_state == -9 ) {
					// 	$('td', row).addClass('text-danger');
					// }else if ( data.isoittd_upload.transaction_state == 0 ) {
					// 	$('td', row).addClass('text-warning');
					// }

					// if ( data.fisik == null &&  data.is_skip == 0) {
					// 	$('td', row).addClass('bg-warning');
					// }
					if ( data.selisih_final < 0 ) {
						$(row).addClass('bg-danger');
					}

					if ( data.selisih_final > 0 ) {
						$(row).addClass('bg-warning');
					}
				}
			} );

			tblisoittd_upload.button('btnCloseStock:name').disable();
			tblisoittd_upload.searchPanes.container().appendTo('#spisoittd_upload');
			tblisoittd_upload.searchBuilder.container().appendTo( '#sbisoittd_upload' );
			
			tblisoittd_upload.on( 'draw', function () {
				// atur hak akses
				CekInitHeaderH(tblisoittd_upload);
				console.log(hak_l);
				console.log(id_isoxxth_upload_filter);

				if (id_isoxxth_upload_filter > 0) {
					if (hak_l == 1) {
						tblisoittd_upload.button('btnCloseStock:name').enable();
					} else {
						tblisoittd_upload.button('btnCloseStock:name').disable();
					}
				} else {
					tblisoittd_upload.button('btnCloseStock:name').disable();
				}
			} );
			
			tblisoittd_upload.on( 'select', function( e, dt, type, indexes ) {
				// set variable standar framework
				// siVarSet('isoittd_upload');
				isoittd_upload_data    = tblisoittd_upload.row( { selected: true } ).data();
				// console.log(isoittd_upload_data);
				id_isoittd_upload      = isoittd_upload_data.id;
				qty_penjelasan      = isoittd_upload_data.qty_penjelasan;
				keterangan_penjelasan      = isoittd_upload_data.keterangan_penjelasan;
				// console.log(id_isoittd_upload);

				// atur hak akses
				CekSelectHeaderH(tblisoittd_upload);
			} );

			tblisoittd_upload.on( 'deselect', function () {
				// reset variable standar framework
				siVarReset('isoittd_upload');
				qty_penjelasan = 0;
				keterangan_penjelasan = '';

				// atur hak akses
				CekDeselectHeaderH(tblisoittd_upload);
			} );

			// END isoittd_upload
			
			$("#frmFilter").submit(function(e) {
				e.preventDefault();
			}).validate({
				rules: {
					
				},
				submitHandler: function(frmisoittd_upload) {
					
					id_isoxxth_upload_filter  = $('#selectKode').val();
					selectedOption = $('#selectKode').select2('data')[0];
					if (selectedOption) {
						selectedText = selectedOption.text;
					}

					if (id_isoxxth_upload_filter > 0) {
						
						full_message = "Sedang Melakukan Load Data" + '</br>';
						toast_type   = "success";
						toastr[toast_type](full_message, 'INFO');
						$('#modalSFisoittd_upload').modal('toggle');

						tblisoittd_upload.ajax.reload(function ( json ) {
						}, false);
						// tblisoittd_upload.button('btnCloseStock:name').enable();
						return false; 
					}
				}
			});
			
		} );// end of document.ready
	
	</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
