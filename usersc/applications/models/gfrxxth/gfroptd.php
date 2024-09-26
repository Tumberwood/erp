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
	
	if ( ! isset($_POST['id_gfrfltd']) || ! is_numeric($_POST['id_gfrfltd']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'gfroptd' )
			->debug(true)
			->fields(
				Field::inst( 'gfroptd.id' ),
				Field::inst( 'gfroptd.id_gfrfltd' ),
				Field::inst( 'gfroptd.kode' ),
				Field::inst( 'gfroptd.nama' ),
				Field::inst( 'gfroptd.keterangan' ),
				Field::inst( 'gfroptd.created_by' ),
				Field::inst( 'gfroptd.transaction_state' ),
				Field::inst( 'gfroptd.approval_state' ),
				Field::inst( 'gfroptd.start_at' ),
				Field::inst( 'gfroptd.finish_at' ),
				Field::inst( 'gfroptd.is_nextprocess' ),
				Field::inst( 'gfroptd.is_defaultprogram' ),
			)
			->where('gfroptd.id_gfrfltd',$_POST['id_gfrfltd']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_gfroptd'] == 0){
			$editor
				->where( 'gfroptd.transaction_state', -9, '<>');
		}

		// BEGIN log
		$nama_table = 'gfroptd';
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