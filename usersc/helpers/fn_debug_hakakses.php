<?php
	/**
     * Digunakan untuk mengambil nilai is_debug_hakakses_hd dari table ggsxxsh
     */
    include_once( "../../users/init.php" );
	include_once( "../../usersc/lib/DataTables.php" );
    include( "datatables_fn_debug.php" );   
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
    
    try{
        $is_debug_hakakses_hd = 0;
        $qs_ggsxxsh = $db
            ->query('select', 'ggsxxsh' )
            ->get([
                'ggsxxsh.is_debug_hakakses_hd as is_debug_hakakses_hd'
            ] )
            ->exec();
        $rs_ggsxxsh = $qs_ggsxxsh->fetch();
        $is_debug_hakakses_hd = $rs_ggsxxsh['is_debug_hakakses_hd'];

        // check apakah query ada resultnya
        if(!empty($rs_gtbrlsh)){
            $status_code  = '200';
            $message      = 'Message Berhasil';
            $type_message = 'success';
        }else{
            $status_code  = '500';
            $message      = 'Message Gagal';
            $type_message = 'error';
        }
    }catch(PDOException $e){
        $status_code  = '500';
        $message      = 'Message Gagal! ' . $e->getMessage();
        $type_message = 'error';
    }
    // build response
    $data = array(
        'status_code'    => $status_code,
        'message'        => $message,
        'type_message'   => $type_message,
        'is_debug_hakakses_hd'   => $is_debug_hakakses_hd
    );

    // tampilkan results
    require_once( "fn_ajax_results.php" );
?>