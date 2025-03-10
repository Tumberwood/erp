<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'prcxxth_npo';
	$nama_tabels_d = [];
	$nama_tabels_d[0] = 'sdlxxth_nso';
?>
<style>
    /* Default font size for desktop */
    .ukuran {
        font-size: 50px;
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
</style>

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
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
					<button class="btn btn-primary" type="submit">Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- 
<div class="row" id="fltr">
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
								<div class="input-group-addon">
									<span class="fa fa-calendar"></span>
								</div>
								<input type="text" id="end_date" class="form-control">
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
<hr> -->

<div class="row" id="showing" style="display:none">
	<div class="col">
		<div class="ibox-content">
			<!-- begin content here -->
			<div class="row" id="card">
				<div class="col-xl-5 col-lg-5">
					<h3 class="text-center">Inbound</h3>
					<div class="row">
						<div class="col-6">
							<div class="widget yellow-bg">
								
									<h1 class="ukuran text-center font-bold" id="ts_in"></h1>
									<h5 class="no-margins text-center font-bold">
										Transaction
									</h5>
							</div>
						</div>
						<div class="col-6">
							<!-- <div class="widget yellow-bg m-l-n-lg"> -->
							<div class="widget yellow-bg m-l-n-md">
								
									<h1 class="ukuran text-center font-bold" id="item_in"></h1>
									<h5 class="no-margins text-center font-bold">
										Item
									</h5>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-5 col-lg-5">
					<h3 class="text-center">Outbound</h3>
					<div class="row">
						<div class="col-6">
							<div class="widget navy-bg">
								
									<h1 class="ukuran text-center font-bold" id="ts_out"></h1>
									<h5 class="no-margins text-center font-bold">
										Transaction
									</h5>
							</div>
						</div>
						<div class="col-6">
							<!-- <div class="widget navy-bg m-l-n-lg"> -->
							<div class="widget navy-bg m-l-n-md">
								
									<h1 class="ukuran text-center font-bold" id="item_out"></h1>
									<h5 class="no-margins text-center font-bold">
										Item
									</h5>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-2 col-lg-2">
					<h3 class="text-center">Average Inventory</h3>
					<div class="row">
						<div class="col-12">
							<div class="widget bg-info">
								<h1 class="ukuran text-center font-bold" id="avg_jumlah"></h1>
								<h5 class="no-margins text-center font-bold">
									Unit
								</h5>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-lg-6 col-sm-12">
					<div class="ibox">
						<div class="ibox-content">
							<div class="table-responsive">
								<h3>Top 10 Items Inbound</h3>
								<table id="tblprcxxth_npo" class="table table-striped table-bordered table-hover nowrap" width="100%">
									<thead>
										<tr>
											<th>ID</th>
											<th>Item Code</th>
											<th>Item Name</th>
											<th>UoM</th>
											<th>Quantity</th>
										</tr>
			
									</thead>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-6 col-sm-12">
					<div class="ibox">
						<div class="ibox-content">
							<div class="table-responsive">
								<h3>Top 10 Items Outbound</h3>
								<table id="tblsdlxxth_nso" class="table table-striped table-bordered table-hover nowrap" width="100%">
									<thead>
										<tr>
											<th>ID</th>
											<th>Item Code</th>
											<th>Item Name</th>
											<th>UoM</th>
											<th>Quantity</th>
										</tr>
			
									</thead>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_modal_log.php';
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_modal_dt_fs.php';
?>

<!-- BEGIN JS -->
<?php 
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_load.php';
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_setup.php';
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_datatables_load.php'; 
?>

<script src="<?=$us_url_root?>usersc/helpers/general_fn.js"></script>
<script src="<?=$us_url_root?>usersc/helpers/validation_fn.js"></script>
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn2.js"></script>
<script src="<?=$us_url_root?>usersc/helpers/language.js"></script>
<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/dash_si_gudang/fn/dash_si_gudang_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtprcxxth_npo, tblprcxxth_npo, show_deleted_prcxxth_npo = 0, id_prcxxth_npo;
	var edtsdlxxth_nso, tblsdlxxth_nso, show_deleted_sdlxxth_nso = 0, id_sdlxxth_nso;
	// ------------- end of default variable
	
	// get tableRelation
	tableRelation('prcxxth_npo');

	//Aktivasi Filter Floating
	filterFloating();

	$(document).ready(function() {

		//function autoreload data based on interval ms di ggsxxsh
		// autoReloadInterval(function () {
		// 	//tambahkan function reload tabel atau function generate card
		// 	loadDashboardSiGudang();							
		// 	tblprcxxth_npo.ajax.reload(null, false);
		// 	// console.log('reloaded');
		// });

		start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');	

		loadDashboardSiGudang();

		tblprcxxth_npo = $('#tblprcxxth_npo').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/dash_si_gudang/dash_si_gudang.php",
				type: 'POST',
				data: function (d){
					d.start_date = start_date;
					d.end_date = end_date;
				},
				dataSrc: function (json) {
					return json.data2;
				}
			},
			order: [[ 4, "desc" ]],
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
					targets: '_all'
				}
			],
			columns: [
				{ data: "id",visible:false },
				{ data: "iimxxmh_kode" },
				{ data: "iimxxmh_nama" },
				{ data: "iumxxmh_kode" },
				{ 
					data: "jumlah_unit",
					...renderNumber()
				},
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_prcxxth_npo';
					$table       = 'tblprcxxth_npo';
					$edt         = 'edtprcxxth_npo';
					$show_status = '_prcxxth_npo';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= ['sp', 'sb'];
					$arr_buttons_action 	= [];
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

		tblprcxxth_npo.searchPanes.container().appendTo('#spprcxxth_npo');
		tblprcxxth_npo.searchBuilder.container().appendTo( '#sbprcxxth_npo' );

		tblsdlxxth_nso = $('#tblsdlxxth_nso').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/dash_si_gudang/dash_si_gudang.php",
				type: 'POST',
				data: function (d){
					d.start_date = start_date;
					d.end_date = end_date;
				},
				dataSrc: function (json) {
					return json.data3;
				}
			},
			order: [[ 4, "desc" ]],
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
					targets: '_all'
				}
			],
			columns: [
				{ data: "id",visible:false },
				{ data: "iimxxmh_kode" },
				{ data: "iimxxmh_nama" },
				{ data: "iumxxmh_kode" },
				{ 
					data: "jumlah_unit",
					...renderNumber()
				},
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_sdlxxth_nso';
					$table       = 'tblsdlxxth_nso';
					$edt         = 'edtsdlxxth_nso';
					$show_status = '_sdlxxth_nso';
					$table_name  = $nama_tabels_d[0];

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= ['sp', 'sb'];
					$arr_buttons_action 	= [];
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

		tblsdlxxth_nso.searchPanes.container().appendTo('#spsdlxxth_nso');
		tblsdlxxth_nso.searchBuilder.container().appendTo( '#sbsdlxxth_nso' );

		// END prcxxth_npo
		
		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
				
			},
			submitHandler: function(frmFilter) {
				start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
				loadDashboardSiGudang();
				tblprcxxth_npo.ajax.reload(null, false);
				tblsdlxxth_nso.ajax.reload(null, false);
				
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				// var ibox = $('#iboxfilter');
				// ibox.find('.collapse-link').click();
				
				$('#modalFloatingFilter').modal('toggle');
			}
		});
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
