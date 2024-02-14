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
                return '<span class="badge badge-primary">APPROVE</span>';
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
}

/**
 * isDefaultUpdate
 * Digunakan untuk mengubah all data field is_default pada sebuah table
 * hanya boleh ada 1 baris data yang mempunyai nilai is_default = 1 
 * Parameter:
 *  table_name              : nama tabel pada database yang akan di update
 *  id_transaksi_default    : id_transaksi yang is_default = 1 
 *  tblname                 : nama variable tbl 
 * Cara menggunakan:
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
function isDefaultUpdate(table_name,id_transaksi_default,tblname){
    $.ajax( {
        url: '../../../helpers/fn_is_default_update.php',
        dataType: 'json',
        type: 'POST',
        data: {
            table_name           : table_name,
            id_transaksi_default : id_transaksi_default
        },
        success: function ( json ) {
            tblname.ajax.reload(null, false);
        }
    } );
}

function isDefaultUpdateD(table_name, id_transaksi_h, id_transaksi_default,tblname){
    $.ajax( {
        url: '../../../helpers/fn_is_default_update_d.php',
        dataType: 'json',
        type: 'POST',
        data: {
            table_name           : table_name,
            id_transaksi_h       : id_transaksi_h,
            id_transaksi_default : id_transaksi_default
        },
        success: function ( json ) {
            tblname.ajax.reload(null, false);
        }
    } );
}

/**
 * konversiUom
 * Digunakan untuk menghitung konversi satuan berdasarkan table iimummd
 * Parameter:
 *  table_name  : nama tabel pada database yang akan di update
 *  id_transaksi: id_transaksi yang akan dihitung konversi nya
 * Cara menggunakan:
 * function ini dipanggil saat editor postSubmit
 * bisa copy baris script ini ke dalam event postSubmit
 * 
        if (action != 'remove') {
            id_last_insert = json.data[0].itoittd.id;
            konversiUom(id_last_insert, 'itoittd');
        }
 */
function konversiUom(table_name, id_transaksi ){
    $.ajax( {
        url: '../../../helpers/fn_konversi_uom.php',
        dataType: 'json',
        type: 'POST',
        data: {
            table_name: table_name,
            id_transaksi: id_transaksi
        },
        success: function ( json ) {
        }
    } );
}

/**
 * autofill
 * Digunakan untuk membuat autofill dependent field. Mendapatkan data dari tabel lain, berdasarkan parameter tertentu
 * table_name   : string    | nama tabel yang akan diambil datanya
 * id_transaksi : integer   | id table tujuan yang akan diambil datanya. biasanya didapatkan dari variable
 * fields_name  : string    | nama field yang akan diambil datanya, bisa multiple, pisahkan menggunakan koma. 
 * contoh:
 *  autofillField('tabel_asal', 1, 'fieldA,fieldB')
 *  akan mengambil data fieldA,fieldB dari tabel_asal, id tabel_asal = 1
 */
function autofillField(table_name, id_transaksi, fields_name){
    $.ajax( {
        url: '../../../helpers/fn_autofillField.php',
        dataType: 'json',
        type: 'POST',
        async: false,
        data: {
            table_name: table_name,
            id_transaksi: id_transaksi,
            fields_name: fields_name
        },
        success: function ( json ) {
            autofillData = json.data.rs_autofill;
        }
    } );
}

/**
 * hitungSubtotal
 * Digunakan untuk menghitung field subtotal
 * subtotal = jumlah_unit * harga_unit
 */

function hitungSubtotal(edt, tabel){
    var jumlah_unit,harga_unit, subtotal;
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
 * hitungDiskon
 * Digunakan untuk menghitung diskon
 * Ada 2 macam diskon, dalam persen dan dalam value
 * jenis_diskon:
 *  0: tidak ada diskon
 *  1: persen
 *  2: value
 */
function hitungDiskon(edt, tabel){
    var diskon_jenis, diskon_persen, diskon_value, diskon_final, dpp ;

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

    // hitung dpp
    if(isNaN(subtotal)){
        dpp = 0;
    }else{
        dpp = (subtotal - diskon_final);
    }
    
    edt.field(tabel+'.diskon_final').val(diskon_final);
    edt.field(tabel+'.dpp').val(dpp);
}

/**
 * hitungPajak
 * Digunakan untuk menghitung pajak
 * @param {*} edt 
 * @param {*} tabel 
 * @param {*} id_iittpmh 
 */
function hitungPajak(edt, tabel, id_iittpmh) {
    is_pajak = edt.field(tabel+'.is_pajak').val();
    dpp      = parseFloat(edt.field(tabel+'.dpp').val());

    if(is_pajak == 1 && dpp > 0){

        $.ajax( {
            url: "../../models/ftxxxmh/ftxxxmh_fn_hitungtarif_iittpmh.php",
            dataType: 'json',
            type: 'POST',
            async: false,
            data: {
                id_iittpmh: id_iittpmh
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