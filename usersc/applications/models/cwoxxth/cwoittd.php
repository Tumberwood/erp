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
	
	if ( ! isset($_POST['id_cwoxxth']) || ! is_numeric($_POST['id_cwoxxth']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'cwoittd' )
			->debug(true)
			->fields(
				Field::inst( 'cwoittd.id' ),
				Field::inst( 'cwoittd.id_cwoxxth' ),
				Field::inst( 'cwoittd.id_rmsxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'cwoittd.id_dbmittd' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'cwoittd.id_iimxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'cwoittd.id_iumxxmh_unit' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'cwoittd.kode' ),
				Field::inst( 'cwoittd.nama' ),
				Field::inst( 'cwoittd.keterangan' ),
				Field::inst( 'cwoittd.created_by' ),
				Field::inst( 'cwoittd.transaction_state' ),
				Field::inst( 'cwoittd.approval_state' ),
				Field::inst( 'cwoittd.start_at' ),
				Field::inst( 'cwoittd.finish_at' ),
				Field::inst( 'cwoittd.is_nextprocess' ),
				Field::inst( 'cwoittd.is_defaultprogram' ),
				Field::inst( 'cwoittd.jumlah_bom' ),
				Field::inst( 'cwoittd.jumlah_total' ),
				Field::inst( 'iimxxmh.nama' ),
				Field::inst( 'rmsxxmh.nama' ),
				Field::inst( 'iumxxmh.kode' ),
			)
			->leftJoin( 'iimxxmh','iimxxmh.id','=','cwoittd.id_iimxxmh' )
			->leftJoin( 'rmsxxmh','rmsxxmh.id','=','cwoittd.id_rmsxxmh' )
			->leftJoin( 'iumxxmh','iumxxmh.id','=','cwoittd.id_iumxxmh_unit' )
			->where('cwoittd.id_cwoxxth',$_POST['id_cwoxxth'])
			;
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_cwoittd'] == 0){
			$editor
				->where( 'cwoittd.transaction_state', -9, '<>');
		}
		
		include( "cwoittd_extra.php" );

		// BEGIN log
		$nama_table = 'cwoittd';
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