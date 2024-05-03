<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'gcpxxmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->

<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblgcpxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>BU</th>
                                <th data-i18n="companyName"></th>
                                <th data-i18n="address"></th>
                                <th data-i18n="city"></th>
                                <th>NPWP</th>
                                <th>KLU</th>
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
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn.js"></script>
<script src="<?=$us_url_root?>usersc/helpers/language.js"></script>

<!-- BEGIN datatables here -->
<script type="text/javascript">
		// ------------- default variable, do not erase
		var edtgcpxxmh, tblgcpxxmh, show_deleted_gcpxxmh = 0, id_gcpxxmh;
		// ------------- end of default variable

		var id_gbuxxmh_old = 0, id_gctxxmh_old = 0;
		
		// get tableRelation
		tableRelation('gcpxxmh');

		$(document).ready(function() {
			
			// BEGIN gcpxxmh
			edtgcpxxmh = new $.fn.dataTable.Editor( {
				ajax: {
					url: "../../models/core/gcpxxmh.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_gcpxxmh = show_deleted_gcpxxmh;
					}
				},
				table: "#tblgcpxxmh",
				fields: [ 
					{
						label: "gcpxxmh.start_at",
						name: "gcpxxmh.start_at",
						type: "hidden"
					},	
					{
						label: "gcpxxmh.finish_at",
						name: "gcpxxmh.finish_at",
						type: "hidden"
					},	
					{
						label: "nama_tabel",
						name: "nama_tabel",
						def: "gcpxxmh",
						type: "hidden"
					},	
					{
						label: "gcpxxmh.transaction_state",
						name: "gcpxxmh.transaction_state",
                        type: "hidden",
						def: 0
					},	
					{
						label: getTranslation('businessEntityCode') + " <sup class='text-danger'>*<sup>",
						name: "gcpxxmh.id_gbuxxmh",
						type: "select2",
						opts: {
							placeholder : "Select",
							allowClear: true,
							multiple: false,
							ajax: {
								url: "../../models/core/gbuxxmh_fn_opt.php",
								dataType: 'json',
								data: function (params) {
									var query = {										
										id_gbuxxmh_old: id_gbuxxmh_old,
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
						label: getTranslation('companyName') + " <sup class='text-danger'>*<sup>",
						name: "gcpxxmh.nama"
					}, 	
					{
						label: getTranslation('address') + " <sup class='text-danger'>*<sup>",
						name: "gcpxxmh.alamat"
					},	
					{
						label: getTranslation('city') + " <sup class='text-danger'>*<sup>",
						name: "gcpxxmh.id_gctxxmh",
						type: "select2",
						opts: {
							placeholder : "Select",
							allowClear: true,
							multiple: false,
							ajax: {
								url: "../../models/core/gctxxmh_fn_opt.php",
								dataType: 'json',
								data: function (params) {
									var query = {
										id_gctxxmh_old: id_gctxxmh_old,
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
						label: "NPWP",
						name: "gcpxxmh.npwp"
					},	
					{
						label: "KLU",
						name: "gcpxxmh.klu"
					}
				]
			} );

			edtgcpxxmh.on( 'preOpen', function( e, mode, action ) {
				start_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtgcpxxmh.field('gcpxxmh.start_at').val(start_at);
				
				if(action == 'create'){
					tblgcpxxmh.rows().deselect();

					edtgcpxxmh.field('gcpxxmh.nama').enable();

				}else if(action == 'edit'){
					
					if(transaction_state == 0){
						edtgcpxxmh.field('gcpxxmh.nama').enable();
					}else{
						edtgcpxxmh.field('gcpxxmh.nama').disable();
					}
				}
			});

			edtgcpxxmh.on("open", function (e, mode, action) {
				$(".modal-dialog").addClass("modal-lg");

				// enable disable tombol Save & Confirm
				edtFormButtonSaveConfirm();
			});

            edtgcpxxmh.on( 'preSubmit', function (e, data, action) {
				if(action != 'remove'){

					nama = edtgcpxxmh.field('gcpxxmh.nama').val();
					alamat = edtgcpxxmh.field('gcpxxmh.alamat').val();
					id_gctxxmh = edtgcpxxmh.field('gcpxxmh.id_gctxxmh').val();
					npwp = edtgcpxxmh.field('gcpxxmh.npwp').val();

					validasiRequired(
						edtgcpxxmh,
						'gcpxxmh',
						{
							'nama': nama,
							'alamat': alamat,
							'id_gctxxmh': id_gctxxmh,
							'npwp': npwp
						}
					);
					
					if (npwp != '') {
						if(npwp <= 0 ){
							edtgcpxxmh.field('gcpxxmh.npwp').error( 'Inputan harus > 0' );
						}
						
						// validasi angka
						if(isNaN(npwp) ){
							edtgcpxxmh.field('gcpxxmh.npwp').error( 'Inputan harus berupa Angka!' );
						}

						if (npwp.length != 15) {
							edtgcpxxmh.field('gcpxxmh.npwp').error( 'Inputan Wajib 15 Digit Angka!' );
						}
					}

					klu = edtgcpxxmh.field('gcpxxmh.klu').val();
					if (klu != '') {
						if(klu <= 0 ){
							edtgcpxxmh.field('gcpxxmh.klu').error( 'Inputan harus > 0' );
						}
						
						// validasi angka
						if(isNaN(klu) ){
							edtgcpxxmh.field('gcpxxmh.klu').error( 'Inputan harus berupa Angka!' );
						}

						if (klu.length != 5) {
							edtgcpxxmh.field('gcpxxmh.klu').error( 'Inputan Wajib 5 Digit Angka!' );
						}
					}
				}
				
				if ( edtgcpxxmh.inError() ) {
					return false;
				}
			});

			edtgcpxxmh.on('initSubmit', function(e, action) {
				finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtgcpxxmh.field('gcpxxmh.finish_at').val(finish_at);
			});

			edtgcpxxmh.on( 'close', function () {
				edtgcpxxmh.enable();
			} );
			
			tblgcpxxmh = $('#tblgcpxxmh').DataTable( {
				ajax: {
					url: "../../models/core/gcpxxmh.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_gcpxxmh = show_deleted_gcpxxmh;
					}
				},
				order: [[ 2, "asc" ],[1,"asc"]],
				columns: [
					{ data: "gcpxxmh.id",visible:false },
					{ data: "gbuxxmh.kode" },
					{ data: "gcpxxmh.nama" },
					{ data: "gcpxxmh.alamat" },
					{ data: "gctxxmh.nama" },
					{ data: "gcpxxmh.npwp" },
					{ data: "gcpxxmh.klu" },
					{ 
						data: "gcpxxmh.transaction_state" ,
						...renderTransactionStatus()
					}
				],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_gcpxxmh';
						$table       = 'tblgcpxxmh';
						$edt         = 'edtgcpxxmh';
						$show_status = '_gcpxxmh';
						$table_name  = $nama_tabel;

						$arr_buttons_tools 		= ['show_hide', 'copy', 'excel', 'colvis'];
						$arr_buttons_tools2 	= [];
						$arr_buttons_action 	= ['edit', 'nonaktif_h', 'view', 'log'];
						include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
					?>
					// END breaking generate button
				],
				initComplete: function() {
					this.api().searchPanes.rebuildPane();
				},
				rowCallback: function( row, data, index ) {
				
				}
			} );

			tblgcpxxmh.on( 'init', function () {
				// atur hak akses
				CekInitHeaderH(tblgcpxxmh);
			} );
			
			tblgcpxxmh.on( 'select', function( e, dt, type, indexes ) {
				// set variable standar framework
				siVarSet('gcpxxmh');
				id_gbuxxmh_old = gcpxxmh_data.id_gbuxxmh;
				id_gctxxmh_old = gcpxxmh_data.id_gctxxmh;

				// atur hak akses
				CekSelectHeaderH(tblgcpxxmh);
			} );

			tblgcpxxmh.on( 'deselect', function () {
				// reset variable standar framework
				siVarReset('gcpxxmh');
				id_gbuxxmh_old = 0;
				id_gctxxmh_old = 0;

				// atur hak akses
				CekDeselectHeaderH(tblgcpxxmh);
			} );
			
			// END gcpxxmh
		} );// end of document.ready
	
	</script>

<!-- END datatables here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
