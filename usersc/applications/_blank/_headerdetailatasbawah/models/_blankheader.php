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
	
	$editor = Editor::inst( $db, '_blankheader' )
		->debug(true)
		->fields(
			Field::inst( '_blankheader.id' ),
			Field::inst( '_blankheader.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( '_blankheader.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( '_blankheader.keterangan' ),
			Field::inst( '_blankheader.created_by' ),
			Field::inst( '_blankheader.transaction_state' ),
			Field::inst( '_blankheader.approval_state' ),
			Field::inst( '_blankheader.start_at' ),
			Field::inst( '_blankheader.finish_at' ),
			Field::inst( '_blankheader.is_defaultprogram' )
		);
	
	if($_POST['start_date'] != ''){
		$editor->where( '_blankheader.tanggal',$_POST['start_date'], '>=' );
	}
	if($_POST['end_date'] != ''){
		$editor->where( '_blankheader.tanggal', $_POST['end_date'], '<=' );
	}

	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted__blankheader'] == 0){
		$editor
			->where( '_blankheader.transaction_state', -9, '<>');
	}
	
	include( "_blankheader_extra.php" );

	// BEGIN log
	$nama_table = '_blankheader';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>