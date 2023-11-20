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
	
	$editor = Editor::inst( $db, 'hbnxxmh' )
		->debug(true)
		->fields(
			Field::inst( 'hbnxxmh.id' ),
			Field::inst( 'hbnxxmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'hbnxxmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'hbnxxmh.keterangan' ),
			Field::inst( 'hbnxxmh.created_by' ),
			Field::inst( 'hbnxxmh.transaction_state' ),
			Field::inst( 'hbnxxmh.approval_state' ),
			Field::inst( 'hbnxxmh.start_at' ),
			Field::inst( 'hbnxxmh.finish_at' ),
			Field::inst( 'hbnxxmh.is_defaultprogram' )
		)
		;
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_hbnxxmh'] == 0){
		$editor
			->where( 'hbnxxmh.transaction_state', -9, '<>');
	}
	
	include( "hbnxxmh_extra.php" );

	// BEGIN log
	$nama_table = 'hbnxxmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>