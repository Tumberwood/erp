<script>
    function loadFoto(){
        $.ajax( {
            url: "../../models/core/dashboard_foto.php",
            dataType: 'json',
            type: 'POST',
            data: {
            },
            success: function ( json ) {
                var html;
                if (json.data.hemxxmh) {
                    var url_foto = json.data.hemxxmh.url_foto;

                    html = `
                        <img src="${url_foto}" class="rounded-circle circle-border m-b-md" alt="profile">
                    `;

                } else {
                    html = `
                        <img src="../../../files/uploads/def_male.png" class="rounded-circle circle-border m-b-md" alt="profile">
                    `;
                }
                document.getElementById('foto_profile').innerHTML = html;   
            }
        } );
    };
    
    function loadKehadiran(){
        $.ajax( {
            url: "../../models/core/dashboard_kehadiran.php",
            dataType: 'json',
            type: 'POST',
            data: {
            },
            success: function ( json ) {
                let leftColumn= `<ul class="list-group clear-list m-t">`;
                let rightColumn= `<ul class="list-group clear-list m-t">`;

                json.data.hemxxmh.forEach(item => {
                    if (item.jenis == 1) {
                        leftColumn += `
                        <li class="list-group-item fist-item">
                            <span class="label">${item.c_leave}</span>&nbsp ${item.nama}
                        </li>`; 

                    } else if (item.jenis == 2) {
                        rightColumn += `
                        <li class="list-group-item fist-item">
                            <span class="label">${item.c_leave}</span>&nbsp ${item.nama}
                        </li>`; 
                    }
                });
                leftColumn += `</ul>`;
                rightColumn += `</ul>`;

                const html = `
                    <div class="row">
                        <div class="col-6">${leftColumn}</div>
                        <div class="col-6">${rightColumn}</div>
                    </div>
                `;

                document.getElementById('httlpmh').innerHTML = html;            }
        } );
    };
    
    function loadKedisiplinan(){
        $.ajax( {
            url: "../../models/core/dashboard_kedisiplinan.php",
            dataType: 'json',
            type: 'POST',
            data: {
            },
            success: function ( json ) {
                html = `<ul class="list-group clear-list m-t">`;

                json.data.hemxxmh.forEach(item => {
                    html += `
                    <li class="list-group-item fist-item">
                        <span class="label label-${item.bg_class}">${item.c_sp}</span>&nbsp ${item.nama}
                    </li>
                    `;
                });

                html += ` </ul>`;

                document.getElementById('hadxxmh').innerHTML = html;            }
        } );
    };

    function loadProfile (){
        $.ajax( {
            url: "../../models/core/d_dashboard_hemxxmh.php",
            dataType: 'json',
            type: 'POST',
            data: {
                // id_hemxxmh: id_hemxxmh
            },
            success: function ( json ) {
                hemxxmh_kode = json.data.hemxxmh.hemxxmh_kode;
                hemxxmh_nama = json.data.hemxxmh.hemxxmh_nama; 
                hodxxmh_nama = json.data.hemxxmh.hodxxmh_nama; 
                hetxxmh_nama = json.data.hemxxmh.hetxxmh_nama; 
                masakerja = json.data.hemxxmh.masakerja; 
                s_saldo = json.data.cuti.s_saldo; 
              
                $("#hemxxmh_nama").html(hemxxmh_nama);
                $("#hodxxmh_nama").html(hodxxmh_nama);
                $("#hetxxmh_nama").html(hetxxmh_nama);
                $("#masakerja").html(masakerja);
                $("#saldoCuti").html('<h4 id="saldoCuti">Saldo Cuti : '+s_saldo+'</h4>');
            }
        } );
    };
</script>