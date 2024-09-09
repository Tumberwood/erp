<?php

	include( "../../../../users/init.php" );
	include( "../../../../usersc/lib/DataTables.php" );

	require '../../../../usersc/vendor/autoload.php';
	use Carbon\Carbon;
	
	use
		DataTables\Editor,
		DataTables\Editor\Query,
		DataTables\Editor\Result;

	if (isset($_POST['id_isoxxth_upload']) && $_POST['id_isoxxth_upload'] > 0){
		$id_isoxxth_upload		= $_POST['id_isoxxth_upload'];
        
        $qs_selisih_row = $db
            ->raw()
            ->bind(':id_isoxxth_upload', $id_isoxxth_upload)
            ->exec('SELECT
                        kode,
                        nama,
                        s_jumlah_terkecil,
                        s_fisik,
                        keterangan,
                        s_selisih_final,
                        s_transaksi_in,
                        s_transaksi_out,
                        s_selisih
                    FROM 
                    (
                        SELECT * FROM 
                        (
                            SELECT
                                a.kode,
                                a.nama,
                                a.jumlah_terkecil AS s_jumlah_terkecil,
                                a.fisik AS s_fisik,
                                CONCAT(ifnull(GROUP_CONCAT(a.keterangan_penjelasan SEPARATOR ", "), ""), ifnull(GROUP_CONCAT(fis.keterangan SEPARATOR ", "),"")) AS keterangan,
                                a.selisih_final AS s_selisih_final,
                                a.transaksi_in AS s_transaksi_in,
                                a.transaksi_out AS s_transaksi_out,
                                a.selisih AS s_selisih
                            FROM isoittd_upload AS a
                            LEFT JOIN isoxxth_upload th ON th.id = a.id_isoxxth_upload
                            LEFT JOIN isoittd_upload_fisik fis ON fis.id_isoittd_upload = a.id
                            WHERE (a.id_isoxxth_upload = :id_isoxxth_upload OR th.id_isoxxth_upload_parent = :id_isoxxth_upload) 
                            AND a.transaction_state <> -9 
                            AND a.fisik IS NOT NULL
                            GROUP BY a.id
                            HAVING s_selisih_final < 0
                            ORDER BY s_selisih_final ASC
                        ) AS subquery1
                        
                        UNION ALL
                        
                        SELECT * FROM 
                        (
                            SELECT
                                a.kode,
                                a.nama,
                                a.jumlah_terkecil AS s_jumlah_terkecil,
                                a.fisik AS s_fisik,
                                CONCAT(ifnull(GROUP_CONCAT(a.keterangan_penjelasan SEPARATOR ", "), ""), ifnull(GROUP_CONCAT(fis.keterangan SEPARATOR ", "),"")) AS keterangan,
                                a.selisih_final AS s_selisih_final,
                                a.transaksi_in AS s_transaksi_in,
                                a.transaksi_out AS s_transaksi_out,
                                a.selisih AS s_selisih
                            FROM isoittd_upload AS a
                            LEFT JOIN isoxxth_upload th ON th.id = a.id_isoxxth_upload
                            LEFT JOIN isoittd_upload_fisik fis ON fis.id_isoittd_upload = a.id
                            WHERE (a.id_isoxxth_upload = :id_isoxxth_upload OR th.id_isoxxth_upload_parent = :id_isoxxth_upload) 
                            AND a.transaction_state <> -9 
                            AND a.fisik IS NOT NULL
                            GROUP BY a.id
                            HAVING s_selisih_final > 0
                            ORDER BY s_selisih_final DESC
                        ) AS subquery2
                    ) item;
        
                    '
                    );
        $rs_selisih_row = $qs_selisih_row->fetchAll();

        $results = array();
		$results['data6'] = $rs_selisih_row;

    } else {
		$results['data6'] = [];
	}

	echo json_encode($results);
?>