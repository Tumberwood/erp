/**
 * Validasi Client Side 
 * Dipanggil pada event datatables editor preSubmit
 * Contributor: vincmeister, ferry ibnu
 * 
 * General Rules
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
 * 
 * Available function:
 *  validasiRequired
 */



/**
 * validasiRequired
 * Digunakan untuk validasi field wajib diisi
 * Cara Penggunaan:
 *  validasiRequired(edt, tbl_name, fields)
 * @param {Object} edt variable datatables editor
 * @param {String} tbl_name nama tabel database
 * @param {String} fields nama fields database, bisa multiple, dipisahkan dengan koma
 * Contoh:
 *  // set variable
 *  id_iicxxmh = edtiimxxmh.field('iimxxmh.id_iicxxmh').val();
 *  id_iigxxmh = edtiimxxmh.field('iimxxmh.id_iigxxmh').val();
 *  id_iibxxmh = edtiimxxmh.field('iimxxmh.id_iibxxmh').val();
 *  // panggil validasi 
 *  validasiRequired(
 *      edtiimxxmh,
 *      "iimxxmh",
 *      {
 *          "id_iicxxmh": id_iicxxmh, 
 *          "id_iigxxmh": id_iigxxmh, 
 *          "id_iibxxmh": id_iibxxmh
 *      }
 *  );
 */
function validasiRequired(edt, tbl_name, fields){
    Object.keys(fields).forEach(field_name => {
        
        if(!fields[field_name] || fields[field_name] === '' || fields[field_name] == '<p><br></p>') {

            edt.field(tbl_name + '.' + field_name).error('Wajib diisi!');
        }
    });
}

/**
 * Validasi
 *  Unique Value
 * Kegunaan
 *  untuk validasi sebuah field harus mempunyai data yang unik dalam satu tabel database
 * Cara Penggunaan
 *  validasiUnique(action, edt, tabel, field_edt, nama_field, nama_field_name, id_transaksi)
 * Parameter
 *  action              : action    | trigger action datatables editor
 *  edt                 : object    | nama variable datatables editor
 *  tabel               : string    | nama tabel database terkait
 *  field_edt           : string    | nama field pada datatables editor (tanpa nama table). multiple, pisahkan dengan koma
 *  nama_field          : string    | nama field pada tabel database yang akan di cek. Biasanya sama seperti field_edt
 *  nama_field_value    : any       | sesuai tipe data dari value yang akan dicek. Jika string harus diapit quote atau double quotes
 *  id_transaksi        : int       | id dari transaksi yang akan dicek. Diambilkan dari variable id__blank
 * Contoh
 *  // set variable
 *  nama = edtiimxxmh.field('iimxxmh.nama').val();
 *  // panggil validasi
 *  validasiUnique(
 *      action,
 *      edtiimxxmh,
 *      'iimxxmh',
 *      'nama',
 *      'nama',
 *      nama,
 *      id_iimxxmh
 *  );
 */
function validasiUnique(action, edt, tabel, field_edt, nama_field, nama_field_value, id_transaksi) {

    if(action == 'create'){
        id_transaksi = 0;
    }
    
    $.ajax( {
        url: '../../../helpers/validate_fn_unique.php',
        dataType: 'json',
        type: 'POST',
        async: false,
        data: {
            table_name      : tabel,
            nama_field      : nama_field,
            nama_field_value: nama_field_value,
            id_transaksi    : id_transaksi
        },
        success: function ( json ) {
            if(json.data.count > 0){
                var arr_field = field_edt.split(",");
                $.each(arr_field,function(i){
                    edt.field(tabel + '.' + arr_field[i]).error( 'Data tidak boleh kembar!' );
                 });
            }
        }
    } );
}

/**
 * Validasi
 *  Number
 * Kegunaan
 *  untuk validasi sebuah nulai apakah berupa angka atau bukan
 * Cara Penggunaan:
 *  validasiNumber(edt, tabel, fields, number, operator)
 * Parameter
 *  edt     : object    | nama variable datatables editor
 *  tabel   : string    | nama tabel database terkait
 *  fields  : array     | nama field yang akan divalidasi
 *  number  : numeric   | nilai batas validasi (opsional. def: 0)
 *  operator: string    | operator pembanding (opsional. def: =)
 * Contoh
 *  // set variable
 *  panjang = edtiimummd.field('iimummd.panjang').val();
 *  lebar = edtiimummd.field('iimummd.lebar').val();
 *  // panggil validasi 
 *  validasiNumber(
 *      edtiimummd, 
 *      "iimummd", 
 *      {
 *          "panjang": panjang, 
 *          "lebar": lebar
 *      },
 *      0,
 *      '>='
 *  );
*/
function validasiNumber(edt, tabel, fields, number, operator){

    Object.keys(fields).forEach(field_name => {

        // validasi angka atau bukan
        if(isNaN(fields[field_name]) ){
            edt.field(tabel + '.' + field_name).error( 'Inputan harus berupa Angka!' );
        }
        
        if (number == null || operator == null) {
            // validasi angka atau bukan
            // jika null, maka artinya hanya validasi angka atau bukan saja
            
        }else{
            
            a = parseFloat(fields[field_name]);
            b = parseFloat(number);

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
        
    });
}

/**
 * Validasi
 *  Email
 * Kegunaan
 *  untuk validasi sebuah field harus berupa email address, ditandai dengan adanya @ dan . untuk domain
 * Cara Penggunaan:
 *  validasiEmail(edt, tabel, fields)
 * Parameter
 *  edt     : object    | nama variable datatables editor
 *  tabel   : string    | nama tabel database terkait
 *  fields  : array     | nama field dan value yang akan dicek
 * Contoh
 *  // set variable
 *  email       = edtpsuxxmh.field('psuxxmh.email').val();
 *  // panggil validasi 
 *  validasiEmail(
 *      edtpsuxxmh,
 *      "psuxxmh",
 *      {
 *          "email": email
 *      }
 *  );
*/
function validasiEmail(edt, tabel, fields) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    Object.keys(fields).forEach(function(key) {
        var value = fields[key];
        if(value){
            if (emailRegex.test(value)) {
                // Valid email format
            } else {
                edt.field(tabel + '.' + field_name).error('Email Tidak Valid!');
            }
        }
        
    });

}

/**
 * Validasi
 *  Different
 * Kegunaan
 *  untuk validasi 2 atau lebih fields tidak boleh mempunyai data yang sama
 * Cara Penggunaan:
 *  validasiDifferent(edt, tabel, fields)
 * Parameter
 *  edt     : object    | nama variable datatables editor
 *  tabel   : string    | nama tabel database terkait
 *  fields  : array     | nama field dan value yang akan dicek
 * Contoh
 *  // set variable
 *  id_aakxxmh_asal   = edtfbtxxth.field('fbtxxth.id_aakxxmh_asal').val();
 *  id_aakxxmh_tujuan = edtfbtxxth.field('fbtxxth.id_aakxxmh_tujuan').val();
 *  // panggil validasi 
 *  validasiDifferent(
 *      edtfbtxxth,
 *      "fbtxxth",
 *      {
 *          'id_aakxxmh_asal': id_aakxxmh_asal,
 *          'id_aakxxmh_tujuan': id_aakxxmh_tujuan
 *      }
 *  );
*/
function validasiDifferent(edt, tbl_name, fields){
    var checkedValues = {};
    var different = 0;
    Object.keys(fields).forEach(function(key) {
        var value = fields[key];
        
        // Periksa apakah nilai sudah pernah diperiksa sebelumnya
        if (checkedValues[value]) {
    		different = 1;
        } else {
            checkedValues[value] = true;
        }

    });

    // loop tampilkan error message di all related fields
    if(different == 1){
        Object.keys(fields).forEach(function(key) {
            edt.field(tbl_name + '.' + key).error( 'Data tidak boleh sama!' );
        });
    }
    
}

/**
 * validasiValidTanggal 
 * Digunakan untuk validasi apakah inputan tanggal sudah menggunakan format yang tepat
 * Format Standar: "DD MM YYYY"
 */
function validasiTanggalValid(edt, tbl_name, fields){

    Object.keys(fields).forEach(field_name => {
        console.log( );
        if( moment(fields[field_name]).isValid() == false ){
            edt.field(tbl_name + '.' + field_name).error('Format Tanggal Salah!');
        }
    });
}

/**
 * Digunakan untuk validasi tanggal terhadap hari ini
 * @param {Object} edt 
 * @param {Object} tbl_name 
 * @param {String} field 
 * @param {String} sign 
 */
function validasiTanggalToday(edt, tbl_name, fields_name, field_value, sign) {
    
    momentDate1 = moment(field_value);
    momentDate2 = moment(tanggal_hariini_dmy);

    if ( momentDate1.isAfter(momentDate2) || momentDate1.isSame(momentDate2)) {
        
    } else {
        edt.field(tbl_name + '.' + fields_name).error( 'Tanggal ' +fields_name+ ' harus '+ sign +' ' + tanggal_hariini_dmy );
    }

}

/**
 * validasiOutstanding
 * Digunakan untuk melakukan validasi jumlah terkecil yang bisa dibuat untuk transaksi lagi
 * Dipanggil pada editor preSubmit
 * @param {Object} edt 
 * @param {String} tbl_name 
 * @param {Number} id_transaksi 
 * @param {Number} id_transaksi_before 
 * @param {String} tbl_name_before 
 */
function validasiOutstanding(edt, tbl_name, id_transaksi, id_transaksi_before, tbl_name_before) {
    jumlah_unit     = edt.field(tbl_name+'.jumlah_unit').val();
    id_iimxxmh      = edt.field(tbl_name+'.id_iimxxmh').val();
    id_iumxxmh_unit = edt.field(tbl_name+'.id_iumxxmh_unit').val();

    $.ajax( {
        url: "../../../helpers/fn_validasi_outstanding.php",
        dataType: 'json',
        type: 'POST',
        async: false,
        data: {
            id_transaksi       : id_transaksi,
            id_transaksi_before: id_transaksi_before,
            tbl_name           : tbl_name,
            tbl_name_before    : tbl_name_before,
            jumlah_unit        : jumlah_unit,
            id_iimxxmh         : id_iimxxmh,
            id_iumxxmh_unit    : id_iumxxmh_unit
        },
        success: function (json) {
            jumlah_default_sisa = 'Sisa Maksimal ' + json.data.jumlah_default_sisa + ' ' + json.data.iumxxmh_default_kode;
            if (parseFloat(json.data.jumlah_terkecil_after) > parseFloat(json.data.jumlah_terkecil)) {
                edt.field(tbl_name+'.jumlah_unit').error( jumlah_default_sisa );
            }
        }

    } );
}

/**
 * validasiOutstandingNew
 * Digunakan untuk melakukan validasi jumlah terkecil yang bisa dibuat untuk transaksi lagi
 * Dipanggil pada editor preSubmit
 * @param {Object} edt 
 * @param {String} tbl_name 
 * @param {Number} id_transaksi 
 * @param {Number} id_transaksi_before 
 * @param {String} tbl_name_before 
 */
function validasiOutstandingNew(edt, tbl_name, id_transaksi, id_transaksi_before, tbl_name_before) {
    jumlah_unit     = edt.field(tbl_name+'.jumlah_unit').val();
    id_iimxxmh      = edt.field(tbl_name+'.id_iimxxmh').val();
    id_iumxxmh_unit = edt.field(tbl_name+'.id_iumxxmh_unit').val();

    $.ajax( {
        url: "../../../helpers/fn_validasi_outstanding_new.php",
        dataType: 'json',
        type: 'POST',
        async: false,
        data: {
            id_transaksi       : id_transaksi,
            id_transaksi_before: id_transaksi_before,
            tbl_name           : tbl_name,
            tbl_name_before    : tbl_name_before,
            id_iimxxmh         : id_iimxxmh,
            id_iumxxmh_unit    : id_iumxxmh_unit
        },
        success: function (json) {
            validasiSisa = 'Sisa Maksimal ' + json.data.jumlah_terkecil_os_validasi + ' ' + json.data.iumxxmh_kode_input;
            if (parseFloat(jumlah_unit) > parseFloat(json.data.jumlah_terkecil_os_validasi)) {
                edt.field(tbl_name+'.jumlah_unit').error( validasiSisa );
            }
        }

    } );
}

// BEGIN custom jquery-validation
$.validator.addMethod("validDate", function(value, element, dateFormat) {
    if (this.optional(element)) {
        return true;
    }
    return moment(value, dateFormat, true).isValid();
}, "Format tanggal salah! harap pilih dari Kalender");
// BEGIN custom jquery-validation

/**
 * validasiOutstandingMask
 * Digunakan untuk melakukan validasi jumlah terkecil yang bisa dibuat untuk transaksi lagi
 * Dipanggil pada editor preSubmit
 * @param {Object} edt 
 * @param {String} tbl_name 
 * @param {Number} id_transaksi 
 * @param {Number} id_transaksi_before 
 * @param {String} tbl_name_before 
 * @param {Object} jumlah_unit 
 */
 function validasiOutstandingMask(edt, tbl_name, id_transaksi, id_transaksi_before, tbl_name_before) {
    jumlah_unit      = edt.field(tbl_name+'.jumlah_unit').input().inputmask('unmaskedvalue');
    id_iimxxmh      = edt.field(tbl_name+'.id_iimxxmh').val();
    id_iumxxmh_unit = edt.field(tbl_name+'.id_iumxxmh_unit').val();

    $.ajax( {
        url: "../../../helpers/fn_validasi_outstanding.php",
        dataType: 'json',
        type: 'POST',
        async: false,
        data: {
            id_transaksi       : id_transaksi,
            id_transaksi_before: id_transaksi_before,
            tbl_name           : tbl_name,
            tbl_name_before    : tbl_name_before,
            jumlah_unit        : jumlah_unit,
            id_iimxxmh         : id_iimxxmh,
            id_iumxxmh_unit    : id_iumxxmh_unit
        },
        success: function (json) {
            jumlah_default_sisa = 'Sisa Maksimal ' + json.data.jumlah_default_sisa + ' ' + json.data.iumxxmh_default_kode;
            if (parseFloat(json.data.jumlah_terkecil_after) > parseFloat(json.data.jumlah_terkecil)) {
                edt.field(tbl_name+'.jumlah_unit').error( jumlah_default_sisa );
            }
        }

    } );
}
