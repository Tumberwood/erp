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
	
	$editor = Editor::inst( $db, 'pmi_cylinder_m_warna' )
		->debug(true)
		->fields(
			Field::inst( 'pmi_cylinder_m_warna.id' ),
			Field::inst( 'pmi_cylinder_m_warna.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'pmi_cylinder_m_warna.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'pmi_cylinder_m_warna.keterangan' ),
			Field::inst( 'pmi_cylinder_m_warna.created_by' ),
			Field::inst( 'pmi_cylinder_m_warna.transaction_state' ),
			Field::inst( 'pmi_cylinder_m_warna.approval_state' ),
			Field::inst( 'pmi_cylinder_m_warna.start_at' ),
			Field::inst( 'pmi_cylinder_m_warna.finish_at' ),
			Field::inst( 'pmi_cylinder_m_warna.is_defaultprogram' ),
			Field::inst( 'pmi_cylinder_m_warna.is_nextprocess' )
		);
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_pmi_cylinder_m_warna'] == 0){
		$editor
			->where( 'pmi_cylinder_m_warna.transaction_state', -9, '<>');
	}
	
	include( "pmi_cylinder_m_warna_extra.php" );

	// BEGIN log
	$nama_table = 'pmi_cylinder_m_warna';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>