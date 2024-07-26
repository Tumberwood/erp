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
	
	if ( ! isset($_POST['id_igixxth']) || ! is_numeric($_POST['id_igixxth']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'igiittd' )
			->debug(true)
			->fields(
				Field::inst( 'igiittd.id' ),
				Field::inst( 'igiittd.id_igixxth' ),
				Field::inst( 'igiittd.id_iimxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'igiittd.id_iumxxmh_unit' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'igiittd.kode' ),
				Field::inst( 'igiittd.nama' ),
				Field::inst( 'igiittd.keterangan' ),
				Field::inst( 'igiittd.created_by' ),
				Field::inst( 'igiittd.transaction_state' ),
				Field::inst( 'igiittd.approval_state' ),
				Field::inst( 'igiittd.start_at' ),
				Field::inst( 'igiittd.finish_at' ),
				Field::inst( 'igiittd.is_nextprocess' ),
				Field::inst( 'igiittd.is_defaultprogram' ),
				Field::inst( 'igiittd.jumlah_unit' ),
				
				Field::inst( 'iimxxmh.kode' ),
				Field::inst( 'iimxxmh.nama' ),
				Field::inst( 'iumxxmh.kode' )
			)
			->leftJoin( 'iumxxmh','iumxxmh.id','=','igiittd.id_iumxxmh_unit' )
			->leftJoin( 'iimxxmh','iimxxmh.id','=','igiittd.id_iimxxmh' )
			->where('igiittd.id_igixxth',$_POST['id_igixxth']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_igiittd'] == 0){
			$editor
				->where( 'igiittd.transaction_state', -9, '<>');
		}
		
		include( "igiittd_extra.php" );

		// BEGIN log
		$nama_table = 'igiittd';
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