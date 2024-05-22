/**
 * Dapat di copy-paste ke halaman views, jika tidak ingin menggunakan generate button di helpers/button_fn_generate.php
 * Jika tanpa generate button, maka hak akses button harus diatur sendiri di masing-masing halaman.
 * 
 * Template Button yang bisa digunakan.
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
 * |    btnCancelApprove:name   | Approval, approval_state = -1                                                             |
 * |    btnVoid:name            | Void, approval_state = -9. Sudah tidak dapat diapa-apakah lagi                            |
 * +----------------------------+-------------------------------------------------------------------------------------------+
 */

buttons: [
    // btnSetTools
    {
        extend: 'collection',
        name: 'btnSetTools',
        text: '<i class="fa fa-wrench"></i>',
        titleAttr: 'Tools',
        className: 'btn btn-sm btn-outline',
        autoClose: true,
        buttons: [
            {
                text: '<i class="fa fa-adjust" id="bf_active_status"></i>&nbsp;Show / Hide Deleted',
                name: 'btnShowHide', 
                className: 'btn btn-sm',
                titleAttr: 'Show / Hide Deleted',
                action: function ( e, dt, node, config, tbl_details ) {
                    
                    if (show_deleted__blank == 0){
                        $('#bf_active_status').addClass('text-danger');
                        show_deleted__blank = 1;
                    } else if (show_deleted__blank == 1){
                        $('#bf_active_status').removeClass('text-danger');
                        show_deleted__blank = 0;
                    }

                    tbl_blank.rows().deselect();
                    tbl_blank.ajax.reload(null,false);

                }
            },

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

        ]  
    },
    // btnSetTools2
    {
        extend: 'collection',
        name: 'btnSetTools2',
        text: '<i class="fa fa-search-plus"></i>',
        titleAttr: 'Advanced Filter',
        className: 'btn btn-sm btn-outline',
        autoClose: true,
        buttons: [
            { 
                text: '&nbsp;<i class="fa fa-filter"></i>&nbsp;Filter',
                name: 'btnSF',
                className: 'btn btn-sm btn-outline',
                titleAttr: 'Simple Filter',
                action: function (e, dt, button, config) {
                    $('#modalSF_blank').modal('show');
                }
            },
            { 
                text: '&nbsp;<i class="fa fa-columns"></i>&nbsp;Search Panes',
                name: 'btnSP',
                className: 'btn btn-sm btn-outline',
                titleAttr: 'Filter',
                action: function (e, dt, button, config) {
                    $('#modalP_blank').modal('show');
                }
            },
            { 
                text: '&nbsp;<i class="fa fa-search"></i>&nbsp;Search Builder',
                name: 'btnSB',
                className: 'btn btn-sm btn-outline',
                titleAttr: 'Search',
                action: function (e, dt, button, config) {
                    $('#modalQ_blank').modal('show');
                }
            },
        ]  
    },
    // Collection
    {
        extend: 'collection',
        name: 'btnSetAction',
        text: '<i class="fa fa-th-list"></i>', 
        titleAttr: 'Actions',
        className: 'btn btn-sm btn-outline',
        autoClose: true,
        buttons: [
            // button here
        ]
    }, 
    // Create
    { 
        extend: 'create',
        name: 'btnCreate', 
        editor: edt_blank, 
        text: '<i class="fa fa-plus"></i>&nbsp;Add New', 
        className: 'btn btn-sm', 
        titleAttr: 'Add New',
        formButtons: [
            {
                text: 'Cancel',
                action: function () {
                    this.close();
                },
                className: 'btn btn-warning m-r-xs'
            },
            {
                text: 'Save',
                action: function () {
                    this.submit();
                },
                className: 'btn btn-primary m-r-xs'
            },
            {
                text: 'Save & Confirm',
                action: function (e, dt, node, config, cb){
                    this.submit(
                        function (json) {
                            new_id = json.data[0]._blank.id;
                            full_message = '';
                            $.ajax( {
                                url: '../../../helpers/tr_fn_transaction_state.php',
                                dataType: 'json',
                                type: 'POST',
                                data: {
                                    table_name       : '_blank',
                                    id_transaksi     : new_id,
                                    transaction_state: 1
                                },
                                success: function ( json ) {
                                    status_code  = json.data.status_code;
                                    full_message = full_message + json.data.message + '</br>';
                                    toast_type   = json.data.type_message;

                                    if(status_code == 200){

                                        if(is_need_generate_kode == 1){
                                            $.ajax( {
                                                url: '../../../helpers/kode_fn_generate_confirm.php',
                                                dataType: 'json',
                                                type: 'POST',
                                                async: false,
                                                data: {
                                                    state                   : 1,
                                                    nama_tabel              : _blank,
                                                    kategori_dokumen        : kategori_dokumen,
                                                    kategori_dokumen_value  : kategori_dokumen_value,
                                                    id_transaksi            : new_id
                                                },
                                                success: function ( json ) {
                                                    toast_type   = json.data.type_message;
                                                    full_message = full_message + json.data.message + '</br>';
                                                }
                                            } );

                                        }

                                        if(is_need_approval == 1){
                                            // insert gaplgtd
                                            $.ajax( {
                                                url: 'xxx.php',
                                                url: '../../../helpers/tr_fn_transaction_state_approval.php',
                                                dataType: 'json',
                                                type: 'POST',
                                                //async: false,
                                                data: {
                                                    state       : 1,
                                                    id_transaksi: new_id,
                                                    table_name  : '_blank',
                                                },
                                                success: function ( json ) {
                                                    toast_type = json.data.type_message;
                                                    full_message = full_message + json.data.message + '</br>';
                                                }
                                            } );
                                        }

                                        if(is_need_inventory == 1){
                                            $.ajax( {
                                                url: '../../models/_blank/_blank_iv.php',
                                                dataType: 'json',
                                                type: 'POST',
                                                //async: false,
                                                data: {
                                                    state           : 1,
                                                    id_transaksi_h  : new_id,
                                                },
                                                success: function ( json ) {
                                                    toast_type = json.data.type_message;
                                                    full_message = full_message + json.data.message + '</br>';
                                                }
                                            } );
                                        }

                                        if(is_need_jurnal == 1){
                                            $.ajax( {
                                                url: '../../models/_blank/_blank_jv.php',
                                                dataType: 'json',
                                                type: 'POST',
                                                async: false,
                                                data: {
                                                    state           : 1,
                                                    id_transaksi_h  : new_id,
                                                },
                                                success: function ( json ) {
                                                    toast_type = json.data.type_message;
                                                    full_message = full_message + json.data.message + '</br>';
                                                }
                                            } );
                                        }

                                        // BEGIN jika perlu post_confirm
                                            $.ajax( {
                                                url: '../../models/_blank/_blank_post_confirm.php',
                                                dataType: 'json',
                                                type: 'POST',
                                                async: false,
                                                data: {
                                                    state           : 1,
                                                    id_transaksi  : new_id
                                                },
                                                success: function ( json ) {
                                                    toast_type = json.data.type_message;
                                                    full_message = full_message + json.data.message + '</br>';
                                                },
                                                error: function(xhr, status, error) {
                                                    toast_type = json.data.type_message;
                                                    full_message = full_message + json.data.message + '</br>';
                                                }
                                            } );
                                        // END jika perlu post_confirm
                                    }else{
                                        console.log('no');
                                    }
                                    toastr[toast_type](full_message, 'INFO');
                                    tbl_blank.ajax.reload(null, false);
                                }
                            } );  
                        }, 
                    );
                },
                className: 'btn btn-primary'
            }
        ]
    },
    // Confirm
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
                        table_name       : '_blank',
                        id_transaksi     : id_transaksi_h,
                        transaction_state: 1
                    },
                    success: function ( json ) {
                        status_code  = json.data.status_code;
                        full_message = full_message + json.data.message + '</br>';
                        toast_type   = json.data.type_message;

                        if(status_code == 200){

                            if(is_need_generate_kode == 1){
                                $.ajax( {
                                    url: '../../../helpers/kode_fn_generate_confirm.php',
                                    dataType: 'json',
                                    type: 'POST',
                                    async: false,
                                    data: {
                                        state                   : 1,
                                        nama_tabel              : _blank,
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

                            if(is_need_approval == 1){
                                // insert gaplgtd
                                $.ajax( {
                                    url: '../../../helpers/tr_fn_transaction_state_approval.php',
                                    dataType: 'json',
                                    type: 'POST',
                                    //async: false,
                                    data: {
                                        state       : 1,
                                        id_transaksi: id_transaksi_h,
                                        table_name  : '_blank',
                                    },
                                    success: function ( json ) {
                                        toast_type = json.data.type_message;
                                        full_message = full_message + json.data.message + '</br>';
                                    }
                                } );
                            }

                            if(is_need_inventory == 1){
                                $.ajax( {
                                    url: '../../models/_blank/_blank_iv.php',
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
                                    url: '../../models/_blank/_blank_jv.php',
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

                            // BEGIN jika perlu post_confirm
                                $.ajax( {
                                    url: '../../models/_blank/_blank_post_confirm.php',
                                    dataType: 'json',
                                    type: 'POST',
                                    async: false,
                                    data: {
                                        state           : 1,
                                        id_transaksi  : id_transaksi_h
                                    },
                                    success: function ( json ) {
                                        toast_type = json.data.type_message;
                                        full_message = full_message + json.data.message + '</br>';
                                    },
                                    error: function(xhr, status, error) {
                                        toast_type = json.data.type_message;
                                        full_message = full_message + json.data.message + '</br>';
                                    }
                                } );
                            // END jika perlu post_confirm
                        }else{
                            console.log('no');
                        }
                        toastr[toast_type](full_message, 'INFO');
                        tbl_blank.ajax.reload(null, false);
                    }

                } );                                    

            }

        }
    },

    // Edit
    { 
        extend: 'edit', 
        name: 'btnEdit', 
        editor: edt_blank,
        text: '<i class="fa fa-edit"></i>&nbsp;Edit',
        className: 'btn btn-sm',
        titleAttr: 'Edit',
        formButtons: [
            {
                text: 'Cancel',
                action: function () {
                    this.close();
                },
                className: 'btn btn-warning m-r-xs'
            },
            {
                text: 'Save',
                action: function () {
                    this.submit();
                },
                className: 'btn btn-primary m-r-xs'
            },
            {
                text: 'Save & Confirm',
                action: function (e, dt, node, config, cb){
                    this.submit(
                        function (json) {
                            new_id = json.data[0]._blank.id;
                            full_message = '';
                            $.ajax( {
                                url: '../../../helpers/tr_fn_transaction_state.php',
                                dataType: 'json',
                                type: 'POST',
                                data: {
                                    table_name       : '_blank',
                                    id_transaksi     : new_id,
                                    transaction_state: 1
                                },
                                success: function ( json ) {
                                    status_code  = json.data.status_code;
                                    full_message = full_message + json.data.message + '</br>';
                                    toast_type   = json.data.type_message;

                                    if(status_code == 200){
                                        if(is_need_generate_kode == 1){
                                            $.ajax( {
                                                url: '../../../helpers/kode_fn_generate_confirm.php',
                                                dataType: 'json',
                                                type: 'POST',
                                                async: false,
                                                data: {
                                                    state                   : 1,
                                                    nama_tabel              : _blank,
                                                    kategori_dokumen        : kategori_dokumen,
                                                    kategori_dokumen_value  : kategori_dokumen_value,
                                                    id_transaksi            : new_id
                                                },
                                                success: function ( json ) {
                                                    toast_type   = json.data.type_message;
                                                    full_message = full_message + json.data.message + '</br>';
                                                }
                                            } );

                                        }

                                        if(is_need_approval == 1){
                                            // insert gaplgtd
                                            $.ajax( {
                                                url: '../../../helpers/tr_fn_transaction_state_approval.php',
                                                dataType: 'json',
                                                type: 'POST',
                                                //async: false,
                                                data: {
                                                    state       : 1,
                                                    id_transaksi: new_id,
                                                    table_name  : '_blank',
                                                },
                                                success: function ( json ) {
                                                    toast_type = json.data.type_message;
                                                    full_message = full_message + json.data.message + '</br>';
                                                }
                                            } );
                                        }

                                        if(is_need_inventory == 1){
                                            $.ajax( {
                                                url: '../../models/_blank/_blank_iv.php',
                                                dataType: 'json',
                                                type: 'POST',
                                                //async: false,
                                                data: {
                                                    state           : 1,
                                                    id_transaksi_h  : new_id,
                                                },
                                                success: function ( json ) {
                                                    toast_type = json.data.type_message;
                                                    full_message = full_message + json.data.message + '</br>';
                                                }
                                            } );
                                        }

                                        if(is_need_jurnal == 1){
                                            $.ajax( {
                                                url: '../../models/_blank/_blank_jv.php',
                                                dataType: 'json',
                                                type: 'POST',
                                                async: false,
                                                data: {
                                                    state           : 1,
                                                    id_transaksi_h  : new_id,
                                                },
                                                success: function ( json ) {
                                                    toast_type = json.data.type_message;
                                                    full_message = full_message + json.data.message + '</br>';
                                                }
                                            } );
                                        }
                                        // BEGIN jika perlu post confirm
                                            $.ajax( {
                                                url: '../../models/_blank/_blank_post_confirm.php',
                                                dataType: 'json',
                                                type: 'POST',
                                                async: false,
                                                data: {
                                                    state           : 1,
                                                    id_transaksi  : new_id
                                                },
                                                success: function ( json ) {
                                                    toast_type = json.data.type_message;
                                                    full_message = full_message + json.data.message + '</br>';
                                                },
                                                error: function(xhr, status, error) {
                                                    toast_type = json.data.type_message;
                                                    full_message = full_message + json.data.message + '</br>';
                                                }
                                            } );
                                        // END jika perlu post confirm
                                    }else{
                                        console.log('no');
                                    }
                                    toastr[toast_type](full_message, 'INFO');
                                    tbl_blank.ajax.reload(null, false);
                                }

                            } );  
                        }, 
                    );
                    
                    

                },
                className: 'btn btn-primary'
            }
        ]
    },

    // Remove
    {
        extend: 'remove', 
        name: 'btnRemove',
        editor: edt_blank, 
        text: '<i class="fa fa-trash"></i>&nbsp;Delete(xH)',
        className: 'btn btn-sm text-danger',
        titleAttr: 'Remove',
        formButtons: [
            {
                text: 'Cancel',
                action: function () {
                    this.close();
                }
            },
            'Delete'
        ]
    },

    // Close Transcation
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
                        table_name	 : '_blank',
                        id_transaksi : id_transaksi_h,
                        transaction_state : 9
                    },
                    success: function ( json ) {
                        toast_type   = json.data.type_message;
                        full_message = json.data.message;
                        toastr[toast_type](full_message, 'INFO');
                    }
                } );

                tbl_blank.ajax.reload(null, false);

            }

        }
    },

    // View Button
    {
        extend: "selected",
        name: 'btnView',
        text: '<i class="fa fa-window-maximize"></i>&nbsp;View Data',
        className: 'btn btn-sm',
        titleAttr: 'View Data',
        action: function(e, dt, node, config) {
            edt_blank.edit(tbl_blank.row({
                selected: true
            }).index(), {
                title: 'View'
            }).buttons(
                {
                    text: 'Close',
                    action: function () {
                        this.close();
                    },
                    className: 'btn btn-warning'
                }
            );
            edt_blank.disable();
            e.preventDefault();
        }
    },

    // Log View Header
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
                    table_name	 : '_blank',
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

    // Log View Detail
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
                    table_name	 : '_blank',
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

    // Non Aktif
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
                        table_name	 : '_blank',
                        id_transaksi : id_transaksi_h,
                        transaction_state : -9
                    },
                    success: function ( json ) {
                        full_message = json.data.message;
                        toast_type   = json.data.type_message;
                        toastr[toast_type](full_message, 'INFO');
                        tbl_blank.ajax.reload(null, false);
                        tbl_blank.rows().deselect();
                    }
                } );
            }

        }
    },

    // Remove HD
    { 
        text: '<i class="fa fa-trash"></i>&nbsp;Delete (xHD)',
        name: 'btnRemoveHD',
        className: 'btn btn-sm text-danger',
        titleAttr: 'Remove',
        action: function ( e, dt, node, config ) {
            
            message_is_delete = "Apakah Anda Yakin Akan Menghapus Data?";
            is_delete = confirm(message_is_delete);

            if(is_delete == true){
                full_message = '';

                $.ajax( {
                    url: '../../../helpers/tr_fn_transaction_state.php',
                    dataType: 'json',
                    type: 'POST',
                    data: {
                        table_name	        : '_blank',
                        id_transaksi        : id_transaksi_h,
                        transaction_state   : -93
                    },
                    success: function ( json ) {

                        toast_type   = json.data.type_message;
                        full_message = full_message + json.data.message + '</br>';
                        toastr[toast_type](full_message, 'INFO');
                        tbl_blank.ajax.reload(null, false);
                        tbl_blank.rows().deselect();

                    }
                } );
            }

        }
    },

    // Non Aktif HD
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
                        table_name	        : '_blank',
                        id_transaksi        : id_transaksi_h,
                        transaction_state   : -92
                    },
                    success: function ( json ) {

                        toast_type   = json.data.type_message;
                        full_message = json.data.message;
                        toastr[toast_type](full_message, 'INFO');                        
                        tbl_blank.ajax.reload(null, false);
                        tbl_blank.rows().deselect();

                    }
                } );
            }

        }
    },

    //No Action Needed
    {
        text: 'No Action Needed', 
        name: 'btnNoAction',
        className: 'btn btn-sm text-muted',
        titleAttr: 'No Action Needed',
        action: function () {}
    },

    //No Action Needed Detail
    {
        text: 'No Action Needed', 
        name: 'btnNoActionD',
        className: 'btn btn-sm text-muted',
        titleAttr: 'No Action Needed',
        action: function () {}
    },
]