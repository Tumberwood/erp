<?php
	/*
        Digunakan untuk meng-update transaction_state
        Sumber 2 digit berarti dari data header detail

        * +--------+------+----------------+--------+------+---------+----------+----------------------------+
        * | Sumber |Kode  | Status         | Cancel | Edit | Next    | Approval | Notes                      |
        * |        |      |                |        |      | Process |          |                            |
        * +--------+------+----------------+--------+------+---------+----------+----------------------------+
        * | -92    |-9    | Deleted        | No     | No   | No      | No       | Soft Delete                |
        * | -93    |-9    | Deleted        | No     | No   | No      | No       | Hard Delete                |
        * |        | 0    | Draft          | No     | Yes  | No      | No       | Doc belum siap dilanjutkan |
        * |        | 1    | Confirmed      | Yes    | No   | Yes     | Yes      | Doc siap dilanjutkan       |
        * |        | 8    | Completed      | No     | No   | No      | Already  | Doc Selesai                |
        * |        | 9    | Closed         | No     | No   | No      | Already  | Doc Selesai                |
        * +--------+------+----------------+--------+------+---------+---------------------------------------+
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
        
        $qs = $db
            ->query('select', $table_name )
            ->get([
                $table_name.'.kode as kode'
            ] )
            ->where( $table_name.'.id', $id_transaksi )
            ->exec();
        $rs = $qs->fetch();

        $sql = '
            INSERT INTO
                gaplgtd (
                    id_users,
                    kode,
                    level
                )
            SELECT
                gapdusd.id_users,
                "'.$rs['kode'].'",
                gapdusd.level
            FROM gapdusd
            LEFT JOIN gapxxsh ON gapxxsh.id = gapdusd.id_gapxxsh
            WHERE
                gapxxsh.nama = :table_name
        ';
        
        $qi_gaplgtd = $db
            ->raw()
            // ->bind(':transaction_state', 1)
            // ->bind(':approval_state', 1)
            ->bind(':table_name', $table_name)
            ->exec($sql);
        
        $db->commit();

        $data = array(
            'message'      => 'Approval Setting Berhasil',
            'type_message' => 'success'
        );

    }catch(PDOException $e){
		// rollback on error
		$db->rollback();

	}

    

    // tampilkan results
    require_once( "fn_ajax_results.php" );
	
?>