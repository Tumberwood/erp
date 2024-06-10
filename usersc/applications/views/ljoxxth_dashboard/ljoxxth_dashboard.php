<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'ljoxxth';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 col-6">
		<div class="widget style1">
			<div class="row">
				<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
					<i class="fa fa-truck fa-5x text-danger"></i>
				</div>
				<div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12">
					<span> Unloading </span>
					<h2 class="font-bold" id="c_unloading"></h2>
					<div class="progress progress-small">
						<div id="p_unloading_done" style="width: 0%;" class="progress-bar progress-bar-warning"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 col-6">
		<div class="widget style1">
			<div class="row">
				<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-6">
					<i class="fa fa-truck fa-flip-horizontal fa-5x text-navy"></i>
				</div>
				<div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12">
					<span> Loading </span>
					<h2 class="font-bold" id="c_loading"></h2>
					<div class="progress progress-small">
						<div id="p_loading_done" style="width: 0%;" class="progress-bar progress-bar-warning"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xl-8 col-lg-8 col-md-12 col-sm-12">
		<div class="row">
			<div class="col-xl-2 col-lg-2 col-md-3 col-sm-6 col-6">
				<div class="ibox">
					<div class="ibox-content bg-danger">
						<h5 class="m-b-md">Booking</h5>
						<h2 class="font-bold" id="c_booking"></h2>
						<small></small>
					</div>
				</div>
			</div>
			<div class="col-xl-2 col-lg-2 col-md-3 col-sm-6 col-6">
				<div class="ibox">
					<div class="ibox-content bg-warning">
						<h5 class="m-b-md">Arrival</h5>
						<h2 class="font-bold" id="c_arrival"></h2>
						<small></small>
					</div>
				</div>
			</div>
			<div class="col-xl-2 col-lg-2 col-md-3 col-sm-6 col-6">
				<div class="ibox">
					<div class="ibox-content bg-warning">
						<h5 class="m-b-md">Process</h5>
						<h2 class="font-bold" id="c_process"></h2>
						<small></small>
					</div>
				</div>
			</div>
			<div class="col-xl-2 col-lg-2 col-md-3 col-sm-6 col-6">
				<div class="ibox">
					<div class="ibox-content bg-warning">
						<h5 class="m-b-md">Document</h5>
						<h2 class="font-bold" id="c_document"></h2>
						<small></small>
					</div>
				</div>
			</div>
			<div class="col-xl-2 col-lg-2 col-md-3 col-sm-6 col-6">
				<div class="ibox">
					<div class="ibox-content bg-warning">
						<h5 class="m-b-md">Clearance</h5>
						<h2 class="font-bold" id="c_clearance"></h2>
						<small></small>
					</div>
				</div>
			</div>
			<div class="col-xl-2 col-lg-2 col-md-3 col-sm-6 col-6">
				<div class="ibox">
					<div class="ibox-content bg-primary">
						<h5 class="m-b-md">Done</h5>
						<h2 class="font-bold" id="c_done"></h2>
						<small></small>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>

<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="modal" id="modalSFljoxxth" tabindex="-1" role="dialog" aria-hidden="true">
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
				<div class="table-responsive">
                    <table id="tblljoxxth" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th rowspan="2">ID</th>
                                <th rowspan="2">Tanggal</th>
                                <th rowspan="2">Plate No</th>
                                <th rowspan="2">Expedition</th>
                                <th rowspan="2">Vehicle Type</th>
                                <th rowspan="2">Driver</th>
                                <th rowspan="2">Load</th>
								<th rowspan="2">Booking</th>
                                <th rowspan="2">Arrival</th>
                                <th colspan="2" class="text-center">Process</th>
                                <th rowspan="2">Document</th>
                                <th rowspan="2">Clearance</th>
                                <th rowspan="2">Done</th>
                            </tr>
							<tr>
                                <th>Start</th>
                                <th>Finish</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/ljoxxth_dashboard/fn/ljoxxth_dashboard_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtljoxxth, tblljoxxth, show_deleted_ljoxxth = 0, id_ljoxxth;
	// ------------- end of default variable
	
	// get tableRelation
	tableRelation('ljoxxth');

	$(document).ready(function() {

		//function autoreload data based on interval ms di ggsxxsh
		autoReloadInterval(function () {
			//tambahkan function reload tabel atau function generate card
			load_dashboard_logistic();							
			tblljoxxth.ajax.reload(null, false);
			// console.log('reloaded');
		});

		start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');	

		load_dashboard_logistic();

		tblljoxxth = $('#tblljoxxth').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/ljoxxth_dashboard/ljoxxth_dashboard.php",
				type: 'POST',
				data: function (d){
					d.start_date = start_date;
					d.end_date = end_date;
				}
			},
			order: [[ 1, "asc" ]],
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
					targets: [0,5,6,7,8,9,10,11,12,13]
				}
			],
			columns: [
				{ data: "id",visible:false },
				{ data: "tanggal" },
				{ 
					data: "plat_no" ,
					render: function (data, type, row) {
						persen_id_lprxxmh_last = Math.ceil(row.c_ljoprtd / 6 * 100);

						if(persen_id_lprxxmh_last <=30){
							progressClass = 'progress-bar-danger';
						}else if(persen_id_lprxxmh_last <=60){
							progressClass = 'progress-bar-warning';
						}else if(persen_id_lprxxmh_last <100){
							progressClass = 'progress-bar-success';
						}else{
							progressClass = 'progress-bar';
						}
					
						progressBar = '<div class="progress progress-mini '+progressClass+'" style="width: '+persen_id_lprxxmh_last+'%" role="progressbar" aria-valuenow="'+persen_id_lprxxmh_last+'" aria-valuemin="0" aria-valuemax="100"></div>';
						return data + '</br>' + progressBar;
						
					}
				},
				{ data: "grlxxmh_expedition_nama" },
				{ data: "lvtxxmh_nama" },
				{ data: "supir_nama" },
				{ data: "berat_muatan" },
				{ 
					data: "waktu_booking" ,
					render: function (data){
						if(data){
							dateTime = moment(data, 'DD MMM YYYY HH:mm');
							dateOnly = dateTime.format('DD MMM YYYY');
							timeOnly = dateTime.format('HH:mm');
							return dateOnly + '</br> ' + timeOnly;
						}else{
							return '';
						}
					}

				},
				{ 
					data: "waktu_arrival" ,
					render: function (data){
						if(data){
							dateTime = moment(data, 'DD MMM YYYY HH:mm');
							dateOnly = dateTime.format('DD MMM YYYY');
							timeOnly = dateTime.format('HH:mm');
							return dateOnly + '</br> ' + timeOnly;
						}else{
							return '';
						}
					}

				},
				{ 
					data: "waktu_process_start" ,
					render: function (data){
						if(data){
							dateTime = moment(data, 'DD MMM YYYY HH:mm');
							dateOnly = dateTime.format('DD MMM YYYY');
							timeOnly = dateTime.format('HH:mm');
							return dateOnly + '</br> ' + timeOnly;
						}else{
							return '';
						}
					}

				},
				{ 
					data: "waktu_process_finish" ,
					render: function (data){
						if(data){
							dateTime = moment(data, 'DD MMM YYYY HH:mm');
							dateOnly = dateTime.format('DD MMM YYYY');
							timeOnly = dateTime.format('HH:mm');
							return dateOnly + '</br> ' + timeOnly;
						}else{
							return '';
						}
					}

				},
				{ 
					data: "waktu_document" ,
					render: function (data){
						if(data){
							dateTime = moment(data, 'DD MMM YYYY HH:mm');
							dateOnly = dateTime.format('DD MMM YYYY');
							timeOnly = dateTime.format('HH:mm');
							return dateOnly + '</br> ' + timeOnly;
						}else{
							return '';
						}
					}

				},
				{ 
					data: "waktu_clearance" ,
					render: function (data){
						if(data){
							dateTime = moment(data, 'DD MMM YYYY HH:mm');
							dateOnly = dateTime.format('DD MMM YYYY');
							timeOnly = dateTime.format('HH:mm');
							return dateOnly + '</br> ' + timeOnly;
						}else{
							return '';
						}
					}
				},
				{ 
					data: "waktu_done" ,
					render: function (data){
						if(data){
							dateTime = moment(data, 'DD MMM YYYY HH:mm');
							dateOnly = dateTime.format('DD MMM YYYY');
							timeOnly = dateTime.format('HH:mm');
							return dateOnly + '</br> ' + timeOnly;
						}else{
							return '';
						}
					}
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_ljoxxth';
					$table       = 'tblljoxxth';
					$edt         = 'edtljoxxth';
					$show_status = '_ljoxxth';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= ['sf', 'sp', 'sb'];
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

		tblljoxxth.searchPanes.container().appendTo('#spljoxxth');
		tblljoxxth.searchBuilder.container().appendTo( '#sbljoxxth' );
		
		tblljoxxth.on( 'init', function () {
			// atur hak akses
			// CekInitHeaderH(tblljoxxth);
		} );
		
		tblljoxxth.on( 'select', function( e, dt, type, indexes ) {
			// siVarSet('ljoxxth');

			// // atur hak akses
			// CekSelectHeaderH(tblljoxxth);
		} );

		tblljoxxth.on( 'deselect', function () {
			// siVarReset('ljoxxth');

			// atur hak akses
			// CekDeselectHeaderH(tblljoxxth);
		} );

		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
			},
			submitHandler: function(frmFilter) {
				start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")

				load_dashboard_logistic();
				tblljoxxth.rows().deselect();
				tblljoxxth.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSFljoxxth').modal('toggle');
			}, false);
				return false;
			}
		});

		// END ljoxxth
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
