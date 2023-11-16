/************ README **********
 * Status Transaksi transaction_state
 * +------+----------------+--------+------+---------+----------+----------------------------+
 * | Kode | Status         | Cancel | Edit | Next    | Approval | Notes                      |
 * |      |                |        |      | Process |          |                            |
 * +------+----------------+--------+------+---------+----------+----------------------------+
 * | -9   | Deleted        | No     | No   | No      | No       | Doc dihapus (Soft)         |
 * |      |                |        |      |         |          | Hanya bisa jika 1          |
 * | 0    | Draft          | No     | Yes  | No      | No       | Doc belum siap dilanjutkan |
 * | 1    | Confirmed      | Yes    | No   | Yes     | Yes      | Doc siap dilanjutkan       |
 * | 9    | Closed         | No     | No   | No      | Already  | Doc Selesai                |
 * +------+----------------+--------+------+---------+---------------------------------------+
 * 
 * Status Approval approval_state
 * Approval ditandai dengan variable is_need_approval
 * Jika is_need_approval == 1, maka data tersebut harus di approve
 * Default = 0
 * +------+----------------+--------+------+------------------------------+
 * | Kode | Status         | Cancel | Edit |                              |
 * +------+----------------+--------+------+------------------------------+
 * |- 9   | Void           | No     | No   |                              |
 * | -1   | Cancel Approve | Yes    | Yes  |                              |
 * | 0    | Open           | No     | Yes  |                              |
 * | 1    | Approved       | Yes    | No   | Approval ini bisa multilevel |
 * +------+----------------+--------+------+------------------------------+
 * 
 * Variable Terkait
 * hak_c        : hak akses Create dan Confirm data
 * hak_u        : hak akses Update data
 * hak_d        : hak akses Remove, Non Aktif, Reactivate data
 * hak_a        : hak akses Approve, Cancel Approve, Void data
 * cek_c_detail : digunakan untuk menentukan apakah table detail wajib diisi minimal 1 baris. 
 *                variable ini dipasang di tbl_detail on draw
 *                0: tidak wajib ada baris datanya
 *                1: wajib ada baris data minimal 1
 * c_id_detail  : digunakan untuk menghitung jumlah baris data detail
 *                tbl_detail.rows().count();
 */

var status_select;
var arr_is_valid_cek_detail = [];
var c_is_valid_cek_detail = 0;

function ReloadTableDetail(){
    // reload table detail
    for (let i = 0; i < tbl_details.length; i++) {
        tbl_details[i].ajax.reload(null,false);
    }
};

function CekBtnNoAction(tbl){
    // untuk show hide No Action Needed
    // jika ada tombol yang bisa show / enable, maka c_btnSetAction == 1
    // btnNoAction akan di hide
    if(c_btnSetAction == 0 ){
        tbl.button( 'btnNoAction:name' )
            .nodes()
            .css( 'display', 'block' );
        tbl.button( 'btnNoAction:name' ).disable();
    }else{
        tbl.button( 'btnNoAction:name' )
            .nodes()
            .css( 'display', 'none' );
    }
}

function CekBtnNoActionD(tbl_header){
    // untuk show hide No Action Needed
    // jika ada tombol yang bisa show / enable, maka c_btnSetActionD == 1
    // btnNoActionD akan di hide
    if(c_btnSetActionD == 0 ){
        tbl_header.button( 'btnNoActionD:name' )
            .nodes()
            .css( 'display', 'block' );
        tbl_header.button( 'btnNoActionD:name' ).disable();
    }else{
        tbl_header.button( 'btnNoActionD:name' )
            .nodes()
            .css( 'display', 'none' );
    }
}

function CekBtnNoApprove(tbl_header){
    // untuk show hide No Approve Needed
    // jika ada tombol yang bisa show / enable, maka c_btnSetApprove == 1
    // btnNoApprove akan di hide
    if(c_btnSetApprove == 0 ){
        tbl_header.button( 'btnNoApprove:name' )
            .nodes()
            .css( 'display', 'block' );
        tbl_header.button( 'btnNoApprove:name' ).disable();
    }else{
        tbl_header.button( 'btnNoApprove:name' )
            .nodes()
            .css( 'display', 'none' );
    }
    
}

function CekApproval(nama_tabel, id_transaksi){
    $.ajax( {
        url: '../../../helpers/tr_fn_approve_cek.php',
        dataType: 'json',
        type: 'POST',
        data: {
            nama_tabel: nama_tabel,
            id_transaksi: id_transaksi
        },
        success: function ( json ) {
            console.log(json);
        }
    } );
}

// BEGIN Header Only
function CekInitHeaderH(tbl_header){
    c_btnSetAction = 0;
    c_btnSetApprove = 0;
    // digunakan untuk inisiasi table di halaman yang hanya berisi table header saja

    // BEGIN Set Action
    // btnCreate
    // btnEdit
    // btnRemove
    // btnConfirm
    // btnNonAktif
    // btnClose
    // btnView
    // btnLog

    // BEGIN btnCreate
    if(hak_c == 1){
        tbl_header.button( 'btnCreate:name' )
            .nodes()
            .css( 'display', 'block' );
        c_btnSetAction = c_btnSetAction + 1;
    }else{
        tbl_header.button( 'btnCreate:name' )
            .nodes()
            .css( 'display', 'none' );
    }
    // END btnCreate

    // BEGIN btnEdit
    tbl_header.button( 'btnEdit:name' )    
        .nodes()
        .css( 'display', 'none' );
    // END btnEdit

    // BEGIN btnRemove
    tbl_header.button( 'btnRemove:name' )    
        .nodes()
        .css( 'display', 'none' );
    // END btnRemove

    // BEGIN btnConfirm
    tbl_header.button( 'btnConfirm:name' )
        .nodes()
        .css( 'display', 'none' );
    // END btnConfirm

    // BEGIN btnNonAktif
    tbl_header.button( 'btnNonAktif:name' )
        .nodes()
        .css( 'display', 'none' );
    // BEGIN btnNonAktif

    // BEGIN btnClose
    tbl_header.button( 'btnClose:name' )
        .nodes()
        .css( 'display', 'none' );
    // BEGIN btnClose
    
    // BEGIN btnView
    tbl_header.button( 'btnView:name' )    
        .nodes()
        .css( 'display', 'none' );
    // BEGIN btnView

    // BEGIN btnLog
    tbl_header.button( 'btnLog:name' )
        .nodes()
        .css( 'display', 'none' );
    // BEGIN btnLog

    // END Set Action

    CekBtnNoAction(tbl_header);

    // BEGIN Set Approve
    tbl_header.button( 'btnApprove:name' )
        .nodes()
        .css( 'display', 'none' );
    tbl_header.button( 'btnCancelApprove:name' )
        .nodes()
        .css( 'display', 'none' );
    tbl_header.button( 'btnVoid:name' )    
        .nodes()
        .css( 'display', 'none' );
    // END Set Approve

    CekBtnNoApprove(tbl_header);

};

function CekSelectHeaderH(tbl_header){
    c_btnSetAction = 0;
    c_btnSetApprove = 0;

    // BEGIN Set Action

    // BEGIN btnEdit
    // Boleh Edit jika
    //  - transaction_state = 0 atau -1 
    //  - approval_state = 0  
    //  - hak_u = 1
    if( (transaction_state == 0 || transaction_state == -1 ) && hak_u == 1 && approval_state == 0){
        tbl_header.button( 'btnEdit:name' )
            .nodes()
            .css( 'display', 'block' );
        c_btnSetAction = c_btnSetAction + 1;
    }else{
        tbl_header.button( 'btnEdit:name' )
            .nodes()
            .css( 'display', 'none' );
    }
    // END btnEdit

    // BEGIN btnRemove
    // Boleh Remove jika
    //  - transaction_state = 0 atau -1 
    //  - approval_state = 0  
    //  - hak_d = 1
    if( (transaction_state == 0 || transaction_state == -1 ) && hak_d == 1 && approval_state == 0){
        tbl_header.button( 'btnRemove:name' )
            .nodes()
            .css( 'display', 'block' );
        c_btnSetAction = c_btnSetAction + 1;
    }else{
        tbl_header.button( 'btnRemove:name' )
            .nodes()
            .css( 'display', 'none' );
    }
    // END btnRemove

    // BEGIN btnConfirm
    // Boleh Confirm jika
    //  - transaction_state = 0 atau -1
    //  - approval_state = 0  
    //  - hak_c = 1
    if( (transaction_state == 0 || transaction_state == -1 ) && hak_c == 1 && approval_state == 0){
        tbl_header.button( 'btnConfirm:name' )
            .nodes()
            .css( 'display', 'block' );
        c_btnSetAction = c_btnSetAction + 1;
    }else{
        tbl_header.button( 'btnConfirm:name' )
            .nodes()
            .css( 'display', 'none' );
    }
    // END btnConfirm

    // BEGIN btnNonAktif
    // Boleh NonAktif jika
    //  - transaction_state = 1
    //  - approval_state = 0  
    //  - hak_d = 1
    if( transaction_state == 1 && hak_d == 1 && approval_state == 0 ){
        tbl_header.button( 'btnNonAktif:name' )
            .nodes()
            .css( 'display', 'block' );
        c_btnSetAction = c_btnSetAction + 1;
    }else{
        tbl_header.button( 'btnNonAktif:name' )
            .nodes()
            .css( 'display', 'none' );
    }
    // END btnNonAktif

    // BEGIN btnClose
    // Boleh Close jika
    //  - transaction_state = 1
    //  - approval_state = 0  
    //  - hak_d = 1
    if( transaction_state == 1 && hak_a == 1 && approval_state == 1){
        console.log('btnClose = Aktif');
        tbl_header.button( 'btnClose:name' )
            .nodes()
            .css( 'display', 'block' );
        c_btnSetAction = c_btnSetAction + 1;
    }else{
        tbl_header.button( 'btnClose:name' )
            .nodes()
            .css( 'display', 'none' );
    }
    // END btnClose

    // BEGIN btnView
    // Boleh tanpa syarat
    tbl_header.button( 'btnView:name' )
        .nodes()
        .css( 'display', 'block' );
    c_btnSetAction = c_btnSetAction + 1;
    // END btnView
    
    // BEGIN btnLog
    // Boleh tanpa syarat
    tbl_header.button( 'btnLog:name' )
        .nodes()
        .css( 'display', 'block' );
    c_btnSetAction = c_btnSetAction + 1;
    // END btnLog

    CekBtnNoAction(tbl_header);
    // END Set Action

    if (is_need_approval == 1){
        // BEGIN btnApprove
        // Boleh Approve jika
        //  - transaction_state = 1
        //  - approval_state = 0  atau -1
        //  - hak_a = 1
        if( transaction_state == 1 && hak_a == 1 && ( approval_state == 0 || approval_state == -1 ) ){
            tbl_header.button( 'btnApprove:name' )
                .nodes()
                .css( 'display', 'block' );
            c_btnSetApprove = c_btnSetApprove + 1;
        }else{
            tbl_header.button( 'btnApprove:name' )
                .nodes()
                .css( 'display', 'none' );
        }
        // END btnApprove

        // BEGIN btnCancelApprove
        // Boleh Cancel Approve jika
        //  - transaction_state = 1
        //  - approval_state = 1
        //  - hak_a = 1
        if( transaction_state == 1 && hak_a == 1 && approval_state == 1 && is_nextprocess == 0){
            tbl_header.button( 'btnCancelApprove:name' )
                .nodes()
                .css( 'display', 'block' );
            c_btnSetApprove = c_btnSetApprove + 1;
        }else{
            tbl_header.button( 'btnCancelApprove:name' )
                .nodes()
                .css( 'display', 'none' );
        }
        // END btnCancelApprove

        // BEGIN btnVoid
        // Boleh Approve jika
        //  - transaction_state = 1
        //  - approval_state = 1
        //  - hak_a = 1
        //  - is_nextprocess = 0
        if( transaction_state == 1 && hak_a == 1 && approval_state == 1 && is_nextprocess == 0){
            tbl_header.button( 'btnVoid:name' )
                .nodes()
                .css( 'display', 'block' );
            c_btnSetApprove = c_btnSetApprove + 1;
        }else{
            tbl_header.button( 'btnVoid:name' )
                .nodes()
                .css( 'display', 'none' );
        }
        // END btnVoid

    }else{
        // BEGIN btnApprove
        tbl_header.button( 'btnApprove:name' )
            .nodes()
            .css( 'display', 'none' );
        // END btnApprove

        // BEGIN btnCancelApprove
        tbl_header.button( 'btnCancelApprove:name' )
            .nodes()
            .css( 'display', 'none' );
        // END btnCancelApprove

        // BEGIN btnVoid
        tbl_header.button( 'btnVoid:name' )
            .nodes()
            .css( 'display', 'none' );
        // END btnVoid

    }
    CekBtnNoApprove(tbl_header);
    
};

function CekDeselectHeaderH(tbl_header){
    c_btnSetAction = 0;
    c_btnSetApprove = 0;

    // BEGIN Set Action
    // BEGIN btnCreate
    if(hak_c == 1){
        tbl_header.button( 'btnCreate:name' )
            .nodes()
            .css( 'display', 'block' );
        c_btnSetAction = c_btnSetAction + 1;

    }else{
        tbl_header.button( 'btnCreate:name' )
            .nodes()
            .css( 'display', 'none' );
    }
    // END btnCreate

    // BEGIN btnEdit
    tbl_header.button( 'btnEdit:name' )    
        .nodes()
        .css( 'display', 'none' );
    // END btnEdit

    // BEGIN btnRemove
    tbl_header.button( 'btnRemove:name' )    
        .nodes()
        .css( 'display', 'none' );
    // END btnRemove

    // BEGIN btnConfirm
    tbl_header.button( 'btnConfirm:name' )
        .nodes()
        .css( 'display', 'none' );
    // END btnConfirm

    // BEGIN btnNonAktif
    tbl_header.button( 'btnNonAktif:name' )
        .nodes()
        .css( 'display', 'none' );
    // BEGIN btnNonAktif

   // BEGIN btnClose
   tbl_header.button( 'btnClose:name' )
        .nodes()
        .css( 'display', 'none' );
    // BEGIN btnClose

    // BEGIN btnView
    tbl_header.button( 'btnView:name' )    
        .nodes()
        .css( 'display', 'none' );
    // BEGIN btnView

    // BEGIN btnLog
    tbl_header.button( 'btnLog:name' )
        .nodes()
        .css( 'display', 'none' );
    // BEGIN btnLog

    CekBtnNoAction(tbl_header);
    // END Set Action

    // BEGIN Set Approve
    tbl_header.button( 'btnApprove:name' )
        .nodes()
        .css( 'display', 'none' );
    tbl_header.button( 'btnCancelApprove:name' )
        .nodes()
        .css( 'display', 'none' );
    tbl_header.button( 'btnVoid:name' )    
        .nodes()
        .css( 'display', 'none' );

    CekBtnNoApprove(tbl_header);
    // END Set Approve

};
// END Header Only

// BEGIN Header Detail
function CekInitHeaderHD(tbl_header, tbl_details){
    c_btnSetAction = 0;
    c_btnSetApprove = 0;

    arr_is_valid_cek_detail = [];
    is_valid_cek_detail_final = 0;
    // digunakan untuk inisiasi table header di halaman header detail

    // BEGIN Set Action
    // BEGIN btnCreate
    if(hak_c == 1){
        tbl_header.button( 'btnCreate:name' )
            .nodes()
            .css( 'display', 'block' );
        c_btnSetAction = c_btnSetAction + 1;

    }else{
        tbl_header.button( 'btnCreate:name' )
            .nodes()
            .css( 'display', 'none' );
    }
    // END btnCreate

    // BEGIN btnEdit
    tbl_header.button( 'btnEdit:name' )    
        .nodes()
        .css( 'display', 'none' );
    // END btnEdit

    // BEGIN btnRemove
    tbl_header.button( 'btnRemoveHD:name' )    
        .nodes()
        .css( 'display', 'none' );
    // END btnRemove

    // BEGIN btnConfirm
    tbl_header.button( 'btnConfirm:name' )
        .nodes()
        .css( 'display', 'none' );
    // END btnConfirm

    // BEGIN btnNonAktif
    tbl_header.button( 'btnNonAktifHD:name' )
        .nodes()
        .css( 'display', 'none' );
    // BEGIN btnNonAktif

    // BEGIN btnClose
    tbl_header.button( 'btnClose:name' )
        .nodes()
        .css( 'display', 'none' );
    // BEGIN btnClose
    
    // BEGIN btnView
    tbl_header.button( 'btnView:name' )    
        .nodes()
        .css( 'display', 'none' );
    // BEGIN btnView

    // BEGIN btnLog
    tbl_header.button( 'btnLog:name' )
        .nodes()
        .css( 'display', 'none' );
    // BEGIN btnLog

    CekBtnNoAction(tbl_header);
    // END Set Action

        // BEGIN Set Approve
        if (is_need_approval == 1){
            // BEGIN btnApprove
            // Boleh Approve jika
            //  - transaction_state = 1
            //  - approval_state = 0  atau -1
            //  - hak_a = 1
            if( transaction_state == 1 && hak_a == 1 && ( approval_state == 0 || approval_state == -1 ) ){
                tbl_header.button( 'btnApprove:name' )
                    .nodes()
                    .css( 'display', 'block' );
                c_btnSetApprove = c_btnSetApprove + 1;
            }else{
                tbl_header.button( 'btnApprove:name' )
                    .nodes()
                    .css( 'display', 'none' );
            }
            // END btnApprove

            // BEGIN btnCancelApprove
            // Boleh Cancel Approve jika
            //  - transaction_state = 1
            //  - approval_state = 1
            //  - hak_a = 1
            if( transaction_state == 1 && hak_a == 1 && approval_state == 1 ){
                tbl_header.button( 'btnCancelApprove:name' )
                    .nodes()
                    .css( 'display', 'block' );
                c_btnSetApprove = c_btnSetApprove + 1;
            }else{
                tbl_header.button( 'btnCancelApprove:name' )
                    .nodes()
                    .css( 'display', 'none' );
            }
            // END btnCancelApprove
    
            // BEGIN btnVoid
            // Boleh Approve jika
            //  - transaction_state = 1
            //  - approval_state = 1
            //  - hak_a = 1
            //  - is_nextprocess = 0
            if( transaction_state == 1 && hak_a == 1 && approval_state == 1 ){
                tbl_header.button( 'btnVoid:name' )
                    .nodes()
                    .css( 'display', 'block' );
                c_btnSetApprove = c_btnSetApprove + 1;
            }else{
                tbl_header.button( 'btnVoid:name' )
                    .nodes()
                    .css( 'display', 'none' );
            }
            // END btnVoid
    
        }else{
            tbl_header.button( 'btnApprove:name' )
                .nodes()
                .css( 'display', 'none' );
            tbl_header.button( 'btnCancelApprove:name' )
                .nodes()
                .css( 'display', 'none' );
            tbl_header.button( 'btnVoid:name' )
                .nodes()
                .css( 'display', 'none' );
        }
        CekBtnNoApprove(tbl_header);
        // END Set Approve

    // BEGIN looping semua table detail
    for (let i = 0; i < tbl_details.length; i++) {
        // BEGIN btnCreate
        tbl_details[i].button( 'btnCreate:name' )
            .nodes()
            .css( 'display', 'none' );
        // END btnCreate

        // BEGIN btnEdit
        tbl_details[i].button( 'btnEdit:name' )
            .nodes()
            .css( 'display', 'none' );
        // END btnEdit

        // BEGIN btnRemove
        tbl_details[i].button( 'btnRemove:name' )
            .nodes()
            .css( 'display', 'none' );
        // END btnRemove

        // BEGIN btnView
        tbl_details[i].button( 'btnView:name' )    
            .nodes()
            .css( 'display', 'none' );
        // BEGIN btnView

        // BEGIN btnLog
        tbl_details[i].button( 'btnLog:name' )
            .nodes()
            .css( 'display', 'none' );
        // BEGIN btnLog

        CekBtnNoAction(tbl_details[i]);
    }
    // END looping semua table detail

};

function CekSelectHeaderHD(tbl_header, tbl_details){
    c_btnSetAction = 0;
    c_btnSetApprove = 0;
    c_btnSetActionD = 0;
    
    // BEGIN Set Action
    // BEGIN btnEdit
    // Boleh Edit jika
    //  - transaction_state = 0 atau -1 
    //  - approval_state = 0  
    //  - hak_u = 1
    if( (transaction_state == 0 || transaction_state == -1 ) && hak_u == 1 && approval_state == 0){
        tbl_header.button( 'btnEdit:name' )
            .nodes()
            .css( 'display', 'block' );
        c_btnSetAction = c_btnSetAction + 1;
    }else{
        tbl_header.button( 'btnEdit:name' )
            .nodes()
            .css( 'display', 'none' );
    }
    // END btnEdit

    // BEGIN btnRemoveHD
    // Boleh Remove jika
    //  - transaction_state = 0 atau -1 
    //  - approval_state = 0  
    //  - hak_d = 1
    if( (transaction_state == 0 || transaction_state == -1 ) && hak_d == 1 && approval_state == 0){
        tbl_header.button( 'btnRemoveHD:name' )
            .nodes()
            .css( 'display', 'block' );
        c_btnSetAction = c_btnSetAction + 1;
    }else{
        tbl_header.button( 'btnRemoveHD:name' )
            .nodes()
            .css( 'display', 'none' );
    }
    // END btnRemoveHD

    // BEGIN btnConfirm
    // ada di CekDrawDetailHDFinal
    // END btnConfirm

    // BEGIN btnNonAktifHD
    // Boleh NonAktif jika
    //  - transaction_state = 1
    //  - approval_state = 0  
    //  - hak_d = 1
    if( transaction_state == 1 && hak_d == 1 && approval_state == 0){
        tbl_header.button( 'btnNonAktifHD:name' )
            .nodes()
            .css( 'display', 'block' );
        c_btnSetAction = c_btnSetAction + 1;
    }else{
        tbl_header.button( 'btnNonAktifHD:name' )
            .nodes()
            .css( 'display', 'none' );
    }
    // END btnNonAktifHD

    // BEGIN btnView
    // Boleh tanpa syarat
    tbl_header.button( 'btnView:name' )
        .nodes()
        .css( 'display', 'block' );
    c_btnSetAction = c_btnSetAction + 1;
    // END btnView

    // BEGIN btnLog
    // Boleh tanpa syarat
    tbl_header.button( 'btnLog:name' )
        .nodes()
        .css( 'display', 'block' );
    c_btnSetAction = c_btnSetAction + 1;
    // END btnLog

    CekBtnNoAction(tbl_header);
    // END Set Action

    // BEGIN Set Approve
    if (is_need_approval == 1){
        // BEGIN btnApprove
        // Boleh Approve jika
        //  - transaction_state = 1
        //  - approval_state = 0  atau -1
        //  - hak_a = 1
        if( transaction_state == 1 && hak_a == 1 && ( approval_state == 0 || approval_state == -1 ) ){
            tbl_header.button( 'btnApprove:name' )
                .nodes()
                .css( 'display', 'block' );
            c_btnSetApprove = c_btnSetApprove + 1;
        }else{
            tbl_header.button( 'btnApprove:name' )
                .nodes()
                .css( 'display', 'none' );
        }
        // END btnApprove

        // BEGIN btnCancelApprove
        // Boleh Approve jika
        //  - transaction_state = 1
        //  - approval_state = 1
        //  - hak_a = 1
        if( transaction_state == 1 && hak_a == 1 && approval_state == 1 && is_nextprocess == 0 ){
            tbl_header.button( 'btnCancelApprove:name' )
                .nodes()
                .css( 'display', 'block' );
            c_btnSetApprove = c_btnSetApprove + 1;
        }else{
            tbl_header.button( 'btnCancelApprove:name' )
                .nodes()
                .css( 'display', 'none' );
        }
        // END btnCancelApprove

        // BEGIN btnVoid
        // Boleh Approve jika
        //  - transaction_state = 1
        //  - approval_state = 1
        //  - hak_a = 1
        //  - is_nextprocess = 0
        if( transaction_state == 1 && hak_a == 1 && approval_state == 1 && is_nextprocess == 0 ){
            tbl_header.button( 'btnVoid:name' )
                .nodes()
                .css( 'display', 'block' );
            c_btnSetApprove = c_btnSetApprove + 1;
        }else{
            tbl_header.button( 'btnVoid:name' )
                .nodes()
                .css( 'display', 'none' );
        }
        // END btnVoid

    }else{
        tbl_header.button( 'btnApprove:name' )
            .nodes()
            .css( 'display', 'none' );
        tbl_header.button( 'btnCancelApprove:name' )
            .nodes()
            .css( 'display', 'none' );
        tbl_header.button( 'btnVoid:name' )
            .nodes()
            .css( 'display', 'none' );
    }
    CekBtnNoApprove(tbl_header);
    // END Set Approve

    // BEGIN detail
    ReloadTableDetail();

    for (let i = 0; i < tbl_details.length; i++) {
        c_btnSetActionD = 0;
        // BEGIN btnCreate
        // Boleh Create Detail jika
        //  - transaction_state = 0 atau -1
        //  - approval_state = 0  
        //  - hak_c = 1
        if( (transaction_state == 0 || transaction_state == -1 ) && hak_c == 1 && approval_state == 0){
            tbl_details[i].button( 'btnCreate:name' )
                .nodes()
                .css( 'display', 'block' );
            c_btnSetActionD = c_btnSetActionD + 1;

        }else{
            tbl_details[i].button( 'btnCreate:name' )
                .nodes()
                .css( 'display', 'none' );
        }
        // END btnCreate

        CekBtnNoActionD(tbl_details[i]);
    }
    // END detail
};

function CekDeselectHeaderHD(tbl_header, tbl_details){
    c_btnSetAction = 0;
    c_btnSetApprove = 0;
    ReloadTableDetail();

    // Set Action
    // btnCreate
    // btnEdit
    // btnRemove
    // btnConfirm
    // btnNonAktif
    // btnClose
    // btnView
    // btnLog

   // BEGIN btnCreate
   if(hak_c == 1){
        tbl_header.button( 'btnCreate:name' )    
            .nodes()
            .css( 'display', 'block' );
        c_btnSetAction = c_btnSetAction + 1;
    }else{
        tbl_header.button( 'btnCreate:name' )    
            .nodes()
            .css( 'display', 'none' );
    }
    // END btnCreate

    // BEGIN btnEdit
    tbl_header.button( 'btnEdit:name' )    
        .nodes()
        .css( 'display', 'none' );
    // END btnEdit

    // BEGIN btnRemove
    tbl_header.button( 'btnRemoveHD:name' )    
        .nodes()
        .css( 'display', 'none' );
    // END btnRemove

    // BEGIN btnConfirm
    tbl_header.button( 'btnConfirm:name' )
        .nodes()
        .css( 'display', 'none' );
    // END btnConfirm

    // BEGIN btnNonAktif
    tbl_header.button( 'btnNonAktifHD:name' )
        .nodes()
        .css( 'display', 'none' );
    // BEGIN btnNonAktif

    // BEGIN btnClose
    tbl_header.button( 'btnClose:name' )
        .nodes()
        .css( 'display', 'none' );
    // BEGIN btnClose
    
    // BEGIN btnView
    tbl_header.button( 'btnView:name' )    
        .nodes()
        .css( 'display', 'none' );
    // BEGIN btnView

    // BEGIN btnLog
    tbl_header.button( 'btnLog:name' )
        .nodes()
        .css( 'display', 'none' );
    // BEGIN btnLog

    // END Set Action

    CekBtnNoAction(tbl_header);

    // BEGIN Set Approve
    tbl_header.button( 'btnApprove:name' )
        .nodes()
        .css( 'display', 'none' );
    tbl_header.button( 'btnCancelApprove:name' )
        .nodes()
        .css( 'display', 'none' );
    tbl_header.button( 'btnVoid:name' )    
        .nodes()
        .css( 'display', 'none' );
    // END Set Approve

    CekBtnNoApprove(tbl_header);

    // BEGIN looping semua table detail
    for (let i = 0; i < tbl_details.length; i++) {
        tbl_details[i].button( 'btnCreate:name' )
            .nodes()
            .css( 'display', 'none' );

        CekBtnNoAction(tbl_details[i]);
    }
    // END looping semua table detail
};

function CekDrawDetailHD(tbl_header, tbl_detail, nama_tabel ){
    c_btnSetAction = 0;

    // 'create', 'edit', 'remove', 'view', 'log','noaction'
    // BEGIN Init button detail
    // BEGIN looping semua table detail
    for (let i = 0; i < tbl_details.length; i++) {
        // BEGIN btnEdit
        tbl_details[i].button( 'btnEdit:name' )
            .nodes()
            .css( 'display', 'none' );
        // END btnEdit

        // BEGIN btnRemove
        tbl_details[i].button( 'btnRemove:name' )
            .nodes()
            .css( 'display', 'none' );
        // END btnRemove

        // BEGIN btnView
        tbl_details[i].button( 'btnView:name' )    
            .nodes()
            .css( 'display', 'none' );
        // BEGIN btnView

        // BEGIN btnLog
        tbl_details[i].button( 'btnLog:name' )
            .nodes()
            .css( 'display', 'none' );
        // BEGIN btnLog
    }
    // END looping semua table detail
    // END Init button detail

    if(cek_c_detail == 0){
        // table detail tidak wajib diisi

    }else{
        // table detail wajib diisi
        // cek apakah table detail ada baris datanya
        // hitung baris data
        c_id_detail = tbl_detail.rows().count();
        if(c_id_detail > 0){
            // cek aturan lainnya
            // baru tentukan boleh action atau tidak

            
            is_valid_cek_detail = 1; // detail sudah valid, header bisa confirm
        }else{
            is_valid_cek_detail = 0; // detail belum valid, header bisa confirm
        }
    }
};

function CekDrawDetailHDFinal(tbl_header){

    // BEGIN btnConfirm
    // Boleh Confirm jika
    //  - transaction_state = 0 atau -1
    //  - approval_state = 0  
    //  - hak_c = 1
    if( (transaction_state == 0 || transaction_state == -1 ) && hak_c == 1 && approval_state == 0 && is_valid_cek_detail == 1){
        tbl_header.button( 'btnConfirm:name' )
            .nodes()
            .css( 'display', 'block' );
        c_btnSetAction = c_btnSetAction + 1;
    }else{
        tbl_header.button( 'btnConfirm:name' )
            .nodes()
            .css( 'display', 'none' );
    }
    // END btnConfirm
    
};

function CekSelectDetailHD(tbl_header, tbl_detail ){
    c_btnSetActionD = 0;
    // BEGIN btnEdit
    // Boleh Edit jika
    //  - transaction_state = 0 atau -1 
    //  - approval_state = 0  
    //  - hak_u = 1
    if( (transaction_state == 0 || transaction_state == -1 ) && hak_u == 1 && approval_state == 0){
        tbl_detail.button( 'btnEdit:name' )
            .nodes()
            .css( 'display', 'block' );
        c_btnSetActionD = c_btnSetActionD + 1;

    }else{
        tbl_detail.button( 'btnEdit:name' )
            .nodes()
            .css( 'display', 'none' );
    }
    // END btnEdit

    // BEGIN btnRemove
    // Boleh Remove jika
    //  - transaction_state = 0 atau -1 
    //  - approval_state = 0  
    //  - hak_d = 1
    if( (transaction_state == 0 || transaction_state == -1 ) && hak_d == 1 && approval_state == 0){
        tbl_detail.button( 'btnRemove:name' )
            .nodes()
            .css( 'display', 'block' );
        c_btnSetActionD = c_btnSetActionD + 1;

    }else{
        tbl_detail.button( 'btnRemove:name' )
            .nodes()
            .css( 'display', 'none' );
    }
    // END btnRemove

    // BEGIN btnView
    tbl_detail.button( 'btnView:name' )    
        .nodes()
        .css( 'display', 'block' );
    c_btnSetActionD = c_btnSetActionD + 1;
    // BEGIN btnView

    // BEGIN btnLog
    tbl_detail.button( 'btnLog:name' )
        .nodes()
        .css( 'display', 'block' );
    c_btnSetActionD = c_btnSetActionD + 1;
    // BEGIN btnLog

    CekBtnNoActionD(tbl_detail);
};

function CekDeselectDetailHD(tbl_header, tbl_detail ){
    // BEGIN btnEdit
    tbl_detail.button( 'btnEdit:name' )
        .nodes()
        .css( 'display', 'none' );
    // END btnEdit

    // BEGIN btnRemove
    tbl_detail.button( 'btnRemove:name' )
        .nodes()
        .css( 'display', 'none' );
    // END btnRemove

    // BEGIN btnView
    tbl_detail.button( 'btnView:name' )    
        .nodes()
        .css( 'display', 'none' );
    // BEGIN btnView

    // BEGIN btnLog
    tbl_detail.button( 'btnLog:name' )
        .nodes()
        .css( 'display', 'none' );
    // BEGIN btnLog
};
// END Header Detail