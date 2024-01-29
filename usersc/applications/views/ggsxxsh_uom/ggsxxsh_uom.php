<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'ggsxxsh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblggsxxsh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>UoM Berat</th>
                                <th>UoM Panjang</th>
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
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn.js"></script>

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/ggsxxsh_uom/fn/ggsxxsh_uom_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
		// ------------- default variable, do not erase
		var edtggsxxsh, tblggsxxsh, show_deleted_ggsxxsh = 0, id_ggsxxsh;
		var id_iumxxmh_panjang_old = 0;
		var id_iumxxmh_berat_old = 0;
		// ------------- end of default variable

		$(document).ready(function() {
			//start datatables editor
			edtggsxxsh = new $.fn.dataTable.Editor( {
				ajax: {
					url: "../../models/ggsxxsh_uom/ggsxxsh_uom.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_ggsxxsh = show_deleted_ggsxxsh;
					}
				},
				table: "#tblggsxxsh",
				fields: [ 
					{
						label: "ggsxxsh.start_at",
						name: "ggsxxsh.start_at",
						type: "hidden"
					},	
					{
						label: "ggsxxsh.finish_at",
						name: "ggsxxsh.finish_at",
						type: "hidden"
					},	
					{
						label: "nama_tabel",
						name: "nama_tabel",
						def: "ggsxxsh",
						type: "hidden"
					},	
					{
						label: "ggsxxsh.transaction_state",
						name: "ggsxxsh.transaction_state",
                        type: "hidden",
						def: 0
					},	
					{
						label: "UoM Panjang <sup class='text-danger'>*<sup>",  
						name: "ggsxxsh.id_iumxxmh_panjang",
						type: "select2",
						opts: {
							placeholder : "Select",
							allowClear: true,
							multiple: false,
							ajax: {
								url: "../../models/iumxxmh/iumxxmh_fn_opt.php",
								dataType: 'json',
								data: function (params) {
									var query = {
										id_iumxxmh_old: id_iumxxmh_panjang_old,
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
						label: "UoM Berat <sup class='text-danger'>*<sup>",
						name: "ggsxxsh.id_iumxxmh_berat",
						type: "select2",
						opts: {
							placeholder : "Select",
							allowClear: true,
							multiple: false,
							ajax: {
								url: "../../models/iumxxmh/iumxxmh_fn_opt.php",
								dataType: 'json',
								data: function (params) {
									var query = {
										id_iumxxmh_old: id_iumxxmh_berat_old,
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
					}
				]
			} );

			edtggsxxsh.on( 'preOpen', function( e, mode, action ) {
				start_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtggsxxsh.field('ggsxxsh.start_at').val(start_at);
				
				if(action == 'create'){
					tblggsxxsh.rows().deselect();
				}
			});

			edtggsxxsh.on("open", function (e, mode, action) {
				$(".modal-dialog").addClass("modal-lg");
			});

            edtggsxxsh.on( 'preSubmit', function (e, data, action) {
				if(action != 'remove'){
					id_iumxxmh_berat = edtggsxxsh.field('ggsxxsh.id_iumxxmh_berat').val();
					if(!id_iumxxmh_berat || id_iumxxmh_berat == ''){
						edtggsxxsh.field('ggsxxsh.id_iumxxmh_berat').error( 'Wajib diisi!' );
					}

					id_iumxxmh_panjang = edtggsxxsh.field('ggsxxsh.id_iumxxmh_panjang').val();
					if(!id_iumxxmh_panjang || id_iumxxmh_panjang == ''){
						edtggsxxsh.field('ggsxxsh.id_iumxxmh_panjang').error( 'Wajib diisi!' );
					}
				}
				
				if ( edtggsxxsh.inError() ) {
					return false;
				}
			});
			
			edtggsxxsh.on('initSubmit', function(e, action) {
				finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtggsxxsh.field('ggsxxsh.finish_at').val(finish_at);
			});

			edtggsxxsh.on( 'close', function () {
				edtggsxxsh.enable();
			} );

			//start datatables
			tblggsxxsh = $('#tblggsxxsh').DataTable( {
				dom: domPQ,
				searchPanes:{
					layout: 'columns-4',
				},
				ajax: {
					url: "../../models/ggsxxsh_uom/ggsxxsh_uom.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_ggsxxsh = show_deleted_ggsxxsh;
					}
				},
				order: [[ 1, "asc" ]],
				columnDefs:[
					{
						searchPanes:{
							show: true,
						},
						targets: [0,1]
					},
					// {
					// 	searchPanes:{
					// 		show: false,
					// 	},
					// 	targets: [0]
					// }
				],
				columns: [
					{ data: "berat.nama"},
					{ data: "panjang.nama" }
				],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_ggsxxsh';
						$table       = 'tblggsxxsh';
						$edt         = 'edtggsxxsh';
						$show_status = '_ggsxxsh';
						$table_name  = $nama_tabel;

						$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
						$arr_buttons_tools2 	= ['sp', 'sb'];
						$arr_buttons_action 	= ['edit', 'remove', 'confirm', 'nonaktif_h', 'view', 'log','noaction'];
						$arr_buttons_approve 	= [];
						include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
					?>
					// END breaking generate button
				],
				initComplete: function() {
					this.api().searchPanes.rebuildPane();
				},
				rowCallback: function( row, data, index ) {
					if ( data.ggsxxsh.transaction_state == -9 ) {
						$('td', row).addClass('text-danger');
					}else if ( data.ggsxxsh.transaction_state == 0 ) {
						$('td', row).addClass('text-warning');
					}
				}
			} );

			tblggsxxsh.searchPanes.container().appendTo('#spggsxxsh');
			tblggsxxsh.searchBuilder.container().appendTo( '#sbggsxxsh' );
			
			tblggsxxsh.on( 'init', function () {
				// atur hak akses
				CekInitHeaderH(tblggsxxsh);
			} );
			
			tblggsxxsh.on( 'select', function( e, dt, type, indexes ) {
				ggsxxsh_data    	= tblggsxxsh.row( { selected: true } ).data().ggsxxsh;
				id_ggsxxsh      	= ggsxxsh_data.id;
				id_transaksi_h 		= id_ggsxxsh; // dipakai untuk general
				id_transaksi_log	= id_ggsxxsh; // dipakai untuk general
				transaction_state   = ggsxxsh_data.transaction_state;
				approval_state   	= ggsxxsh_data.approval_state;
				is_nextprocess 		= ggsxxsh_data.is_nextprocess;
				is_jurnal      		= ggsxxsh_data.is_jurnal;
				id_iumxxmh_berat      		= ggsxxsh_data.id_iumxxmh_berat;
				id_iumxxmh_panjang      		= ggsxxsh_data.id_iumxxmh_panjang;
				
				id_ggsxxsh_parent_old = ggsxxsh_data.id_ggsxxsh_parent;

				// atur hak akses
				CekSelectHeaderH(tblggsxxsh);
			} );

			tblggsxxsh.on( 'deselect', function () {
				// reload dipanggil di function CekDeselectHeader
				id_ggsxxsh = 0;
				id_ggsxxsh_parent_old = 0;
				id_iumxxmh_berat = 0;
				id_iumxxmh_panjang = 0;

				// atur hak akses
				CekDeselectHeaderH(tblggsxxsh);
			} );
			
		} );// end of document.ready
	
	</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
