<?php
	include_once( "../../../../users/init.php" );
	include_once( "../../../../usersc/lib/DataTables.php" );
	include_once( "../../../../usersc/vendor/autoload.php");
	include_once( "../../../helpers/hakakses_s_fn.php" );
	include_once( "../../../helpers/SolusiIndonesiaUtilities.php" );
	
	use
		DataTables\Editor,
		DataTables\Editor\Field,
		DataTables\Editor\Format,
		DataTables\Editor\Mjoin,
		DataTables\Editor\Options,
		DataTables\Editor\Upload,
		DataTables\Editor\Validate,
		DataTables\Editor\ValidateOptions,
		DataTables\Editor\SearchPaneOptions,
		DataTables\Editor\Query,
		DataTables\Editor\Result;

	use 
		Carbon\Carbon;
	
	$editor = Editor::inst( $db, 'users' )
		->debug(true)
		->fields(
			Field::inst( 'users.id' ),
			Field::inst( 'users.username' ),
			Field::inst( 'users.fname' ),
			Field::inst( 'users.lname' ),
			Field::inst( 'users.active' )
		)
		->join(
			Mjoin::inst( 'permissions' )
				->link( 'users.id', 'user_permission_matches.user_id' )
				->link( 'permissions.id', 'user_permission_matches.permission_id' )
				->fields(
					Field::inst( 'id' ),
					Field::inst( 'name' )
				)
		);
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
	
?>