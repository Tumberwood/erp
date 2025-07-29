<script>
    function wloxxmh_generate_nama (){
        id_wlotpmh = edtwloxxmh.field('wloxxmh.id_wlotpmh').val();

        if (id_wlotpmh == 4) {
            if(iwhxxmh_kode != '' && rack_name !='' && bay_name != '' && depth_name != '' && level_name != ''){
                wloxxmh_nama = iwhxxmh_kode + '-' + rack_name + '-' + bay_name + '-' + depth_name + '-' + level_name;
            }else{
                wloxxmh_nama = '';
            }
        } else {
            if(iwhxxmh_kode != '' && rack_name !='' && bay_name != '' && level_name != '' && position_name != ''){
                wloxxmh_nama = iwhxxmh_kode + '-' + rack_name + '-' + bay_name + '-' + level_name + '-' + position_name;
            }else{
                wloxxmh_nama = '';
            }
        }

        edtwloxxmh.field('wloxxmh.nama').val(wloxxmh_nama);
    };

    function getSelectedRowIds() {
        var selectedData = tblwloxxmh.rows({ selected: true }).data();
        var ids = [];

        for (var i = 0; i < selectedData.length; i++) {
            ids.push(selectedData[i].wloxxmh.id);
        }

        return ids;
    }
</script>