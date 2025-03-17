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
	
	$editor = Editor::inst( $db, 'ittxxmh' )
		->debug(true)
		->fields(
			Field::inst( 'ittxxmh.id' ),
			Field::inst( 'ittxxmh.imtxxmh_kode' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'ittxxmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'ittxxmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'ittxxmh.keterangan' ),
			Field::inst( 'ittxxmh.created_by' ),
			Field::inst( 'ittxxmh.transaction_state' ),
			Field::inst( 'ittxxmh.approval_state' ),
			Field::inst( 'ittxxmh.start_at' ),
			Field::inst( 'ittxxmh.finish_at' ),
			Field::inst( 'ittxxmh.is_defaultprogram' ),
			Field::inst( 'ittxxmh.is_nextprocess' ),
			Field::inst( 'imtxxmh.movement_type_group' ),
			Field::inst( 'imtxxmh.nama' ),
		)
		->leftJoin( 'imtxxmh','imtxxmh.kode','=','ittxxmh.imtxxmh_kode' )
		;
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_ittxxmh'] == 0){
		$editor
			->where( 'ittxxmh.transaction_state', -9, '<>');
	}
	
	include( "ittxxmh_extra.php" );

	// BEGIN log
	$nama_table = 'ittxxmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>