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
	
	$editor = Editor::inst( $db, 'pmi_cylinder_problem_t' )
		->debug(true)
		->fields(
			Field::inst( 'pmi_cylinder_problem_t.id' ),
			Field::inst( 'pmi_cylinder_problem_t.id_pmi_cylinder_m' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'pmi_cylinder_problem_t.id_pmi_cylinder_m_color' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'pmi_cylinder_problem_t.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'pmi_cylinder_problem_t.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'pmi_cylinder_problem_t.keterangan' ),
			Field::inst( 'pmi_cylinder_problem_t.created_by' ),
			Field::inst( 'pmi_cylinder_problem_t.transaction_state' ),
			Field::inst( 'pmi_cylinder_problem_t.approval_state' ),
			Field::inst( 'pmi_cylinder_problem_t.start_at' ),
			Field::inst( 'pmi_cylinder_problem_t.finish_at' ),
			Field::inst( 'pmi_cylinder_problem_t.is_defaultprogram' ),
			Field::inst( 'pmi_cylinder_problem_t.is_nextprocess' ),
			Field::inst( 'pmi_cylinder_problem_t.ditemukan_pada' ),
			Field::inst( 'pmi_cylinder_problem_t.action' ),

			Field::inst( 'pmi_cylinder_m.nama' ),
			Field::inst( 'pmi_cylinder_m_color.nama' ),
			Field::inst( 'pmi_cylinder_m_warna.nama' ),
		)
		->leftJoin( 'pmi_cylinder_m','pmi_cylinder_m.id','=','pmi_cylinder_problem_t.id_pmi_cylinder_m' )
		->leftJoin( 'pmi_cylinder_m_color','pmi_cylinder_m_color.id','=','pmi_cylinder_problem_t.id_pmi_cylinder_m_color' )
		->leftJoin( 'pmi_cylinder_m_warna','pmi_cylinder_m_warna.id','=','pmi_cylinder_m_color.id_pmi_cylinder_m_warna' )
		;
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_pmi_cylinder_problem_t'] == 0){
		$editor
			->where( 'pmi_cylinder_problem_t.transaction_state', -9, '<>');
	}
	
	include( "pmi_cylinder_problem_t_extra.php" );

	// BEGIN log
	$nama_table = 'pmi_cylinder_problem_t';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>