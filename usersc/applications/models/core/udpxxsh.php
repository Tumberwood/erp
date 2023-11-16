<?php
	include( "../../../../users/init.php" );
	include( "../../../../usersc/lib/DataTables.php" );
	include_once( "../../../../usersc/vendor/autoload.php");
	include_once( "../../../helpers/hakakses_s_fn.php" );
	
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
	
	$editor = Editor::inst( $db, 'udpxxsh' )
		->debug(true)
		->fields(
			Field::inst( 'udpxxsh.id' ),
			Field::inst( 'udpxxsh.id_users' ),
			Field::inst( 'udpxxsh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} )
				->searchPaneOptions( SearchPaneOptions::inst()),
			Field::inst( 'udpxxsh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} )
				->searchPaneOptions( SearchPaneOptions::inst()),
			Field::inst( 'udpxxsh.keterangan' ),
			Field::inst( 'udpxxsh.transaction_state' ),
			Field::inst( 'udpxxsh.approval_state' )
				->searchPaneOptions( SearchPaneOptions::inst()),
			Field::inst( 'udpxxsh.start_at' ),
			Field::inst( 'udpxxsh.finish_at' ),
			Field::inst( 'udpxxsh.is_defaultprogram' ),
			Field::inst( 'udpxxsh.data_permission' ),
			
			Field::inst( 'users.username' )
				->set( Field::SET_NONE )
		)
		->leftJoin( 'users','users.id','=','udpxxsh.id_users' )
		->leftJoin( 'users_extend','users_extend.id','=','users.id' );
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_udpxxsh'] == 0){
		$editor
			->where( 'udpxxsh.transaction_state', -9, '<>');
	}
	
	include( "udpxxsh_extra.php" );

	// BEGIN log
	$nama_table = 'udpxxsh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>