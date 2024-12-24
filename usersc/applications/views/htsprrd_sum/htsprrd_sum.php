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

<div class="modal" id="modalFloatingFilter" tabindex="-1" role="dialog" aria-hidden="true">
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
					<div class="form-group row" id="input_jenis">
						<label class="col-lg-2 col-form-label">Cuti Khusus</label>
						<div class="col-lg-5">
							<div class="input-group">
								<select class="form-control" id="is_cuti_khusus" name="is_cuti_khusus">
									<option value="1">Yes</option>
									<option value="0">No</option>
								</select>
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
		var title_tooltip;
		filterFloating();

		$('#periode').datepicker({
			setDate: new Date(),
			autoclose: true,
			todayHighlight: true,
			clearBtn: true,
			format: "dd M yyyy",
			minViewMode: 'month' 
		});
		$('#start_date').datepicker('setDate', '');
		$('#end_date').datepicker('setDate', '');
		// $('#start_date').datepicker('setDate', awal_bulan_dmy);
		// $('#end_date').datepicker('setDate', tanggal_hariini_dmy);
		
		$(document).ready(function() {
			start_date 		= moment($('#start_date').val()).format('YYYY-MM-DD');
			end_date 		= moment($('#end_date').val()).format('YYYY-MM-DD');
			is_cuti_khusus =  $('#is_cuti_khusus').val();

			generateTable(start_date, is_cuti_khusus);

			//GENERATE TABLE
			function generateTable(start_date, is_cuti_khusus) {
				$('#report').show();
				$('#tabel_atas').empty();
				$('#searchPanes1').empty();
				mulai 		= moment($('#start_date').val()).format('DD MMM YYYY');
				selesai 		= moment($('#end_date').val()).format('DD MMM YYYY');
				$('#judul').html("Presensi Karyawan Tanggal " + mulai + " s/d " + selesai);
				
				$.ajax({
					url: "../../models/htsprrd_sum/htsprrd_sum.php",
					dataType: 'json',
					type: 'POST',
					data: {
						start_date: start_date,
						end_date: end_date,
						is_cuti_khusus: is_cuti_khusus,
					},
					success: function (json) {
						if (json.data.length > 0) {
							namaLeave();
							// Create an empty table
							var str1 = '<table id="tblhtsprrd1" class="table table-striped table-bordered table-hover nowrap">';
							str1 += '<thead>';
							str1 += '<tr>';
							str1 += '<th rowspan=2 style="vertical-align: middle" class="text-center">Nama</th>';
							str1 += '<th rowspan=2 style="vertical-align: middle" class="text-center">NIP</th>';
							str1 += '<th rowspan=2 style="vertical-align: middle" class="text-center">Jabatan</th>';

							$.each(json.columns, function (k, colObj) {
								// console.log(colObj.data);
								dataReport = colObj.data;
								subs_ceklok = dataReport.substring(10);
								label_httlpmh = dataReport.substring(7);
								// console.log(dataReport);

								sub_tanggal = dataReport.substring(0, 10);
								httlpmh	 = dataReport.substring(0, 7);

								var parsedDate = moment(sub_tanggal, "YYYY-MM-DD");

								// Format the parsed date as "26-Mar-24"
								var formattedDate = parsedDate.format("DD MMM YYYY");

								var count_hari = json.columns.filter(function(colObj) {
									return colObj.data.includes("httlpmh");
								}).length;
								// console.log(count_hari);
								
								if (dataReport == "httlpmhHK") {
									str1 += `<th colspan=${count_hari} class="text-center" style="vertical-align: middle">Leave</th>`;
								}

								if (dataReport == "htlgJAMDL") {
									str1 += '<th colspan=6 class="text-center" style="vertical-align: middle">Permission</th>';
								}

								if (dataReport == "Hari") {
									str1 += '<th rowspan=2 class="text-center" style="vertical-align: middle">'+dataReport+'</th>';
								} 
								if (dataReport == "JK") {
									str1 += '<th colspan=3 style="vertical-align: middle" class="text-center">Jadwal</th>';
								}

								if (dataReport == "Total") {
									str1 += '<th rowspan=2 class="text-center bg-warning" style="vertical-align: middle">'+dataReport+'</th>';
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
								label_httlpmh = dataReport.substring(7);

								sub_tanggal = dataReport.substring(0, 10);
								httlpmh	 = dataReport.substring(0, 7);
								title_tooltip = data_master[label_httlpmh];
								
								if (dataReport == "JK") {
									str1 += '<th rowspan=2 class="text-center bg-warning tooltipRows" title="Jadwal Kerja" style="vertical-align: middle;">' + dataReport + '</th>';
								} else if (dataReport == "OFF") {
									str1 += '<th rowspan=2 class="text-center tooltipRows" title="Jadwal Libur" style="vertical-align: middle;">' + dataReport + '</th>';
								} else if (dataReport == "No Jadwal") {
									str1 += '<th rowspan=2 class="text-center tooltipRows" title="Tidak Ada Jadwal" style="vertical-align: middle;">' + dataReport + '</th>';
								}

								if (httlpmh	 == "httlpmh") {
									if (label_httlpmh.includes("Cuti")) {
										var bgClass = 'bg-danger';
									} else {
										var bgClass = 'bg-warning';
									}
									
									str1 += '<th rowspan=2 class="text-center tooltipRows '+bgClass+'" title="'+title_tooltip+'" style="vertical-align: middle">'+label_httlpmh+'</th>';
								}

								if (httlpmh	 == "htlgJAM") {
									str1 += '<th rowspan=2 class="text-center tooltipRows" title="'+title_tooltip+'" style="vertical-align: middle">'+label_httlpmh+'</th>';
								}

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

							//tooltip
							$('.tooltipRows').tooltip({
								content: function() {
									return $(this).attr('title'); // Ambil atribut 'title' sebagai konten tooltip
								},
								html: true,
								placement: 'top'
							});

							$('#tblhtsprrd1').DataTable({
								"language": {
									"emptyTable": "No data available" // Custom message when there is no data
								},
								"dom": 'Bfrtip', // Hanya menampilkan Buttons, filter, dan table info
								"buttons": [
									 // Daftar tombol yang ingin ditampilkan
								],
								"paging": false, // Menonaktifkan pagination (show 10/100 dsb)
								"ordering": false, // Menonaktifkan pengurutan kolom
								"info": false, // Menonaktifkan informasi total baris
								"searching": false // Menonaktifkan kolom pencarian
							});

						} else {
							toastr['error']('Tidak ada data pada tanggal tersebut!', 'ERROR');
							// Generate the table structure dynamically
							var str1 = '<table id="tblhtsprrd1" class="table table-striped table-bordered table-hover nowrap">';
							str1 += '<thead>';
							str1 += '<tr>';
							str1 += '<th>Nama</th>';
							str1 += '<th>Jabatan</th>';
							str1 += '</tr>';
							str1 += '</thead>';

							str1 += '<tbody>';
							// No data in tbody
							str1 += '</tbody>';

							str1 += '</table>';

							// Update the table element
							$('#tabel_atas').html(str1);

							// Initialize DataTable with no data and custom message
							$('#tblhtsprrd1').DataTable({
								"language": {
									"emptyTable": "No data available" // Custom message when there is no data
								},
								"dom": 'Bfrtip', // Hanya menampilkan Buttons, filter, dan table info
								"buttons": [
									 // Daftar tombol yang ingin ditampilkan
								],
								"paging": false, // Menonaktifkan pagination (show 10/100 dsb)
								"ordering": false, // Menonaktifkan pengurutan kolom
								"info": false, // Menonaktifkan informasi total baris
								"searching": false // Menonaktifkan kolom pencarian
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
					end_date 		= moment($('#end_date').val()).format('YYYY-MM-DD');
					is_cuti_khusus =  $('#is_cuti_khusus').val();

					// toastr awal
					toastr.info('Harap tunggu ...', 'Proses Upload', {
						progressBar: false, 
						timeOut: 0, // Infinite timeout
						extendedTimeOut: 0
					});

					// tblhtsprrd.destroy();
					generateTable(start_date, is_cuti_khusus)
					toastr.clear();
					$('#modalFloatingFilter').modal('toggle');
					return false; 
				}
			});
			
		} );// end of document.ready
	
	</script>

<!-- END datatables here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
