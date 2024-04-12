<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'htlgntd';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblhtlgntd" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tanggal</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Keterangan</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/htlgntd/fn/htlgntd_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
		// ------------- default variable, do not erase
		var edthtlgntd, tblhtlgntd, show_deleted_htlgntd = 0, id_htlgntd;
		// ------------- end of default variable
		
		// get tableRelation
		tableRelation('htlgntd');

		$(document).ready(function() {
			// BEGIN htlgntd
			edthtlgntd = new $.fn.dataTable.Editor( {
				ajax: {
					url: "../../models/htlgntd/htlgntd.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_htlgntd = show_deleted_htlgntd;
					}
				},
				table: "#tblhtlgntd",
				fields: [ 
					{
						label: "htlgntd.start_at",
						name: "htlgntd.start_at",
						type: "hidden"
					},	
					{
						label: "htlgntd.finish_at",
						name: "htlgntd.finish_at",
						type: "hidden"
					},	
					{
						label: "nama_tabel",
						name: "nama_tabel",
						def: "htlgntd",
						type: "hidden"
					},	
					{
						label: "htlgntd.transaction_state",
						name: "htlgntd.transaction_state",
                        type: "hidden",
						def: 0
					},	
					{
						label: "Tanggal",
						name: "htlgntd.tanggal",
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
						label: "Nama <sup class='text-danger'>*<sup>",
						name: "htlgntd.nama"
					}, 	
					{
						label: "Keterangan",
						name: "htlgntd.keterangan",
						type: "textarea"
					}
				]
			} );

			edthtlgntd.on( 'preOpen', function( e, mode, action ) {
				start_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edthtlgntd.field('htlgntd.start_at').val(start_at);
				
				if(action == 'create'){
					tblhtlgntd.rows().deselect();
				}
			});

			edthtlgntd.on("open", function (e, mode, action) {
				$(".modal-dialog").addClass("modal-lg");
			});

            edthtlgntd.on( 'preSubmit', function (e, data, action) {
				if(action != 'remove'){

					tanggal = edthtlgntd.field('htlgntd.tanggal').val();
					tanggal_ymd = moment(tanggal).format("YYYY-MM-DD");
					nama = edthtlgntd.field('htlgntd.nama').val();

					validasiRequired(
						edthtlgntd,
						'htlgntd',
						{
							'tanggal': tanggal,
							'nama': nama
						}
					);

					validasiUnique(
						action,
						edthtlgntd,
						'htlgntd',
						'tanggal',
						'tanggal',
						'"'+tanggal_ymd+'"',
						id_htlgntd
					);

					validasiUnique(
						action,
						edthtlgntd,
						'htlgntd',
						'nama',
						'nama',
						'"'+nama+'"',
						id_htlgntd
					);
				}
				
				if ( edthtlgntd.inError() ) {
					return false;
				}
			});
			
			edthtlgntd.on('initSubmit', function(e, action) {
				finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edthtlgntd.field('htlgntd.finish_at').val(finish_at);
			});

			edthtlgntd.on( 'close', function () {
				edthtlgntd.enable();
			} );

			tblhtlgntd = $('#tblhtlgntd').DataTable( {
				dom: domPQ,
				searchPanes:{
					layout: 'columns-4',
				},
				ajax: {
					url: "../../models/htlgntd/htlgntd.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_htlgntd = show_deleted_htlgntd;
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
					{ data: "htlgntd.id",visible:false },
					{ data: "htlgntd.tanggal" },
					{ data: "htlgntd.kode" },
					{ data: "htlgntd.nama" },
					{ data: "htlgntd.keterangan" },
					{ 
						data: "htlgntd.transaction_state" ,
						...renderTransactionStatus()
					}
				],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_htlgntd';
						$table       = 'tblhtlgntd';
						$edt         = 'edthtlgntd';
						$show_status = '_htlgntd';
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
					if ( data.htlgntd.transaction_state == -9 ) {
						$('td', row).addClass('text-danger');
					}else if ( data.htlgntd.transaction_state == 0 ) {
						$('td', row).addClass('text-warning');
					}
				}
			} );

			tblhtlgntd.searchPanes.container().appendTo('#sphtlgntd');
			tblhtlgntd.searchBuilder.container().appendTo( '#sbhtlgntd' );
			
			tblhtlgntd.on( 'init', function () {
				// atur hak akses
				CekInitHeaderH(tblhtlgntd);
			} );
			
			tblhtlgntd.on( 'select', function( e, dt, type, indexes ) {
				htlgntd_data    		= tblhtlgntd.row( { selected: true } ).data().htlgntd;
				id_htlgntd      		= htlgntd_data.id;
				id_transaksi_h 		= id_htlgntd; // dipakai untuk general
				id_transaksi_log	= id_htlgntd; // dipakai untuk general
				transaction_state   = htlgntd_data.transaction_state;
				approval_state   	= htlgntd_data.approval_state;
				is_nextprocess 		= htlgntd_data.is_nextprocess;

				// atur hak akses
				CekSelectHeaderH(tblhtlgntd);
			} );

			tblhtlgntd.on( 'deselect', function () {
				// reload dipanggil di function CekDeselectHeader
				id_htlgntd = 0;

				// atur hak akses
				CekDeselectHeaderH(tblhtlgntd);
			} );

			// END htlgntd
			
		} );// end of document.ready
	
	</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
