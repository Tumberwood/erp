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
	
	$editor = Editor::inst( $db, 'iivxxrd_audit' )
		->debug(true)
		->fields(
			Field::inst( 'iivxxrd_audit.id' ),
			Field::inst( 'iivxxrd_audit.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'iivxxrd_audit.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'iivxxrd_audit.keterangan' ),
			Field::inst( 'iivxxrd_audit.created_by' ),
			Field::inst( 'iivxxrd_audit.transaction_state' ),
			Field::inst( 'iivxxrd_audit.approval_state' ),
			Field::inst( 'iivxxrd_audit.start_at' ),
			Field::inst( 'iivxxrd_audit.finish_at' ),
			Field::inst( 'iivxxrd_audit.status_audit' ),
			Field::inst( 'iivxxrd_audit.is_defaultprogram' )
		);
	
	if($_POST['start_date'] != ''){
		$editor->where( 'iivxxrd_audit.tanggal',$_POST['start_date'], '>=' );
	}
	if($_POST['end_date'] != ''){
		$editor->where( 'iivxxrd_audit.tanggal', $_POST['end_date'], '<=' );
	}

	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_iivxxrd_audit'] == 0){
		$editor
			->where( 'iivxxrd_audit.transaction_state', -9, '<>');
	}
	
	include( "iivxxrd_audit_extra.php" );

	// BEGIN log
	$nama_table = 'iivxxrd_audit';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>