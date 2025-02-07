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
	
	$editor = Editor::inst( $db, 'ggsfnsh' )
		->debug(true)
		->fields(
			Field::inst( 'ggsfnsh.id' ),
			Field::inst( 'ggsfnsh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'ggsfnsh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'ggsfnsh.keterangan' ),
			Field::inst( 'ggsfnsh.created_by' ),
			Field::inst( 'ggsfnsh.transaction_state' ),
			Field::inst( 'ggsfnsh.approval_state' ),
			Field::inst( 'ggsfnsh.start_at' ),
			Field::inst( 'ggsfnsh.finish_at' ),
			Field::inst( 'ggsfnsh.is_defaultprogram' ),
			Field::inst( 'ggsfnsh.is_nextprocess' ),
			Field::inst( 'ggsfnsh.jatuh_tempo' ),
		)
		;
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_ggsfnsh'] == 0){
		$editor
			->where( 'ggsfnsh.transaction_state', -9, '<>');
	}
	
	include( "ggsfnsh_extra.php" );

	// BEGIN log
	$nama_table = 'ggsfnsh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>