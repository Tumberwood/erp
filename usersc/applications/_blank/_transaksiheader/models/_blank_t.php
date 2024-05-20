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
	
	$editor = Editor::inst( $db, '_blank_t' )
		->debug(true)
		->fields(
			Field::inst( '_blank_t.id' ),
			Field::inst( '_blank_t.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( '_blank_t.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( '_blank_t.keterangan' ),
			Field::inst( '_blank_t.created_by' ),
			Field::inst( '_blank_t.transaction_state' ),
			Field::inst( '_blank_t.approval_state' ),
			Field::inst( '_blank_t.start_at' ),
			Field::inst( '_blank_t.finish_at' ),
			Field::inst( '_blank_t.is_defaultprogram' )
		);
	
	// BEGIN where single data view
	if (isset($_POST['rowid']) && $_POST['rowid'] > 0) {
		$rowid = $_POST['rowid'];
		$editor
			->where( '_blank_t.id', $rowid);
	}else{
		$editor
			->where( '_blank_t.tanggal', $_POST['start_date'], '>=' )
			->where( '_blank_t.tanggal', $_POST['end_date'], '<=' );
	}
	// END where single data view

	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted__blank_t'] == 0){
		$editor
			->where( '_blank_t.transaction_state', -9, '<>');
	}
	
	include( "_blank_t_extra.php" );

	// BEGIN log
	$nama_table = '_blank_t';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>