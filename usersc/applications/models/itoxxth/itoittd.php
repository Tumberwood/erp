<?php
	include_once( "../../../../users/init.php" );
	include_once( "../../../../usersc/lib/DataTables.php" );
	include_once( "../../../../usersc/vendor/autoload.php");
	include_once( "../../../helpers/hakakses_s_fn.php" );
	
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
	
	if ( ! isset($_POST['id_itoxxth']) || ! is_numeric($_POST['id_itoxxth']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'itoittd' )
			->debug(true)
			->fields(
				Field::inst( 'itoittd.id' ),
				Field::inst( 'itoittd.id_iimxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'itoittd.id_iumxxmh_unit' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'itoittd.id_itoxxth' ),
				Field::inst( 'itoittd.kode' ),
				Field::inst( 'itoittd.nama' ),
				Field::inst( 'itoittd.keterangan' ),
				Field::inst( 'itoittd.created_by' ),
				Field::inst( 'itoittd.transaction_state' ),
				Field::inst( 'itoittd.approval_state' ),
				Field::inst( 'itoittd.start_at' ),
				Field::inst( 'itoittd.finish_at' ),
				Field::inst( 'itoittd.is_defaultprogram' ),
				Field::inst( 'itoittd.jumlah_unit' ),
				Field::inst( 'iimxxmh.kode' ),
				Field::inst( 'iimxxmh.nama' ),
				Field::inst( 'iumxxmh_unit.nama' )
			)
			->leftJoin( 'iumxxmh as iumxxmh_unit','iumxxmh_unit.id','=','itoittd.id_iumxxmh_unit' )
			->leftJoin( 'iimxxmh','iimxxmh.id','=','itoittd.id_iimxxmh' )
			->where('itoittd.id_itoxxth',$_POST['id_itoxxth'])
			;
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_itoittd'] == 0){
			$editor
				->where( 'itoittd.transaction_state', -9, '<>');
		}
		
		include( "itoittd_extra.php" );

		// BEGIN log
		$nama_table = 'itoittd';
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