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
								<editor-field name="gdnxxsh.reset_by"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="gdnxxsh.field_tanggal"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="gdnxxsh.separator"></editor-field>
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
								<th>Mode</th>
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
<?php require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_load.php'; ?>
<?php require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_setup.php'; ?>
<?php require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_datatables_load.php'; ?>
<script src="<?=$us_url_root?>usersc/helpers/general_fn.js"></script>
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn.js"></script>

<!-- BEGIN datatables here -->
<script type="text/javascript">
		// ------------- default variable, do not erase
		var edtgdnxxsh, tblgdnxxsh, show_deleted_gdnxxsh = 0, id_gdnxxsh;
		// ------------- end of default variable

		is_master_table = 1;
		
		$(document).ready(function() {
			//start datatables editor
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
							{ "label": "prefix/tahunbulan/nomorurut", "value": 1 },
							{ "label": "P00001", "value": 2 },
							{ "label": "Urut/Prefix/Suffix/Bulan Romawi/Tahun 4 Digit", "value": 3 },
							{ "label": "Cabang/Prefix/Tahun/Bulan/nomorurut", "value": 4 }
						]
						
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
						label: "Awalan",
						name: "gdnxxsh.prefix"
					}, 	
					{
						label: "Akhiran",
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
						type: "select",
						def: "-",
						options: [
							{ "label": "Bulan", "value": "Bulan" },
							{ "label": "Tahun", "value": "Tahun" },
							{ "label": "-", "value": "" }
						]
					}, 	
					{
						label: "Field Tanggal",
						name: "gdnxxsh.field_tanggal",
						fieldInfo: "Kosongkan jika ingin menggunakan tanggal konfirmasi "
					},
					{
						label: "Karakter Pembagi",
						name: "gdnxxsh.separator",
						def: "/",
					}, 	
					{
						label: "Dibagi per Perusahaan",
						name: "gdnxxsh.by_company",
						type: "radio",
						def: 0,
						options: [
							{ "label": "Ya", "value": 1 },
							{ "label": "Tidak", "value": 0 }
						]
					}, 	
					{
						label: "Dibagi per Cabang",
						name: "gdnxxsh.by_cabang",
						type: "radio",
						def: 0,
						options: [
							{ "label": "Ya", "value": 1 },
							{ "label": "Tidak", "value": 0 }
						]
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
			});

            edtgdnxxsh.on( 'preSubmit', function (e, data, action) {
				if(action != 'remove'){
					
					// BEGIN of validasi gdnxxsh.nama
					if ( ! edtgdnxxsh.field('gdnxxsh.nama').isMultiValue() ) {
						nama = edtgdnxxsh.field('gdnxxsh.nama').val();
						if(!nama || nama == ''){
							edtgdnxxsh.field('gdnxxsh.nama').error( 'Wajib diisi!' );
						}
					}
					// END of validasi gdnxxsh.nama

					// BEGIN of validasi gdnxxsh.mode
					if ( ! edtgdnxxsh.field('gdnxxsh.mode').isMultiValue() ) {
						mode = edtgdnxxsh.field('gdnxxsh.mode').val();
						if(!mode || mode == ''){
							edtgdnxxsh.field('gdnxxsh.mode').error( 'Wajib diisi!' );
						}
					}
					// END of validasi gdnxxsh.mode

					// BEGIN of validasi gdnxxsh.nama_tabel
					if ( ! edtgdnxxsh.field('gdnxxsh.nama_tabel').isMultiValue() ) {
						nama_tabel = edtgdnxxsh.field('gdnxxsh.nama_tabel').val();
						if(!nama_tabel || nama_tabel == ''){
							edtgdnxxsh.field('gdnxxsh.nama_tabel').error( 'Wajib diisi!' );
						}
					}
					// END of validasi gdnxxsh.nama_tabel

					// BEGIN of validasi gdnxxsh.total_digit
					if ( ! edtgdnxxsh.field('gdnxxsh.total_digit').isMultiValue() ) {
						total_digit = edtgdnxxsh.field('gdnxxsh.total_digit').val();
						if(!total_digit || total_digit == ''){
							edtgdnxxsh.field('gdnxxsh.total_digit').error( 'Wajib diisi!' );
						}
					}
					// END of validasi gdnxxsh.total_digit
						
					// BEGIN of cek unik gdnxxsh
					nama_tabel = edtgdnxxsh.field('gdnxxsh.nama_tabel').val();
					kategori_dokumen = edtgdnxxsh.field('gdnxxsh.kategori_dokumen').val();
					kategori_dokumen_value = edtgdnxxsh.field('gdnxxsh.kategori_dokumen_value').val();
					if(action == 'create'){
						id_gdnxxsh = 0;
					}
					
					$.ajax( {
						url: '../../../helpers/validate_fn_unique.php',
						dataType: 'json',
						type: 'POST',
						async: false,
						data: {
							table_name       : 'gdnxxsh',
							nama_field       : 'nama_tabel,kategori_dokumen,kategori_dokumen_value',
							nama_field_value : '"'+ nama_tabel + '","' + kategori_dokumen + '","' + kategori_dokumen_value + '"',
							id_transaksi     : id_gdnxxsh
						},
						success: function ( json ) {
							if(json.data.count == 1){
								edtgdnxxsh.field('gdnxxsh.nama_tabel').error( 'Kombinasi Nama Tabel dan Kategori Dokumen sudah ada!' );
								edtgdnxxsh.field('gdnxxsh.kategori_dokumen').error( 'Kombinasi Nama Tabel dan Kategori Dokumen sudah ada!' );
								edtgdnxxsh.field('gdnxxsh.kategori_dokumen_value').error( 'Kombinasi Nama Tabel dan Kategori Dokumen sudah ada!' );
							}else if (json.data.count == -1){
								edtgdnxxsh.error( json.data.message );
							}

						}
					} );
					// END of cek unik gdnxxsh

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

			//start datatables
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
								return 'prefix/tahunbulan/nomorurut';
							}else if(data == 2){
								return 'P00001';
							}else if(data == 3){
								return 'Urut/Prefix/Suffix/Bulan Romawi/Tahun 4 Digit';
							}else if(data == 4){
								return 'Cabang/Prefix/Tahun/Bulan/nomorurut';
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
						$arr_buttons_approve 	= ['approve', 'cancel_approve', 'void','noapprove'];
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
				gdnxxsh_data    		= tblgdnxxsh.row( { selected: true } ).data().gdnxxsh;
				id_gdnxxsh      		= gdnxxsh_data.id;
				id_transaksi_h 		= id_gdnxxsh; // dipakai untuk general
				id_transaksi_log	= id_gdnxxsh; // dipakai untuk general
				transaction_state   = gdnxxsh_data.transaction_state;
				approval_state   	= gdnxxsh_data.approval_state;
				is_nextprocess 		= gdnxxsh_data.is_nextprocess;
				is_jurnal      		= gdnxxsh_data.is_jurnal;

				// atur hak akses
				CekSelectHeaderH(tblgdnxxsh);
			} );

			tblgdnxxsh.on( 'deselect', function () {
				// reload dipanggil di function CekDeselectHeader
				id_gdnxxsh = '';

				// atur hak akses
				CekDeselectHeaderH(tblgdnxxsh);
			} );
			
		} );// end of document.ready
	
	</script>

<!-- END datatables here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
