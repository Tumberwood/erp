<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'lacxxmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tbllacxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
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
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/lacxxmh/fn/lacxxmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtlacxxmh, tbllacxxmh, show_deleted_lacxxmh = 0, id_lacxxmh;
	// ------------- end of default variable
	
	// get tableRelation
	tableRelation('lacxxmh');

	$(document).ready(function() {
		// BEGIN lacxxmh
		edtlacxxmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/lacxxmh/lacxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_lacxxmh = show_deleted_lacxxmh;
				}
			},
			table: "#tbllacxxmh",
			fields: [ 
				{
					label: "lacxxmh.start_at",
					name: "lacxxmh.start_at",
					type: "hidden"
				},	
				{
					label: "lacxxmh.finish_at",
					name: "lacxxmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "lacxxmh",
					type: "hidden"
				},	
				{
					label: "lacxxmh.transaction_state",
					name: "lacxxmh.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "Kode <sup class='text-danger'>*<sup>",
					name: "lacxxmh.kode"
				}, 	
				{
					label: "Nama <sup class='text-danger'>*<sup>",
					name: "lacxxmh.nama"
				}, 	
				{
					label: "Keterangan",
					name: "lacxxmh.keterangan",
					type: "textarea"
				}
			]
		} );

		edtlacxxmh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtlacxxmh.field('lacxxmh.start_at').val(start_at);
			
			if(action == 'create'){
				tbllacxxmh.rows().deselect();
			}else if(action == 'edit'){
				
				if(transaction_state == 0){
					edtlacxxmh.field('lacxxmh.kode').enable();
					edtlacxxmh.field('lacxxmh.nama').enable();
				}else{
					edtlacxxmh.field('lacxxmh.kode').disable();
					edtlacxxmh.field('lacxxmh.nama').disable();
				}
			}
		});

		edtlacxxmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edtlacxxmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				kode = edtlacxxmh.field('lacxxmh.kode').val();
				nama = edtlacxxmh.field('lacxxmh.nama').val();

				validasiRequired(
					edtlacxxmh,
					'lacxxmh',
					{
						'kode': kode,
						'nama': nama
					}
				);

				validasiUnique(
					action,
					edtlacxxmh,
					'lacxxmh',
					'kode',
					'kode',
					'"'+kode+'"',
					id_lacxxmh
				);

				validasiUnique(
					action,
					edtlacxxmh,
					'lacxxmh',
					'nama',
					'nama',
					'"'+nama+'"',
					id_lacxxmh
				);
			}
			
			if ( edtlacxxmh.inError() ) {
				return false;
			}
		});
		
		edtlacxxmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtlacxxmh.field('lacxxmh.finish_at').val(finish_at);
		});

		edtlacxxmh.on( 'close', function () {
			edtlacxxmh.enable();
		} );

		tbllacxxmh = $('#tbllacxxmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/lacxxmh/lacxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_lacxxmh = show_deleted_lacxxmh;
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
				{ data: "lacxxmh.id",visible:false },
				{ data: "lacxxmh.kode" },
				{ data: "lacxxmh.nama" },
				{ data: "lacxxmh.keterangan" },
				{ 
					data: "lacxxmh.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_lacxxmh';
					$table       = 'tbllacxxmh';
					$edt         = 'edtlacxxmh';
					$show_status = '_lacxxmh';
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
				if ( data.lacxxmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.lacxxmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tbllacxxmh.searchPanes.container().appendTo('#splacxxmh');
		tbllacxxmh.searchBuilder.container().appendTo( '#sblacxxmh' );
		
		tbllacxxmh.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tbllacxxmh);
		} );
		
		tbllacxxmh.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('lacxxmh');

			// atur hak akses
			CekSelectHeaderH(tbllacxxmh);
		} );

		tbllacxxmh.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('lacxxmh');

			// atur hak akses
			CekDeselectHeaderH(tbllacxxmh);
		} );

		// END lacxxmh
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
