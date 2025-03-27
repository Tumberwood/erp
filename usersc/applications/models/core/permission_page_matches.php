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
	
	if ( ! isset($_POST['permission_id']) || ! is_numeric($_POST['permission_id']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'permission_page_matches' )
			->debug(true)
			->fields(
				Field::inst( 'permission_page_matches.id' ),
				Field::inst( 'permission_page_matches.permission_id' ),
				Field::inst( 'permission_page_matches.page_id' )
				->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'pages.title' ),
				Field::inst( 'pages.page' ),
				Field::inst( 'permission_page_matches_extend.created_by' ),
				Field::inst( 'permission_page_matches_extend.transaction_state' ),
				Field::inst( 'permission_page_matches_extend.approval_state' ),
				Field::inst( 'permission_page_matches_extend.start_at' ),
				Field::inst( 'permission_page_matches_extend.finish_at' ),
				Field::inst( 'permission_page_matches_extend.is_defaultprogram' ),
				Field::inst( 'menus.display_order' ),
			)
			->leftJoin( 'pages','pages.id','=','permission_page_matches.page_id' )
			->leftJoin( 'permission_page_matches_extend','permission_page_matches_extend.id','=','permission_page_matches.id' )
			->leftJoin( 'menus','menus.link','=','SUBSTRING_INDEX(pages.page, "views/", -1)' )
			->where('permission_page_matches.permission_id',$_POST['permission_id']);
		
		// do not erase
		// function show / hide inactive document
		
		include( "permission_page_matches_extra.php" );

		// BEGIN log
		$nama_table = 'permission_page_matches_extend';
		include( "../../../helpers/edt_log.php" );
		// END log
		
		$json = $editor
			->process( $_POST )
			->data();

		// debugging hak akses
		$json['hakakses'] = $hakakses;

		echo json_encode( $json );

	}
?>