<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'gtbrlsh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblgtbrlsh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Header</th>
                                <th>Detail</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/gtbrlsh/fn/gtbrlsh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
		// ------------- default variable, do not erase
		var edtgtbrlsh, tblgtbrlsh, show_deleted_gtbrlsh = 0, id_gtbrlsh;
		// ------------- end of default variable

		// get tableRelation
		tableRelation('gtbrlsh');
		
		$(document).ready(function() {
			//start datatables editor
			edtgtbrlsh = new $.fn.dataTable.Editor( {
				ajax: {
					url: "../../models/gtbrlsh/gtbrlsh.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_gtbrlsh = show_deleted_gtbrlsh;
					}
				},
				table: "#tblgtbrlsh",
				fields: [ 
					{
						label: "gtbrlsh.start_at",
						name: "gtbrlsh.start_at",
						type: "hidden"
					},	
					{
						label: "gtbrlsh.finish_at",
						name: "gtbrlsh.finish_at",
						type: "hidden"
					},	
					{
						label: "nama_tabel",
						name: "nama_tabel",
						def: "gtbrlsh",
						type: "hidden"
					},	
					{
						label: "gtbrlsh.transaction_state",
						name: "gtbrlsh.transaction_state",
                        type: "hidden",
						def: 0
					},	
					{
						label: "Nama <sup class='text-danger'>*<sup>",
						name: "gtbrlsh.nama"
					}, 	
					{
						label: "Tabel Header <sup class='text-danger'>*<sup>",
						name: "gtbrlsh.tblheader"
					},
					{
						label: "Tabel Details",
						name: "gtbrlsh.tbldetails",
					},
					{
						label: "Master Table",
						name: "gtbrlsh.is_master_table",
						type: "select",
						placeholder : "Select",
						options: [
							{ "label": "Yes", "value": 1 },
							{ "label": "No", "value": 0 }
						]
					},
					{
						label: "Perlu Approval",
						name: "gtbrlsh.is_need_approval",
						type: "select",
						placeholder : "Select",
						options: [
							{ "label": "Yes", "value": 1 },
							{ "label": "No", "value": 0 }
						]
					},
					{
						label: "Auto Generate Kode",
						name: "gtbrlsh.is_need_generate_kode",
						type: "select",
						placeholder : "Select",
						options: [
							{ "label": "Yes", "value": 1 },
							{ "label": "No", "value": 0 }
						]
					},
					{
						label: "Menggunakan Jurnal",
						name: "gtbrlsh.is_need_jurnal",
						type: "select",
						placeholder : "Select",
						options: [
							{ "label": "Yes", "value": 1 },
							{ "label": "No", "value": 0 }
						]
					},
					{
						label: "Menggunakan Inventory",
						name: "gtbrlsh.is_need_inventory",
						type: "select",
						placeholder : "Select",
						options: [
							{ "label": "Yes", "value": 1 },
							{ "label": "No", "value": 0 }
						]
					},
					{
						label: "Keterangan",
						name: "gtbrlsh.keterangan",
						type: "textarea"
					}
				]
			} );

			edtgtbrlsh.on( 'preOpen', function( e, mode, action ) {
				start_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtgtbrlsh.field('gtbrlsh.start_at').val(start_at);
				
				if(action == 'create'){
					tblgtbrlsh.rows().deselect();
					edtgtbrlsh.field('gtbrlsh.nama').enable();
					edtgtbrlsh.field('gtbrlsh.tblheader').enable();

				}else if(action == 'edit'){
					edtgtbrlsh.field('gtbrlsh.nama').disable();
					edtgtbrlsh.field('gtbrlsh.tblheader').disable();
					
				}
			});

			edtgtbrlsh.on("open", function (e, mode, action) {
				$(".modal-dialog").addClass("modal-lg");
			});

            edtgtbrlsh.on( 'preSubmit', function (e, data, action) {
				if(action != 'remove'){

					nama      = edtgtbrlsh.field('gtbrlsh.nama').val();
					tblheader = edtgtbrlsh.field('gtbrlsh.tblheader').val();

					validasiRequired(
						edtgtbrlsh,
						'gtbrlsh',
						{
							'nama': nama,
							'tblheader': tblheader
						}
					);

					validasiUnique(
						action,
						edtgtbrlsh,
						'gtbrlsh',
						'nama',
						'nama',
						'"'+nama+'"',
						id_gtbrlsh
					);
				}
				
				if ( edtgtbrlsh.inError() ) {
					return false;
				}
			});
			
			edtgtbrlsh.on('initSubmit', function(e, action) {
				finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtgtbrlsh.field('gtbrlsh.finish_at').val(finish_at);
			});

			edtgtbrlsh.on( 'close', function () {
				edtgtbrlsh.enable();
			} );

			//start datatables
			tblgtbrlsh = $('#tblgtbrlsh').DataTable( {
				dom: domPQ,
				searchPanes:{
					layout: 'columns-4',
				},
				ajax: {
					url: "../../models/gtbrlsh/gtbrlsh.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_gtbrlsh = show_deleted_gtbrlsh;
					}
				},
				order: [[ 1, "asc" ]],
				columnDefs:[
					{
						searchPanes:{
							show: true,
						},
						targets: [1,2]
					},
					{
						searchPanes:{
							show: false,
						},
						targets: [0,3,4,5]
					}
				],
				columns: [
					{ data: "gtbrlsh.id",visible:false },
					{ data: "gtbrlsh.nama" },
					{ data: "gtbrlsh.tblheader" },
					{ data: "gtbrlsh.tbldetails" },
					{ data: "gtbrlsh.keterangan" },
					{ 
						data: "gtbrlsh.transaction_state" ,
						...renderTransactionStatus()
					}
				],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_gtbrlsh';
						$table       = 'tblgtbrlsh';
						$edt         = 'edtgtbrlsh';
						$show_status = '_gtbrlsh';
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
					if ( data.gtbrlsh.transaction_state == -9 ) {
						$('td', row).addClass('text-danger');
					}else if ( data.gtbrlsh.transaction_state == 0 ) {
						$('td', row).addClass('text-warning');
					}
				}
			} );

			tblgtbrlsh.searchPanes.container().appendTo('#spgtbrlsh');
			tblgtbrlsh.searchBuilder.container().appendTo( '#sbgtbrlsh' );
			
			tblgtbrlsh.on( 'init', function () {
				// atur hak akses
				CekInitHeaderH(tblgtbrlsh);
			} );
			
			tblgtbrlsh.on( 'select', function( e, dt, type, indexes ) {
				gtbrlsh_data    		= tblgtbrlsh.row( { selected: true } ).data().gtbrlsh;
				id_gtbrlsh      		= gtbrlsh_data.id;
				id_transaksi_h 		= id_gtbrlsh; // dipakai untuk general
				id_transaksi_log	= id_gtbrlsh; // dipakai untuk general
				transaction_state   = gtbrlsh_data.transaction_state;
				approval_state   	= gtbrlsh_data.approval_state;
				is_nextprocess 		= gtbrlsh_data.is_nextprocess;
				is_jurnal      		= gtbrlsh_data.is_jurnal;

				// atur hak akses
				CekSelectHeaderH(tblgtbrlsh);
			} );

			tblgtbrlsh.on( 'deselect', function () {
				// reload dipanggil di function CekDeselectHeader
				id_gtbrlsh = 0;

				// atur hak akses
				CekDeselectHeaderH(tblgtbrlsh);
			} );
			
		} );// end of document.ready
	
	</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
