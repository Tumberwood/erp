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
	
	$editor = Editor::inst( $db, 'ggswmsh' )
		->debug(true)
		->fields(
			Field::inst( 'ggswmsh.id' ),
			Field::inst( 'ggswmsh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'ggswmsh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'ggswmsh.keterangan' ),
			Field::inst( 'ggswmsh.created_by' ),
			Field::inst( 'ggswmsh.transaction_state' ),
			Field::inst( 'ggswmsh.approval_state' ),
			Field::inst( 'ggswmsh.start_at' ),
			Field::inst( 'ggswmsh.finish_at' ),
			Field::inst( 'ggswmsh.is_defaultprogram' ),
			Field::inst( 'ggswmsh.is_nextprocess' ),
			Field::inst( 'ggswmsh.is_ganti_lokasi_putaway' ),
			Field::inst( 'ggswmsh.is_delete_reload' ),
			Field::inst( 'ggswmsh.is_replenishment' ),
			Field::inst( 'ggswmsh.is_one_way_do' ),
			Field::inst( 'ggswmsh.pick_and_pack' ),
			Field::inst( 'ggswmsh.format_lpn_kitting' ),
			Field::inst( 'ggswmsh.is_koordinat' ),
			Field::inst( 'ggswmsh.koefisien_level' ),
			Field::inst( 'ggswmsh.vehicle_capacity' ),
		);
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_ggswmsh'] == 0){
		$editor
			->where( 'ggswmsh.transaction_state', -9, '<>');
	}
	
	include( "ggswmsh_extra.php" );

	// BEGIN log
	$nama_table = 'ggswmsh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>