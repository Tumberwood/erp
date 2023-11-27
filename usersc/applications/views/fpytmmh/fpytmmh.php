<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'fpytmmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblfpytmmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Jatuh Tempo</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/fpytmmh/fn/fpytmmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
		// ------------- default variable, do not erase
		var edtfpytmmh, tblfpytmmh, show_deleted_fpytmmh = 0, id_fpytmmh;
		// ------------- end of default variable
		
		id_fpytmmh_parent_old = 0;

		$(document).ready(function() {
			//start datatables editor
			edtfpytmmh = new $.fn.dataTable.Editor( {
				ajax: {
					url: "../../models/fpytmmh/fpytmmh.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_fpytmmh = show_deleted_fpytmmh;
					}
				},
				table: "#tblfpytmmh",
				fields: [ 
					{
						label: "fpytmmh.start_at",
						name: "fpytmmh.start_at",
						type: "hidden"
					},	
					{
						label: "fpytmmh.finish_at",
						name: "fpytmmh.finish_at",
						type: "hidden"
					},	
					{
						label: "nama_tabel",
						name: "nama_tabel",
						def: "fpytmmh",
						type: "hidden"
					},	
					{
						label: "fpytmmh.transaction_state",
						name: "fpytmmh.transaction_state",
                        type: "hidden",
						def: 0
					},	
					{
						label: "Nama <sup class='text-danger'>*<sup>",
						name: "fpytmmh.nama"
					},
					{
						label: "Jatuh Tempo (Hari)<sup class='text-danger'>*<sup>",
						name: "fpytmmh.jatuh_tempo"
					},
					{
						label: "Keterangan ",
						name: "fpytmmh.keterangan",
						type: "textarea"
					},
				]
			} );

			edtfpytmmh.on( 'preOpen', function( e, mode, action ) {
				start_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtfpytmmh.field('fpytmmh.start_at').val(start_at);
				
				if(action == 'create'){
					tblfpytmmh.rows().deselect();
				}
			});

			edtfpytmmh.on("open", function (e, mode, action) {
				$(".modal-dialog").addClass("modal-lg");
			});

            edtfpytmmh.on( 'preSubmit', function (e, data, action) {
				if(action != 'remove'){
					// BEGIN of validasi fpytmmh.nama
					if ( ! edtfpytmmh.field('fpytmmh.nama').isMultiValue() ) {
						nama = edtfpytmmh.field('fpytmmh.nama').val();
						if(!nama || nama == ''){
							edtfpytmmh.field('fpytmmh.nama').error( 'Wajib diisi!' );
						}
					}
					// END of validasi fpytmmh.nama

					jatuh_tempo = edtfpytmmh.field('fpytmmh.jatuh_tempo').val();
					if(!jatuh_tempo || jatuh_tempo == ''){
							edtfpytmmh.field('fpytmmh.jatuh_tempo').error( 'Wajib diisi!' );
						}
						
					if(jatuh_tempo < 0 ){
						edtfpytmmh.field('fpytmmh.jatuh_tempo').error( 'Inputan harus > 0' );
					}
					
					// validasi angka
					if(isNaN(jatuh_tempo) ){
						edtfpytmmh.field('fpytmmh.jatuh_tempo').error( 'Inputan harus berupa Angka!' );
					}
				}
				
				if ( edtfpytmmh.inError() ) {
					return false;
				}
			});
			
			edtfpytmmh.on('initSubmit', function(e, action) {
				finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtfpytmmh.field('fpytmmh.finish_at').val(finish_at);
			});

			edtfpytmmh.on( 'close', function () {
				edtfpytmmh.enable();
			} );

			//start datatables
			tblfpytmmh = $('#tblfpytmmh').DataTable( {
				dom: domPQ,
				searchPanes:{
					layout: 'columns-4',
				},
				ajax: {
					url: "../../models/fpytmmh/fpytmmh.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_fpytmmh = show_deleted_fpytmmh;
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
					{ data: "fpytmmh.id",visible:false },
					{ data: "fpytmmh.nama" },
					{ data: "fpytmmh.jatuh_tempo" },
					{ data: "fpytmmh.keterangan" },
					{ 
						data: "fpytmmh.transaction_state" ,
						render: $.fn.dataTable.render.transactionStatus()
					}
				],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_fpytmmh';
						$table       = 'tblfpytmmh';
						$edt         = 'edtfpytmmh';
						$show_status = '_fpytmmh';
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
					if ( data.fpytmmh.transaction_state == -9 ) {
						$('td', row).addClass('text-danger');
					}else if ( data.fpytmmh.transaction_state == 0 ) {
						$('td', row).addClass('text-warning');
					}
				}
			} );

			tblfpytmmh.searchPanes.container().appendTo('#spfpytmmh');
			tblfpytmmh.searchBuilder.container().appendTo( '#sbfpytmmh' );
			
			tblfpytmmh.on( 'init', function () {
				// atur hak akses
				CekInitHeaderH(tblfpytmmh);
			} );
			
			tblfpytmmh.on( 'select', function( e, dt, type, indexes ) {
				fpytmmh_data    	= tblfpytmmh.row( { selected: true } ).data().fpytmmh;
				id_fpytmmh      	= fpytmmh_data.id;
				id_transaksi_h 		= id_fpytmmh; // dipakai untuk general
				id_transaksi_log	= id_fpytmmh; // dipakai untuk general
				transaction_state   = fpytmmh_data.transaction_state;
				approval_state   	= fpytmmh_data.approval_state;
				is_nextprocess 		= fpytmmh_data.is_nextprocess;
				is_jurnal      		= fpytmmh_data.is_jurnal;
				
				id_fpytmmh_parent_old = fpytmmh_data.id_fpytmmh_parent;

				// atur hak akses
				CekSelectHeaderH(tblfpytmmh);
			} );

			tblfpytmmh.on( 'deselect', function () {
				// reload dipanggil di function CekDeselectHeader
				id_fpytmmh = 0;
				id_fpytmmh_parent_old = 0;

				// atur hak akses
				CekDeselectHeaderH(tblfpytmmh);
			} );
			
		} );// end of document.ready
	
	</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
