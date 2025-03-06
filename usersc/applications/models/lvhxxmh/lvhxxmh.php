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
	
	$editor = Editor::inst( $db, 'lvhxxmh' )
		->debug(true)
		->fields(
			Field::inst( 'lvhxxmh.id' ),
			Field::inst( 'lvhxxmh.id_lvtxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'lvhxxmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'lvhxxmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'lvhxxmh.keterangan' ),
			Field::inst( 'lvhxxmh.created_by' ),
			Field::inst( 'lvhxxmh.transaction_state' ),
			Field::inst( 'lvhxxmh.approval_state' ),
			Field::inst( 'lvhxxmh.start_at' ),
			Field::inst( 'lvhxxmh.finish_at' ),
			Field::inst( 'lvhxxmh.is_defaultprogram' ),
			Field::inst( 'lvhxxmh.is_nextprocess' ),
			Field::inst( 'lvtxxmh.nama' ),
		)
		->leftJoin( 'lvtxxmh','lvtxxmh.id','=','lvhxxmh.id_lvtxxmh' )
		;
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_lvhxxmh'] == 0){
		$editor
			->where( 'lvhxxmh.transaction_state', -9, '<>');
	}
	
	include( "lvhxxmh_extra.php" );

	// BEGIN log
	$nama_table = 'lvhxxmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>