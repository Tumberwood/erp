<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'pmi_cylinder_m_warna';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblpmi_cylinder_m_warna" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/pmi_cylinder_m_warna/fn/pmi_cylinder_m_warna_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtpmi_cylinder_m_warna, tblpmi_cylinder_m_warna, show_deleted_pmi_cylinder_m_warna = 0, id_pmi_cylinder_m_warna;
	// ------------- end of default variable
	
	// get tableRelation
	tableRelation('pmi_cylinder_m_warna');

	$(document).ready(function() {
		// BEGIN pmi_cylinder_m_warna
		edtpmi_cylinder_m_warna = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/pmi_cylinder_m_warna/pmi_cylinder_m_warna.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_pmi_cylinder_m_warna = show_deleted_pmi_cylinder_m_warna;
				}
			},
			table: "#tblpmi_cylinder_m_warna",
			fields: [ 
				{
					label: "pmi_cylinder_m_warna.start_at",
					name: "pmi_cylinder_m_warna.start_at",
					type: "hidden"
				},	
				{
					label: "pmi_cylinder_m_warna.finish_at",
					name: "pmi_cylinder_m_warna.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "pmi_cylinder_m_warna",
					type: "hidden"
				},	
				{
					label: "pmi_cylinder_m_warna.transaction_state",
					name: "pmi_cylinder_m_warna.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: getTranslation('name') + "<sup class='text-danger'>*<sup>",
					name: "pmi_cylinder_m_warna.nama"
				}, 	
				{
					label: getTranslation('notes'),
					name: "pmi_cylinder_m_warna.keterangan",
					type: "textarea"
				}
			]
		} );

		edtpmi_cylinder_m_warna.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtpmi_cylinder_m_warna.field('pmi_cylinder_m_warna.start_at').val(start_at);
			
			if(action == 'create'){
				tblpmi_cylinder_m_warna.rows().deselect();
				edtpmi_cylinder_m_warna.field('pmi_cylinder_m_warna.nama').enable();
			}else if(action == 'edit'){
				if(transaction_state == 0){
					edtpmi_cylinder_m_warna.field('pmi_cylinder_m_warna.nama').enable();
				}else{
					edtpmi_cylinder_m_warna.field('pmi_cylinder_m_warna.nama').disable();
				}
			}
		});

		edtpmi_cylinder_m_warna.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edtpmi_cylinder_m_warna.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				nama = edtpmi_cylinder_m_warna.field('pmi_cylinder_m_warna.nama').val();

				validasiRequired(
					edtpmi_cylinder_m_warna,
					'pmi_cylinder_m_warna',
					{
						'nama': nama
					}
				);

				validasiUnique(
					action,
					edtpmi_cylinder_m_warna,
					'pmi_cylinder_m_warna',
					'nama',
					'nama',
					'"'+nama+'"',
					id_pmi_cylinder_m_warna
				);
			}
			
			if ( edtpmi_cylinder_m_warna.inError() ) {
				return false;
			}
		});
		
		edtpmi_cylinder_m_warna.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtpmi_cylinder_m_warna.field('pmi_cylinder_m_warna.finish_at').val(finish_at);
		});

		edtpmi_cylinder_m_warna.on( 'close', function () {
			edtpmi_cylinder_m_warna.enable();
		} );

		tblpmi_cylinder_m_warna = $('#tblpmi_cylinder_m_warna').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/pmi_cylinder_m_warna/pmi_cylinder_m_warna.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_pmi_cylinder_m_warna = show_deleted_pmi_cylinder_m_warna;
				}
			},
			order: [[ 1, "asc" ]],
			columnDefs:[
				{
					searchPanes:{
						show: true,
					},
					targets: [1,2]
				},
				{
					searchPanes:{
						show: false,
					},
					targets: '_all'
				}
			],
			columns: [
				{ data: "pmi_cylinder_m_warna.id",visible:false },
				{ data: "pmi_cylinder_m_warna.nama" },
				{ 
					data: "pmi_cylinder_m_warna.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_pmi_cylinder_m_warna';
					$table       = 'tblpmi_cylinder_m_warna';
					$edt         = 'edtpmi_cylinder_m_warna';
					$show_status = '_pmi_cylinder_m_warna';
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
				if ( data.pmi_cylinder_m_warna.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.pmi_cylinder_m_warna.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblpmi_cylinder_m_warna.searchPanes.container().appendTo('#sppmi_cylinder_m_warna');
		tblpmi_cylinder_m_warna.searchBuilder.container().appendTo( '#sbpmi_cylinder_m_warna' );
		
		tblpmi_cylinder_m_warna.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblpmi_cylinder_m_warna);
		} );
		
		tblpmi_cylinder_m_warna.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('pmi_cylinder_m_warna');

			// atur hak akses
			CekSelectHeaderH(tblpmi_cylinder_m_warna);
		} );

		tblpmi_cylinder_m_warna.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('pmi_cylinder_m_warna');

			// atur hak akses
			CekDeselectHeaderH(tblpmi_cylinder_m_warna);
		} );

		// END pmi_cylinder_m_warna
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
