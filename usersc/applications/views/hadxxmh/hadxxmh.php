<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'hadxxmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblhadxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Masa Berlaku</th>
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
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn2.js"></script>
<script src="<?=$us_url_root?>usersc/helpers/language.js"></script>
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/hadxxmh/fn/hadxxmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edthadxxmh, tblhadxxmh, show_deleted_hadxxmh = 0, id_hadxxmh;
	// ------------- end of default variable
	
	// get tableRelation
	tableRelation('hadxxmh');

	$(document).ready(function() {
		// BEGIN hadxxmh
		edthadxxmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/hadxxmh/hadxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hadxxmh = show_deleted_hadxxmh;
				}
			},
			table: "#tblhadxxmh",
			fields: [ 
				{
					label: "hadxxmh.start_at",
					name: "hadxxmh.start_at",
					type: "hidden"
				},	
				{
					label: "hadxxmh.finish_at",
					name: "hadxxmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "hadxxmh",
					type: "hidden"
				},	
				{
					label: "hadxxmh.transaction_state",
					name: "hadxxmh.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "Kode <sup class='text-danger'>*<sup>",
					name: "hadxxmh.kode"
				}, 	
				{
					label: "Nama <sup class='text-danger'>*<sup>",
					name: "hadxxmh.nama"
				}, 	
				{
					label: "Masa Berlaku (Hari) <sup class='text-danger'>*<sup>",
					name: "hadxxmh.masa_berlaku_hari"
				}, 	
				{
					label: "Keterangan",
					name: "hadxxmh.keterangan",
					type: "textarea"
				}
			]
		} );

		edthadxxmh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthadxxmh.field('hadxxmh.start_at').val(start_at);
			
			if(action == 'create'){
				tblhadxxmh.rows().deselect();
				edthadxxmh.field('hadxxmh.kode').enable();
				edthadxxmh.field('hadxxmh.nama').enable();
			}else if(action == 'edit'){
				if(transaction_state == 0){
					edthadxxmh.field('hadxxmh.kode').enable();
					edthadxxmh.field('hadxxmh.nama').enable();
				}else{
					edthadxxmh.field('hadxxmh.kode').disable();
					edthadxxmh.field('hadxxmh.nama').disable();
				}
			}
		});

		edthadxxmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edthadxxmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				kode = edthadxxmh.field('hadxxmh.kode').val();
				nama = edthadxxmh.field('hadxxmh.nama').val();
				masa_berlaku_hari = edthadxxmh.field('hadxxmh.masa_berlaku_hari').val();

				validasiRequired(
					edthadxxmh,
					'hadxxmh',
					{
						'kode': kode,
						'nama': nama,
						'masa_berlaku_hari': masa_berlaku_hari,
					}
				);

				validasiUnique(
					action,
					edthadxxmh,
					'hadxxmh',
					'kode',
					'kode',
					'"'+kode+'"',
					id_hadxxmh
				);

				validasiUnique(
					action,
					edthadxxmh,
					'hadxxmh',
					'nama',
					'nama',
					'"'+nama+'"',
					id_hadxxmh
				);
			}
			
			if ( edthadxxmh.inError() ) {
				return false;
			}
		});
		
		edthadxxmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthadxxmh.field('hadxxmh.finish_at').val(finish_at);
		});

		edthadxxmh.on( 'close', function () {
			edthadxxmh.enable();
		} );

		tblhadxxmh = $('#tblhadxxmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/hadxxmh/hadxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hadxxmh = show_deleted_hadxxmh;
				}
			},
			order: [[ 1, "asc" ]],
			columnDefs:[
				{
					searchPanes:{
						show: true,
					},
					targets: [1,2,5]
				},
				{
					searchPanes:{
						show: false,
					},
					targets: '_all'
				}
			],
			columns: [
				{ data: "hadxxmh.id",visible:false },
				{ data: "hadxxmh.kode" },
				{ data: "hadxxmh.nama" },
				{ 
					data: "hadxxmh.masa_berlaku_hari" ,
					...renderNumber()
				},
				{ data: "hadxxmh.keterangan" },
				{ 
					data: "hadxxmh.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hadxxmh';
					$table       = 'tblhadxxmh';
					$edt         = 'edthadxxmh';
					$show_status = '_hadxxmh';
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
				if ( data.hadxxmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.hadxxmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblhadxxmh.searchPanes.container().appendTo('#sphadxxmh');
		tblhadxxmh.searchBuilder.container().appendTo( '#sbhadxxmh' );
		
		tblhadxxmh.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblhadxxmh);
		} );
		
		tblhadxxmh.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('hadxxmh');

			// atur hak akses
			CekSelectHeaderH(tblhadxxmh);
		} );

		tblhadxxmh.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('hadxxmh');

			// atur hak akses
			CekDeselectHeaderH(tblhadxxmh);
		} );

		// END hadxxmh
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
