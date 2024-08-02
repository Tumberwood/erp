<?php
	include( "../../../../users/init.php" );
	include( "../../../../usersc/lib/DataTables.php" );
	
	use
		DataTables\Editor,
		DataTables\Editor\Field,
		DataTables\Editor\Format,
		DataTables\Editor\Mjoin,
		DataTables\Editor\Options,
		DataTables\Editor\Upload,
		DataTables\Editor\Validate,
		DataTables\Editor\ValidateOptions,
		DataTables\Editor\Query,
		DataTables\Editor\Result;
	
    $id_notifications     = $_POST['id_notifications'];
	$user_id = $_SESSION['user'];

	$date_read    = date('Y-m-d H:i:s');

    $qu_notifications = $db
        ->query('update', 'notifications')
        ->set('is_read',1)
        ->set('is_archived',1)
        ->set('date_read',$date_read)
        ->where('id',$id_notifications)
        ->exec();

	$qs_badge = $db
		->query('select', 'notifications' )
		->get(['count(id) as c_id'] )
        ->where('user_id',$user_id)
        ->where('is_read',0)
        ->where('is_archived',0)
		->exec();
	$rs_badge = $qs_badge->fetch();

    $data = array(
        "badge"=> $rs_badge['c_id'],
        "id_notifications"=> $id_notifications,
    );

    echo json_encode($data);


?>