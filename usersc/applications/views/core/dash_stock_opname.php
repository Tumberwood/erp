<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel   = '';
	$nama_tabels_d = [];
	// tes webhook
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
                <form class="form-horizontal" id="frmisoittd_upload">
					<div class="form-group row">
						<label class="col-lg-2 col-md-2">Kode</label>
						<div class="col-lg-4 col-sm-4">
							<select class="form-control" id="selectKode" name="selectKode" multiple="multiple"></select>
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

<div class="row" id="showing" style="display: none">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				<h3>Result By Row Data</h3>
				<div class="row">
					<div class="col-lg-3">
						<div class="widget no-padding">
							<div class="p-m">
								<h1 class="text-center font-bold" id="targetRows" style="font-size: 40px"></h1>
								<br>
								<h4 class="no-margins text-center">
									Target
								</h4>
							</div>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="widget no-padding">
							<div class="p-m">
								<h1 class="text-center font-bold" id="c_uploadRows" style="font-size: 40px"></h1>
								<br>
								<h4 class="no-margins text-center">
									Total Upload
								</h4>
							</div>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="widget navy-bg no-padding">
							<div class="p-m">
								<h1 class="text-center font-bold" id="terhitungRows" style="font-size: 40px"></h1>
								<h3 class="no-margins font-bold text-center" id="p_terhitungRows" style="font-size: 20px"></h3>
								<h4 class="no-margins text-center">
									Terhitung
								</h3>
							</div>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="widget red-bg no-padding">
							<div class="p-m">
								<h1 class="text-center font-bold" id="not_terhitungRows" style="font-size: 40px"></h1>
								<h3 class="no-margins font-bold text-center" id="p_not_terhitungRows" style="font-size: 20px"></h3>
								<h4 class="no-margins text-center">
									Belum Terhitung
								</h3>
							</div>
						</div>
					</div>
				</div>
				<br>
				
				<h3>Detail Result By Row Data</h3>
				<div class="row">
					<div class="col-lg-3">
						<div class="widget navy-bg no-padding">
							<div class="p-m">
								<h1 class="text-center font-bold" id="sesuaiRows" style="font-size: 40px"></h1>
								<h3 class="no-margins font-bold text-center" id="p_sesuaiRows" style="font-size: 20px"></h3>
								<h4 class="no-margins text-center">
									Sesuai
								</h3>
							</div>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="widget yellow-bg no-padding">
							<div class="p-m">
								<h1 class="text-center font-bold" id="lebihRows" style="font-size: 40px"></h1>
								<h3 class="no-margins font-bold text-center" id="p_lebihRows" style="font-size: 20px"></h3>
								<h4 class="no-margins text-center">
									Selisih Lebih
								</h3>
							</div>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="widget red-bg no-padding">
							<div class="p-m">
								<h1 class="text-center font-bold" id="kurangRows" style="font-size: 40px"></h1>
								<h3 class="no-margins font-bold text-center" id="p_kurangRows" style="font-size: 20px"></h3>
								<h4 class="no-margins text-center">
									Selisih Kurang
								</h3>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="ibox ">
			<div class="ibox-content">
				<h3>Result By Item Data</h3>
				<div class="row">
					<div class="col-lg-3">
						<div class="widget no-padding">
							<div class="p-m">
								<h1 class="text-center font-bold" id="targetItem" style="font-size: 40px"></h1>
								<br>
								<h4 class="no-margins text-center">
									Target
								</h4>
							</div>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="widget no-padding">
							<div class="p-m">
								<h1 class="text-center font-bold" id="c_uploadItem" style="font-size: 40px"></h1>
								<br>
								<h4 class="no-margins text-center">
									Total Upload
								</h4>
							</div>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="widget navy-bg no-padding">
							<div class="p-m">
								<h1 class="text-center font-bold" id="terhitungItem" style="font-size: 40px"></h1>
								<h3 class="no-margins font-bold text-center" id="p_terhitungItem" style="font-size: 20px"></h3>
								<h4 class="no-margins text-center">
									Terhitung
								</h3>
							</div>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="widget red-bg no-padding">
							<div class="p-m">
								<h1 class="text-center font-bold" id="not_terhitungItem" style="font-size: 40px"></h1>
								<h3 class="no-margins font-bold text-center" id="p_not_terhitungItem" style="font-size: 20px"></h3>
								<h4 class="no-margins text-center">
									Belum Terhitung
								</h3>
							</div>
						</div>
					</div>
				</div>
				<br>
				
				<h3>Detail Result By Item Data</h3>
				<div class="row">
					<div class="col-lg-3">
						<div class="widget navy-bg no-padding">
							<div class="p-m">
								<h1 class="text-center font-bold" id="sesuaiItem" style="font-size: 40px"></h1>
								<h3 class="no-margins font-bold text-center" id="p_sesuaiItem" style="font-size: 20px"></h3>
								<h4 class="no-margins text-center">
									Sesuai
								</h3>
							</div>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="widget yellow-bg no-padding">
							<div class="p-m">
								<h1 class="text-center font-bold" id="lebihItem" style="font-size: 40px"></h1>
								<h3 class="no-margins font-bold text-center" id="p_lebihItem" style="font-size: 20px"></h3>
								<h4 class="no-margins text-center">
									Selisih Lebih
								</h3>
							</div>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="widget red-bg no-padding">
							<div class="p-m">
								<h1 class="text-center font-bold" id="kurangItem" style="font-size: 40px"></h1>
								<h3 class="no-margins font-bold text-center" id="p_kurangItem" style="font-size: 20px"></h3>
								<h4 class="no-margins text-center">
									Selisih Kurang
								</h3>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- BEGIN JS -->
<?php require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_load.php'; ?>
<?php require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_setup.php'; ?>
<?php require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_datatables_load.php'; ?>
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn.js"></script>

<!-- BEGIN datatables here -->
<script type="text/javascript">
		// ------------- default variable, do not erase
		var tblhtsprrd, show_inactive_status_htsprrd = 0;
		var edthtssctd, tblhtssctd, show_inactive_status_htssctd = 0, id_htssctd;
		var edthtsprtd, tblhtsprtd, show_inactive_status_htsprtd = 0, id_htsprtd;
		// ------------- end of default variable
		var notifyprogress = '';
		var id_htsxxmh_old = 0;
		var id_isoxxth_upload_filter = 0;
		
		$("#selectKode").select2({
			placeholder : "Select",
			allowClear: true,
			multiple: false,
			ajax: {
				url: "../../models/isoxxth_upload/isoxxth_upload_fn_opt.php",
				dataType: 'json',
				data: function (params) {
					var query = {
						id_isoxxth_upload_old: id_isoxxth_upload_filter,
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
			}
		});

		function generateTable(id_isoxxth_upload_filter) {

			$.ajax( {
				url: "../../models/core/dash_stock_opname.php",
				dataType: 'json',
				type: 'POST',
				data: {
					id_isoxxth_upload: id_isoxxth_upload_filter
				},
				success: function ( json ) {
					if (json.data && Object.keys(json.data).length > 0) {
						console.log('oke');

						$('#showing').show();

						//Data by Rows
						$('#targetRows').empty();
						$('#targetRows').html(json.data.c_target);

						$('#c_uploadRows').empty();
						$('#c_uploadRows').html(json.data.c_upload);
						
						$('#terhitungRows').empty();
						$('#terhitungRows').html(json.data.c_terhitung);
						
						$('#p_terhitungRows').empty();
						$('#p_terhitungRows').html(json.data.terhitung);
						
						$('#p_not_terhitungRows').empty();
						$('#p_not_terhitungRows').html(json.data.not_terhitung);
						
						$('#not_terhitungRows').empty();
						$('#not_terhitungRows').html(json.data.c_not_terhitung);
						
						$('#p_sesuaiRows').empty();
						$('#p_sesuaiRows').html(json.data.sesuai);
						
						$('#sesuaiRows').empty();
						$('#sesuaiRows').html(json.data.c_sesuai);
						
						$('#p_lebihRows').empty();
						$('#p_lebihRows').html(json.data.lebih);
						
						$('#lebihRows').empty();
						$('#lebihRows').html(json.data.c_lebih);
						
						$('#p_kurangRows').empty();
						$('#p_kurangRows').html(json.data.kurang);
						
						$('#kurangRows').empty();
						$('#kurangRows').html(json.data.c_kurang);
						

						//data2 by Item
						$('#targetItem').empty();
						$('#targetItem').html(json.data2.c_target);

						$('#c_uploadItem').empty();
						$('#c_uploadItem').html(json.data2.c_upload);
						
						$('#terhitungItem').empty();
						$('#terhitungItem').html(json.data2.c_terhitung);
						
						$('#p_terhitungItem').empty();
						$('#p_terhitungItem').html(json.data2.terhitung);
						
						$('#p_not_terhitungItem').empty();
						$('#p_not_terhitungItem').html(json.data2.not_terhitung);
						
						$('#not_terhitungItem').empty();
						$('#not_terhitungItem').html(json.data2.c_not_terhitung);
						
						$('#p_sesuaiItem').empty();
						$('#p_sesuaiItem').html(json.data2.sesuai);
						
						$('#sesuaiItem').empty();
						$('#sesuaiItem').html(json.data2.c_sesuai);
						
						$('#p_lebihItem').empty();
						$('#p_lebihItem').html(json.data2.lebih);
						
						$('#lebihItem').empty();
						$('#lebihItem').html(json.data2.c_lebih);
						
						$('#p_kurangItem').empty();
						$('#p_kurangItem').html(json.data2.kurang);
						
						$('#kurangItem').empty();
						$('#kurangItem').html(json.data2.c_kurang);
						
						//Result By Items

						// if(json.data.length > 0 && json.data[0].id_hemxxmh != null){
						// 	var str1 = '<table id="tblhtsprrd1" class="table table-striped table-bordered">';
							
						// 	if ($.fn.dataTable.isDataTable('#tblhtsprrd1')) {
						// 		$('#tblhtsprrd1').DataTable().clear();
						// 		$('#tblhtsprrd1').DataTable().destroy();
						// 		$('#tblhtsprrd1 tbody').empty();
						// 		$('#tblhtsprrd1 thead').empty();
						// 	}
						// 	str1 += '<thead>';
						// 		// BEGIN header baris 1
						// 		str1 += '<tr>';
						// 		if (json.data[0].cek == 0) {
						// 			str1 += '<th class="text-center" style="color: blue; vertical-align: middle;" colspan="2" rowspan="2" >Clock Finger</th>';
						// 		} else {
						// 			str1 += '<th class="text-center text-danger" colspan="2" rowspan="2" style="vertical-align: middle;">Clock Finger</th>';
						// 		}
								
						// 		var id_hemxxmh = json.data[0].id_hemxxmh;
						// 		var tanggal = json.data[0].tanggal;
						// 		var kondite = json.data[0].kondite;
						// 		var kode_spkl = json.data[0].kode_spkl;

						// 		str1 += '<th class="text-center" rowspan="3" style="vertical-align: middle;">Status IN</th>';
						// 		str1 += '<th class="text-center" rowspan="3" style="vertical-align: middle;" >Status OUT</th>';

						// 		var linkUrl = "../htlxxrh/htlxxrh.php?id_hemxxmh=" + id_hemxxmh + "&start_date=" + tanggal;
								
						// 		str1 += '<th class="text-center" rowspan="3" style="vertical-align: middle;">Kondite</th>';

						// 		str1 += '<th class="text-center" colspan="2" rowspan="1">SPKL</th>';
						// 		str1 += '</tr>';

						// 		var url = "../htoxxth/htoxxth.php?kode_hto=" + json.data[0].kode_spkl + "&start_date=" + tanggal;
								
						// 		if (kode_spkl == '-') {
						// 			str1 += '<tr>';
						// 			str1 += '<th class="text-center" colspan="2" rowspan="1">' + json.data[0].kode_spkl + '</th>';
						// 			str1 += '</tr>';
						// 		} else {
						// 			str1 += '<tr>';
						// 			str1 += '<th class="text-center" colspan="2" rowspan="1">';
						// 			str1 += '<a href="' + url + '" targetRows="_blank">' + json.data[0].kode_spkl + '</a>';
						// 			str1 += '</th>';
						// 			str1 += '</tr>';
						// 		}

						// 		str1 += '<tr>';
						// 		$.each(json.columns, function (k, colObj) {
						// 			// BEGIN render column name
						// 			if (colObj.name == 'clock_in') {
						// 				str1 += '<th class="text-center">IN</th>';
						// 			} else if (colObj.name == 'clock_out') {
						// 				str1 += '<th class="text-center">OUT</th>';
						// 			} else if (colObj.name == 'jam_awal') {
						// 				str1 += '<th class="text-center">Jam Awal</th>';
						// 			} else if (colObj.name == 'jam_akhir') {
						// 				str1 += '<th class="text-center">Jam Akhir</th>';
						// 			}
						// 		});
						// 		str1 += '</tr>';
						// 		// END header baris 1
						// 	str1 = str1 + '</thead>';

						// 	$('#tabel_atas').html(str1);

						// 	$('#tblhtsprrd1').DataTable({
						// 		paging: false,          // Disable pagination
						// 		searching: false,       // Disable search
						// 		info: false,            // Disable "Showing X of Y entries" information
						// 		lengthChange: false,    // Disable "Show X entries" dropdown
						// 		responsive: false,
						// 		fixedHeader: {
						// 			header: false,
						// 			// footer: true
						// 		},
						// 		data: json.data,
						// 		columns: json.columns,
						// 		buttons: buttons,
						// 		columnDefs: [
						// 			{
						// 				targets: [4],
						// 				render: function (data, type, row, meta) {
						// 					var id_hemxxmh = row.id_hemxxmh;
						// 					var tanggal = row.tanggal;
						// 					var kondite = row.kondite;

						// 					if (kondite !== '') {
						// 						var linkUrlKondite = "../htlxxrh/htlxxrh.php?id_hemxxmh=" + id_hemxxmh + "&start_date=" + tanggal;
						// 						return '<a href="' + linkUrlKondite + '" targetRows="_blank">' + kondite + '</a>';
						// 					} else {
						// 						return data;
						// 					}
						// 				},
						// 			},
						// 		],
						// 		rowCallback: function (row, data, index) {

						// 		}
						// 	});
						// } else {
						// 	$('#tabel_atas').html('<h1 style="color: red; text-align: center;"><b>REPORT PRESENSI BELUM DI GENERATE!!!<b></h1><br><br><br>');
						// }

						if(notifyprogress != ''){
							notifyprogress.close();
						}
					} else {
						$('#report').hide();
						$('#no_jadwal').show();
						if(notifyprogress != ''){
							notifyprogress.close();
						}
					}
				}
			} );
		}

		$(document).ready(function() {
			$('#prevButton').hide();
			$('#nextButton').hide();
			$('#report').hide();
			
			$("#frmisoittd_upload").submit(function(e) {
				e.preventDefault();
			}).validate({
				rules: {
					
				},
				submitHandler: function(frmisoittd_upload) {
					
					id_isoxxth_upload_filter  = $('#selectKode').val();
					selectedOption = $('#selectKode').select2('data')[0];
					if (selectedOption) {
						selectedText = selectedOption.text;
					}

					if (id_isoxxth_upload_filter > 0) {
						generateTable(id_isoxxth_upload_filter);
					}
				}
			});
		} );// end of document.ready
	
	</script>

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
