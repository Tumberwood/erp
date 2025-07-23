<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<style>
	div.DTE_Field_Type_textarea textarea {
		width: 100%;
		height: 120px;
	}
</style>

<?php
	$nama_tabel    = 'wtrittd';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="modal" id="modalSFwtrittd" tabindex="-1" role="dialog" aria-hidden="true">
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
                    <table id="tblwtrittd" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tanggal</th>
                                <th>Kode</th>
                                <th>User</th>
                                <th>LPN Asal</th>
                                <th>LPN Tujuan</th>
                                <th>Warehouse</th>
                                <th>Lokasi Asal</th>
                                <th>Lokasi Tujuan</th>
                                <th>Item Code</th>
                                <th>Item Name</th>
                                <th>UoM</th>
                                <th>Qty</th>
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
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn.js"></script>

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/wtrittd_replenishment/fn/wtrittd_replenishment_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtwtrittd, tblwtrittd, show_deleted_wtrittd = 0, id_wtrittd;
	// ------------- end of default variable

	var id_iimxxmh, id_iumxxmh_unit_old  = 0, wlpxxmh_kode, wloxxmh_nama_target, jumlah_unit_old = 0;
	// get tableRelation
	tableRelation('wtrittd');

	var wtrittd_details = '';
	var uniqueToken = '';
	var sisa = 0;
	var is_valid_lpn = 0;
	
	$('#start_date').datepicker('setDate', tanggal_hariini_dmy);
	$('#end_date').datepicker('setDate', tanggal_hariini_dmy);

	start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
	end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');	

	$(document).ready(function() {
		// BEGIN wtrittd
		edtwtrittd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/wtrittd_replenishment/wtrittd_replenishment.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_wtrittd = show_deleted_wtrittd;
					d.start_date = start_date;
					d.end_date = end_date;
				}
			},
			table: "#tblwtrittd",
			fields: [ 
				{
					label: "wtrittd.start_at",
					name: "wtrittd.start_at",
					type: "hidden"
				},	
				{
					label: "wtrittd.finish_at",
					name: "wtrittd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "wtrittd",
					type: "hidden"
				},	
				{
					label: "wtrittd.transaction_state",
					name: "wtrittd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "Lokasi Asal <sup class='text-danger'>*<sup>",
					name: "wloxxmh_nama_asal",
					type: scannerDinamis()
				},
				{
					label: "LPN Asal<sup class='text-danger'>*<sup>",
					name: "wtrittd.wlpxxmh_kode",
					type: scannerDinamis()
				},
				{
					label: "wtrittd.id_iimxxmh",
					name: "wtrittd.id_iimxxmh",
					type: "hidden"
				},
				{
					label: "wtrittd.id_iwhxxmh",
					name: "wtrittd.id_iwhxxmh",
					type: "hidden"
				},
				{
					label: "wtrittd.id_wloxxmh_asal",
					name: "wtrittd.id_wloxxmh_asal",
					type: "hidden"
				},
				{
					label: "wtrittd.id_wloxxmh_tujuan",
					name: "wtrittd.id_wloxxmh_tujuan",
					type: "hidden"
				},
				{
					label: "wtrittd.id_wpttpmh",
					name: "wtrittd.id_wpttpmh",
					type: "hidden",
					def: 1
				},
				{
					label: "wtrittd.id_wjtxxmh",
					name: "wtrittd.id_wjtxxmh",
					type: "hidden",
					def: 4
				},
				{
					label: "Detail",
					// name: "wtrittd_details",
					name: "wtrittd.keterangan",
					type: "textarea"
				},
				{
					label: "UoM <sup class='text-danger'>*<sup>",
					name: "wtrittd.id_iumxxmh_unit",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/iumxxmh/iumxxmh_fn_opt_iimummd.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_iimxxmh: id_iimxxmh,
									id_iumxxmh_unit_old: id_iumxxmh_unit_old,
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
					label: "Jumlah <sup class='text-danger'>*<sup>",
					name: "wtrittd.jumlah_unit"
				},
				{
					label: "Lokasi Tujuan <sup class='text-danger'>*<sup>",
					name: "wloxxmh_nama_scan",
					type: scannerDinamis()
				},
				{
					label: "Gabung LPN <sup class='text-danger'>*<sup>",
					name: "wtrittd.is_gabung_lpn",
					type: 'radio',
					options: [
						{ label: 'Tidak', value: 0 },
						{ label: 'Ya', value: 1 }
					]
				},
				{
					label: "LPN Tujuan <sup class='text-danger'>*<sup>",
					name: "wtrittd.wlpxxmh_kode_tujuan",
					type: scannerDinamis()
				},
				{
					label: "Gabung ke LPN<sup class='text-danger'>*<sup>",
					name: "wtrittd.is_ikut_baru",
					type: 'radio',
					def: 1,
					options: [
						{ label: 'Tujuan', value: 1 },
						{ label: 'Asal', value: 2 },
					]
				},
				{
					label: "wtrittd.expired_date",
					name: "wtrittd.expired_date"
				},
				{
					label: "wtrittd.batch_number",
					name: "wtrittd.batch_number",
					type: "hidden"
				},
				{
					label: "wtrittd.expired_date_tujuan",
					name: "wtrittd.expired_date_tujuan"
				},
				{
					label: "wtrittd.batch_number_tujuan",
					name: "wtrittd.batch_number_tujuan",
					type: "hidden"
				},
			]
		} );

		edtwtrittd.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtwtrittd.field('wtrittd.start_at').val(start_at);

			edtwtrittd.field('wtrittd.wlpxxmh_kode').disable();
			edtwtrittd.field('wtrittd.id_iumxxmh_unit').disable();
			edtwtrittd.field('wtrittd.keterangan').disable();
			edtwtrittd.field('wtrittd.jumlah_unit').disable();
			edtwtrittd.field('wtrittd.wlpxxmh_kode_tujuan').hide();
			edtwtrittd.field('wloxxmh_nama_asal').hide();
			edtwtrittd.field('wtrittd.is_gabung_lpn').hide();
			edtwtrittd.field('wtrittd.is_ikut_baru').hide();
			edtwtrittd.field('wtrittd.expired_date').hide();
			edtwtrittd.field('wtrittd.expired_date_tujuan').hide();
			
			wtrittd_details = wtrittd_details + iimxxmh_kode + ' - ';
			wtrittd_details = wtrittd_details + iimxxmh_nama + '\n';
			wtrittd_details = wtrittd_details + jumlah_unit_old + ' ';
			wtrittd_details = wtrittd_details + iumxxmh_kode + '\n';
			wtrittd_details = wtrittd_details + tujuan_nama + '\n';
			
			// edtwtrittd.field('wtrittd_details').val(wtrittd_details);
			edtwtrittd.field('wtrittd.keterangan').val(wtrittd_details);
			
			if(action == 'create'){
				tblwtrittd.rows().deselect();
			}else if(action == 'edit'){
				
			}
			
			uniqueToken = generateUniqueToken();
    		// console.log(uniqueToken)
			$(window).on('unload', function() {
				updateJson(uniqueToken);
			});
			edtwtrittd.field('wtrittd.keterangan').disable();

			//cek setting wh
			autofillField('ggswmsh', 1, 'is_ganti_lokasi_putaway');
			is_ganti_lokasi_putaway = autofillData.is_ganti_lokasi_putaway;
		});

		edtwtrittd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			window.addEventListener('beforeunload', confirmLeavePage);

			//ini tunggu load ajax dulu, agar datanya hidden terisi
			//ini untuk keperluan insert booking is_fisik 0,
			//kalau tidak pakai ini, nanti error insert data null semua karena ajax belum success tapi udah di insert datanya
			$('div.DTE_Form_Buttons button:eq(1)').hide();

			// enable disable tombol Save & Confirm
			// edtFormButtonSaveConfirm();
			
			$('div.DTE_Form_Buttons button:eq(2)').hide();
			$('div.DTE_Form_Buttons button:eq(3)').hide();
		});

		edtwtrittd.dependent( 'wloxxmh_nama_scan', function ( val, data, callback ) {
			if(val != ''){
				wloxxmh_nama_scan = val;
				if(wloxxmh_nama_scan != tujuan_nama){
					edtwtrittd.field('wloxxmh_nama_scan').error( 'Lokasi Tidak Sesuai!' );
					edtwtrittd.field('wloxxmh_nama_scan').val('');
					$('div.DTE_Form_Buttons button:eq(3)').hide();
					// console.log('xx');
				}else{
					$('div.DTE_Form_Buttons button:eq(3)').show();
					edtwtrittd.field('wloxxmh_nama_scan').error( '' );
					// console.log('lokasi ok');
				}
				console.log(tujuan_nama);
			}
			return {}
		}, {event: 'keyup'});

		edtwtrittd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				wloxxmh_nama_scan = edtwtrittd.field('wloxxmh_nama_scan').val();

				if(!wloxxmh_nama_scan || wloxxmh_nama_scan == ''){
					edtwtrittd.field('wloxxmh_nama_scan').error( 'Wajib diisi!' );
				}

				if(wloxxmh_nama_scan != tujuan_nama){
					edtwtrittd.field('wloxxmh_nama_scan').error( 'Lokasi Tidak Sesuai!' );
					edtwtrittd.field('wloxxmh_nama_scan').val('');
					// console.log('xx');
				}
			}
			
			if ( edtwtrittd.inError() ) {
				return false;
			}
		});
		
		edtwtrittd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtwtrittd.field('wtrittd.finish_at').val(finish_at);
		});
		
		edtwtrittd.on('postSubmit', function(e, json, data, action, xhr) {
			// if (action != 'remove') {
			// 	// console.log(json);
			// 	// id_transaksi = json.data[0].wtrittd.id;
			// 	// konversiUom('wtrittd', id_transaksi );
				
			// 	id_transaksi_h = json.data[0].wtrittd.id;
			// 	console.log(id_transaksi_h);
			// 	fnConfirm('wtrittd', tblwtrittd );
				tblwtrittd.rows().deselect();
				tblwtrittd.ajax.reload(null, false);
			// }
		});

		edtwtrittd.on( 'close', function () {
			edtwtrittd.enable();
			//delete iiv fisik 0 atau booking
			window.removeEventListener('beforeunload', confirmLeavePage);
			booking(3);
		} );

		tblwtrittd = $('#tblwtrittd').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/wtrittd_replenishment/wtrittd_replenishment.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_wtrittd = show_deleted_wtrittd;
					d.start_date = start_date;
					d.end_date = end_date;
				}
			},
			order: [[ 0, "desc" ]],
			columnDefs:[
				{
					searchPanes:{
						show: true,
					},
					targets: [1,2,3,4,5]
				},
				{
					searchPanes:{
						show: false,
					},
					targets: [0,6,7]
				}
			],
			columns: [
				{ data: "wtrittd.id",visible:false },
				{ data: "tanggal_confirm" },
				{ data: "wtrittd.kode"},
				{ data: "username" },
				{ data: "wtrittd.wlpxxmh_kode" },
				{ data: "wtrittd.wlpxxmh_kode_tujuan" },
				{ data: "iwhxxmh.kode" },
				{ data: "asal.nama" },
				{ data: "tujuan.nama" },
				{ data: "iimxxmh.kode" },
				{ data: "iimxxmh.nama" },
				{ data: "iumxxmh.kode" },
				{ 
					data: "wtrittd.jumlah_unit",
					...renderNumber( 2, "")
				},
				{ 
					data: "wtrittd.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_wtrittd';
					$table       = 'tblwtrittd';
					$edt         = 'edtwtrittd';
					$show_status = '_wtrittd';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= ['sf', 'sp', 'sb'];
					$arr_buttons_action 	= [];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
				// END breaking generate button
				{ 
					extend: 'edit',
					name: 'btnEdit', 
					editor: edtwtrittd, 
					text: '<i class="fa fa-plus"></i>&nbsp;Add New', 
					className: 'btn btn-sm', 
					titleAttr: 'Add New',
					formButtons: [
						{
							text: 'Cancel',
							name: 'btnCancel',
							action: function () {
								confirm_cancel = confirm('Apakah anda yakin?');
								if (confirm_cancel) {
									this.close();
								}
								// alert('tes');
							},
							className: 'btn btn-warning m-r-xs'
						},
						{
							text: 'Load',
							name: 'btnLoad',
							action: function () {
								// this.close();
								// alert('Load');
								// wlpxxmh_kode = edtwtrittd.field('wtrittd.wlpxxmh_kode').val();
								
								// // console.log(wlpxxmh_kode);
								// validasiRequired(
								// 	edtwtrittd,
								// 	'wtrittd',
								// 	{
								// 		'wlpxxmh_kode'   : wlpxxmh_kode,
								// 	}
								// );
								
								// if ( edtwtrittd.inError() ) {
								// 	return false;
								// } else {
									
								// }
							},
							className: 'btn btn-primary m-r-xs'
						},
						{
							text: 'Start',
							name: 'btnStart',
							action: function () {
								// this.close();
								outstandingItem();
								jumlah_unit = edtwtrittd.field('wtrittd.jumlah_unit').val();

								// console.log('sisa = '+sisa); //10.00
								jumlah_unit = parseFloat(jumlah_unit);
								// console.log('jumlah_unit = '+jumlah_unit); //5
								if (jumlah_unit > sisa) {
									// console.log(11);
									edtwtrittd.field('wtrittd.jumlah_unit').error( 'Jumlah Max: '+sisa );
								} else {
									edtwtrittd.field('wtrittd.jumlah_unit').error('');
									
									$('div.DTE_Form_Buttons button:eq(1)').hide();
									$('div.DTE_Form_Buttons button:eq(2)').hide();
									$('div.DTE_Form_Buttons button:eq(3)').show();
									// console.log('uniqueToken start' +uniqueToken);
									booking(1);
									edtwtrittd.field('wtrittd.is_gabung_lpn').show();
									edtwtrittd.field('wloxxmh_nama_scan').show();
									edtwtrittd.field('wloxxmh_nama_scan').focus();
									edtwtrittd.field('wtrittd.id_iumxxmh_unit').disable();
									edtwtrittd.field('wtrittd.jumlah_unit').disable();
								}

								if ( edtwtrittd.inError() ) {
									return false;
								}
							},
							className: 'btn btn-primary m-r-xs'
						},
						{
							text: 'Finish',
							action: function (e, dt, node, config, cb){
								this.submit(
									function (json) {
									}, 
								);
								
								

							},
							className: 'btn btn-primary'
						},
						// {
						// 	text: 'Prompt',
						// 	action: function (e, dt, node, config, cb){
						// 		function confirmWithInput(message, callback) {
						// 			var response = prompt(message);
						// 			if (response !== null) {
						// 				callback(response.trim());
						// 			}
						// 		}

						// 		// Example usage:
						// 		confirmWithInput("Please confirm by typing 'yes':", function(response) {
						// 			if (response.toLowerCase() === "yes") {
						// 				console.log("Confirmation received!");
						// 			} else {
						// 				console.log("Confirmation failed.");
						// 			}
						// 		});
						// 	},
						// 	className: 'btn btn-primary'
						// },
					]
				},
                    // END 
				// END breaking generate button
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
				if ( data.wtrittd.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.wtrittd.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblwtrittd.searchPanes.container().appendTo('#spwtrittd');
		tblwtrittd.searchBuilder.container().appendTo( '#sbwtrittd' );
	
		tblwtrittd.button('btnEdit:name')
			.nodes()
			.css( 'display', 'none' );
		
		tblwtrittd.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblwtrittd);
		} );
		
		tblwtrittd.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('wtrittd');
			id_iumxxmh_unit_old = wtrittd_data.id_iumxxmh_unit;
			jumlah_unit_old = parseFloat(wtrittd_data.jumlah_unit).toFixed(2).replace('.', ',')
			wlpxxmh_kode = wtrittd_data.wlpxxmh_kode;

			iumxxmh_data    = tblwtrittd.row( { selected: true } ).data().iumxxmh;
			iumxxmh_kode = iumxxmh_data.kode;

			tujuan_data    = tblwtrittd.row( { selected: true } ).data().tujuan;
			tujuan_nama = tujuan_data.nama;

			iimxxmh_data    = tblwtrittd.row( { selected: true } ).data().iimxxmh;
			iimxxmh_kode = iimxxmh_data.kode;
			iimxxmh_nama = iimxxmh_data.nama;

			console.log(iimxxmh_kode);
			console.log(iimxxmh_nama);
			
			if (transaction_state == 0) {
				tblwtrittd.button('btnEdit:name').trigger();
			}

			// atur hak akses
			CekSelectHeaderH(tblwtrittd);
			tblwtrittd.button('btnEdit:name')
				.nodes()
				.css( 'display', 'none' );
		} );

		tblwtrittd.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('wtrittd');
			id_iumxxmh_unit_old = 0;
			jumlah_unit_old = 0;
			wlpxxmh_kode = "";
			iumxxmh_kode = "";
			iimxxmh_kode = "";
			tujuan_nama = "";
			iimxxmh_nama = "";

			// atur hak akses
			CekDeselectHeaderH(tblwtrittd);
		} );

		// END wtrittd
		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
			},
			submitHandler: function(frmFilter) {
				start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")

				tblwtrittd.rows().deselect();
				tblwtrittd.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSFwtrittd').modal('toggle');
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
