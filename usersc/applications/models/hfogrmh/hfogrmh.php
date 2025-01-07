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
	
	$editor = Editor::inst( $db, 'hfogrmh' )
		->debug(true)
		->fields(
			Field::inst( 'hfogrmh.id' ),
			Field::inst( 'hfogrmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'hfogrmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'hfogrmh.keterangan' ),
			Field::inst( 'hfogrmh.created_by' ),
			Field::inst( 'hfogrmh.transaction_state' ),
			Field::inst( 'hfogrmh.approval_state' ),
			Field::inst( 'hfogrmh.start_at' ),
			Field::inst( 'hfogrmh.finish_at' ),
			Field::inst( 'hfogrmh.is_defaultprogram' ),
			Field::inst( 'hfogrmh.is_nextprocess' )
		);
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_hfogrmh'] == 0){
		$editor
			->where( 'hfogrmh.transaction_state', -9, '<>');
	}
	
	include( "hfogrmh_extra.php" );

	// BEGIN log
	$nama_table = 'hfogrmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>