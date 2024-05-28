<?php

	include( "../../users/init.php" );
	include( "../../usersc/lib/DataTables.php" );

	require '../../usersc/vendor/autoload.php';
	use Carbon\Carbon;
	
	use
		DataTables\Editor,
		DataTables\Editor\Query,
		DataTables\Editor\Result;
    
    $qs_interval = $db
        ->raw()
        ->exec('SELECT
                    reload_interval_ms
                FROM ggsxxsh
                '
                );
    $rs_interval = $qs_interval->fetch();

    $results = array();
    $results['data'] = $rs_interval;
	echo json_encode($results);
?>