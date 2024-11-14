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
	
	if ( ! isset($_POST['id_wrexxth']) || ! is_numeric($_POST['id_wrexxth']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'wrexxth_wreittd' )
			->debug(true)
			->fields(
				Field::inst( 'wrexxth_wreittd.id' ),
				Field::inst( 'wrexxth_wreittd.id_wrexxth' ),
				Field::inst( 'wrexxth_wreittd.id_wreittd' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'wrexxth_wreittd.kode' ),
				Field::inst( 'wrexxth_wreittd.nama' ),
				Field::inst( 'wrexxth_wreittd.keterangan' ),
				Field::inst( 'wrexxth_wreittd.created_by' ),
				Field::inst( 'wrexxth_wreittd.transaction_state' ),
				Field::inst( 'wrexxth_wreittd.approval_state' ),
				Field::inst( 'wrexxth_wreittd.start_at' ),
				Field::inst( 'wrexxth_wreittd.finish_at' ),
				Field::inst( 'wrexxth_wreittd.is_nextprocess' ),
				Field::inst( 'wrexxth_wreittd.is_defaultprogram' ),
				
				Field::inst( 'wreittd.kode' ),
				Field::inst( 'wreittd.wlpxxmh_kode' ),
				Field::inst( 'wreittd.jumlah_unit' ),
				Field::inst( 'iimxxmh.kode' ),
				Field::inst( 'iimxxmh.nama' ),
				Field::inst( 'iumxxmh.kode' ),
			)
			->leftJoin( 'wreittd','wreittd.id','=','wrexxth_wreittd.id_wreittd' )
			->leftJoin( 'iimxxmh','iimxxmh.id','=','wreittd.id_iimxxmh' )
			->leftJoin( 'iumxxmh','iumxxmh.id','=','wreittd.id_iumxxmh_unit' )
			->where('wrexxth_wreittd.id_wrexxth',$_POST['id_wrexxth']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_wrexxth_wreittd'] == 0){
			$editor
				->where( 'wrexxth_wreittd.transaction_state', -9, '<>');
		}
		
		include( "wrexxth_wreittd_extra.php" );

		// BEGIN log
		$nama_table = 'wrexxth_wreittd';
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