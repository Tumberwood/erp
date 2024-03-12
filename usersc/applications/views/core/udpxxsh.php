<?php
    require_once '../../../../users/init.php';
    require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
?>

<?php
	$nama_tabel       = 'udpxxsh';
    $nama_tabels_d    = [];
    $nama_tabels_d[0] = 'udpbrsd';
    $nama_tabels_d[1] = 'ucudasd';
?>

<!-- begin content here -->

<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="table-responsive">
					<table id="tbludpxxsh" class="table table-striped table-bordered table-hover nowrap" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Akses Data</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

	<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 p-w-xs">
		<div class="ibox ">
			<div class="ibox-content">
				<div class="tabs-container">
					<ul class="nav nav-tabs" role="tablist">
						<li><a class="nav-link active" data-toggle="tab" href="#tabudpbrsd">Cabang</a></li>
						<li><a class="nav-link" data-toggle="tab" href="#tabucudasd"> CRUD</a></li>
					</ul>
					<div class="tab-content">
						<div role="tabpanel" id="tabudpbrsd" class="tab-pane active">
							<div class="panel-body">
								<table id="tbludpbrsd" class="table table-striped table-bordered table-hover" width="100%">
									<thead>
										<tr>
											<th>ID</th>
											<th>id_udpxxsh</th>
											<th>Cabang</th>
											<th>Keterangan</th>
										</tr>
									</thead>
								</table>
							</div>
						</div>
						<div role="tabpanel" id="tabucudasd" class="tab-pane">
							<div class="panel-body">
								<div class="table-responsive">
									<table id="tblucudasd" class="table table-striped table-bordered table-hover" width="100%">
										<thead>
											<tr>
												<th>ID</th>
												<th>id_udpxxsh</th>
												<th>Pages</th>
												<th>C</th>
												<th>U</th>
												<th>D</th>
												<th>A</th>
											</tr>
										</thead>
									</table>
								</div>
							</div>
						</div>
					</div> <!-- END of tab-content -->
				</div> <!-- END of tabs-container -->
			</div>
		</div>
	</div>

</div> <!-- end of row -->

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


<!-- BEGIN datatables here -->
<script type="text/javascript">
		// ------------- default variable, do not erase
		var edtudpxxsh, tbludpxxsh, show_deleted_udpxxsh = 0, id_udpxxsh;
		var edtudpbrsd, tbludpbrsd, show_deleted_udpbrsd = 0, udpbrsd;
        var edtucudasd, tblucudasd, show_deleted_ucudasd = 0, ucudasd;
		// ------------- end of default variable

        var id_gbrxxmh_old = 0;
        var id_users_old = 0;
        var id_users;
		
		$(document).ready(function() {
        
            // start header
			edtudpxxsh = new $.fn.dataTable.Editor( {
				ajax: {
					url: "../../models/core/udpxxsh.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_udpxxsh = show_deleted_udpxxsh;
					}
				},
				table: "#tbludpxxsh",
				fields: [ 
					{
						label: "udpxxsh.start_at",
						name: "udpxxsh.start_at",
						type: "hidden"
					},	
					{
						label: "udpxxsh.finish_at",
						name: "udpxxsh.finish_at",
						type: "hidden"
					},	
					{
						label: "nama_tabel",
						name: "nama_tabel",
						def: "udpxxsh",
						type: "hidden"
					},	
					{
						label: "udpxxsh.transaction_state",
						name: "udpxxsh.transaction_state",
                        type: "hidden",
						def: 0
					},	
					{
                        label: "Username",
						name: "udpxxsh.id_users",
                        type: "select2",
                        opts: {
                            placeholder : "Select",
                            allowClear: true,
                            multiple: false,
                            ajax: {
                                url: "../../models/core/users_fn_opt.php",
                                dataType: 'json',
                                data: function (params) {
                                    var query = {
                                        id_users_old: id_users_old,
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
						label: "Akses Data",
						name: "udpxxsh.data_permission",
						type: "select",
						def: 1,
						options: [
							{ "label": "Self", "value": 1 },
							{ "label": "All", "value": 0 }
						]
					},  
					{
						label: "Boleh Setting",
						name: "udpxxsh.is_setting",
						type: "select",
						def: 0,
						options: [
							{ "label": "Ya", "value": 1 },
                            { "label": "Tidak", "value": 0 }
						]
					}, 	
					{
						label: "Keterangan",
						name: "udpxxsh.keterangan",
						type: "textarea"
					}
				]
			} );
			
			edtudpxxsh.on( 'preOpen', function( e, mode, action ) {
				start_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtudpxxsh.field('udpxxsh.start_at').val(start_at);
				
				if (action == 'create'){
					tbludpxxsh.rows().deselect();
					edtudpxxsh.field('udpxxsh.id_users').enable();
				}else if(action == 'edit'){
                    edtudpxxsh.field('udpxxsh.id_users').disable();
				}
			});

            edtudpxxsh.on('initSubmit', function(e, action) {
				finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtudpxxsh.field('udpxxsh.finish_at').val(finish_at);
			});
			
			edtudpxxsh.on( 'postSubmit', function (e, json, data, action, xhr) {
				tbludpxxsh.ajax.reload(null,false);
				tblucudasd.ajax.reload(null,false);
				if(action == 'remove'){
					tbludpbrsd.ajax.reload(null,false);
				}
			} );
			
			edtudpxxsh.on( 'close', function () {
				edtudpxxsh.enable();
			} );

			tbludpxxsh = $('#tbludpxxsh').DataTable( {
				dom: domPQ,
				searchPanes:{
					layout: 'columns-2',
				},
				ajax: {
					url: "../../models/core/udpxxsh.php",
					type: 'POST',
					data: function (d){
						d.show_deleted_udpxxsh = show_deleted_udpxxsh;
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
						targets: [0,3]
					}
				],
				columns: [
					{ data: "udpxxsh.id",visible:false },
					{ data: "users.username" },
					{ 
						data: "udpxxsh.data_permission",
						render: function (data){
							if (data == 0){
								return 'All';
							}else if (data == 1){
								return 'Self';
							}else{
								return '';
							}
						}
					},
					{ data: "udpxxsh.keterangan" }
				],
				buttons: [
                    // BEGIN breaking generate button
					<?php
						$id_table    = 'id_udpxxsh';
						$table       = 'tbludpxxsh';
						$edt         = 'edtudpxxsh';
						$show_status = '_udpxxsh';
						$table_name  = $nama_tabel;

                        $arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
						$arr_buttons_tools2 	= ['sp', 'sb'];
						$arr_buttons_action 	= ['create', 'edit', 'remove_hd', 'nonaktif_hd', 'view', 'log','noaction'];
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

			tbludpxxsh.searchPanes.container().appendTo('#spudpxxsh');
			tbludpxxsh.searchBuilder.container().appendTo( '#sbudpxxsh' );

            tbludpxxsh.on( 'init', function () {
				// atur hak akses
				tbl_details = [tbludpbrsd, tblucudasd];
				CekInitHeaderHD(tbludpxxsh, tbl_details);

                tblucudasd.button( 'btnRefreshPages:name' ).disable();
			} );
			
			tbludpxxsh.on( 'select', function( e, dt, type, indexes ) {
                udpxxsh_data    	= tbludpxxsh.row( { selected: true } ).data().udpxxsh;
				id_udpxxsh      	= udpxxsh_data.id;
				id_transaksi_h 		= id_udpxxsh; // dipakai untuk general
				id_transaksi_log	= id_udpxxsh; // dipakai untuk general
				transaction_state   = udpxxsh_data.transaction_state;
				approval_state   	= udpxxsh_data.approval_state;
				is_nextprocess 		= udpxxsh_data.is_nextprocess;
				is_jurnal      		= udpxxsh_data.is_jurnal;

                id_users       = udpxxsh_data.id_users;
                id_users_old   = udpxxsh_data.id_users;
				
				// atur hak akses
				tbl_details = [tbludpbrsd, tblucudasd];
				CekSelectHeaderHD(tbludpxxsh, tbl_details);

                tblucudasd.button( 'btnRefreshPages:name' ).enable();

			} );
			
			tbludpxxsh.on( 'deselect', function () {
				// reload dipanggil di function CekDeselectHeader
				id_udpxxsh = 0;
                id_users = 0;
                id_users_old = 0;

				// atur hak akses
				tbl_details = [tbludpbrsd, tblucudasd];
				CekDeselectHeaderHD(tbludpxxsh, tbl_details);

                tblucudasd.button( 'btnRefreshPages:name' ).disable();
			} );

			
            // end header
			
            // start detail cabang
            edtudpbrsd = new $.fn.dataTable.Editor( {
                ajax: {
                    url: "../../models/core/udpbrsd.php",
                    type: 'POST',
                    data: function (d){
                        d.show_deleted_udpbrsd = show_deleted_udpbrsd;
                        d.id_udpxxsh = id_udpxxsh;
                    }
                },
                table: "#tbludpbrsd",
                fields: [ 
					{
						label: "udpbrsd.start_at",
						name: "udpbrsd.start_at",
						type: "hidden"
					},	
					{
						label: "udpbrsd.finish_at",
						name: "udpbrsd.finish_at",
						type: "hidden"
					},	
					{
						label: "nama_tabel",
						name: "nama_tabel",
						def: "udpbrsd",
						type: "hidden"
					},	
					{
						label: "udpbrsd.id_udpxxsh",
						name: "udpbrsd.id_udpxxsh",
                        type: "hidden"
					},
					{
						label: "udpbrsd.transaction_state",
						name: "udpbrsd.transaction_state",
                        type: "hidden",
						def: 0
					},

                    {
                        label: "Cabang",
                        name: "udpbrsd.id_gbrxxmh",
                        type: "select2",
                        opts: {
                            placeholder : "Select",
                            allowClear: true,
                            multiple: false,
                            ajax: {
                                url: "../../models/core/gbrxxmh_fn_opt.php",
                                dataType: 'json',
                                data: function (params) {
                                    var query = {
                                        id_gbrxxmh_old: id_gbrxxmh_old,
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
                        label: "Keterangan",
                        name: "udpbrsd.keterangan",
                        type: "textarea"
                    }
                ]
            } );
            
            edtudpbrsd.on( 'preOpen', function( e, mode, action ) {
                edtudpbrsd.field('udpbrsd.id_udpxxsh').val(id_udpxxsh);
                
                start_at = moment().format('YYYY-MM-DD HH:mm:ss');
                edtudpbrsd.field('udpbrsd.start_at').val(start_at);
                
                if (action == 'create'){
                    tbludpbrsd.rows().deselect();
                }
            });

            edtudpbrsd.on('initSubmit', function(e, action) {
				finish_at = moment().format('YYYY-MM-DD HH:mm:ss');
				edtudpbrsd.field('udpbrsd.finish_at').val(finish_at);
			});

			edtudpbrsd.on( 'close', function () {
				edtudpbrsd.enable();
			} );
            
            tbludpbrsd = $('#tbludpbrsd').DataTable( {
                ajax: {
                    url: "../../models/core/udpbrsd.php",
                    type: 'POST',
                    data: function (d){
                        d.show_deleted_udpbrsd = show_deleted_udpbrsd;
                        d.id_udpxxsh = id_udpxxsh;
                    }
                },
                order: [[ 1, "asc" ]],
                columns: [
                    { data: "udpbrsd.id",visible:false },
                    { data: "udpbrsd.id_udpxxsh",visible:false },
                    { data: "gbrxxmh.nama" },
                    { data: "udpbrsd.keterangan" }
                ],
                buttons: [
                    // BEGIN breaking generate button
					<?php
						$id_table    = 'id_udpbrsd';
						$table       = 'tbludpbrsd';
						$edt         = 'edtudpbrsd';
						$show_status = '_udpbrsd';
						$table_name  = $nama_tabels_d[0];

						$arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
						$arr_buttons_tools2 	= [];
						$arr_buttons_action 	= ['create', 'edit', 'remove', 'view', 'log','noactionD'];
						include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 

					?>
					// END breaking generate button
                ],
                rowCallback: function( row, data, index ) {
                }
            } );

            tbludpbrsd.on( 'draw', function( e, settings ) { 
				// atur hak akses
				cek_c_detail= 1;
				CekDrawDetailHD(tbludpxxsh, tbludpbrsd, 'udpbrsd' );
				CekDrawDetailHDFinal(tbludpxxsh);
			} );

			tbludpbrsd.on( 'select', function( e, dt, type, indexes ) {

				udpbrsd_data    	= tbludpbrsd.row( { selected: true } ).data().udpbrsd;
				id_udpbrsd      	= udpbrsd_data.id;
				id_gbrxxmh_old 		= udpbrsd_data.id_gbrxxmh;
				id_transaksi_d 		= id_udpbrsd; // dipakai untuk general
				id_transaksi_log	= id_udpbrsd; // dipakai untuk general

				// atur hak akses
				CekSelectDetailHD(tbludpxxsh, tbludpbrsd );
			} );

			tbludpbrsd.on( 'deselect', function() {
				// set variable on deselect
				id_udpbrsd  = '';
				id_gbrxxmh_old = 0;
				
				// atur hak akses
				CekDeselectDetailHD(tbludpxxsh, tbludpbrsd );
			} );

            
            // end detail cabang

            // start detail crud
            edtucudasd = new $.fn.dataTable.Editor( {
                ajax: {
                    url: "../../models/core/ucudasd.php",
                    type: 'POST',
                    data: function (d){
                        d.show_deleted_ucudasd = show_deleted_ucudasd;
                        d.id_udpxxsh = id_udpxxsh;
                    }
                },
                table: "#tblucudasd",
                fields: [ 
					{
						label: "ucudasd.start_at",
						name: "ucudasd.start_at",
						type: "hidden"
					},	
					{
						label: "ucudasd.finish_at",
						name: "ucudasd.finish_at",
						type: "hidden"
					},	
					{
						label: "nama_tabel",
						name: "nama_tabel",
						def: "ucudasd",
						type: "hidden"
					},	
					{
						label: "ucudasd.transaction_state",
						name: "ucudasd.transaction_state",
                        type: "hidden",
						def: 0
					},	
					{
						label: "ucudasd.id_udpxxsh",
						name: "ucudasd.id_udpxxsh",
                        type: "hidden"
					},

                    {
                        label: "Create",
                        name: "ucudasd.hak_c",
                        type: "select",
                        placeholder: "Pilih",
                        options: [
                            { "label": "Ya", "value": 1 },
                            { "label": "Tidak", "value": 0 }
                        ]
                    },	{
                        label: "Update",
                        name: "ucudasd.hak_u",
                        type: "select",
                        placeholder: "Pilih",
                        options: [
                            { "label": "Ya", "value": 1 },
                            { "label": "Tidak", "value": 0 }
                        ]
                    },	{
                        label: "Delete",
                        name: "ucudasd.hak_d",
                        type: "select",
                        placeholder: "Pilih",
                        options: [
                            { "label": "Ya", "value": 1 },
                            { "label": "Tidak", "value": 0 }
                        ]
                    },	{
                        label: "Approve",
                        name: "ucudasd.hak_a",
                        type: "select",
                        placeholder: "Pilih",
                        options: [
                            { "label": "Ya", "value": 1 },
                            { "label": "Tidak", "value": 0 }
                        ]
                    }
                ]
            } );
            
            edtucudasd.on( 'preOpen', function( e, mode, action ) {
                edtucudasd.field('ucudasd.id_udpxxsh').val(id_udpxxsh);
                
                start_at = moment().format('YYYY-MM-DD HH:mm:ss');
                edtucudasd.field('ucudasd.start_at').val(start_at);
                
                if (action == 'create'){
                    tblucudasd.rows().deselect();
                }
            });

            edtucudasd.on('initSubmit', function(e, action) {
				ucudasd = moment().format('YYYY-MM-DD HH:mm:ss');
				edtucudasd.field('ucudasd.ucudasd').val(ucudasd);
			});

			edtucudasd.on( 'close', function () {
				edtucudasd.enable();
			} );
            
            tblucudasd = $('#tblucudasd').DataTable( {
				dom: domPQ,
				searchPanes:{
					layout: 'columns-4',
				},
                ajax: {
                    url: "../../models/core/ucudasd.php",
                    type: 'POST',
                    data: function (d){
                        d.show_deleted_ucudasd = show_deleted_ucudasd;
                        d.id_udpxxsh = id_udpxxsh;
                    }
                },
                order: [[ 1, "asc" ]],
				columnDefs:[
					{
						searchPanes:{
							show: true,
						},
						targets: [3,4,5,6]
					},
					{
						searchPanes:{
							show: false,
						},
						targets: [0,1,2]
					}
				],
                columns: [
                    { data: "ucudasd.id",visible:false },
                    { data: "ucudasd.id_udpxxsh",visible:false },
                    { data: "pages.title"},
                    { 
                        data: "ucudasd.hak_c",
                        render: function (data){
                            if (data == 1){
                                return '<i class="fa fa-check text-navy"></i>';
                            }else if(data == 0){
                                return '<i class="fa fa-remove text-danger"></i>';
                            }
                        }
                    },
                    { 
                        data: "ucudasd.hak_u" ,
                        render: function (data){
                            if (data == 1){
                                return '<i class="fa fa-check text-navy"></i>';
                            }else if(data == 0){
                                return '<i class="fa fa-remove text-danger"></i>';
                            }
                        }
                    },
                    { 
                        data: "ucudasd.hak_d" ,
                        render: function (data){
                            if (data == 1){
                                return '<i class="fa fa-check text-navy"></i>';
                            }else if(data == 0){
                                return '<i class="fa fa-remove text-danger"></i>';
                            }
                        }
                    },
                    { 
                        data: "ucudasd.hak_a" ,
                        render: function (data){
                            if (data == 1){
                                return '<i class="fa fa-check text-navy"></i>';
                            }else if(data == 0){
                                return '<i class="fa fa-remove text-danger"></i>';
                            }
                        }
                    }
                ],
                buttons: [
                    // BEGIN breaking generate button
					<?php
						$id_table    = 'id_ucudasd';
						$table       = 'tblucudasd';
						$edt         = 'edtucudasd';
						$show_status = '_ucudasd';
						$table_name  = $nama_tabels_d[1];

                        $arr_buttons_tools 		= ['show_hide','copy','excel','colvis'];
						$arr_buttons_tools2 	= ['sp', 'sb'];
						$arr_buttons_action 	= ['create', 'edit', 'remove', 'view', 'log','noactionD'];
						include $abs_us_root.$us_url_root. 'usersc/helpers/button_fn_generate.php'; 
					?>
					// END breaking generate button

                    {
                        name: 'btnRefreshPages',
                        text: '<i class="fa fa-refresh"></i>',
                        className: 'btn btn-outline',
                        titleAttr: 'Recheck',
                        action: function ( e, dt, node, config ) {
                            $.ajax( {
                                url: '../../models/core/ucudasd_fn_generate.php',
                                dataType: 'json',
                                type: 'POST',
                                data: {
                                    id_udpxxsh: id_udpxxsh,
                                    id_users: id_users
                                },
                                success: function ( json ) {
                                    $.notify({
                                        message: json.message
                                    },{
                                        type: json.type_message
                                    });
                                    tblucudasd.ajax.reload(null,false);
                                }
                            } );
                        }
                    }
                    // END additional button

                ],
				initComplete: function() {
					this.api().searchPanes.rebuildPane();
				},
                rowCallback: function( row, data, index ) {
                }
            } );

			tblucudasd.searchPanes.container().appendTo('#spucudasd');
			tblucudasd.searchBuilder.container().appendTo( '#sbucudasd' );

            tblucudasd.on( 'draw', function( e, settings ) { 
				// atur hak akses
				cek_c_detail= 0;
				CekDrawDetailHD(tbludpxxsh, tblucudasd, 'ucudasd' );
				CekDrawDetailHDFinal(tbludpxxsh);
			} );

			tblucudasd.on( 'select', function( e, dt, type, indexes ) {
				ucudasd_data    	= tblucudasd.row( { selected: true } ).data().ucudasd;
				id_ucudasd      	= ucudasd_data.id;
				id_transaksi_d 		= id_ucudasd; // dipakai untuk general
				id_transaksi_log	= id_ucudasd; // dipakai untuk general
				
				// atur hak akses
				CekSelectDetailHD(tbludpxxsh, tblucudasd );
			} );

			tblucudasd.on( 'deselect', function() {
				id_ucudasd = '';
				
				// atur hak akses
				CekDeselectDetailHD(tbludpxxsh, tblucudasd );
			} );
            // end detail crud
			
		} );// end of document.ready
	
	</script>

<!-- END datatables here -->

<!-- end content here -->

<!-- do not erase -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
