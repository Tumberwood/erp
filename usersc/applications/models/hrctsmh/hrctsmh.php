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
	
	$editor = Editor::inst( $db, 'hrctsmh' )
		->debug(true)
		->fields(
			Field::inst( 'hrctsmh.id' ),
			Field::inst( 'hrctsmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'hrctsmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'hrctsmh.keterangan' ),
			Field::inst( 'hrctsmh.created_by' ),
			Field::inst( 'hrctsmh.transaction_state' ),
			Field::inst( 'hrctsmh.approval_state' ),
			Field::inst( 'hrctsmh.start_at' ),
			Field::inst( 'hrctsmh.finish_at' ),
			Field::inst( 'hrctsmh.is_defaultprogram' ),
			Field::inst( 'hrctsmh.is_nextprocess' )
		);
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_hrctsmh'] == 0){
		$editor
			->where( 'hrctsmh.transaction_state', -9, '<>');
	}
	
	include( "hrctsmh_extra.php" );

	// BEGIN log
	$nama_table = 'hrctsmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>