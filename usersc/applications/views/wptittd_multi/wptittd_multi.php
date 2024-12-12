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

	.cards tbody tr {
		float: left;
		width: 19rem;
		margin: 0.5rem;
		border: 0.0625rem solid rgba(0, 0, 0, .125);
		border-radius: .25rem;
		box-shadow: 0.25rem 0.25rem 0.5rem rgba(0, 0, 0, 0.25);
		word-wrap: break-word;
		overflow: auto; /* Hide overflow if necessary */
		display: block; /* Ensure the cards are block elements */
	}

	.cards tbody td {
		display: block;
		overflow-wrap: break-word; /* Ensure text wraps within cells */
		word-wrap: break-word; /* Ensure text wraps */
		white-space: normal;
	}


	.cards thead {
		display: none;
	}

	.cards td:before {
		content: attr(data-label);
		position: relative;
		float: left;
		color: #808080;
		min-width: 4rem;
		margin-left: 0;
		margin-right: 1rem;
		text-align: left;   
	}

	tr.selected td:before {
		color: #CCC;
	}
</style>

<?php
	$nama_tabel    = 'wptittd';
	$nama_tabels_d = [];
?>

<!-- begin content here -->

<div class="ibox">
	<div class="ibox-content">
		<div class="form-group row">
			<label class="col-lg-2 col-md-2">Jenis Putaway</label>
			<div class="col-lg-4 col-sm-4">
				<select class="form-control" id="select_wpttpmh" name="select_wpttpmh" multiple="multiple"></select>
			</div>
		</div>
		<div class="form-group row">
			<label class="col-lg-2 col-md-2">LPN</label>
			<div class="col-lg-4 col-sm-4">
				<input type="text" class="form-control" id="wlpxxmh_kode" name="wlpxxmh_kode" placeholder="LPN">
			</div>
		</div>
	</div>
</div>
<br>

<!-- <div class="ibox" id="kontenLPN" > -->
<!-- <div class="ibox" id="kontenLPN" style="display: none">>
	<div class="ibox-content">
		<div id="konten" class="row"></div>
	<div>
<div> -->

<!-- <div class="row" id="tableLPN" style="display: none"> -->
<!-- <div class="row" id="tableLPN"> -->
	
<div class="row" id="tableLPN">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">

			<div class="modal" id="modalLPN" tabindex="-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog modal-lg">
					<div class="modal-content animated bounceInRight">
						<div class="modal-header">
							<h4 class="modal-title">Putaway</h4>
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

			<!-- Modal drop item -->
			<div class="modal fade" id="dropItemModal" tabindex="-1" role="dialog" aria-labelledby="dropItemModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="dropItemModalLabel">Drop Item</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
						<form id="myForm">
							<div class="form-group row">
								<label class="col-lg-3 col-md-3">Lokasi Drop</label>
								<div class="col-lg-9 col-sm-9">
									<select class="form-control" id="select_wloxxmh_drop" name="select_wloxxmh_drop" multiple="multiple"></select>
								</div>
							</div>
						</form>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
							<button type="button" class="btn btn-primary" id="submitDropItem">Submit</button>
						</div>
					</div>
				</div>
			</div>
				<div class="table-responsive">
                    <table id="tblwptittd" class="table table-hover no-borders" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Kode</th>
                                <th>LPN</th>
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
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn2.js"></script>
<script src="<?=$us_url_root?>usersc/helpers/language.js"></script>

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/wptittd_multi/fn/wptittd_multi_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtwptittd, tblwptittd, show_deleted_wptittd = 0, id_wptittd;
	// ------------- end of default variable

	var id_iimxxmh, id_iumxxmh_unit_old_edt  = 0, id_iumxxmh_unit_old = 0, wlpxxmh_kode, wloxxmh_nama_target, jumlah_unit_old = 0;
	// get tableRelation
	tableRelation('wptittd');
	var uniqueToken = generateUniqueToken();

	var sisa = 0;
	var is_valid_lpn = 0;
	var id_iwhxxmh = 0;
	var id_wpttpmh_old = 0;
	var id_wloxxmh_old = 0;
	var id_wloctmh = 0;
	var id_putaway_header = 0;

	getHeaderPutaway();
	// console.log(id_wpttpmh_header);
	$('#select_wloxxmh_drop').select2({
        placeholder: "Select",
        allowClear: true,
		multiple: false,
        ajax: {
            url: "../../models/wloxxmh/wloxxmh_fn_opt_wloctmh.php",
            dataType: 'json',
            data: function (params) {
                return {
                    ids_wloctmh: '6',
                    id_iwhxxmh: id_iwhxxmh,
                    id_wloxxmh_old: id_wloxxmh_old,
                    search: params.term || '',
                    page: params.page || 1
                };
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
            delay: 500
        }
    });

	$("#select_wpttpmh").select2({
		placeholder : "Select",
		allowClear: true,
		multiple: false,
		ajax: {
			url: "../../models/wpttpmh/wpttpmh_fn_opt.php",
			dataType: 'json',
			data: function (params) {
				var query = {
					id_wpttpmh_old: id_wpttpmh_old,
					search: params.term || '',
					page: params.page || 1
				}
					return query;
			},
			processResults: function (data, params) {
				var options = data.results.map(function (result) {
					return {
						id: result.id,
						text: result.text
					};
				});
				
				//add by ferry agar auto select 07 sep 23
				if (params.page && params.page === 1) {
					$('#select_wpttpmh').empty().select2({ data: options });
				} else {
					if (id_wpttpmh_header == 0) {
						$('#select_wpttpmh').append(new Option(options[0].text, options[0].id, false, false)).trigger('change');
					} else {
						$('#select_wpttpmh').append(new Option(wpttpmh_nama_header, id_wpttpmh_header, false, false)).trigger('change');
					}
				}

				return {
					results: options,
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
	
	$('#select_wpttpmh').select2('open');

	setTimeout(function() {
		$('#select_wpttpmh').select2('close');
	}, 5);
	
	$(document).ready(function() {
		// generateKonten();

		$('#wlpxxmh_kode').on('keyup', function() {
			lpnValidate();
		});
		
		$('#select_wpttpmh').on('change', function() {
			lpnValidate();
		});

		edtwptittd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/wptittd_multi/wptittd_multi.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_wptittd = show_deleted_wptittd;
				}
			},
			table: "#tblwptittd",
			fields: [ 
				{
					label: "wptittd.start_at",
					name: "wptittd.start_at",
					type: "hidden"
				},	
				{
					label: "wptittd.finish_at",
					name: "wptittd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "wptittd",
					type: "hidden"
				},	
				{
					label: "wptittd.transaction_state",
					name: "wptittd.transaction_state",
					type: "hidden",
					def: 0
				},
				{
					label: "wptittd.id_wloxxmh_tujuan",
					name: "wptittd.id_wloxxmh_tujuan",
					type: "hidden"
				},
				{
					label: "Detail",
					name: "wptittd.keterangan",
					type: "textarea"
				},
				{
					label: "UoM <sup class='text-danger'>*<sup>",
					name: "wptittd.id_iumxxmh_unit",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/iumxxmh/iumxxmh_fn_opt_iimummd.php",
							dataType: 'json',
							data: function (params) {
								// console.log(id_iumxxmh_unit_old_edt);
								var query = {
									id_iimxxmh: id_iimxxmh,
									id_iumxxmh_unit_old: id_iumxxmh_unit_old_edt,
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
					name: "wptittd.jumlah_unit"
				},
				{
					label: "Drop",
					name: "wptittd.is_drop",
					type: "select",
					placeholder : "Select",
					fieldInfo: "jika tidak drop,berarti langsung disimpan ke lokasi",
					def: 1,
					options: [
						{ "label": "Ya", "value": 1 },
						{ "label": "Tidak", "value": 0 }
					]
				},
				{
					label: "Lokasi Drop <sup class='text-danger'>*<sup>",
					name: "lokasi_drop",
					id: "select_wloxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/wloxxmh/wloxxmh_fn_opt_wloctmh.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									ids_wloctmh: '6',
									id_iwhxxmh: id_iwhxxmh,
									id_wloxxmh_old: id_wloxxmh_old,
									search: params.term || '',
									page: params.page || 1
								}
									return query;
							},
							
                            processResults: function (data, params) {
                                var options = data.results.map(function (result) {
									return {
										id: result.id,
										text: result.text
									};
								});

								//add by ferry agar auto select 07 sep 23
								if (params.page && params.page === 1) {
									$('#select_wloxxmh').empty().select2({ data: options });
								} else {
									$('#select_wloxxmh').append(new Option(options[0].text, options[0].id, false, false)).trigger('change');
								}

								return {
									results: options,
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
					label: "Location <sup class='text-danger'>*<sup>",
					name: "wloxxmh_nama_scan"
				},
			]
		} );

		edtwptittd.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtwptittd.field('wptittd.start_at').val(start_at);
			edtwptittd.field('wloxxmh_nama_scan').hide();
			edtwptittd.field('wptittd.keterangan').disable();

			if (id_wpttpmh_old == 2) {
				edtwptittd.field('lokasi_drop').show();
				edtwptittd.field('wptittd.is_drop').show();
				edtwptittd.field('wptittd.id_iumxxmh_unit').disable();
				edtwptittd.field('wptittd.jumlah_unit').disable();
			} else {
				edtwptittd.field('lokasi_drop').hide();
				edtwptittd.field('wptittd.is_drop').hide();
				edtwptittd.field('wptittd.id_iumxxmh_unit').enable();
				edtwptittd.field('wptittd.jumlah_unit').enable();
			}
			autofillField('ggswmsh', 1, 'is_ganti_lokasi_putaway');
			is_ganti_lokasi_putaway = autofillData.is_ganti_lokasi_putaway;
		});
		
		edtwptittd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			$('div.DTE_Form_Buttons button:eq(2)').hide();
			// var btnPassId = '#kontenEdt';
			// console.log($(btnPassId).length);
			// if ($(btnPassId).length === 0) {
			// 	var kontenDetail = $(
			// 		`<h3 id="kontenEdt">Ferr</h3>`
			// 	);

			// 	edtwptittd.field('wptittd.id_iumxxmh_unit').input().after(kontenDetail);
			// }
		});

		edtwptittd.dependent( 'wptittd.id_iumxxmh_unit', function ( val, data, callback ) {
			if (val > 0) {
				id_iumxxmh_unit_old = id_iumxxmh_unit_old_edt;
				id_iumxxmh_unit = edtwptittd.field('wptittd.id_iumxxmh_unit').val();
				outstandingItem(id_wpttpmh_old,wlpxxmh_kode_sel, id_transaksi_h);
				jumlah_unit = edtwptittd.field('wptittd.jumlah_unit').val();
				// console.log('sisa = '+sisa); //10.00
				jumlah_unit = parseFloat(jumlah_unit);
				if (jumlah_unit > sisa) {
					edtwptittd.field('wloxxmh_nama_scan').hide();
				} else {
					edtwptittd.field('wloxxmh_nama_scan').show();
				}
			}
			return {}
		}, {event: 'change'});

		edtwptittd.dependent( 'wptittd.jumlah_unit', function ( val, data, callback ) {
			if (val > 0) {
				id_iumxxmh_unit_old = id_iumxxmh_unit_old_edt;
				id_iumxxmh_unit = edtwptittd.field('wptittd.id_iumxxmh_unit').val();
				outstandingItem(id_wpttpmh_old,wlpxxmh_kode_sel, id_transaksi_h);
				jumlah_unit = edtwptittd.field('wptittd.jumlah_unit').val();
				// console.log('sisa = '+sisa); //10.00
				jumlah_unit = parseFloat(jumlah_unit);
				if (jumlah_unit > sisa) {
					edtwptittd.field('wloxxmh_nama_scan').hide();
				} else {
					edtwptittd.field('wloxxmh_nama_scan').show();
				}
			}
			return {}
		}, {event: 'keyup'});
		edtwptittd.dependent( 'wptittd.is_drop', function ( val, data, callback ) {
			is_drop = edtwptittd.field('wptittd.is_drop').val();
			jumlah_unit = edtwptittd.field('wptittd.jumlah_unit').val();
			
			if (jumlah_unit > 0) {
				if (is_drop == 1) {
					$('#select_wloxxmh').select2('open');

					setTimeout(function() {
						$('#select_wloxxmh').select2('close');
					}, 5);

					edtwptittd.field('wloxxmh_nama_scan').hide();
					edtwptittd.field('lokasi_drop').show();
				} else {
					edtwptittd.field('wloxxmh_nama_scan').show();
					edtwptittd.field('wloxxmh_nama_scan').focus();
					edtwptittd.field('lokasi_drop').hide();
				}
			}
			return {}
		}, {event: 'change'});

		edtwptittd.dependent( 'lokasi_drop', function ( val, data, callback ) {
			if (val > 0) {
				id_wloxxmh_tujuan = val;
				edtwptittd.field('wptittd.id_wloxxmh_tujuan').val(id_wloxxmh_tujuan); 
			}
			return {}
		}, {event: 'change'});

		edtwptittd.dependent( 'wloxxmh_nama_scan', function ( val, data, callback ) {
			if(val != ''){
				wloxxmh_nama_scan = val;
				if (is_ganti_lokasi_putaway == 1) {
					validasiLocation(id_transaksi_h, wloxxmh_tujuan_nama);
				} else {
					if(wloxxmh_nama_scan != wloxxmh_nama_target){
						edtwptittd.field('wloxxmh_nama_scan').error( 'Lokasi Tidak Sesuai!' );
						edtwptittd.field('wloxxmh_nama_scan').val('');
						// console.log('xx');
					}else{
						edtwptittd.field('wloxxmh_nama_scan').error( '' );
						// console.log('lokasi ok');
					}
				}
			}
			return {}
		}, {event: 'keyup'});

		edtwptittd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				id_iumxxmh_unit = edtwptittd.field('wptittd.id_iumxxmh_unit').val();
				jumlah_unit_input = edtwptittd.field('wptittd.jumlah_unit').val();
				wloxxmh_nama_scan = edtwptittd.field('wloxxmh_nama_scan').val();
				lokasi_drop = edtwptittd.field('lokasi_drop').val();
				is_drop = edtwptittd.field('wptittd.is_drop').val();

				if (is_drop == 0) {
					if(!wloxxmh_nama_scan || wloxxmh_nama_scan == ''){
						edtwptittd.field('wloxxmh_nama_scan').error( 'Wajib diisi!' );
					}
				} else {
					if(!lokasi_drop || lokasi_drop == ''){
						edtwptittd.field('lokasi_drop').error( 'Wajib diisi!' );
					}
				}

				validasiRequired(
					edtwptittd,
					'wptittd',
					{
						'id_iumxxmh_unit': id_iumxxmh_unit,
						'jumlah_unit'    : jumlah_unit_input,
					}
				);

				validasiNumber(
					edtwptittd,
					'wptittd',
					{
						'jumlah_unit': jumlah_unit_input,
					},
					0,
					'>'
				);

				id_iumxxmh_unit_old = id_iumxxmh_unit_old_edt;
				outstandingItem(id_wpttpmh_old,wlpxxmh_kode_sel, id_transaksi_h);
				
				console.log('sisa = '+sisa); //10.00
				jumlah_unit_input = parseFloat(jumlah_unit_input);

				if (jumlah_unit_input > sisa) {
					// console.log(11);
					edtwptittd.field('wptittd.jumlah_unit').error( 'Jumlah Max: '+sisa );
				} else {
					edtwptittd.field('wptittd.jumlah_unit').error('');
					// console.log(22);
				}

				// tidak bisa pakai ini harus hitung sendiri
				// validasiOutstanding(
				// 	edtwptittd, 'wptittd', id_transaksi, id_wroittd, 'wroittd'
				// )

			}
			
			if ( edtwptittd.inError() ) {
				return false;
			}
		});
		
		edtwptittd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtwptittd.field('wptittd.finish_at').val(finish_at);
		});
		
		edtwptittd.on('postSubmit', async function(e, json, data, action, xhr) {
			try {
				const id_transaksi_h = json.data[0].wptittd.id;
				await removeBooking(id_transaksi_h);
				await fnConfirm('wptittd', tblwptittd);
				confirmHeader();
				tblwptittd.rows().deselect();
				tblwptittd.ajax.reload(null, false);
			} catch (error) {
				console.error('Error during postSubmit:', error);
			}
		});
		// edtwptittd.on('postSubmit', function(e, json, data, action, xhr) {
		// 	id_transaksi_h = json.data[0].wptittd.id;
		// 	removeBooking(id_transaksi_h)
		// 	fnConfirm('wptittd', tblwptittd );
		// 	confirmHeader();
		// 	tblwptittd.rows().deselect();
		// 	tblwptittd.ajax.reload(null, false);
		// });
		
		edtwptittd.on( 'close', function () {
			edtwptittd.enable();
		} );

		tblwptittd = $('#tblwptittd').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			paging: false,          // Disable pagination
			info: false,            // Disable "Showing X of Y entries" information
			lengthChange: false,    // Disable "Show X entries" dropdown	
			pageLength: -1,
			ajax: {
				url: "../../models/wptittd_multi/wptittd_multi.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_wptittd = show_deleted_wptittd;
				}
			},
			order: [[ 5, "desc" ]],
			columnDefs:[
				{
					searchPanes:{
						show: true,
					},
					targets: [2,3,4]
				},
				{
					searchPanes:{
						show: false,
					},
					targets: "_all"
				}
			],
			columns: [
				{ data: "wptittd.id",visible:false },
				{ data: "wptittd.kode" ,visible:false },
				{ data: "wptittd.wlpxxmh_kode" },
				{ data: "iimxxmh.kode" },
				{ data: "iimxxmh.nama" },
				{ data: "iumxxmh.kode" },
				{ 
					data: "wptittd.jumlah_unit",
					...renderNumber( 2, "")
				},
				{ 
					data: "wptittd.transaction_state" ,
					...renderTransactionStatus()
				},
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_wptittd';
					$table       = 'tblwptittd';
					$edt         = 'edtwptittd';
					$show_status = '_wptittd';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= [];
					$arr_buttons_tools2 	= [];
					$arr_buttons_action 	= ['edit'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
				// {
                //     text: '<i class="fa fa-id-badge fa-fw" aria-hidden="true"></i>',
                //     action: function (e, dt, node) {
                //         $(dt.table().node()).toggleClass('cards');
                //         $('.fa', node).toggleClass(['fa-table', 'fa-id-badge']);
                //         dt.draw('page');
                //     },
                //     className: 'btn-sm',
                //     attr: {
                //         title: 'Change views'
                //     }
                // }
				{
                    text: 'Cancel',
                    name: 'btnCancelPut',
                    className: 'btn btn-sm btn-danger m-r-xs',
            		titleAttr: 'Cancel Putaway',
                    action: function (e, dt, node) {
						message_transaction_state = "Apakah Anda Yakin Akan Cancel Putaway? \nData Putaway dengan status Draft Akan Terhapus.";
						
						swal({
							text: message_transaction_state,
							icon: "info",
							buttons: {
								cancel: true,
								confirm: true
							},
						})
						.then((willConfirm) => {
							if (willConfirm) {
								cancelPutaway();
							}
						});
                    },
                },
				{
                    text: 'Drop All',
                    name: 'btnDropItem',
                    className: 'btn btn-sm btn-primary m-r-xs',
            		titleAttr: 'Drop All',
                    action: function (e, dt, node) {
						$('#dropItemModal').modal('show');
                    },
                },
				{
                    text: 'Cancel Drop',
                    name: 'btnCancelDrop',
                    className: 'btn btn-sm btn-warning m-r-xs',
            		titleAttr: 'Cancel Drop',
                    action: function (e, dt, node) {
						message_transaction_state = "Apakah Anda Yakin Akan Cancel Drop? \nData Putaway Drop dengan status Draft Akan Dikembalikan ke Lokasi Asal (Inbound).";
						
						swal({
							text: message_transaction_state,
							icon: "info",
							buttons: {
								cancel: true,
								confirm: true
							},
						})
						.then((willConfirm) => {
							if (willConfirm) {
								console.log(123);
								cancelDrop();
							}
						});
                    },
                },
			],
			initComplete: function() {
				// $(tblwptittd.table().node()).toggleClass('cards');
				$('#tblwptittd').parent().addClass('cards');
				this.api().searchPanes.rebuildPane();
			},
			'drawCallback': function (settings) {
				var api = this.api();
				var $table = $(api.table().node());
				
				if ($table.hasClass('cards')) {

				// Create an array of labels containing all table headers
				var labels = [];
				$('thead th', $table).each(function () {
					labels.push($(this).text());
				});

				// Add data-label attribute to each cell
				$('tbody tr', $table).each(function () {
					$(this).find('td').each(function (column) {
						$(this).attr('data-label', labels[column]);
					});
				});

				var max = 0;
				$('tbody tr', $table).each(function () {
					max = Math.max($(this).height(), max);
				}).height(max);

				} else {
				// Remove data-label attribute from each cell
				$('tbody td', $table).each(function () {
					$(this).removeAttr('data-label');
				});

				$('tbody tr', $table).each(function () {
					$(this).height('auto');
				});
				}
			}

		} );

		tblwptittd.button('btnCancelPut:name').disable();
		tblwptittd.button('btnDropItem:name').disable();
		tblwptittd.searchPanes.container().appendTo('#spwptittd');
		tblwptittd.searchBuilder.container().appendTo( '#sbwptittd' );
		tblwptittd.button('btnCancelDrop:name').disable();
		tblwptittd.button('btnSetAction:name')
			.nodes()
            .css( 'display', 'none' );

		tblwptittd.on( 'draw', function () {
			// atur hak akses
			getHeaderPutaway();

			// console.log(id_putaway_header);
			// console.log(id_wpttpmh_header);
			if (id_putaway_header > 0) {
				tblwptittd.button('btnCancelPut:name').enable();
			} else{
				tblwptittd.button('btnCancelPut:name').disable();
			}
			
			if (id_wpttpmh_header == 2) {
				tblwptittd.button('btnCancelDrop:name').enable();
				tblwptittd.button('btnDropItem:name').enable();
			} else{
				tblwptittd.button('btnCancelDrop:name').disable();
				tblwptittd.button('btnDropItem:name').disable();
			}
		} );
		
		tblwptittd.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework


			siVarSet('wptittd');
			id_iumxxmh_unit_old_edt = wptittd_data.id_iumxxmh_unit;
			id_iimxxmh = wptittd_data.id_iimxxmh;
			jumlah_default_old = wptittd_data.jumlah_default;
			id_wpttpmh_old = wptittd_data.id_wpttpmh;
			id_wloxxmh_tujuan = wptittd_data.id_wloxxmh_tujuan;
			wlpxxmh_kode_sel = wptittd_data.wlpxxmh_kode;
			var dataModel = tblwptittd.rows({ selected: true }).data();
			wloxxmh_tujuan_nama = dataModel[0].wloxxmh.nama;
			// console.log(wloxxmh_tujuan_nama);

			// $('#modalLPN').modal('toggle');
			// generateKonten(id_transaksi_h);
			// console.log(transaction_state);
			if (transaction_state == 0) {
				tblwptittd.button('btnEdit:name').trigger();
			}
			
			autofillField('wloxxmh', id_wloxxmh_tujuan, 'id_wloctmh');
			id_wloctmh_s = autofillData.id_wloctmh;
		} );

		tblwptittd.on( 'deselect', function () {
			id_iumxxmh_unit_old_edt = 0;
			id_wloxxmh_tujuan = 0;
			wlpxxmh_kode_sel = '';
			id_wpttpmh_old = 0;
			jumlah_default_old = 0;
			id_iimxxmh = 0;

			// atur hak akses
			CekDeselectHeaderH(tblwptittd);
		} );

		$('#submitDropItem').on('click', function() {
			$('#myForm').submit(); // Trigger form validation
		});

		$('#myForm').validate({
			rules: {
				select_wloxxmh_drop: {
					required: true // Make the select field required
				}
			},
			messages: {
				select_wloxxmh_drop: {
					required: 'Please select an option from the dropdown.' // Custom message for required field
				}
			},
			submitHandler: function(form) {
				// If form is valid, handle form submission
				var id_wloxxmh_drop = $('#select_wloxxmh_drop').val();
				// console.log('Selected Value:', id_wloxxmh_drop);
				// console.log(id_putaway_header);
				$.ajax( {
					url: "../../models/wptittd_multi/wptittd_fn_drop_multi.php",
					dataType: 'json',
					type: 'POST',
					data: {
						id_wloxxmh_drop: id_wloxxmh_drop,
						id_putaway_header: id_putaway_header
					},
					success: function ( json ) {
						confirmHeader();
						tblwptittd.ajax.reload(null, false);
					}
				} );
        		$('#dropItemModal').modal('hide');
			}
		});
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
