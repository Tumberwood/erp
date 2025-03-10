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
	
	if ( ! isset($_POST['id_hfasktd']) || ! is_numeric($_POST['id_hfasktd']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'hfasltd' )
			->debug(true)
			->fields(
				Field::inst( 'hfasltd.id' ),
				Field::inst( 'hfasltd.id_hfasktd' ),
				Field::inst( 'hfasltd.id_hfaxxth' ),
				Field::inst( 'hfasltd.kode' ),
				Field::inst( 'hfasltd.nama' ),
				Field::inst( 'hfasltd.keterangan' ),
				Field::inst( 'hfasltd.created_by' ),
				Field::inst( 'hfasltd.transaction_state' ),
				Field::inst( 'hfasltd.approval_state' ),
				Field::inst( 'hfasltd.start_at' ),
				Field::inst( 'hfasltd.finish_at' ),
				Field::inst( 'hfasltd.is_nextprocess' ),
				Field::inst( 'hfasltd.is_defaultprogram' ),
				Field::inst( 'hfasltd.status' ),
			)
			->where('hfasltd.id_hfaxxth',$_POST['id_hfaxxth'])
			->where('hfasltd.id_hfasktd',$_POST['id_hfasktd'])
			;
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_hfasltd'] == 0){
			$editor
				->where( 'hfasltd.transaction_state', -9, '<>');
		}
		
		include( "hfasltd_extra.php" );

		// BEGIN log
		$nama_table = 'hfasltd';
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