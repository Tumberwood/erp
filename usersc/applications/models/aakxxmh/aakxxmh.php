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
	
	$editor = Editor::inst( $db, 'aakxxmh' )
		->debug(true)
		->fields(
			Field::inst( 'aakxxmh.id' ),
			Field::inst( 'aakxxmh.id_aakxxmh_parent' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'aakxxmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'aakxxmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'aakxxmh.keterangan' ),
			Field::inst( 'aakxxmh.created_by' ),
			Field::inst( 'aakxxmh.transaction_state' ),
			Field::inst( 'aakxxmh.approval_state' ),
			Field::inst( 'aakxxmh.start_at' ),
			Field::inst( 'aakxxmh.finish_at' ),
			Field::inst( 'aakxxmh.is_defaultprogram' ),
			Field::inst( 'aakxxmh.is_parent' ),

			Field::inst( 'aakxxmh_parent.kode' ),
			Field::inst( 'aakxxmh_parent.nama' )
		)
		->leftJoin( 'aakxxmh as aakxxmh_parent','aakxxmh_parent.id','=','aakxxmh.id_aakxxmh_parent' )
		;
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_aakxxmh'] == 0){
		$editor
			->where( 'aakxxmh.transaction_state', -9, '<>');
	}
	
	include( "aakxxmh_extra.php" );

	// BEGIN log
	$nama_table = 'aakxxmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>