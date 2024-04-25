<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'htpxxth';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
    <div class="col">
        <div class="ibox collapsed" id="iboxfilter">
            <div class="ibox-title">
                <h5 class="text-navy">Filter</h5>&nbsp
                <button class="btn btn-primary btn-xs collapse-link"><i class="fa fa-chevron-up"></i></button>
            </div>
            <div class="ibox-content">
                <form class="form-horizontal" id="frmFilter">
                    <div class="form-group row">
						<label class="col-lg-2 col-form-label">Periode</label>
                        <div class="col-lg-5">
                            <div class="input-group input-daterange" id="periode">
                                <input type="text" id="start_date" class="form-control">
                                <span class="input-group-addon">to</span>
                                <input type="text" id="end_date" class="form-control">
                                <div class="input-group-addon">
                                    <span class="fa fa-calendar"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-4">
                            <button class="btn btn-primary" type="submit" id="go">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblhtpxxth" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
								<th>Kode</th>
								<th>Tanggal </th>
								<th>Karyawan</th>
								<th>Jenis</th>
								<th>Jabatan</th>
								<th>Department</th>
								<th>Keterangan </th>
								<th>Jam Awal</th>
								<th>Jam Akhir</th>
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
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn.js"></script>

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/htpxxth/fn/htpxxth_fn.php'; ?>

<!-- BEGIN datatables here -->
<script type="text/javascript">
		// ------------- default variable, do not erase
		var edthtpxxth, tblhtpxxth, show_deleted_htpxxth = 0, id_htpxxth;
		// ------------- end of default variable
		var id_hemxxmh_old = 0, id_httlpmh_old = 0;
		// get tableRelation
		
		tableRelation('htpxxth');

		start_date = null;
		end_date = null;

		kategori_dokumen = "";
		kategori_dokumen_value = "";
		
		// BEGIN datepicker init
		$('#periode').datepicker({
			setDate: new Date(),
			autoclose: true,
			todayHighlight: true,
			clearBtn: true,
			format: "dd M yyyy",
			minViewMode: 'month' 
		});
		$('#start_date').datepicker('setDate', awal_bulan_dmy);
		$('#end_date').datepicker('setDate', tanggal_hariini_dmy);
        // END datepicker init
		
		$(document).ready(function() {
			start_date = moment($('#start_date').val()).format('YYYY-MM-DD');
			end_date   = moment($('#end_date').val()).format('YYYY-MM-DD');

			//start datatables editor
			edthtpxxth = new $.fn.dataTable.Editor( {
				ajax: {
					url: "../../models/htpxxth/htpxxth.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_htpxxth = show_deleted_htpxxth;
						d.start_date = start_date;
						d.end_date = end_date;
					}
				},
				table: "#tblhtpxxth",
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
						label: "htpxxth.start_at",
						name: "htpxxth.start_at",
						type: "hidden"
					},	
					{
						label: "htpxxth.finish_at",
						name: "htpxxth.finish_at",
						type: "hidden"
					},	
					{
						label: "nama_tabel",
						name: "nama_tabel",
						def: "htpxxth",
						type: "hidden"
					},	
					{
						label: "htpxxth.transaction_state",
						name: "htpxxth.transaction_state",
                        type: "hidden",
						def: 0
					},
					{
						label: "Tanggal <sup class='text-danger'>*<sup>",
						name: "htpxxth.tanggal",
						type: "datetime",
						def: function () { 
							return moment($('#end_date').val()).format('DD MMM YYYY'); 
						},
						opts:{
							minDate: new Date('1900-01-01'),
							firstDay: 0
						},
						format: 'DD MMM YYYY'
					},	{
						label: "Karyawan <sup class='text-danger'>*<sup>",
						name: "htpxxth.id_hemxxmh",
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
					}, 	{
						label: "Jenis <sup class='text-danger'>*<sup>",
						name: "htpxxth.id_httlpmh",
						type: "select2",
						opts: {
							placeholder : "Select",
							allowClear: true,
							multiple: false,
							ajax: {
								url: "../../models/httlpmh/httlpmh_fn_opt.php",
								dataType: 'json',
								data: function (params) {
									var query = {
										id_httlpmh_old: id_httlpmh_old,
										jenis: 2,
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
					},	{
						label: "Jam Awal",
						name: "htpxxth.jam_awal",
						type: "datetime",
						opts:{
							minDate: new Date('1900-01-01'),
							firstDay: 0
						},
						format: 'HH:mm'
					},	{
						label: "Jam Akhir",
						name: "htpxxth.jam_akhir",
						type: "datetime",
						opts:{
							minDate: new Date('1900-01-01'),
							firstDay: 0
						},
						format: 'HH:mm'
					}, 	{
						label: "Keterangan <sup class='text-danger'>*<sup>",
						name: "htpxxth.keterangan",
						type: "textarea"
					}
				]
			} );

			edthtpxxth.on( 'preOpen', function( e, mode, action ) {
				start_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edthtpxxth.field('htpxxth.start_at').val(start_at);
				
				if(action == 'create'){
					edthtpxxth.field('kategori_dokumen').val('');
					edthtpxxth.field('kategori_dokumen_value').val('');
					edthtpxxth.field('field_tanggal').val('tanggal');
					tblhtpxxth.rows().deselect();
				}
			});

			edthtpxxth.on("open", function (e, mode, action) {
				$(".modal-dialog").addClass("modal-lg");
			});

			edthtpxxth.dependent( 'htpxxth.id_httlpmh', function ( val, data, callback ) {
				if(val > 0){
					id_httlpmh = val;
					get_httlpmh();
					if(jenis_jam == 1){
						edthtpxxth.field('htpxxth.jam_awal').show();
						edthtpxxth.field('htpxxth.jam_akhir').hide();

						edthtpxxth.field('htpxxth.jam_awal').label('Jam Awal <sup class="text-danger">*<sup>');
						edthtpxxth.field('htpxxth.jam_akhir').label('Jam Akhir');
						
						edthtpxxth.field('htpxxth.jam_akhir').val(null);
					}else if (jenis_jam == 2){
						edthtpxxth.field('htpxxth.jam_awal').hide();
						edthtpxxth.field('htpxxth.jam_akhir').show();

						edthtpxxth.field('htpxxth.jam_awal').label('Jam Awal');
						edthtpxxth.field('htpxxth.jam_akhir').label('Jam Akhir <sup class="text-danger">*<sup>');

						edthtpxxth.field('htpxxth.jam_awal').val(null);
					}else if (jenis_jam == 3){
						edthtpxxth.field('htpxxth.jam_awal').show();
						edthtpxxth.field('htpxxth.jam_akhir').show();
						edthtpxxth.field('htpxxth.jam_awal').label('Jam Awal <sup class="text-danger">*<sup>');
						edthtpxxth.field('htpxxth.jam_akhir').label('Jam Akhir <sup class="text-danger">*<sup>');

					}else{
						edthtpxxth.field('htpxxth.jam_awal').hide();
						edthtpxxth.field('htpxxth.jam_akhir').hide();

						edthtpxxth.field('htpxxth.jam_awal').label('Jam Awal');
						edthtpxxth.field('htpxxth.jam_akhir').label('Jam Akhir');

						edthtpxxth.field('htpxxth.jam_awal').val(null);
						edthtpxxth.field('htpxxth.jam_akhir').val(null);
					}
				}
				return {}
			}, {event: 'keyup change'});

            edthtpxxth.on( 'preSubmit', function (e, data, action) {
				if(action != 'remove'){
					id_hemxxmh = edthtpxxth.field('htpxxth.id_hemxxmh').val();
					id_httlpmh = edthtpxxth.field('htpxxth.id_httlpmh').val();
					tanggal = edthtpxxth.field('htpxxth.tanggal').val();
					keterangan = edthtpxxth.field('htpxxth.keterangan').val();

					validasiRequired(
						edthtpxxth,
						'htpxxth',
						{
							'id_httlpmh': id_httlpmh,
							'keterangan': keterangan,
							'tanggal': tanggal,
							'id_hemxxmh': id_hemxxmh,
						}
					);
				}
				
				if ( edthtpxxth.inError() ) {
					return false;
				}
			});
			
			edthtpxxth.on('initSubmit', function(e, action) {
				finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edthtpxxth.field('htpxxth.finish_at').val(finish_at);
			});

			edthtpxxth.on( 'postSubmit', function (e, json, data, action, xhr) {
				tblhtpxxth.rows().deselect();
				tblhtpxxth.ajax.reload(null, false);
			} );

			edthtpxxth.on( 'close', function () {
				edthtpxxth.enable();
			} );

			//start datatables
			tblhtpxxth = $('#tblhtpxxth').DataTable( {
				dom: domPQ,
				searchPanes:{
					layout: 'columns-4',
				},
				ajax: {
					url: "../../models/htpxxth/htpxxth.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_htpxxth = show_deleted_htpxxth;
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
				columns: [
					{ data: "htpxxth.id",visible:false },
					{ data: "htpxxth.kode" },
					{ data: "htpxxth.tanggal" },
					{ data: "hemxxmh_data" },
					{ data: "httlpmh.nama" },
					{ data: "hetxxmh.nama" },
					{ data: "hodxxmh.nama" },
					{ data: "htpxxth.keterangan" },
					{ data: "htpxxth.jam_awal" },
					{ data: "htpxxth.jam_akhir" },
					{ 
						data: "htpxxth.approval_state" ,
						...renderApprovalStatus()
					}
				],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_htpxxth';
						$table       = 'tblhtpxxth';
						$edt         = 'edthtpxxth';
						$show_status = '_htpxxth';
						$table_name  = $nama_tabel;

						$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
						$arr_buttons_tools2 	= ['sp', 'sb'];
						$arr_buttons_action 	= ['create', 'edit', 'remove', 'confirm', 'nonaktif_h', 'close', 'view', 'log','noaction'];
						$arr_buttons_approve 	= [];
						include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
					?>
					// END breaking generate button
					
					// BEGIN buttom Approval Set
					{
						extend: 'collection',
						name: 'btnSetApprove',
						text: '<span class="fa fa-check"></span>',
						titleAttr: 'Approval',
						className: 'btn btn-sm btn-outline',
						autoClose: true,
						buttons: [
							{ 
								text: '<i class="fa fa-check"></i>&nbsp;Approve',
								name: 'btnApprove1',
								className: 'btn btn-sm text-navy',
								titleAttr: 'Approve',
								action: function (e, dt, node, config) {
									$.ajax( {
										url: '../../models/htpxxth/htpxxth_post_approve.php',
										dataType: 'json',
										type: 'POST',
										data: {
											state           : 1,
                        					id_transaksi_h  : id_transaksi_h
										},
										success: function ( json ) {
											tblhtpxxth.ajax.reload(null, false);
										}
									} );
								}
							},
							{ 
								text: '<i class="fa fa-undo"></i>&nbsp;Cancel Approve',
								name: 'btnCancelApprove1',
								className: 'btn btn-sm',
								titleAttr: 'Approve',
								action: function ( e, dt, node, config ) {
									$.ajax( {
										url: '../../models/htpxxth/htpxxth_post_approve.php',
										dataType: 'json',
										type: 'POST',
										data: {
											state           : -1,
                        					id_transaksi_h  : id_transaksi_h
										},
										success: function ( json ) {
											tblhtpxxth.ajax.reload(null, false);
										}
									} );
								}
							},
							{
								text: '<i class="fa fa-remove"></i>&nbsp;Void',
								name: 'btnVoid1',
								className: 'btn btn-sm text-danger',
								titleAttr: 'Void',
								action: function ( e, dt, node, config ) {
									$.ajax( {
										url: '../../models/htpxxth/htpxxth_post_approve.php',
										dataType: 'json',
										type: 'POST',
										data: {
											state           : -9,
                        					id_transaksi_h  : id_transaksi_h
										},
										success: function ( json ) {
											tblhtpxxth.ajax.reload(null, false);
										}
									} );
								}
							}
						]
					}
					// END buttom Approval Set
				],
				initComplete: function() {
					this.api().searchPanes.rebuildPane();
				},
				rowCallback: function( row, data, index ) {
					if ( data.htpxxth.transaction_state == -9 ) {
						$('td', row).addClass('text-danger');
					}else if ( data.htpxxth.transaction_state == 0 ) {
						$('td', row).addClass('text-warning');
					}
				}
			} );

			tblhtpxxth.searchPanes.container().appendTo('#sphtpxxth');
			tblhtpxxth.searchBuilder.container().appendTo( '#sbhtpxxth' );
			
			tblhtpxxth.on( 'init', function () {
				// atur hak akses
				CekInitHeaderH(tblhtpxxth);
				tblhtpxxth.button( 'btnSetApprove:name' ).disable();
			} );
			
			tblhtpxxth.on( 'select', function( e, dt, type, indexes ) {
				htpxxth_data    		= tblhtpxxth.row( { selected: true } ).data().htpxxth;
				id_htpxxth      		= htpxxth_data.id;
				id_transaksi_h 		= id_htpxxth; // dipakai untuk general
				id_transaksi_log	= id_htpxxth; // dipakai untuk general
				transaction_state   = htpxxth_data.transaction_state;
				approval_state   	= htpxxth_data.approval_state;
				is_nextprocess 		= htpxxth_data.is_nextprocess;
				is_jurnal      		= htpxxth_data.is_jurnal;
				id_hemxxmh_old      		= htpxxth_data.id_hemxxmh;
				id_httlpmh_old      		= htpxxth_data.id_httlpmh;

				// atur hak akses
				CekSelectHeaderH(tblhtpxxth);
				
				// BEGIN approval button
				if (transaction_state == 1) {
					tblhtpxxth.button( 'btnSetApprove:name' ).enable();
				} else {
					tblhtpxxth.button( 'btnSetApprove:name' ).disable();
				}
				
				if(approval_state == 1){
					// approve
					tblhtpxxth.button( 'btnApprove1:name' ).disable();
					tblhtpxxth.button( 'btnCancelApprove1:name' ).enable();
					tblhtpxxth.button( 'btnVoid1:name' ).disable();
				}else if(approval_state == -1){
					// cancel approve
					tblhtpxxth.button( 'btnApprove1:name' ).enable();
					tblhtpxxth.button( 'btnCancelApprove1:name' ).disable();
					tblhtpxxth.button( 'btnVoid1:name' ).disable();
				}else if(approval_state == -9){
					// void
					tblhtpxxth.button( 'btnApprove1:name' ).disable();
					tblhtpxxth.button( 'btnCancelApprove1:name' ).disable();
					tblhtpxxth.button( 'btnVoid1:name' ).disable();
				}else{
					// open
					tblhtpxxth.button( 'btnApprove1:name' ).enable();
					tblhtpxxth.button( 'btnCancelApprove1:name' ).disable();
					tblhtpxxth.button( 'btnVoid1:name' ).enable();
				}
				// END approval button
			} );

			tblhtpxxth.on( 'deselect', function () {
				// reload dipanggil di function CekDeselectHeader
				id_htpxxth = 0;
				id_hemxxmh_old = 0;
				id_httlpmh_old = 0;

				// atur hak akses
				CekDeselectHeaderH(tblhtpxxth);
				tblhtpxxth.button( 'btnSetApprove:name' ).disable();
			} );
			
		} );// end of document.ready
		
		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
				
			},
			submitHandler: function(frmFilter) {
				start_date 		= moment($('#start_date').val()).format('YYYY-MM-DD');
				end_date 		= moment($('#end_date').val()).format('YYYY-MM-DD');
				
				notifyprogress = $.notify({
					message: 'Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!'
				},{
					z_index: 9999,
					allow_dismiss: false,
					type: 'info',
					delay: 0
				});

				tblhtpxxth.rows().deselect();
				tblhtpxxth.ajax.reload(function ( json ) {
					notifyprogress.close();
				}, false);
				return false; 
			}
		});
	
	</script>

<!-- END datatables here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
