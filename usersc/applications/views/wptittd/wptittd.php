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
	$nama_tabel    = 'wptittd';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblwptittd" class="table table-striped table-bordered table-hover nowrap" width="100%">
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
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn.js"></script>

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/wptittd/fn/wptittd_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtwptittd, tblwptittd, show_deleted_wptittd = 0, id_wptittd;
	// ------------- end of default variable

	var id_iimxxmh, id_iumxxmh_unit_old  = 0, wlpxxmh_kode, wloxxmh_nama_target;
	
	// get tableRelation
	tableRelation('wptittd');

	$(document).ready(function() {
		// BEGIN wptittd
		edtwptittd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/wptittd/wptittd.php",
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
					label: "LPN <sup class='text-danger'>*<sup>",
					name: "wptittd.wlpxxmh_kode"
				},
				{
					label: "Detail",
					name: "wptittd_details",
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
					name: "wptittd.jumlah_unit"
				},
				{
					label: "Location",
					name: "wloxxmh_nama_scan"
				},
			]
		} );

		edtwptittd.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtwptittd.field('wptittd.start_at').val(start_at);
			
			if(action == 'create'){
				tblwptittd.rows().deselect();
			}else if(action == 'edit'){
				
			}

			edtwptittd.field('wptittd_details').disable();
			
		});

		edtwptittd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();

		});

		edtwptittd.dependent( 'wptittd.wlpxxmh_kode', function ( val, data, callback ) {
			wlpxxmh_kode = val;
			wlpxxmh_kode_validasi();
			return {}
		}, {event: 'change'});

		edtwptittd.dependent( 'wloxxmh_nama_scan', function ( val, data, callback ) {
			if(val != ''){
				wloxxmh_nama_scan = val;
				if(wloxxmh_nama_scan != wloxxmh_nama_target){
					edtwptittd.field('wloxxmh_nama_scan').error( 'Lokasi Tidak Sesuai!' );
					edtwptittd.field('wloxxmh_nama_scan').val('');
					console.log('xx');
				}else{
					edtwptittd.field('wloxxmh_nama_scan').error( '' );
					console.log('lokasi ok');
				}
			}
			
			
			return {}
		}, {event: 'keyup change'});

		edtwptittd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				wlpxxmh_kode = edtwptittd.field('wptittd.wlpxxmh_kode').val();
				id_iumxxmh_unit = edtwptittd.field('wptittd.id_iumxxmh_unit').val();
				jumlah_unit = edtwptittd.field('wptittd.jumlah_unit').val();

				validasiRequired(
					edtwptittd,
					'wptittd',
					{
						'wlpxxmh_kode'   : wlpxxmh_kode,
						'id_iumxxmh_unit': id_iumxxmh_unit,
						'jumlah_unit'    : jumlah_unit
					}
				);

				validasiNumber(
					edtwptittd,
					'wptittd',
					{
						'jumlah_unit': jumlah_unit,
					},
					0,
					'>'
				);

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

		edtwptittd.on( 'close', function () {
			edtwptittd.enable();
		} );

		tblwptittd = $('#tblwptittd').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/wptittd/wptittd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_wptittd = show_deleted_wptittd;
				}
			},
			order: [[ 1, "asc" ]],
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
				{ data: "wptittd.id",visible:false },
				{ data: "wptittd.kode" },
				{ data: "wptittd.wlpxxmh_kode" },
				{ data: "iimxxmh.kode" },
				{ data: "iimxxmh.nama" },
				{ data: "iumxxmh.kode" },
				{ 
					data: "wptittd.jumlah_unit",
					...renderNumber( 0, "")
				},
				{ 
					data: "wptittd.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_wptittd';
					$table       = 'tblwptittd';
					$edt         = 'edtwptittd';
					$show_status = '_wptittd';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= ['sp', 'sb'];
					$arr_buttons_action 	= ['create', 'edit', 'remove', 'confirm', 'nonaktif_h', 'close', 'view', 'log','noaction'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
				// END breaking generate button
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
				if ( data.wptittd.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.wptittd.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblwptittd.searchPanes.container().appendTo('#spwptittd');
		tblwptittd.searchBuilder.container().appendTo( '#sbwptittd' );
		
		tblwptittd.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblwptittd);
		} );
		
		tblwptittd.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('wptittd');

			// atur hak akses
			CekSelectHeaderH(tblwptittd);
		} );

		tblwptittd.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('wptittd');

			// atur hak akses
			CekDeselectHeaderH(tblwptittd);
		} );

		// END wptittd
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
