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
	
	$editor = Editor::inst( $db, 'lexxxmh' )
		->debug(true)
		->fields(
			Field::inst( 'lexxxmh.id' ),
			Field::inst( 'lexxxmh.id_gctxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'lexxxmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'lexxxmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'lexxxmh.keterangan' ),
			Field::inst( 'lexxxmh.created_by' ),
			Field::inst( 'lexxxmh.transaction_state' ),
			Field::inst( 'lexxxmh.approval_state' ),
			Field::inst( 'lexxxmh.start_at' ),
			Field::inst( 'lexxxmh.finish_at' ),
			Field::inst( 'lexxxmh.is_defaultprogram' ),

			Field::inst( 'lexxxmh.alamat' ),

			Field::inst( 'gctxxmh.nama' )

		)
		->leftJoin( 'gctxxmh','gctxxmh.id','=','lexxxmh.id_gctxxmh' );
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_lexxxmh'] == 0){
		$editor
			->where( 'lexxxmh.transaction_state', -9, '<>');
	}
	
	include( "lexxxmh_extra.php" );

	// BEGIN log
	$nama_table = 'lexxxmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>