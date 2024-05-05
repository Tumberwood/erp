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
                                <th data-i18n="name"></th>
                                <th data-i18n="dueDate"></th>
                                <th data-i18n="notes"></th>
                                <th data-i18n="default"></th>
                                <th data-i18n="state"></th>
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
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn.js"></script>
<script src="<?=$us_url_root?>usersc/helpers/language.js"></script>

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/fpytmmh/fn/fpytmmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
		// ------------- default variable, do not erase
		var edtfpytmmh, tblfpytmmh, show_deleted_fpytmmh = 0, id_fpytmmh;
		// ------------- end of default variable

		// get tableRelation
		tableRelation('fpytmmh');

		$(document).ready(function() {
			// BEGIN fpytmmh
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
						label: getTranslation('name') + " <sup class='text-danger'>*<sup>",
						name: "fpytmmh.nama"
					},
					{
						label: getTranslation('dueDate') + " (Day) <sup class='text-danger'>*<sup>",
						name: "fpytmmh.jatuh_tempo"
					},
					{
						label: getTranslation('notes'),
						name: "fpytmmh.keterangan",
						type: "textarea"
					},
					{
						label: getTranslation('default'),
						name: "fpytmmh.is_default",
						type: "select",
						placeholder : "Select",
						options: [
							{ "label": "Ya", "value": 1 },
							{ "label": "Tidak", "value": 0 }
						]
					}
				]
			} );

			edtfpytmmh.on( 'preOpen', function( e, mode, action ) {
				start_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtfpytmmh.field('fpytmmh.start_at').val(start_at);
				
				if(action == 'create'){
					tblfpytmmh.rows().deselect();
					edtfpytmmh.field('fpytmmh.nama').enable();
				}else if(action == 'edit'){
					if(transaction_state == 0){
						edtfpytmmh.field('fpytmmh.nama').enable();
					}else{
						edtfpytmmh.field('fpytmmh.nama').disable();
					}
				}
			});

			edtfpytmmh.on("open", function (e, mode, action) {
				$(".modal-dialog").addClass("modal-lg");

				// enable disable tombol Save & Confirm
				edtFormButtonSaveConfirm();
			});

            edtfpytmmh.on( 'preSubmit', function (e, data, action) {
				if(action != 'remove'){
					nama        = edtfpytmmh.field('fpytmmh.nama').val();
					jatuh_tempo = edtfpytmmh.field('fpytmmh.jatuh_tempo').val();

					validasiRequired(
						edtfpytmmh,
						'fpytmmh',
						{
							'nama'       : nama,
							'jatuh_tempo': jatuh_tempo
						}
					);

					validasiNumber(
						edtfpytmmh,
						'fpytmmh',
						{
							'jatuh_tempo': jatuh_tempo
						},
						0,
						'>='
					);

				}
				
				if ( edtfpytmmh.inError() ) {
					return false;
				}
			});
			
			edtfpytmmh.on('initSubmit', function(e, action) {
				finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtfpytmmh.field('fpytmmh.finish_at').val(finish_at);

				// BEGIN is_default
				// ambil is_default dari form input
				is_default 		= edtfpytmmh.field('fpytmmh.is_default').val();
				nama 			= edtfpytmmh.field('fpytmmh.nama').val();
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

			edtfpytmmh.on( 'postSubmit', function (e, json, data, action, xhr) {	
				// BEGIN is_default
				if(is_update_default == 1){
					id_transaksi_default = json.data[0].fpytmmh.id;
					isDefaultUpdate('fpytmmh', id_transaksi_default, tblfpytmmh);
				}
				// END is_default
				
			} );

			edtfpytmmh.on( 'close', function () {
				edtfpytmmh.enable();
			} );

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
						data: "fpytmmh.is_default",
						render: function (data){
							if (data == 1){
								return '<i class="fa fa-check text-navy"></i>';
							}else{
								return '';
							}
						}
					},
					{ 
						data: "fpytmmh.transaction_state" ,
						...renderTransactionStatus()
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
				// set variable standar framework
				siVarSet('fpytmmh');
				is_default_old      = fpytmmh_data.is_default;

				// atur hak akses
				CekSelectHeaderH(tblfpytmmh);
			} );

			tblfpytmmh.on( 'deselect', function () {
				// reset variable standar framework
				siVarReset('fpytmmh');

				// atur hak akses
				CekDeselectHeaderH(tblfpytmmh);
			} );
			
			// END fpytmmh
			
		} );// end of document.ready
	
	</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
