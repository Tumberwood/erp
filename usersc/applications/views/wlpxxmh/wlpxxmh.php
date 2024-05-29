<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel    = 'wlpxxmh';
	$nama_tabels_d = [];
?>

<!-- begin content here -->
<div class="row">
	<div class="col">
		<div class="ibox">
			<div class="ibox-content">
				<div class="table-responsive">
                    <table id="tblwlpxxmh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>LPN</th>
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

<?php require_once $abs_us_root . $us_url_root . 'usersc/applications/views/wlpxxmh/fn/wlpxxmh_fn.php'; ?>

<!-- BEGIN javascript here -->
<script type="text/javascript">
	// ------------- default variable, do not erase
	var edtwlpxxmh, tblwlpxxmh, show_deleted_wlpxxmh = 0, id_wlpxxmh;
	// ------------- end of default variable

	var selectedIds;

	// get tableRelation
	tableRelation('wlpxxmh');
	
	$(document).ready(function() {
		// BEGIN wlpxxmh
		edtwlpxxmh = new $.fn.dataTable.Editor( {
			ajax: {
				url: "../../models/wlpxxmh/wlpxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_wlpxxmh = show_deleted_wlpxxmh;
				}
			},
			table: "#tblwlpxxmh",
			fields: [ 
				{
					label: "wlpxxmh.start_at",
					name: "wlpxxmh.start_at",
					type: "hidden"
				},	
				{
					label: "wlpxxmh.finish_at",
					name: "wlpxxmh.finish_at",
					type: "hidden"
				},	
				{
					label: "nama_tabel",
					name: "nama_tabel",
					def: "wlpxxmh",
					type: "hidden"
				},	
				{
					label: "wlpxxmh.transaction_state",
					name: "wlpxxmh.transaction_state",
					type: "hidden",
					def: 0
				},	
				{
					label: "LPN <sup class='text-danger'>*<sup>",
					name: "wlpxxmh.kode"
				}
			]
		} );

		edtwlpxxmh.on( 'preOpen', function( e, mode, action ) {
			start_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtwlpxxmh.field('wlpxxmh.start_at').val(start_at);
			
			if(action == 'create'){
				tblwlpxxmh.rows().deselect();
			}else if(action == 'edit'){
				
				if(transaction_state == 0){
					edtwlpxxmh.field('wlpxxmh.kode').enable();
				}else{
					edtwlpxxmh.field('wlpxxmh.kode').disable();
				}
			}
		});

		edtwlpxxmh.on("open", function (e, mode, action) {
			$(".modal-dialog").addClass("modal-lg");

			// enable disable tombol Save & Confirm
			edtFormButtonSaveConfirm();
		});

		edtwlpxxmh.on( 'preSubmit', function (e, data, action) {
			if(action != 'remove'){

				kode = edtwlpxxmh.field('wlpxxmh.kode').val();

				validasiRequired(
					edtwlpxxmh,
					'wlpxxmh',
					{
						'kode': kode
					}
				);

				validasiUnique(
					action,
					edtwlpxxmh,
					'wlpxxmh',
					'kode',
					'kode',
					'"'+kode+'"',
					id_wlpxxmh
				);


			}
			
			if ( edtwlpxxmh.inError() ) {
				return false;
			}
		});
		
		edtwlpxxmh.on('initSubmit', function(e, action) {
			finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
			edtwlpxxmh.field('wlpxxmh.finish_at').val(finish_at);
		});

		edtwlpxxmh.on( 'close', function () {
			edtwlpxxmh.enable();
		} );

		tblwlpxxmh = $('#tblwlpxxmh').DataTable( {
			dom: domPQ,
			searchPanes:{
				layout: 'columns-4',
			},
			ajax: {
				url: "../../models/wlpxxmh/wlpxxmh.php",
				type: 'POST',
				data: function (d){
					d.show_deleted_wlpxxmh = show_deleted_wlpxxmh;
				}
			},
			order: [[ 1, "asc" ]],
			columnDefs:[
				{
					searchPanes:{
						show: true,
					},
					targets: [1,2]
				},
				{
					searchPanes:{
						show: false,
					},
					targets: [0]
				}
			],
			columns: [
				{ data: "wlpxxmh.id",visible:false },
				{ data: "wlpxxmh.kode" },
				{ 
					data: "wlpxxmh.transaction_state" ,
					...renderTransactionStatus()
				}
			],
			buttons: [
				// BEGIN breaking generate button
				<?php
					$id_table    = 'id_wlpxxmh';
					$table       = 'tblwlpxxmh';
					$edt         = 'edtwlpxxmh';
					$show_status = '_wlpxxmh';
					$table_name  = $nama_tabel;

					$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
					$arr_buttons_tools2 	= ['sp', 'sb'];
					$arr_buttons_action 	= ['create', 'edit', 'remove', 'confirm', 'nonaktif_h', 'close', 'view', 'log','noaction'];
					include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
				?>
				// END breaking generate button
				{
					text: '<i class="fa fa-google"></i>',
					name: 'btnCustom',
					className: 'btn btn-outline',
					titleAttr: 'Generate LPN',
					action: function ( e, dt, node, config ) {
						// e.preventDefault();
						var lpnJumlah = prompt("Generate Berapa LPN?", 1);
						console.log(lpnJumlah);
						if( typeof parseInt(lpnJumlah) === "number" && parseInt(lpnJumlah) > 0 ){
							console.log(1);
							$.ajax( {
								url: "../../models/wlpxxmh/wlpxxmh_fn_generate.php",
								dataType: 'json',
								type: 'POST',
								data: {
									lpnJumlah: parseInt(lpnJumlah)
								},
								success: function ( json ) {
									full_message = '';
									status_code  = json.data.status_code;
									full_message = full_message + json.data.message + '</br>';
									toast_type   = json.data.type_message;
									toastr[toast_type](full_message, 'INFO');
									tblwlpxxmh.ajax.reload(null, false);
								}
							} );
						}
						
					}
				},
				{
					text: '<i class="fa fa-print"></i>',
					name: 'btnPrint',
					className: 'btn btn-outline',
					titleAttr: 'Print Quotation',
					action: function ( e, dt, node, config ) {
						e.preventDefault();
						var queryString = selectedIds.join(',');
						var url = $(this).attr('href'); 
						window.open('wlpxxmh_print.php?ids_wlpxxmh='+queryString, '_blank');
					}
				},
			],
			initComplete: function() {
				this.api().searchPanes.rebuildPane();
			},
			rowCallback: function( row, data, index ) {
				if ( data.wlpxxmh.transaction_state == -9 ) {
					$('td', row).addClass('text-danger');
				}else if ( data.wlpxxmh.transaction_state == 0 ) {
					$('td', row).addClass('text-warning');
				}
			}
		} );

		tblwlpxxmh.searchPanes.container().appendTo('#spwlpxxmh');
		tblwlpxxmh.searchBuilder.container().appendTo( '#sbwlpxxmh' );
		
		tblwlpxxmh.on( 'init', function () {
			// atur hak akses
			CekInitHeaderH(tblwlpxxmh);
		} );
		
		tblwlpxxmh.on( 'select', function( e, dt, type, indexes ) {
			// set variable standar framework
			siVarSet('wlpxxmh');
			
			// ids_wlpxxmh = tblwlpxxmh.rows( {selected: true} ).data().length;
			selectedIds = getSelectedRowIds();
			console.log('Selected IDs:', selectedIds);

			// console.log(ids_wlpxxmh);

			// atur hak akses
			CekSelectHeaderH(tblwlpxxmh);
		} );

		tblwlpxxmh.on( 'deselect', function () {
			// reset variable standar framework
			siVarReset('wlpxxmh');

			var selectedIds = getSelectedRowIds();
    		console.log('Selected IDs after deselect:', selectedIds);

			// atur hak akses
			CekDeselectHeaderH(tblwlpxxmh);
		} );
		
		// END wlpxxmh
		
	} );// end of document.ready

</script>

<!-- END javascript here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
