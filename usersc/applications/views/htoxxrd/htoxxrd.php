<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'htoxxrd';
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
                <form class="form-horizontal" id="frmhtoxxrd">
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
                        <label class="col-sm-2 col-form-label">Employee</label>
                        <div class="col-sm-4">
                            <select class="form-control" id="select_hemxxmh" name="select_hemxxmh"></select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-4">
                            <button class="btn btn-primary" type="submit" id="go">Submit</button>
                        </div>
                    </div>
                </form>
                <div id="searchPanes1"></div>
            </div>
        </div>
    </div>
</div>

<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblhtoxxrd" class="table table-striped table-bordered table-hover nowrap" width="100%">
						<thead>
							<tr>
								<th>ID</th>
								<th>Kode</th>
								<th>Tanggal</th>
								<th>Karyawan</th>
								<!-- <th>Jenis</th> -->
								<th>Tipe</th>
								<th>Istirahat</th>
								<th>Keterangan</th>
								<th>Jam Awal</th>
								<th>Jam Akhir</th>
								<th>Durasi</th>
								<!-- <th>Makan</th> -->
								<th>Approve</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<!-- <th></th> -->
								<th></th>
								<th></th>
								<th></th>
								<!-- <th id=""></th> -->
								<th></th>
								<th>Grand Total</th>
								<th class="text-right bg-primary" id="s_jam"></th>
								<th></th>
							</tr>
						</tfoot>
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
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn.js"></script>

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/htoxxrd/fn/htoxxrd_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
		// ------------- default variable, do not erase
		var edthtoxxrd, tblhtoxxrd, show_deleted_htoxxrd = 0, id_htoxxrd;
		// ------------- end of default variable
		var id_hemxxmh = 0;
		var id_hemxxmh_old = 0;
		
		// get tableRelation
		tableRelation('htoxxrd');

		// BEGIN datepicker init
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
		
        // END datepicker init

		//Select2 init
        $("#select_hemxxmh").select2({
			placeholder: 'Ketik atau TekanTanda Panah Kanan',
			allowClear: true,
			ajax: {
				url: "../../models/hemxxmh/hemxxmh_fn_opt.php",
				dataType: 'json',
				data: function (params) {
					var query = {
						id_hemxxmh_old: id_hemxxmh_old,
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
        // END select2 init

		$(document).ready(function() {
			start_date = moment($('#start_date').val()).format('YYYY-MM-DD');
			end_date   = moment($('#end_date').val()).format('YYYY-MM-DD');
			// BEGIN htoxxrd

			tblhtoxxrd = $('#tblhtoxxrd').DataTable( {
				dom: domPQ,
				searchPanes:{
					layout: 'columns-4',
				},
				ajax: {
					url: "../../models/htoxxrd/htoxxrd.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_htoxxrd = show_deleted_htoxxrd;
						d.start_date = start_date;
						d.end_date = end_date;
						d.id_hemxxmh = id_hemxxmh;
					}
				},
				order: [[ 1, "asc" ]],
				columnDefs:[
					{
						searchPanes:{
							show: true,
						},
						targets: [1,2,3,5]
					},
					{
						searchPanes:{
							show: false,
						},
						targets: "_all"
					}
				],
				
				rowGroup: {
					startRender: function ( rows, group ) {
						return $('<tr/>')
							.append( '<td colspan="2" class="font-bold">'+group+'</td>' )
							.append( '<td></td>' )
							.append( '<td></td>' )
							.append( '<td></td>' )
							.append( '<td></td>' )
							.append( '<td></td>' )
							.append( '<td></td>' )
							.append( '<td></td>' );
					},
					endRender: function ( rows, group ) {
						var sumJam = rows
							.data()
							.pluck('htoxxrd.durasi_lembur_jam') 
							.reduce( function (a, b) {
								return parseFloat(a) + parseFloat(b);
							}, 0);
						sumJam = $.fn.dataTable.render.number(',', '.', 1, '').display( sumJam );

						var sum_pot_ti = rows
							.data()
							.pluck('htoxxrd.pot_ti') 
							.reduce( function (a, b) {
								return parseFloat(a) + parseFloat(b);
							}, 0);
						sum_pot_ti = $.fn.dataTable.render.number(',', '.', 1, '').display( sum_pot_ti );

						return $('<tr/>')
							.append( '<td colspan="2" class="font-bold">Total</td>' )
							.append( '<td></td>' )
							.append( '<td></td>' )
							.append( '<td></td>' )
							.append( '<td></td>' )
							.append( '<td></td>' )
							.append( '<td class="text-right bg-warning">'+sumJam+'</td>' )
							.append( '<td class="text-right"></td>' );
					},
					dataSrc: 'htoxxrd.kode'
				},
				columns: [
					{ data: "htoxxrd.id",visible:false },
					{ 
						data: "htoxxrd.kode" ,
						visible:false 
					},
					{ data: "htoxxrd.tanggal" },
					{ data: "hemxxmh_data" },
					// { data: "heyxxmh.nama" },
					{ data: "htotpmh.nama" },
					{ 
						data: "htoxxrd.is_istirahat" ,
						render: function (data){
							if (data == 0){
								return 'Tidak';
							}else if(data == 1){
								return 'Ya';
							}else if(data == 2){
								return 'TI';
							}else{
								return 'Data Salah';
							}
						}
					},
					{ data: "htoxxrd.keterangan" },
					{ data: "htoxxrd.jam_awal" },
					{ data: "htoxxrd.jam_akhir" },
					{ 
						data: "htoxxrd.durasi_lembur_jam" ,
						render: $.fn.dataTable.render.number( ',', '.', 1,'','' ),
						class: "text-right"
					},
					{ 
						data: "htoxxrd.approval_state" ,
						...renderApprovalStatus()
					}
				],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_htoxxrd';
						$table       = 'tblhtoxxrd';
						$edt         = 'edthtoxxrd';
						$show_status = '_htoxxrd';
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
					if ( data.htoxxrd.transaction_state == -9 ) {
						$('td', row).addClass('text-danger');
					}else if ( data.htoxxrd.transaction_state == 0 ) {
						$('td', row).addClass('text-warning');
					}
				},
				footerCallback: function ( row, data, start, end, display ) {
					var api       = this.api(), data;
					var numFormat1 = $.fn.dataTable.render.number( '\,', '.', 1, '' ).display; 
					var numFormat0 = $.fn.dataTable.render.number( '\,', '.', 1, '' ).display; 
					// hitung jumlah 
					s_jam = api.column( 9 ).data().sum();
					

					$( '#s_jam' ).html( numFormat1(s_jam) );
				}
			} );

			tblhtoxxrd.searchPanes.container().appendTo('#sphtoxxrd');
			tblhtoxxrd.searchBuilder.container().appendTo( '#sbhtoxxrd' );
			
			tblhtoxxrd.on( 'init', function () {
				// atur hak akses
				CekInitHeaderH(tblhtoxxrd);
			} );
			
			tblhtoxxrd.on( 'select', function( e, dt, type, indexes ) {
				htoxxrd_data    		= tblhtoxxrd.row( { selected: true } ).data().htoxxrd;
				id_htoxxrd      		= htoxxrd_data.id;
				id_transaksi_h 		= id_htoxxrd; // dipakai untuk general
				id_transaksi_log	= id_htoxxrd; // dipakai untuk general
				transaction_state   = htoxxrd_data.transaction_state;
				approval_state   	= htoxxrd_data.approval_state;
				is_nextprocess 		= htoxxrd_data.is_nextprocess;

				// atur hak akses
				CekSelectHeaderH(tblhtoxxrd);
			} );

			tblhtoxxrd.on( 'deselect', function () {
				// reload dipanggil di function CekDeselectHeader
				id_htoxxrd = 0;

				// atur hak akses
				CekDeselectHeaderH(tblhtoxxrd);
			} );

			$("#frmhtoxxrd").submit(function(e) {
				e.preventDefault();
			}).validate({
				rules: {
					
				},
				submitHandler: function(frmhtoxxrd) {
					start_date 		= moment($('#start_date').val()).format('YYYY-MM-DD');
					end_date 		= moment($('#end_date').val()).format('YYYY-MM-DD');
					id_hemxxmh = $('#select_hemxxmh').val();

					notifyprogress = $.notify({
						message: 'Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!'
					},{
						z_index: 9999,
						allow_dismiss: false,
						type: 'info',
						delay: 0
					});

					tblhtoxxrd.rows().deselect();
					tblhtoxxrd.ajax.reload(function ( json ) {
						notifyprogress.close();
					}, false);
					return false; 
				}
			});
			// END htoxxrd
			
		} );// end of document.ready
	
	</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
