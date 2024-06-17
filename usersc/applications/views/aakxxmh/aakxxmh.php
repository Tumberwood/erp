<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'aakxxmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblaakxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Parent</th>
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
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_toast.php';
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/aakxxmh/fn/aakxxmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtaakxxmh, tblaakxxmh, show_deleted_aakxxmh = 0, id_aakxxmh;
	// ------------- end of default variable
	
	id_aakxxmh_parent_old = 0;

	// get tableRelation
	tableRelation('aakxxmh');

	$(document).ready(function() {
		
		// BEGIN aakxxmh
		edtaakxxmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/aakxxmh/aakxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_aakxxmh = show_deleted_aakxxmh;
				}
			},
			table: "#tblaakxxmh",
			fields: [ 
				{
					label: "aakxxmh.start_at",
					name: "aakxxmh.start_at",
					type: "hidden"
				},	
				{
					label: "aakxxmh.finish_at",
					name: "aakxxmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "aakxxmh",
					type: "hidden"
				},	
				{
					label: "aakxxmh.transaction_state",
					name: "aakxxmh.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "Kode <sup class='text-danger'>*<sup>",
					name: "aakxxmh.kode"
				}, 	
				{
					label: "Nama <sup class='text-danger'>*<sup>",
					name: "aakxxmh.nama"
				},
				{
					label: "Akun Parent?",
					name: "aakxxmh.is_parent",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": "Ya", "value": 1 },
						{ "label": "Tidak", "value": 0 }
					]
				},
				{
					label: "Nama Parent Akun",
					name: "aakxxmh.id_aakxxmh_parent",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/aakxxmh/aakxxmh_fn_opt_parent.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_aakxxmh_old: id_aakxxmh_parent_old,
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
							minimumResultsForSearch: -1,
						},
					}
				},
				{
					label: "Saldo Awal",
					name: "aakxxmh.saldo_awal"
				},
				{
					label: "Tanggal Saldo Awal",
					name: "aakxxmh.saldo_awal_tanggal",
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
			]
		} );

		edtaakxxmh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtaakxxmh.field('aakxxmh.start_at').val(start_at);
			
			if(action == 'create'){
				tblaakxxmh.rows().deselect();
			}else if(action == 'edit'){
				
				if(transaction_state == 0){
					edtaakxxmh.field('aakxxmh.kode').enable();
					edtaakxxmh.field('aakxxmh.nama').enable();
				}else{
					edtaakxxmh.field('aakxxmh.kode').disable();
					edtaakxxmh.field('aakxxmh.nama').disable();
				}

				if(saldo_awal !=null && saldo_awal_tanggal != null ){
					edtaakxxmh.field('aakxxmh.saldo_awal').disable();
					edtaakxxmh.field('aakxxmh.saldo_awal_tanggal').disable();
				}else{
					edtaakxxmh.field('aakxxmh.saldo_awal').enable();
					edtaakxxmh.field('aakxxmh.saldo_awal_tanggal').enable();
				}
			}
		});

		edtaakxxmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edtaakxxmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				kode = edtaakxxmh.field('aakxxmh.kode').val();
				nama = edtaakxxmh.field('aakxxmh.nama').val();

				validasiRequired(
					edtaakxxmh,
					'aakxxmh',
					{
						'kode': kode,
						'nama': nama
					}
				);

				validasiUnique(
					action,
					edtaakxxmh,
					'aakxxmh',
					'kode',
					'kode',
					'"'+kode+'"',
					id_aakxxmh
				);

				validasiUnique(
					action,
					edtaakxxmh,
					'aakxxmh',
					'nama',
					'nama',
					'"'+nama+'"',
					id_aakxxmh
				);

			}
			
			if ( edtaakxxmh.inError() ) {
				return false;
			}
		});
		
		edtaakxxmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtaakxxmh.field('aakxxmh.finish_at').val(finish_at);
		});

		edtaakxxmh.on('postSubmit', function(e, json, data, action, xhr) {
			tblaakxxmh.rows().deselect();
			tblaakxxmh.ajax.reload(null, false);
		});

		edtaakxxmh.on( 'close', function () {
			edtaakxxmh.enable();
		} );

		tblaakxxmh = $('#tblaakxxmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/aakxxmh/aakxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_aakxxmh = show_deleted_aakxxmh;
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
				{ data: "aakxxmh.id",visible:false },
				{ data: "aakxxmh.kode" , type: 'string'},
				{ data: "aakxxmh.nama" },
				{ data: "aakxxmh_parent.nama" },
				{ 
					data: "aakxxmh.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_aakxxmh';
					$table       = 'tblaakxxmh';
					$edt         = 'edtaakxxmh';
					$show_status = '_aakxxmh';
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
				if ( data.aakxxmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.aakxxmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblaakxxmh.searchPanes.container().appendTo('#spaakxxmh');
		tblaakxxmh.searchBuilder.container().appendTo( '#sbaakxxmh' );
		
		tblaakxxmh.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblaakxxmh);
		} );
		
		tblaakxxmh.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('aakxxmh');
			id_aakxxmh_parent_old = aakxxmh_data.id_aakxxmh_parent;
			saldo_awal = aakxxmh_data.saldo_awal;
			saldo_awal_tanggal = aakxxmh_data.saldo_awal_tanggal;
			
			// atur hak akses
			CekSelectHeaderH(tblaakxxmh);
		} );

		tblaakxxmh.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('aakxxmh');
			id_aakxxmh_parent_old = 0;
			saldo_awal = null, saldo_awal_tanggal = null;

			// atur hak akses
			CekDeselectHeaderH(tblaakxxmh);
		} );
		
		// END aakxxmh
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
