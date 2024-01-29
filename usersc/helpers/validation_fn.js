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