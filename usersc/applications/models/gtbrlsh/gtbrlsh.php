<?php
	include_once( "../../../../users/init.php" );
	include_once( "../../../../usersc/lib/DataTables.php" );
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
	
	$editor = Editor::inst( $db, 'gtbrlsh' )
		->debug(true)
		->fields(
			Field::inst( 'gtbrlsh.id' ),
			Field::inst( 'gtbrlsh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'gtbrlsh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'gtbrlsh.keterangan' ),
			Field::inst( 'gtbrlsh.created_by' ),
			Field::inst( 'gtbrlsh.transaction_state' ),
			Field::inst( 'gtbrlsh.approval_state' ),
			Field::inst( 'gtbrlsh.start_at' ),
			Field::inst( 'gtbrlsh.finish_at' ),
			Field::inst( 'gtbrlsh.is_defaultprogram' ),
			Field::inst( 'gtbrlsh.tblheader' ),
			Field::inst( 'gtbrlsh.tbldetails' ),
			Field::inst( 'gtbrlsh.is_master' )
		);
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_gtbrlsh'] == 0){
		$editor
			->where( 'gtbrlsh.transaction_state', -9, '<>');
	}
	
	include( "gtbrlsh_extra.php" );

	// BEGIN log
	$nama_table = 'gtbrlsh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>