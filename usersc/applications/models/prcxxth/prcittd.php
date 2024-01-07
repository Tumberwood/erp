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
	
	if ( ! isset($_POST['id_prcxxth']) || ! is_numeric($_POST['id_prcxxth']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'prcittd' )
			->debug(true)
			->fields(
				Field::inst( 'prcittd.id' ),
				Field::inst( 'prcittd.id_prcxxth' ),
				Field::inst( 'prcittd.id_iimxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'prcittd.id_iumxxmh_unit' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'prcittd.kode' ),
				Field::inst( 'prcittd.nama' ),
				Field::inst( 'prcittd.keterangan' ),
				Field::inst( 'prcittd.created_by' ),
				Field::inst( 'prcittd.transaction_state' ),
				Field::inst( 'prcittd.approval_state' ),
				Field::inst( 'prcittd.start_at' ),
				Field::inst( 'prcittd.finish_at' ),
				Field::inst( 'prcittd.is_defaultprogram' ),

				Field::inst( 'prcittd.jumlah_unit' ),
				Field::inst( 'iimxxmh.nama' ),
				Field::inst( 'iumxxmh_unit.nama' )
			)
			->leftJoin( 'iumxxmh as iumxxmh_unit','iumxxmh_unit.id','=','prcittd.id_iumxxmh_unit' )
			->leftJoin( 'iimxxmh','iimxxmh.id','=','prcittd.id_iimxxmh' )
			->where('prcittd.id_prcxxth',$_POST['id_prcxxth']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_prcittd'] == 0){
			$editor
				->where( 'prcittd.transaction_state', -9, '<>');
		}
		
		include( "prcittd_extra.php" );

		// BEGIN log
		$nama_table = 'prcittd';
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