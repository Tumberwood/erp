<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'lprxxmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tbllprxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
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
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn.js"></script>

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/lprxxmh/fn/lprxxmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtlprxxmh, tbllprxxmh, show_deleted_lprxxmh = 0, id_lprxxmh;
	// ------------- end of default variable
	
	// get tableRelation
	tableRelation('lprxxmh');

	$(document).ready(function() {
		// BEGIN lprxxmh
		edtlprxxmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/lprxxmh/lprxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_lprxxmh = show_deleted_lprxxmh;
				}
			},
			table: "#tbllprxxmh",
			fields: [ 
				{
					label: "lprxxmh.start_at",
					name: "lprxxmh.start_at",
					type: "hidden"
				},	
				{
					label: "lprxxmh.finish_at",
					name: "lprxxmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "lprxxmh",
					type: "hidden"
				},	
				{
					label: "lprxxmh.transaction_state",
					name: "lprxxmh.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "Kode <sup class='text-danger'>*<sup>",
					name: "lprxxmh.kode"
				}, 	
				{
					label: "Nama <sup class='text-danger'>*<sup>",
					name: "lprxxmh.nama"
				}, 	
				{
					label: "Keterangan",
					name: "lprxxmh.keterangan",
					type: "textarea"
				}
			]
		} );

		edtlprxxmh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtlprxxmh.field('lprxxmh.start_at').val(start_at);
			
			if(action == 'create'){
				tbllprxxmh.rows().deselect();
			}else if(action == 'edit'){
				
				if(transaction_state == 0){
					edtlprxxmh.field('lprxxmh.kode').enable();
					edtlprxxmh.field('lprxxmh.nama').enable();
				}else{
					edtlprxxmh.field('lprxxmh.kode').disable();
					edtlprxxmh.field('lprxxmh.nama').disable();
				}
			}
		});

		edtlprxxmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edtlprxxmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				kode = edtlprxxmh.field('lprxxmh.kode').val();
				nama = edtlprxxmh.field('lprxxmh.nama').val();

				validasiRequired(
					edtlprxxmh,
					'lprxxmh',
					{
						'kode': kode,
						'nama': nama
					}
				);

				validasiUnique(
					action,
					edtlprxxmh,
					'lprxxmh',
					'kode',
					'kode',
					'"'+kode+'"',
					id_lprxxmh
				);

				validasiUnique(
					action,
					edtlprxxmh,
					'lprxxmh',
					'nama',
					'nama',
					'"'+nama+'"',
					id_lprxxmh
				);
			}
			
			if ( edtlprxxmh.inError() ) {
				return false;
			}
		});
		
		edtlprxxmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtlprxxmh.field('lprxxmh.finish_at').val(finish_at);
		});

		edtlprxxmh.on( 'close', function () {
			edtlprxxmh.enable();
		} );

		tbllprxxmh = $('#tbllprxxmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/lprxxmh/lprxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_lprxxmh = show_deleted_lprxxmh;
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
				{ data: "lprxxmh.id",visible:false },
				{ data: "lprxxmh.kode" },
				{ data: "lprxxmh.nama" },
				{ data: "lprxxmh.keterangan" },
				{ 
					data: "lprxxmh.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_lprxxmh';
					$table       = 'tbllprxxmh';
					$edt         = 'edtlprxxmh';
					$show_status = '_lprxxmh';
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
				if ( data.lprxxmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.lprxxmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tbllprxxmh.searchPanes.container().appendTo('#splprxxmh');
		tbllprxxmh.searchBuilder.container().appendTo( '#sblprxxmh' );
		
		tbllprxxmh.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tbllprxxmh);
		} );
		
		tbllprxxmh.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('lprxxmh');

			// atur hak akses
			CekSelectHeaderH(tbllprxxmh);
		} );

		tbllprxxmh.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('lprxxmh');

			// atur hak akses
			CekDeselectHeaderH(tbllprxxmh);
		} );

		// END lprxxmh
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
