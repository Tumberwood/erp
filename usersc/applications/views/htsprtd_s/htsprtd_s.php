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
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn.js"></script>

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/htsprtd_s/fn/htsprtd_s_fn.php'; ?>

<!-- BEGIN datatables here -->
<script type="text/javascript">
		// ------------- default variable, do not erase
		var edthtsprtd, tblhtsprtd, show_deleted_htsprtd = 0, id_htsprtd;
		// ------------- end of default variable
		
		$(document).ready(function() {
			//start datatables editor
			edthtsprtd = new $.fn.dataTable.Editor( {
				ajax: {
					url: "../../models/htsprtd_s/htsprtd_s.php",
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
						label: "Username <sup class='text-danger'>*<sup>",
						name: "htsprtd.username",
						type: "readonly"
					}, 	
					{
						label: "Tanggal",
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
						label: "Jam",
						name: "htsprtd.jam",
						type: "datetime",
						def: function () { 
							return new Date(); 
						},
						format: 'HH:mm:ss'
					},
					{
						label: "In / Out",
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
				getLocation();
				edthtsprtd.field('htsprtd.lokasi').disable();
				console.log(username_ha);
				
				if(action == 'create'){
					tblhtsprtd.rows().deselect();
					edthtsprtd.field('htsprtd.username').val(username_ha);
				}
			});

			edthtsprtd.on("open", function (e, mode, action) {
				$(".modal-dialog").addClass("modal-lg");
			});

            edthtsprtd.on( 'preSubmit', function (e, data, action) {
				if(action != 'remove'){
					
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

			//start datatables
			tblhtsprtd = $('#tblhtsprtd').DataTable( {
				dom: domPQ,
				searchPanes:{
					layout: 'columns-4',
				},
				ajax: {
					url: "../../models/htsprtd_s/htsprtd_s.php",
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
						$arr_buttons_approve 	= [];
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
			} );
			
			tblhtsprtd.on( 'select', function( e, dt, type, indexes ) {
				htsprtd_data    		= tblhtsprtd.row( { selected: true } ).data().htsprtd;
				id_htsprtd      		= htsprtd_data.id;
				id_transaksi_h 		= id_htsprtd; // dipakai untuk general
				id_transaksi_log	= id_htsprtd; // dipakai untuk general
				transaction_state   = htsprtd_data.transaction_state;

				// atur hak akses
				CekSelectHeaderH(tblhtsprtd);
			} );

			tblhtsprtd.on( 'deselect', function () {
				// reload dipanggil di function CekDeselectHeader
				id_htsprtd = 0;

				// atur hak akses
				CekDeselectHeaderH(tblhtsprtd);
			} );
			
		} );// end of document.ready
	
	</script>

<!-- END datatables here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
