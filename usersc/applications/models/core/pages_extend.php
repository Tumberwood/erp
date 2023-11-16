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

	$editor = Editor::inst( $db, 'pages' )
		->debug(true)
		->fields(
			Field::inst( 'pages.id' )
				->set( Field::SET_NONE ),
			Field::inst( 'pages.page' )
				->set( Field::SET_NONE ),
			Field::inst( 'pages.title' )
				->set( Field::SET_NONE ),
			Field::inst( 'pages_extend.created_by' ),
			Field::inst( 'pages_extend.transaction_state' ),
			Field::inst( 'pages_extend.approval_state' ),
			Field::inst( 'pages_extend.start_at' ),
			Field::inst( 'pages_extend.finish_at' ),
			Field::inst( 'pages_extend.is_defaultprogram' ),
			Field::inst( 'pages_extend.info' ),
			Field::inst( 'pages_extend.is_setting' ),
			Field::inst( 'pages_extend.is_crud' )
		)
		->leftJoin( 'pages_extend','pages_extend.id','=','pages.id' )
		->where( 'LEFT(pages.page,20)', 'usersc/applications/');
	
	// BEGIN log
	$nama_table = 'pages_extend';
	include( "../../../helpers/edt_log.php" );
	// END log

	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>