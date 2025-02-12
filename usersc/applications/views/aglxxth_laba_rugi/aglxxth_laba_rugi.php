<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'aglxxth';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="modal" id="modalSFaglxxth" tabindex="-1" role="dialog" aria-hidden="true">
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
                    <table id="tblaglxxth" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>parent3</th>
                                <th>parent2</th>
                                <th>parent1</th>
                                <th data-i18n="accountName"></th>
                                <th data-i18n="beginningBalance"></th>
                                <th data-i18n="debit"></th>
                                <th data-i18n="credit"></th>
                                <th data-i18n="balance"></th>
                            </tr>
                        </thead>
						<!-- <tfoot>
							<tr>
								<th></th>
								<th></th>
								<th>Total</th>
								<th id="total_3"></th>
								<th id="total_4"></th>
								<th id="total_5"></th>
								<th id="total_6"></th>
							</tr>
						</tfoot> -->
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
<script src="<?=$us_url_root?>usersc/helpers/language.js"></script>
<!-- BEGIN javascript here -->
<script type="text/javascript">
	cekNotification();
	// ------------- default variable, do not erase
	var edtaglxxth, tblaglxxth, show_deleted_aglxxth = 0, id_aglxxth;
	// ------------- end of default variable
	var is_akunbertransaksi = 1, is_akunbernilai = 1;

	// get tableRelation
	tableRelation('aglxxth');
	
	$(document).ready(function() {
		start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
		end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');	
		
		tblaglxxth = $('#tblaglxxth').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/aglxxth_laba_rugi/aglxxth_laba_rugi.php",
				type: 'POST',
				data: function (d){
					d.start_date = start_date;
					d.end_date = end_date;
					d.is_akunbertransaksi = is_akunbertransaksi;
					d.is_akunbernilai = is_akunbernilai;
				}
			},
			// rowGroup: {
			// 	dataSrc: 'akun'
			// },
			columnDefs:[
				{
					searchPanes:{
						show: true,
					},
					targets: [1,2,3]
				},
				{
					searchPanes:{
						show: false,
					},
					targets: '_all'
				}
			],
			columns: [
				{ data: "aatxxmh_nama",visible:false },
				{ data: "parent3",visible:false },
				{ data: "parent2",visible:false },
				{ data: "parent1",visible:false },
				{
    data: "nama",
    render: function(data, type, row) {
        return '<span style="padding-left: 60px;">' + data + '</span>';
    }
}
,
				{ 
					data: "saldo_awal" ,
					...renderNumber(2)
				},
				{ 
					data: "debit" ,
					...renderNumber(2)
				},
				{ 
					data: "kredit" ,
					...renderNumber(2)
				},
				{ 
					data: "saldo_akhir" ,
					...renderNumber(2)
				}
			],
			rowGroup: {
				dataSrc: ['parent3', 'parent2', 'parent1'], // Group berdasarkan kolom pertama dan kedua
				startRender: function(rows, group, level) {
					if (level === 0) {
						return $('<tr/>')
							.append('<td colspan="5"><strong>' + group + '</strong></td>');
					} else if (level === 1) {
						return $('<tr/>')
							.append('<td colspan="5" style="padding-left: 20px;"><strong>' + group + '</strong></td>');
					} else {
						return $('<tr/>')
							.append('<td colspan="5" style="padding-left: 40px;"><strong>' + group + '</strong></td>');
					}
				},
				endRender: function (rows, group, level) {
					var sum_saldo_awal = rows
						.data()
						.pluck('saldo_awal')
						.map(s => parseFloat(s) || 0)
						.reduce((a, b) => a + b, 0);

					var sum_debit = rows
						.data()
						.pluck('debit')
						.map(d => parseFloat(d) || 0)
						.reduce((a, b) => a + b, 0);

					var sum_kredit = rows
						.data()
						.pluck('kredit')
						.map(k => parseFloat(k) || 0)
						.reduce((a, b) => a + b, 0);

					var sum_saldo_akhir = rows
						.data()
						.pluck('saldo_akhir')
						.map(s => parseFloat(s) || 0)
						.reduce((a, b) => a + b, 0);

					sum_saldo_awal = $.fn.dataTable.render.number(',', '.', 0, '').display(sum_saldo_awal);
					sum_debit = $.fn.dataTable.render.number(',', '.', 0, '').display(sum_debit);
					sum_kredit = $.fn.dataTable.render.number(',', '.', 0, '').display(sum_kredit);
					sum_saldo_akhir = $.fn.dataTable.render.number(',', '.', 0, '').display(sum_saldo_akhir);

					var indent = level * 20; // Sesuaikan indentasi berdasarkan level

					var label = "";
					if (level === 0) {
						label = '<strong>Total ' + group + '</strong>';
					} else if (level === 1) {
						label = '<strong>Total ' + group + '</strong>';
					} else if (level === 2) {
						label = '<strong>Total ' + group + '</strong>';
					}

					return $('<tr/>')
						.append('<td class="font-bold text-primary" style="padding-left: ' + indent + 'px;">' + label + '</td>')
						.append('<td class="text-right font-bold bg-primary">' + sum_saldo_awal + '</td>')
						.append('<td class="text-right font-bold bg-primary">' + sum_debit + '</td>')
						.append('<td class="text-right font-bold bg-primary">' + sum_kredit + '</td>')
						.append('<td class="text-right font-bold bg-primary">' + sum_saldo_akhir + '</td>');
				}
			},
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_aglxxth';
					$table       = 'tblaglxxth';
					$edt         = 'edtaglxxth';
					$show_status = '_aglxxth';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= ['sf', 'sp', 'sb'];
					$arr_buttons_action 	= [];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
				// END breaking generate button
			],
			// footerCallback: function ( row, data, start, end, display ) {
			// 	var api = this.api();
			// 	var numFormat = $.fn.dataTable.render.number( '\,', '.', 0, '' ).display; 

			// 	for (var i = 3; i <= 6; i++) {
			// 		var columnIndex = i;
			// 		var sum_all = api.column(columnIndex).data().sum();
			// 		// Bisa dilakukan sum berdasarkan paginasi (sum per paginasi / tidak sum semua data) dengan menambahkan { page: 'current' }
			// 		var sum = api.column(columnIndex, { page: 'current' }).data().sum();
			// 		$('#total_' + columnIndex).html(numFormat(sum_all));

			// 		// console.log('Number of Pages: ' + api.page.info().pages);
			// 	}
			// },
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
		} );

		tblaglxxth.searchPanes.container().appendTo('#spaglxxth');
		tblaglxxth.searchBuilder.container().appendTo( '#sbaglxxth' );
		
		tblaglxxth.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblaglxxth);
		} );
		
		tblaglxxth.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			// siVarSet('aglxxth');

			// atur hak akses
			CekSelectHeaderH(tblaglxxth);
		} );

		tblaglxxth.on( 'deselect', function () {
			// reset variable standar framework
			// siVarReset('aglxxth');

			// atur hak akses
			CekDeselectHeaderH(tblaglxxth);
		} );

		// END aglxxth

		// BEGIN form filter
		$("#frmFilter").submit(function(e) {
			e.preventDefault();
		}).validate({
			rules: {
				start_date: {
					required: true,
					validDate: "DD MMM YYYY"
				},
				end_date: {
					required: true,
					validDate: "DD MMM YYYY"
				}
			},
			messages: {
				start_date: {
					required: "Start Date Wajib Diisi!"
				},
				end_date: {
					required: "End Date Wajib Diisi!"
				}
			},
			submitHandler: function(frmFilter) {
				start_date = moment($('#start_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');
				end_date = moment($('#end_date').val(), 'DD MMM YYYY').format('YYYY-MM-DD');

				// BEGIN parameter tambahan
				if( $('#cbakunbertransaksi').is(':checked') ){
					is_akunbertransaksi = 1;
				}else{
					is_akunbertransaksi = 0;
				}

				if( $('#cbakunbertransaksi').is(':checked') ){
					is_akunbernilai = 1;
				}else{
					is_akunbernilai = 0;
				}

				toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")
				tblaglxxth.rows().deselect();
				tblaglxxth.ajax.reload(function ( json ) {
				toastr.remove();
				toastr["success"]("Load data berhasil","INFO")
				$('#modalSFaglxxth').modal('toggle');
			}, false);
				return false;
			}
		});
		// END form filter
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
