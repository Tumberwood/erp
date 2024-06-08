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
	
	$editor = Editor::inst( $db, '_blank' )
		->debug(true)
		->fields(
			Field::inst( '_blank.id' ),
			Field::inst( '_blank.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( '_blank.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( '_blank.keterangan' ),
			Field::inst( '_blank.created_by' ),
			Field::inst( '_blank.transaction_state' ),
			Field::inst( '_blank.approval_state' ),
			Field::inst( '_blank.start_at' ),
			Field::inst( '_blank.finish_at' ),
			Field::inst( '_blank.is_defaultprogram' )
		);
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted__blank'] == 0){
		$editor
			->where( '_blank.transaction_state', -9, '<>');
	}
	
	include( "_blank_extra.php" );

	// BEGIN log
	$nama_table = '_blank';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>