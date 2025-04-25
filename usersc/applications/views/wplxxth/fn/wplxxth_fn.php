<script>
    
    function wlpxxmh_kode_validasi (){
        wlpxxmh_kode = edtwpllptd.field('wpllptd.wlpxxmh_kode').val();
        if(wlpxxmh_kode != ""){
            // cek apakah master LPN ada
            $.ajax( {
                url: "../../models/wreittd/wreittd_fn_wlpxxmh.php",
                dataType: 'json',
                type: 'POST',
                data: {
                    wlpxxmh_kode: wlpxxmh_kode
                },
                success: function ( json ) {
                    if(json.data.status_code == 500){
                        edtwpllptd.field('wpllptd.wlpxxmh_kode').error( json.data.message );
                        edtwpllptd.field('wpllptd.wlpxxmh_kode').val('');
                    }
                }
            } );
            
        }
    };
    
    function konversiJumlah(id_iimxxmh, id_iumxxmh_unit){
        $.ajax( {
            url: "../../models/wktxxth/wktxxth_backdate_konversi_jumlah.php",
            dataType: 'json',
            type: 'POST',
            async: false,
            data: {
                id_iimxxmh: id_iimxxmh,
                id_iumxxmh_unit: id_iumxxmh_unit,
            },
            success: function ( json ) {
                jumlah_konversi = json.data.jumlah_konversi;
            }
        } );
    };

    function cekBelumConfirm() {
        $.ajax( {
            url: "../../models/wplxxth/wplxxth_fn_count_pl.php",
            dataType: 'json',
            type: 'POST',
            async: false,
            data: {
            },
            success: function ( json ) {
                c_id = json.data.c_id;

                if (c_id == 0) {
			        window.removeEventListener('beforeunload', confirmLeavePage)
                } else {
                    window.addEventListener('beforeunload', confirmLeavePage);
                }
            }
        } );

    }

    function confirmLeavePage(event) {
        event.preventDefault();
        console.log(c_id);
        toastr["warning"]("Terdapat "+c_id+" Data PL yang sudah di generate namun belum confirm!","WARNING")

    }

    function btnGenerateLPN() {
        var date = new Date().getTime();
        var timestamp = moment(timestamp).format('YYYY-MM-DD HH:mm:ss');
        console.log(uniqueToken);
        toastr["info"]("Processing ...</br> Jangan tutup halaman sampai notifikasi ini hilang!","INFO")

        $.ajax( {
        	url: "../../models/wplxxth/wplxxth_fn_gen_lpn.php",
        	dataType: 'json',
        	type: 'POST',
        	data: {
        		id_transaksi_h: id_transaksi_h,
        		uniqueToken: uniqueToken,
        		timestamp: timestamp
        	},
        	success: function ( json ) {
        		status_code = json.data.status_code;
        		// if (status_code == 200) {
        			toastr[json.data.type_message](json.data.message,"INFO");
        			cekBelumConfirm();
        			tblwplxxth.ajax.reload(null, false);
        			tblwpllptd.ajax.reload(null, false);
        			tblwplxxth.rows().deselect();
        		// }
        	}
        } );
    }

    function rowGroupConfig(dataSrc) {
        return {
            dataSrc: function (row) {
                return row[dataSrc];
            },
            endRender: function (rows, group) {
                var sum_terkecil = rows
                    .data()
                    .pluck('wpllptd.jumlah_terkecil')
                    .map(function (terkecil) {
                        return parseFloat(terkecil) || 0;
                    })
                    .reduce(function (a, b) {
                        return a + b;
                    }, 0);

                var sum_default = rows
                    .data()
                    .pluck('wpllptd.jumlah_default')
                    .map(function (def) {
                        return parseFloat(def) || 0;
                    })
                    .reduce(function (a, b) {
                        return a + b;
                    }, 0);

                sum_terkecil = $.fn.dataTable.render.number(',', '.', 0, '').display(sum_terkecil);
                sum_default = $.fn.dataTable.render.number(',', '.', 2, '').display(sum_default);

                return $('<tr/>')
                    .append('<td class="font-bold text-success">Total</td>')
                    .append('<td></td>')
                    .append('<td></td>')
                    .append('<td></td>')
                    .append('<td></td>')
                    .append('<td class="text-right font-bold bg-success">' + sum_terkecil + '</td>')
                    .append('<td></td>')
                    .append('<td class="text-right font-bold bg-success">' + sum_default + '</td>')
                    .append('<td></td>')
                    .append('<td></td>')
                    .append('<td></td>');
            }
        };
    }

</script>