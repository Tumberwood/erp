<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'wpkxxmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div id="frmwpkxxmh">
					<div class="panel-body">
						<h5 class="text-secondary">UoM Weight & Dimension mengikuti General Setting</h5>
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="wpkxxmh.kode"></editor-field>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="wpkxxmh.nama"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="wpkxxmh.keterangan"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="wpkxxmh.nw"></editor-field>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="wpkxxmh.gw"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
								<editor-field name="wpkxxmh.panjang"></editor-field>
							</div>
							<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
								<editor-field name="wpkxxmh.lebar"></editor-field>
							</div>
							<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
								<editor-field name="wpkxxmh.tinggi"></editor-field>
							</div>
						</div>
					</div>
				</div>
				<div class="table-responsive">
                    <table id="tblwpkxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th data-i18n="code"></th>
                                <th data-i18n="name"></th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/wpkxxmh/fn/wpkxxmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtwpkxxmh, tblwpkxxmh, show_deleted_wpkxxmh = 0, id_wpkxxmh;
	// ------------- end of default variable
	
	// get tableRelation
	tableRelation('wpkxxmh');

	$(document).ready(function() {
		autofillField('ggswmsh', 1, 'id_iumxxmh_berat,id_iumxxmh_panjang');
		var id_iumxxmh_panjang = autofillData.id_iumxxmh_panjang;
		var id_iumxxmh_berat = autofillData.id_iumxxmh_berat;
		
		autofillField('iumxxmh', id_iumxxmh_panjang, 'kode');
		var uom_panjang = "("+autofillData.kode+")";

		autofillField('iumxxmh', id_iumxxmh_berat, 'kode');
		var uom_berat =  "("+autofillData.kode+")";

		// BEGIN wpkxxmh
		edtwpkxxmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/wpkxxmh/wpkxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_wpkxxmh = show_deleted_wpkxxmh;
				}
			},
			table: "#tblwpkxxmh",
			template: "#frmwpkxxmh",
			fields: [ 
				{
					label: "wpkxxmh.start_at",
					name: "wpkxxmh.start_at",
					type: "hidden"
				},	
				{
					label: "wpkxxmh.finish_at",
					name: "wpkxxmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "wpkxxmh",
					type: "hidden"
				},	
				{
					label: "wpkxxmh.transaction_state",
					name: "wpkxxmh.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: getTranslation('code') + "<sup class='text-danger'>*<sup>",
					name: "wpkxxmh.kode"
				}, 	
				{
					label: getTranslation('name') + "<sup class='text-danger'>*<sup>",
					name: "wpkxxmh.nama"
				}, 	
				{
					label: getTranslation('notes'),
					name: "wpkxxmh.keterangan",
					type: "textarea"
				},
				{
					label: "Net Weight "+uom_berat,
					name: "wpkxxmh.nw"
				},
				{
					label: "Gross Weight "+uom_berat,
					name: "wpkxxmh.gw"
				},
				{
					label: "Length "+uom_panjang,
					name: "wpkxxmh.panjang"
				},
				{
					label: "Width "+uom_panjang,
					name: "wpkxxmh.lebar"
				},
				{
					label: "Height "+uom_panjang,
					name: "wpkxxmh.tinggi"
				},
			]
		} );

		edtwpkxxmh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtwpkxxmh.field('wpkxxmh.start_at').val(start_at);
			
			if(action == 'create'){
				tblwpkxxmh.rows().deselect();
				edtwpkxxmh.field('wpkxxmh.kode').enable();
				edtwpkxxmh.field('wpkxxmh.nama').enable();
			}else if(action == 'edit'){
				if(transaction_state == 0){
					edtwpkxxmh.field('wpkxxmh.kode').enable();
					edtwpkxxmh.field('wpkxxmh.nama').enable();
				}else{
					edtwpkxxmh.field('wpkxxmh.kode').disable();
					edtwpkxxmh.field('wpkxxmh.nama').disable();
				}
			}
		});

		edtwpkxxmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edtwpkxxmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				kode = edtwpkxxmh.field('wpkxxmh.kode').val();
				nama = edtwpkxxmh.field('wpkxxmh.nama').val();
				panjang         = edtwpkxxmh.field('wpkxxmh.panjang').val();
				lebar           = edtwpkxxmh.field('wpkxxmh.lebar').val();
				tinggi          = edtwpkxxmh.field('wpkxxmh.tinggi').val();
				nw              = edtwpkxxmh.field('wpkxxmh.nw').val();
				gw              = edtwpkxxmh.field('wpkxxmh.gw').val();

				validasiRequired(
					edtwpkxxmh,
					'wpkxxmh',
					{
						'kode': kode,
						'nama': nama
					}
				);

				validasiUnique(
					action,
					edtwpkxxmh,
					'wpkxxmh',
					'kode',
					'kode',
					'"'+kode+'"',
					id_wpkxxmh
				);

				validasiUnique(
					action,
					edtwpkxxmh,
					'wpkxxmh',
					'nama',
					'nama',
					'"'+nama+'"',
					id_wpkxxmh
				);

				validasiNumber(
					edtwpkxxmh, 
					'wpkxxmh', 
					{
						'panjang': panjang, 
						'lebar': lebar, 
						'tinggi': tinggi, 
						'nw': nw, 
						'gw': gw
					},
					0,
					'>='
				);
			}
			
			if ( edtwpkxxmh.inError() ) {
				return false;
			}
		});
		
		edtwpkxxmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtwpkxxmh.field('wpkxxmh.finish_at').val(finish_at);
		});

		edtwpkxxmh.on( 'close', function () {
			edtwpkxxmh.enable();
		} );

		tblwpkxxmh = $('#tblwpkxxmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/wpkxxmh/wpkxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_wpkxxmh = show_deleted_wpkxxmh;
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
					targets: '_all'
				}
			],
			columns: [
				{ data: "wpkxxmh.id",visible:false },
				{ data: "wpkxxmh.kode" },
				{ data: "wpkxxmh.nama" },
				{ 
					data: "wpkxxmh.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_wpkxxmh';
					$table       = 'tblwpkxxmh';
					$edt         = 'edtwpkxxmh';
					$show_status = '_wpkxxmh';
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
				if ( data.wpkxxmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.wpkxxmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblwpkxxmh.searchPanes.container().appendTo('#spwpkxxmh');
		tblwpkxxmh.searchBuilder.container().appendTo( '#sbwpkxxmh' );
		
		tblwpkxxmh.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblwpkxxmh);
		} );
		
		tblwpkxxmh.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('wpkxxmh');

			// atur hak akses
			CekSelectHeaderH(tblwpkxxmh);
		} );

		tblwpkxxmh.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('wpkxxmh');

			// atur hak akses
			CekDeselectHeaderH(tblwpkxxmh);
		} );

		// END wpkxxmh
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
