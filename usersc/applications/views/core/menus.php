<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'menus_extend';
	$nama_tabels_d = [];
?>

<!-- begin content here -->

<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblmenus" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Label</th>
                                <th>Parent</th>
                                <th>Link</th>
                                <th>Dropdown</th>
                                <th>Authorized Group</th>
                                <th>Logged In</th>
                                <th>Display Order</th>
                                <th>Icon Class</th>
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

<!-- BEGIN datatables here -->
<script type="text/javascript">
		// ------------- default variable, do not erase
		var edtmenus, tblmenus, id_menus;
		// ------------- end of default variable

		var id_menus_old = 0;

		$(document).ready(function() {

			//start datatables editor
			edtmenus = new $.fn.dataTable.Editor( {
				ajax: {
					url: "../../models/core/menus.php",
					type: 'POST',
					data: function (d){
					}
				},
				table: "#tblmenus",
				fields: [ 
					{
						label: "menus_extend.start_at",
						name: "menus_extend.start_at",
						type: "hidden"
					},	
					{
						label: "menus_extend.finish_at",
						name: "menus_extend.finish_at",
						type: "hidden"
					},	
					{
						label: "nama_tabel",
						name: "nama_tabel",
						def: "menus_extend",
						type: "hidden"
					},	
					{
						label: "menus_extend.transaction_state",
						name: "menus_extend.transaction_state",
                        type: "hidden",
						def: 0
					},
					{
						label: "Parent",
						name: "menus.parent",
						type: "select2",
						opts: {
							placeholder : "Select",
							allowClear: true,
							multiple: false,
							ajax: {
								url: "../../models/core/menus_fn_opt.php",
								dataType: 'json',
								data: function (params) {
									var query = {
										id_menus_old: id_menus_old,
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
						label: "Dropdown",
						name: "menus.dropdown",
						type: "select",
						placeholder : "Select",
						options: [
							{ "label": "Yes", "value": 1 },
							{ "label": "No", "value": 0 }
						]
					},	
					{
						label: "Authorized Groups",
						name: "permissions[].id",
						type: "select2",
						opts: {
							"multiple": true
						}
					},	
					{
						label: "User must be logged in",
						name: "menus.logged_in",
						type: "select",
						def: 1,
						placeholder : "Select",
						options: [
							{ "label": "Yes", "value": 1 },
							{ "label": "No", "value": 0 }
						]
					}, 	
					{
						label: "Display Order <sup class='text-danger'>*<sup>",
						name: "menus.display_order",
						def: "9999"
					}, 	
					{
						label: "Label <sup class='text-danger'>*<sup>",
						name: "menus.label"
					}, 
					{
						label: "Link",
						name: "menus.link",
						def: "#"
					}, 
					{
						label: "Icon Class",
						name: "menus.icon_class",
						fieldInfo: "Be sure to add fa fa-fw before the shortcode to display properly"
					}
				]
			} );

			edtmenus.on( 'preOpen', function( e, mode, action ) {
				start_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtmenus.field('menus_extend.start_at').val(start_at);
				
				if(action == 'create'){
					tblmenus.rows().deselect();
				}
			});

			edtmenus.on("open", function (e, mode, action) {
				$(".modal-dialog").addClass("modal-lg");
			});

            edtmenus.on( 'preSubmit', function (e, data, action) {
				if(action != 'remove'){
					label         = edtmenus.field('menus.label').val();
					link          = edtmenus.field('menus.link').val();
					display_order = edtmenus.field('menus.display_order').val();

					validasiRequired(
						edtmenus,
						'menus',
						{
							'label': label,
							'link': link
						}
					);

					validasiNumber(
						edtmenus,
						'menus',
						{
							'display_order': display_order,
						},
						0,
						'>'
					);
                    
				}
				
				if ( edtmenus.inError() ) {
					return false;
				}
			});

			edtmenus.on('initSubmit', function(e, action) {
				finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtmenus.field('menus_extend.finish_at').val(finish_at);
			});

			edtmenus.on( 'postSubmit', function (e, json, data, action, xhr) {
				tblmenus.ajax.reload(null, false);
			});

			edtmenus.on( 'close', function () {
				edtmenus.enable();
			} );
			
			//start datatables
			tblmenus = $('#tblmenus').DataTable( {
				dom: domPQ,
				searchPanes:{
					layout: 'columns-4',
				},
				ajax: {
					url: "../../models/core/menus.php",
					type: 'POST',
					data: function (d){
					}
				},
				order: [[ 7, "asc" ]],
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
						targets: [0,4,5,6,7,8]
					}
				],
				columns: [
					{ data: "menus.id",visible:false },
					{ data: "menus.label" },
					{ data: "menus_parent.label" },
					{ data: "menus.link" },
					{ 
						data: "menus.dropdown" ,
						render: function (data){
							if (data == 0){
								return 'No';
							}else if(data == 1){
								return 'Yes';
							}
						}
					},
					{ data: "permissions[].name" },
					{ 
						data: "menus.logged_in" ,
						render: function (data){
							if (data == 0){
								return 'No';
							}else if(data == 1){
								return 'Yes';
							}
						}
					},
					{ data: "menus.display_order" },
					{ data: "menus.icon_class" }
					
				],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_menus';
						$table       = 'tblmenus';
						$edt         = 'edtmenus';
						$show_status = '_menus';
						$table_name  = $nama_tabel;

						$arr_buttons_tools 		= ['copy', 'excel'];
						$arr_buttons_tools2 	= ['sp', 'sb'];
						$arr_buttons_action 	= ['create', 'edit', 'remove', 'log'];
						$arr_buttons_approve 	= [];
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

			tblmenus.searchPanes.container().appendTo('#spmenus_extend');
			tblmenus.searchBuilder.container().appendTo( '#sbmenus_extend' );
			
			tblmenus.on( 'init', function () {
				// atur hak akses
				CekInitHeaderH(tblmenus);
			} );
			
			tblmenus.on( 'select', function( e, dt, type, indexes ) {
				menus_data    		= tblmenus.row( { selected: true } ).data().menus;
				menus_extend_data   = tblmenus.row( { selected: true } ).data().menus_extend;
				id_menus      		= menus_data.id;
				id_transaksi_h 		= id_menus; // dipakai untuk general
				id_transaksi_log	= id_menus; // dipakai untuk general
				transaction_state   = menus_extend_data.transaction_state;
				approval_state   	= menus_extend_data.approval_state;
				is_nextprocess 		= menus_extend_data.is_nextprocess;
				is_jurnal      		= menus_extend_data.is_jurnal;
				
				id_menus_old   = menus_data.id;

				// atur hak akses
				CekSelectHeaderH(tblmenus);
			} );

			tblmenus.on( 'deselect', function () {
				// reload dipanggil di function CekDeselectHeader
				id_menus = 0;
				id_menus_old = 0;

				// atur hak akses
				CekDeselectHeaderH(tblmenus);
			} );
			
		} );// end of document.ready
	
	</script>

<!-- END datatables here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
