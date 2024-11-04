<script>
    function ribuan(number) {
        return parseFloat(number).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    function tableAwal() {
        $.ajax({
			url: "../../models/hpyxxth/fn_hpcxxmh.php",
			dataType: 'json',
			type: 'POST',
			success: function (json) {
				// Create an empty table
				var str1 = '<table id="tblhpyemtd" class="table table-striped table-bordered table-hover nowrap" width="100%">';
				str1 += '<thead>';
				str1 += '<tr>';
				var sum1 = 0; // Sum of columns starting with "1"
				var sum2 = 0; // Sum of columns starting with "2"

				// Loop through columns and add them to the table header
				str1 += '<th>Nama</th>';
				$.each(json.data.rs_hpcxxmh, function (k, colObj) {

					str1 += '<th';
					if (colObj.jenis == 2) {
						str1 += ' class="text-danger"';
					}
					str1 += '>' + colObj.nama + '</th>';
				});

				str1 += '<th>Gaji Bersih</th>';
				str1 += '<th>Pembulatan</th>';
				str1 += '<th>Gaji Diterima</th>';
				str1 += '</tr>';
				str1 += '</thead>';
				str1 += '<tbody>'; // Start the tbody

				// Check if there is any data to add
				if (json.data.rs_hpcxxmh.length > 0) {
					$.each(json.data.rs_hpcxxmh.data, function (i, row) {
						str1 += '<tr>';
						// Populate your row data here
						// Assuming row is an object with keys matching the headers
						str1 += '<td></td>';
						$.each(row, function (key, value) {
							str1 += '<td>' + value + '</td>';
						});
						// Calculate and append Gaji Bersih, Pembulatan, Gaji Diterima
						var gajiBersih = sum1 - sum2; // Example calculation
						var pembulatan = gajiBersih % 100;
						str1 += '<td>' + gajiBersih + '</td>';
						str1 += '<td>' + pembulatan + '</td>';
						str1 += '<td>' + (gajiBersih + pembulatan) + '</td>'; // Example for Gaji Diterima
						str1 += '</tr>';
					});
				} else {
					// If no data, add a single row indicating no data available
					str1 += '<tr><td colspan="' + (json.data.rs_hpcxxmh.nama.length + 3) + '" class="text-center">No data available</td></tr>';
				}

				str1 += '</tbody>'; // End tbody
				str1 += '</table>';

				// Update the table element
				$('#tabel_atas').html(str1);

				// Initialize DataTable
				$('#tblhpyemtd').DataTable({
					lengthChange: false,
					responsive: false,
					fixedHeader: {
						header: false,
					},
					buttons: [
						// Add your buttons configuration here
					],
				});

			}
		});
    }

    function generateTable(id_hpyxxth) {
        $('#tabel_atas').empty();
        $.ajax({
            url: "../../models/hpyxxth/hpyemtd_dinamis.php",
            dataType: 'json',
            type: 'POST',
            data: {
                id_hpyxxth: id_hpyxxth
            },
            success: function (json) {
                if (json.data.length > 0) {
                    // Create an empty table
                    var str1 = '<table id="tblhpyemtd" class="table table-striped table-bordered table-hover nowrap" width="100%">';
                    str1 += '<thead>';
                    str1 += '<tr>';
                    var sum1 = 0; // Sum of columns starting with "1"
                    var sum2 = 0; // Sum of columns starting with "2"

                    // Loop through columns and add them to the table header
                    $.each(json.columns, function (k, colObj) {
                        str1 += '<th';
                        if (/^2\w+/.test(colObj.data)) {
                            str1 += ' class="text-danger"';
                        }
                        str1 += '>' + colObj.data.substr(1) + '</th>';
                    });


                    str1 += '<th>Gaji Bersih</th>';
                    str1 += '<th>Pembulatan</th>';
                    str1 += '<th>Gaji Diterima</th>';
                    str1 += '</tr>';
                    str1 = str1 + '</thead>';
                    str1 += '<tbody>';

                    // Loop through data and add rows to the table body
                    $.each(json.data, function (index, rowData) {
                        str1 += '<tr>';
                        sum1 = 0; // Reset the sum for each row
                        sum2 = 0; // Reset the sum for each row

                        $.each(json.columns, function (k, colObj) {
                            var columnName = colObj.data;
                            var cellValue = rowData[columnName];

                            if (/^9\w+/.test(colObj.data)) {
                                str1 += '<td>' + cellValue + '</td>';
                            } else {
                                cellValue = ribuan(parseFloat(cellValue) || 0);
                                str1 += '<td class="text-right">' + cellValue + '</td>';
                            }
                            
                            if (/^1\w+/.test(colObj.data)) {
                                sum1 += parseFloat(rowData[columnName]) || 0;
                            } else if (/^2\w+/.test(colObj.data)) {
                                sum2 += parseFloat(rowData[columnName]) || 0;
                            }
                        });

                        var gajiBersih = sum1 - sum2;
                        var pembulatan = gajiBersih % 100;
                        var gajiDiterima = gajiBersih - pembulatan;
                        gajiBersih = ribuan(Math.floor(gajiBersih));
                        pembulatan = ribuan(Math.floor(pembulatan));
                        gajiDiterima = ribuan(Math.floor(gajiDiterima));
                        str1 += '<td class="text-right">' + gajiBersih + '</td>';
                        str1 += '<td class="text-right">' + pembulatan + '</td>';
                        str1 += '<td class="text-right">' + gajiDiterima + '</td>';
                        str1 += '</tr>';
                    });

                    str1 += '</tbody>';
                    str1 += '</table>';

                    // Update the table element
                    $('#tabel_atas').html(str1);
                } else {
                    tableAwal();
                }
            }
        });
    }
</script>
