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
	
	$editor = Editor::inst( $db, 'pmi_cylinder_m' )
		->debug(true)
		->fields(
			Field::inst( 'pmi_cylinder_m.id' ),
			Field::inst( 'pmi_cylinder_m.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'pmi_cylinder_m.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'pmi_cylinder_m.keterangan' ),
			Field::inst( 'pmi_cylinder_m.created_by' ),
			Field::inst( 'pmi_cylinder_m.transaction_state' ),
			Field::inst( 'pmi_cylinder_m.approval_state' ),
			Field::inst( 'pmi_cylinder_m.start_at' ),
			Field::inst( 'pmi_cylinder_m.finish_at' ),
			Field::inst( 'pmi_cylinder_m.is_nextprocess' ),
			Field::inst( 'pmi_cylinder_m.is_defaultprogram' )
		);

	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_pmi_cylinder_m'] == 0){
		$editor
			->where( 'pmi_cylinder_m.transaction_state', -9, '<>');
	}
	
	include( "pmi_cylinder_m_extra.php" );

	// BEGIN log
	$nama_table = 'pmi_cylinder_m';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>