<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'si_training_peserta_m';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblsi_training_peserta_m" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>No Whatsapp</th>
                                <th>Email</th>
                                <th>Domisili</th>
                                <th>Profesi saat ini </th>
                                <th>Dapat Info Darimana</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/si_training_peserta_m/fn/si_training_peserta_m_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtsi_training_peserta_m, tblsi_training_peserta_m, show_deleted_si_training_peserta_m = 0, id_si_training_peserta_m;
	// ------------- end of default variable

	var id_hodxxmh_old = 0;
	
	// get tableRelation
	tableRelation('si_training_peserta_m');

	$(document).ready(function() {
		// BEGIN si_training_peserta_m
		edtsi_training_peserta_m = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/si_training_peserta_m/si_training_peserta_m.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_si_training_peserta_m = show_deleted_si_training_peserta_m;
				}
			},
			table: "#tblsi_training_peserta_m",
			fields: [ 
				{
					label: "si_training_peserta_m.start_at",
					name: "si_training_peserta_m.start_at",
					type: "hidden"
				},	
				{
					label: "si_training_peserta_m.finish_at",
					name: "si_training_peserta_m.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "si_training_peserta_m",
					type: "hidden"
				},	
				{
					label: "si_training_peserta_m.transaction_state",
					name: "si_training_peserta_m.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: getTranslation('name') + " <sup class='text-danger'>*<sup>",
					name: "si_training_peserta_m.nama"
				}, 	
				{
					label: "No Whatsapp <sup class='text-danger'>*<sup>",
					name: "si_training_peserta_m.no_wa",
				},
				{
					label: "Domisili <sup class='text-danger'>*<sup>",
					name: "si_training_peserta_m.domisili",
				},
				{
					label: "Email <sup class='text-danger'>*<sup>",
					name: "si_training_peserta_m.email",
				},
				{
					label: "Profesi saat ini <sup class='text-danger'>*<sup>",
					name: "si_training_peserta_m.profesi",
				},
				{
					label: "Dapat Info Darimana <sup class='text-danger'>*<sup>",
					name: "si_training_peserta_m.sumber_info",
				},
				{
					label: "Alasan singkat 3 kata ingin ikut pelatihan ini <sup class='text-danger'>*<sup>",
					name: "si_training_peserta_m.alasan",
				},
			]
		} );

		edtsi_training_peserta_m.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtsi_training_peserta_m.field('si_training_peserta_m.start_at').val(start_at);
			
			if(action == 'create'){
				tblsi_training_peserta_m.rows().deselect();
				edtsi_training_peserta_m.field('si_training_peserta_m.nama').enable();
			}else if(action == 'edit'){
				if(transaction_state == 0){
					edtsi_training_peserta_m.field('si_training_peserta_m.nama').enable();
				}else{
					edtsi_training_peserta_m.field('si_training_peserta_m.nama').disable();
				}
			}
		});

		edtsi_training_peserta_m.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edtsi_training_peserta_m.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				no_wa = edtsi_training_peserta_m.field('si_training_peserta_m.no_wa').val();
				nama = edtsi_training_peserta_m.field('si_training_peserta_m.nama').val();
				domisili = edtsi_training_peserta_m.field('si_training_peserta_m.domisili').val();
				email = edtsi_training_peserta_m.field('si_training_peserta_m.email').val();
				profesi = edtsi_training_peserta_m.field('si_training_peserta_m.profesi').val();
				sumber_info = edtsi_training_peserta_m.field('si_training_peserta_m.sumber_info').val();
				alasan = edtsi_training_peserta_m.field('si_training_peserta_m.alasan').val();

				validasiRequired(
					edtsi_training_peserta_m,
					'si_training_peserta_m',
					{
						'no_wa': no_wa,
						'nama': nama,
						'domisili': domisili,
						'email': email,
						'profesi': profesi,
						'sumber_info': sumber_info,
						'alasan': alasan,
					}
				);

				var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
				if (!emailRegex.test(email)) {
					edtsi_training_peserta_m.field('si_training_peserta_m.email').error('Format email tidak valid!');
				}

				validasiUnique(
					action,
					edtsi_training_peserta_m,
					'si_training_peserta_m',
					'nama',
					'nama',
					'"'+nama+'"',
					id_si_training_peserta_m
				);
			}
			
			if ( edtsi_training_peserta_m.inError() ) {
				return false;
			}
		});
		
		edtsi_training_peserta_m.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtsi_training_peserta_m.field('si_training_peserta_m.finish_at').val(finish_at);
		});

		edtsi_training_peserta_m.on( 'close', function () {
			edtsi_training_peserta_m.enable();
		} );

		tblsi_training_peserta_m = $('#tblsi_training_peserta_m').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/si_training_peserta_m/si_training_peserta_m.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_si_training_peserta_m = show_deleted_si_training_peserta_m;
				}
			},
			order: [[ 1, "asc" ]],
			columnDefs:[
				{
					searchPanes:{
						show: true,
					},
					targets: [1,2,3,4]
				},
				{
					searchPanes:{
						show: false,
					},
					targets: '_all'
				}
			],
			columns: [
				{ data: "si_training_peserta_m.id",visible:false },
				{ data: "si_training_peserta_m.nama" },
				{ data: "si_training_peserta_m.no_wa" },
				{ data: "si_training_peserta_m.email" },
				{ data: "si_training_peserta_m.domisili" },
				{ data: "si_training_peserta_m.profesi" },
				{ data: "si_training_peserta_m.sumber_info" },
				{ 
					data: "si_training_peserta_m.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_si_training_peserta_m';
					$table       = 'tblsi_training_peserta_m';
					$edt         = 'edtsi_training_peserta_m';
					$show_status = '_si_training_peserta_m';
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
				if ( data.si_training_peserta_m.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.si_training_peserta_m.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblsi_training_peserta_m.searchPanes.container().appendTo('#spsi_training_peserta_m');
		tblsi_training_peserta_m.searchBuilder.container().appendTo( '#sbsi_training_peserta_m' );
		
		tblsi_training_peserta_m.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblsi_training_peserta_m);
		} );
		
		tblsi_training_peserta_m.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('si_training_peserta_m');
			id_hodxxmh_old 		= si_training_peserta_m_data.id_hodxxmh;

			// atur hak akses
			CekSelectHeaderH(tblsi_training_peserta_m);
		} );

		tblsi_training_peserta_m.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('si_training_peserta_m');
			id_hodxxmh_old = 0;

			// atur hak akses
			CekDeselectHeaderH(tblsi_training_peserta_m);
		} );

		// END si_training_peserta_m
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
