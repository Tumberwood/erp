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
	
	if ( ! isset($_POST['id_hatemth']) || ! is_numeric($_POST['id_hatemth']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'hatemtd' )
			->debug(true)
			->fields(
				Field::inst( 'hatemtd.id' ),
				Field::inst( 'hatemtd.id_hatemth' ),
				Field::inst( 'hatemtd.id_hpcxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'hatemtd.kode' ),
				Field::inst( 'hatemtd.nama' ),
				Field::inst( 'hatemtd.keterangan' ),
				Field::inst( 'hatemtd.created_by' ),
				Field::inst( 'hatemtd.transaction_state' ),
				Field::inst( 'hatemtd.approval_state' ),
				Field::inst( 'hatemtd.start_at' ),
				Field::inst( 'hatemtd.finish_at' ),
				Field::inst( 'hatemtd.is_nextprocess' ),
				Field::inst( 'hatemtd.is_defaultprogram' ),
				Field::inst( 'hatemtd.nominal' ),
				Field::inst( 'hpcxxmh.nama' ),
			)
			->leftJoin( 'hpcxxmh','hpcxxmh.id','=','hatemtd.id_hpcxxmh' )
			->where('hatemtd.id_hatemth',$_POST['id_hatemth']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_hatemtd'] == 0){
			$editor
				->where( 'hatemtd.transaction_state', -9, '<>');
		}
		
		include( "hatemtd_extra.php" );

		// BEGIN log
		$nama_table = 'hatemtd';
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