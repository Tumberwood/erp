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
		$editor = Editor::inst( $db, 'udpwhsd' )
			->debug(true)
			->fields(
				Field::inst( 'udpwhsd.id' ),
				Field::inst( 'udpwhsd.id_udpxxsh' ),
				Field::inst( 'udpwhsd.id_iwhxxmh' ),
				Field::inst( 'udpwhsd.kode' )
					->searchPaneOptions( SearchPaneOptions::inst()),
				Field::inst( 'udpwhsd.nama' )
					->searchPaneOptions( SearchPaneOptions::inst()),
				Field::inst( 'udpwhsd.keterangan' ),
				Field::inst( 'udpwhsd.transaction_state' ),
				Field::inst( 'udpwhsd.approval_state' )
					->searchPaneOptions( SearchPaneOptions::inst()),
				Field::inst( 'udpwhsd.start_at' ),
				Field::inst( 'udpwhsd.finish_at' ),
				Field::inst( 'udpwhsd.is_defaultprogram' ),

				Field::inst( 'iwhxxmh.nama' )
			)
			->leftJoin( 'iwhxxmh','iwhxxmh.id','=','udpwhsd.id_iwhxxmh' )
			->where('udpwhsd.id_udpxxsh',$_POST['id_udpxxsh']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_udpwhsd'] == 0){
			$editor
				->where( 'udpwhsd.transaction_state', -9, '<>');
		}
		
		// include( "udpwhsd_extra.php" );
		
		// BEGIN log
		$nama_table = 'udpwhsd';
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