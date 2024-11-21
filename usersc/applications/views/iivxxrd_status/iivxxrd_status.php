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
		<div class="ibox ">
			<div class="ibox-content">
				<div class="modal" id="modalSFiivxxrd" tabindex="-1" role="dialog" aria-hidden="true">
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
												<input type="text" id="end_date" class="form-control">
												<div class="input-group-addon">
													<span class="fa fa-calendar"></span>
												</div>
											</div>
										</div>
									</div>
									<div class="form-group row">												
										<label class="col-sm-2 col-form-label">Location Category</label>
										<div class="col-sm-6">
											<select class="form-control" id="select_id_wloctmh" name="select_id_wloctmh"></select>
										</div>
									</div>
									<div class="form-group row" id="input_jenis">
										<label class="col-lg-2 col-form-label">Item Status</label>
										<div class="col-lg-5">
											<div class="input-group">
												<select class="form-control" id="iimxxmh_status_fs" name="iimxxmh_status_fs">
													<option value="1">Good</option>
													<option value="2">Bad</option>
													<option value="3">Hold</option>
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

				<table id="tbliivxxrd" class="table table-striped table-bordered table-hover nowrap" width="100%">
				<thead>
					<tr>
						<th style="vertical-align: middle" rowspan="3">Warehouse</th>
						<th style="vertical-align: middle" rowspan="3">Location</th>
						<th style="vertical-align: middle" rowspan="3">LPN</th>
						<th style="vertical-align: middle" rowspan="3">Kode</th>
						<th style="vertical-align: middle" rowspan="3">Nama</th>
						<th colspan="4" class="text-center bg-success">On Hand</th>
						<th colspan="4" class="text-center bg-warning">Reserved</th>
						<th colspan="4" class="text-center bg-primary">Avalaible</th>
						<th style="vertical-align: middle" rowspan="3">Batch Number</th>
						<th style="vertical-align: middle" rowspan="3">Expired Date</th>
						<th style="vertical-align: middle" rowspan="3">Item Status</th>
					</tr>
					<tr>
						<th colspan="2">Terkecil</th>
						<th colspan="2">Default</th>

						<th colspan="2">Terkecil</th>
						<th colspan="2">Default</th>

						<th colspan="2">Terkecil</th>
						<th colspan="2">Default</th>
					</tr>
					<tr>
						<th>Jumlah</th>
						<th>UoM</th>
						<th>Jumlah</th>
						<th>UoM</th>

						<th>Jumlah</th>
						<th>UoM</th>
						<th>Jumlah</th>
						<th>UoM</th>

						<th>Jumlah</th>
						<th>UoM</th>
						<th>Jumlah</th>
						<th>UoM</th>
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

<script src="<?=$us_url_root?>usersc/helpers/general_fn.js"></script>
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn2.js"></script>
<!-- BEGIN datatables here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var tbliivxxrd, show_deleted_iivxxrd = 0, id_wloctmh_old = 0, id_wloctmh = 0;
	var edtqwhxxth;
	var iimxxmh_status = 0, id_iivxxrd = 0;
	// ------------- end of default variable
	
	// BEGIN select2 init
	$("#select_id_wloctmh").select2({
		dropdownParent: $("#modalSFiivxxrd"),
		placeholder : "Select",
		allowClear: true,
		multiple: true,
		ajax: {
			url: "../../models/wloctmh/wloctmh_fn_opt.php",
			dataType: 'json',
			data: function (params) {
				var query = {
					id_wloctmh_old: id_wloctmh_old,
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
		},
	});

	$(document).ready(function() {
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		id_wloctmh = $('#select_id_wloctmh').val();
		id_wloctmh = '(' + id_wloctmh.join(',') + ')';
		// console.log(id_wloctmh);
		iimxxmh_status_fs =  $('#iimxxmh_status_fs').val();

		// BEGIN qwhxxth
		edtqwhxxth = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/iivxxrd_status/create_qwhxxth.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_qwhxxth = 0;
					d.id_udpxxsh = 0;
				}
			},
			formOptions: {
				main: {
					focus: 3
				}
			},
			fields: [ 
				{
					label: "start_at",
					name: "start_at",
					type: "hidden"
				},	
				{
					label: "finish_at",
					name: "finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "qwhxxth",
					type: "hidden"
				},	
				{
					label: "qwhxxth.transaction_state",
					name: "qwhxxth.transaction_state",
					type: "hidden",
					def: 1
				},	
				{
					label: "id_iivxxrd",
					name: "id_iivxxrd",
					type: "hidden",
				},	
				{
					label: "end_date",
					name: "end_date",
					type: "hidden",
				},	
				{
					label: "Tanggal",
					name: "qwhxxth.tanggal",
					type: "datetime",
					def: function () { 
						return new Date(); 
					},
					opts:{
						minDate: new Date('1900-01-01'),
						firstDay: 0
					},
					format: 'DD MMM YYYY'
				},
				{
					label: "Item Status <sup class='text-danger'>*<sup>",  
					name: "iimxxmh_status",
					type: "select",
					placeholder : "Select",
					options: [
						{ "label": "Good", "value": 1 },
						{ "label": "Bad", "value": 2 },
						{ "label": "Hold", "value": 3 },
					],
				},
				{
					label: "Alasan Perubahan Status",
					name: "alasan_perubahan_status",
					type: "textarea"
				},
			]
			} );
			edtqwhxxth.field('qwhxxth.tanggal').hide();

			edtqwhxxth.on( 'preOpen', function( e, mode, action ) {
				console.log(iimxxmh_status);
				start_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtqwhxxth.field('iimxxmh_status').val(iimxxmh_status);
				edtqwhxxth.field('id_iivxxrd').val(id_iivxxrd);
				edtqwhxxth.field('start_at').val(start_at);
				edtqwhxxth.field('end_date').val(end_date);
			});

			edtqwhxxth.on("open", function (e, mode, action) {
				$(".modal-dialog").addClass("modal-lg");
				$('div.DTE_Form_Buttons button:eq(2)').hide();
			});

			let swalConfirmed = false;

			edtqwhxxth.on( 'preSubmit', function (e, data, action) {
				if(action != 'remove'){
					iimxxmh_status = edtqwhxxth.field('iimxxmh_status').val();
					if(iimxxmh_status == null || iimxxmh_status == ''){
						edtqwhxxth.field('iimxxmh_status').error( 'Wajib diisi!' );
					}
				}

				if ( edtqwhxxth.inError() ) {
					return false;
				}
				
				// If already confirmed, allow submission
				if (swalConfirmed) {
					swalConfirmed = false; // Reset the flag for future submissions
					return true;
				}

				// Prevent the default submission initially
				e.preventDefault();

				// Show SweetAlert confirmation dialog
				swal({
					text: "Apakah Anda Yakin?",
					icon: "info",
					buttons: {
						cancel: "Batal",
						confirm: "Ya, Simpan"
					},
				}).then((willConfirm) => {
					if (willConfirm) {
						// Set the flag and re-trigger the submit process
						swalConfirmed = true;
						edtqwhxxth.submit(); // Submit the data
					} else {
						// If the user cancels, do nothing
						// console.log("Submission canceled by the user.");
					}
				});

				// Return false to prevent automatic submission until confirmed
				return false;
			});

			edtqwhxxth.on('initSubmit', function(e, action) {
				finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtqwhxxth.field('finish_at').val(finish_at);
			});

			edtqwhxxth.on( 'postSubmit', function (e, json, data, action, xhr) {
				tbliivxxrd.rows().deselect();
				tbliivxxrd.ajax.reload(null, false);
			} );

			edtqwhxxth.on( 'close', function () {
				edtqwhxxth.enable();
			} );

		//start datatables
		tbliivxxrd = $('#tbliivxxrd').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/iivxxrd_status/iivxxrd_status.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_iivxxrd = show_deleted_iivxxrd;
					d.end_date = end_date;
					d.id_wloctmh = id_wloctmh;
					d.iimxxmh_status_fs = iimxxmh_status_fs;
				}
			},
			responsive: false,
			scrollX: true,
			order: [[ 1, "asc" ]],
			columnDefs:[
				{
					searchPanes:{
						show: true,
					},
					targets: [0,1,2,4]
				},
				{
					searchPanes:{
						show: false,
					},
					targets:'_all'
				},
				{ 
					className: 'bg-beige', targets: [5,6,9,10,13,14] //ini jumlah sama uom
				}
			],
			columns: [
				{ data: "iwhxxmh_kode" },
				{ data: "wloxxmh_nama" },
				{ data: "wlpxxmh_kode" },
				{ data: "iimxxmh_kode" },
				{ data: "iimxxmh_nama" },
				{ 
					data: "jumlah_terkecil", //4
					...renderNumber(0)
				},
				{ data: "iumxxmh_terkecil_kode" },//5
				{ 
					data: "jumlah_default",
					...renderNumber(3)
				},
				{ data: "iumxxmh_default_kode" },

				//Reserved
				{ 
					data: "jumlah_terkecil_booking",
					...renderNumber(0)
				},
				{ data: "iumxxmh_terkecil_kode" },
				{ 
					data: "jumlah_default_booking",
					...renderNumber(3)
				},
				{ data: "iumxxmh_default_kode" },

				//Avalaible
				{ 
					data: "jumlah_terkecil_ava",
					...renderNumber(0)
				},
				{ data: "iumxxmh_terkecil_kode" },
				{ 
					data: "jumlah_default_ava",
					...renderNumber(3)
				},
				{ data: "iumxxmh_default_kode" },

				{ data: "batch_number" },
				{ data: "expired_date" },
				{ 
					data: "iimxxmh_status",
					render: function (data) {
						if(data == 1){
							return '<span class="badge badge-primary">GOOD</span>';
						}else if(data == 2){
							return '<span class="badge badge-danger">BAD</span>';
						}else if(data == 3){
							return '<span class="badge badge-plain">HOLD</span>';
						}else{
							return '<span class="badge badge-warning">INVALID</span>';
						}
					}
				},
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
					$arr_buttons_tools2 	= ['sf','sp', 'sb'];
					$arr_buttons_action 	= [];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
				{
					extend: 'create',
					name: 'btnItemStatus',
					editor: edtqwhxxth,
					// text: '<i class="fa fa-edit"></i>&nbsp;Edit Item Status',
					text: 'Edit Item Status',
					className: 'btn btn-outline',
					titleAttr: 'New',
					key: {
						key: 'n',
						ctrlKey: true,
						altKey: true
					}
				}
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
	
		tbliivxxrd.button( 'btnItemStatus:name' ).disable();
		
		tbliivxxrd.on( 'select', function( e, dt, type, indexes ) {
			iivxxrd_data    = tbliivxxrd.row( { selected: true } ).data();
			iimxxmh_status      = iivxxrd_data.iimxxmh_status;
			id_iivxxrd      = iivxxrd_data.id_iivxxrd;
			// console.log(iivxxrd_data);
			tbliivxxrd.button( 'btnItemStatus:name' ).enable();

		} );
		
		tbliivxxrd.on( 'deselect', function () {
			iimxxmh_status = 0;
			id_iivxxrd = 0;
			tbliivxxrd.button( 'btnItemStatus:name' ).disable();
		} );

		// BEGIN form filter
		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
			},
			submitHandler: function(frmFilter) {
				start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				id_wloctmh = $('#select_id_wloctmh').val();
				id_wloctmh = '(' + id_wloctmh.join(',') + ')';
				// console.log(id_wloctmh);
				iimxxmh_status_fs =  $('#iimxxmh_status_fs').val();

				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
				tbliivxxrd.rows().deselect();
				tbliivxxrd.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSFiivxxrd').modal('toggle');
			}, false);
				return false;
			}
		});
		// END form filter
		
		
	} );// end of document.ready

</script>

<!-- END datatables here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
