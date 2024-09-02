<?php
	/**
     * Digunakan untuk insert ke tabel Approval List (gaplgtd) berdasarkan Approval Setting (gapxxsh, gaplgtd, gapdusd)
     * id_gaptpmh
     * 1: Level         : hanya berdasarkan urutan, tanpa membedakan Divisi atau Department
     * 2: Amount        : berdasarkan grand_total
     * 3: Level Group   : berdasarkan urutan, dengan memperhatikan Divisi atau Department
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
    // END definisi variable untuk fn_ajax_results.php
	
	$state         = $_POST['state'];
	$table_name         = $_POST['table_name'];
	$id_transaksi       = $_POST['id_transaksi'];

    try{
        $db->transaction();
        /**
         * State 1 == is_need_approval = 1
         * State 0 == is_need_approval = 0
         */

        //jika is_need_approval = 1
        if ($state == 1) {/**
            * Ambil aturan approval berdasarkan apa
            */
            $qs_gtbrlsh = $db
                ->raw()
                ->bind(':table_name', $table_name)
                ->exec('SELECT
                        gtbrlsh.id as id_gtbrlsh,
                        gtbrlsh.nama as gtbrlsh_nama,
                        gtbrlsh.tblheader as gtbrlsh_tblheader,
                        gapxxsh.id as id_gapxxsh,
                        gapxxsh.id_gaptpmh as id_gaptpmh,
                        gapxxsh.jumlah_level as jumlah_level
                    FROM gtbrlsh
                    LEFT JOIN gaptbtd ON gaptbtd.id_gtbrlsh = gtbrlsh.id
                    LEFT JOIN gapxxsh ON gapxxsh.id = gaptbtd.id_gapxxsh
                    WHERE 
                        gtbrlsh.tblheader = :table_name
                ');
            $rs_gtbrlsh        = $qs_gtbrlsh->fetch();
            $gtbrlsh_nama      = $rs_gtbrlsh['gtbrlsh_nama'];
            $gtbrlsh_tblheader = $rs_gtbrlsh['gtbrlsh_tblheader'];
            $id_gapxxsh        = $rs_gtbrlsh['id_gapxxsh'];
            $jumlah_level      = $rs_gtbrlsh['jumlah_level'];
            $id_gaptpmh        = $rs_gtbrlsh['id_gaptpmh'];
            $id_gtbrlsh        = $rs_gtbrlsh['id_gtbrlsh'];
            // END ambil aturan approval
    
            /**
                * generate field untuk di select di $qs_transaksi jika approval type = amount
                * jika jika approval type = level, maka tidak perlu
                */
            $field_amount = '';
            $tr_amount = '';
            $field_group = '';
            $where_group_nama = '';
    
            /**
                * gaptpmh
                * 1: Level
                * 2: Amount
                * 3: Group Level
                * 
                */
    
            if($id_gaptpmh == 1){
                
            }elseif($id_gaptpmh == 2){
                $field_amount = ',grand_total ';
    
                /**
                    * ambil kode transaksi [dan grand_total] untuk di insert ke gaplgtd
                    * grand_total optional, hanya untuk yang approval_type (gaptpmh) = Amount
                    */
                $qs_transaksi = $db
                    ->raw()
                    ->bind(':id_transaksi', $id_transaksi)
                    ->exec('SELECT
                            kode 
                        '
                            .$field_amount.
                            // $field_group.
                        ' FROM '.$table_name.'
                        WHERE 
                            id = :id_transaksi
                    ');
                $rs_transaksi = $qs_transaksi->fetch();
                $tr_amount = $rs_transaksi['grand_total'];
    
            }elseif($id_gaptpmh == 3){
                /**
                    * perlu mendapatkan department atau divisi mana yang harus approve
                    * contoh dari 
                    *  prqxxth, ada id_hodxxmh
                    *  maka harus dicari di table gapdusd yang group nya d
                    */
                $qs_gapdusd = $db
                    ->query('select', 'gapdusd' )
                    ->get([
                        'gapdusd.tblheader as tblheader',
                        'gapdusd.tbl_group_nama as tbl_group_nama'
                    ] )
                    ->join('gaptbtd','gaptbtd.id_gapxxsh = gapdusd.id_gapxxsh','LEFT' )
                    ->where('gaptbtd.id_gtbrlsh', $id_gtbrlsh )
                    ->exec();
                $rs_gapdusd = $qs_gapdusd->fetch();
    
                // ambil data Divisi atau Department dari table transaksi
                $qs_transaksi_group = $db
                    ->raw()
                    ->bind(':id_transaksi', $id_transaksi)
                    ->exec('SELECT
                            id_'.$rs_gapdusd['tblheader'].',
                            '.$rs_gapdusd['tblheader'].'.nama as tbl_group_nama
                        FROM '.$table_name.'
                        LEFT JOIN '.$rs_gapdusd['tblheader'].' ON '.$rs_gapdusd['tblheader'].'.id = '.$table_name.'.id_'.$rs_gapdusd['tblheader'].' 
                        WHERE 
                            '.$table_name.'.id = :id_transaksi
                    ');
                $rs_transaksi_group = $qs_transaksi_group->fetch();
    
                // generate where_group_nama
                $where_group_nama = 'AND gapdusd.tblheader = "' . $rs_gapdusd['tblheader'] . '" AND gapdusd.tbl_group_nama = "' . $rs_transaksi_group['tbl_group_nama'] .'"';
    
    
            }else{
    
            }
        
            /**
                * ambil id_users_pengaju untuk di insert ke gaplgtd
                */
            $qs_log = $db
                ->raw()
                ->bind(':id_transaksi', $id_transaksi)
                ->bind(':kode', 'CONFIRM')
                ->bind(':table_name', $table_name)
                ->exec('SELECT
                        created_by as id_users_pengaju,
                        created_on
                    FROM activity_log_ml
                    WHERE 1
                        AND id_transaksi = :id_transaksi
                        AND kode = :kode
                        AND nama = :table_name
                ');
            $rs_log     = $qs_log->fetch();
            
            /**
                * ambil id_users yang harus melakukan approval
                */
            $qs_gapdusd = $db
                ->raw()
                ->bind(':id_gapxxsh', $id_gapxxsh)
                ->bind(':tr_amount', $tr_amount)
                ->exec('SELECT 
                        id_users,
                        level_ke
                    FROM gapdusd
                    WHERE 1
                        '.$where_group_nama.'
                        AND id_gapxxsh = :id_gapxxsh
                        AND :tr_amount BETWEEN gaptpmh_value_fr AND IFNULL(gaptpmh_value_to,999999999999999999.99)
                ');
            $rs_gapdusd = $qs_gapdusd->fetchAll();
    
            if(!empty($rs_gapdusd)){
                foreach ($rs_gapdusd as $row_gapdusd) {
                    $qi_gaplgtd = $db
                        ->query('insert', 'gaplgtd')
                        ->set('id_users', $row_gapdusd['id_users'] )
                        ->set('id_users_pengaju', $rs_log['id_users_pengaju'])
                        ->set('id_transaksi', $id_transaksi )
                        ->set('kode', $rs_transaksi['kode'])
                        ->set('nama', $gtbrlsh_nama)
                        ->set('start_at', date('Y-m-d H:i:s'))
                        ->set('tbl_name', $table_name)
                        ->set('level_ke', $row_gapdusd['level_ke'] )
                        ->set('dt_pengajuan', $rs_log['created_on'] )
                        ->set('transaction_state', 1 )
                        ->exec();
                }
    
                $db->commit();
                $status_code  = 200;
                $message      = 'Pengajuan Approval Berhasil Dilakukan';
                $type_message = 'success';
    
            }else{
                $db->rollback();
                $status_code  = 500;
                $message      = 'Pengajuan Approval Gagal Dilakukan! User penyetuju belum diatur';
                $type_message = 'error';
            }
        } else {
            //jika tidak butuh approval, maka dibuat otomatis approval_state = 9
            $qu_approval = $db
                ->query('update', $table_name)
                ->set('approval_state',9)
                ->where('id',$id_transaksi)
            ->exec();

            if (!empty($qu_approval)) {
                $db->commit();
                $status_code  = 200;
                $message      = 'Approval Berhasil Dilakukan';
                $type_message = 'success';
            } else {
                $db->rollback();
                $status_code  = 500;
                $message      = 'Approval Gagal Dilakukan!';
                $type_message = 'error';
            }
        }

        
    }catch(PDOException $e){
        $db->rollback();
        $status_code  = 500;
        $message      = 'Pengajuan Approval Gagal Dilakukan! ' . $e->getMessage();
        $type_message = 'error';
    }catch (Exception $e) {
        $db->rollback();
        $status_code = 500;
        $message = 'Pengajuan Approval Gagal Dilakukan!, ' . $e->getMessage();
        $type_message = 'error';
    }

    // build response
    $data = array(
        'status_code'    => $status_code,
        'message'        => $message,
        'type_message'   => $type_message
    );

    // tampilkan results
    require_once( "fn_ajax_results.php" );
	
?>