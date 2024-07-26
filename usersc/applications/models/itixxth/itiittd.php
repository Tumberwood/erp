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
	
	if ( ! isset($_POST['id_itixxth']) || ! is_numeric($_POST['id_itixxth']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'itiittd' )
			->debug(true)
			->fields(
				Field::inst( 'itiittd.id' ),
				Field::inst( 'itiittd.id_itixxth' ),
				Field::inst( 'itiittd.id_itoxxth' ),
				Field::inst( 'itiittd.id_itoittd' ),
				Field::inst( 'itiittd.id_iimxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'itiittd.id_iumxxmh_unit' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'itiittd.kode' ),
				Field::inst( 'itiittd.nama' ),
				Field::inst( 'itiittd.keterangan' ),
				Field::inst( 'itiittd.created_by' ),
				Field::inst( 'itiittd.transaction_state' ),
				Field::inst( 'itiittd.approval_state' ),
				Field::inst( 'itiittd.start_at' ),
				Field::inst( 'itiittd.finish_at' ),
				Field::inst( 'itiittd.is_nextprocess' ),
				Field::inst( 'itiittd.is_defaultprogram' ),
				Field::inst( 'itiittd.jumlah_unit' ),

				Field::inst( 'iimxxmh.kode' ),
				Field::inst( 'iimxxmh.nama' ),
				Field::inst( 'iumxxmh.nama' )
			)
			->leftJoin( 'iumxxmh','iumxxmh.id','=','itiittd.id_iumxxmh_unit' )
			->leftJoin( 'iimxxmh','iimxxmh.id','=','itiittd.id_iimxxmh' )
			->where('itiittd.id_itixxth',$_POST['id_itixxth'])
			;
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_itiittd'] == 0){
			$editor
				->where( 'itiittd.transaction_state', -9, '<>');
		}
		
		include( "itiittd_extra.php" );

		// BEGIN log
		$nama_table = 'itiittd';
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