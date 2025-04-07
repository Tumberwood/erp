<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel   = 'pages_extend';
	$nama_tabels_d = [];
?>

<!-- begin content here -->

<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblpages" class="table table-striped table-bordered table-hover nowrap responsive" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Page</th>
                                <th>Title</th>
                                <th>Info</th>
                                <th>C-U-D-A</th>
                                <th>Hal Setting</th>
                                <th>Private</th>
                                <th>Permissions</th>
                                <th data-i18n='state'></th>
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
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn2.js"></script>
<script src="<?=$us_url_root?>usersc/helpers/language.js"></script>
<!-- BEGIN datatables here -->
<script type="text/javascript">
		// ------------- default variable, do not erase
		var edtpages, tblpages, id_pages;
		// ------------- end of default variable

		// get tableRelation
		tableRelation('pages');		
		
		$(document).ready(function() {
			
			// BEGIN pages
			edtpages = new $.fn.dataTable.Editor( {
				formOptions: {
					main: {
						focus: 3,
					}
				},
				ajax: {
					url: "../../models/pages/pages_extend.php",
					type: 'POST',
					data: function (d){
					}
				},
				table: "#tblpages",
				formOptions: {
					main: {
						focus: 6
					}
				},
				fields: [ 
					{
						label: "pages_extend.start_at",
						name: "pages_extend.start_at",
						type: "hidden"
					},	
					{
						label: "pages_extend.finish_at",
						name: "pages_extend.finish_at",
						type: "hidden"
					},	
					{
						label: "nama_tabel",
						name: "nama_tabel",
						def: "pages_extend",
						type: "hidden"
					},	
					{
						label: "pages_extend.transaction_state",
						name: "pages_extend.transaction_state",
                        type: "hidden",
						def: 0
					},	
					{
						label: "Page",
						name: "pages.page",
                        type: "readonly"
					}, 	
					{
						label: "Title",  
						name: "pages.title"
					}, 	
					{
						label: "Info",
						name: "pages_extend.info"
					}, 	
					{
						label: "Perlu Atur C-U-D-A",
						name: "pages_extend.is_crud",
						type: "select",
						fieldInfo: "Akses untuk Menambahkan Data (C), Edit (U), Delete (D), Approve (A).<br>Jika Ya, maka harus diatur hak akses Data nya. <a href='udpxxsh.php' target='pages'>Atur Hak Akses Data</a>",
						placeholder : "Pilih",
						def: 1,
						options: [
							{ "label": "Ya", "value": 1 },
							{ "label": "Tidak", "value": 0 }
						]
					}, 	
					{
						label: "Halaman Setting",
						name: "pages_extend.is_setting",
						type: "select",
						placeholder : "Pilih",
						def: 0,
						options: [
							{ "label": "Tidak", "value": 0 },
							{ "label": "Ya", "value": 1 }
						]
					},
					{
						label: "Set this page as private?",
						name: "pages.private",
						type: "select",
						placeholder : "Pilih",
						def: 1,
						options: [
							{ "label": "This Page is Public", "value": 0 },
							{ "label": "This Page is Private (Protected)", "value": 1 }
						]
					},
					{
						label: "Permissions",
						name: "permissions[].id",
						type: "select2",
						opts: {
							"multiple": true
						}
					},	
				]
			} );

			edtpages.on( 'preOpen', function( e, mode, action ) {
				start_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtpages.field('pages_extend.start_at').val(start_at);
			});

			edtpages.on("open", function (e, mode, action) {
				$(".modal-dialog").addClass("modal-lg");
			})

			edtpages.on('initSubmit', function(e, action) {
				finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtpages.field('pages_extend.finish_at').val(finish_at);
			});

			edtpages.on( 'close', function () {
				edtpages.enable();
			} );
			
			//start datatables
			tblpages = $('#tblpages').DataTable( {
				dom: domPQ,
				searchPanes:{
					layout: 'columns-4',
				},
				ajax: {
					url: "../../models/pages/pages_extend.php",
					type: 'POST',
					data: function (d){
					}
				},
				order: [[ 1, "asc" ]],
				columnDefs:[
					{
						searchPanes:{
							show: true,
						},
						targets: [1,2,4,5]
					},
					{
						searchPanes:{
							show: false,
						},
						targets: [0,3]
					}
				],
				columns: [
					{ data: "pages.id",visible:false },
					{ data: "pages.page" },
					{ data: "pages.title" },
					{ data: "pages_extend.info"},
					{ 
						data: "pages_extend.is_crud", 
						...renderYaTidak()
					},
					{ 
						data: "pages_extend.is_setting", 
						...renderYaTidak()
					},
					{ 
						data: "pages.private", 
						...renderYaTidak()
					},
					{ data: "permissions[].name" },
					{ 
						data: "pages_extend.transaction_state" ,
						...renderTransactionStatus()
					},
				],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_pages';
						$table       = 'tblpages';
						$edt         = 'edtpages';
						$show_status = '_pages';
						$table_name  = $nama_tabel;

						$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
						$arr_buttons_tools2 	= ['sp', 'sb'];
						$arr_buttons_action 	= ['edit','view', 'log','noaction'];
						include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 

					?>
					// END breaking generate button
				],
				initComplete: function() {
					this.api().searchPanes.rebuildPane();
				}
			} );

			tblpages.searchPanes.container().appendTo('#sppages_extend');
			tblpages.searchBuilder.container().appendTo( '#sbpages_extend' );

			tblpages.on( 'init', function () {
				// atur hak akses
				CekInitHeaderH(tblpages);
			} );

			tblpages.on( 'select', function( e, dt, type, indexes ) {
				pages_data   		= tblpages.row( { selected: true } ).data().pages;
				pages_extend_data   = tblpages.row( { selected: true } ).data().pages_extend;
				id_pages      		= pages_data.id;
				id_transaksi_h 		= id_pages; // dipakai untuk general
				id_transaksi_log	= id_pages; // dipakai untuk general
				transaction_state   = pages_extend_data.transaction_state;
				approval_state   	= pages_extend_data.approval_state;
				is_nextprocess 		= pages_extend_data.is_nextprocess;

				// atur hak akses
				CekSelectHeaderH(tblpages);
			} );

			tblpages.on( 'deselect', function () {
				// reload dipanggil di function CekDeselectHeader
				id_pages = '';

				// atur hak akses
				CekDeselectHeaderH(tblpages);
			} );

			// END pages

		} );// end of document.ready
	
	</script>

<!-- END datatables here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
