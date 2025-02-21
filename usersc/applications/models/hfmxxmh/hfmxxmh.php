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
	
	$editor = Editor::inst( $db, 'hfmxxmh' )
		->debug(true)
		->fields(
			Field::inst( 'hfmxxmh.id' ),
			Field::inst( 'hfmxxmh.id_hfoxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'hfmxxmh.id_hfogrmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'hfmxxmh.id_iumxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'hfmxxmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'hfmxxmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'hfmxxmh.keterangan' ),
			Field::inst( 'hfmxxmh.created_by' ),
			Field::inst( 'hfmxxmh.transaction_state' ),
			Field::inst( 'hfmxxmh.approval_state' ),
			Field::inst( 'hfmxxmh.start_at' ),
			Field::inst( 'hfmxxmh.finish_at' ),
			Field::inst( 'hfmxxmh.is_defaultprogram' ),
			Field::inst( 'hfmxxmh.is_nextprocess' ),
			Field::inst( 'hfmxxmh.polarisasi' ),

			Field::inst( 'iumxxmh.kode' ),
			Field::inst( 'hfoxxmh.nama' ),
			Field::inst( 'hfogrmh.nama' ),
			Field::inst( 'hfogrmh.color' ),
		)
		->leftJoin( 'iumxxmh','iumxxmh.id','=','hfmxxmh.id_iumxxmh' )
		->leftJoin( 'hfogrmh','hfogrmh.id','=','hfmxxmh.id_hfogrmh' )
		->leftJoin( 'hfoxxmh','hfoxxmh.id','=','hfmxxmh.id_hfoxxmh' )
		;
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_hfmxxmh'] == 0){
		$editor
			->where( 'hfmxxmh.transaction_state', -9, '<>');
	}
	
	include( "hfmxxmh_extra.php" );

	// BEGIN log
	$nama_table = 'hfmxxmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>