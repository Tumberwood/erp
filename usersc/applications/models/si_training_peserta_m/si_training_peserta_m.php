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
	
	$editor = Editor::inst( $db, 'si_training_peserta_m' )
		->debug(true)
		->fields(
			Field::inst( 'si_training_peserta_m.id' ),
			Field::inst( 'si_training_peserta_m.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'si_training_peserta_m.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'si_training_peserta_m.keterangan' ),
			Field::inst( 'si_training_peserta_m.created_by' ),
			Field::inst( 'si_training_peserta_m.transaction_state' ),
			Field::inst( 'si_training_peserta_m.approval_state' ),
			Field::inst( 'si_training_peserta_m.start_at' ),
			Field::inst( 'si_training_peserta_m.finish_at' ),
			Field::inst( 'si_training_peserta_m.is_defaultprogram' ),
			Field::inst( 'si_training_peserta_m.is_nextprocess' ),
			Field::inst( 'si_training_peserta_m.no_wa' ),
			Field::inst( 'si_training_peserta_m.domisili' ),
			Field::inst( 'si_training_peserta_m.profesi' ),
			Field::inst( 'si_training_peserta_m.sumber_info' ),
			Field::inst( 'si_training_peserta_m.alasan' ),
			Field::inst( 'si_training_peserta_m.email' ),

		)
		;
		
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_si_training_peserta_m'] == 0){
		$editor
			->where( 'si_training_peserta_m.transaction_state', -9, '<>');
	}
	
	include( "si_training_peserta_m_extra.php" );

	// BEGIN log
	$nama_table = 'si_training_peserta_m';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>