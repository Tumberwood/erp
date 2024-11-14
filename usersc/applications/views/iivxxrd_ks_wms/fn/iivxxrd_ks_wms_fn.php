<script>
    function getTitle() {
        $.ajax( {
            url: "../../models/iivxxrd_ks/fn_satuan_terkecil.php",
            dataType: 'json',
            async: false,
            type: 'POST',
            data: {
                id_iimxxmh: id_iimxxmh,
            },
            success: function ( json ) {
                iumxxmh_kode = json.data.iumxxmh_kode;
                
				autofillField('iimxxmh', id_iimxxmh, 'kode,nama');
				iimxxmh_nama = autofillData.nama;
				iimxxmh_kode = autofillData.kode;

				autofillField('iwhxxmh', id_iwhxxmh, 'kode,nama');
				iwhxxmh_nama = autofillData.nama;

                html = `
				<div class="row">
					<div class="col-6">
                        <h3>Item: ${iimxxmh_kode} - ${iimxxmh_nama}</h3>
                    </div>
					<div class="col-6">
                        <h3>Warehouse: ${iwhxxmh_nama}</h3>
                    </div>
				</div>
				<div class="row">
					<div class="col-6">
                        <h3>UoM: ${iumxxmh_kode}</h3>
                    </div>
				</div>
                <hr>
                `;

				$('#nama_item').html(html);

            }
        } );
    }
</script>