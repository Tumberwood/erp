<script>
    function wloxxmh_generate_nama (){
        if(iwhxxmh_kode != '' && rack_name !='' && bay_name != '' && level_name != '' && position_name != ''){
            wloxxmh_nama = iwhxxmh_kode + '-' + rack_name + '-' + bay_name + '-' + level_name + '-' + position_name;
        }else{
            wloxxmh_nama = '';
        }
        edtwloxxmh.field('wloxxmh.nama').val(wloxxmh_nama);
    };

    function validasiKapasitas(){
        
    }

</script>