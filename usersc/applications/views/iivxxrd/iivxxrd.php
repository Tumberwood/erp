<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>
<link href="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/css/plugins/pivottable/pivot.min.css" rel="stylesheet">

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
                                <input type="text" id="start_date" class="form-control">
                                <!-- <span class="input-group-addon">to</span>
                                <input type="text" id="end_date" class="form-control"> -->
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
				<table id="tbliivxxrd" class="table table-striped table-bordered table-hover wrap" width="100%">
				</table>
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
		var tbliivxxrd, show_inactive_status_iivxxrd = 0;
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
		$('#start_date').datepicker('setDate', tanggal_hariini_dmy);
        // END datepicker init

		function generateTable() {
			
			$.ajax( {
				url: "../../models/iivxxrd/iivxxrd.php",
				dataType: 'json',
				type: 'POST',
				data: {
					start_date: start_date
				},
				success: function ( json ) {
					if(json.data.length > 0){
						
						if ( $.fn.dataTable.isDataTable( '#tbliivxxrd' ) ) {
							$('#tbliivxxrd').DataTable().clear();
							$('#tbliivxxrd').DataTable().destroy(); 
							$('#tbliivxxrd tbody').empty();
							$('#tbliivxxrd thead').empty();
						}

						str = '<thead>';
							// BEGIN header baris 1
							str = str + '<tr>';
							$.each(json.columns, function (k, colObj) {
								// BEGIN render column name
								if( colObj.name == 'kode' ){
									str = str + '<th>Kode</th>';
								}else if( colObj.name == 'nama' ){
									str = str + '<th>Nama</th>';
								}else if( colObj.name == 'uom' ){
									str = str + '<th>UoM</th>';
								}else if( colObj.name == 'wh' ){
									str = str + '<th>Warehouse</th>';
								}else if( colObj.name == 'qty_terkecil' ){
									str = str + '<th>Quantity</th>';
								}
							});
							str = str + '</tr>';
							// END header baris 1
						str = str + '</thead>';

						$('#tbliivxxrd').html(str);
						
						$('#tbliivxxrd').DataTable({
							scrollX: true,
							responsive: false,
							scrollCollapse: true,
							fixedColumns:   {
								left: 3
							},
							data: json.data,
							columns: json.columns,
							buttons: [
								{
									extend: 'collection',
									text: '<i class="fa  fa-wrench">',
									className: 'btn btn-white',
									autoClose: true,
									buttons: [
										{ extend: "copy", text: '<i class="fa fa-copy">&nbsp &nbsp Copy</i>', className: '',titleAttr: 'Copy'},
										{ extend: "excel", text: '<i class="fa fa-file-excel-o">&nbsp &nbsp Excel</i>', className: '',titleAttr: 'Export to Excel'}
									]
								},
								{ 
									extend: 'colvis',
									columns: colvisCount,
									columnText: function ( dt, idx, title ) {
										return title;
									},
									text: '<i class="fa fa-eye-slash"></i>',
									className: 'btn btn-white',
									titleAttr: 'Show / Hide Column'
								},
							],
							columnDefs: [
								{ targets: [4], className: 'text-right' } // Apply text-right class to all columns
							],
							rowCallback: function( row, data, index ) {
								
							}
						});

						if(notifyprogress != ''){
							notifyprogress.close();
						}

					}else{
						notifyprogress.close();
						notifyprogress = $.notify({
							message: 'Tidak ada data pada tanggal tersebut!'
						},{
							z_index: 9999,
							allow_dismiss: false,
							type: 'danger',
							delay: 3
						});
					}
				}
			} );
		}

		$(document).ready(function() {
			start_date = moment($('#start_date').val()).format('YYYY-MM-DD');
			
			// generateTable();

			$("#frmiivxxrd").submit(function(e) {
				e.preventDefault();
			}).validate({
				rules: {
					
				},
				submitHandler: function(frmiivxxrd) {
					start_date 		= moment($('#start_date').val()).format('YYYY-MM-DD');
					
					notifyprogress = $.notify({
						message: 'Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!'
					},{
						z_index: 9999,
						allow_dismiss: false,
						type: 'info',
						delay: 0
					});
					// tbliivxxrd.destroy();
					generateTable();
					return false; 
				}
			});
			
			
		} );// end of document.ready
	
	</script>

<!-- END datatables here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
