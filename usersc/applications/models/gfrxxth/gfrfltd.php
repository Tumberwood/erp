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
	
	if ( ! isset($_POST['id_gfrxxth']) || ! is_numeric($_POST['id_gfrxxth']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'gfrfltd' )
			->debug(true)
			->fields(
				Field::inst( 'gfrfltd.id' ),
				Field::inst( 'gfrfltd.id_gfrxxth' ),
				Field::inst( 'gfrfltd.kode' ),
				Field::inst( 'gfrfltd.nama' ),
				Field::inst( 'gfrfltd.keterangan' ),
				Field::inst( 'gfrfltd.created_by' ),
				Field::inst( 'gfrfltd.transaction_state' ),
				Field::inst( 'gfrfltd.approval_state' ),
				Field::inst( 'gfrfltd.start_at' ),
				Field::inst( 'gfrfltd.finish_at' ),
				Field::inst( 'gfrfltd.is_nextprocess' ),
				Field::inst( 'gfrfltd.is_defaultprogram' ),
				Field::inst( 'gfrfltd.type' ),
			)
			->where('gfrfltd.id_gfrxxth',$_POST['id_gfrxxth']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_gfrfltd'] == 0){
			$editor
				->where( 'gfrfltd.transaction_state', -9, '<>');
		}
		
		include( "gfrfltd_extra.php" );

		// BEGIN log
		$nama_table = 'gfrfltd';
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