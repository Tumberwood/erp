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
                                <th>ID</th>
                                <th>Posisi Logo</th>
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
		var edtggsxxsh, tblggsxxsh, show_deleted_ggsxxsh = 0, id_ggsxxsh;
		var id_iumxxmh_panjang_old = 0;
		var id_iumxxmh_berat_old = 0;
		// ------------- end of default variable
		
		// get tableRelation
		tableRelation('ggsxxsh');

		$(document).ready(function() {
			
			// BEGIN ggsxxsh
			edtggsxxsh = new $.fn.dataTable.Editor( {
				ajax: {
					url: "../../models/ggsxxsh/ggsxxsh.php",
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
						label: "Logo Perusahaan",
						name: "ggsxxsh.id_files_company_logo",
						type: "upload",
                        display: function(id) {
							if (id > 0) {
								return '<img src="' + edtggsxxsh.file('files', id).web_path + '"/>';
							} else {
								return 'Belum ada gambar';
							}
						},
					},	
					{
						label: "Posisi Logo Login",
						name: "ggsxxsh.posisi_logo_login",
						type: "select",
						options: [
							{ "label": "Atas", "value": 1 },
							{ "label": "Bawah", "value": 2 }
						]
					}, 	
					{
						label: "Keterangan",
						name: "ggsxxsh.keterangan",
						type: "textarea"
					},
					{
						label: "API Key Gemini AI",
						name: "ggsxxsh.gemini_api_key",
					},
					{
						label: getTranslation('language'),
						name: "ggsxxsh.language",
						type: "select",
						placeholder : "Select",
						options: [
							{ "label": "English", "value": 'en' },
							{ "label": "Indonesia", "value": 'id' }
						]
					},
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
				
				$('div.DTE_Form_Buttons button:eq(2)').hide();
			});

            edtggsxxsh.on( 'preSubmit', function (e, data, action) {
				if(action != 'remove'){
					
				}
				
				if ( edtggsxxsh.inError() ) {
					return false;
				}
			});

			edtggsxxsh.on('initSubmit', function(e, action) {
				finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtggsxxsh.field('ggsxxsh.finish_at').val(finish_at);
			});
			
			tblggsxxsh = $('#tblggsxxsh').DataTable( {
				ajax: {
					url: "../../models/ggsxxsh/ggsxxsh.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_ggsxxsh = show_deleted_ggsxxsh;
					}
				},
				order: [[ 1, "asc" ]],
				columns: [
					{ data: "ggsxxsh.id",visible:false },
					{ 
                        data: "ggsxxsh.posisi_logo_login" ,
                        render: function (data){
							if (data == 1){
								return 'Atas';
							}else if(data == 2){
								return 'Bawah';
							}else{
                                return '';
                            }
						}
                    },
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
						$arr_buttons_tools2 	= [];
						$arr_buttons_action 	= ['edit','view', 'log','noaction'];
						include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
					?>
					// END breaking generate button
				]
			} );
			
			tblggsxxsh.on( 'init', function () {
				// atur hak akses
				CekInitHeaderH(tblggsxxsh);
			} );
			
			tblggsxxsh.on( 'select', function( e, dt, type, indexes ) {
				ggsxxsh_data           = tblggsxxsh.row( { selected: true } ).data().ggsxxsh;
				id_ggsxxsh             = ggsxxsh_data.id;
				id_transaksi_h         = id_ggsxxsh;                                           // dipakai untuk general
				id_transaksi_log       = id_ggsxxsh;                                           // dipakai untuk general
				transaction_state      = ggsxxsh_data.transaction_state;
				approval_state         = ggsxxsh_data.approval_state;
				is_nextprocess         = ggsxxsh_data.is_nextprocess;
				is_default         	   = ggsxxsh_data.is_default;

				// atur hak akses
				CekSelectHeaderH(tblggsxxsh);
			} );

			tblggsxxsh.on( 'deselect', function () {
				// reload dipanggil di function CekDeselectHeader
				id_ggsxxsh = '';

				// atur hak akses
				CekDeselectHeaderH(tblggsxxsh);
			} );
			
			// END ggsxxsh
			
		} );// end of document.ready
	
	</script>

<!-- END datatables here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
