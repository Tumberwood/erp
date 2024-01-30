/**
 * dtNumberFormat
 * format number menggunakan function dari datatables
 * biasanya dipanggil di footerCallback
 */
dtNumberFormat = $.fn.dataTable.render.number( '\,', '.', 2, '' ).display; 

/**
 * Datatables Render transactionStatus
 * Digunakan untuk render field transaction_status
 * Cara menggunakan:
 * pada datatables columns render
 * render: $.fn.dataTable.render.transactionStatus()
 */
$.fn.dataTable.render.transactionStatus = function () {
    return function ( data, type, row ) {

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

/**
 * Datatables Render approvalStatus
 * Digunakan untuk render field approval_status
 * Cara menggunakan:
 * pada datatables columns render
 * render: $.fn.dataTable.render.approvalStatus()
 */
$.fn.dataTable.render.approvalStatus = function () {
    return function ( data, type, row ) {

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

/**
 * Datatables Render yaTidak
 * Digunakan untuk render field yang mempunyai opsi Ya | Tidak
 * Cara menggunakan:
 * pada datatables columns render
 * render: $.fn.dataTable.render.yaTidak()
 */
$.fn.dataTable.render.yaTidak = function () {
    return function ( data, type, row ) {

        if (data == 0){
            return '<span class="badge badge-plain">Tidak</span>';
        }else if(data == 1){
            return '<span class="badge badge-primary">Ya</span>';
        }else{
            return '<span class="badge badge-warning">INVALID</span>';
        }
        
    }
};

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
    var harga_unit, jumlah_unit, subtotal;
    harga_unit = parseFloat(edt.field(tabel+'.harga_unit').val());
    jumlah_unit = parseFloat(edt.field(tabel+'.jumlah_unit').val());

    subtotal = (jumlah_unit * harga_unit);
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

    diskon_jenis = parseFloat(edt.field(tabel+'.diskon_jenis').val());
    diskon_persen = parseFloat(edt.field(tabel+'.diskon_persen').val());
    diskon_value = parseFloat(edt.field(tabel+'.diskon_value').val());
    subtotal = parseFloat(edt.field(tabel+'.subtotal').val());

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
    dpp = (subtotal - diskon_final);
    
    edt.field(tabel+'.diskon_final').val(diskon_final);
    edt.field(tabel+'.dpp').val(dpp);
}