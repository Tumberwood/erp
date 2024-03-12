<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'users';
	$nama_tabels_d = [];
?>

<!-- begin content here -->

<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblusers" class="table table-striped table-bordered table-hover" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Permission</th>
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

<!-- BEGIN datatables here -->
<script type="text/javascript">
		// ------------- default variable, do not erase
		var edtgeneral_s, tblgeneral_s, id_general_s;
		// ------------- end of default variable
		
		$(document).ready(function() {
			
			tblusers = $('#tblusers').DataTable( {
				dom: domPQ,
				searchPanes:{
					layout: 'columns-4',
				},
				ajax: {
					url: "../../models/core/users_r_permissions.php",
					type: 'POST',
					data: function (d){
					}
				},
				order: [[ 0, "asc" ]],
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
						targets: [0]
					}
				],
				responsive: false,
				columns: [
					{ data: "users.id"},
					{ data: "users.username"},
					{ data: "users.fname" },
					{ data: "users.lname" },
					{ data: "permissions[].name" }
				],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_users';
						$table       = 'tblusers';
						$edt         = 'edtusers';
						$show_status = '_users';
						$table_name  = $nama_tabel;

						$arr_buttons_tools 		= ['copy','excel','colvis'];
						$arr_buttons_tools2 	= ['sp','sb'];
						$arr_buttons_action 	= [];
						include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
					?>
					// END breaking generate button

				],
				initComplete: function() {
					this.api().searchPanes.rebuildPane();
				}
			} );
			
			tblusers.on( 'select', function( e, dt, type, indexes ) {
				id_users = tblusers.row( { selected: true } ).data().users.id;
			} );

			tblusers.searchPanes.container().appendTo('#spusers');
			tblusers.searchBuilder.container().appendTo( '#sbusers' );
			
		} );// end of document.ready
	
	</script>

<!-- END datatables here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
