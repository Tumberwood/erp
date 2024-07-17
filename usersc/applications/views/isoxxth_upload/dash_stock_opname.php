<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'isoittd_upload';
	$nama_tabels_d = [];
	// tes webhook
?>

<!-- begin content here -->
<style>
    /* Default font size for desktop */
    .ukuran {
        font-size: 40px;
    }

    /* Media query for mobile devices */
    @media only screen and (max-width: 600px) {
        .ukuran {
            font-size: 20px;
        }
    }

    .ukuran_label {
        font-size: 15px;
    }

    /* Media query for mobile devices */
    @media only screen and (max-width: 600px) {
        .ukuran_label {
            font-size: 10px;
        }
    }

    .card_item {
        height: 100%;
    }
</style>

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
<hr>

<div class="row" id="showing" style="display: none">

	<!-- Mobile view -->
	<div class="d-md-none">
		<!-- Content visible only on mobile -->
		<ul class="nav nav-tabs">
			<li class="nav-item">
				<a class="nav-link active" href="#tab1" data-toggle="tab" onclick="showTabContent('#tab1')">Row Data</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#tab2" data-toggle="tab" onclick="showTabContent('#tab2')">Item Data</a>
			</li>
			<!-- Add more tabs as needed -->
		</ul>
		<div class="tab-content">
			<div class="tab-pane fade show active" id="tab1">
				<!-- Content for Tab 1 -->
			</div>
			<div class="tab-pane fade" id="tab2">
				<!-- Content for Tab 2 -->
			</div>
			<!-- Add more tab content as needed -->
		</div>
	</div>
	
	<div class="col-lg-6">
		<div id="kontenTab1">
			<br>
			<h3>Row Data</h3>
			<!-- <div class="ibox "> -->
				<div class="row m-r-n-xl">
					<div class="col-3 m-r-n-xl" id="tooltipRows">
						<div class="ibox-content card_item d-flex align-items-center justify-content-center" style="background-color: #bae1ff">
							<div class="row">
								<div class="col text-center">
									<h4 class="ukuran font-bold" id="targetRows"></h4>
									<!-- <h4 class="ukuran font-bold" id="">1695</h4> -->
									<h5 class="no-margins font-bold">
										Target
									</h5>
									<div id="progress_rows"></div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-5 m-l-sm">
						<div class="ibox-content">
							<h4>Upload</h4>
							<div class="row">
								<div class="col-6">
									<h4 class="ukuran text-center font-bold" id="c_uploadRows"></h4>
								</div>
								<div class="col-6">
								</div>
							</div>
						</div>
						
						
						<div class="ibox-content">
							<h4>Diluar Upload</h4>
							<div class="row">
								<div class="col-6">
									<h4 class="ukuran text-center font-bold" id="c_not_uploadRows"></h4>
								</div>
								<div class="col-6">
								</div>
							</div>
						</div>
					</div>
					<div class="col-4 m-l-n-lg">
						
						<div class="ibox-content m-r-n-lg">
							<h4>Terhitung</h4>
							<div class="row">
								<div class="col-6">
									<h4 class="ukuran text-center font-bold" id="terhitungRows"></h4>
								</div>
								<div class="col-6">
									<span class="label ukuran_label label-primary float-right" id="p_terhitungRows"></span>
								</div>
							</div>
						</div>
						
						
						<div class="ibox-content m-r-n-lg">
							<h4>Belum Terhitung</h4>
							<div class="row">
								<div class="col-6">
									<h4 class="ukuran text-center font-bold" id="not_terhitungRows"></h4>
								</div>
								<div class="col-6">
									<span class="label ukuran_label label-danger float-right" id="p_not_terhitungRows" ></span>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="row">
					<!-- <div class="col-6">
						<div class="ibox-content">
							<h4>Sesuai</h4>
							<div class="row">
								<div class="col-6">
									<h4 class="ukuran text-center font-bold" id="sesuaiRows"></h4>
								</div>
								<div class="col-6">
									<span class="label ukuran_label label-primary float-right" id="p_sesuaiRows"></span>
								</div>
							</div>
						</div>
					</div>
					<div class="col-6">
						
						<div class="ibox-content">
							<h4>Selisih Lebih</h4>
							<div class="row">
								<div class="col-6">
									<h4 class="ukuran text-center font-bold" id="lebihRows"></h4>
								</div>
								<div class="col-6">
									<span class="label ukuran_label label-warning float-right" id="p_lebihRows"></span>
								</div>
							</div>
						</div>
					</div> -->
						
					<div class="col-6">
						<div class="widget navy-bg">
							
								<h4 class="ukuran text-center font-bold" id="sesuaiRows"></h4>
								<h5 class="no-margins font-bold text-center" id="p_sesuaiRows" style="font-size: 20px"></h5>
								<h6 class="no-margins text-center font-bold">
									Sesuai
								</h6>
						</div>
					</div>
					<div class="col-6">
						<!-- <div class="widget yellow-bg m-l-n-lg"> -->
						<div class="widget yellow-bg m-l-n-md">
							
								<h4 class="ukuran text-center font-bold" id="lebihRows"></h4>
								<h5 class="no-margins font-bold text-center" id="p_lebihRows" style="font-size: 20px"></h5>
								<h6 class="no-margins text-center font-bold">
									Selisih Lebih
								</h6>
						</div>
					</div>
				</div>
				<div class="row m-t-n-sm">
				<!-- <div class="row m-t-n-md"> -->
					<div class="col-6">
						<div class="widget red-bg">
							
								<h4 class="ukuran text-center font-bold" id="kurangRows"></h4>
								<h5 class="no-margins font-bold text-center" id="p_kurangRows" style="font-size: 20px"></h5>
								<h6 class="no-margins text-center font-bold">
									Selisih Kurang
								</h6>
						</div>
					</div>
					<div class="col-6">
						<!-- <div class="widget gray-bg m-l-n-lg"> -->
						<div class="widget gray-bg m-l-n-md">
							
								<h4 class="ukuran text-center font-bold" id="skipRows"></h4>
								<h5 class="no-margins font-bold text-center" id="p_skipRows" style="font-size: 20px"></h5>
								<h6 class="no-margins text-center font-bold">
									Data Skip
								</h6>
						</div>
					</div>
				</div>
			<!-- </div> -->
		</div>
	</div>
	<div class="col-lg-6">
		<div id="kontenTab2">
			<br>
			<h3>Item Data</h3>
			<!-- <div class="ibox "> -->
				<div class="row m-r-n-xl">
					<div class="col-4 m-r-n-xl" id="tooltipItem" data-toggle="tooltip">
						<div class="ibox-content card_item d-flex align-items-center justify-content-center" style=" background-color: #B5C0D0">
							<div class="row">
								<div class="col text-center">
									<h4 class="ukuran font-bold" id="targetItem"></h4>
									<!-- <h4 class="ukuran font-bold" id="">1695</h4> -->
									<h5 class="no-margins font-bold">
										Target
									</h5>
									<div id="progress_rows"></div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-4 m-r-n-xl" id="tooltipItem" data-toggle="tooltip">
						<div class="ibox-content card_item bg-muted d-flex align-items-center justify-content-center" >
							<div class="row">
								<div class="col text-center">
									<h4 class="ukuran font-bold" id="c_uploadItem"></h4>
									<!-- <h4 class="ukuran font-bold" id="">1695</h4> -->
									<h5 class="no-margins font-bold">
										Total Upload
									</h5>
								</div>
							</div>
						</div>
					</div>
					<div class="col-4">
						<div class="row">
							<div class="col-12">
								<div class="ibox-content m-r-n-xl">
									<h4>Terhitung</h4>
									<div class="row">
										<div class="col-6">
											<h4 class="ukuran text-center font-bold" id="terhitungItem"></h4>
										</div>
										<div class="col-6">
											<span class="label ukuran_label label-primary float-right" id="p_terhitungItem"></span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-12">
								<div class="ibox-content m-r-n-xl">
									<h4>Belum Terhitung</h4>
									<div class="row">
										<div class="col-6">
											<h4 class="ukuran text-center font-bold" id="not_terhitungItem"></h4>
										</div>
										<div class="col-6">
											<span class="label ukuran_label label-danger float-right" id="p_not_terhitungItem" ></span>
										</div>
									</div>
								</div>
							</div>
						</div>
						
					</div>
						
						
				</div>
				
				<div class="row">
					<div class="col-4">
						<div class="widget navy-bg">
							
								<h4 class="ukuran text-center font-bold" id="sesuaiItem"></h4>
								<h5 class="no-margins font-bold text-center" id="p_sesuaiItem" style="font-size: 20px"></h5>
								<h6 class="no-margins text-center font-bold">
									Sesuai
								</h6>
						</div>
					</div>
					<div class="col-4">
						<!-- <div class="widget yellow-bg m-l-n-lg"> -->
						<div class="widget red-bg m-l-n-md">
							
								<h4 class="ukuran text-center font-bold" id="kurangItem"></h4>
								<h5 class="no-margins font-bold text-center" id="p_kurangItem" style="font-size: 20px"></h5>
								<h6 class="no-margins text-center font-bold">
									Selisih Kurang
								</h6>
						</div>
					</div>
					<div class="col-4">
						<div class="widget yellow-bg m-l-n-md m-r-sm">
							
								<h4 class="ukuran text-center font-bold" id="lebihItem"></h4>
								<h5 class="no-margins font-bold text-center" id="p_lebihItem" style="font-size: 20px"></h5>
								<h6 class="no-margins text-center font-bold">
									Selisih Lebih
								</h6>
						</div>
					</div>
				</div>
			<!-- </div> -->

			<!-- <div class="ibox ">
				<div class="ibox-content">
					<h5>Item Data</h5>
					<div class="row">
						<div class="col-lg-3">
							<div class="widget no-padding gray-bg ">
								<div class="p-m">
									<h4 class="ukuran text-center font-bold" id="targetItem"></h4>
									<br>
									<h6 class="no-margins text-center font-bold">
										Target
									</h6>
									<div id="progress_item"></div>
								</div>
							</div>
						</div>
						<div class="col-lg-3">
							<div class="widget no-padding gray-bg ">
								<div class="p-m">
									<h4 class="ukuran text-center font-bold" id="c_uploadItem"></h4>
									<br>
									<h6 class="no-margins text-center font-bold">
										Total Upload
									</h6>
								</div>
							</div>
						</div>
						<div class="col-lg-3">
							<div class="widget navy-bg no-padding">
								<div class="p-m">
									<h4 class="ukuran text-center font-bold" id="terhitungItem"></h4>
									<h5 class="no-margins font-bold text-center" id="p_terhitungItem" style="font-size: 20px"></h5>
									<h6 class="no-margins text-center font-bold">
										Terhitung
									</h5>
								</div>
							</div>
						</div>
						<div class="col-lg-3">
							<div class="widget red-bg no-padding">
								<div class="p-m">
									<h4 class="ukuran text-center font-bold" id="not_terhitungItem"></h4>
									<h5 class="no-margins font-bold text-center" id="p_not_terhitungItem" style="font-size: 20px"></h5>
									<h6 class="no-margins text-center font-bold">
										Belum Terhitung
									</h5>
								</div>
							</div>
						</div>
					</div>
					<br>
					
					<h5>Detail Item Data</h5>
					<div class="row">
						<div class="col-lg-3">
							<div class="widget navy-bg no-padding">
								<div class="p-m">
									<h4 class="ukuran text-center font-bold" id="sesuaiItem"></h4>
									<h5 class="no-margins font-bold text-center" id="p_sesuaiItem" style="font-size: 20px"></h5>
									<h6 class="no-margins text-center font-bold">
										Sesuai
										</h5>
								</div>
							</div>
						</div>
						<div class="col-lg-3">
							<div class="widget yellow-bg no-padding">
								<div class="p-m">
									<h4 class="ukuran text-center font-bold" id="lebihItem"></h4>
									<h5 class="no-margins font-bold text-center" id="p_lebihItem" style="font-size: 20px"></h5>
									<h6 class="no-margins text-center font-bold">
										Selisih Lebih
									</h5>
								</div>
							</div>
						</div>
						<div class="col-lg-3">
							<div class="widget red-bg no-padding">
								<div class="p-m">
									<h4 class="ukuran text-center font-bold" id="kurangItem"></h4>
									<h5 class="no-margins font-bold text-center" id="p_kurangItem" style="font-size: 20px"></h5>
									<h6 class="no-margins text-center font-bold">
										Selisih Kurang
									</h5>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div> -->
		</div>
	</div>
	
	<div class="col">
		<div class="ibox" id="tabel_item">
			<div class="ibox-content">
				<div class="row">
					<!-- <div class="col-md-6"> -->
					<div class="col-md-6 col-12">
						<h5>Log By User</h5>
							<div class="table-responsive">
								<table id="tblisoittd_upload" class="table table-striped table-bordered table-hover nowrap" width="100%">
									<thead>
										<tr>
											<th>Item Code</th>
											<th>Item Name</th>
											<th>Sistem</th>
											<th>Fisik</th>
											<th>Selisih</th>
										</tr>

									</thead>
								</table>
							</div>
						<!-- <div id="tabel_kiri"></div> -->
					</div>
					<!-- <div class="col-md-6"> -->
					<div class="col-md-6 col-12">
						<h5>Bottom 10 Items</h5>
							<div class="table-responsive">
								<table id="tblisoittd_upload_log" class="table table-striped table-bordered table-hover nowrap" width="100%">
									<thead>
										<tr>
											<th class="text-center" rowspan="2" style="vertical-align: middle">User</th>
											<th class="text-center" colspan="2">Count</th>
											<th class="text-center" rowspan="2" style="vertical-align: middle">Lokasi</th>
											<th class="text-center" rowspan="2" style="vertical-align: middle">Total Time</th>
										</tr>
										<tr>
											<th class="text-center">Upload</th>
											<th class="text-center">New</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th >User</th>
											<th id="total_1"></th>
											<th id="total_2"></th>
											<th></th>
											<th></th>
										</tr>
									</tfoot>
								</table>
							</div>
						
						<!-- <div id="tabel_atas"></div> -->
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
<script src="<?=$us_url_root?>usersc/helpers/general_fn.js"></script>

<!-- BEGIN datatables here -->
<script type="text/javascript">
		// ------------- default variable, do not erase
		var edtisoittd_upload, tblisoittd_upload, show_deleted_isoittd_upload = 0, id_isoittd_upload;
		var tblisoittd_upload_log;
		// ------------- end of default variable
		var notifyprogress = '';
		var id_htsxxmh_old = 0;
		var id_isoxxth_upload_filter = 0;
		
		// get tableRelation
		tableRelation('isoittd_upload');

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

		function generateCard(id_isoxxth_upload_filter) {

			$.ajax( {
				url: "../../models/isoxxth_upload/dash_stock_opname.php",
				dataType: 'json',
				type: 'POST',
				data: {
					id_isoxxth_upload: id_isoxxth_upload_filter
				},
				success: function ( json ) {
					if (json.data && Object.keys(json.data).length > 0) {
						$('#showing').show();

						//Data by Rows
						$('#targetRows').empty();
						$('#targetRows').html(json.data.c_target);

						$('#c_uploadRows').empty();
						$('#c_uploadRows').html(json.data.c_upload);

						$('#c_not_uploadRows').empty();
						$('#c_not_uploadRows').html(json.data.c_not_upload);
						
						$('#terhitungRows').empty();
						$('#terhitungRows').html(json.data.c_terhitung);
						
						$('#p_terhitungRows').empty();
						persen_terhitung_rows = json.data.terhitung;
						$('#p_terhitungRows').html(persen_terhitung_rows);
						
						persen_terhitung_rows_int = parseInt(persen_terhitung_rows);
						
						if(persen_terhitung_rows_int <= 30){
							progressClassrows = 'progress-bar-danger';
						}else if(persen_terhitung_rows_int <= 60){
							progressClassrows = 'progress-bar-warning';
						}else if(persen_terhitung_rows_int < 100){
							progressClassrows = 'progress-bar-success';
						}else{
							progressClassrows = 'progress-bar';
						}
						$('#progress_rows').html(
							'<div class="progress progress-mini '+progressClassrows+'" style="width: '+persen_terhitung_rows+'" role="progressbar" aria-valuenow="'+persen_terhitung_rows+'" aria-valuemin="0" aria-valuemax="100"></div>'
						);

						var tooltipRows = document.getElementById('tooltipRows');

						var titleText = 'Total Data by Rows = ' + json.data.c_target +
										'<br> Terhitung = ' + json.data.c_terhitung +
										'<br> Progress = ' + persen_terhitung_rows;

						tooltipRows.setAttribute('title', titleText);
						
						$(tooltipRows).tooltip({
							content: titleText,
							html: true,
							placement: 'top'
						});
						
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
						
						$('#p_skipRows').empty();
						$('#p_skipRows').html(json.data.skip);
						
						$('#skipRows').empty();
						$('#skipRows').html(json.data.c_skip);
						

						//data2 by Item
						$('#targetItem').empty();
						$('#targetItem').html(json.data2.c_target);

						$('#c_uploadItem').empty();
						$('#c_uploadItem').html(json.data2.c_upload);
						
						$('#terhitungItem').empty();
						$('#terhitungItem').html(json.data2.c_terhitung);
						
						$('#p_terhitungItem').empty();
						persen_terhitung_item = json.data2.terhitung;
						$('#p_terhitungItem').html(persen_terhitung_item);

						persen_terhitung_item_int = parseInt(persen_terhitung_item);
						
						if(persen_terhitung_item_int <= 30){
							progressClassItem = 'progress-bar-danger';
						}else if(persen_terhitung_item_int <= 60){
							progressClassItem = 'progress-bar-warning';
						}else if(persen_terhitung_item_int < 100){
							progressClassItem = 'progress-bar-success';
						}else{
							progressClassItem = 'progress-bar';
						}
						$('#progress_item').html(
							'<div class="progress progress-mini '+progressClassItem+'" style="width: '+persen_terhitung_item+'" role="progressbar" aria-valuenow="'+persen_terhitung_item+'" aria-valuemin="0" aria-valuemax="100"></div>'
						);
						
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
						
						//disini

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
		
		function showTabContent(tabId) {
			var tab1Content = document.getElementById('kontenTab1');
			var tab2Content = document.getElementById('kontenTab2');
			
			if ($(window).width() < 768) { // Mobile view
				// Hide tab 2 content when tab 1 is clicked
				if (tabId === '#tab1') {
					tab1Content.style.display = 'block';
					tab2Content.style.display = 'none';
				}
				// Hide tab 1 content when tab 2 is clicked
				else if (tabId === '#tab2') {
					tab2Content.style.display = 'block';
					tab1Content.style.display = 'none';
				}
			} else { // Desktop view
				// Show both tab 1 and tab 2 content
				tab1Content.style.display = 'block';
				tab2Content.style.display = 'block';
			}
		}

		$(document).ready(function() {
			showTabContent('#tab1');

			$(window).resize(function() {
				showTabContent($('.nav-link.active').attr('href')); // Display content based on the active tab
			});
			//function autoreload data based on interval ms di ggsxxsh
			autoReloadInterval(function () {
				var scrollPosition = window.pageYOffset || document.documentElement.scrollTop;
				// console.log(scrollPosition);
 	    		//tambahkan function reload tabel atau function generate card
				generateCard(id_isoxxth_upload_filter);
				// Reload the tables and scroll to position afterward
				tblisoittd_upload.ajax.reload(function() {
					scrollToPosition(scrollPosition);
				}, false);

				tblisoittd_upload_log.ajax.reload(function() {
					scrollToPosition(scrollPosition);
				}, false);
				// console.log('reloaded');
			});

			//Table Selisih
			tblisoittd_upload = $('#tblisoittd_upload').DataTable( {
				dom: dom0,
				ajax: {
					url: "../../models/isoxxth_upload/dash_stock_opname.php",
					type: 'POST',
					data: function (d){
						d.id_isoxxth_upload = id_isoxxth_upload_filter;
					},
					dataSrc: 'data3'
				},
				order: [[ 4, "asc" ]],
				responsive: false,
				scrollX: true,
				columns: [
					{ data: "kode" },
					{ data: "nama" },
					{ 
						data: "s_jumlah_terkecil",
						...renderNumber() 
					},
					{ 
						data: "s_fisik",
						...renderNumber() 
					},
					{ 
						data: "s_selisih",
						...renderNumber() 
					},
				],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_isoittd_upload';
						$table       = 'tblisoittd_upload';
						$edt         = 'edtisoittd_upload';
						$show_status = '_isoittd_upload';
						$table_name  = $nama_tabel;

						$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
						// $arr_buttons_tools2 	= ['sf', 'sp', 'sb'];
						$arr_buttons_tools2 	= [];
						$arr_buttons_action 	= [];
						include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
					?>
					// END breaking generate button
				],
				rowCallback: function( row, data, index ) {
					
				}
			} );

			tblisoittd_upload.on( 'init', function () {
				// atur hak akses
				CekInitHeaderH(tblisoittd_upload);
			} );
			
			tblisoittd_upload.on( 'select', function( e, dt, type, indexes ) {
				// atur hak akses
				CekSelectHeaderH(tblisoittd_upload);
			} );

			tblisoittd_upload.on( 'deselect', function () {
				// atur hak akses
				CekDeselectHeaderH(tblisoittd_upload);
			} );
			
			//Tabel Log by User
			tblisoittd_upload_log = $('#tblisoittd_upload_log').DataTable( {
				dom: dom0,
				ajax: {
					url: "../../models/isoxxth_upload/dash_stock_opname.php",
					type: 'POST',
					data: function (d){
						d.id_isoxxth_upload = id_isoxxth_upload_filter;
					},
					dataSrc: 'data4'
				},
				order: [[ 4, "asc" ]],
				responsive: false,
				scrollX: true,
				columns: [
					{ data: "nama" },
					{ 
						data: "c_upload",
						...renderNumber() 
					},
					{ 
						data: "c_new",
						...renderNumber() 
					},
					{ 
						data: "lokasi",
						...renderNumber() 
					},
					{ data: "total_time" },
				],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_isoittd_upload';
						$table       = 'tblisoittd_upload_log';
						$edt         = 'edtisoittd_upload';
						$show_status = '_isoittd_upload';
						$table_name  = $nama_tabel;

						$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
						// $arr_buttons_tools2 	= ['sf', 'sp', 'sb'];
						$arr_buttons_tools2 	= [];
						$arr_buttons_action 	= [];
						include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
					?>
					// END breaking generate button
				],
				rowCallback: function( row, data, index ) {
					
				},
				footerCallback: function ( row, data, start, end, display ) {
					var api = this.api();
					var numFormat = $.fn.dataTable.render.number( '\,', '.', 0, '' ).display; 

					for (var i = 1; i <= 2; i++) {
						var columnIndex = i;
						var sum_all = api.column(columnIndex).data().sum();
						// Bisa dilakukan sum berdasarkan paginasi (sum per paginasi / tidak sum semua data) dengan menambahkan { page: 'current' }
						var sum = api.column(columnIndex, { page: 'current' }).data().sum();
						$('#total_' + columnIndex).html(numFormat(sum_all));

						// console.log('Number of Pages: ' + api.page.info().pages);
					}
				}
			} );

			tblisoittd_upload_log.on( 'init', function () {
				// atur hak akses
				CekInitHeaderH(tblisoittd_upload_log);
			} );
			
			tblisoittd_upload_log.on( 'select', function( e, dt, type, indexes ) {
				// atur hak akses
				CekSelectHeaderH(tblisoittd_upload_log);
			} );

			tblisoittd_upload_log.on( 'deselect', function () {
				// atur hak akses
				CekDeselectHeaderH(tblisoittd_upload_log);
			} );

			$("#frmFilter").submit(function(e) {
				e.preventDefault();
			}).validate({
				rules: {
					
				},
				submitHandler: function(frmFilter) {
					
					id_isoxxth_upload_filter  = $('#selectKode').val();
					selectedOption = $('#selectKode').select2('data')[0];
					if (selectedOption) {
						selectedText = selectedOption.text;
					}

					if (id_isoxxth_upload_filter > 0) {
						generateCard(id_isoxxth_upload_filter);
						tblisoittd_upload.ajax.reload(null, false);
						tblisoittd_upload_log.ajax.reload(null, false);
						var ibox = $('#iboxfilter');
        				ibox.find('.collapse-link').click();
					}
				}
			});
		} );// end of document.ready
	
	</script>

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
