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
	
	$editor = Editor::inst( $db, 'htsptth' )
		->debug(true)
		->fields(
			Field::inst( 'htsptth.id' ),
			Field::inst( 'htsptth.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'htsptth.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'htsptth.keterangan' ),
			Field::inst( 'htsptth.transaction_state' ),
			Field::inst( 'htsptth.approval_state' ),
			Field::inst( 'htsptth.start_at' ),
			Field::inst( 'htsptth.finish_at' ),
			Field::inst( 'htsptth.is_defaultprogram' ),
			Field::inst( 'htsptth.is_nextprocess' ),
			Field::inst( 'htsptth.jumlah_grup' ),
			Field::inst( 'htsptth.is_tukar' )
		);
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_htsptth'] == 0){
		$editor
			->where( 'htsptth.transaction_state', -9, '<>');
	}
	
	include( "htsptth_extra.php" );

	// BEGIN log
	$nama_table = 'htsptth';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>