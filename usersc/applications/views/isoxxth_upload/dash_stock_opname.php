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
				
				<br>
            </div>
        </div>
    </div>
</div>

<div class="row" id="showing" style="display: none">
	<div class="col-lg-6">
		<div class="ibox ">
			<div class="ibox-content">
				<h5>Row Data</h5>
				<div class="row">
					<div class="col-lg-3">
						<div class="widget no-padding gray-bg ">
							<div class="p-m">
								<h4 class="text-center font-bold" id="targetRows" style="font-size: 40px"></h4>
								<br>
								<h6 class="no-margins text-center font-bold">
									Target
								</h6>
							</div>
						</div>
					</div>
					<div class="col-lg-3">
						<div id="uploadCarousel" class="carousel slide" data-ride="carousel">
							<div class="carousel-inner">
								<div class="carousel-item active">
									<div class="widget no-padding gray-bg">
										<div class="p-m">
											<div class="row">
												<div class="col-12">
													<h4 class="text-center font-bold" id="c_uploadRows" style="font-size: 40px"></h4>
													<br>
													<h6 class="no-margins text-center font-bold">Upload</h6>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="carousel-item">
									<div class="widget no-padding gray-bg">
										<div class="p-m">
											<div class="row">
												<div class="col-12">
													<h4 class="text-center font-bold" id="c_not_uploadRows" style="font-size: 40px"></h4>
													<br>
													<h6 class="no-margins text-center font-bold">Diluar Upload</h6>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<a class="carousel-control-prev" href="#uploadCarousel" role="button" data-slide="prev">
								<span class="carousel-control-prev-icon" aria-hidden="true"></span>
								<span class="sr-only">Previous</span>
							</a>
							<a class="carousel-control-next" href="#uploadCarousel" role="button" data-slide="next">
								<span class="carousel-control-next-icon" aria-hidden="true"></span>
								<span class="sr-only">Next</span>
							</a>
						</div>
					</div>

					<div class="col-lg-3">
						<div class="widget navy-bg no-padding">
							<div class="p-m">
								<h4 class="text-center font-bold" id="terhitungRows" style="font-size: 40px"></h4>
								<h5 class="no-margins font-bold text-center" id="p_terhitungRows" style="font-size: 20px"></h5>
								<h6 class="no-margins text-center font-bold">
									Terhitung
								</h5>
							</div>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="widget red-bg no-padding">
							<div class="p-m">
								<h4 class="text-center font-bold" id="not_terhitungRows" style="font-size: 40px"></h4>
								<h5 class="no-margins font-bold text-center" id="p_not_terhitungRows" style="font-size: 20px"></h5>
								<h6 class="no-margins text-center font-bold">
									Belum Terhitung
								</h5>
							</div>
						</div>
					</div>
				</div>
				<br>
				
				<h5>Detail Row Data</h5>
				<div class="row">
					<div class="col-lg-3">
						<div class="widget navy-bg no-padding">
							<div class="p-m">
								<h4 class="text-center font-bold" id="sesuaiRows" style="font-size: 40px"></h4>
								<h5 class="no-margins font-bold text-center" id="p_sesuaiRows" style="font-size: 20px"></h5>
								<h6 class="no-margins text-center font-bold">
									Sesuai
								</h5>
							</div>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="widget yellow-bg no-padding">
							<div class="p-m">
								<h4 class="text-center font-bold" id="lebihRows" style="font-size: 40px"></h4>
								<h5 class="no-margins font-bold text-center" id="p_lebihRows" style="font-size: 20px"></h5>
								<h6 class="no-margins text-center font-bold">
									Selisih Lebih
								</h5>
							</div>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="widget red-bg no-padding">
							<div class="p-m">
								<h4 class="text-center font-bold" id="kurangRows" style="font-size: 40px"></h4>
								<h5 class="no-margins font-bold text-center" id="p_kurangRows" style="font-size: 20px"></h5>
								<h6 class="no-margins text-center font-bold">
									Selisih Kurang
								</h5>
							</div>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="widget gray-bg no-padding">
							<div class="p-m">
								<h4 class="text-center font-bold" id="skipRows" style="font-size: 40px"></h4>
								<h5 class="no-margins font-bold text-center" id="p_skipRows" style="font-size: 20px"></h5>
								<h6 class="no-margins text-center font-bold">
									Data Skip
								</h5>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-6">
		<div class="ibox ">
			<div class="ibox-content">
				<h5>Item Data</h5>
				<div class="row">
					<div class="col-lg-3">
						<div class="widget no-padding gray-bg ">
							<div class="p-m">
								<h4 class="text-center font-bold" id="targetItem" style="font-size: 40px"></h4>
								<br>
								<h6 class="no-margins text-center font-bold">
									Target
								</h6>
							</div>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="widget no-padding gray-bg ">
							<div class="p-m">
								<h4 class="text-center font-bold" id="c_uploadItem" style="font-size: 40px"></h4>
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
								<h4 class="text-center font-bold" id="terhitungItem" style="font-size: 40px"></h4>
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
								<h4 class="text-center font-bold" id="not_terhitungItem" style="font-size: 40px"></h4>
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
								<h4 class="text-center font-bold" id="sesuaiItem" style="font-size: 40px"></h4>
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
								<h4 class="text-center font-bold" id="lebihItem" style="font-size: 40px"></h4>
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
								<h4 class="text-center font-bold" id="kurangItem" style="font-size: 40px"></h4>
								<h5 class="no-margins font-bold text-center" id="p_kurangItem" style="font-size: 20px"></h5>
								<h6 class="no-margins text-center font-bold">
									Selisih Kurang
								</h5>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col">
		<div class="ibox" id="tabel_item">
			<div class="ibox-content">
				<div class="row">
					<div class="col-md-6">
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
					<div class="col-md-6">
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

		$(document).ready(function() {

			//function autoreload data based on interval ms di ggsxxsh
			autoReloadInterval(function () {
 	    		//tambahkan function reload tabel atau function generate card
				generateCard();							
				tblisoittd_upload.ajax.reload(null, false);
				tblisoittd_upload_log.ajax.reload(null, false);
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
						generateCard(id_isoxxth_upload_filter);
						tblisoittd_upload.ajax.reload(null, false);
						tblisoittd_upload_log.ajax.reload(null, false);
					}
				}
			});
		} );// end of document.ready
	
	</script>

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
