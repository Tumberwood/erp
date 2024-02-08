<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>


<?php
	$nama_tabel    = 'iivxxrd';
	$nama_tabels_d = [];
?>

<!-- begin content here -->

<div class="row">
    <div class="col">
        <div class="ibox" id="iboxfilter">
            <div class="ibox-title">
                <h5 class="text-navy">Filter</h5>&nbsp
                <button class="btn btn-primary btn-xs collapse-link"><i class="fa fa-chevron-up"></i></button>
            </div>
            <div class="ibox-content">
                <form class="form-horizontal" id="frmiivxxrd">
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label">Periode</label>
                        <div class="col-lg-5">
                            <div class="input-group input-daterange" id="periode">
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
				<table id="tbliivxxrd" class="table table-striped table-bordered table-hover nowrap" width="100%">
					<thead>
						<tr>
							<th rowspan="2">Warehouse</th>
							<th rowspan="2">Kode</th>
							<th rowspan="2">Nama</th>
							<th colspan="2">Terkecil</th>
							<th colspan="2">Default</th>
						</tr>
						<tr>
							<th>UoM</th>
							<th>Jumlah</th>
							<th>UoM</th>
							<th>Jumlah</th>
						</tr>
					</thead>
				</table>
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

<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn.js"></script>

<!-- BEGIN datatables here -->
<script type="text/javascript">
		// ------------- default variable, do not erase
		var tbliivxxrd, show_deleted_iivxxrd = 0;
		// ------------- end of default variable
		var notifyprogress = '';

		// BEGIN datepicker init
		$('#periode').datepicker({
			setDate: new Date(),
			autoclose: true,
			todayHighlight: true,
			clearBtn: true,
			format: "dd M yyyy",
			minViewMode: 'month' 
		});
		$('#end_date').datepicker('setDate', tanggal_hariini_dmy);
        // END datepicker init

		$(document).ready(function() {
			end_date = moment($('#end_date').val()).format('YYYY-MM-DD');

			//start datatables
			tbliivxxrd = $('#tbliivxxrd').DataTable( {
				dom: domPQ,
				searchPanes:{
					layout: 'columns-4',
				},
				ajax: {
					url: "../../models/iivxxrd/iivxxrd.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_iivxxrd = show_deleted_iivxxrd;
						d.end_date = end_date;
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
						targets: [0]
					}
				],
				columns: [
					{ data: "iwhxxmh_kode" },
					{ data: "iimxxmh_kode" },
					{ data: "iimxxmh_nama" },
					{ data: "iumxxmh_terkecil_kode" },
					{ 
						data: "jumlah_terkecil",
						...renderNumber(2)
					},
					{ data: "iumxxmh_default_kode" },
					{ 
						data: "jumlah_default",
						render: $.fn.dataTable.render.number( ',', '.', 2,'','' ),
						class: "text-right"
					}
				],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_iivxxrd';
						$table       = 'tbliivxxrd';
						$edt         = 'edtiivxxrd';
						$show_status = '_iivxxrd';
						$table_name  = $nama_tabel;

						$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
						$arr_buttons_tools2 	= ['sp', 'sb'];
						$arr_buttons_action 	= [];
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

			tbliivxxrd.searchPanes.container().appendTo('#spiivxxrd');
			tbliivxxrd.searchBuilder.container().appendTo( '#sbiivxxrd' );

			
			$("#frmiivxxrd").submit(function(e) {
				e.preventDefault();
			}).validate({
				rules: {
					
				},
				submitHandler: function(frmiivxxrd) {
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

					tbliivxxrd.rows().deselect();
					tbliivxxrd.ajax.reload(function ( json ) {
						notifyprogress.close();
					}, false);
					return false; 
				}
			});
			
			
		} );// end of document.ready
	
	</script>

<!-- END datatables here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
