<?php
	/*
        231011 - 2.1.1
            - Menggabungkan Void disini
            - Mengganti nama variable state -> status_approval

        220827 - 2.0.0
            Mengubah query dengan menggunakan class bawaan dari datatables
		
		Kegunaan:
            - Mengubah is_approve transaksi menjadi 1 (menandakan data sudah di approve)
            - Insert log ke table activity_log_ml

        Parameter:
            - $tbl_name
		    - $id_transaksi
	*/
	
	require_once( "../../users/init.php" );
	require_once( "../../usersc/lib/DataTables.php" );
    require_once( "datatables_fn_debug.php" );
    require_once( "hakakses_s_fn.php" );

	use
		DataTables\Editor,
		DataTables\Editor\Query,
		DataTables\Editor\Result;

    // BEGIN definisi variable untuk fn_ajax_results.php
    $data      = array();
    $rs_opt    = array();
    $c_rs_opt  = 0;
    $morePages = 0;
    // END definisi variable untuk fn_ajax_results.php
	
	$tbl_name   = $_POST['table_name'];
	$id_transaksi = $_POST['id_transaksi'];
	$id_gaplgtd   = $_POST['id_gaplgtd'];
	$level_ke   = $_POST['level_ke'];

    if($_POST['approval_state'] == 1){
        $status_approval = 'Approve ';
    }elseif($_POST['approval_state'] == -1){
        $status_approval = 'Cancel Approve ';
    }elseif($_POST['approval_state'] == -9){
        $status_approval = 'Void';
    }else{
        $status_approval = 'Invalid ';
    }

    $notes          = $status_approval . $tbl_name . ' , id = '. $id_transaksi;

    try{
        $db->transaction();

        // BEGIN update approval_state gaplgtd
        $qu_gaplgtd = $db
            ->query('update', 'gaplgtd')
            ->set('approval_state', 1)
            ->where('id', $id_gaplgtd)
            ->exec();
        // END update approval_state gaplgtd

        // cek apakah setelah update approval_state gaplgtd, sudah merupakan yang final
        // ditandai dengan approval_state sudah tidak ada yang 0
        $qs_gaplgtd = $db
            ->raw()
            ->bind(':tbl_name', $tbl_name)
            ->bind(':id_transaksi', $id_transaksi)
            ->exec('
                SELECT
                    approval_state
                FROM gaplgtd
                WHERE 1
                    AND tbl_name = :tbl_name 
                    AND id_transaksi = :id_transaksi
                    AND approval_state = 0
            ');
        $rs_gaplgtd = $qs_gaplgtd->fetchAll();
        if(empty($rs_gaplgtd)){
            $approval_state_final = 9;
        }else{
            $approval_state_final = 1;
        }

        // BEGIN get gaplgtd.start_at
        $qs_gaplgtd = $db
            ->query('select', 'gaplgtd' )
            ->get([
                'gaplgtd.start_at as start_at'
            ] )
            ->where('gaplgtd.id', $id_gaplgtd )
            ->exec();
        $rs_gaplgtd = $qs_gaplgtd->fetch();
        $start_at   = $rs_gaplgtd['start_at'];
        // END get gaplgtd.start_at

        // BEGIN update transaksi approval_state
        $qu_transaksi = $db
            ->query('update', $tbl_name)
            ->set('approval_state', $approval_state_final )
            ->where('id', $id_transaksi )
            ->exec();
        // END update transaksi approval_state

        // BEGIN insert activity_log_ml
        $qi_log = $db
            ->query('insert', 'activity_log_ml')
            ->set('id_transaksi',$id_transaksi)
            ->set('kode', strtoupper($status_approval))
            ->set('nama', $tbl_name )
            ->set('keterangan', $notes )
            ->set('created_by', $s_id_users)
            ->set('username', $s_username)
            ->set('start_on', $start_at)
            ->set('finish_on', date("Y-m-d H:i:s"))
            ->set('durasi_detik', strtotime(date("Y-m-d H:i:s")) - strtotime($start_at))
            ->exec();
        // END insert activity_log_ml

        // jika Void, maka transaction_state diubah menjadi closed 9
        // BEGIN close 
        if( $_POST['approval_state'] == -9 ){
            $qu = $db
                ->query('update', $tbl_name )
                ->set('transaction_state', 9 )
                ->where('id',$id_transaksi)
                ->exec();
        }
        // END close 

        //27 Des 2024 - Ferry
        //Ambil level tertinggi dalam transaksi yang 
        $qs_gaplgtd = $db
            ->raw()
            ->bind(':id_transaksi', $id_transaksi)
            ->bind(':tbl_name', $tbl_name)
            ->exec('SELECT
                        MAX(a.level_ke) level_final
                    FROM gaplgtd a
                    WHERE a.tbl_name = :tbl_name AND  a.id_transaksi = :id_transaksi
        ');
        $rs_gaplgtd = $qs_gaplgtd->fetch();
        $level_final = $rs_gaplgtd['level_final'];

        if ($level_ke == $level_final) {
            //Jika yang approve ini adalah level terakhir
            //maka update approval_state = -8 atau bypass untuk transaksi dibawah level final, hanya berlaku yg belum diapprove.
            $qs_gaplgtd = $db
                ->raw()
                ->bind(':id_transaksi', $id_transaksi)
                ->bind(':tbl_name', $tbl_name)
                ->bind(':level_final', $level_final)
                ->exec('UPDATE gaplgtd a
                        SET
                            is_direct_approval = 1,
                            approval_state = -8
                        WHERE a.tbl_name = :tbl_name AND  a.id_transaksi = :id_transaksi
                        AND a.approval_state = 0 
                        AND a.level_ke < :level_final
            ');
        }

        $db->commit();
        
        $status_code = 200;
        $message = 'Proses '.$status_approval.'Berhasil';
        $type_message = 'success';

    }catch(PDOException $e){
		// rollback on error
		$db->rollback();

        $status_code = 500;
        $message = 'Proses '.$status_approval.'Gagal';
        $type_message = 'danger';

	}

    $data = array(
        'status_code'    => $status_code,
        'message'      => $message,
		'type_message' => $type_message
    );

    // tampilkan results
    require_once( "fn_ajax_results.php" );
	
?>