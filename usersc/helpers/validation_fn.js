/**
 * ------------------------------------------------------
 * Validasi Client Side 
 * Dipanggil pada event datatables editor preSubmit
 * Contributor: vincmeister, ferry ibnu
 * ------------------------------------------------------
 */

/**
 * Validasi
 *  Required
 * Kegunaan
 *  untuk validasi sebuah field wajib diisi
 * Cara Penggunaan:
 *  validasiRequired(edt, tabel, fields)
 * Parameter
 *  edt     : object    | nama variable datatables editor
 *  tabel   : string    | nama tabel database terkait
 *  fields  : array     | nama field dan value yang akan dicek
 * Contoh
 *  // set variable
 *  id_iicctmh = edtiimxxmh.field('iimxxmh.id_iicctmh').val();
 *  id_iiggrmh = edtiimxxmh.field('iimxxmh.id_iiggrmh').val();
 *  id_iibbrmh = edtiimxxmh.field('iimxxmh.id_iibbrmh').val();
 *  // panggil validasi 
 *  validasiRequired(
 *      edtiimxxmh,
 *      "iimxxmh",
 *      {
 *          "id_iicctmh": id_iicctmh, 
 *          "id_iiggrmh": id_iiggrmh, 
 *          "id_iibbrmh": id_iibbrmh
 *      }
 *  );
*/
function validasiRequired(edt, tabel, fields){

    Object.keys(fields).forEach(field_name => {
        
        if(!fields[field_name] || fields[field_name] === '' || fields[field_name] == '<p><br></p>') {

            edt.field(tabel + '.' + field_name).error('Wajib diisi!');
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
 *  field_edt           : string    | nama field pada datatables editor (tanpa nama table)
 *  nama_field          : string    | nama field pada tabel database yang akan di cek. Biasanya sama seperti field_edt
 *  nama_field_name    : any       | sesuai tipe data dari value yang akan dicek. Jika string harus diapit quote atau double quotes
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
            table_name: tabel,
            nama_field: nama_field,
            nama_field_value: nama_field_value,
            id_transaksi: id_transaksi
        },
        success: function ( json ) {
            if(json.data.count == 1){
                edt.field(tabel + '.' + field_edt).error( 'Data tidak boleh kembar!' );
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
    Object.keys(fields).forEach(field_name => {
        if (fields[field_name]) {
            if (emailRegex.test(fields[field_name])) {
                // Valid email format
            } else {
                edt.field(tabel + '.' + field_name).error('Email Tidak Valid!');
            }
        }
    });
}

/**
 *  VALIDASI TANGGAL lebih besar atau kecil

    CARANYA SAMA SEPERTI VALIDASI REQUIRED
 */
function validasiTanggal(edt, tabel, fields){

    tanggalsekarang    	= moment().format('YYYY-MM-DD');
    Object.keys(fields).forEach(field_name => {

        if( fields[field_name] < tanggalsekarang ){
            edt.field(tabel + '.' + field_name).error( 'Tanggal harus lebih besar dari sekarang!' );
        }
    });
}