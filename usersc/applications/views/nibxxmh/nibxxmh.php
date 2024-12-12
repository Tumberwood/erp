<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'nibxxmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblnibxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Kode</th>
                                <th>Nama</th>
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
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/nibxxmh/fn/nibxxmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtnibxxmh, tblnibxxmh, show_deleted_nibxxmh = 0, id_nibxxmh;
	// ------------- end of default variable
	
	// get tableRelation
	tableRelation('nibxxmh');

	$(document).ready(function() {
		// BEGIN nibxxmh
		edtnibxxmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/nibxxmh/nibxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_nibxxmh = show_deleted_nibxxmh;
				}
			},
			table: "#tblnibxxmh",
			fields: [ 
				{
					label: "nibxxmh.start_at",
					name: "nibxxmh.start_at",
					type: "hidden"
				},	
				{
					label: "nibxxmh.finish_at",
					name: "nibxxmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "nibxxmh",
					type: "hidden"
				},	
				{
					label: "nibxxmh.transaction_state",
					name: "nibxxmh.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "Kode <sup class='text-danger'>*<sup>",
					name: "nibxxmh.kode"
				}, 	
				{
					label: "Nama <sup class='text-danger'>*<sup>",
					name: "nibxxmh.nama"
				}, 	
				{
					label: "Keterangan",
					name: "nibxxmh.keterangan",
					type: "textarea"
				}
			]
		} );

		edtnibxxmh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtnibxxmh.field('nibxxmh.start_at').val(start_at);
			
			if(action == 'create'){
				tblnibxxmh.rows().deselect();
				edtnibxxmh.field('nibxxmh.kode').enable();
				edtnibxxmh.field('nibxxmh.nama').enable();
			}else if(action == 'edit'){
				if(transaction_state == 0){
					edtnibxxmh.field('nibxxmh.kode').enable();
					edtnibxxmh.field('nibxxmh.nama').enable();
				}else{
					edtnibxxmh.field('nibxxmh.kode').disable();
					edtnibxxmh.field('nibxxmh.nama').disable();
				}
			}
		});

		edtnibxxmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			edtFormButtonSaveConfirm();
		});

		edtnibxxmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				kode = edtnibxxmh.field('nibxxmh.kode').val();
				nama = edtnibxxmh.field('nibxxmh.nama').val();

				validasiRequired(
					edtnibxxmh,
					'nibxxmh',
					{
						'kode': kode,
						'nama': nama
					}
				);

				validasiUnique(
					action,
					edtnibxxmh,
					'nibxxmh',
					'kode',
					'kode',
					'"'+kode+'"',
					id_nibxxmh
				);

				validasiUnique(
					action,
					edtnibxxmh,
					'nibxxmh',
					'nama',
					'nama',
					'"'+nama+'"',
					id_nibxxmh
				);
			}
			
			if ( edtnibxxmh.inError() ) {
				return false;
			}
		});
		
		edtnibxxmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtnibxxmh.field('nibxxmh.finish_at').val(finish_at);
		});

		edtnibxxmh.on( 'close', function () {
			edtnibxxmh.enable();
		} );

		tblnibxxmh = $('#tblnibxxmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/nibxxmh/nibxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_nibxxmh = show_deleted_nibxxmh;
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
				{ data: "nibxxmh.id",visible:false },
				{ data: "nibxxmh.kode" },
				{ data: "nibxxmh.nama" },
				{ data: "nibxxmh.keterangan" },
				{ 
					data: "nibxxmh.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_nibxxmh';
					$table       = 'tblnibxxmh';
					$edt         = 'edtnibxxmh';
					$show_status = '_nibxxmh';
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
				if ( data.nibxxmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.nibxxmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblnibxxmh.searchPanes.container().appendTo('#spnibxxmh');
		tblnibxxmh.searchBuilder.container().appendTo( '#sbnibxxmh' );
		
		tblnibxxmh.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblnibxxmh);
		} );
		
		tblnibxxmh.on( 'select', function( e, dt, type, indexes ) {
			siVarSet('nibxxmh');

			// atur hak akses
			CekSelectHeaderH(tblnibxxmh);
		} );

		tblnibxxmh.on( 'deselect', function () {
			siVarReset('nibxxmh');

			// atur hak akses
			CekDeselectHeaderH(tblnibxxmh);
		} );

		// END nibxxmh
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
