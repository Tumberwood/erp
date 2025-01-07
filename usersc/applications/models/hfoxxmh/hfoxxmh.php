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
	
	$editor = Editor::inst( $db, 'hfoxxmh' )
		->debug(true)
		->fields(
			Field::inst( 'hfoxxmh.id' ),
			Field::inst( 'hfoxxmh.id_hfogrmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'hfoxxmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'hfoxxmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'hfoxxmh.keterangan' ),
			Field::inst( 'hfoxxmh.created_by' ),
			Field::inst( 'hfoxxmh.transaction_state' ),
			Field::inst( 'hfoxxmh.approval_state' ),
			Field::inst( 'hfoxxmh.start_at' ),
			Field::inst( 'hfoxxmh.finish_at' ),
			Field::inst( 'hfoxxmh.is_defaultprogram' ),
			Field::inst( 'hfoxxmh.is_nextprocess' ),
			
			Field::inst( 'hfogrmh.nama' ),
		)
		->leftJoin( 'hfogrmh','hfogrmh.id','=','hfoxxmh.id_hfogrmh' )
		;
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_hfoxxmh'] == 0){
		$editor
			->where( 'hfoxxmh.transaction_state', -9, '<>');
	}
	
	include( "hfoxxmh_extra.php" );

	// BEGIN log
	$nama_table = 'hfoxxmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>