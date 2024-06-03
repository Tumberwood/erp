<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'httlptd';
	$nama_tabels_d = [];
	
	$rowId = 0;
	if (isset($_GET['rowId'])) {
		$rowId = $_GET['rowId'];
	}
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				
				<div class="modal" id="modalSFhttlptd" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog modal-lg">
						<div class="modal-content animated bounceInRight">
							<form class="form-horizontal" id="frmFilter">
								<div class="modal-header">
									<h4 class="modal-title">Filter</h4>
								</div>
								<div class="modal-body">
									<div class="form-group row">
										<label class="col-lg-2 col-form-label">Periode</label>
										<div class="col-lg-5">
											<div class="input-group input-daterange" id="periode">
												<input type="text" id="start_date" class="form-control">
												<div class="input-group-addon">
													<span class="fa fa-calendar"></span>
												</div>
												<input type="text" id="end_date" class="form-control">
											</div>
										</div>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
									<button class="btn btn-primary" type="submit">Submit</button>
								</div>
							</form>
						</div>
					</div>
				</div>

				<div class="table-responsive">
                    <table id="tblhttlptd" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tgl Awal</th>
                                <th>Tgl Akhir</th>
                                <th>Jam Awal</th>
                                <th>Jam Akhir</th>
                                <th>Doc No.</th>
                                <th>Jenis</th>
                                <th>Nama Izin/Cuti</th>
                                <th>NIP</th>
                                <th>Nama</th>
                                <th>TX</th>
                                <th>Approval</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/httlptd/fn/httlptd_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
		// ------------- default variable, do not erase
		var edthttlptd, tblhttlptd, show_deleted_httlptd = 0, id_httlptd;
		// ------------- end of default variable
		
		var id_hemxxmh_old = 0, id_httlpmh_old = 0;
		
		kategori_dokumen = "";
		kategori_dokumen_value = "";

		//ini untuk single
		var rowId = <?php echo $rowId; ?>;
		// console.log(rowId);
		
		// get tableRelation
		tableRelation('httlptd');

		$(document).ready(function() {
			start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
			end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
			
			// BEGIN httlptd
			edthttlptd = new $.fn.dataTable.Editor( {
				ajax: {
					url: "../../models/httlptd/httlptd.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_httlptd = show_deleted_httlptd;
						d.rowId = rowId;
						d.start_date = start_date;
						d.end_date = end_date;
					}
				},
				table: "#tblhttlptd",
				fields: [ 
					{
						label: "httlptd.start_at",
						name: "httlptd.start_at",
						type: "hidden"
					},	
					{
						label: "httlptd.finish_at",
						name: "httlptd.finish_at",
						type: "hidden"
					},	
					{
						label: "nama_tabel",
						name: "nama_tabel",
						def: "httlptd",
						type: "hidden"
					},	
					{
						label: "httlptd.transaction_state",
						name: "httlptd.transaction_state",
                        type: "hidden",
						def: 0
					},	
					{
						label: "Jenis",
						name: "httlptd.jenis",
						type: "select",
						placeholder : "Select",
						options: [
							{ "label": "Hari", "value": 1 },
							{ "label": "Jam", "value": 2 }
						]
					},
					{
						label: "Nama Izin/Cuti <sup class='text-danger'>*<sup>",
						name: "httlptd.id_httlpmh",
						type: "select2",
						opts: {
							placeholder : "Select",
							allowClear: true,
							multiple: false,
							ajax: {
								url: "../../models/httlpmh/httlpmh_fn_opt.php",
								dataType: 'json',
								data: function (params) {
									jenis = edthttlptd.field('httlptd.jenis').val();
									var query = {
										id_httlpmh_old: id_httlpmh_old,
										jenis: jenis,
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
						label: "Tanggal Awal <sup class='text-danger'>*<sup>", 
						name: "httlptd.tanggal_awal",
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
						label: "Tanggal Akhir <sup class='text-danger'>*<sup>", 
						name: "httlptd.tanggal_akhir",
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
						label: "Jam Awal",
						name: "httlptd.jam_awal",
						type: "datetime",
						opts:{
							minDate: new Date('1900-01-01'),
							firstDay: 0
						},
						format: 'HH:mm'
					},	{
						label: "Jam Akhir",
						name: "httlptd.jam_akhir",
						type: "datetime",
						opts:{
							minDate: new Date('1900-01-01'),
							firstDay: 0
						},
						format: 'HH:mm'
					},
					{
						label: "Employee <sup class='text-danger'>*<sup>",
						name: "httlptd.id_hemxxmh",
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
								minimumResultsForSearch: -1,
							},
						}
					},
					{
						label: "Keterangan <sup class='text-danger'>*<sup>",
						name: "httlptd.keterangan",
						type: "textarea"
					}
				]
			} );

			edthttlptd.on( 'preOpen', function( e, mode, action ) {
				start_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edthttlptd.field('httlptd.start_at').val(start_at);
				edthttlptd.field('httlptd.tanggal_awal').hide();
				edthttlptd.field('httlptd.tanggal_akhir').hide();
				edthttlptd.field('httlptd.jam_awal').hide();
				edthttlptd.field('httlptd.jam_akhir').hide();
				
				if(action == 'create'){
					tblhttlptd.rows().deselect();
				}
			});

			edthttlptd.on("open", function (e, mode, action) {
				$(".modal-dialog").addClass("modal-lg");
			});

			edthttlptd.dependent( 'httlptd.jenis', function ( val, data, callback ) {
				if (val > 0) {
					if (val == 1) {
						edthttlptd.field('httlptd.tanggal_awal').label("Tanggal Awal <sup class='text-danger'>*<sup>");
						edthttlptd.field('httlptd.tanggal_awal').show();
						edthttlptd.field('httlptd.tanggal_akhir').show();
						edthttlptd.field('httlptd.jam_awal').hide();
						edthttlptd.field('httlptd.jam_akhir').hide();
						edthttlptd.field('httlptd.jam_awal').val('');
						edthttlptd.field('httlptd.jam_akhir').val('');
					} else {
						edthttlptd.field('httlptd.tanggal_awal').label("Tanggal <sup class='text-danger'>*<sup>");
						edthttlptd.field('httlptd.tanggal_awal').show();
						edthttlptd.field('httlptd.tanggal_akhir').hide();
					}
				}
				return {}
			}, {event: 'keyup change'});

			edthttlptd.dependent( 'httlptd.id_httlpmh', function ( val, data, callback ) {
				if (val > 0) {
					jenis = edthttlptd.field('httlptd.jenis').val();
					if (jenis == 2) {
						autofillField("httlpmh", val, "jenis_jam");
						jenis_jam = autofillData.jenis_jam;
						//Jika Harian
						
						if(jenis_jam == 1){
							edthttlptd.field('httlptd.jam_awal').show();
							edthttlptd.field('httlptd.jam_akhir').hide();

							edthttlptd.field('httlptd.jam_awal').label('Jam Awal <sup class="text-danger">*<sup>');
							edthttlptd.field('httlptd.jam_akhir').label('Jam Akhir');
							
							edthttlptd.field('httlptd.jam_akhir').val(null);
						}else if (jenis_jam == 2){
							edthttlptd.field('httlptd.jam_awal').hide();
							edthttlptd.field('httlptd.jam_akhir').show();

							edthttlptd.field('httlptd.jam_awal').label('Jam Awal');
							edthttlptd.field('httlptd.jam_akhir').label('Jam Akhir <sup class="text-danger">*<sup>');

							edthttlptd.field('httlptd.jam_awal').val(null);
						}else if (jenis_jam == 3){
							edthttlptd.field('httlptd.jam_awal').show();
							edthttlptd.field('httlptd.jam_akhir').show();
							edthttlptd.field('httlptd.jam_awal').label('Jam Awal <sup class="text-danger">*<sup>');
							edthttlptd.field('httlptd.jam_akhir').label('Jam Akhir <sup class="text-danger">*<sup>');

						}else{
							edthttlptd.field('httlptd.jam_awal').hide();
							edthttlptd.field('httlptd.jam_akhir').hide();

							edthttlptd.field('httlptd.jam_awal').label('Jam Awal');
							edthttlptd.field('httlptd.jam_akhir').label('Jam Akhir');

							edthttlptd.field('httlptd.jam_awal').val(null);
							edthttlptd.field('httlptd.jam_akhir').val(null);
						}
					}
				}
				return {}
			}, {event: 'keyup change'});

            edthttlptd.on( 'preSubmit', function (e, data, action) {
				if(action != 'remove'){

					tanggal_awal = edthttlptd.field('httlptd.tanggal_awal').val();
					// tanggal_awal_ymd = moment(tanggal_awal).format("YYYY-MM-DD HH:mm:ss");
					tanggal_akhir = edthttlptd.field('httlptd.tanggal_akhir').val();
					// tanggal_akhir_ymd = moment(tanggal_akhir).format("YYYY-MM-DD HH:mm:ss");
					id_hemxxmh = edthttlptd.field('httlptd.id_hemxxmh').val();
					id_httlpmh = edthttlptd.field('httlptd.id_httlpmh').val();
					keterangan = edthttlptd.field('httlptd.keterangan').val();
					jenis = edthttlptd.field('httlptd.jenis').val();
					jam_awal = edthttlptd.field('httlptd.jam_awal').val();
					jam_akhir = edthttlptd.field('httlptd.jam_akhir').val();

					validasiRequired(
						edthttlptd,
						'httlptd',
						{
							'id_hemxxmh': id_hemxxmh,
							'id_httlpmh': id_httlpmh,
							'keterangan': keterangan,
							'tanggal_awal': tanggal_awal, //Jika izin/jam, tanggal_awal ini akan jadi tanggal biasa
							'jenis': jenis
						}
					);

					if (jenis == 1) {
						validasiRequired(
							edthttlptd,
							'httlptd',
							{
								'tanggal_akhir': tanggal_akhir,
							}
						);
					} else {
						autofillField("httlpmh", id_httlpmh, "jenis_jam");
						jenis_jam = autofillData.jenis_jam;

						if(jenis_jam == 1) {
							validasiRequired(
								edthttlptd,
								'httlptd',
								{
									'jam_awal': jam_awal,
								}
							);
						} else if(jenis_jam == 2) {
							validasiRequired(
								edthttlptd,
								'httlptd',
								{
									'jam_akhir': jam_akhir,
								}
							);
						} else if(jenis_jam == 3) {
							validasiRequired(
								edthttlptd,
								'httlptd',
								{
									'jam_awal': jam_awal,
									'jam_akhir': jam_akhir,
								}
							);
						}
					}

				}
				
				if ( edthttlptd.inError() ) {
					return false;
				}
			});
			
			edthttlptd.on('initSubmit', function(e, action) {
				finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edthttlptd.field('httlptd.finish_at').val(finish_at);
			});

			edthttlptd.on( 'close', function () {
				edthttlptd.enable();
			} );

			tblhttlptd = $('#tblhttlptd').DataTable( {
				dom: domPQ,
				searchPanes:{
					layout: 'columns-4',
				},
				ajax: {
					url: "../../models/httlptd/httlptd.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_httlptd = show_deleted_httlptd;
						d.rowId = rowId;
						d.start_date = start_date;
						d.end_date = end_date;
					}
				},
				order: [[ 1, "desc" ]],
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
				responsive: false,
				scrollX: true,
				columns: [
					{ data: "httlptd.id",visible:false },
					{ data: "httlptd.tanggal_awal" },
					{ data: "httlptd.tanggal_akhir" },
					{ data: "httlptd.jam_awal" },
					{ data: "httlptd.jam_akhir" },
					{ data: "httlptd.kode" },
					{ 
						data: "httlptd.jenis",
						render: function (data) {
							if (data == 1) {
								return '<span class="badge badge-primary">Hari</span>';
							} else if (data == 2) {
								return '<span class="badge badge-primary">Jam</span>';
							} else {
								return '<span class="badge badge-warning">INVALID</span>';
							}
						}
					},
					{ data: "httlpmh.nama" },
					{ data: "hemxxmh.kode" },
					{ data: "hemxxmh.nama" },
					{ 
						data: "httlptd.transaction_state" ,
						...renderTransactionStatus()
					},
					{ 
						data: "httlptd.approval_state" ,
						...renderApprovalStatus()
					}
				],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_httlptd';
						$table       = 'tblhttlptd';
						$edt         = 'edthttlptd';
						$show_status = '_httlptd';
						$table_name  = $nama_tabel;

						$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
						$arr_buttons_tools2 	= [ 'sf','sp', 'sb'];
						$arr_buttons_action 	= ['create', 'edit', 'remove', 'confirm', 'nonaktif_h', 'close', 'view', 'log','noaction'];
						include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
					?>
					// END breaking generate button
				],
				initComplete: function() {
					this.api().searchPanes.rebuildPane();
				},
				rowCallback: function( row, data, index ) {
					if ( data.httlptd.transaction_state == -9 ) {
						$('td', row).addClass('text-danger');
					}else if ( data.httlptd.transaction_state == 0 ) {
						$('td', row).addClass('text-warning');
					}
				}
			} );

			tblhttlptd.searchPanes.container().appendTo('#sphttlptd');
			tblhttlptd.searchBuilder.container().appendTo( '#sbhttlptd' );
			
			tblhttlptd.on( 'init', function () {
				// atur hak akses
				CekInitHeaderH(tblhttlptd);
			} );
			
			tblhttlptd.on( 'select', function( e, dt, type, indexes ) {
				httlptd_data    		= tblhttlptd.row( { selected: true } ).data().httlptd;
				id_httlptd      		= httlptd_data.id;
				id_transaksi_h 		= id_httlptd; // dipakai untuk general
				id_transaksi_log	= id_httlptd; // dipakai untuk general
				transaction_state   = httlptd_data.transaction_state;
				approval_state   	= httlptd_data.approval_state;
				is_nextprocess 		= httlptd_data.is_nextprocess;

				id_hemxxmh_old = httlptd_data.id_hemxxmh;
				id_httlpmh_old = httlptd_data.id_httlpmh;

				// atur hak akses
				CekSelectHeaderH(tblhttlptd);
			} );

			tblhttlptd.on( 'deselect', function () {
				// reload dipanggil di function CekDeselectHeader
				id_httlptd = 0;

				id_hemxxmh_old = 0, id_httlpmh_old = 0;

				// atur hak akses
				CekDeselectHeaderH(tblhttlptd);
			} );

			// END httlptd

			$("#frmFilter").submit(function(e) {
				e.preventDefault();
			}).validate({
				rules: {
				},
				submitHandler: function(frmFilter) {
					start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
					end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
					toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
					tblhttlptd.rows().deselect();
					tblhttlptd.ajax.reload(function ( json ) {
					toastr.remove();
					toastr["success"]("Load data berhasil","INFO")
					$('#modalSFhttlptd').modal('toggle');
				}, false);
					return false;
				}
			});
			
		} );// end of document.ready
	
	</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
