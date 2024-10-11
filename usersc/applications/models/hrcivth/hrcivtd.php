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
	
	if ( ! isset($_POST['id_hrcivth']) || ! is_numeric($_POST['id_hrcivth']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'hrcivtd' )
			->debug(true)
			->fields(
				Field::inst( 'hrcivtd.id' ),
				Field::inst( 'hrcivtd.id_hrcivth' ),
				Field::inst( 'hrcivtd.kode' ),
				Field::inst( 'hrcivtd.nama' ),
				Field::inst( 'hrcivtd.keterangan' ),
				Field::inst( 'hrcivtd.created_by' ),
				Field::inst( 'hrcivtd.transaction_state' ),
				Field::inst( 'hrcivtd.approval_state' ),
				Field::inst( 'hrcivtd.start_at' ),
				Field::inst( 'hrcivtd.finish_at' ),
				Field::inst( 'hrcivtd.is_nextprocess' ),
				Field::inst( 'hrcivtd.is_defaultprogram' )
			)
			->where('hrcivtd.id_hrcivth',$_POST['id_hrcivth']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_hrcivtd'] == 0){
			$editor
				->where( 'hrcivtd.transaction_state', -9, '<>');
		}
		
		include( "hrcivtd_extra.php" );

		// BEGIN log
		$nama_table = 'hrcivtd';
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