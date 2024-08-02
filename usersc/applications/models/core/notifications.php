<?php
	include( "../../../../users/init.php" );

	// DataTables PHP library
	include( "../../../../usersc/lib/DataTables.php" );
	
	// Alias Editor classes so they are easy to use
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
	
	// ----------- do not erase
	// -----------
	
	$editor = Editor::inst( $db, 'notifications' )
		->fields(
			Field::inst( 'notifications.id' ),
			Field::inst( 'notifications.message' ),
			Field::inst( 'notifications.is_read' ),
			Field::inst( 'notifications.date_created' )
				->getFormatter( 'Format::datetime', array(
					'from' => 'Y-m-d H:i:s',
					'to' =>   'd M Y H:i'
				) )
				->setFormatter( 'Format::datetime', array(
					'from' => 'd M Y H:i',
					'to' =>   'Y-m-d H:i:s'
				) )
		)
		->where( 'notifications.user_id', $_SESSION['user'])
		->where( 'notifications.is_read', 0)
		;
	
	$editor
		->process( $_POST )
		->json();
?>