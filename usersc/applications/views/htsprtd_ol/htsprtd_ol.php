<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'htsprtd';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblhtsprtd" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Tanggal</th>
                                <th>Jam</th>
                                <th>In / Out</th>
                                <th>Longitude</th>
                                <th>Latitude</th>
                                <th>Lokasi</th>
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
<script src="<?=$us_url_root?>usersc/helpers/validation_fn.js"></script>
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn2.js"></script>
<script src="<?=$us_url_root?>usersc/helpers/language.js"></script>
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/htsprtd_ol/fn/htsprtd_ol_fn.php'; ?>

<!-- BEGIN datatables here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edthtsprtd, tblhtsprtd, show_deleted_htsprtd = 0, id_htsprtd;
	// ------------- end of default variable;

	var lokasi_sel = "";

	// get tableRelation
	tableRelation('htsprtd');
	
	$(document).ready(function() {
		
		// BEGIN htsprtd
		edthtsprtd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/htsprtd_ol/htsprtd_ol.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_htsprtd = show_deleted_htsprtd;
				}
			},
			table: "#tblhtsprtd",
			fields: [ 
				{
					label: "htsprtd.start_at",
					name: "htsprtd.start_at",
					type: "hidden"
				},	
				{
					label: "htsprtd.finish_at",
					name: "htsprtd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "htsprtd",
					type: "hidden"
				},	
				{
					label: "htsprtd.transaction_state",
					name: "htsprtd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "Username",
					name: "htsprtd.username",
					type: "readonly"
				}, 	
				{
					label: "Tanggal <sup class='text-danger'>*<sup>",
					name: "htsprtd.tanggal",
					type: "datetime",
					def: function () { 
						return new Date(); 
					},
					opts:{
						minDate: new Date('1900-01-01'),
						firstDay: 0
					},
					format: 'DD MMM YYYY'
				},
				{
					label: "Jam <sup class='text-danger'>*<sup>",
					name: "htsprtd.jam",
					type: "datetime",
					def: function () { 
						return new Date(); 
					},
					format: 'HH:mm:ss'
				},
				{
					label: "In / Out <sup class='text-danger'>*<sup>",
					name: "htsprtd.checkinout",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": "Masuk Kerja", "value": "Masuk Kerja" },
						{ "label": "Pulang Kerja", "value": "Pulang Kerja" },
					]
				},
				{
					label: "Longitude",
					name: "htsprtd.lng",
					type: "readonly"
				},
				{
					label: "latitute",
					name: "htsprtd.lat",
					type: "readonly"
				},
				{
					label: "Lokasi",
					name: "htsprtd.lokasi",
					type: "textarea"
				}
			]
		} );

		edthtsprtd.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthtsprtd.field('htsprtd.start_at').val(start_at);

			// console.log(lokasi_sel);
			if (lokasi_sel == "") {
				getLocation();
			}

			edthtsprtd.field('htsprtd.jam').disable();
			edthtsprtd.field('htsprtd.tanggal').disable();
			edthtsprtd.field('htsprtd.lokasi').disable();
			// console.log(username_ha);
			
			if(action == 'create'){
				tblhtsprtd.rows().deselect();
				edthtsprtd.field('htsprtd.username').val(username_ha);
			}
		});

		edthtsprtd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edthtsprtd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				tanggal = edthtsprtd.field('htsprtd.tanggal').val();
				jam = edthtsprtd.field('htsprtd.jam').val();
				checkinout = edthtsprtd.field('htsprtd.checkinout').val();

				validasiRequired(
					edthtsprtd,
					'htsprtd',
					{
						'tanggal': tanggal,
						'jam': jam,
						'checkinout': checkinout,
					}
				);
			}
			
			if ( edthtsprtd.inError() ) {
				return false;
			}
		});
		
		edthtsprtd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthtsprtd.field('htsprtd.finish_at').val(finish_at);
		});

		edthtsprtd.on( 'close', function () {
			edthtsprtd.enable();
		} );

		tblhtsprtd = $('#tblhtsprtd').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/htsprtd_ol/htsprtd_ol.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_htsprtd = show_deleted_htsprtd;
				}
			},
			order: [[ 2, "desc" ],[3, "desc"]],
			columnDefs:[
				{
					searchPanes:{
						show: true,
					},
					targets: [1,2,4]
				},
				{
					searchPanes:{
						show: false,
					},
					targets: [0,3,5,6,7]
				}
			],
			columns: [
				{ data: "htsprtd.id",visible:false },
				{ data: "users.fname" },
				{ data: "htsprtd.tanggal" },
				{ data: "htsprtd.jam" },
				{ data: "htsprtd.checkinout" },
				{ data: "htsprtd.lng" },
				{ data: "htsprtd.lat" },
				{ data: "htsprtd.lokasi" }
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_htsprtd';
					$table       = 'tblhtsprtd';
					$edt         = 'edthtsprtd';
					$show_status = '_htsprtd';
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
				if ( data.htsprtd.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.htsprtd.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblhtsprtd.searchPanes.container().appendTo('#sphtsprtd');
		tblhtsprtd.searchBuilder.container().appendTo( '#sbhtsprtd' );
		
		tblhtsprtd.on( 'init', function (e, settings, json) {
			// atur hak akses
			CekInitHeaderH(tblhtsprtd);
			username_ha = json.hakakses.s_username
			lokasi_sel = "";
		} );
		
		tblhtsprtd.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('htsprtd');
			lokasi_sel   = htsprtd_data.lokasi;

			// atur hak akses
			CekSelectHeaderH(tblhtsprtd);
		} );

		tblhtsprtd.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('htsprtd');
			lokasi_sel = "";

			// atur hak akses
			CekDeselectHeaderH(tblhtsprtd);
		} );
		
	} );// end of document.ready

</script>

<!-- END datatables here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
