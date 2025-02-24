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
	
	$editor = Editor::inst( $db, 'ggshrsh' )
		->debug(true)
		->fields(
			Field::inst( 'ggshrsh.id' ),
			Field::inst( 'ggshrsh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'ggshrsh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'ggshrsh.keterangan' ),
			Field::inst( 'ggshrsh.created_by' ),
			Field::inst( 'ggshrsh.transaction_state' ),
			Field::inst( 'ggshrsh.approval_state' ),
			Field::inst( 'ggshrsh.start_at' ),
			Field::inst( 'ggshrsh.finish_at' ),
			Field::inst( 'ggshrsh.is_defaultprogram' ),
			Field::inst( 'ggshrsh.is_nextprocess' ),
			Field::inst( 'ggshrsh.is_autocreateusers' ),
			Field::inst( 'ggshrsh.def_cuti_tahunan' ),
			Field::inst( 'ggshrsh.kpi_bobot_target_atas' ),
			Field::inst( 'ggshrsh.kpi_bobot_target_bawah' ),
			Field::inst( 'ggshrsh.batas_skor_revisi' ),
		);
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_ggshrsh'] == 0){
		$editor
			->where( 'ggshrsh.transaction_state', -9, '<>');
	}
	
	include( "ggshrsh_extra.php" );

	// BEGIN log
	$nama_table = 'ggshrsh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>