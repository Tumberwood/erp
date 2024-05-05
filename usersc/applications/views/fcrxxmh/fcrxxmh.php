<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'fcrxxmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblfcrxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th data-i18n="code"></th>
                                <th data-i18n="name"></th>
                                <th data-i18n="symbol"></th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/fcrxxmh/fn/fcrxxmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
		// ------------- default variable, do not erase
		var edtfcrxxmh, tblfcrxxmh, show_deleted_fcrxxmh = 0, id_fcrxxmh;
		// ------------- end of default variable

		// get tableRelation
		tableRelation('fcrxxmh');
		
		$(document).ready(function() {
			// BEGIN fcrxxmh
			edtfcrxxmh = new $.fn.dataTable.Editor( {
				ajax: {
					url: "../../models/fcrxxmh/fcrxxmh.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_fcrxxmh = show_deleted_fcrxxmh;
					}
				},
				table: "#tblfcrxxmh",
				fields: [ 
					{
						label: "fcrxxmh.start_at",
						name: "fcrxxmh.start_at",
						type: "hidden"
					},	
					{
						label: "fcrxxmh.finish_at",
						name: "fcrxxmh.finish_at",
						type: "hidden"
					},	
					{
						label: "nama_tabel",
						name: "nama_tabel",
						def: "fcrxxmh",
						type: "hidden"
					},	
					{
						label: "fcrxxmh.transaction_state",
						name: "fcrxxmh.transaction_state",
                        type: "hidden",
						def: 0
					},	
					{
						label: getTranslation('code') + " <sup class='text-danger'>*<sup>",
						name: "fcrxxmh.kode"
					}, 	
					{
						label: getTranslation('name') + " <sup class='text-danger'>*<sup>",
						name: "fcrxxmh.nama"
					}, 	
					{
						label: getTranslation('symbol') + " <sup class='text-danger'>*<sup>",
						name: "fcrxxmh.simbol"
					},
					{
						label: getTranslation('default') + " <sup class='text-danger'>*<sup>",
						name: "fcrxxmh.is_default",
						type: "select",
						placeholder : "Select",
						options: [
							{ "label": "Ya", "value": 1 },
							{ "label": "Tidak", "value": 0 }
						]
					}
				]
			} );

			edtfcrxxmh.on( 'preOpen', function( e, mode, action ) {
				start_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtfcrxxmh.field('fcrxxmh.start_at').val(start_at);
				
				if(action == 'create'){
					tblfcrxxmh.rows().deselect();

					edtfcrxxmh.field('fcrxxmh.kode').enable();
					edtfcrxxmh.field('fcrxxmh.nama').enable();
				}else if(action == 'edit'){

					if(transaction_state == 0){
						edtfcrxxmh.field('fcrxxmh.kode').enable();
						edtfcrxxmh.field('fcrxxmh.nama').enable();
					}else{
						edtfcrxxmh.field('fcrxxmh.kode').disable();
						edtfcrxxmh.field('fcrxxmh.nama').disable();
					}
				}
			});

			edtfcrxxmh.on("open", function (e, mode, action) {
				$(".modal-dialog").addClass("modal-lg");

				// enable disable tombol Save & Confirm
				edtFormButtonSaveConfirm();
			});

            edtfcrxxmh.on( 'preSubmit', function (e, data, action) {
				if(action != 'remove'){
					kode   = edtfcrxxmh.field('fcrxxmh.kode').val();
					nama   = edtfcrxxmh.field('fcrxxmh.nama').val();
					simbol = edtfcrxxmh.field('fcrxxmh.simbol').val();

					validasiRequired(
						edtfcrxxmh,
						'fcrxxmh',
						{
							'kode'  : kode,
							'nama'  : nama,
							'simbol': simbol
						}
					);

					validasiUnique(
						action,
						edtfcrxxmh,
						'fcrxxmh',
						'kode',
						'kode',
						'"'+kode+'"',
						id_fcrxxmh
					);

					validasiUnique(
						action,
						edtfcrxxmh,
						'fcrxxmh',
						'nama',
						'nama',
						'"'+nama+'"',
						id_fcrxxmh
					);

					validasiUnique(
						action,
						edtfcrxxmh,
						'fcrxxmh',
						'simbol',
						'simbol',
						'"'+simbol+'"',
						id_fcrxxmh
					);

				}
				
				if ( edtfcrxxmh.inError() ) {
					return false;
				}
			});
			
			edtfcrxxmh.on('initSubmit', function(e, action) {
				finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtfcrxxmh.field('fcrxxmh.finish_at').val(finish_at);

				// BEGIN is_default
				// ambil is_default dari form input
				is_default 		= edtfcrxxmh.field('fcrxxmh.is_default').val();
				kode 			= edtfcrxxmh.field('fcrxxmh.kode').val();
				nama 			= edtfcrxxmh.field('fcrxxmh.nama').val();
				if(action == 'create'){
					is_default_old = 0;
				} // else nya sudah didapatkan saat select

				if(is_default == 1 && is_default != is_default_old){
					// jika inputan Default = Ya dan sebelumnya bukan Ya
					// konfirmasi perubahan
					if(confirm('Apakah Anda Ingin Membuat '+kode+' - '+nama+' Menjadi Default Currency?')){
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

			edtfcrxxmh.on( 'postSubmit', function (e, json, data, action, xhr) {
				
				// BEGIN is_default
				if(is_update_default == 1){
					id_transaksi_default = json.data[0].fcrxxmh.id;
					isDefaultUpdate('fcrxxmh', id_transaksi_default, tblfcrxxmh);
				}
				// END is_default

			} );

			edtfcrxxmh.on( 'close', function () {
				edtfcrxxmh.enable();
			} );

			tblfcrxxmh = $('#tblfcrxxmh').DataTable( {
				dom: domPQ,
				searchPanes:{
					layout: 'columns-4',
				},
				ajax: {
					url: "../../models/fcrxxmh/fcrxxmh.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_fcrxxmh = show_deleted_fcrxxmh;
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
						targets: [0,4]
					}
				],
				columns: [
					{ data: "fcrxxmh.id",visible:false },
					{ data: "fcrxxmh.kode" },
					{ data: "fcrxxmh.nama" },
					{ data: "fcrxxmh.simbol" },
					{ 
						data: "fcrxxmh.is_default",
						render: function (data){
							if (data == 1){
								return '<i class="fa fa-check text-navy"></i>';
							}else{
								return '';
							}
						}
					},
					{ 
						data: "fcrxxmh.transaction_state" ,
						...renderTransactionStatus()
					}
				],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_fcrxxmh';
						$table       = 'tblfcrxxmh';
						$edt         = 'edtfcrxxmh';
						$show_status = '_fcrxxmh';
						$table_name  = $nama_tabel;

						$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
						$arr_buttons_tools2 	= [];
						$arr_buttons_action 	= ['create', 'edit', 'remove', 'confirm', 'nonaktif_h', 'view', 'log','noaction'];
						include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
					?>
					// END breaking generate button
				],
				initComplete: function() {
					this.api().searchPanes.rebuildPane();
				},
				rowCallback: function( row, data, index ) {
					if ( data.fcrxxmh.transaction_state == -9 ) {
						$('td', row).addClass('text-danger');
					}else if ( data.fcrxxmh.transaction_state == 0 ) {
						$('td', row).addClass('text-warning');
					}
				}
			} );

			tblfcrxxmh.searchPanes.container().appendTo('#spfcrxxmh');
			tblfcrxxmh.searchBuilder.container().appendTo( '#sbfcrxxmh' );
			
			tblfcrxxmh.on( 'init', function () {
				// atur hak akses
				CekInitHeaderH(tblfcrxxmh);
			} );
			
			tblfcrxxmh.on( 'select', function( e, dt, type, indexes ) {
				// set variable standar framework
				siVarSet('fcrxxmh');
				is_default_old    = fcrxxmh_data.is_default;

				// atur hak akses
				CekSelectHeaderH(tblfcrxxmh);
			} );

			tblfcrxxmh.on( 'deselect', function () {
				// reset variable standar framework
				siVarReset('fcrxxmh');

				// atur hak akses
				CekDeselectHeaderH(tblfcrxxmh);
			} );
			
			// END fcrxxmh

		} );// end of document.ready
	
	</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
