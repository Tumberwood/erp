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
	
	if ( ! isset($_POST['id_sqtxxth']) || ! is_numeric($_POST['id_sqtxxth']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'sqtittd' )
			->debug(true)
			->fields(
				Field::inst( 'sqtittd.id' ),
				Field::inst( 'sqtittd.id_iumxxmh_unit' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'sqtittd.id_iimxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'sqtittd.id_sqtxxth' ),
				Field::inst( 'sqtittd.kode' ),
				Field::inst( 'sqtittd.nama' ),
				Field::inst( 'sqtittd.keterangan' ),
				Field::inst( 'sqtittd.created_by' ),
				Field::inst( 'sqtittd.transaction_state' ),
				Field::inst( 'sqtittd.approval_state' ),
				Field::inst( 'sqtittd.start_at' ),
				Field::inst( 'sqtittd.finish_at' ),
				Field::inst( 'sqtittd.is_defaultprogram' ),
				Field::inst( 'sqtittd.is_nextprocess' ),
				
				Field::inst( 'sqtittd.jumlah_unit' ),
				Field::inst( 'sqtittd.harga_unit' ),
				Field::inst( 'sqtittd.subtotal' ),
				Field::inst( 'sqtittd.diskon_jenis' ),
				Field::inst( 'sqtittd.diskon_value' ),
				Field::inst( 'sqtittd.diskon_persen' ),
				Field::inst( 'sqtittd.diskon_final' ),
				Field::inst( 'sqtittd.dpp' ),
				

				Field::inst( 'iumxxmh.nama' ),
				Field::inst( 'iimxxmh.kode' ),
				Field::inst( 'iimxxmh.nama' )
			)
			->leftJoin( 'iumxxmh','iumxxmh.id','=','sqtittd.id_iumxxmh_unit' )
			->leftJoin( 'iimxxmh','iimxxmh.id','=','sqtittd.id_iimxxmh' )
			->where('sqtittd.id_sqtxxth',$_POST['id_sqtxxth'])
			;
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_sqtittd'] == 0){
			$editor
				->where( 'sqtittd.transaction_state', -9, '<>');
		}
		
		include( "sqtittd_extra.php" );

		// BEGIN log
		$nama_table = 'sqtittd';
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