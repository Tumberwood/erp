<?php

	include( "../../../../users/init.php" );
	include( "../../../../usersc/lib/DataTables.php" );

	require '../../../../usersc/vendor/autoload.php';
	use Carbon\Carbon;
	
	use
		DataTables\Editor,
		DataTables\Editor\Query,
		DataTables\Editor\Result;

	if (isset($_POST['id_isoxxth_upload_filter']) && $_POST['id_isoxxth_upload_filter'] > 0){
		$id_isoxxth_upload		= $_POST['id_isoxxth_upload_filter'];

        $qs_data = $db
            ->raw()
            ->bind(':id_isoxxth_upload', $id_isoxxth_upload)
            ->exec('SELECT
                        th.kode kode_sou,
                        CONCAT(ifnull(GROUP_CONCAT(a.keterangan SEPARATOR ", "), ""), ifnull(GROUP_CONCAT(fis.keterangan SEPARATOR ", "),"")) AS s_keterangan,
                        a.*,
                        DATE_FORMAT(a.expired_date, "%d %b %Y") expired_date
                    FROM isoittd_upload AS a
                    INNER JOIN isoxxth_upload th ON th.id = a.id_isoxxth_upload
                    INNER JOIN isoittd_upload_fisik fis ON fis.id_isoittd_upload = a.id
                    WHERE (a.id_isoxxth_upload = :id_isoxxth_upload OR th.id_isoxxth_upload_parent = :id_isoxxth_upload) 
                    AND a.transaction_state <> -9 
                    GROUP BY a.id
                    '
                    );
        $rs_data = $qs_data->fetchAll();

        $results = array();
		$results = array();
        $results['data'] = array_map(function($row) {
            return array(
                'DT_RowId' => 'row_'.$row['id'],  // This gives each row a unique identifier
                'id' => $row['id'],
                'kode_sou' => $row['kode_sou'],
                's_keterangan' => $row['s_keterangan'],
                'lokasi' => $row['lokasi'],
                'lpn' => $row['lpn'],
                'nama' => $row['nama'],
                'kode' => $row['kode'],
                'batch_number' => $row['batch_number'],
                'expired_date' => $row['expired_date'],
                'satuan' => $row['satuan'],
                'jumlah_terkecil' => $row['jumlah_terkecil'],
                'fisik' => $row['fisik'],
                'selisih' => $row['selisih'],
                'transaksi_in' => $row['transaksi_in'],
                'transaksi_out' => $row['transaksi_out'],
                'selisih_final' => $row['selisih_final'],
                'qty_penjelasan' => $row['qty_penjelasan'],
                'keterangan_penjelasan' => $row['keterangan_penjelasan'],
                'is_skip' => $row['is_skip'],
                'transaction_state' => $row['transaction_state'],
                'id_isoxxth_upload' => $row['id_isoxxth_upload'],
                // other fields...
            );
        }, $rs_data);
        
	} else {
		$results['data'] = [];
	}

	echo json_encode($results);
?>