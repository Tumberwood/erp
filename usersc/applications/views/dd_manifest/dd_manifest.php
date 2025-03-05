<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'dd_manifest';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tbldd_manifest" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Pengirim</th>
                                <th>Alamat Pengirim</th>
                                <th>Telepon Pengirim</th>
                                <th>Passport Pengirim</th>
                                <th>Status PMI</th>
                                <th>Nama Penerima</th>
                                <th>Alamat Penerima</th>
                                <th>Telepon Penerima</th>
                                <th>Koli Ke</th>
                                <th>Ukuran</th>
                                <th>Berat</th>
                                <th>Uraian Barang</th>
                                <th data-priority="1">ID Box / AWB Barcode</th>
                                <th>State</th>
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
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn2.js"></script>
<script src="<?=$us_url_root?>usersc/helpers/language.js"></script>

<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/dd_manifest/fn/dd_manifest_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtdd_manifest, tbldd_manifest, show_deleted_dd_manifest = 0, id_dd_manifest;
	// ------------- end of default variable
	
	// get tableRelation
	tableRelation('dd_manifest');

	function generateBarcodes() {
    $(".barcode").each(function() {
        var code = $(this).data('code');

		if (code) {
				JsBarcode(this, code, {
					format: "CODE128",
					displayValue: false,
					width: 1,
					height: 50,
					fontSize: 14,
					margin: 5
				});
			}
		});
	}


	$(document).ready(function() {
		// BEGIN dd_manifest
		edtdd_manifest = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/dd_manifest/dd_manifest.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_dd_manifest = show_deleted_dd_manifest;
				}
			},
			table: "#tbldd_manifest",
			fields: [ 
				{
					label: "dd_manifest.start_at",
					name: "dd_manifest.start_at",
					type: "hidden"
				},	
				{
					label: "dd_manifest.finish_at",
					name: "dd_manifest.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "dd_manifest",
					type: "hidden"
				},	
				{
					label: "dd_manifest.transaction_state",
					name: "dd_manifest.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "Nama Pengirim <sup class='text-danger'>*<sup>",
					name: "dd_manifest.nama_pengirim"
				}, 	
				{
					label: "Alamat Pengirim <sup class='text-danger'>*<sup>",
					name: "dd_manifest.alamat_pengirim"
				}, 	
				{
					label: "Telepon Pengirim <sup class='text-danger'>*<sup>",
					name: "dd_manifest.telepon_pengirim"
				}, 
				{
					label: "Passport Pengirim <sup class='text-danger'>*<sup>",
					name: "dd_manifest.passport_pengirim"
				}, 	
				{
					label: "Status PMI <sup class='text-danger'>*<sup>",
					name: "dd_manifest.status_pmi",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": "BP2MI", "value": "BP2MI" },
						{ "label": "Reguler", "value": "Reguler" }
					]
				},
				{
					label: "Nama Penerima <sup class='text-danger'>*<sup>",
					name: "dd_manifest.nama_penerima"
				}, 	
				{
					label: "Alamat Penerima <sup class='text-danger'>*<sup>",
					name: "dd_manifest.alamat_penerima"
				}, 	
				{
					label: "Telepon Penerima <sup class='text-danger'>*<sup>",
					name: "dd_manifest.telepon_penerima"
				}, 
				{
					label: "Koli Ke- <sup class='text-danger'>*<sup>",
					name: "dd_manifest.koli_ke",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": "1", "value": "1" },
						{ "label": "2", "value": "2" },
						{ "label": "3", "value": "3" }
					]
				}, 	
				{
					label: "Ukuran <sup class='text-danger'>*<sup>",
					name: "dd_manifest.ukuran",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": "XL (60X60X80)", "value": "XL (60X60X80)" },
						{ "label": "L (60X60X60)", "value": "L (60X60X60)" },
						{ "label": "M (60X60X30)", "value": "M (60X60X30)" }
					]
				}, 	
				
				{
					label: "Berat <sup class='text-danger'>*<sup>",
					name: "dd_manifest.berat"
				}, 	
				{
					label: "Uraian Barang <sup class='text-danger'>*<sup>",
					name: "dd_manifest.uraian_barang"
				}, 	
				{
					label: "ID Box / AWB Barcode <sup class='text-danger'>*<sup>",
					name: "dd_manifest.kode",
					type: "readonly"
				}
			]
		} );

		edtdd_manifest.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtdd_manifest.field('dd_manifest.start_at').val(start_at);
			
			if(action == 'create'){
				tbldd_manifest.rows().deselect();
			}else if(action == 'edit'){
				
			}
		});

		edtdd_manifest.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
			
			$(".barcode-form").remove();
			var kode = edtdd_manifest.field('dd_manifest.kode').val();
			if (kode !== "") {
				// Tambahkan elemen barcode baru
				$('#DTE_Field_dd_manifest-kode').after('<svg class="barcode-form"></svg>');

				// Ambil elemen terakhir yang baru dibuat untuk memastikan barcode tampil
				JsBarcode($('.barcode-form').last()[0], kode, {
					format: "CODE128",
					width: 1,
					height: 50,
					displayValue: true
				});
			}
			
		});

		edtdd_manifest.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				nama_pengirim     = edtdd_manifest.field('dd_manifest.nama_pengirim').val();
				alamat_pengirim   = edtdd_manifest.field('dd_manifest.alamat_pengirim').val();
				telepon_pengirim  = edtdd_manifest.field('dd_manifest.telepon_pengirim').val();
				passport_pengirim = edtdd_manifest.field('dd_manifest.passport_pengirim').val();
				status_pmi        = edtdd_manifest.field('dd_manifest.status_pmi').val();
				nama_penerima     = edtdd_manifest.field('dd_manifest.nama_penerima').val();
				alamat_penerima   = edtdd_manifest.field('dd_manifest.alamat_penerima').val();
				telepon_penerima  = edtdd_manifest.field('dd_manifest.telepon_penerima').val();
				koli_ke           = edtdd_manifest.field('dd_manifest.koli_ke').val();
				ukuran            = edtdd_manifest.field('dd_manifest.ukuran').val();
				berat             = edtdd_manifest.field('dd_manifest.berat').val();
				uraian_barang     = edtdd_manifest.field('dd_manifest.uraian_barang').val();

				validasiRequired(
					edtdd_manifest,
					'dd_manifest',
					{
						'nama_pengirim'    : nama_pengirim,
						'alamat_pengirim'  : alamat_pengirim,
						'telepon_pengirim' : telepon_pengirim,
						'passport_pengirim': passport_pengirim,
						'status_pmi'       : status_pmi,
						'nama_penerima'    : nama_penerima,
						'alamat_penerima'  : alamat_penerima,
						'telepon_penerima' : telepon_penerima,
						'koli_ke'          : koli_ke,
						'ukuran'           : ukuran,
						'berat'            : berat,
						'uraian_barang'    : uraian_barang
					}
				);

				if(berat <= 0 ){
					edtdd_manifest.field('dd_manifest.berat').error( 'Inputan harus > 0' );
				}
				if(isNaN(berat) ){
					edtdd_manifest.field('dd_manifest.berat').error( 'Inputan harus berupa Angka!' );
				}

			}
			
			if ( edtdd_manifest.inError() ) {
				return false;
			}
		});
		
		edtdd_manifest.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtdd_manifest.field('dd_manifest.finish_at').val(finish_at);
		});

		edtdd_manifest.on( 'close', function () {
			edtdd_manifest.enable();
		} );

		tbldd_manifest = $('#tbldd_manifest').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/dd_manifest/dd_manifest.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_dd_manifest = show_deleted_dd_manifest;
				}
			},
			order: [[ 0, "asc" ]],
			columnDefs:[
				{
					searchPanes:{
						show: true,
					},
					targets: [5,9]
				},
				{
					searchPanes:{
						show: false,
					},
					targets: '_all'
				}
			],
			columns: [
				{ data: "dd_manifest.id",visible:false },
				{ data: "dd_manifest.nama_pengirim" },
				{ data: "dd_manifest.alamat_pengirim" },
				{ data: "dd_manifest.telepon_pengirim" },
				{ data: "dd_manifest.passport_pengirim" },
				{ data: "dd_manifest.status_pmi" },
				{ data: "dd_manifest.nama_penerima" },
				{ data: "dd_manifest.alamat_penerima" },
				{ data: "dd_manifest.telepon_penerima" },
				{ data: "dd_manifest.koli_ke" },
				{ data: "dd_manifest.ukuran" },
				{ data: "dd_manifest.berat" },
				{ data: "dd_manifest.uraian_barang" },
				{ 
					data: "dd_manifest.kode" ,
					render: function (data, type, row) {
						if (type === 'display' || data != "") {
							return '<svg class="barcode" data-code="'+ data +'"></svg>';
						}
						return data;
					}
				},
				{ 
					data: "dd_manifest.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_dd_manifest';
					$table       = 'tbldd_manifest';
					$edt         = 'edtdd_manifest';
					$show_status = '_dd_manifest';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= ['sp', 'sb'];
					$arr_buttons_action 	= ['create', 'edit', 'remove', 'confirm', 'nonaktif_h', 'close', 'view', 'log','noaction'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
				// END breaking generate button,
				{
					text: '<i class="fa fa-print"></i>',
					name: 'btnPrintManifest',
					className: 'btn btn-sm btn-outline',
					titleAttr: 'Print Manifest',
					action: function ( e, dt, node, config ) {
						e.preventDefault(); 
						var url = $(this).attr('href'); 
						window.open('dd_manifest_print.php?id_dd_manifest=' + id_dd_manifest ,'_blank');
					}
				}
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
				if ( data.dd_manifest.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.dd_manifest.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			},
			drawCallback: function() {
				$('.barcode').each(function() {
					var code = $(this).data('code');
					if(code != ""){
						JsBarcode(this, code, {
							format: "CODE128",
							width: 1,  // Lebar tiap batang (default 2)
							height: 50, // Tinggi barcode (default 100)
							displayValue: true, // Tampilkan teks di bawah barcode
							fontSize: 14, // Ukuran teks
							margin: 5 // Jarak di sekitar barcode
						});
					}
				});
			}
		} );

		tbldd_manifest.searchPanes.container().appendTo('#spdd_manifest');
		tbldd_manifest.searchBuilder.container().appendTo( '#sbdd_manifest' );
		
		tbldd_manifest.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tbldd_manifest);

			tbldd_manifest.button( 'btnPrintManifest:name' ).disable();
		} );
		
		tbldd_manifest.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('dd_manifest');
			// atur hak akses
			CekSelectHeaderH(tbldd_manifest);

			if(transaction_state == 1){
				tbldd_manifest.button( 'btnPrintManifest:name' ).enable();
			}else{
				tbldd_manifest.button( 'btnPrintManifest:name' ).disable();
			}
		} );

		tbldd_manifest.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('dd_manifest');

			// atur hak akses
			CekDeselectHeaderH(tbldd_manifest);
			tbldd_manifest.button( 'btnPrintManifest:name' ).disable();
		} );

		// END dd_manifest
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
