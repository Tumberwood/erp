<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'hgsptth';
	$nama_tabels_d = [];
?>

<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblhgsptth" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Pola</th>
                                <th>Siklus</th>
                                <th>Tanggal Awal</th>
                                <th>Tanggal Akhir</th>
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
<script src="<?=$us_url_root?>usersc/helpers/language.js"></script>
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/hgsptth/fn/hgsptth_fn.php'; ?>

<!-- BEGIN datatables here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edthgsptth, tblhgsptth, show_deleted_hgsptth = 0, id_hgsptth;
	// ------------- end of default variable

	var id_htsptth_old = 0;
	var id_hemxxmh_old = 0;
	
	// get tableRelation
	tableRelation('hgsptth');

	$(document).ready(function() {
		
		// BEGIN hgsptth
		edthgsptth = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/hgsptth/hgsptth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hgsptth = show_deleted_hgsptth;
				}
			},
			table: "#tblhgsptth",
			fields: [ 
				{
					label: "kategori_dokumen",
					name: "kategori_dokumen",
					type: "hidden"
				},	{
					label: "kategori_dokumen_value",
					name: "kategori_dokumen_value",
					type: "hidden"
				},	{
					label: "field_tanggal",
					name: "field_tanggal",
					type: "hidden"
				},
				{
					label: "hgsptth.start_at",
					name: "hgsptth.start_at",
					type: "hidden"
				},	
				{
					label: "hgsptth.finish_at",
					name: "hgsptth.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "hgsptth",
					type: "hidden"
				},	
				{
					label: "hgsptth.transaction_state",
					name: "hgsptth.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "Pola <sup class='text-danger'>*<sup>",
					name: "hgsptth.id_htsptth",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: false,
						ajax: {
							url: "../../models/htsptth/htsptth_fn_opt.php",
							dataType: 'json',
							data: function (params) {
								var query = {
									id_htsptth_old: id_htsptth_old,
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
					label: "Pilih Karyawan",
					name: "hgsptth.is_pegawai",
					type: "select",
					fieldInfo: "Jika Ya, maka hanya karyawan yang dipilih saja yang akan dibuatkan Jadwal!",
					placeholder : "Select",
					options: [
						{ "label": "Ya", "value": 1 },
						{ "label": "Tidak", "value": 0 }
					]
				},
				{
					label: "Karyawan <sup class='text-danger'>*<sup>",
					name: "hemxxmh[].id",
					type: "select2",
					opts: {
						placeholder : "Select",
						allowClear: true,
						multiple: true,
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
							minimumResultsForSearch: -1,
						},
					}
				},	
				{
					label: "Siklus  <sup class='text-danger'>*<sup>",
					name: "hgsptth.jumlah_siklus"
				}, 	{
					label: "Tanggal Awal",
					name: "hgsptth.tanggal_awal",
					type: "datetime",
					def: function () { 
						return new Date(); 
					},
					opts:{
						minDate: new Date('1900-01-01'),
						firstDay: 0
					},
					format: 'DD MMM YYYY'
				},	{
					label: "Keterangan",
					name: "hgsptth.keterangan",
					type: "textarea"
				}
			]
		} );

		edthgsptth.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthgsptth.field('hgsptth.start_at').val(start_at);
			edthgsptth.field('hemxxmh[].id').hide();
			
			if(action == 'create'){
				tblhgsptth.rows().deselect();
				edthgsptth.field('kategori_dokumen').val('');
				edthgsptth.field('kategori_dokumen_value').val('');
				edthgsptth.field('field_tanggal').val('start_at');
			}
		});

		edthgsptth.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");
			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edthgsptth.dependent( 'hgsptth.is_pegawai', function ( val, data, callback ) {
			if (val == 1) {
				edthgsptth.field('hemxxmh[].id').show();
			} else {
				edthgsptth.field('hemxxmh[].id').hide();
			}
			return {}
		}, {event: 'keyup change'});

		edthgsptth.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){
				id_htsptth = edthgsptth.field('hgsptth.id_htsptth').val();
				is_pegawai = edthgsptth.field('hgsptth.is_pegawai').val();
				tanggal_awal = edthgsptth.field('hgsptth.tanggal_awal').val();
				id_hemxxmh = edthgsptth.field('hemxxmh[].id').val();

				validasiRequired(
					edthgsptth,
					'hgsptth',
					{
						'tanggal_awal': tanggal_awal,
						'id_htsptth': id_htsptth,
					}
				);

				// BEGIN of validasi hgsptth.jumlah_siklus
				if ( ! edthgsptth.field('hgsptth.jumlah_siklus').isMultiValue() ) {
					jumlah_siklus = edthgsptth.field('hgsptth.jumlah_siklus').val();
					if(!jumlah_siklus || jumlah_siklus == ''){
						edthgsptth.field('hgsptth.jumlah_siklus').error( 'Wajib diisi!' );
					}
					if(jumlah_siklus <= 0 ){
						edthgsptth.field('hgsptth.jumlah_siklus').error( 'Inputan harus > 0' );
					}
					if(isNaN(jumlah_siklus) ){
						edthgsptth.field('hgsptth.jumlah_siklus').error( 'Inputan harus berupa Angka!' );
					}
				}
				// END of validasi hgsptth.jumlah_siklus

				if (is_pegawai == 1) {
					if(!id_hemxxmh || id_hemxxmh == ''){
						edthgsptth.field('hemxxmh[].id').error( 'Wajib diisi!' );
					}
				}
			}
			
			if ( edthgsptth.inError() ) {
				return false;
			}
		});
		
		edthgsptth.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edthgsptth.field('hgsptth.finish_at').val(finish_at);
		});

		edthgsptth.on( 'close', function () {
			edthgsptth.enable();
		} );

		tblhgsptth = $('#tblhgsptth').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/hgsptth/hgsptth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_hgsptth = show_deleted_hgsptth;
				}
			},
			order: [[ 1, "asc" ]],
			columnDefs:[
				{
					searchPanes:{
						show: true,
					},
					targets: [1,5]
				},
				{
					searchPanes:{
						show: false,
					},
					targets: [0,2,3,4]
				}
			],
			columns: [
				{ data: "hgsptth.id",visible:false },
				{ data: "htsptth.nama" },
				{ 
					data: "hgsptth.jumlah_siklus" ,
					render: $.fn.dataTable.render.number( ',', '.', 0,'','' ),
					class: "text-right"
				},
				{ data: "hgsptth.tanggal_awal" },
				{ data: "hgsptth.tanggal_akhir" },
				{ 
					data: "hgsptth.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_hgsptth';
					$table       = 'tblhgsptth';
					$edt         = 'edthgsptth';
					$show_status = '_hgsptth';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= ['sp', 'sb'];
					$arr_buttons_action 	= ['create', 'edit', 'remove', 'confirm', 'nonaktif_h', 'close', 'view', 'log','noaction'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
				// END breaking generate button
				{
					text: '<i class="fa fa-google"></i>',
					name: 'btnGenerateJadwal',
					className: 'btn btn-outline',
					titleAttr: '',
					action: function ( e, dt, node, config ) {
						e.preventDefault(); 

						notifyprogress = $.notify({
							message: 'Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!'
						},{
							z_index: 9999,
							allow_dismiss: false,
							type: 'info',
							delay: 0
						});

						$.ajax( {
							url: "../../models/hgsptth/hgsptth_fn_gen_jadwal.php",
							dataType: 'json',
							type: 'POST',
							data: {
								id_transaksi_h: id_transaksi_h
							},
							success: function ( json ) {

								$.notify({
									message: json.data.message
								},{
									type: json.data.type_message
								});

								tblhgsptth.ajax.reload(function ( json ) {
									notifyprogress.close();
								}, false);
							}
						} );
					}
				},
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
				if ( data.hgsptth.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.hgsptth.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblhgsptth.searchPanes.container().appendTo('#sphgsptth');
		tblhgsptth.searchBuilder.container().appendTo( '#sbhgsptth' );
		
		tblhgsptth.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblhgsptth);
			tblhgsptth.button( 'btnGenerateJadwal:name' ).disable();
		} );
		
		tblhgsptth.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('hgsptth');
			id_htsptth_old = hgsptth_data.id_htsptth;
			// atur hak akses
			CekSelectHeaderH(tblhgsptth);
			tblhgsptth.button( 'btnGenerateJadwal:name' ).enable();
		} );

		tblhgsptth.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('hgsptth');
			id_htsptth_old = 0;

			// atur hak akses
			CekDeselectHeaderH(tblhgsptth);
			tblhgsptth.button( 'btnGenerateJadwal:name' ).disable();
		} );
		
	} );// end of document.ready

</script>

<!-- END datatables here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
