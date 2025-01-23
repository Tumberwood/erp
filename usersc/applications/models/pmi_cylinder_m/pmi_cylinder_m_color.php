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
	
	if ( ! isset($_POST['id_pmi_cylinder_m']) || ! is_numeric($_POST['id_pmi_cylinder_m']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'pmi_cylinder_m_color' )
			->debug(true)
			->fields(
				Field::inst( 'pmi_cylinder_m_color.id' ),
				Field::inst( 'pmi_cylinder_m_color.id_pmi_cylinder_m' ),
				Field::inst( 'pmi_cylinder_m_color.id_pmi_cylinder_m_warna' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'pmi_cylinder_m_color.kode' ),
				Field::inst( 'pmi_cylinder_m_color.nama' ),
				Field::inst( 'pmi_cylinder_m_color.keterangan' ),
				Field::inst( 'pmi_cylinder_m_color.created_by' ),
				Field::inst( 'pmi_cylinder_m_color.transaction_state' ),
				Field::inst( 'pmi_cylinder_m_color.approval_state' ),
				Field::inst( 'pmi_cylinder_m_color.start_at' ),
				Field::inst( 'pmi_cylinder_m_color.finish_at' ),
				Field::inst( 'pmi_cylinder_m_color.is_nextprocess' ),
				Field::inst( 'pmi_cylinder_m_color.is_defaultprogram' ),

				Field::inst( 'pmi_cylinder_m_warna.nama' )
			)
			->leftJoin( 'pmi_cylinder_m_warna','pmi_cylinder_m_warna.id','=','pmi_cylinder_m_color.id_pmi_cylinder_m_warna' )
			->where('pmi_cylinder_m_color.id_pmi_cylinder_m',$_POST['id_pmi_cylinder_m']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_pmi_cylinder_m_color'] == 0){
			$editor
				->where( 'pmi_cylinder_m_color.transaction_state', -9, '<>');
		}
		
		include( "pmi_cylinder_m_color_extra.php" );

		// BEGIN log
		$nama_table = 'pmi_cylinder_m_color';
		include( "../../../helpers/edt_log.php" );
		// END log
		
		$json = $editor
			->process( $_POST )
			->data();

		// debugging hak akses
		$json['hakakses'] = $hakakses;

		echo json_encode( $json );

	}
?>