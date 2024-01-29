/**
// Validasi Required

id_iicctmh = edtiimxxmh.field('iimxxmh.id_iicctmh').val();
id_iiggrmh = edtiimxxmh.field('iimxxmh.id_iiggrmh').val();
id_iibbrmh = edtiimxxmh.field('iimxxmh.id_iibbrmh').val();

isRequiredValid(
    edtiimxxmh, 
    "iimxxmh", 
    {
        "id_iicctmh": id_iicctmh, 
        "id_iiggrmh": id_iiggrmh, 
        "id_iibbrmh": id_iibbrmh
    }
);
*/

function isRequiredValid(edt, tabel, fields){

    Object.keys(fields).forEach(nama_fields => {
        
        if(!fields[nama_fields] || fields[nama_fields] === '') {

            edt.field(tabel + '.' + nama_fields).error('Wajib diisi!');
        }
    });
}

/**
 * 
// Validasi default akan muncul saat kurang atau sama dengan 0
isNumberValid(
    edtiimummd, 
    "iimummd", 
    {
        "jumlah_konversi": jumlah_konversi
    }
);

// VALIDASI NUMBER dengan def_number validation
isNumberValid(
    edtiimummd, 
    "iimummd", 
    {
        "panjang": panjang, 
        "lebar": lebar, 
        "tinggi": tinggi, 
        "nw": nw, 
        "gw": gw
    },
    -1 //Ini adalah nilai yang menjadi validasi. Jika nilai kurang dari -1 maka akan dapat validasi
);
 */

function isNumberValid(edt, tabel, fields, number){
    if (number == null) {
        number = 0;
    }

    Object.keys(fields).forEach(nama_fields => {
        
        if(fields[nama_fields] <= number ){
            edt.field(tabel + '.' + nama_fields).error( 'Inputan harus > 0' );
        }
        
        // validasi angka
        if(isNaN(fields[nama_fields]) ){
            edt.field(tabel + '.' + nama_fields).error( 'Inputan harus berupa Angka!' );
        }
    });
}

/**
 * VALIDASI OLD
 * // BEGIN of cek unik iimummd.id_iumxxmh 
    if(action == 'create'){
        id_iimummd = 0;
    }
    
    $.ajax( {
        url: '../../../helpers/validate_fn_unique.php',
        dataType: 'json',
        type: 'POST',
        async: false,
        data: {
            table_name: 'iimummd',
            nama_field: 'id_iimxxmh,id_iumxxmh',
            nama_field_value: id_iimxxmh+','+id_iumxxmh,
            id_transaksi: id_iimummd
        },
        success: function ( json ) {
            if(json.data.count == 1){
                edtiimummd.field('iimummd.id_iumxxmh').error( 'Data tidak boleh kembar!' );
            }
        }
    } );
    // END of cek unik iimummd.id_iumxxmh 

    MENJADI ->

 * isCekUnikValid(
        edtiimummd, 					//variable editor
        "iimummd", 						//Nama tabel
        "id_iumxxmh", 					//Nama Field Editor yang akan di validasi
        'id_iimxxmh,id_iumxxmh',		//nama_field
        id_iimxxmh+','+id_iumxxmh, 		//nama_field_value
        id_iimummd 						//id_transaksi
    );
 */
function isCekUnikValid(action, edt, tabel, field_edt, nama_field, nama_field_value, id_transaksi) {

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

//VALIDASI EMAIL, HARUS ADA SIMBOL @ DAN . 
// SIMBOL @ TIDAK BOLEH LEBIH DARI 1
function isEmailValid(edt, tabel, fields) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    Object.keys(fields).forEach(nama_fields => {
        if (fields[nama_fields]) {
            if (emailRegex.test(fields[nama_fields])) {
                // Valid email format
            } else {
                edt.field(tabel + '.' + nama_fields).error('Email Tidak Valid!');
            }
        }
    });
}
