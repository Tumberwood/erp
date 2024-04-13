<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'htssctd';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblhtssctd" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th rowspan="2">ID</th>
                                <th rowspan="2">Tanggal</th>
                                <th rowspan="2">NIP</th>
                                <th rowspan="2">Nama</th>
                                <th rowspan="2">Department</th>
                                <th colspan="3" class="text-center">Awal</th>
                                <th colspan="3" class="text-center">Akhir</th>
                                <th rowspan="2">TX</th>
                            </tr>
							<tr>
								<th>T1</th>
								<th>T</th>
								<th>T2</th>
								<th>T1</th>
								<th>T</th>
								<th>T2</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/htssctd/fn/htssctd_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
		// ------------- default variable, do not erase
		var edthtssctd, tblhtssctd, show_deleted_htssctd = 0, id_htssctd;
		// ------------- end of default variable

		id_hemxxmh_old = 0;
		
		// get tableRelation
		tableRelation('htssctd');

		$(document).ready(function() {
			// BEGIN htssctd
			edthtssctd = new $.fn.dataTable.Editor( {
				ajax: {
					url: "../../models/htssctd/htssctd.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_htssctd = show_deleted_htssctd;
					}
				},
				table: "#tblhtssctd",
				fields: [ 
					{
						label: "htssctd.start_at",
						name: "htssctd.start_at",
						type: "hidden"
					},	
					{
						label: "htssctd.finish_at",
						name: "htssctd.finish_at",
						type: "hidden"
					},	
					{
						label: "nama_tabel",
						name: "nama_tabel",
						def: "htssctd",
						type: "hidden"
					},	
					{
						label: "htssctd.transaction_state",
						name: "htssctd.transaction_state",
                        type: "hidden",
						def: 0
					},	
					{
						label: "Tanggal <sup class='text-danger'>*<sup>",
						name: "htssctd.tanggal",
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
						label: "Employee <sup class='text-danger'>*<sup>",
						name: "htssctd.id_hemxxmh",
						type: "select2",
						opts: {
							placeholder : "Select",
							allowClear: true,
							multiple: false,
							ajax: {
								url: "../../models/hemxxmh/hemxxmh_fn_opt.php",
								dataType: 'json',
								data: function (params) {
									var query = {
										id_hemxxmh_old: id_hemxxmh_old,
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
						label: "Tanggal Jam Awal T1",
						name: "htssctd.tanggaljam_awal_t1",
						type: "datetime",
						def: function () { 
							return new Date(); 
						},
						opts:{
							minDate: new Date('1900-01-01'),
							firstDay: 0
						},
						format: 'DD MMM YYYY HH:mm'
					},
					{
						label: "Tanggal Jam Awal",
						name: "htssctd.tanggaljam_awal",
						type: "datetime",
						def: function () { 
							return new Date(); 
						},
						opts:{
							minDate: new Date('1900-01-01'),
							firstDay: 0
						},
						format: 'DD MMM YYYY HH:mm'
					},
					{
						label: "Tanggal Jam Awal T2",
						name: "htssctd.tanggaljam_awal_t2",
						type: "datetime",
						def: function () { 
							return new Date(); 
						},
						opts:{
							minDate: new Date('1900-01-01'),
							firstDay: 0
						},
						format: 'DD MMM YYYY HH:mm'
					},
					{
						label: "Tanggal Jam Akhir T1",
						name: "htssctd.tanggaljam_akhir_t1",
						type: "datetime",
						def: function () { 
							return new Date(); 
						},
						opts:{
							minDate: new Date('1900-01-01'),
							firstDay: 0
						},
						format: 'DD MMM YYYY HH:mm'
					},
					{
						label: "Tanggal Jam Akhir",
						name: "htssctd.tanggaljam_akhir",
						type: "datetime",
						def: function () { 
							return new Date(); 
						},
						opts:{
							minDate: new Date('1900-01-01'),
							firstDay: 0
						},
						format: 'DD MMM YYYY HH:mm'
					},
					{
						label: "Tanggal Jam Akhir T2",
						name: "htssctd.tanggaljam_akhir_t2",
						type: "datetime",
						def: function () { 
							return new Date(); 
						},
						opts:{
							minDate: new Date('1900-01-01'),
							firstDay: 0
						},
						format: 'DD MMM YYYY HH:mm'
					}
				]
			} );

			edthtssctd.on( 'preOpen', function( e, mode, action ) {
				start_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edthtssctd.field('htssctd.start_at').val(start_at);
				
				if(action == 'create'){
					tblhtssctd.rows().deselect();
				}
			});

			edthtssctd.on("open", function (e, mode, action) {
				$(".modal-dialog").addClass("modal-lg");
			});

            edthtssctd.on( 'preSubmit', function (e, data, action) {
				if(action != 'remove'){

					tanggal = edthtssctd.field('htssctd.tanggal').val();
					tanggal_ymd = moment(tanggal).format("YYYY-MM-DD HH:mm:ss");
					id_hemxxmh = edthtssctd.field('htssctd.id_hemxxmh').val();

					validasiRequired(
						edthtssctd,
						'htssctd',
						{
							'tanggal': tanggal,
							'id_hemxxmh': id_hemxxmh
						}
					);

					validasiUnique(
						action,
						edthtssctd,
						'htssctd',
						'id_hemxxmh,tanggal',
						'id_hemxxmh,tanggal',
						id_hemxxmh + ',"'+tanggal_ymd+'"',
						id_htssctd
					);

				}
				
				if ( edthtssctd.inError() ) {
					return false;
				}
			});
			
			edthtssctd.on('initSubmit', function(e, action) {
				finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edthtssctd.field('htssctd.finish_at').val(finish_at);
			});

			edthtssctd.on( 'close', function () {
				edthtssctd.enable();
			} );

			tblhtssctd = $('#tblhtssctd').DataTable( {
				dom: domPQ,
				searchPanes:{
					layout: 'columns-4',
				},
				ajax: {
					url: "../../models/htssctd/htssctd.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_htssctd = show_deleted_htssctd;
					}
				},
				order: [[ 1, "asc" ]],
				columnDefs:[
					{
						searchPanes:{
							show: true,
						},
						targets: [1,2,3]
					},
					{
						searchPanes:{
							show: false,
						},
						targets: [0]
					}
				],
				columns: [
					{ data: "htssctd.id",visible:false },
					{ data: "htssctd.tanggal" },
					{ data: "hemxxmh.kode" },
					{ data: "hemxxmh.nama" },
					{ data: "hodxxmh.nama" },
					{ data: "htssctd.tanggaljam_awal_t1" },
					{ data: "htssctd.tanggaljam_awal" },
					{ data: "htssctd.tanggaljam_awal_t2" },
					{ data: "htssctd.tanggaljam_akhir_t1" },
					{ data: "htssctd.tanggaljam_akhir" },
					{ data: "htssctd.tanggaljam_akhir_t2" },
					{ 
						data: "htssctd.transaction_state" ,
						...renderTransactionStatus()
					}
				],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_htssctd';
						$table       = 'tblhtssctd';
						$edt         = 'edthtssctd';
						$show_status = '_htssctd';
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
					if ( data.htssctd.transaction_state == -9 ) {
						$('td', row).addClass('text-danger');
					}else if ( data.htssctd.transaction_state == 0 ) {
						$('td', row).addClass('text-warning');
					}
				}
			} );

			tblhtssctd.searchPanes.container().appendTo('#sphtssctd');
			tblhtssctd.searchBuilder.container().appendTo( '#sbhtssctd' );
			
			tblhtssctd.on( 'init', function () {
				// atur hak akses
				CekInitHeaderH(tblhtssctd);
			} );
			
			tblhtssctd.on( 'select', function( e, dt, type, indexes ) {
				htssctd_data    		= tblhtssctd.row( { selected: true } ).data().htssctd;
				id_htssctd      		= htssctd_data.id;
				id_transaksi_h 		= id_htssctd; // dipakai untuk general
				id_transaksi_log	= id_htssctd; // dipakai untuk general
				transaction_state   = htssctd_data.transaction_state;
				approval_state   	= htssctd_data.approval_state;
				is_nextprocess 		= htssctd_data.is_nextprocess;

				id_hemxxmh_old = htssctd_data.id_hemxxmh;

				// atur hak akses
				CekSelectHeaderH(tblhtssctd);
			} );

			tblhtssctd.on( 'deselect', function () {
				// reload dipanggil di function CekDeselectHeader
				id_htssctd = 0;

				id_hemxxmh_old = 0;

				// atur hak akses
				CekDeselectHeaderH(tblhtssctd);
			} );

			// END htssctd
			
		} );// end of document.ready
	
	</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
