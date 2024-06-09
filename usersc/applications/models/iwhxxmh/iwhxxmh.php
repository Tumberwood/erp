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
	
	$editor = Editor::inst( $db, 'iwhxxmh' )
		->debug(true)
		->fields(
			Field::inst( 'iwhxxmh.id' ),
			Field::inst( 'iwhxxmh.id_gbrxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'iwhxxmh.id_iwhctmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'iwhxxmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'iwhxxmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'iwhxxmh.keterangan' ),
			Field::inst( 'iwhxxmh.created_by' ),
			Field::inst( 'iwhxxmh.transaction_state' ),
			Field::inst( 'iwhxxmh.approval_state' ),
			Field::inst( 'iwhxxmh.start_at' ),
			Field::inst( 'iwhxxmh.finish_at' ),
			Field::inst( 'iwhxxmh.is_defaultprogram' ),

			Field::inst( 'gbrxxmh.nama' ),
			Field::inst( 'iwhctmh.nama' ),
		)
		->leftJoin( 'gbrxxmh','gbrxxmh.id','=','iwhxxmh.id_gbrxxmh' )
		->leftJoin( 'iwhctmh','iwhctmh.id','=','iwhxxmh.id_iwhctmh' )
		->where( 'iwhxxmh.is_sistem', null)
		;
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_iwhxxmh'] == 0){
		$editor
			->where( 'iwhxxmh.transaction_state', -9, '<>');
	}
	
	include( "iwhxxmh_extra.php" );

	// BEGIN log
	$nama_table = 'iwhxxmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>