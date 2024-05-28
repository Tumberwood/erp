<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'gdnxxsh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				
				<div id="frmgdnxxsh">
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="gdnxxsh.nama"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="gdnxxsh.mode"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="gdnxxsh.nama_tabel"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="gdnxxsh.kategori_dokumen"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="gdnxxsh.kategori_dokumen_value"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="gdnxxsh.prefix"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="gdnxxsh.suffix"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="gdnxxsh.total_digit"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="gdnxxsh.separator"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="gdnxxsh.field_tanggal"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="gdnxxsh.field_kode"></editor-field>
							</div>
						</div>

					</div>
				</div>

				<div class="table-responsive">
                    <table id="tblgdnxxsh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
								<th>ID</th>
								<th>Menu</th>
								<th data-toggle="tooltip" data-placement="top" title="P: Prefix; Y: Tahun; M: Bulan; MR: Bulan Romawi; BR: Branch">Mode</th>
								<th>Nama Tabel</th>
								<th>Ketegori</th>
								<th>Ketegori Value</th>
								<th>Awalan</th>
								<th>Akhiran</th>
								<th>Digit Angka</th>
								<th>Reset per</th>
								<th>Karakter Pembagi</th>
								<th>per Cabang</th>
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

<!-- BEGIN datatables here -->
<script type="text/javascript">
		// ------------- default variable, do not erase
		var edtgdnxxsh, tblgdnxxsh, show_deleted_gdnxxsh = 0, id_gdnxxsh;
		// ------------- end of default variable

		// get tableRelation
		tableRelation('gdnxxsh');
		
		$(document).ready(function() {
			// BEGIN gdnxxsh
			edtgdnxxsh = new $.fn.dataTable.Editor( {
				ajax: {
					url: "../../models/core/gdnxxsh.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_gdnxxsh = show_deleted_gdnxxsh;
					}
				},
				table: "#tblgdnxxsh",
				template: "#frmgdnxxsh",
				fields: [ 
					{
						label: "gdnxxsh.start_at",
						name: "gdnxxsh.start_at",
						type: "hidden"
					},	
					{
						label: "gdnxxsh.finish_at",
						name: "gdnxxsh.finish_at",
						type: "hidden"
					},	
					{
						label: "nama_tabel",
						name: "nama_tabel",
						def: "gdnxxsh",
						type: "hidden"
					},	
					{
						label: "gdnxxsh.transaction_state",
						name: "gdnxxsh.transaction_state",
                        type: "hidden",
						def: 0
					},	
					{
						label: "Menu <sup class='text-danger'>*<sup>",
						name: "gdnxxsh.nama"
					},	
					{
						label: "Mode <sup class='text-danger'>*<sup>",
						name: "gdnxxsh.mode",
						type: "select",
						options: [
							{ "label": "P/YYMM/1234", "value": 1 },
							{ "label": "P1234", "value": 2 },
							{ "label": "1234/P/S/MR/YYYY", "value": 3 },
							{ "label": "BR/P/YY/MM/1234", "value": 4 },
							{ "label": "PYY001234", "value": 5 }
						],
						fieldInfo: "P: Prefix; Y: Tahun; M: Bulan; MR: Bulan Romawi; BR: Branch"
					},	
					{
						label: "Nama Tabel <sup class='text-danger'>*<sup>",
						name: "gdnxxsh.nama_tabel",
						type: "select2"
					}, 	
					{
						label: "Kategori Dokumen",
						name: "gdnxxsh.kategori_dokumen"
					}, 	
					{
						label: "Kategori Dokumen Value",
						name: "gdnxxsh.kategori_dokumen_value"
					}, 	
					{
						label: "Prefix",
						name: "gdnxxsh.prefix"
					}, 	
					{
						label: "Suffix",
						name: "gdnxxsh.suffix"
					}, 	
					{
						label: "Jumlah Digit Angka <sup class='text-danger'>*<sup>",
						name: "gdnxxsh.total_digit",
						def: 4,
					}, 	
					{
						label: "Reset per",
						name: "gdnxxsh.reset_by",
						type: "hidden"
					}, 	
					{
						label: "Field Tanggal",
						name: "gdnxxsh.field_tanggal",
						fieldInfo: "Kosongkan jika ingin menggunakan tanggal konfirmasi"
					},
					{
						label: "Field Kode",
						name: "gdnxxsh.field_kode",
						def: 'kode',
					},
					{
						label: "Karakter Pembagi",
						name: "gdnxxsh.separator",
						def: "/",
					}, 		
					{
						label: "Dibagi per Cabang",
						name: "gdnxxsh.by_cabang",
						type: "hidden"
					}
				]

			} );

			edtgdnxxsh.on( 'preOpen', function( e, mode, action ) {
				start_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtgdnxxsh.field('gdnxxsh.start_at').val(start_at);
				
				if(action == 'create'){
					tblgdnxxsh.rows().deselect();
				}else if(action == 'edit'){

					if(transaction_state == 0){
						edtgdnxxsh.field('gdnxxsh.nama').enable();
					}else{
						edtgdnxxsh.field('gdnxxsh.nama').disable();
					}

				}
			});

			edtgdnxxsh.on("open", function (e, mode, action) {
				$(".modal-dialog").addClass("modal-xl");
				edtFormButtonSaveConfirm();

			});

			edtgdnxxsh.dependent( 'gdnxxsh.mode', function ( val, data, callback ) {
				if(val == 1){
					edtgdnxxsh.field('gdnxxsh.reset_by').val("Bulan");
					edtgdnxxsh.field('gdnxxsh.by_cabang').val(0);
					edtgdnxxsh.field('gdnxxsh.suffix').hide();
					edtgdnxxsh.field('gdnxxsh.suffix').val("");
				}else if(val == 2){
					edtgdnxxsh.field('gdnxxsh.reset_by').val("");
					edtgdnxxsh.field('gdnxxsh.by_cabang').val(0);
					edtgdnxxsh.field('gdnxxsh.suffix').hide();
					edtgdnxxsh.field('gdnxxsh.suffix').val("");
				}else if(val == 3){
					edtgdnxxsh.field('gdnxxsh.reset_by').val("Bulan");
					edtgdnxxsh.field('gdnxxsh.by_cabang').val(0);
					edtgdnxxsh.field('gdnxxsh.suffix').show();
					edtgdnxxsh.field('gdnxxsh.suffix').val("");
				}else if(val == 4){
					edtgdnxxsh.field('gdnxxsh.reset_by').val("Bulan");
					edtgdnxxsh.field('gdnxxsh.by_cabang').val(1);
					edtgdnxxsh.field('gdnxxsh.suffix').hide();
					edtgdnxxsh.field('gdnxxsh.suffix').val("");
				}else if(val == 5){
					edtgdnxxsh.field('gdnxxsh.reset_by').val("Tahun");
					edtgdnxxsh.field('gdnxxsh.by_cabang').val(0);
					edtgdnxxsh.field('gdnxxsh.suffix').hide();
					edtgdnxxsh.field('gdnxxsh.suffix').val("");
				}

				return {}
			}, {event: 'keyup change'});

            edtgdnxxsh.on( 'preSubmit', function (e, data, action) {
				if(action != 'remove'){
					
					nama                   = edtgdnxxsh.field('gdnxxsh.nama').val();
					mode                   = edtgdnxxsh.field('gdnxxsh.mode').val();
					nama_tabel             = edtgdnxxsh.field('gdnxxsh.nama_tabel').val();
					total_digit            = edtgdnxxsh.field('gdnxxsh.total_digit').val();
					kategori_dokumen       = edtgdnxxsh.field('gdnxxsh.kategori_dokumen').val();
					kategori_dokumen_value = edtgdnxxsh.field('gdnxxsh.kategori_dokumen_value').val();

					validasiRequired(
						edtgdnxxsh,
						'gdnxxsh',
						{
							'nama'       : nama,
							'mode'       : mode,
							'nama_tabel' : nama_tabel,
							'total_digit': total_digit,
						}
					);

					validasiUnique(
						action,
						edtgdnxxsh,
						'gdnxxsh',
						'nama_tabel,kategori_dokumen,kategori_dokumen_value',
						'nama_tabel,kategori_dokumen,kategori_dokumen_value',
						'"'+ nama_tabel + '","' + kategori_dokumen + '","' + kategori_dokumen_value + '"',
						id_gdnxxsh
					);

				}
				
				if ( edtgdnxxsh.inError() ) {
					return false;
				}
			});
			
			edtgdnxxsh.on('initSubmit', function(e, action) {
				finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtgdnxxsh.field('gdnxxsh.finish_at').val(finish_at);
			});

			edtgdnxxsh.on( 'close', function () {
				edtgdnxxsh.enable();
			} );

			tblgdnxxsh = $('#tblgdnxxsh').DataTable( {
				dom: domPQ,
				searchPanes:{
					layout: 'columns-4',
				},
				ajax: {
					url: "../../models/core/gdnxxsh.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_gdnxxsh = show_deleted_gdnxxsh;
					}
				},
				order: [[ 1, "asc" ]],
				scrollX: true,
				responsive: false,
				columnDefs:[
					{
						searchPanes:{
							show: true,
						},
						targets: [1,2,3,9]
					},
					{
						searchPanes:{
							show: false,
						},
						targets: [0,4,5,6,7,8,10,11]
					}
				],
				columns: [
					{ data: "gdnxxsh.id",visible:false },
					{ data: "gdnxxsh.nama" },
					{ 
						data: "gdnxxsh.mode",
						render: function (data){
							if (data == 1){
								return 'P/YYMM/1234';
							}else if(data == 2){
								return 'P1234';
							}else if(data == 3){
								return '1234/P/S/MR/YYYY';
							}else if(data == 4){
								return 'BR/P/YY/MM/1234';
							}else if(data == 5){
								return 'PYY001234';
							}
						}
					},
					{ data: "gdnxxsh.nama_tabel" },
					{ data: "gdnxxsh.kategori_dokumen" },
					{ data: "gdnxxsh.kategori_dokumen_value" },
					{ data: "gdnxxsh.prefix" },
					{ data: "gdnxxsh.suffix" },
					{ data: "gdnxxsh.total_digit" },
					{ data: "gdnxxsh.reset_by" },
					{ data: "gdnxxsh.separator" },
					{ 
						data: "gdnxxsh.by_cabang" ,
						...renderYaTidak()
					}
				],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_gdnxxsh';
						$table       = 'tblgdnxxsh';
						$edt         = 'edtgdnxxsh';
						$show_status = '_gdnxxsh';
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
					if ( data.gdnxxsh.transaction_state == -9 ) {
						$('td', row).addClass('text-danger');
					}else if ( data.gdnxxsh.transaction_state == 0 ) {
						$('td', row).addClass('text-warning');
					}
				}
			} );

			tblgdnxxsh.searchPanes.container().appendTo('#spgdnxxsh');
			tblgdnxxsh.searchBuilder.container().appendTo( '#sbgdnxxsh' );
			
			tblgdnxxsh.on( 'init', function () {
				// atur hak akses
				CekInitHeaderH(tblgdnxxsh);
			} );
			
			tblgdnxxsh.on( 'select', function( e, dt, type, indexes ) {
				siVarSet('gdnxxsh');

				// atur hak akses
				CekSelectHeaderH(tblgdnxxsh);
			} );

			tblgdnxxsh.on( 'deselect', function () {
				siVarReset('gdnxxsh');

				// atur hak akses
				CekDeselectHeaderH(tblgdnxxsh);
			} );
			
			// END gdnxxsh
			
		} );// end of document.ready
	
	</script>

<!-- END datatables here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
