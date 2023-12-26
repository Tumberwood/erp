<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'fpymtmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblfpymtmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Keterangan</th>
                                <th>Default</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/fpymtmh/fn/fpymtmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
		// ------------- default variable, do not erase
		var edtfpymtmh, tblfpymtmh, show_deleted_fpymtmh = 0, id_fpymtmh;
		// ------------- end of default variable
		
		is_master_table = 1;

		$(document).ready(function() {
			//start datatables editor
			edtfpymtmh = new $.fn.dataTable.Editor( {
				ajax: {
					url: "../../models/fpymtmh/fpymtmh.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_fpymtmh = show_deleted_fpymtmh;
					}
				},
				table: "#tblfpymtmh",
				fields: [ 
					{
						label: "fpymtmh.start_at",
						name: "fpymtmh.start_at",
						type: "hidden"
					},	
					{
						label: "fpymtmh.finish_at",
						name: "fpymtmh.finish_at",
						type: "hidden"
					},	
					{
						label: "nama_tabel",
						name: "nama_tabel",
						def: "fpymtmh",
						type: "hidden"
					},	
					{
						label: "fpymtmh.transaction_state",
						name: "fpymtmh.transaction_state",
                        type: "hidden",
						def: 0
					},	
					{
						label: "Nama <sup class='text-danger'>*<sup>",
						name: "fpymtmh.nama"
					},
					{
						label: "Keterangan ",
						name: "fpymtmh.keterangan",
						type: "textarea"
					},
					{
						label: "Default",
						name: "fpymtmh.is_default",
						type: "select",
						placeholder : "Select",
						options: [
							{ "label": "Ya", "value": 1 },
							{ "label": "Tidak", "value": 0 }
						]
					}
				]
			} );

			edtfpymtmh.on( 'preOpen', function( e, mode, action ) {
				start_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtfpymtmh.field('fpymtmh.start_at').val(start_at);
				
				if(action == 'create'){
					tblfpymtmh.rows().deselect();
					edtfpymtmh.field('fpymtmh.nama').enable();
				}else if(action == 'edit'){
					if(transaction_state == 0){						
						edtfpymtmh.field('fpymtmh.nama').enable();
					}else{
						edtfpymtmh.field('fpymtmh.nama').disable();
					}
				}

			});

			edtfpymtmh.on("open", function (e, mode, action) {
				$(".modal-dialog").addClass("modal-lg");
			});

            edtfpymtmh.on( 'preSubmit', function (e, data, action) {
				if(action != 'remove'){
					// BEGIN of validasi fpymtmh.nama
					if ( ! edtfpymtmh.field('fpymtmh.nama').isMultiValue() ) {
						nama = edtfpymtmh.field('fpymtmh.nama').val();
						if(!nama || nama == ''){
							edtfpymtmh.field('fpymtmh.nama').error( 'Wajib diisi!' );
						}
					}
					// END of validasi fpymtmh.nama

				}
				
				if ( edtfpymtmh.inError() ) {
					return false;
				}
			});
			
			edtfpymtmh.on('initSubmit', function(e, action) {
				finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtfpymtmh.field('fpymtmh.finish_at').val(finish_at);

				// BEGIN is_default
				// ambil is_default dari form input
				is_default 		= edtfpymtmh.field('fpymtmh.is_default').val();
				nama 			= edtfpymtmh.field('fpymtmh.nama').val();
				if(action == 'create'){
					is_default_old = 0;
				} // else nya sudah didapatkan saat select

				if(is_default == 1 && is_default != is_default_old){
					// jika inputan Default = Ya dan sebelumnya bukan Ya
					// konfirmasi perubahan
					if(confirm('Apakah Anda Ingin Membuat '+nama+' Menjadi Default Currency?')){
						is_update_default = 1;
					}else{
						is_update_default = 0;
						return false;
					}
				}else{
					// tidak ada perubahan

				}
				// END is_default
			});

			edtfpymtmh.on( 'postSubmit', function (e, json, data, action, xhr) {	
				// BEGIN is_default
				if(is_update_default == 1){
					id_transaksi_default = json.data[0].fpymtmh.id;
					isDefaultUpdate('fpymtmh', id_transaksi_default, tblfpymtmh);
				}
				// END is_default
				
			} );

			edtfpymtmh.on( 'close', function () {
				edtfpymtmh.enable();
			} );

			//start datatables
			tblfpymtmh = $('#tblfpymtmh').DataTable( {
				dom: domPQ,
				searchPanes:{
					layout: 'columns-4',
				},
				ajax: {
					url: "../../models/fpymtmh/fpymtmh.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_fpymtmh = show_deleted_fpymtmh;
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
					{ data: "fpymtmh.id",visible:false },
					{ data: "fpymtmh.nama" },
					{ data: "fpymtmh.keterangan" },
					{ 
						data: "fpymtmh.is_default",
						render: function (data){
							if (data == 1){
								return '<i class="fa fa-check text-navy"></i>';
							}else{
								return '';
							}
						}
					},
					{ 
						data: "fpymtmh.transaction_state" ,
						render: $.fn.dataTable.render.transactionStatus()
					}
				],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_fpymtmh';
						$table       = 'tblfpymtmh';
						$edt         = 'edtfpymtmh';
						$show_status = '_fpymtmh';
						$table_name  = $nama_tabel;

						$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
						$arr_buttons_tools2 	= ['sp', 'sb'];
						$arr_buttons_action 	= ['create', 'edit', 'remove', 'confirm', 'nonaktif_h', 'view', 'log','noaction'];
						$arr_buttons_approve 	= [];
						include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
					?>
					// END breaking generate button
				],
				initComplete: function() {
					this.api().searchPanes.rebuildPane();
				},
				rowCallback: function( row, data, index ) {
					if ( data.fpymtmh.transaction_state == -9 ) {
						$('td', row).addClass('text-danger');
					}else if ( data.fpymtmh.transaction_state == 0 ) {
						$('td', row).addClass('text-warning');
					}
				}
			} );

			tblfpymtmh.searchPanes.container().appendTo('#spfpymtmh');
			tblfpymtmh.searchBuilder.container().appendTo( '#sbfpymtmh' );
			
			tblfpymtmh.on( 'init', function () {
				// atur hak akses
				CekInitHeaderH(tblfpymtmh);
			} );
			
			tblfpymtmh.on( 'select', function( e, dt, type, indexes ) {
				fpymtmh_data    	= tblfpymtmh.row( { selected: true } ).data().fpymtmh;
				id_fpymtmh      	= fpymtmh_data.id;
				id_transaksi_h 		= id_fpymtmh; // dipakai untuk general
				id_transaksi_log	= id_fpymtmh; // dipakai untuk general
				transaction_state   = fpymtmh_data.transaction_state;
				approval_state   	= fpymtmh_data.approval_state;
				is_nextprocess 		= fpymtmh_data.is_nextprocess;

				// atur hak akses
				CekSelectHeaderH(tblfpymtmh);
			} );

			tblfpymtmh.on( 'deselect', function () {
				// reload dipanggil di function CekDeselectHeader
				id_fpymtmh = 0;

				// atur hak akses
				CekDeselectHeaderH(tblfpymtmh);
			} );
			
		} );// end of document.ready
	
	</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
