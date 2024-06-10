<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'lvtxxmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div id="frmlvtxxmh">
					<div class="panel-body">
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="lvtxxmh.kode"></editor-field>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="lvtxxmh.nama"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="lvtxxmh.golongan"></editor-field>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="lvtxxmh.keterangan"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="lvtxxmh.berat_maksimal"></editor-field>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="lvtxxmh.dimensi_maksimal"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="lvtxxmh.panjang"></editor-field>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="lvtxxmh.lebar"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="lvtxxmh.tinggi"></editor-field>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<editor-field name="lvtxxmh.insentif"></editor-field>
							</div>
						</div>
					</div>
				</div>
				<div class="table-responsive">
                    <table id="tbllvtxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Berat Max</th>
                                <th>Dimensi Max</th>
                                <th>Insentif</th>
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
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn2.js"></script>

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/lvtxxmh/fn/lvtxxmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtlvtxxmh, tbllvtxxmh, show_deleted_lvtxxmh = 0, id_lvtxxmh;
	// ------------- end of default variable
	
	// get tableRelation
	tableRelation('lvtxxmh');

	$(document).ready(function() {

		//start datatables editor
		edtlvtxxmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/lvtxxmh/lvtxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_lvtxxmh = show_deleted_lvtxxmh;
				}
			},
			table: "#tbllvtxxmh",
			template: "#frmlvtxxmh",
			fields: [ 
				{
					label: "lvtxxmh.start_at",
					name: "lvtxxmh.start_at",
					type: "hidden"
				},	
				{
					label: "lvtxxmh.finish_at",
					name: "lvtxxmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "lvtxxmh",
					type: "hidden"
				},	
				{
					label: "lvtxxmh.transaction_state",
					name: "lvtxxmh.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "Kode <sup class='text-danger'>*<sup>",
					name: "lvtxxmh.kode"
				}, 	
				{
					label: "Nama <sup class='text-danger'>*<sup>",
					name: "lvtxxmh.nama"
				}, 	
				{
					label: "Golongan",
					name: "lvtxxmh.golongan",
				},
				{
					label: "Berat Maksimal (kg)",
					name: "lvtxxmh.berat_maksimal",
				},
				{
					label: "Dimensi Maksimal (m<sup>3</sup>)",
					name: "lvtxxmh.dimensi_maksimal",
				},
				{
					label: "Panjang (m)",
					name: "lvtxxmh.panjang"
				},
				{
					label: "Lebar (m)",
					name: "lvtxxmh.lebar"
				},
				{
					label: "Tinggi (m)",
					name: "lvtxxmh.tinggi"
				},
				{
					label: "Insentif (Rp)",
					name: "lvtxxmh.insentif"
				},
				{
					label: "Keterangan",
					name: "lvtxxmh.keterangan",
					type: "textarea"
				}
			]
		} );

		edtlvtxxmh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtlvtxxmh.field('lvtxxmh.start_at').val(start_at);
			
			if(action == 'create'){
				tbllvtxxmh.rows().deselect();
				edtlvtxxmh.field('lvtxxmh.kode').enable();
			}else if(action == 'edit'){
				
				if(transaction_state == 0){
					edtlvtxxmh.field('lvtxxmh.kode').enable();
					edtlvtxxmh.field('lvtxxmh.nama').enable();
				}else{
					edtlvtxxmh.field('lvtxxmh.kode').disable();
					edtlvtxxmh.field('lvtxxmh.nama').disable();
				}
			}
		});

		edtlvtxxmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-xl");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edtlvtxxmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				kode             = edtlvtxxmh.field('lvtxxmh.kode').val();
				nama             = edtlvtxxmh.field('lvtxxmh.nama').val();
				berat_maksimal   = edtlvtxxmh.field('lvtxxmh.berat_maksimal').val();
				dimensi_maksimal = edtlvtxxmh.field('lvtxxmh.dimensi_maksimal').val();
				panjang          = edtlvtxxmh.field('lvtxxmh.panjang').val();
				lebar            = edtlvtxxmh.field('lvtxxmh.lebar').val();
				tinggi           = edtlvtxxmh.field('lvtxxmh.tinggi').val();
				insentif         = edtlvtxxmh.field('lvtxxmh.insentif').val();

				validasiRequired(
					edtlvtxxmh,
					'lvtxxmh',
					{
						'kode': kode,
						'nama': nama
					}
				);

				validasiUnique(
					action,
					edtlvtxxmh,
					'lvtxxmh',
					'kode',
					'kode',
					'"'+kode+'"',
					id_lvtxxmh
				);

				validasiUnique(
					action,
					edtlvtxxmh,
					'lvtxxmh',
					'nama',
					'nama',
					'"'+nama+'"',
					id_lvtxxmh
				);

				validasiNumber(
					edtlvtxxmh,
					'lvtxxmh',
					{
						'berat_maksimal': berat_maksimal,
						'dimensi_maksimal': dimensi_maksimal,
						'panjang': panjang,
						'lebar': lebar,
						'tinggi': tinggi,
						'insentif': insentif
					},
					0,
					'>='
				);
			}
			
			if ( edtlvtxxmh.inError() ) {
				return false;
			}
		});
		
		edtlvtxxmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtlvtxxmh.field('lvtxxmh.finish_at').val(finish_at);
		});

		edtlvtxxmh.on( 'close', function () {
			edtlvtxxmh.enable();
		} );

		tbllvtxxmh = $('#tbllvtxxmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/lvtxxmh/lvtxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_lvtxxmh = show_deleted_lvtxxmh;
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
					targets: [0,4,5,6]
				}
			],
			columns: [
				{ data: "lvtxxmh.id",visible:false },
				{ data: "lvtxxmh.kode" },
				{ data: "lvtxxmh.nama" },
				{ 
					data: "lvtxxmh.berat_maksimal" ,
					...renderNumber(2)
				},
				{ 
					data: "lvtxxmh.dimensi_maksimal" ,
					...renderNumber(2)
				},
				{ 
					data: "lvtxxmh.insentif" ,
					...renderNumber(2)
				},
				{ 
					data: "lvtxxmh.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_lvtxxmh';
					$table       = 'tbllvtxxmh';
					$edt         = 'edtlvtxxmh';
					$show_status = '_lvtxxmh';
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
				if ( data.lvtxxmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.lvtxxmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tbllvtxxmh.searchPanes.container().appendTo('#splvtxxmh');
		tbllvtxxmh.searchBuilder.container().appendTo( '#sblvtxxmh' );
		
		tbllvtxxmh.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tbllvtxxmh);
		} );
		
		tbllvtxxmh.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('lvtxxmh');

			// atur hak akses
			CekSelectHeaderH(tbllvtxxmh);
		} );

		tbllvtxxmh.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('lvtxxmh');

			// atur hak akses
			CekDeselectHeaderH(tbllvtxxmh);
		} );
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
