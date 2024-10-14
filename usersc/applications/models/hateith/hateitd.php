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
	
	if ( ! isset($_POST['id_hateith']) || ! is_numeric($_POST['id_hateith']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'hateitd' )
			->debug(true)
			->fields(
				Field::inst( 'hateitd.id' ),
				Field::inst( 'hateitd.id_hateith' ),
				Field::inst( 'hateitd.kode' ),
				Field::inst( 'hateitd.nama' ),
				Field::inst( 'hateitd.keterangan' ),
				Field::inst( 'hateitd.created_by' ),
				Field::inst( 'hateitd.transaction_state' ),
				Field::inst( 'hateitd.approval_state' ),
				Field::inst( 'hateitd.start_at' ),
				Field::inst( 'hateitd.finish_at' ),
				Field::inst( 'hateitd.is_nextprocess' ),
				Field::inst( 'hateitd.is_defaultprogram' )
			)
			->where('hateitd.id_hateith',$_POST['id_hateith']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_hateitd'] == 0){
			$editor
				->where( 'hateitd.transaction_state', -9, '<>');
		}
		
		include( "hateitd_extra.php" );

		// BEGIN log
		$nama_table = 'hateitd';
		include( "../../../helpers/edt_log.php" );
		// END log

		//generate form
		include_once( "../../../helpers/generateForm.php" );		
		
		$json = $editor
			->process( $_POST )
			->data();

		// debugging hak akses
		$json['hakakses'] = $hakakses;

		echo json_encode( $json );

	}
?>