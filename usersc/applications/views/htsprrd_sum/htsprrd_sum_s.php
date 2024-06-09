<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'htsprrd_sum';
	$nama_tabels_d = [];
?>

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

<div class="row" id="report" style="display: none">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
					<h3 id="judul"></h3>
                	<div id="searchPanes1"></div>
					<div id="tabel_atas"></div>
				</div> <!-- end of table -->
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/htsprrd_sum/fn/htsprrd_sum_fn.php'; ?>

<!-- BEGIN datatables here -->
<script type="text/javascript">
		// ------------- default variable, do not erase
		var edthtsprrd_sum, tblhtsprrd_sum, show_deleted_htsprrd_sum = 0, id_htsprrd_sum;
		// ------------- end of default variable

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
		
		$(document).ready(function() {
			start_date 		= moment($('#start_date').val()).format('YYYY-MM-DD');
			end_date 		= moment($('#end_date').val()).format('YYYY-MM-DD');

			//GENERATE TABLE
			function generateTable(start_date) {
				$('#report').show();
				$('#tabel_atas').empty();
				$('#searchPanes1').empty();
				mulai 		= moment($('#start_date').val()).format('DD MMM YYYY');
				selesai 		= moment($('#end_date').val()).format('DD MMM YYYY');
				$('#judul').html("Presensi Karyawan Tanggal " + mulai + " s/d " + selesai);
				
				$.ajax({
					url: "../../models/htsprrd_sum/htsprrd_sum_s.php",
					dataType: 'json',
					type: 'POST',
					data: {
						start_date: start_date,
						end_date: end_date,
					},
					success: function (json) {
						if (json.data.length > 0) {
							// Create an empty table
							var str1 = '<table id="tblhtsprrd1" class="table table-striped table-bordered table-hover nowrap">';
							str1 += '<thead>';
							str1 += '<tr>';
							str1 += '<th rowspan=2 style="vertical-align: middle" class="text-center">Nama</th>';
							str1 += '<th rowspan=2 style="vertical-align: middle" class="text-center">NIP</th>';
							str1 += '<th rowspan=2 style="vertical-align: middle" class="text-center">Kode Finger</th>';
							str1 += '<th rowspan=2 style="vertical-align: middle" class="text-center">Jabatan</th>';

							$.each(json.columns, function (k, colObj) {
								// console.log(colObj.data);
								dataReport = colObj.data;
								subs_ceklok = dataReport.substring(10);
								label_htlgrmh = dataReport.substring(7);
								// console.log(dataReport);

								sub_tanggal = dataReport.substring(0, 10);
								htlgrmh	 = dataReport.substring(0, 7);

								var parsedDate = moment(sub_tanggal, "YYYY-MM-DD");

								// Format the parsed date as "26-Mar-24"
								var formattedDate = parsedDate.format("DD-MMM-YY");

								if (dataReport == "htlgrmhNoJadwal") {
									str1 += '<th rowspan=2 class="text-center" style="vertical-align: middle">No Jadwal</th>';
								}

								if (htlgrmh	 == "htlgrmh" && dataReport != "htlgrmhNoJadwal") {
									str1 += '<th rowspan=2 class="text-center" style="vertical-align: middle">'+label_htlgrmh+'</th>';
								}

								if (dataReport == "Total") {
									str1 += '<th rowspan=2 class="text-center" style="vertical-align: middle">'+dataReport+'</th>';
								}

								if (subs_ceklok == "In") {
									str1 += '<th colspan=2 class="text-center">'+formattedDate+'</th>';
								}								
							});
							str1 += '</tr>';
							
							str1 += '<tr>';
							// Loop through columns and add them to the table header
							$.each(json.columns, function (k, colObj) {
								// console.log(colObj.data);
								dataReport = colObj.data;
								subs_ceklok = dataReport.substring(10);

								if (subs_ceklok == "In" || subs_ceklok == "Out") {
									str1 += '<th  class="text-center">';
									str1 += subs_ceklok + '</th>';
								}
							});
							str1 += '</tr>';
							str1 = str1 + '</thead>';
							str1 += '<tbody>';

							// Loop through data and add rows to the table body
							$.each(json.data, function (index, rowData) {
								str1 += '<tr>';

								$.each(json.columns, function (k, colObj) {
									var columnName = colObj.data;
									var cellValue = rowData[columnName];

									console.log(columnName);
									console.log(cellValue);
									// console.log(cellValue);
									if (cellValue == undefined) {
										cellValue = "-";
									}
									str1 += '<td>' + cellValue + '</td>';
								});
								str1 += '</tr>';
							});

							str1 += '</tbody>';
							str1 += '</table>';

							// Update the table element
							$('#tabel_atas').html(str1);

							// Initialize DataTable
							tblhtsprrd1 = $('#tblhtsprrd1').DataTable({
								responsive: false,
								searchPanes:{
									layout: 'columns-4',
								},
								dom: 
									"<P>"+
									"<lf>"+
									"<B>"+
									"<rt>"+
									"<'row'<'col-sm-4'i><'col-sm-8'p>>",
								columnDefs:[
									{
										searchPanes:{
											show: true,
										},
										targets: [0,1,2,3]
									},
									{
										searchPanes:{
											show: false,
										},
										targets: '_all'
									},
									{
										target: [4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20],
										...renderNumber()
									}
								],
								buttons: [

									// BEGIN breaking generate button
									<?php
										$id_table    = 'id_htoxxth';
										$table       = 'tblhtoxxth';
										$edt         = 'edthtoxxth';
										$show_status = '_htoxxth';
										$table_name  = $nama_tabel;

										$arr_buttons_tools 		= ['copy','excel','colvis'];
										$arr_buttons_tools2 	= [];
										$arr_buttons_action 	= [];
										include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
									?>
								]
							});
							tblhtsprrd1.searchPanes.container().appendTo( '#searchPanes1' );
							
						} else {
							// notifyprogress.close();
							notifyprogress = $.notify({
								message: 'Tidak ada data pada tanggal tersebut!'
							}, {
								z_index: 9999,
								allow_dismiss: false,
								type: 'danger',
								delay: 3
							});
						}
					}
				});
			}

			// FORM PERIODE
			
			$("#frmFilter").submit(function(e) {
				e.preventDefault();
			}).validate({
				rules: {
					
				},
				submitHandler: function(frmFilter) {
					start_date 		= moment($('#start_date').val()).format('YYYY-MM-DD');
					// console.log(start_date);
					
					notifyprogress = $.notify({
						message: 'Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!'
					},{
						z_index: 9999,
						allow_dismiss: false,
						type: 'info',
						delay: 0
					});
					// tblhtsprrd.destroy();
					generateTable(start_date)
					
					notifyprogress.close();
					return false; 
				}
			});
			
		} );// end of document.ready
	
	</script>

<!-- END datatables here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
