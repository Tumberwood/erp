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
			Field::inst( 'udpxxsh.id' ),
			Field::inst( 'users.id' ),
			Field::inst( 'users.email' ),
			Field::inst( 'users.username' ),
			Field::inst( 'users.password' )
			->setFormatter(function($val) {
				return password_hash($val, PASSWORD_BCRYPT, ['cost' => 12]);
			}),
			Field::inst( 'users.permissions' )
			->setValue(1),
			Field::inst( 'users.email_verified' )
			->setValue(1),
			Field::inst( 'users.fname' ),
			Field::inst( 'users.lname' ),
			Field::inst( 'udpxxsh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'udpxxsh.keterangan' ),
			Field::inst( 'udpxxsh.transaction_state' ),
			Field::inst( 'udpxxsh.approval_state' ),
			Field::inst( 'udpxxsh.start_at' ),
			Field::inst( 'udpxxsh.finish_at' ),
			Field::inst( 'udpxxsh.is_defaultprogram' ),
			Field::inst( 'udpxxsh.data_permission' ),
			Field::inst( 'users_extend.is_hakakses' )
			->setValue(1),
			
			Field::inst( 'CONCAT(users.fname," ",users.lname) as users_nama' )
				->set( Field::SET_NONE )
		)
		->leftJoin( 'udpxxsh','udpxxsh.id_users','=','users.id' )
		->leftJoin( 'users_extend','users_extend.id','=','users.id' )
		->join(
			Mjoin::inst( 'permissions' )
				->link( 'users.id', 'user_permission_matches.user_id' )
				->link( 'permissions.id', 'user_permission_matches.permission_id' )
				->fields(
					Field::inst( 'id' )
						->setFormatter( Format::ifEmpty( 0 ) )
						->options( Options::inst()
							->table( 'permissions' )
							->value( 'id' )
							->label( ['name'] )
							->render( function ( $row ) {
								return $row['name'];
							} )
							->order( 'name' )
						),
					Field::inst( 'name' )
				)
		)
		;
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_udpxxsh'] == 0){
		$editor
			->where( 'udpxxsh.transaction_state', -9, '<>');
	}
	
	include( "users_extra.php" );

	// BEGIN log
	$nama_table = 'users';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>