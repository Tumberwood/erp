/**
 * Hak Akses CRUD
 * Halaman ini digunakan untuk mengatur button enable disable berdasarkan aturan tertentu
 * Aturan yang digunakan
 *  - Status Transaksi transaction_state
 *  - Status Approval approval_state
 *  - Hak akses CUDA Create Update Delete Approve
 * 
 * Status Transaksi
 * Status Transaksi didapatkan dari nilai transaction_state yang terdapat pada masing-masing table
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
 * Status Approval
 * Status Transaksi didapatkan dari nilai approval_state yang terdapat pada masing-masing table
 * Aturan perlu menggunakan approval atau tidak, didefinisikan di table gtbrlsh.is_need_approval
 * +------+----------------+--------+------+--------------------------------+
 * | Kode | Status         | Cancel | Edit |                                |
 * +------+----------------+--------+------+--------------------------------+
 * |- 9   | Void           | No     | No   |                                |
 * | -1   | Cancel Approve | Yes    | Yes  |                                |
 * | 0    | Open           | No     | Yes  |                                |
 * | 1    | Approved       | Yes    | No   | Approval ini bisa multilevel   |
 * | 9    | Final Approval | Yes    | No   | Penanda sudah approval terakhir|
 * +------+----------------+--------+------+--------------------------------+
 * 
 * Hak akses CUDA
 * Diatur per id_users, pada table ucudasd
 * hak_c        : hak akses Create dan Confirm data
 * hak_u        : hak akses Update data
 * hak_d        : hak akses Remove, Non Aktif, Reactivate data
 * hak_a        : hak akses Approve, Cancel Approve, Void data
 * hak_e        : hak akses Export Excel, Export pdf, Copy Clipboard
 * hak_p        : hak akses Print
 * 
 * Variable lain yang berpengaruh
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

/**
 * Digunakan untuk membantu menampilkan console.log untuk event-event di file ini
 * Setting on off nya pada ggsxxsh.is_debug_hakakses_hd
 */
var is_debug_hakakses_hd;
$.ajax( {
    url: '../../../helpers/fn_debug_hakakses.php',
    dataType: 'json',
    type: 'POST',
    data: {},
    success: function ( json ) {
        is_debug_hakakses_hd = json.data.is_debug_hakakses_hd
    }
} );

/**
 * ReloadTableDetail
 * Digunakan untuk reload semua table detail
 */
function ReloadTableDetail(){
    // debug purpose
    if (is_debug_hakakses_hd == 1) {
        console.log('ReloadTableDetail');
    }
    
    for (let i = 0; i < tbl_details.length; i++) {
        tbl_details[i].ajax.reload(null,false);
    }
};

/**
 * CekBtnNoAction
 * Digunakan untuk show hide No Action Needed pada tabel header
 * jika ada tombol yang bisa show / enable, maka c_btnSetAction == 1
 * dan btnNoAction akan di hide
 * @param {Object} tbl variable tbl datatables
 */
function CekBtnNoAction(tbl){
    // debug purpose
    if (is_debug_hakakses_hd == 1) {
        console.log('CekBtnNoAction');
        console.log('- CekBtnNoAction: ' + c_btnSetAction);
        console.log('----------');
    }
    
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

/**
 * CekBtnNoActionD
 * Digunakan untuk show hide No Action Needed
 * jika ada tombol yang bisa show / enable, maka c_btnSetActionD == 1
 * btnNoActionD akan di hide
 * @param {Object} tbl_header variable tbl header datatables
 */
function CekBtnNoActionD(tbl_header){
    // debug purpose
    if (is_debug_hakakses_hd == 1) {
        console.log('CekBtnNoActionD');
        console.log('- c_btnSetActionD: ' + c_btnSetActionD);
        console.log('----------');
    }
    
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

/**
 * CekInitHeaderH
 * Digunakan untuk inisiasi button table di halaman yang hanya berisi table header saja
 * btnSetAction : btnCreate | btnEdit | btnRemove | btnConfirm | btnNonAktif | btnClose | btnView | btnLog
 * @param {Object} tbl_header 
 */
function CekInitHeaderH(tbl_header){
    c_btnSetAction = 0;

    // debug purpose
    if (is_debug_hakakses_hd == 1) {
        console.log('CekInitHeaderH');
        console.log('- c_btnSetAction ' + c_btnSetAction);
        console.log('- hak_c ' + hak_c);
        console.log('- hak_e ' + hak_e);
        console.log('----------');
    }

    // BEGIN btnExcel
    if(hak_e == 1){
        tbl_header.button( 'btnExcel:name' )
            .nodes()
            .css( 'display', 'block' );
    }else{
        tbl_header.button( 'btnExcel:name' )
            .nodes()
            .css( 'display', 'none' );
    }
    // END btnExcel

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
    // END btnNonAktif

    // BEGIN btnClose
    tbl_header.button( 'btnClose:name' )
        .nodes()
        .css( 'display', 'none' );
    // END btnClose
    
    // BEGIN btnView
    tbl_header.button( 'btnView:name' )    
        .nodes()
        .css( 'display', 'none' );
    // END btnView

    // BEGIN btnLog
    tbl_header.button( 'btnLog:name' )
        .nodes()
        .css( 'display', 'none' );
    // END btnLog

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

};

/**
 * CekSelectHeaderH
 * Digunakan untuk enable atau disable btnEdit | btnRemove | btnConfirm | btnNonAktif | btnClose , di halaman yang hanya berisi table header saja
 * Parameter tambahan yang digunakan:
 *  is_defaultprogram:
 *      Digunakan untuk memberikan flag, bahwa data tersebut adalah data yang dipakai oleh core program, dan tidak boleh diubah.
 *      Nilai default is_defaultprogram = 0, silakan diubah langsung di database. Dari web tidak disediakan field untuk mengubah
 *      Field ini sudah ada di template file model.
 *  is_master_table:
 *      Digunakan untuk membedakan sebuah table merupakan master atau tidak. 
 *      Master table tidak dapat di edit, karena data-data sebagian besar akan dipakai untuk join.
 *      Disarankan yang dapat di edit di master table adalah data-data yang tidak akan di join, misal keterangan
 *      Nilai default is_master_table = 0, silakan diubah di masing-masing halaman, diletakkan pada bagian deklarasi variable javascript
 *  transaction_state:
 *      Digunakan untuk membedakan status transaksi.
 *      Nilai transaction_state dapat dilihat di file usersc\helpers\tr_fn_transaction_state.php
 *  approval_state:
 *      Digunakan untuk membedakan status approval.
 *      Nilai approval_state dapat dilihat di file usersc\helpers\tr_fn_transaction_state.php
 *  hak akses dari tabel ucudasd
 *      Dipanggil dari file usersc\templates\inspinia-side\template_js_setup.php
 *      hak_c: hak create (create dan confirm)
 *      hak_u: hak update (edit)
 *      hak_d: hak delete (remove dan non aktif)
 *      hak_a: hak approve (approve dan void)
 * @param {Object} tbl_header 
 */
function CekSelectHeaderH(tbl_header){
    // debug purpose
    if (is_debug_hakakses_hd == 1) {
        console.log('CekSelectHeaderH');
        console.log('- is_defaultprogram ' + is_defaultprogram);
        console.log('- is_master_table ' + is_master_table);
        console.log('- is_nextprocess ' + is_nextprocess);
        console.log('- transaction_state ' + transaction_state);
        console.log('- approval_state ' + approval_state);
        console.log('- hak_u ' + hak_u);
        console.log('- hak_d ' + hak_d);
        console.log('- hak_a ' + hak_a);
        console.log('----------');
    }

    c_btnSetAction = 0;

    // BEGIN Set Action

    // BEGIN btnEdit
    /**
     * Aturan Edit:
     *  is_master_table = 1 atau
     *  transaction_state = 0 atau -1
     *  approval_state = 0
     *  hak_u = 1
     */
    if(is_defaultprogram == 1){
        // data default program, tidak boleh di edit dengan alasan apapun
        tbl_header.button( 'btnEdit:name' )
            .nodes()
            .css( 'display', 'none' );

    }else{
        // cek apakah master tabel atau bukan
        if(is_master_table == 0){
            // bukan master table
            // cek status transaksi
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
        }else if (is_master_table == 1){
            // master table
            // cek status transaksi
            if(transaction_state == -9){
                tbl_header.button( 'btnEdit:name' )
                    .nodes()
                    .css( 'display', 'none' );
            }else{
                tbl_header.button( 'btnEdit:name' )
                    .nodes()
                    .css( 'display', 'block' );
                c_btnSetAction = c_btnSetAction + 1;
            }
        }else{
            // seharusnya tidak masuk sini karena default is_master_table = 0
            // ada di file usersc\templates\inspinia-side\template_js_setup.php
            tbl_header.button( 'btnEdit:name' )
                .nodes()
                .css( 'display', 'none' );
        }

    }
    // END btnEdit

    // BEGIN btnRemove
    /**
     * ------------------------------------------------------------------------------
     * Ini masih ada kurang pengecekan, 
     * seharusnya ditambahkan jika data sudah pernah dipakai, maka tidak bisa di edit
     * ------------------------------------------------------------------------------
     * 
     * Aturan Remove
     *  transaction_state = 0 atau -1
     *  approval_state = 0
     *  hak_d = 1
     */
    
    if( is_nextprocess == 1 ){
        tbl_header.button( 'btnRemove:name' )
            .nodes()
            .css( 'display', 'none' );
    }else{
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
    }
    
    // END btnRemove

    // BEGIN btnConfirm
    /**
     * Aturan Confirm
     *  transaction_state = 0 atau -1
     *  approval_state = 0
     *  hak_c = 1
     */
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
    /**
     * ------------------------------------------------------------------------------
     * Ini masih ada kurang pengecekan, 
     * seharusnya ditambahkan jika data sudah pernah dipakai, maka tidak bisa di edit
     * ------------------------------------------------------------------------------
     * 
     * Aturan NonAktif
     *  transaction_state = 1
     *  approval_state = 0
     *  hak_d = 1
     */
    if( is_nextprocess == 1 ){
        tbl_header.button( 'btnRemove:name' )
            .nodes()
            .css( 'display', 'none' );
    }else{
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
    }
    // END btnNonAktif

    // BEGIN btnClose
    /**
     * Aturan Close
     *  transaction_state = 1
     *  approval_state = 0
     *  hak_d = 1
     */
    if( transaction_state == 1 && hak_a == 1 && approval_state == 1){
        // debug purpose
        if (is_debug_hakakses_hd == 1) {
            console.log('btnClose = Aktif');
            console.log('----------');
        }
        
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
    
};

/**
 * CekDeselectHeaderH
 * Digunakan pada halaman dengan tabel header saja
 * Dipanggil saat event tabel on deselect
 * Digunakan untuk
 *  - disable btnCreate | btnEdit | btnRemove | btnConfirm | btnNonAktif | btnClose | btnView | btnLog , di halaman yang hanya berisi table header saja
 * @param {Object} tbl_header variable tabel header datatables
 */
function CekDeselectHeaderH(tbl_header){
    c_btnSetAction = 0;

    // debug purpose
    if (is_debug_hakakses_hd == 1) {
        console.log('CekDeselectHeaderH');
        console.log('hak_c ' + hak_c);
        console.log('----------');
    }

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

    // END Set Approve

};
// END Header Only

// BEGIN Header Detail

/**
 * CekInitHeaderHD
 * Digunakan untuk melakukan pengecekan saat inisiasi tabel header detail
 * @param {Object} tbl_header variable tabel header datatables
 * @param {Object} tbl_details variable tabel detail datatables
 */
function CekInitHeaderHD(tbl_header, tbl_details){
    c_btnSetAction = 0;

    arr_is_valid_cek_detail = [];
    // digunakan untuk inisiasi table header di halaman header detail

    // BEGIN btn Export & Copy
    if(hak_e == 1){
        tbl_header.button( 'btnExcel:name' )
            .nodes()
            .css( 'display', 'block' );
        tbl_header.button( 'btnPdf:name' )
            .nodes()
            .css( 'display', 'block' );
        tbl_header.button( 'btnCopy:name' )
            .nodes()
            .css( 'display', 'block' );
    }else{
        tbl_header.button( 'btnExcel:name' )
            .nodes()
            .css( 'display', 'none' );
        tbl_header.button( 'btnPdf:name' )
            .nodes()
            .css( 'display', 'none' );
        tbl_header.button( 'btnCopy:name' )
            .nodes()
            .css( 'display', 'none' );
    }
    // END btn Export & Copy

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

    // BEGIN looping semua table detail
    for (let i = 0; i < tbl_details.length; i++) {

        // BEGIN btn Export & Copy
        if(hak_e == 1){
            tbl_details[i].button( 'btnExcel:name' )
                .nodes()
                .css( 'display', 'block' );
            tbl_details[i].button( 'btnPdf:name' )
                .nodes()
                .css( 'display', 'block' );
            tbl_details[i].button( 'btnCopy:name' )
                .nodes()
                .css( 'display', 'block' );
        }else{
            tbl_details[i].button( 'btnExcel:name' )
                .nodes()
                .css( 'display', 'none' );
            tbl_details[i].button( 'btnPdf:name' )
                .nodes()
                .css( 'display', 'none' );
            tbl_details[i].button( 'btnCopy:name' )
                .nodes()
                .css( 'display', 'none' );
        }
        // END btn Export & Copy

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

    // debug purpose
    if (is_debug_hakakses_hd == 1) {
        console.log('CekInitHeaderHD');
        console.log('- hak_e: ' + hak_e);
        console.log('- hak_c: ' + hak_c);
        console.log('- c_btnSetAction: ' + c_btnSetAction);
        console.log('----------');
    }

};

/**
 * CekSelectHeaderHD
 * Digunakan untuk melakukan pengecekan saat table header pada transaksi header detail di select
 * @param {Object} tbl_header 
 * @param {Object} tbl_details 
 */
function CekSelectHeaderHD(tbl_header, tbl_details){
    c_btnSetAction = 0;
    c_btnSetActionD = 0;
    arr_is_valid_cek_detail = [];

    // debug purpose
    if (is_debug_hakakses_hd == 1) {
        console.log('CekSelectHeaderHD');
        console.log('- is_defaultprogram: ' + is_defaultprogram);
        console.log('- is_master_table: ' + is_master_table);
        console.log('- transaction_state: ' + transaction_state);
        console.log('- approval_state: ' + approval_state);
        console.log('- hak_u: ' + hak_u);
        console.log('- is_nextprocess: ' + is_nextprocess);
        console.log('----------');
    }
    
    // BEGIN Set Action
    // BEGIN btnEdit
    // Boleh Edit jika
    //  - transaction_state = 0 atau -1 
    //  - approval_state = 0  
    //  - hak_u = 1
    
    if(is_defaultprogram == 1){
        tbl_header.button( 'btnEdit:name' )
            .nodes()
            .css( 'display', 'none' );

    }else{
        if(is_master_table == 0){
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
        }else if(is_master_table == 1){
            // master table
            if(transaction_state == -9){
                tbl_header.button( 'btnEdit:name' )
                    .nodes()
                    .css( 'display', 'none' );
            }else{
                tbl_header.button( 'btnEdit:name' )
                    .nodes()
                    .css( 'display', 'block' );
                c_btnSetAction = c_btnSetAction + 1;
            }
        }else{
            // master table
            tbl_header.button( 'btnEdit:name' )
                .nodes()
                .css( 'display', 'none' );
        }
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
    
    if( is_nextprocess == 1){
        tbl_header.button( 'btnNonAktifHD:name' )
            .nodes()
            .css( 'display', 'none' );
    }else{
        if( transaction_state == 1 && hak_d == 1 && approval_state == 0 ){
            tbl_header.button( 'btnNonAktifHD:name' )
                .nodes()
                .css( 'display', 'block' );
            c_btnSetAction = c_btnSetAction + 1;
        }else{
            tbl_header.button( 'btnNonAktifHD:name' )
                .nodes()
                .css( 'display', 'none' );
        }
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

    // BEGIN detail
    ReloadTableDetail();

    for (let i = 0; i < tbl_details.length; i++) {
        c_btnSetActionD = 0;
        // BEGIN btnCreate
        // Boleh Create Detail jika
        //  - transaction_state = 0 atau -1
        //  - approval_state = 0  
        //  - hak_c = 1
        if(is_master_table == 0){
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
        }else if(is_master_table == 1){
            if(transaction_state == -9){
                tbl_details[i].button( 'btnCreate:name' )
                    .nodes()
                    .css( 'display', 'none' );
            }else{
                tbl_details[i].button( 'btnCreate:name' )
                    .nodes()
                    .css( 'display', 'block' );
                c_btnSetActionD = c_btnSetActionD + 1;
            }
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

/**
 * CekDeselectHeaderHD
 * Digunakan pada halaman dengan tabel header dan detail.
 * Dipanggil saat event tabel header on deselect
 * Digunakan untuk 
 *  - enable atau disable btnEdit | btnRemove | btnConfirm | btnNonAktif | btnClose pada tabel header
 *  - enable atau disable btnEdit | btnRemove | btnNonAktif pada tabel detail
 * @param {Object} tbl_header 
 * @param {Object} tbl_details 
 */
function CekDeselectHeaderHD(tbl_header, tbl_details){
    // debug purpose
    if (is_debug_hakakses_hd == 1) {
        console.log('CekDeselectHeaderHD');
        console.log('----------');
    }
    
    c_btnSetAction  = 0;
    arr_is_valid_cek_detail = [];
    ReloadTableDetail();

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

    // BEGIN looping semua table detail
    for (let i = 0; i < tbl_details.length; i++) {
        tbl_details[i].button( 'btnCreate:name' )
            .nodes()
            .css( 'display', 'none' );
        c_btnSetActionD = 0;
        CekBtnNoActionD(tbl_details[i]);
    }
    // END looping semua table detail
};

/**
 * CekDrawDetailHD
 * @param {Object} tbl_detail 
 * @param {Number} is_wajib | apakah table detail wajib ada isinya minimal 1 baris data
 */
// function CekDrawDetailHD(tbl_header, tbl_detail, nama_tabel ){
function CekDrawDetailHD(tbl_detail, cek_c_detail){
    // beta cek 21 May 2024
    // harusnya tidak perlu looping, karena sudah dipanggil di masing-masing tbl_detail on draw
    c_btnSetAction = 0;

    // 'create', 'edit', 'remove', 'view', 'log','noaction'
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
    // END btnLog
    
    if(cek_c_detail == 0){
        // table detail tidak wajib diisi
        is_valid_cek_detail = 1;
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

    arr_is_valid_cek_detail.push(is_valid_cek_detail);

};

/**
 * CekDrawDetailHDFinal
 * @param {Object} tbl_header 
 */
function CekDrawDetailHDFinal(tbl_header){
    // BEGIN btnConfirm
    // Boleh Confirm jika
    //  - transaction_state = 0 atau -1
    //  - approval_state = 0  
    //  - hak_c = 1
    if( (transaction_state == 0 || transaction_state == -1 ) && hak_c == 1 && approval_state == 0 && arr_is_valid_cek_detail.includes(0) == false){
        final = 'Bisa Confirm';
        tbl_header.button( 'btnConfirm:name' )
            .nodes()
            .css( 'display', 'block' );
        c_btnSetAction = c_btnSetAction + 1;
    }else{
        final = 'Tidak bisa Confirm';
        tbl_header.button( 'btnConfirm:name' )
            .nodes()
            .css( 'display', 'none' );
    }
    // END btnConfirm

    if (is_debug_hakakses_hd == 1) {
        console.log('CekDrawDetailHDFinal');
        console.log('- transaction_state: ' + transaction_state);
        console.log('- hak_c: ' + hak_c);
        console.log('- approval_state: ' + approval_state);
        console.log('- arr_is_valid_cek_detail: ' + arr_is_valid_cek_detail.includes(0));
        console.log('- final: ' + final );
        console.log('----------');
    }
    
};

/**
 * CekSelectDetailHD
 * @param {Object} tbl_detail 
 */
function CekSelectDetailHD( tbl_detail ){
// function CekSelectDetailHD( tbl_detail ){
    c_btnSetActionD = 0;
    // BEGIN btnEdit
    // Boleh Edit jika
    //  - transaction_state = 0 atau -1 
    //  - approval_state = 0  
    //  - hak_u = 1
    if(is_master_table == 0){
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
    }else if(is_master_table == 1){
        // master table
        if(transaction_state == -9){
            tbl_detail.button( 'btnEdit:name' )
                .nodes()
                .css( 'display', 'none' );
        }else{
            tbl_detail.button( 'btnEdit:name' )
                .nodes()
                .css( 'display', 'block' );
            c_btnSetAction = c_btnSetAction + 1;
        }
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
    // END btnView

    // BEGIN btnLog
    tbl_detail.button( 'btnLog:name' )
        .nodes()
        .css( 'display', 'block' );
    c_btnSetActionD = c_btnSetActionD + 1;
    // END btnLog

    // debug purpose
    if (is_debug_hakakses_hd == 1) {
        console.log('CekSelectDetailHD');
        console.log('- transaction_state: ' + transaction_state);
        console.log('- hak_u: ' + hak_u);
        console.log('- hak_d: ' + hak_d);
        console.log('- c_btnSetActionD: ' + c_btnSetActionD);
        console.log('----------');
    }
    
    CekBtnNoActionD(tbl_detail);
};

/**
 * CekDeselectDetailHD
 * @param {Object} tbl_detail 
 */
function CekDeselectDetailHD( tbl_detail ){
    // debug purpose
    if (is_debug_hakakses_hd == 1) {
        console.log('CekDeselectDetailHD');
        console.log('- c_btnSetActionD: ' + c_btnSetActionD);
        console.log('----------');
    }

    c_btnSetAction = 0;
    
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

