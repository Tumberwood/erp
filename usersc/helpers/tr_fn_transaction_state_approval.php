<?php
	/**
     * Digunakan untuk meng-update approval_state
     * 1    : Approve
     * -1   : Cancel Approve
     * -9   : Void
     * 9    : Final Approve
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
	
	$table_name         = $_POST['table_name'];
	$id_transaksi       = $_POST['id_transaksi'];

    try{
        $db->transaction();
        
        // BEGIN ambil aturan approval
        $qs_gtbrlsh = $db
            ->raw()
            ->bind(':table_name', $table_name)
            ->exec('
                SELECT
                    gtbrlsh.nama as gtbrlsh_nama,
                    gapxxsh.id as id_gapxxsh,
                    gapxxsh.jumlah_level as jumlah_level,
                    gaptpmh.nama as gaptpmh_nama
                FROM gtbrlsh
                JOIN gapxxsh ON gapxxsh.id_gtbrlsh = gtbrlsh.id
                JOIN gaptpmh ON gaptpmh.id = gapxxsh.id_gaptpmh
                WHERE 
                    tblheader = :table_name
            ');
        $rs_gtbrlsh   = $qs_gtbrlsh->fetch();
        $gtbrlsh_nama = $rs_gtbrlsh['gtbrlsh_nama'];
        $id_gapxxsh   = $rs_gtbrlsh['id_gapxxsh'];
        $jumlah_level = $rs_gtbrlsh['jumlah_level'];
        $gaptpmh_nama = $rs_gtbrlsh['gaptpmh_nama'];
        // END ambil aturan approval

        if($gaptpmh_nama == 'Amount'){
            $field_amount = ',grand_total ';
        }else{
            $field_amount = '';
        }
   
        $qs_log = $db
            ->raw()
            ->bind(':id_transaksi', $id_transaksi)
            ->bind(':kode', 'CONFIRM')
            ->bind(':table_name', $table_name)
            ->exec('
                SELECT
                    created_by as id_users_pengaju,
                    created_on
                FROM activity_log_ml
                WHERE 1
                    AND id_transaksi = :id_transaksi
                    AND kode = :kode
                    AND nama = :table_name
            ');
        $rs_log     = $qs_log->fetch();

        $qs_transaksi = $db
            ->raw()
            ->bind(':id_transaksi', $id_transaksi)
            ->exec('
                SELECT
                    kode 
                '
                    .$field_amount.
                'FROM '.$table_name.'
                WHERE 
                    id = :id_transaksi
            ');
        $rs_transaksi = $qs_transaksi->fetch();
        
        $kode = $rs_transaksi['kode'];

        // bagian ini mungkin bisa diubah masuk ke table gapxxsh atau gapdusd
        if($gaptpmh_nama == 'Amount'){
            $tr_amount = $rs_transaksi['grand_total'];
        }else{
            $tr_amount = 0;
        }
        
        $qs_gapdusd = $db
            ->raw()
            ->bind(':id_gapxxsh', $id_gapxxsh)
            ->bind(':tr_amount', $tr_amount)
            ->exec('
                SELECT 
                    id_users,
                    level_ke
                FROM gapdusd
                WHERE 1
                    AND id_gapxxsh = :id_gapxxsh
                    AND :tr_amount BETWEEN gaptpmh_value_fr AND IFNULL(gaptpmh_value_to,999999999999999999.99)
            ');
        $rs_gapdusd = $qs_gapdusd->fetch();
        
        $qi_gaplgtd = $db
            ->query('insert', 'gaplgtd')
            ->set('id_users', $rs_gapdusd['id_users'] )
            ->set('id_users_pengaju', $rs_log['id_users_pengaju'])
            ->set('id_transaksi', $id_transaksi )
            ->set('kode', $kode)
            ->set('nama', $gtbrlsh_nama)
            ->set('start_at', date('Y-m-d H:i:s'))
            ->set('tbl_name', $table_name)
            ->set('level_ke', $rs_gapdusd['level_ke'] )
            ->set('dt_pengajuan', $rs_log['created_on'] )
            ->set('transaction_state', 1 )
            ->exec();
                
        $db->commit();

        if($qi_gaplgtd){
            $data = array(
                'status_code'  => 200,
                'message'      => 'Setting Approval Berhasil Dilakukan',
                'type_message' => 'success'
            );
        }else{
            $data = array(
                'status_code'  => 500,
                'message'      => 'Setting Approval Gagal Dilakukan!',
                'type_message' => 'error'
            );
        }
        
    }catch(PDOException $e){
        $data = array(
		    'status_code'  => 500,
            'message'      => 'Setting Approval Gagal Dilakukan! ' . $e->getMessage(),
            'type_message' => 'error'
        );
		$db->rollback();

	}

    // tampilkan results
    require_once( "fn_ajax_results.php" );
	
?>