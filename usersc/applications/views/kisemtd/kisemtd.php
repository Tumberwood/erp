<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'kisemtd';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div id="frmkisemtd">
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="kisemtd.tanggal"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="kisemtd.id_hemxxmh"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="kisemtd.id_kisctmh"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="kisemtd.pihak_terlibat"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="kisemtd.deskripsi_insiden"></editor-field>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<editor-field name="kisemtd.penyebab"></editor-field>
							</div>
							<div class="col-lg-6">
								<editor-field name="kisemtd.tindakan"></editor-field>
							</div>
						</div>
					</div>
				</div>
				<div class="table-responsive">
                    <table id="tblkisemtd" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th data-i18n="code"></th>
                                <th data-i18n="date"></th>
                                <th data-i18n="Insiden Category"></th>
                                <th data-i18n="employee"></th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/kisemtd/fn/kisemtd_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtkisemtd, tblkisemtd, show_deleted_kisemtd = 0, id_kisemtd;
	var id_hemxxmh_old = 0, id_kisctmh_old = 0;
	// ------------- end of default variable
	
	// get tableRelation
	tableRelation('kisemtd');

	$(document).ready(function() {
		// BEGIN kisemtd
		edtkisemtd = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/kisemtd/kisemtd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_kisemtd = show_deleted_kisemtd;
				}
			},
			table: "#tblkisemtd",
			template: "#frmkisemtd",
			fields: [ 
				{
					label: "kisemtd.start_at",
					name: "kisemtd.start_at",
					type: "hidden"
				},	
				{
					label: "kisemtd.finish_at",
					name: "kisemtd.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "kisemtd",
					type: "hidden"
				},	
				{
					label: "kisemtd.transaction_state",
					name: "kisemtd.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: getTranslation('date') + ` <sup class='text-danger'>*<sup>`,
					name: "kisemtd.tanggal",
					type: "datetime",
					def: function () { 
						return new Date(); 
					},
					opts:{
						minDate: new Date('1900-01-01'),
						firstDay: 0
					},
					format: 'DD MMM YYYY'
				},
				{
					label: getTranslation('employee') + ` <sup class='text-danger'>*<sup>`,
					name: "kisemtd.id_hemxxmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/hemxxmh/hemxxmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_hemxxmh_old: id_hemxxmh_old,
									search: params.term || '',
									page: params.page || 1
								}
								return query;
							},
							processResults: function (data, params) {
								return {
									results: data.results,
									pagination: {
										more: true
									}
								};
							},
							cache: true,
							minimumInputLength: 1,
							maximum: 10,
							delay: 500,
							maximumSelectionLength: 5,
							minimumResultsForSearch: -1
						}
					}
				},
				{
					label: getTranslation('Insiden Category') + ` <sup class='text-danger'>*<sup>`,
					name: "kisemtd.id_kisctmh",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/kisctmh/kisctmh_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_kisctmh_old: id_kisctmh_old,
									search: params.term || '',
									page: params.page || 1
								}
								return query;
							},
							processResults: function (data, params) {
								return {
									results: data.results,
									pagination: {
										more: true
									}
								};
							},
							cache: true,
							minimumInputLength: 1,
							maximum: 10,
							delay: 500,
							maximumSelectionLength: 5,
							minimumResultsForSearch: -1
						}
					}
				},
				{
					label: `Pihak Terlibat <sup class='text-danger'>*<sup>`,
					name: "kisemtd.pihak_terlibat",
					type: "textarea"
				},
				{
					label: `Deskripsi Insiden <sup class='text-danger'>*<sup>`,
					name: "kisemtd.deskripsi_insiden",
					type: "textarea"
				},
				{
					label: `Penyebab <sup class='text-danger'>*<sup>`,
					name: "kisemtd.penyebab",
					type: "textarea"
				},
				{
					label: `Tindakan Perbaikan & Pencegahan <sup class='text-danger'>*<sup>`,
					name: "kisemtd.tindakan",
					type: "textarea"
				},
			]
		} );

		edtkisemtd.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtkisemtd.field('kisemtd.start_at').val(start_at);
			
			if(action == 'create'){
				tblkisemtd.rows().deselect();
			}
		});

		edtkisemtd.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-xl");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edtkisemtd.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				id_hemxxmh = edtkisemtd.field('kisemtd.id_hemxxmh').val();
				tanggal = edtkisemtd.field('kisemtd.tanggal').val();
				id_kisctmh = edtkisemtd.field('kisemtd.id_kisctmh').val();
				pihak_terlibat = edtkisemtd.field('kisemtd.pihak_terlibat').val();
				deskripsi_insiden = edtkisemtd.field('kisemtd.deskripsi_insiden').val();
				penyebab = edtkisemtd.field('kisemtd.penyebab').val();
				tindakan = edtkisemtd.field('kisemtd.tindakan').val();

				validasiRequired(
					edtkisemtd,
					'kisemtd',
					{
						'id_hemxxmh': id_hemxxmh,
						'tanggal': tanggal,
						'id_kisctmh': id_kisctmh,
						'pihak_terlibat': pihak_terlibat,
						'deskripsi_insiden': deskripsi_insiden,
						'penyebab': penyebab,
						'tindakan': tindakan,
					}
				);
			}
			
			if ( edtkisemtd.inError() ) {
				return false;
			}
		});
		
		edtkisemtd.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtkisemtd.field('kisemtd.finish_at').val(finish_at);
		});

		edtkisemtd.on( 'close', function () {
			edtkisemtd.enable();
		} );

		tblkisemtd = $('#tblkisemtd').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/kisemtd/kisemtd.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_kisemtd = show_deleted_kisemtd;
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
				{ data: "kisemtd.id",visible:false },
				{ data: "kisemtd.kode" },
				{ data: "kisemtd.tanggal" },
				{ data: "kisctmh.nama" },
				{ data: "hemxxmh_fullname" },
				{ 
					data: "kisemtd.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_kisemtd';
					$table       = 'tblkisemtd';
					$edt         = 'edtkisemtd';
					$show_status = '_kisemtd';
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
				if ( data.kisemtd.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.kisemtd.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblkisemtd.searchPanes.container().appendTo('#spkisemtd');
		tblkisemtd.searchBuilder.container().appendTo( '#sbkisemtd' );
		
		tblkisemtd.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblkisemtd);
		} );
		
		tblkisemtd.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('kisemtd');
			id_hemxxmh_old = kisemtd_data.id_hemxxmh;
			id_kisctmh_old = kisemtd_data.id_kisctmh;

			// atur hak akses
			CekSelectHeaderH(tblkisemtd);
		} );

		tblkisemtd.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('kisemtd');
			id_hemxxmh_old = 0, id_kisctmh_old = 0;

			// atur hak akses
			CekDeselectHeaderH(tblkisemtd);
		} );

		// END kisemtd
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
