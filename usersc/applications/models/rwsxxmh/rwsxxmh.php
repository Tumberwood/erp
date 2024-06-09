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
	
	$editor = Editor::inst( $db, 'rwsxxmh' )
		->debug(true)
		->fields(
			Field::inst( 'rwsxxmh.id' ),
			Field::inst( 'rwsxxmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'rwsxxmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'rwsxxmh.keterangan' ),
			Field::inst( 'rwsxxmh.created_by' ),
			Field::inst( 'rwsxxmh.transaction_state' ),
			Field::inst( 'rwsxxmh.approval_state' ),
			Field::inst( 'rwsxxmh.start_at' ),
			Field::inst( 'rwsxxmh.finish_at' ),
			Field::inst( 'rwsxxmh.is_defaultprogram' )
		);
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_rwsxxmh'] == 0){
		$editor
			->where( 'rwsxxmh.transaction_state', -9, '<>');
	}
	
	include( "rwsxxmh_extra.php" );

	// BEGIN log
	$nama_table = 'rwsxxmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>