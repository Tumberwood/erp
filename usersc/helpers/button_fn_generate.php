<?php
/**
 * +----------------------------+-------------------------------------------------------------------------------------------+
 * | Button                     | Fungsi                                                                                    |
 * +----------------------------+-------------------------------------------------------------------------------------------+
 * | btnSetTools                |                                                                                           |
 * |    btnCopy:name            | Copy ke clipboard                                                                         |
 * |    btnExcel:name           | Export ke Excel                                                                           |
 * |    btnPdf:name             | Export ke pdf                                                                             |
 * |    btnShowHide:name        | Show Hide Deleted Data                                                                    |
 * |    btnColVis:name          | Show Hide Kolom                                                                           |
 * |                            |                                                                                           |
 * | btnSetAction               |                                                                                           |
 * |    btnCreate:name          | Add Data, transaction_status = 0                                                          |
 * |    btnEdit:name            | Edit Data, transaction_status = 0                                                         |
 * |    btnRemove:name          | Remove Data (Hard Delete), hanya bisa dilakukan jika transaction_status = 0               |
 * |    btnConfirm:name         | Konfirmasi Data, transaction_status = 1                                                   |
 * |    btnNonAktif:name        | Non Aktif Data, transaction_status = -9, hanya bisa dilakikan jika transaction_status = 1 |
 * |    btnClose:name           | Menyatakan transaksi sudah close. . Sudah tidak dapat diapa-apakah lagi                   |
 * |    btnView:name            | View Data, technically ini menggunakan fitur edit, hanya di readonly                      |
 * |    btnLog:name             | View Log Data, history terkait data dari table activity_log_ml                            |
 * |                            |                                                                                           |
 * | btnSetApproval             |                                                                                           |
 * |    btnApprove:name         | Approval, approval_state = 1, masih bisa di cancel Approve jika belum Next Process        |
 * |    btnVoid:name            | Void, approval_state = -9. Sudah tidak dapat diapa-apakah lagi                            |
 * +----------------------------+-------------------------------------------------------------------------------------------+
 */

    /*
        230629 - 3.1.0
            Mengubah button menjadi 3 set
                btnSetTools       : terkait tools table
                btnSetAction      : terkait action transaksi
                btnSetApproval    : terkait approval

            untuk membuat setButton:
            if(count($arr_buttons_setName) > 0){
                {
                    extend: 'collection',
                    name: 'btnSetName',
                    text: '<span class="fa fa-wrench">',
                    className: 'btn btn-sm',
                    autoClose: true,
                    buttons: [
                        berisi button-button yang ada
                        foreach ($arr_buttons_tools as $value) {
                            if($value == 'btnName'){

                            }
                        }
                    ]
                }
            }
        230121 - 3.0.1
            Memisahkan tombol tools sehingga bisa lebih flexible lagi
            
        221205 - 3.0.0
            Standarisasi Nama Table Baru

        220827 - 2.0.0
            Menambahkan atribut 'name' pada button, sehingga button bisa di skip urutannya, tidak perlu menggunakan index.
            Default button name:
            set button tools
                table.button( 'btnSetTools:name' );
                    table.button( 'btnCopy:name' );
                    table.button( 'btnExcel:name' );
                    table.button( 'btnPdf:name' );
                    table.button( 'btnShowHide:name' );
                    table.button( 'btnColVis:name' );
                
            set button action
                table.button( 'btnSetAction:name' );
                    table.button( 'btnCreate:name' );
                    table.button( 'btnConfirm:name' );
                    table.button( 'btnEdit:name' );
                    table.button( 'btnRemove:name' );
                    table.button( 'btnNonAktif:name' );
                    table.button( 'btnView:name' );
                    table.button( 'btnLog:name' );

            set button approval
                table.button( 'btnSetApprove:name' );
                    table.button( 'btnApprove:name' );
                    table.button( 'btnVoid:name' );

        Kegunaan:
            - Untuk generate default button pada datatables
		
        Parameter:
		    $id_transaksi = 'id_' . $nama_tabel;
            $table    = 'tbl'. $nama_tabel;
            $edt      = 'edt'. $nama_tabel;
    */
?>

<?php
    // BEGIN IF $arr_buttons_tools
    if(count($arr_buttons_tools) > 0){

        // BEGIN btnSetTools
?>      
        {
            extend: 'collection',
            name: 'btnSetTools',
            text: '<i class="fa fa-wrench"></i>',
            titleAttr: 'Tools',
            className: 'btn btn-sm btn-outline',
            autoClose: true,
            buttons: [
<?php     
                // BEGIN foreach arr_buttons_tools
                foreach ($arr_buttons_tools as $value) {
?>

<?php
                    // BEGIN button show_hide
                    if($value == 'show_hide'){
?>
                        {
                            text: '<i class="fa fa-adjust" id="bf_active_status"></i>&nbsp;Show / Hide Deleted',
                            name: 'btnShowHide', 
                            className: 'btn btn-sm',
                            titleAttr: 'Show / Hide Deleted',
                            action: function ( e, dt, node, config, tbl_details ) {
                                
                                if (show_deleted_<?php echo $table_name;?> == 0){
                                    $('#bf_active_status').addClass('text-danger');
                                    show_deleted_<?php echo $table_name;?> = 1;
                                } else if (show_deleted_<?php echo $table_name;?> == 1){
                                    $('#bf_active_status').removeClass('text-danger');
                                    show_deleted_<?php echo $table_name;?> = 0;
                                }

                                <?php echo $table;?>.rows().deselect();
                                <?php echo $table;?>.ajax.reload(null,false);

                            }
                        },
<?php
                    }
                    // END button show_hide
?>

<?php
                    // BEGIN button excel
                    if($value == 'excel'){
?>
                        { 
                            extend: "excel",
                            name: 'btnExcel', 
                            text: '<i class="fa fa-file-excel-o"></i>&nbsp;Excel',
                            className: 'btn btn-sm',
                            titleAttr: 'Export to Excel',
                            exportOptions: {
                                columns: ':visible'
                            }
                        },
<?php
                    }
                    // END button excel
?>

<?php
                    // BEGIN button pdf
                    if($value == 'pdf'){
?>
                        { 
                            extend: "pdf", 
                            name: 'btnPdf',
                            text: '<i class="fa fa-file-pdf-o"></i>&nbsp;pdf',
                            className: 'btn btn-sm',
                            titleAttr: 'Export to pdf',
                            exportOptions: {
                                columns: ':visible'
                            }
                        },
<?php
                    }
                    // END button pdf
?>

<?php
                    // BEGIN button copy
                    if($value == 'copy'){
?>
                        { 
                            extend: "copy", 
                            name: 'btnCopy',
                            text: '<i class="fa fa-copy"></i>&nbsp;Copy',
                            className: 'btn btn-sm',
                            titleAttr: 'Copy',
                            exportOptions: {
                                columns: ':visible'
                            }
                        },
<?php
                    }
                    // END button copy
?>

<?php
                    // BEGIN button colvis
                    if($value == 'colvis'){
?>
                        { 
                            extend: 'colvis',
                            text: '<i class="fa fa-eye-slash"></i>&nbsp;Show / Hide Column',
                            name: 'btnColVis',
                            className: 'btn btn-sm',
                            titleAttr: 'Show / Hide Column',
                            columns: colvisCount,
                            columnText: function ( dt, idx, title ) {
                                return title;
                            }
                        },
<?php
                    }
                    // END button colvis
?>

<?php
                }
                // END of foreach arr_buttons_tools
?>
            ]  
        },
<?php        
        // END btnSetTools
    }   
    // END IF $arr_buttons_tools
?> 

<?php
    // BEGIN IF $arr_buttons_tools2
    if(count($arr_buttons_tools2) > 0){
        foreach ($arr_buttons_tools2 as $value) {
        // BEGIN btnSetTools2
?>

<?php
                    // BEGIN button sp
                    if($value == 'sp'){
?>
                        { 
                            text: '&nbsp;<i class="fa fa-filter"></i>&nbsp;',
                            name: 'btnSP',
                            className: 'btn btn-sm btn-outline',
                            titleAttr: 'Filter',
                            action: function (e, dt, button, config) {
                                $('#modalP<?php echo $table_name; ?>').modal('show');
                            }
                        },
<?php
                    }   // END button sp
?>

<?php
    // BEGIN button SB
                    if($value == 'sb'){
?>
                        { 
                            text: '&nbsp;<i class="fa fa-search"></i>&nbsp;',
                            name: 'btnSB',
                            className: 'btn btn-sm btn-outline',
                            titleAttr: 'Search',
                            action: function (e, dt, button, config) {
                                $('#modalQ<?php echo $table_name; ?>').modal('show');
                            }
                        },
<?php
                    }   // END button sb
?>

<?php       
        }
        // END btnSetTools2
    }   
    // END IF $arr_buttons_tools2
?> 

<?php
    // BEGIN IF $arr_buttons_tools
    if(count($arr_buttons_action) > 0){
        // BEGIN btnSetAction
?>
        {
            extend: 'collection',
            name: 'btnSetAction',
            text: '<i class="fa fa-th-list"></i>', 
            titleAttr: 'Actions',
            className: 'btn btn-sm btn-outline',
            autoClose: true,
            buttons: [
<?php
                // BEGIN foreach arr_buttons_action
                foreach ($arr_buttons_action as $value) {
?>

<?php
                    // BEGIN button create
                    if($value == 'create'){
?>
                        { 
                            extend: 'create',
                            name: 'btnCreate', 
                            editor: <?php echo $edt;?>, 
                            text: '<i class="fa fa-plus"></i>&nbsp;Add New', 
                            className: 'btn btn-sm', 
                            titleAttr: 'Add New'
                        },
<?php
                    }
                    // END button create
?>

<?php
                    // BEGIN button confirm
                    if($value == 'confirm'){
?>
                        { 
                            text: '<i class="fa fa-save"></i>&nbsp;Confirm',
                            name: 'btnConfirm',
                            className: 'btn btn-sm',
                            titleAttr: 'Confirm',
                            action: function ( e, dt, node, config ) {

                                // jika draft akan dikonfirmasi
                                message_transaction_state = "Apakah Anda Yakin Akan Konfimasi Data?";
                                
                                is_confirmed = confirm(message_transaction_state);
                                if(is_confirmed == true){
                                    full_message = '';
                                    $.ajax( {
                                        url: '../../../helpers/tr_fn_transaction_state.php',
                                        dataType: 'json',
                                        type: 'POST',
                                        data: {
                                            table_name       : '<?php echo $table_name;?>',
                                            id_transaksi     : id_transaksi_h,
                                            transaction_state: 1
                                        },
                                        success: function ( json ) {
                                            status_code  = json.data.status_code;
                                            full_message = full_message + json.data.message + '</br>';
                                            toast_type   = json.data.type_message;

                                            if(status_code == 200){
                                                console.log('200');
                                                if(is_need_generate_kode == 1){
                                                    $.ajax( {
                                                        url: '../../../helpers/kode_fn_generate_confirm.php',
                                                        dataType: 'json',
                                                        type: 'POST',
                                                        async: false,
                                                        data: {
                                                            state                   : 1,
                                                            nama_tabel              : '<?php echo $table_name;?>',
                                                            kategori_dokumen        : kategori_dokumen,
                                                            kategori_dokumen_value  : kategori_dokumen_value,
                                                            id_transaksi            : id_transaksi_h
                                                        },
                                                        success: function ( json ) {
                                                            toast_type   = json.data.type_message;
                                                            full_message = full_message + json.data.message + '</br>';
                                                        }
                                                    } );

                                                }

                                                if(is_need_inventory == 1){
                                                    $.ajax( {
                                                        url: '../../models/'+ "<?php echo $table_name . '/' . $table_name;?>" +'_iv.php',
                                                        dataType: 'json',
                                                        type: 'POST',
                                                        //async: false,
                                                        data: {
                                                            state           : 1,
                                                            id_transaksi_h  : id_transaksi_h,
                                                        },
                                                        success: function ( json ) {
                                                            toast_type = json.data.type_message;
                                                            full_message = full_message + json.data.message + '</br>';
                                                        }
                                                    } );
                                                }

                                                if(is_need_jurnal == 1){
                                                    $.ajax( {
                                                        url: '../../models/'+ "<?php echo $table_name . '/' . $table_name;?>" +'_jv.php',
                                                        dataType: 'json',
                                                        type: 'POST',
                                                        async: false,
                                                        data: {
                                                            state           : 1,
                                                            id_transaksi_h  : id_transaksi_h,
                                                        },
                                                        success: function ( json ) {
                                                            toast_type = json.data.type_message;
                                                            full_message = full_message + json.data.message + '</br>';
                                                        }
                                                    } );
                                                }

                                                <?php 
                                                    if(file_exists("../../models/" . $table_name . '/' . $table_name . "_post_confirm.php")) {
                                                ?>
                                                    $.ajax( {
                                                        url: '../../models/'+ "<?php echo $table_name . '/' . $table_name;?>" +'_post_confirm.php',
                                                        dataType: 'json',
                                                        type: 'POST',
                                                        async: false,
                                                        data: {
                                                            state           : 1,
                                                            id_transaksi_h  : id_transaksi_h
                                                        },
                                                        success: function ( json ) {
                                                            toast_type = json.data.type_message;
                                                            full_message = full_message + json.data.message + '</br>';
                                                        }
                                                    } );
                                                <?php
                                                    }
                                                ?>
                                            }else{
                                                console.log('no');
                                            }
                                            
                                            toastr[toast_type](full_message, 'INFO');
                                            
                                            <?php echo $table;?>.ajax.reload(null, false);

                                        }

                                    } );                                    

                                }

                            }
                        },
<?php
                    }
                    // END button confirm
?>

<?php
                    // BEGIN  button edit
                    if($value == 'edit'){
?>
                        { 
                            extend: 'edit', 
                            name: 'btnEdit', 
                            editor: <?php echo $edt;?>,
                            text: '<i class="fa fa-edit"></i>&nbsp;Edit',
                            className: 'btn btn-sm',
                            titleAttr: 'Edit'
                        },
<?php
                    }
                    // END button edit
?>

<?php
                    // BEGIN button remove
                    if($value == 'remove'){
?>
                        {
                            extend: 'remove', 
                            name: 'btnRemove',
                            editor: <?php echo $edt;?>, 
                            text: '<i class="fa fa-trash"></i>&nbsp;Delete(xH)',
                            className: 'btn btn-sm text-danger',
                            titleAttr: 'Remove'
                        },
<?php
                    }
                    // END button remove
?>

<?php
                    // BEGIN button close
                    if($value == 'close'){
?>
                        { 
                            text: '<i class="fa fa-window-close"></i>&nbsp;Close',
                            name: 'btnClose',
                            className: 'btn btn-sm text-warning',
                            titleAttr: 'Confirm',
                            action: function ( e, dt, node, config ) {

                                // jika draft akan dikonfirmasi
                                message_transaction_state = "Apakah Anda Yakin Akan Menutup Data?";
                                
                                is_close = confirm(message_transaction_state);
                                if(is_close == true){

                                    $.ajax( {
                                        url: '../../../helpers/tr_fn_transaction_state.php',
                                        dataType: 'json',
                                        type: 'POST',
                                        data: {
                                            table_name	 : '<?php echo $table_name;?>',
                                            id_transaksi : id_transaksi_h,
                                            transaction_state : 9
                                        },
                                        success: function ( json ) {
                                            toast_type   = json.data.type_message;
                                            full_message = json.data.message;
                                            toastr[toast_type](full_message, 'INFO');
                                        }
                                    } );

                                    <?php echo $table;?>.ajax.reload(null, false);

                                }

                            }
                        },
<?php
                    }
                    // END button close
?>

<?php
                    // BEGIN button view
                    if($value == 'view'){
?>
                        {
                            extend: "selected",
                            name: 'btnView',
                            text: '<i class="fa fa-window-maximize"></i>&nbsp;View Data',
                            className: 'btn btn-sm',
                            titleAttr: 'View Data',
                            action: function(e, dt, node, config) {
                                <?php echo $edt;?>.edit(<?php echo $table;?>.row({
                                    selected: true
                                }).index(), {
                                    title: 'View'
                                }).buttons("");
                                <?php echo $edt;?>.disable();
                                e.preventDefault();
                            }
                        },
<?php
                    }
                    // END button view
?>

<?php
                    // BEGIN button log
                    if($value == 'log'){
?>
                        {
                            extend: "selected",
                            name: 'btnLog',
                            text: '<i class="fa fa-history"></i>&nbsp;View Log',
                            className: 'btn btn-sm',
                            titleAttr: 'View Data Log',
                            action: function(e, dt, node, config) {
                                e.preventDefault();
                                $("#mdlLog").modal("show");

                                $.ajax({
                                    url: '../../../helpers/fn_log_view.php',
                                    dataType: 'json',
                                    type: 'POST',
                                    async: false,
                                    data: {
                                        table_name	 : '<?php echo $table_name;?>',
                                        id_transaksi : id_transaksi_log,
                                    },
                                    success: function(json) {
                                        str_log = '';
                                        log_data = json.data.rs_activity_log_ml;
                                        $.each(log_data, function(index, value) {
                                            
                                            switch(log_data[index].kode) {
                                                case 'CREATE':
                                                    badgeClass = 'warning';
                                                    break;
                                                case 'EDIT':
                                                    badgeClass = 'info';
                                                    break;
                                                case 'DELETE':
                                                    badgeClass = 'danger';
                                                    break;
                                                case 'CONFIRM':
                                                    badgeClass = 'primary';
                                                    break;
                                                case 'CLOSE':
                                                    badgeClass = 'danger';
                                                    break;
                                                case 'APPROVE':
                                                    badgeClass = 'primary';
                                                    break;
                                                case 'VOID':
                                                    badgeClass = 'danger';
                                                    break;
                                                case 'INVALID CODE':
                                                    badgeClass = 'warning';
                                                    break;
                                                default:
                                                    badgeClass = 'plain';
                                            }

                                            str_log =   str_log + 
                                                        '<span class=\"badge badge-' + 
                                                        badgeClass + '\">' + 
                                                        log_data[index].kode + 
                                                        '</span> by ' + 
                                                        log_data[index].username + 
                                                        ' at ' + 
                                                        log_data[index].created_on + 
                                                        '</br>';
                                        });
                                        $("#contentLog").html(str_log);
                                    }
                                });
                            }
                        },
<?php
                    }
                    // END button log
?>

<?php
                    // BEGIN button log detail
                    if($value == 'log_d'){
?>
                        {
                            extend: "selected",
                            name: 'btnLog',
                            text: '<i class="fa fa-history"></i>&nbsp;View Log',
                            className: 'btn btn-sm',
                            titleAttr: 'View Data Log',
                            action: function(e, dt, node, config) {
                                e.preventDefault();
                                $("#mdlLog").modal("show");

                                $.ajax({
                                    url: '../../../helpers/fn_log_view.php',
                                    dataType: 'json',
                                    type: 'POST',
                                    async: false,
                                    data: {
                                        table_name	 : '<?php echo $table_name;?>',
                                        id_transaksi : id_transaksi_log_d,
                                    },
                                    success: function(json) {
                                        str_log = '';
                                        log_data = json.data.rs_activity_log_ml;
                                        $.each(log_data, function(index, value) {
                                            
                                            switch(log_data[index].kode) {
                                                case 'CREATE':
                                                    badgeClass = 'warning';
                                                    break;
                                                case 'EDIT':
                                                    badgeClass = 'info';
                                                    break;
                                                case 'DELETE':
                                                    badgeClass = 'danger';
                                                    break;
                                                case 'CONFIRM':
                                                    badgeClass = 'primary';
                                                    break;
                                                case 'CLOSE':
                                                    badgeClass = 'danger';
                                                    break;
                                                case 'APPROVE':
                                                    badgeClass = 'primary';
                                                    break;
                                                case 'VOID':
                                                    badgeClass = 'danger';
                                                    break;
                                                case 'INVALID CODE':
                                                    badgeClass = 'warning';
                                                    break;
                                                default:
                                                    badgeClass = 'plain';
                                            }

                                            str_log =   str_log + 
                                                        '<span class=\"badge badge-' + 
                                                        badgeClass + '\">' + 
                                                        log_data[index].kode + 
                                                        '</span> by ' + 
                                                        log_data[index].username + 
                                                        ' at ' + 
                                                        log_data[index].created_on + 
                                                        '</br>';
                                        });
                                        $("#contentLog").html(str_log);
                                    }
                                });
                            }
                        },
<?php
                    }
                    // END button log
?>

<?php
                    // BEGIN button nonaktif_h
                    if($value == 'nonaktif_h'){
?>
                        { 
                            text: '<i class="fa fa-trash"></i>&nbsp;Delete(H)',
                            name: 'btnNonAktif',
                            className: 'btn btn-sm text-danger',
                            titleAttr: 'Remove',
                            action: function ( e, dt, node, config ) {
                                
                                message_is_delete = "Apakah Anda Yakin Akan Menghapus Data? xxx";
                                is_delete = confirm(message_is_delete);

                                if(is_delete == true){
                                    $.ajax( {
                                        url: '../../../helpers/tr_fn_transaction_state.php',
                                        dataType: 'json',
                                        type: 'POST',
                                        data: {
                                            table_name	 : '<?php echo $table_name;?>',
                                            id_transaksi : id_transaksi_h,
                                            transaction_state : -9
                                        },
                                        success: function ( json ) {
                                            full_message = json.data.message;
                                            toast_type   = json.data.type_message;
                                            toastr[toast_type](full_message, 'INFO');
                                            
                                            <?php echo $table;?>.ajax.reload(null, false);
                                            <?php echo $table;?>.rows().deselect();
                                        }
                                    } );
                                }

                            }
                        },
<?php
                    }
                    // END button nonaktif_h
?>

<?php
                    // BEGIN button remove_hd
                    if($value == 'remove_hd'){
?>
                        { 
                            text: '<i class="fa fa-trash"></i>&nbsp;Delete (xHD)',
                            name: 'btnRemoveHD',
                            className: 'btn btn-sm text-danger',
                            titleAttr: 'Remove',
                            action: function ( e, dt, node, config ) {
                                
                                message_is_delete = "Apakah Anda Yakin Akan Menghapus Data?";
                                is_delete = confirm(message_is_delete);

                                if(is_delete == true){
                                    $.ajax( {
                                        url: '../../../helpers/tr_fn_transaction_state.php',
                                        dataType: 'json',
                                        type: 'POST',
                                        data: {
                                            table_name	        : '<?php echo $table_name;?>',
                                            id_transaksi        : id_transaksi_h,
                                            transaction_state   : -93
                                        },
                                        success: function ( json ) {
                                            
                                            toast_type   = json.data.type_message;
                                            full_message = json.data.message;
                                            toastr[toast_type](full_message, 'INFO');
                                            
                                            <?php echo $table;?>.ajax.reload(null, false);
                                            <?php echo $table;?>.rows().deselect();

                                        }
                                    } );
                                }

                            }
                        },
<?php
                    }
                    // END button remove_hd
?>

<?php
                    // BEGIN button nonaktif_hd
                    if($value == 'nonaktif_hd'){
?>
                        { 
                            text: '<i class="fa fa-trash"></i>&nbsp;Delete (HD)',
                            name: 'btnNonAktifHD',
                            className: 'btn btn-sm text-danger',
                            titleAttr: 'Remove',
                            action: function ( e, dt, node, config ) {
                                
                                message_is_delete = "Apakah Anda Yakin Akan Menghapus Data?";
                                is_delete = confirm(message_is_delete);

                                if(is_delete == true){
                                    $.ajax( {
                                        url: '../../../helpers/tr_fn_transaction_state.php',
                                        dataType: 'json',
                                        type: 'POST',
                                        data: {
                                            table_name	        : '<?php echo $table_name;?>',
                                            id_transaksi        : id_transaksi_h,
                                            transaction_state   : -92
                                        },
                                        success: function ( json ) {
                    
                                            toast_type   = json.data.type_message;
                                            full_message = json.data.message;
                                            toastr[toast_type](full_message, 'INFO');
                                            
                                            <?php echo $table;?>.ajax.reload(null, false);
                                            <?php echo $table;?>.rows().deselect();

                                        }
                                    } );
                                }

                            }
                        },
<?php
                    }
                    // END button nonaktif_hd
?>

<?php
                    // BEGIN button noAction
                    if($value == 'noaction'){
?>
                        {
                            text: 'No Action Needed', 
                            name: 'btnNoAction',
                            className: 'btn btn-sm text-muted',
                            titleAttr: 'No Action Needed',
                            action: function () {}
                        },
<?php
                    }
                    // END button noaction
?>

<?php
                    // BEGIN button noAction
                    if($value == 'noactionD'){
?>
                        {
                            text: 'No Action Needed', 
                            name: 'btnNoActionD',
                            className: 'btn btn-sm text-muted',
                            titleAttr: 'No Action Needed',
                            action: function () {}
                        },
<?php
                    }
                    // END button noaction
?>

<?php
                }   
                // END foreach arr_buttons_action
?>

            ]
        },  
        
<?php
        // END btnSetAction
    }   
    // END IF $arr_buttons_action
?> 

<?php
    // BEGIN IF arr_buttons_approve
    if(count($arr_buttons_approve) > 0){
        // BEGIN btnSetApprove
?>
                {
                    extend: 'collection',
                    name: 'btnSetApprove',
                    text: '<span class="fa fa-check"></span>',
                    titleAttr: 'Approval',
                    className: 'btn btn-sm btn-outline',
                    autoClose: true,
                    buttons: [
<?php
                        // BEGIN foreach arr_buttons_approve
                        foreach ($arr_buttons_approve as $value) {
?>
<?php
                            // BEGIN button approve
                            if($value == 'approve'){
?>
                                { 
                                    text: '<i class="fa fa-check"></i>&nbsp;Approve',
                                    name: 'btnApprove',
                                    className: 'btn btn-sm text-navy',
                                    titleAttr: 'Approve',
                                    action: function ( e, dt, node, config ) {

                                        $.ajax( {
                                            url: '../../../helpers/tr_fn_approve.php',
                                            dataType: 'json',
                                            type: 'POST',
                                            data: {
                                                approval_state : 1,
                                                table_name: '<?php echo $table_name;?>',
                                                id_transaksi: id_transaksi_h,
                                            },
                                            success: function ( json ) {

                                                $('#notifToast').toast('show');
                                                $('#toastMessage').html(json.data.message);
                                                $('#toastHeader' ).addClass( 'bg-' + json.data.type_message);
                                                setTimeout(function() { 
                                                    $('#notifToast').toast('hide');
                                                }, 3000);
                                                
                                                if(is_need_inventory == 1){
                                                    $.ajax( {
                                                        url: '../../../helpers/fn_inventory_r.php',
                                                        dataType: 'json',
                                                        type: 'POST',
                                                        data: {
                                                            state          : 1,
                                                            id_transaksi_h : id_transaksi_h,
                                                            imtxxmh_kode   : imtxxmh_kode
                                                        },
                                                        success: function ( json ) {
                                                            console.log('Inventory');
                                                        }
                                                    } );
                                                }

                                                if(is_need_jurnal == 1){
                                                    $.ajax( {
                                                        url: '../../models/'+ "<?php echo $table_name . '/' . $table_name;?>" +'_jv.php',
                                                        dataType: 'json',
                                                        type: 'POST',
                                                        data: {
                                                            state           : 1,
                                                            id_transaksi_h  : id_transaksi_h,
                                                        },
                                                        success: function ( json ) {
                                                            console.log('Jurnal');
                                                        }
                                                    } );
                                                }
                                                
                                                <?php 
                                                    if(file_exists("../../models/" . $table_name . '/' . $table_name . "_post_approve.php")) {
                                                ?>
                                                    $.ajax( {
                                                        url: '../../models/'+ "<?php echo $table_name . '/' . $table_name;?>" +'_post_approve.php',
                                                        dataType: 'json',
                                                        type: 'POST',
                                                        data: {
                                                            state           : 1,
                                                            id_transaksi_h  : id_transaksi_h
                                                        },
                                                        success: function ( json ) {
                                                            $('#notifToast').toast('show');
                                                            $('#toastMessage').html(json.data.message);
                                                            $('#toastHeader' ).addClass( 'bg-' + json.data.type_message);
                                                            setTimeout(function() { 
                                                                $('#notifToast').toast('hide');
                                                            }, 3000);
                                                        }
                                                    } );
                                                <?php
                                                    }
                                                ?>

                                                <?php echo $table;?>.ajax.reload(null, false);

                                            }
                                        });
                                    }
                                },
<?php
                            }
                            // END button approve
?>

<?php
                            // BEGIN button cancel_approve
                            if($value == 'cancel_approve'){
?>
                                { 
                                    text: '<i class="fa fa-undo"></i>&nbsp;Cancel Approve',
                                    name: 'btnCancelApprove',
                                    className: 'btn btn-sm',
                                    titleAttr: 'Approve',
                                    action: function ( e, dt, node, config ) {

                                        $.ajax( {
                                            url: '../../../helpers/tr_fn_approve.php',
                                            dataType: 'json',
                                            type: 'POST',
                                            data: {
                                                approval_state : -1,
                                                table_name: '<?php echo $table_name;?>',
                                                id_transaksi: id_transaksi_h,
                                            },
                                            success: function ( json ) {

                                                $('#notifToast').toast('show');
                                                $('#toastMessage').html(json.data.message);
                                                $('#toastHeader' ).addClass( 'bg-' + json.data.type_message);
                                                setTimeout(function() { 
                                                    $('#notifToast').toast('hide');
                                                }, 3000);
                                                
                                                if(is_need_inventory == 1){
                                                    $.ajax( {
                                                        url: '../../../helpers/fn_inventory_r.php',
                                                        dataType: 'json',
                                                        type: 'POST',
                                                        data: {
                                                            state          : 1,
                                                            id_transaksi_h : id_transaksi_h,
                                                            imtxxmh_kode   : imtxxmh_kode
                                                        },
                                                        success: function ( json ) {
                                                            console.log('Inventory');
                                                        }
                                                    } );
                                                }

                                                if(is_need_jurnal == 1){
                                                    $.ajax( {
                                                        url: '../../models/'+ "<?php echo $table_name . '/' . $table_name;?>" +'_jv.php',
                                                        dataType: 'json',
                                                        type: 'POST',
                                                        data: {
                                                            state           : 1,
                                                            id_transaksi_h  : id_transaksi_h,
                                                            imtxxmh_kode    : imtxxmh_kode
                                                        },
                                                        success: function ( json ) {
                                                            console.log('Jurnal');
                                                        }
                                                    } );
                                                }
                                                
                                                <?php 
                                                    if(file_exists("../../models/" . $table_name . '/' . $table_name . "_post_approve.php")) {
                                                ?>
                                                    $.ajax( {
                                                        url: '../../models/'+ "<?php echo $table_name . '/' . $table_name;?>" +'_post_approve.php',
                                                        dataType: 'json',
                                                        type: 'POST',
                                                        data: {
                                                            state           : -1,
                                                            id_transaksi_h  : id_transaksi_h
                                                        },
                                                        success: function ( json ) {
                                                            $('#notifToast').toast('show');
                                                            $('#toastMessage').html(json.data.message);
                                                            $('#toastHeader' ).addClass( 'bg-' + json.data.type_message);
                                                            setTimeout(function() { 
                                                                $('#notifToast').toast('hide');
                                                            }, 3000);
                                                        }
                                                    } );
                                                <?php
                                                    }
                                                ?>

                                                <?php echo $table;?>.ajax.reload(null, false);

                                            }
                                        });
                                    }
                                },
<?php
                            }
                            // END button cancel_approve
?>

<?php
                            // BEGIN button void
                            if($value == 'void'){
?>
                                {
                                    text: '<i class="fa fa-remove"></i>&nbsp;Void',
                                    name: 'btnVoid',
                                    className: 'btn btn-sm text-danger',
                                    titleAttr: 'Void',
                                    action: function ( e, dt, node, config ) {
                                        $.ajax( {
                                            url: '../../../helpers/tr_fn_approve.php',
                                            dataType: 'json',
                                            type: 'POST',
                                            data: {
                                                approval_state : -9,
                                                table_name: '<?php echo $table_name;?>',
                                                id_transaksi: id_transaksi_h,
                                            },
                                            success: function ( json ) {
                                                $('#notifToast').toast('show');
                                                $('#toastMessage').html(json.data.message);
                                                $('#toastHeader' ).addClass( 'bg-' + json.data.type_message);
                                                setTimeout(function() { 
                                                    $('#notifToast').toast('hide');
                                                }, 3000);
                                                
                                                if(is_need_inventory == 1){
                                                    $.ajax( {
                                                        url: '../../../helpers/fn_inventory_r.php',
                                                        dataType: 'json',
                                                        type: 'POST',
                                                        data: {
                                                            state          : -9,
                                                            id_transaksi_h : id_transaksi_h,
                                                            imtxxmh_kode   : imtxxmh_kode
                                                        },
                                                        success: function ( json ) {
                                                            console.log('Inventory');
                                                        }
                                                    } );
                                                }

                                                if(is_need_jurnal == 1){
                                                    $.ajax( {
                                                        url: '../../models/'+ "<?php echo $table_name . '/' . $table_name;?>" +'_jv.php',
                                                        dataType: 'json',
                                                        type: 'POST',
                                                        data: {
                                                            state           : -9,
                                                            id_transaksi_h  : id_transaksi_h,
                                                            imtxxmh_kode    : imtxxmh_kode
                                                        },
                                                        success: function ( json ) {
                                                            console.log('Jurnal');
                                                        }
                                                    } );
                                                }
                                                
                                                <?php echo $table;?>.ajax.reload(null, false);
                                            }
                                        } );
                                    }
                                },
<?php
                            }
                            // END button void
?>

<?php
                            // BEGIN button noApprove
                            if($value == 'noapprove'){
?>
                                {
                                    text: 'No Approval Needed', 
                                    name: 'btnNoApprove',
                                    className: 'btn btn-sm text-muted',
                                    titleAttr: 'No Approval Needed',
                                    action: function () {}
                                },
<?php
                            }
                            // END button noApprove
?>

<?php
                        } 
                        // END foreach arr_buttons_approve
?>
                    ]
                },
<?php
            // END btnSetApprove
    }   
    // END IF $arr_buttons_approve
?>