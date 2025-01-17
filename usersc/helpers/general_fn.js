/**
 * -----------------------------------
 * General Rules
 * -----------------------------------
 * Penamaan Variable
 *  @param {Object} edt variable datatables editor
 *  @param {Object} tbl variable datatables table
 *  Jika pakai header dan detail, maka ditambahkan suffix _h atau _d
 *  contoh: tbl_h, tbl_d
 *  @param {String} tbl_name nama tabel database
 *  Jika pakai header dan detail, maka ditambahkan suffix _h atau _d
 *  contoh: tbl_name_h, tbl_name_d
 *  @param {String} fields_name nama field database
 *  @param {Number} id_transaksi nilai id dari transaksi yang dipilih
 *  Jika pakai header dan detail, maka ditambahkan suffix _h atau _d
 *  contoh: id_transaksi_h, id_transaksi_d 
 */

/**
 * Digunakan untuk meng-copy error message yang tampil pada toastr (notifikasi)
 */
function copyError() {
    navigator.clipboard.writeText(full_message.replace(/<br>/g, " ")).then(function () {
        alert('Silakan hubungi tim Solusi Indonesia dan paste pesan error yang sudah di copy tadi.')
    }, function () {
        alert('Failure to copy. Check permissions for clipboard')
    });
}

/**
 * siVarSet
 * Digunakan untuk set nilai variable yang diperlukan oleh framework, yaitu:
 *  tbl_name_data
 *  id_tbl_name
 *  id_transaksi_h
 *  id_transaksi_log
 *  transaction_state
 *  approval_state
 *  is_nextprocess
 * 
 * @param {String} tbl_name 
 */
function siVarSet(tbl_name){

    var rowData = window['tbl' + tbl_name].row({ selected: true }).data();
    window[tbl_name + '_data'] = rowData[tbl_name];
    window['id_' + tbl_name]   = rowData[tbl_name].id;
    id_transaksi_h             = rowData[tbl_name].id;
    id_transaksi_log           = rowData[tbl_name].id;
    transaction_state          = rowData[tbl_name].transaction_state;
    approval_state             = rowData[tbl_name].approval_state;
    is_nextprocess             = rowData[tbl_name].is_nextprocess;
    is_defaultprogram          = rowData[tbl_name].is_defaultprogram;

    
    window['tbl' + tbl_name].button( 'btnPrint:name' )
        .nodes()
        .css( 'display', 'block' );

    if(transaction_state == 1){
        window['tbl' + tbl_name].button( 'btnPrintJurnal:name' )
            .nodes()
            .css( 'display', 'block' );
    }else{
        window['tbl' + tbl_name].button( 'btnPrintJurnal:name' )
            .nodes()
            .css( 'display', 'none' );	
    }

}

/**
 * siVarReset
 * Digunakan untuk reset variable yang diperlukan oleh framework, yaitu:
 *  tbl_name
 *  id_tbl_name
 *  id_transaksi_h
 *  id_transaksi_log
 *  transaction_state
 *  approval_state
 *  is_nextprocess
 * 
 * @param {String} tbl_name 
 */
function siVarReset(tbl_name){

    window[tbl_name + '_data'] = 0;
    window['id_' + tbl_name]   = 0;
    id_transaksi_h             = 0;
    id_transaksi_log           = 0;
    transaction_state          = 0;
    approval_state             = 0;
    is_nextprocess             = 0;
    is_defaultprogram          = 0;

    window['tbl' + tbl_name].button( 'btnPrintJurnal:name' )
        .nodes()
        .css( 'display', 'none' );

    window['tbl' + tbl_name].button( 'btnPrint:name' )
        .nodes()
        .css( 'display', 'none' );
}

/**
 * siVarSetD
 * Digunakan untuk set nilai variable yang diperlukan oleh framework, yaitu:
 *  tbl_name_data
 *  id_tbl_name
 *  id_transaksi_d
 *  id_transaksi_log_d
 *  transaction_state_d
 *  is_nextprocess_d
 * 
 * @param {String} tbl_name 
 */
function siVarSetD(tbl_name){

    var rowDataD = window['tbl' + tbl_name].row({ selected: true }).data();
    window[tbl_name + '_data'] = rowDataD[tbl_name];
    window['id_' + tbl_name]   = rowDataD[tbl_name].id;
    id_transaksi_d             = rowDataD[tbl_name].id;
    id_transaksi_log_d           = rowDataD[tbl_name].id;
    transaction_state_d        = rowDataD[tbl_name].transaction_state;
    is_nextprocess_d           = rowDataD[tbl_name].is_nextprocess;

}

/**
 * siVarReset
 * Digunakan untuk reset variable yang diperlukan oleh framework, yaitu:
 *  tbl_name
 *  id_tbl_name
 *  id_transaksi_d
 *  id_transaksi_log_d
 *  transaction_state_d
 *  is_nextprocess_d
 * 
 * @param {String} tbl_name 
 */
function siVarResetD(tbl_name){

    window[tbl_name + '_data'] = 0;
    window['id_' + tbl_name]   = 0;
    id_transaksi_d             = 0;
    id_transaksi_log_d           = 0;
    transaction_state_d        = 0;
    is_nextprocess_d           = 0;

}

/**
 * edtFormButtonSaveConfirm
 * Digunakan untuk show hide Form Button Save & Confirm
 * Rule:
 *  transaction_state = 1, maka tombol di hide 
 */
function edtFormButtonSaveConfirm(){
    if(transaction_state == 1){
        $('div.DTE_Form_Buttons button:eq(2)').hide();
    }else{
        $('div.DTE_Form_Buttons button:eq(2)').show();
    }
}

/**
 * edtFormButtonSaveConfirmHD
 * Digunakan untuk show hide Form Button Save & Confirm pada menu Header Detail
 * Rule:
 *  transaction_state = 1, maka tombol di hide 
 */
function edtFormButtonSaveConfirmHD(){
    if(transaction_state == 1){
        $('div.DTE_Form_Buttons button:eq(2)').hide();
    }else{
        if( (transaction_state == 0 || transaction_state == -1 ) && hak_c == 1 && approval_state == 0 && arr_is_valid_cek_detail.length != 0 && arr_is_valid_cek_detail.includes(0) == false){
            $('div.DTE_Form_Buttons button:eq(2)').show();
        }else{
            $('div.DTE_Form_Buttons button:eq(2)').hide();
        }
    }
}

/**
 * Datatables Render transactionStatus
 * Digunakan untuk render field transaction_status
 * Cara menggunakan:
 *  pada datatables columns, setelah data
 *  ...renderTransactionStatus()
 * Contoh
 * { 
        data: "_blank.namaField" ,
        ...renderTransactionStatus()
    }
 */
function renderTransactionStatus() {
    return {
        render: function (data) {
            if (data == -9){
                return '<span class="badge badge-danger">DELETE</span>';
            }else if (data == 0){
                return '<span class="badge badge-plain">DRAFT</span>';
            }else if(data == 1){
                return '<span class="badge badge-primary">CONFIRM</span>';
            }else if(data == 8){
                return '<span class="badge badge-primary">COMPLETE</span>';
            }else if(data == 9){
                return '<span class="badge badge-danger">CLOSED</span>';
            }else{
                return '<span class="badge badge-warning">INVALID</span>';
            }
        }
    };
}

/**
 * Datatables Render approvalStatus
 * Digunakan untuk render field approval_status
 * Cara menggunakan:
 *  pada datatables columns, setelah data
 *  ...renderApprovalStatus()
 * Contoh
 * { 
        data: "_blank.namaField" ,
        ...renderApprovalStatus()
    }
 */
function renderApprovalStatus() {
    return {
        render: function (data) {
            if (data == -9){
                return '<span class="badge badge-danger">VOID</span>';
            }else if(data == -1){
                return '<span class="badge badge-primary">CANCEL APPROVE</span>';
            }else if (data == 0){
                return '<span class="badge badge-plain">OPEN</span>';
            }else if(data == 1){
                return '<span class="badge badge-warning">APPROVE</span>';
            }else if(data == 9){
                return '<span class="badge badge-primary">APPROVE</span>';
            }else if(data == -8){
                return '<span class="badge badge-danger">BYPASS</span>';
            }else{
                return '<span class="badge badge-warning">INVALID</span>';
            }
        }
    };
}

/**
 * Datatables Render yaTidak
 * Kegunaan
 *  untuk render field yang mempunyai opsi Ya | Tidak
 * Cara menggunakan:
 *  pada datatables columns, setelah data
 *  ...renderYaTidak()
 * Contoh
 * { 
        data: "_blank.namaField" ,
        ...renderYaTidak()
    }
 */

function renderYaTidak() {
    return {
        render: function (data) {
            if (data == 0) {
                return '<span class="badge badge-plain">Tidak</span>';
            } else if (data == 1) {
                return '<span class="badge badge-primary">Ya</span>';
            } else {
                return '<span class="badge badge-warning">INVALID</span>';
            }
        }
    };
}

function renderYesNo() {
    return {
        render: function (data) {
            if (data == 0) {
                return '<span class="badge badge-plain">No</span>';
            } else if (data == 1) {
                return '<span class="badge badge-primary">Yes</span>';
            } else {
                return '<span class="badge badge-warning">INVALID</span>';
            }
        }
    };
}

/**
 * Datatables Render Number
 * Kegunaan
 *  untuk render field berupa angka dengan menambahkan thousand separator, decimal, prefix atau suffix, rata kanan
 * Cara menggunakan:
 *  pada datatables columns, setelah data
 *  ...renderNumber(decimal_digit, prefix, suffix")
 * Contoh
 * { 
        data: "iimummd.jumlah_konversi" ,
        ...renderNumber(2, "Rp. ", "")
    }
 */

function renderNumber(digit, prefix, suffix) {
    if (digit == null) {
        digit = 0;
    }

    if (prefix == null) {
        prefix = '';
    }

    if (suffix == null) {
        suffix = '';
    }

    return {
        render: $.fn.dataTable.render.number(',', '.', digit, prefix, suffix),
        class: "text-right"
    };

    //maaf pak, untuk case jika digit dibelakang koma itu 0 maka akan dihilangkan angka 0 nya masih belum sesuai
    //saya cancel, jadinya pakai ini render seperti dibawah ini.
    //saya masukkan di function ini, rendernya tidak terbaca
    // { 
    //     data: "iivxxrd_audit.jumlah_default",
    //     render: function (data){
    //         return data.toString().replace(/\.?0+$/, '');
    //     },
    //     class: "text-right"
    // },
}

/**
 * isDefaultUpdate
 * Digunakan untuk mengubah all data field is_default pada sebuah table
 * hanya boleh ada 1 baris data yang mempunyai nilai is_default = 1 
 * Parameter:
 *  table_name              : nama tabel pada database yang akan di update
 *  id_transaksi_default    : id_transaksi yang is_default = 1 
 *  tblname                 : nama variable tbl 
 * Cara menggunakan:x
 * pada editor initSubmit
 * bisa copy baris script ini ke dalam event initSubmit
 * 
 * // BEGIN is_default
    // ambil is_default dari form input
    is_default 		= edtfcrxxmh.field('fcrxxmh.is_default').val();
    kode 			= edtfcrxxmh.field('fcrxxmh.kode').val();
    nama 			= edtfcrxxmh.field('fcrxxmh.nama').val();
    if(action == 'create'){
        is_default_old = 0;
    } // else nya sudah didapatkan saat select

    if(is_default == 1 && is_default != is_default_old){
        // jika inputan Default = Ya dan sebelumnya bukan Ya
        // konfirmasi perubahan
        if(confirm('Apakah Anda Ingin Membuat '+kode+' - '+nama+' Menjadi Default Currency?')){
            is_update_default = 1;
        }else{
            is_update_default = 0;
            return false;
        }
    }else{
        // tidak ada perubahan

    }
    // END is_default
 * 
 *   
 * pada editor event: postSubmit
 * bisa copy baris script ini ke dalam event postSubmit
 * 
    // BEGIN is_default
    if(is_update_default == 1){
        id_transaksi_default = json.data[0].fcrxxmh.id;
        isDefaultUpdate(table_name,id_transaksi_default,tblname);
    }
    // END is_default
 *   
 */
function isDefaultUpdate(tbl_name,id_transaksi_default,tbl){
    $.ajax( {
        url: '../../../helpers/fn_is_default_update.php',
        dataType: 'json',
        type: 'POST',
        data: {
            tbl_name           : tbl_name,
            id_transaksi_default : id_transaksi_default
        },
        success: function ( json ) {
            tbl.ajax.reload(null, false);
        }
    } );
}

/**
 * konversiUom
 * Digunakan untuk menghitung konversi satuan berdasarkan table iimummd
 * Parameter:
 *  tbl_name  : nama tabel pada database yang akan di update
 *  id_transaksi: id_transaksi yang akan dihitung konversi nya
 * Cara menggunakan:
 * function ini dipanggil saat editor postSubmit
 * bisa copy baris script ini ke dalam event postSubmit
 * 
        if (action != 'remove') {
            id_last_insert = json.data[0]._blank.id;
            konversiUom(id_last_insert, '_blank');
        }
 */
function konversiUom(tbl_name, id_transaksi ){
    $.ajax( {
        url: '../../../helpers/fn_uom_konversi_update.php',
        dataType: 'json',
        type: 'POST',
        data: {
            tbl_name: tbl_name,
            id_transaksi: id_transaksi
        },
        success: function ( json ) {
            if(json.data.status_code == 500){
                full_message = json.data.message + '<br>Page: ' + $(location).attr("href") + '<br>';
                toastr[json.data.type_message](full_message + '<button onclick="copyError()" type="button" class="btn btn-success btn-xs">Copy ke Clipboard</button>', 'Error', {progressBar: false, timeOut:0});
            }
        }
    } );
}

/**
 * autofill
 * Digunakan untuk membuat autofill dependent field. Mendapatkan data dari tabel lain, berdasarkan parameter tertentu
 * @param {String} tbl_name nama tabel yang akan diambil datanya
 * @param {Number} id_transaksi id table tujuan yang akan diambil datanya. biasanya didapatkan dari variable
 * @param {String} fields_name nama field yang akan diambil datanya, bisa multiple, pisahkan menggunakan koma.
 * contoh:
 *  autofillField('tabel_asal', 1, 'fieldA,fieldB')
 *  akan mengambil data fieldA,fieldB dari tabel_asal, id tabel_asal = 1
 */
function autofillField(tbl_name, id_transaksi, fields_name){
    $.ajax( {
        url: '../../../helpers/fn_autofillField.php',
        dataType: 'json',
        type: 'POST',
        async: false,
        data: {
            tbl_name: tbl_name,
            id_transaksi: id_transaksi,
            fields_name: fields_name
        },
        success: function ( json ) {
            if(json.data.status_code == 200){
                autofillData = json.data.rs_autofill;
            }else{
                autofillData = [];
            }
        }
    } );
}

/**
 * hitungSubtotalDetail
 * Digunakan untuk menghitung nilai subtotal pada table detail
 * Rumus:
 * subtotal = jumlah_unit * harga_unit
 * @param {*} edt 
 * @param {*} tabel 
 */
function hitungSubtotalDetail(edt, tabel){
    var jumlah_unit, harga_unit, subtotal;
    jumlah_unit = parseFloat(edt.field(tabel+'.jumlah_unit').val());
    harga_unit  = parseFloat(edt.field(tabel+'.harga_unit').val());
    
    if(isNaN(harga_unit) || isNaN(jumlah_unit)){
        subtotal = 0;
    }else{
        subtotal = (jumlah_unit * harga_unit);
    }
    edt.field(tabel+'.subtotal').val(subtotal);
    
}

/**
 * hitungSubtotalHeader
 * Digunakan untuk menghitung nilai subtotal pada header
 * Subtotal header dihitung dari SUM subtotal pada detail
 * Subtotal header akan diolah lagi dengan data-data header:
 *  - diskon
 *  - pajak
 * @param {Number} id_transaksi_h 
 * @param {String} tabel_detail 
 * @param {Object} tabel_header 
 */
function hitungSubtotalHeader(id_transaksi_h, tabel_detail, tabel_header){
    $.ajax( {
        url: '../../../helpers/fn_subtotal_header.php',
        dataType: 'json',
        type: 'POST',
        data: {
            tabel_header  : tabel_header,
            tabel_detail  : tabel_detail,
            id_transaksi_h: id_transaksi_h
        },
        success: function ( json ) {
            // do nothing
        }
    } );
}  

/**
 * hitungDiskon
 * Digunakan untuk menghitung diskon di detail atau di header
 * Ada 2 macam diskon, dalam persen dan dalam value
 * jenis_diskon:
 *  0: tidak ada diskon
 *  1: persen
 *  2: value
 * @param {*} edt 
 * @param {*} tabel 
 */
function hitungDiskon(edt, tabel){
    var diskon_jenis, diskon_persen, diskon_value, diskon_final ;

    diskon_jenis  = parseFloat(edt.field(tabel+'.diskon_jenis').val());
    diskon_persen = parseFloat(edt.field(tabel+'.diskon_persen').val());
    diskon_value  = parseFloat(edt.field(tabel+'.diskon_value').val());
    subtotal      = parseFloat(edt.field(tabel+'.subtotal').val());

    if (diskon_jenis == 0) {
        diskon_final = 0;
    }else if (diskon_jenis == 1) {
        edt.field(tabel+'.diskon_value').val(0)
        diskon_final = (diskon_persen / 100 * subtotal);
    }else if (diskon_jenis == 2) {
        edt.field(tabel+'.diskon_persen').val(0)
        diskon_final = diskon_value;
    }else{
        // harusnya tidak masuk ke sini karena pilihan di form hanya 0|1|2
    }
    
    edt.field(tabel+'.diskon_final').val(diskon_final);
}

/**
 * hitungHeaderDetail
 * Digunakan untuk menghitung nilai-nilai di header, saat transaksi detail di submit
 * Dipanggil saat postSubmit editor detail
 * @param {*} id_transaksi_h
 */
function hitungHeaderDetail(tbl_name_h, tbl_name_d, id_transaksi_h) {
    // ambil data detail
    // ambil data header
    $.ajax( {
        url: '../../../helpers/tr_fn_header_hitung_total.php',
        dataType: 'json',
        type: 'POST',
        data: {
            tbl_name_h: tbl_name_h,
            tbl_name_d: tbl_name_d,
            id_transaksi_h: id_transaksi_h
        },
        success: function ( json ) {
            
        }
    } );
}

/**
 * hitungHeader
 * Digunakan untuk menghitung nilai-nilai di header
 * @param {*} edt 
 * @param {*} tabel_nama 
 * @param {*} id_iitxxmh 
 */
function hitungHeader(edt, tabel_nama, id_iitxxmh) {
    subtotal     = parseFloat(edt.field(tabel_nama+'.subtotal').val());
    diskon_final = parseFloat(edt.field(tabel_nama+'.diskon_final').val());
    is_pajak     = edt.field(tabel_nama+'.is_pajak').val();
    dpp          = parseFloat(edt.field(tabel_nama+'.dpp').val());
    // BEGIN ambil tarif pajak
    if(is_pajak == 1){
        // jika menggunakan pajak
        $.ajax( {
            url: "../../models/ftxxxmh/ftxxxmh_fn_hitungtarif_iitxxmh.php",
            dataType: 'json',
            type: 'POST',
            async: false,
            data: {
                id_iitxxmh: id_iitxxmh
            },
            success: function ( json ) {
                pajak_jenis = parseFloat(json.data.rs_autofill.id);
                tarif       = parseFloat(json.data.rs_autofill.tarif);
                
                edt.field(tabel_nama+'.pajak_in_ex').show();

            }
        } );

    }else{
        pajak_jenis = 0;
        tarif       = 0;
    }
    // END ambil tarif pajak

    edt.field(tabel_nama+'.pajak_jenis').val(pajak_jenis);
    edt.field(tabel_nama+'.pajak_persen').val(tarif);    

    // BEGIN hitung dpp_final, pajak_final, grand_total
    if(subtotal > 0){
        // jika subtotal sudah ada nilainya
        pajak_in_ex = parseFloat(edt.field(tabel_nama+'.pajak_in_ex').val());

        if(pajak_in_ex == 1){
            //include
            dpp_final = 100 / (tarif + 100) * dpp;
            dpp_final = Math.round(dpp_final * 100) / 100;
            
            pajak_final = dpp - dpp_final;
            pajak_final = Math.round(pajak_final * 100) / 100;
            
            grand_total = dpp;
            grand_total = Math.round(grand_total * 100) / 100;
        }else{
            //exclude
            pajak_final = tarif / 100 * dpp;
            pajak_final = Math.round(pajak_final * 100) / 100;

            dpp_final   = dpp;
            dpp_final   = Math.round(dpp_final * 100) / 100;

            grand_total = dpp_final + pajak_final;
            grand_total = Math.round(grand_total * 100) / 100;
        }

    }else{
        // jika subtotal masih 0
        // harusnya masuk sini saat pertama header di create
        dpp_final   = 0;
        pajak_final = 0;
        grand_total = 0;
    }
    // END hitung dpp_final, pajak_final, grand_total
    
    edt.field(tabel_nama+'.pajak_final').val(pajak_final);
    edt.field(tabel_nama+'.dpp_final').val(dpp_final);
    edt.field(tabel_nama+'.grand_total').val(grand_total);
}

/**
 * hitungDpp
 * Digunakan untuk menghitung nilai dpp pada tabel detail
 * dpp = subtotal - diskon_final
 * @param {*} edt 
 * @param {*} tabel 
 */
function hitungDpp(edt, tabel) {

    var subtotal, diskon_final, dpp;
    
    subtotal     = parseFloat(edt.field(tabel+'.subtotal').val());
    diskon_final = parseFloat(edt.field(tabel+'.diskon_final').val());

    if(isNaN(subtotal)){
        dpp = 0;
    }else{
        dpp = subtotal - diskon_final;
    }

    edt.field(tabel+'.dpp').val(dpp);
}

/**
 * hitungPajak
 * Digunakan untuk menghitung pajak
 * @param {*} edt 
 * @param {*} tabel 
 * @param {*} id_iitxxmh 
 */
function hitungPajak(edt, tabel, id_iitxxmh) {
    subtotal     = parseFloat(edt.field(tabel+'.subtotal').val());
    diskon_final = parseFloat(edt.field(tabel+'.diskon_final').val());
    is_pajak     = edt.field(tabel+'.is_pajak').val();
    dpp          = parseFloat(edt.field(tabel+'.dpp').val());

    if(is_pajak == 1 && dpp > 0){

        $.ajax( {
            url: "../../models/ftxxxmh/ftxxxmh_fn_hitungtarif_iitxxmh.php",
            dataType: 'json',
            type: 'POST',
            async: false,
            data: {
                id_iitxxmh: id_iitxxmh
            },
            success: function ( json ) {
                pajak_jenis = parseFloat(json.data.rs_autofill.id);
                tarif       = parseFloat(json.data.rs_autofill.tarif);
            
                edt.field(tabel+'.pajak_jenis').val(pajak_jenis);
                edt.field(tabel+'.pajak_persen').val(tarif);
                edt.field(tabel+'.pajak_in_ex').show();

                
                pajak_in_ex = parseFloat(edt.field(tabel+'.pajak_in_ex').val());

                if(dpp > 0){
                    if(pajak_in_ex == 1){
                        //include
                        pajak_final = 100 / (tarif + 100) * dpp;
                        pajak_final = Math.round(pajak_final * 100) / 100;
                        
                        dpp_final   = dpp - pajak_final;
                        dpp_final   =Math.round(dpp_final * 100) / 100
                        
                        grand_total = dpp;
                        grand_total = Math.round(grand_total * 100) / 100
                    }else{
                        //exclude
                        pajak_final = tarif / 100 * dpp;
                        pajak_final = Math.round(pajak_final * 100) / 100

                        dpp_final   = dpp;
                        dpp_final   =Math.round(dpp_final * 100) / 100

                        grand_total = dpp_final + pajak_final;
                        grand_total = Math.round(grand_total * 100) / 100
                    }
                    
                }else{
                    dpp_final   = 0;
                    pajak_final = 0;
                    grand_total = 0;
                }

                edt.field(tabel+'.dpp_final').val(dpp_final);
                edt.field(tabel+'.pajak_final').val(pajak_final);
                edt.field(tabel+'.grand_total').val(grand_total);
            }
        } );

    }else{
        edt.field(tabel+'.pajak_jenis').val(null);
        edt.field(tabel+'.pajak_persen').val(null);
        edt.field(tabel+'.pajak_final').val(null);
        edt.field(tabel+'.dpp_final').val(dpp);
        edt.field(tabel+'.grand_total').val(dpp);
        edt.field(tabel+'.pajak_in_ex').hide();
    }
}

/**
 * 
 * @param {String} tbl_name nama tabel database yang akan dicek
 */
function tableRelation(tbl_name){
    $.ajax( {
        url: "../../models/gtbrlsh/gtbrlsh_fn_data.php",
        dataType: 'json',
        type: 'POST',
        data: {
            tbl_name: tbl_name
        },
        success: function ( json ) {
            full_message = '';
            if(json.data.status_code == 200){
                is_need_generate_kode = json.data.is_need_generate_kode;
                is_need_approval      = json.data.is_need_approval;
                is_master_table       = json.data.is_master_table;
                is_need_jurnal        = json.data.is_need_jurnal;
                is_need_inventory     = json.data.is_need_inventory;
            }else{
                full_message = json.data.message + '<br>Page: ' + $(location).attr("href") + '<br>';
                toastr[json.data.type_message](full_message + '<button onclick="copyError()" type="button" class="btn btn-success btn-xs">Copy ke Clipboard</button>', 'Error', {progressBar: false, timeOut:0});
            }
            
        }
    } );
}

/**
 * defaultCurrency
 * Digunakan untuk get data default Currency untuk di load di datatables editor select2
 * Credit to Ferry Ibnu
 */
function defaultCurrency() {
    $.ajax( {
        url: "../../models/fcrxxmh/fcrxxmh_fn_default.php",
        dataType: 'json',
        type: 'POST',
        async: false,
        data: {
        },
        success: function ( json ) {
            if(json.data.status_code == 200){
                id_def = json.data.id_def;
                nama_def = json.data.nama_def;
            }
        }
    } );
}

/**
 * 
 * Masih belum Finish, masih push
 */

// function multiFilesT(id_h) {
//     $.ajax( {
//         url: '../../../helpers/fn_konversi_uom.php',
//         dataType: 'json',
//         type: 'POST',
//         data: {
//             table_name: table_name,
//             id_transaksi: id_transaksi
//         },
//         success: function ( json ) {
//         }
//     } );
// }

/**
 * dtNumberFormat
 * format number menggunakan function dari datatables
 * biasanya dipanggil di footerCallback
 */
dtNumberFormat = $.fn.dataTable.render.number( '\,', '.', 2, '' ).display; 


// Fungsi Scroll kembali ke posisi terakhir sebelum Reload
/**
 * 
 * @param {scrollPosition} Offset Page Y dan X
 * 
    var scrollPosition = window.pageYOffset || document.documentElement.scrollTop;
    
    tblisoittd_upload.ajax.reload(function() {
        scrollToPosition(scrollPosition);
    }, false);
 */

function scrollToPosition(scrollPosition) {
    window.scrollTo(0, scrollPosition);
}


/**
 * 
 * @param {content} = konten yang ingin direload, seperti:
 * tblisoittd_upload.ajax.reload(null, false); atau function generateCard();
 * 
 * Cara menggunakan function autoReloadInterval()
 * 
 *  autoReloadInterval(function () {
        var scrollPosition = window.pageYOffset || document.documentElement.scrollTop;
        console.log(scrollPosition);
        //tambahkan function reload tabel atau function generate card
        generateCard(id_isoxxth_upload_filter);
        // Reload the tables and scroll to position afterward
        tblisoittd_upload.ajax.reload(function() {
            scrollToPosition(scrollPosition);
        }, false);

        tblisoittd_upload_log.ajax.reload(function() {
            scrollToPosition(scrollPosition);
        }, false);
        // console.log('reloaded');
    });
 */
function autoReloadInterval(content) {

    //Buat form cekbox switch auto reload dinamis, jadi tidak perlu lagi menambahkan html di filter
    //ketika function autoReloadInterval() dipanggil, maka otomatis membuat form switch checkbox
    var autoReloadCheckbox = `
        <div class="form-group row">
            <label id="label-auto-reload" class="col-lg-2 col-form-label">Auto Reload</label>
            <div class="col-lg-5">
                <input id="isAutoReload" type="checkbox" class="js-switch"/>
            </div>
        </div>`;

    // ini akan di append di #frmFilter atau class form yang ada di filter biasanya

    //Cari modal-body pada form-horizontal, ini untuk case SF atau filter yang masuk di button
    var modalBody = $("#frmFilter").find(".modal-body");

    //jika ternyata ada modal body, atau filter ini yang masuk di button ljoxxth_dashboard.php
    if (modalBody.length > 0) {
        // maka di append di modal body, atau di filter yang di dalam button
        modalBody.append(autoReloadCheckbox);
    } else {
        // jika tidak ditemukan, maka akan di append di form-horizontal, seperti di dash_stock_opname.php
        $("#frmFilter").append(autoReloadCheckbox);
    }

    //Panggil elem disini agar tidak perlu deklarasi lagi di viewnya, sekalian disini saja
    var elem = document.querySelector('.js-switch');
    var switchery = new Switchery(elem, { color: '#1AB394' });

    //ini function change, jika checkboxnya ter ceklis, maka akan di reload kontennya, jika tidak maka disable reload
    $("#isAutoReload").change(function(){
        if ($(this).prop("checked")) {
            is_auto_reload = true;
            $.ajax({
                url: "../../../../usersc/helpers/reload_interval_ms.php",
                dataType: 'json',
                type: 'POST',
                success: function (json) {
                    var reload_interval_ms = json.data.reload_interval_ms;

                    autoReload = setInterval(function () {
                        content(); // Call the provided content function
                    }, reload_interval_ms);
                }
            });				
        } else {
            clearInterval(autoReload); 
            is_auto_reload = false;
        }
    });
}

/**
 * Digunakan untuk melakukan pengecekan apakah sebuah file atau url ada
 * @param {String} url 
 * @returns 
 */
var checkFileExists = async (url) => {
    try {
        await $.ajax({
            url: url,
            type: 'HEAD'
        });
        return true;
    } catch {
        return false;
    }
};

/**
 * Digunakan untuk melakukan action pada button confirm, termasuk rollback jika terjadi kesalahan
 * Dipanggil dari helpers/button_fn_generate.php
 * @param {String} tbl_name 
 * @param {Object} tbl 
 */
async function fnConfirm(tbl_name, tbl){
    var is_error = 0, is_update_transaction_state = 0, is_generate_kode = 0, is_inventory = 0, is_jurnal = 0, is_post_confirm = 0;
    try {
        full_message = '';

        // Cek keberadaan file sebelum melakukan AJAX request.
        var fileExists_pre = await checkFileExists('../../models/' + tbl_name + '/' + tbl_name + '_pre_confirm.php');
        if (fileExists_pre == true && is_error == 0) {
            let json0 = await $.ajax( {
                url: '../../models/'+ tbl_name +  '/'  + tbl_name +'_pre_confirm.php',
                dataType: 'json',
                type: 'POST',
                data: {
                    table_name       : tbl_name,
                    id_transaksi     : id_transaksi_h,
                    transaction_state: 1
                },
                success: function ( json ) {
                    status_code  = json.data.status_code;
                    if(status_code == 500){
                        is_error = 1;
                    }else{
                        is_update_transaction_state = 1;
                    }
                    full_message = full_message + json.data.message + '</br>';
                    toast_type   = json.data.type_message;

                }

            } );  
        }

        let json1 = await $.ajax( {
            url: '../../../helpers/tr_fn_transaction_state.php',
            dataType: 'json',
            type: 'POST',
            data: {
                table_name       : tbl_name,
                id_transaksi     : id_transaksi_h,
                transaction_state: 1
            },
            success: function ( json ) {
                status_code  = json.data.status_code;
                if(status_code == 500){
                    is_error = 1;
                }else{
                    is_update_transaction_state = 1;
                }
                full_message = full_message + json.data.message + '</br>';
                toast_type   = json.data.type_message;

            }

        } );  
        
        if(is_need_generate_kode == 1 && is_error == 0){
            let json2 = await $.ajax( {
                url: '../../../helpers/kode_fn_generate_confirm.php',
                dataType: 'json',
                type: 'POST',
                data: {
                    state                   : 1,
                    nama_tabel              : tbl_name,
                    kategori_dokumen        : kategori_dokumen,
                    kategori_dokumen_value  : kategori_dokumen_value,
                    id_transaksi            : id_transaksi_h
                },
                success: function ( json ) {
                    status_code  = json.data.status_code;
                    if(status_code == 500){
                        is_error = 1;
                    }else{
                        is_generate_kode = 1;
                    }
                    toast_type   = json.data.type_message;
                    full_message = full_message + json.data.message + '</br>';
                }
            } );

        }

        if(is_need_approval == 1 && is_error == 0 ){
            // insert gaplgtd
            let json3 = await $.ajax( {
                url: '../../../helpers/tr_fn_transaction_state_approval.php',
                dataType: 'json',
                type: 'POST',
                data: {
                    state       : 1,
                    id_transaksi: id_transaksi_h,
                    table_name  : tbl_name,
                },
                success: function ( json ) {
                    status_code  = json.data.status_code;
                    if(status_code == 500){
                        is_error = 1;
                    }else{
                        is_generate_kode = 1;
                    }
                    toast_type = json.data.type_message;
                    full_message = full_message + json.data.message + '</br>';
                }
            } );
        } else {
            if (is_error == 0) {
                //untuk yang setting tblrelation is_need_approval = 0, maka dibuat approve = 9
                //ditambahkan approve = 9
                let json3 = await $.ajax( {
                    url: '../../../helpers/tr_fn_transaction_state_approval.php',
                    dataType: 'json',
                    type: 'POST',
                    data: {
                        state       : 0,
                        id_transaksi: id_transaksi_h,
                        table_name  : tbl_name,
                    },
                    success: function ( json ) {
                        status_code  = json.data.status_code;
                        if(status_code == 500){
                            is_error = 1;
                        }else{
                            is_generate_kode = 1;
                        }
                        toast_type = json.data.type_message;
                        full_message = full_message + json.data.message + '</br>';
                    }
                } );
            }
        }

        if(is_need_inventory == 1 && is_error == 0){
            let json4 = await $.ajax( {
                url: '../../models/'+ tbl_name + '/' + tbl_name +'_iv.php',
                dataType: 'json',
                type: 'POST',
                data: {
                    state           : 1,
                    id_transaksi_h  : id_transaksi_h,
                },
                success: function ( json ) {
                    status_code  = json.data.status_code;
                    if(status_code == 500){
                        is_error = 1;
                    }else{
                        is_inventory = 1;
                    }
                    toast_type = json.data.type_message;
                    full_message = full_message + json.data.message + '</br>';
                }
            } );
        }

        // Cek keberadaan file sebelum melakukan AJAX request.
        var fileExists = await checkFileExists('../../models/' + tbl_name + '/' + tbl_name + '_post_confirm.php');
        if (fileExists == true && is_error == 0) {
            let json6 = await $.ajax( {
                url: '../../models/'+ tbl_name +  '/'  + tbl_name +'_post_confirm.php',
                dataType: 'json',
                type: 'POST',
                async: false,
                data: {
                    state           : 1,
                    id_transaksi  : id_transaksi_h
                },
                success: function ( json ) {
                    status_code  = json.data.status_code;
                    if(status_code == 500){
                        is_error = 1;
                    }else{
                        is_post_confirm = 1;
                    }
                    toast_type = json.data.type_message;
                    full_message = full_message + json.data.message + '</br>';
                },
                error: function(){
                    console.error('File Not Exist');
                },
            } );
        }
        
        if(is_need_jurnal == 1 && is_error == 0){
            let json5 = await $.ajax( {
                url: '../../models/'+ tbl_name +  '/'  + tbl_name +'_jv.php',
                dataType: 'json',
                type: 'POST',
                data: {
                    state           : 1,
                    id_transaksi_h  : id_transaksi_h,
                },
                success: function ( json ) {
                    status_code  = json.data.status_code;
                    if(status_code == 500){
                        is_error = 1;
                    }else{
                        is_jurnal = 1;
                    }
                    toast_type = json.data.type_message;
                    full_message = full_message + json.data.message + '</br>';
                }
            } );
        }

        // lakukan rollback jika ada error
        if(is_error == 1){
            let json6 = await $.ajax( {
                url: '../../../helpers/tr_fn_confirm_rollback.php',
                dataType: 'json',
                type: 'POST',
                data: {
                    state       : 1,
                    id_transaksi: id_transaksi_h,
                    table_name  : tbl_name,
                    is_error : is_error,
                    is_update_transaction_state : is_update_transaction_state,
                    is_generate_kode : is_generate_kode,
                    is_inventory : is_inventory,
                    is_jurnal : is_jurnal,
                    is_post_confirm : is_post_confirm
                },
                success: function ( json ) {
                    status_code  = json.data.status_code;
                    toast_type = 'error';
                    full_message = full_message + json.data.message + '</br>';
                }
            } );
        }

        tbl.rows().deselect();
        tbl.ajax.reload(null, false);
        toastr[toast_type](full_message, 'INFO');


    } catch (error) {
        console.error('Error occurred:', error);
    }
}

function filterFloating() {
    $('#btnFilterFloating').show();
    $('#btnFilterFloating').on('click', function() {
        $('#modalFloatingFilter').modal('show');
    });
}

/**
 * Generate Form Dinamis
 * Tempatkan diatas preOpen
 * 
    genForm('hcdxxmh', edthcdxxmh);
    edthcdxxmh.on( 'preOpen', function( e, mode, action ) {

 */
function genForm(nama_tabel, edt){
    
    var urutan = [];

    $.ajax( {
        url: "../../models/gfrxxth/gfrxxth_fn_gen_form.php",
        dataType: 'json',
        type: 'POST',
        async: false,
        data: {
            nama_tabel: nama_tabel
        },
        success: function ( json ) {
            data_gen_form = json.data.rs_gen_form;
            
            data_gen_form.forEach(gen_form => {
                var id_gfrfltd = gen_form.id_gfrfltd;
                urutan.push(gen_form.urutan_awal);
                
                if (gen_form.is_required == 1) {
                    var labelInput = gen_form.label + " <sup class='text-danger'>*<sup>";
                    // console.log(gen_form.nama);

                    edt.on( 'preSubmit', function (e, data, action) {
                        if(action != 'remove'){
                            if(!edt.field(gen_form.nama).val() || edt.field(gen_form.nama).val() == ''){
                                edt.field(gen_form.nama).error( 'Wajib diisi!' );
                            }
                            
                            if (gen_form.type_data == 'DECIMAL(12,2)' || gen_form.type_data == 'INT(11)' || gen_form.is_number == 1) {
                                if(edt.field(gen_form.nama).val() <= 0 ){
                                    edt.field(gen_form.nama).error( 'Inputan harus > 0' );
                                }
                                
                                if(isNaN(edt.field(gen_form.nama).val()) ){
                                    edt.field(gen_form.nama).error( 'Inputan harus berupa Angka!' );
                                }
                            }
                        }
                    });

                } else {
                    var labelInput = gen_form.label;
                }

                if (gen_form.type === 'select') {
                    var options = []; 
                    
                    $.ajax({
                        url: "../../models/gfrxxth/gfrxxth_fn_select_options.php",
                        dataType: 'json',
                        type: 'POST',
                        async: false,
                        data: {
                            id_gfrfltd: id_gfrfltd
                        },
                        success: function (json) {
                            var data_option_select = json.data.rs_option_select; 
                            
                            data_option_select.forEach(option_select => {
                                options.push({
                                    label: option_select.nama, 
                                    value: option_select.id    
                                });
                            });
            
                            edt.add({
                                label: labelInput,
                                name: gen_form.nama,
                                type: gen_form.type,
                                placeholder: "Select",
                                options: options 
                            });
                        }
                    });
                } else if (gen_form.type == 'datetime'){
                    //IF date biasa
                    if (gen_form.type_data == 'DATE') {
                        edt.add({
                            label: labelInput,
                            name: gen_form.nama,
                            type: gen_form.type,
                            def: function () { 
                                return new Date(); 
                            },
                            opts:{
                                minDate: new Date('1900-01-01'),
                                firstDay: 0
                            },
                            format: 'DD MMM YYYY'
                        });
                        
                    //IF DATETIME
                    } else if (gen_form.type_data == 'DATETIME') {
                        edt.add({
                            label: labelInput,
                            name: gen_form.nama,
                            type: gen_form.type,
                            def: function () { 
                                return new Date(); 
                            },
                            opts:{
                                minDate: new Date('1900-01-01'),
                                firstDay: 0
                            },
                            format: 'DD MMM YYYY HH:mm'
                        });

                    //IF TIME
                    } else {
                        edt.add({
                            label: labelInput,
                            name: gen_form.nama,
                            type: gen_form.type,
                            def: function () { 
                                return new Date(); 
                            },
                            opts:{
                                minDate: new Date('1900-01-01'),
                                firstDay: 0
                            },
                            format: 'HH:mm'
                        });
                    }

                } else {
                    edt.add({
                        label: labelInput,
                        name: gen_form.nama,
                        type: gen_form.type
                    });
                }
            });
            
        }
    } );

    // console.log(urutan);
    
    //ini untuk membuat form template dinamis
    var templateObject = edt.template();

    // cari panel body yang terakhir, ini nanti akan di append row dan col nya
    var lastPanelBody = $(templateObject).find('div.panel-body:last'); 


    for (let i = 0; i < urutan.length; i += 2) {
        var newRow = $('<div class="row"></div>');

        var newCol1 = $(`
            <div class="col-lg-6">
                <editor-field name="${nama_tabel}.field_${urutan[i]}"></editor-field>
            </div>
        `);

        var newCol2 = $('<div class="col-lg-6"></div>');

        // jika increment masih ada di urutan dan increment genap, maka akan ada di baris kedua yang kanan
        if (i + 1 < urutan.length) {
            newCol2.append(`
                <editor-field name="${nama_tabel}.field_${urutan[i + 1]}"></editor-field>
            `);
        }

        newRow.append(newCol1).append(newCol2);
        
        lastPanelBody.append(newRow);
    }
};

/** FUNCTION UPLOAD MASTER, HTML DAN JS AUTO
 * MOHON DIPASTIKAN MEMBERI NAMA FILE DENGAN AKHIRAN _upload.php di models.
 * 
 * @param {*} nama_tabel = "hosxxmh"
 * @param {*} tbl        = tbl datatables
 * @param {*} url        = Lokasi Foto dengan files/folder/nama file.xlsx
 * 
 * // END hosxxmh
		
    uploadMaster('hosxxmh', tblhosxxmh, 'files/template_file_upload/Master Section.xlsx');
 */
function uploadMaster(nama_tabel, tbl, url) {
    // Create and append the modal HTML
    const modalHTML = `
    <div class="modal" id="modalUpload${nama_tabel}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated bounceInRight">
                <form class="form-horizontal" id="frmUploadMaster" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h4 class="modal-title">Upload Master</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label">File Excel</label>
                            <div class="col-sm-4">
                                <div class="input-group">
                                    <input type="file" name="filename" class="form-control" id="frmUploadItem">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <button type="button" class="btn btn-success" onclick="window.open('../../../${url}');">
                                    <i class="fa fa-download"></i>&nbsp;&nbsp;<span class="bold">Template</span>
                                </button>
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
    </div>`;

    // Append modal to the body
    document.body.insertAdjacentHTML('beforeend', modalHTML);

    // Initialize validation and submission for the form
    var frmUploadMaster = $("#frmUploadMaster").validate({
        submitHandler: function(form) {
            // toastr awal
            toastr.info('Harap tunggu ...', 'Proses Upload', {
                progressBar: false,
                timeOut: 0, // Infinite timeout
                extendedTimeOut: 0
            });

            // item
            var fd_item = new FormData();
            var item = $('#frmUploadItem')[0].files[0];
            if (item != undefined) {
                fd_item.append('filename', item);

                $.ajax({
                    url: "../../models/" + nama_tabel + "/" + nama_tabel + "_upload.php",
                    type: 'POST',
                    dataType: 'json',
                    data: fd_item,
                    async: false,
                    contentType: false,
                    processData: false,
                    success: function(json) {
                        // Hilangkan toastr awal
                        toastr.clear();

                        var full_message = json.data.message + '</br>';
                        var toast_type = json.data.type_message;

                        // Tampilkan toastr baru
                        toastr[toast_type](full_message, 'INFO');

                        $("#frmUploadItem").val('');
                        tbl.ajax.reload(null, false);
                        $('#modalUpload'+nama_tabel).modal('toggle');
                    },
                    error: function(xhr, Status, err) {
                        toastr.remove(toastrWaiting);
                        toastr['error']('Upload gagal. Silakan coba lagi.', 'Error');
                    }
                });
            }
        }
    });
}

/**
 * Sama seperti uploadMaster, tapi ini harus dipasang di Select dan Deselect Header untuk mendapatkan id_header secara realtime.
 */
function uploadDetail(id_header, nama_tabel, tbl, url) {
    if (id_header > 0) {
        tbl.button('btnUploadData:name').enable();
        // Create and append the modal HTML
        const modalHTML = `
        <div class="modal" id="modalUpload${nama_tabel}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content animated bounceInRight">
                    <form class="form-horizontal" id="frmUploadDetail" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h4 class="modal-title">Upload Detail</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">File Excel</label>
                                <div class="col-sm-4">
                                    <div class="input-group">
                                        <input type="file" name="filename" class="form-control" id="frmUploadItem">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <button type="button" class="btn btn-success" onclick="window.open('../../../${url}');">
                                        <i class="fa fa-download"></i>&nbsp;&nbsp;<span class="bold">Template</span>
                                    </button>
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
        </div>`;
    
        // Append modal to the body
        document.body.insertAdjacentHTML('beforeend', modalHTML);
    
        // Initialize validation and submission for the form
        var frmUploadDetail = $("#frmUploadDetail").validate({
            submitHandler: function(form) {
                // toastr awal
                toastr.info('Harap tunggu ...', 'Proses Upload', {
                    progressBar: false,
                    timeOut: 0, // Infinite timeout
                    extendedTimeOut: 0
                });
    
                // detail
                var fd_detail = new FormData();
                var detail = $('#frmUploadItem')[0].files[0];
                if (detail != undefined) {
                    fd_detail.append('filename', detail);
                    fd_detail.append('id_header',id_header);
    
                    $.ajax({
                        url: "../../models/" + nama_tabel + "/" + nama_tabel + "_upload.php",
                        type: 'POST',
                        dataType: 'json',
                        data: fd_detail,
                        async: false,
                        contentType: false,
                        processData: false,
                        success: function(json) {
                            // Hilangkan toastr awal
                            toastr.clear();
    
                            var full_message = json.data.message + '</br>';
                            var toast_type = json.data.type_message;
    
                            // Tampilkan toastr baru
                            toastr[toast_type](full_message, 'INFO');
    
                            $("#frmUploadItem").val('');
                            tbl.ajax.reload(null, false);
                            $('#modalUpload'+nama_tabel).modal('toggle');
                        },
                        error: function(xhr, Status, err) {
                            toastr.remove(toastrWaiting);
                            toastr['error']('Upload gagal. Silakan coba lagi.', 'Error');
                        }
                    });
                }
            }
        });
    } else {
        tbl.button('btnUploadData:name').disable();
    }
}

/**
 * 
 * @param {nama tabel database} tbl_name 
 * @param {editor} edt 
 * @param {is_required} is_required = 1 maka wajib isi kode | is_required = 0, maka tidak wajib isi kode 
 * 
    cek_is_need_generate_kode('hemxxmh', edthemxxmh);
 */
function cek_is_need_generate_kode(tbl_name, edt, is_required) {
    tableRelation(tbl_name);
    if (!is_required) {
        is_required = 0;
    }

    const fields = edt.fields();
    //jika is_generate_kode = 1 di gtbrlsh
    if (is_need_generate_kode == 1) {
        //Jika fields kode di editor ada, maka dihide saja
        if (fields.includes(tbl_name + '.kode')) {
            console.log('Field ditemukan.');
            edt.field(tbl_name+'.kode').hide();
        }
    } else {
        if (!fields.includes(tbl_name + '.kode')) {
            // Jika field tidak ditemukan, buat editor baru untuk "kode"
            edt.add({
                label: 'Kode', // Label untuk editor
                name: tbl_name + '.kode', // Nama field
                type: 'text', // Jenis input (misalnya, teks)
                placeholder: 'Masukkan kode', // Placeholder
            });
        }

        if (is_required == 1) {
            edt.field(tbl_name + '.kode').label( "Kode  <sup class='text-danger'>*<sup>" );
            edt.on( 'preSubmit', function (e, data, action) {
                if(action != 'remove'){
                    if(!edt.field(tbl_name + '.kode').val() || edt.field(tbl_name + '.kode').val() == ''){
                        edt.field(tbl_name + '.kode').error( 'Wajib diisi!' );
                    }
                }
            });
        }
        
    }
}

/**
 * 
 * @param {*} tabel 
 * @param {*} edt 
 * @param {*} fields 
 * 
 * //Phone
 * edttabel.field('tabel.target_atas').input().inputmask({
        alias: 'phone', // Gunakan alias phone untuk memulai
        mask: '9999-9999-999', // Override alias dengan pola khusus
        placeholder: '_', // Placeholder saat input kosong
        removeMaskOnSubmit: false, // Biarkan mask tetap saat submit
        autoUnmask: false // Jangan hapus mask saat mengambil data
    });

 */
/**
 * 
 * @param {*} edt       = editor
 * @param {*} tabel     = nama tabel db
 * @param {*} fields    = fields dalam Array, [terget atas, target bawah]
 * @param {*} digit     = digit belakang koma, mask
 * @param {*} number     = digit untuk validasiNumber
 * @param {*} operator     = Operator seperti ">", ">=", val > number
 * @returns 
 * 
 * Cara implementasi: tempatkan diatas Preopen
 * unmaskedData = maskingNumber(
        edthfkobtd, 
        "hfkobtd", 
        [
            "target_atas", 
            "target_bawah", 
        ],
        2,
    );

    variable unmaskedData akan menghasilkan nilai return unmask dari inputan.

    variable ini bisa dibuat digunakan di presubmit untuk dibuat validasi Number dsb.

    target_atas = unmaskedData.target_atas;
    target_bawah = unmaskedData.target_bawah;

    NOTE: function maskingNumber sudah termasuk validasiNumber, jadi tidak perlu dipanggil lagi validasiNumber di presubmit.
 */
function maskingNumber(edt, tabel, fields, digit, number, operator) {
    if (digit === null) {
        digit = 0;
    }

    // Object to store dynamic variables
    let unmaskedValues = {};

    fields.forEach(field_name => {
        edt.field(tabel + '.' + field_name).input().inputmask({
            alias: 'numeric',
            groupSeparator: ',',
            autoGroup: true,
            digits: digit, // Jumlah angka desimal sesuai input parameter
            radixPoint: '.', // Gunakan titik sebagai pemisah desimal
            removeMaskOnSubmit: false // Biarkan mask untuk penanganan manual di preSubmit
        });

        edt.on('preSubmit', function (e, data, action) {
            if (action != 'remove') {
                //Unmask dan simpan data unmask, agar valid data yang tersimpan,
                $.each(data.data, function (key, value) {
                    if (value[tabel] && value[tabel][field_name]) {
                        // Update data for submission
                        data.data[key][tabel][field_name] = edt.field(tabel + '.' + field_name).input().inputmask('unmaskedvalue');
                    }
                });

                // Store unmasked value in the unmaskedValues object
                //variable ini adalah nilai asli tanpa masking, bisa dibuat untuk dependent / presubmit.
                unmaskedValues[field_name] = edt.field(tabel + '.' + field_name).input().inputmask('unmaskedvalue');

                 // validasi angka atau bukan
                if(isNaN(edt.field(tabel + '.' + field_name).input().inputmask('unmaskedvalue')) ){
                    edt.field(tabel + '.' + field_name).error( 'Inputan harus berupa Angka!' );
                }
                
                if (number == null || operator == null) {
                    // validasi angka atau bukan
                    // jika null, maka artinya hanya validasi angka atau bukan saja
                    
                }else{
                    
                    a = parseFloat(edt.field(tabel + '.' + field_name).input().inputmask('unmaskedvalue'));
                    b = parseFloat(number);

                    // console.log(a);
                    // console.log(b);

                    switch (operator) {
                        case '==':
                        case '=':
                        ifStatement = a == b;
                        break;
                        case '<>':
                        ifStatement = a != b;
                        break;
                        case '<=':
                        ifStatement = a <= b;
                        break;
                        case '>=':
                        ifStatement = a >= b;
                        break;
                        case '<':
                        ifStatement = a < b;
                        break;
                        case '>':
                        ifStatement = a > b;
                        break;
                        default:
                        console.log('Operator tidak valid');
                    }

                    // validasi by operator
                    if( ifStatement ){
                        // kondisi terpenuhi, do nothing
                    }else{
                        edt.field(tabel + '.' + field_name).error( 'Inputan harus ' + operator + ' ' + number );
                    }
                }
            }
        });
    });

    return unmaskedValues; // Return dynamic variables as an object
}
