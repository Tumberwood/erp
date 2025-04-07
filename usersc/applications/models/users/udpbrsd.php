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
	
	if ( ! isset($_POST['id_udpxxsh']) || ! is_numeric($_POST['id_udpxxsh']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'udpbrsd' )
			->debug(true)
			->fields(
				Field::inst( 'udpbrsd.id' ),
				Field::inst( 'udpbrsd.id_udpxxsh' ),
				Field::inst( 'udpbrsd.id_gbrxxmh' ),
				Field::inst( 'udpbrsd.kode' )
					->searchPaneOptions( SearchPaneOptions::inst()),
				Field::inst( 'udpbrsd.nama' )
					->searchPaneOptions( SearchPaneOptions::inst()),
				Field::inst( 'udpbrsd.keterangan' ),
				Field::inst( 'udpbrsd.transaction_state' ),
				Field::inst( 'udpbrsd.approval_state' )
					->searchPaneOptions( SearchPaneOptions::inst()),
				Field::inst( 'udpbrsd.start_at' ),
				Field::inst( 'udpbrsd.finish_at' ),
				Field::inst( 'udpbrsd.is_defaultprogram' ),

				Field::inst( 'gbrxxmh.nama' )
			)
			->leftJoin( 'gbrxxmh','gbrxxmh.id','=','udpbrsd.id_gbrxxmh' )
			->where('udpbrsd.id_udpxxsh',$_POST['id_udpxxsh']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_udpbrsd'] == 0){
			$editor
				->where( 'udpbrsd.transaction_state', -9, '<>');
		}
		
		// include( "udpbrsd_extra.php" );
		
		// BEGIN log
		$nama_table = 'udpbrsd';
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