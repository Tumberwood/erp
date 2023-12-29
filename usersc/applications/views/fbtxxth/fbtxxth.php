<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'fbtxxth';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblfbtxxth" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tanggal</th>
                                <th>Kode</th>
                                <th>Asal</th>
                                <th>Tujuan</th>
                                <th>Amount</th>
                                <th>Keterangan</th>
                                <th>TX</th>
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
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_toast.php';
?>

<!-- BEGIN JS -->
<?php 
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_load.php';
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_setup.php';
	require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_datatables_load.php'; 
?>

<script src="<?=$us_url_root?>usersc/helpers/general_fn.js"></script>
<script src="<?=$us_url_root?>usersc/helpers/hakaksescrud_hd_fn.js"></script>

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/fbtxxth/fn/fbtxxth_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
		// ------------- default variable, do not erase
		var edtfbtxxth, tblfbtxxth, show_deleted_fbtxxth = 0, id_fbtxxth;
		// ------------- end of default variable
		is_need_generate_kode = 1, is_need_approval = 1, is_need_jurnal = 1;
		id_aakxxmh_asal_old = 0, id_aakxxmh_tujuan_old = 0;
		
		$(document).ready(function() {
			//start datatables editor
			edtfbtxxth = new $.fn.dataTable.Editor( {
				formOptions: {
					main: {
						focus: 5,
					}
				},
				ajax: {
					url: "../../models/fbtxxth/fbtxxth.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_fbtxxth = show_deleted_fbtxxth;
					}
				},
				table: "#tblfbtxxth",
				fields: [ 
					{
						label: "kategori_dokumen",
						name: "kategori_dokumen",
						type: "hidden"
					},
					{
						label: "kategori_dokumen_value",
						name: "kategori_dokumen_value",
						type: "hidden"
					},
					{
						label: "field_tanggal",
						name: "field_tanggal",
						type: "hidden"
					},
					{
						label: "fbtxxth.start_at",
						name: "fbtxxth.start_at",
						type: "hidden"
					},	
					{
						label: "fbtxxth.finish_at",
						name: "fbtxxth.finish_at",
						type: "hidden"
					},	
					{
						label: "nama_tabel",
						name: "nama_tabel",
						def: "fbtxxth",
						type: "hidden"
					},	
					{
						label: "fbtxxth.transaction_state",
						name: "fbtxxth.transaction_state",
                        type: "hidden",
						def: 0
					},	
					{
						label: "Tanggal <sup class='text-danger'>*<sup>",
						name: "fbtxxth.tanggal",
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
						label: "Asal <sup class='text-danger'>*<sup>",
						name: "fbtxxth.id_aakxxmh_asal",
						type: "select2",
						opts: {
							placeholder : "Select",
							allowClear: true,
							multiple: false,
							ajax: {
								url: "../../models/aakxxmh/aakxxmh_kasbank_fn_opt.php",
								dataType: 'json',
								data: function (params) {
									var query = {
										id_aakxxmh_old: id_aakxxmh_asal_old,
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
						}
					},
					{
						label: "Tujuan <sup class='text-danger'>*<sup>",
						name: "fbtxxth.id_aakxxmh_tujuan",
						type: "select2",
						opts: {
							placeholder : "Select",
							allowClear: true,
							multiple: false,
							ajax: {
								url: "../../models/aakxxmh/aakxxmh_kasbank_fn_opt.php",
								dataType: 'json',
								data: function (params) {
									var query = {
										id_aakxxmh_old: id_aakxxmh_tujuan_old,
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
						}
					},
					{
						label: "Amount <sup class='text-danger'>*<sup>",
						name: "fbtxxth.amount"
					},
					{
						label: "Keterangan <sup class='text-danger'>*<sup>",
						name: "fbtxxth.keterangan",
						type: "textarea"
					}
				]
			} );

			edtfbtxxth.on( 'preOpen', function( e, mode, action ) {
				start_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtfbtxxth.field('fbtxxth.start_at').val(start_at);
				
				if(action == 'create'){
					edtfbtxxth.field('kategori_dokumen').val('');
					edtfbtxxth.field('kategori_dokumen_value').val('');
					edtfbtxxth.field('field_tanggal').val('tanggal');
					tblfbtxxth.rows().deselect();
				}
			});

			edtfbtxxth.on("open", function (e, mode, action) {
				$(".modal-dialog").addClass("modal-lg");
			});

            edtfbtxxth.on( 'preSubmit', function (e, data, action) {
				if(action != 'remove'){
					
					// BEGIN of validasi fbtxxth.tanggal
					if ( ! edtfbtxxth.field('fbtxxth.tanggal').isMultiValue() ) {
						tanggal = edtfbtxxth.field('fbtxxth.tanggal').val();
						if(!tanggal || tanggal == ''){
							edtfbtxxth.field('fbtxxth.tanggal').error( 'Wajib diisi!' );
						}
					}
					// END of validasi fbtxxth.tanggal

					// BEGIN of validasi fbtxxth.id_aakxxmh_asal
					if ( ! edtfbtxxth.field('fbtxxth.id_aakxxmh_asal').isMultiValue() ) {
						id_aakxxmh_asal = edtfbtxxth.field('fbtxxth.id_aakxxmh_asal').val();
						if(!id_aakxxmh_asal || id_aakxxmh_asal == ''){
							edtfbtxxth.field('fbtxxth.id_aakxxmh_asal').error( 'Wajib diisi!' );
						}
					}
					// END of validasi fbtxxth.id_aakxxmh_asal

					// BEGIN of validasi fbtxxth.id_aakxxmh_tujuan
					if ( ! edtfbtxxth.field('fbtxxth.id_aakxxmh_tujuan').isMultiValue() ) {
						id_aakxxmh_tujuan = edtfbtxxth.field('fbtxxth.id_aakxxmh_tujuan').val();
						if(!id_aakxxmh_tujuan || id_aakxxmh_tujuan == ''){
							edtfbtxxth.field('fbtxxth.id_aakxxmh_tujuan').error( 'Wajib diisi!' );
						}
					}
					// END of validasi fbtxxth.id_aakxxmh_tujuan

					// BEGIN of validasi fbtxxth.amount
					if ( ! edtfbtxxth.field('fbtxxth.amount').isMultiValue() ) {
						amount = edtfbtxxth.field('fbtxxth.amount').val();
						if(!amount || amount == ''){
							edtfbtxxth.field('fbtxxth.amount').error( 'Wajib diisi!' );
						}
						if(amount <= 0 ){
							edtfbtxxth.field('fbtxxth.amount').error( 'Inputan harus > 0' );
						}
						if(isNaN(amount) ){
							edtfbtxxth.field('fbtxxth.amount').error( 'Inputan harus berupa Angka!' );
						}
					}
					// END of validasi fbtxxth.amount

					// BEGIN of validasi fbtxxth.keterangan
					if ( ! edtfbtxxth.field('fbtxxth.keterangan').isMultiValue() ) {
						keterangan = edtfbtxxth.field('fbtxxth.keterangan').val();
						if(!keterangan || keterangan == ''){
							edtfbtxxth.field('fbtxxth.keterangan').error( 'Wajib diisi!' );
						}
					}
					// END of validasi fbtxxth.keterangan

					// BEGIN balidasi id_aakxxmh_asal <> id_aakxxmh_tujuan
					if(id_aakxxmh_asal > 0 && id_aakxxmh_tujuan > 0){
						if(id_aakxxmh_asal == id_aakxxmh_tujuan){
							edtfbtxxth.field('fbtxxth.id_aakxxmh_asal').error( 'Asal dan Tujuan Tidak Boleh Sama!' );
							edtfbtxxth.field('fbtxxth.id_aakxxmh_tujuan').error( 'Asal dan Tujuan Tidak Boleh Sama!' );
						}
					}
				
				}
				
				if ( edtfbtxxth.inError() ) {
					return false;
				}
			});
			
			edtfbtxxth.on('initSubmit', function(e, action) {
				finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtfbtxxth.field('fbtxxth.finish_at').val(finish_at);
			});

			edtfbtxxth.on( 'close', function () {
				edtfbtxxth.enable();
			} );

			//start datatables
			tblfbtxxth = $('#tblfbtxxth').DataTable( {
				dom: domPQ,
				searchPanes:{
					layout: 'columns-4',
				},
				ajax: {
					url: "../../models/fbtxxth/fbtxxth.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_fbtxxth = show_deleted_fbtxxth;
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
						targets: [0,5,6,7]
					}
				],
				columns: [
					{ data: "fbtxxth.id",visible:false },
					{ data: "fbtxxth.tanggal" },
					{ data: "fbtxxth.kode" },
					{ data: "aakxxmh_asal.nama" },
					{ data: "aakxxmh_tujuan.nama" },
					{ 
						data: "fbtxxth.amount" ,
						render: $.fn.dataTable.render.number( ',', '.', 2,'','' ),
						class: "text-right"
					},
					{ data: "fbtxxth.keterangan" },
					{ 
						data: "fbtxxth.transaction_state" ,
						render: $.fn.dataTable.render.transactionStatus()
					}
				],
				buttons: [
					// BEGIN breaking generate button
					<?php
						$id_table    = 'id_fbtxxth';
						$table       = 'tblfbtxxth';
						$edt         = 'edtfbtxxth';
						$show_status = '_fbtxxth';
						$table_name  = $nama_tabel;

						$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
						$arr_buttons_tools2 	= ['sp', 'sb'];
						$arr_buttons_action 	= ['create', 'edit', 'remove', 'confirm', 'nonaktif_h', 'close', 'view', 'log','noaction'];
						$arr_buttons_approve 	= ['approve', 'cancel_approve', 'void','noapprove'];
						include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
					?>
					// END breaking generate button
					{
						text: '<i class="fa fa-print"></i>',
						name: 'btnPrint',
						className: 'btn btn-sm btn-outline',
						titleAttr: 'Print Voucher',
						action: function ( e, dt, node, config ) {
							e.preventDefault(); 
							var url = $(this).attr('href'); 
							window.open('fbtxxth_print.php?id_fbtxxth='+id_fbtxxth, '_blank');
						}
					}
				],
				initComplete: function() {
					this.api().searchPanes.rebuildPane();
				},
				rowCallback: function( row, data, index ) {
					if ( data.fbtxxth.transaction_state == -9 ) {
						$('td', row).addClass('text-danger');
					}else if ( data.fbtxxth.transaction_state == 0 ) {
						$('td', row).addClass('text-warning');
					}
				}
			} );

			tblfbtxxth.searchPanes.container().appendTo('#spfbtxxth');
			tblfbtxxth.searchBuilder.container().appendTo( '#sbfbtxxth' );
			
			tblfbtxxth.on( 'init', function () {
				// atur hak akses
				CekInitHeaderH(tblfbtxxth);
			} );
			
			tblfbtxxth.on( 'select', function( e, dt, type, indexes ) {
				fbtxxth_data    	= tblfbtxxth.row( { selected: true } ).data().fbtxxth;
				id_fbtxxth      	= fbtxxth_data.id;
				id_transaksi_h 		= id_fbtxxth; // dipakai untuk general
				id_transaksi_log	= id_fbtxxth; // dipakai untuk general
				transaction_state   = fbtxxth_data.transaction_state;
				approval_state   	= fbtxxth_data.approval_state;
				is_nextprocess 		= fbtxxth_data.is_nextprocess;
				is_jurnal      		= fbtxxth_data.is_jurnal;

				id_aakxxmh_asal_old = fbtxxth_data.id_aakxxmh_asal;
				id_aakxxmh_tujuan_old = fbtxxth_data.id_aakxxmh_tujuan;

				// atur hak akses
				CekSelectHeaderH(tblfbtxxth);
			} );

			tblfbtxxth.on( 'deselect', function () {
				// reload dipanggil di function CekDeselectHeader
				id_fbtxxth = 0;

				id_aakxxmh_asal_old = 0, id_aakxxmh_tujuan_old = 0;

				// atur hak akses
				CekDeselectHeaderH(tblfbtxxth);
			} );
			
		} );// end of document.ready
	
	</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
