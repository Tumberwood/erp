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
	
	if ( ! isset($_POST['id_sodxxth']) || ! is_numeric($_POST['id_sodxxth']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'sodittd' )
			->debug(true)
			->fields(
				Field::inst( 'sodittd.id' ),
				Field::inst( 'sodittd.id_sodxxth' ),
				Field::inst( 'sodittd.id_iumxxmh_unit' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'sodittd.id_sqtittd' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'sodittd.id_iimxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'sodittd.kode' ),
				Field::inst( 'sodittd.nama' ),
				Field::inst( 'sodittd.keterangan' ),
				Field::inst( 'sodittd.created_by' ),
				Field::inst( 'sodittd.transaction_state' ),
				Field::inst( 'sodittd.approval_state' ),
				Field::inst( 'sodittd.start_at' ),
				Field::inst( 'sodittd.finish_at' ),
				Field::inst( 'sodittd.tanggal_dibutuhkan' )
					->getFormatter( function ( $val, $data, $opts ) {
						if ($val === '0000-00-00' || $val === null){
							echo '';
						}else{
							return date( 'd M Y', strtotime( $val ) );
						}
					} )
					->setFormatter( 'Format::datetime', array(
						'from' => 'd M Y',
						'to' =>   'Y-m-d'
					) ),
				Field::inst( 'sodittd.is_defaultprogram' ),
				Field::inst( 'sodittd.jumlah_unit' ),
				Field::inst( 'sodittd.harga_unit' ),
				Field::inst( 'sodittd.subtotal' ),
				Field::inst( 'sodittd.diskon_jenis' ),
				Field::inst( 'sodittd.diskon_value' ),
				Field::inst( 'sodittd.diskon_persen' ),
				Field::inst( 'sodittd.diskon_final' ),
				Field::inst( 'sodittd.dpp' ),

				Field::inst( 'iumxxmh.nama' ),
				Field::inst( 'iimxxmh.kode' ),
				Field::inst( 'iimxxmh.nama' ),
				Field::inst( 'sqtxxth.kode' )
			)
			->leftJoin( 'iumxxmh','iumxxmh.id','=','sodittd.id_iumxxmh_unit' )
			->leftJoin( 'sqtittd','sqtittd.id','=','sodittd.id_sqtittd' )
			->leftJoin( 'sqtxxth','sqtxxth.id','=','sqtittd.id_sqtxxth' )
			->leftJoin( 'iimxxmh','iimxxmh.id','=','sodittd.id_iimxxmh' )
			->where('sodittd.id_sodxxth',$_POST['id_sodxxth']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_sodittd'] == 0){
			$editor
				->where( 'sodittd.transaction_state', -9, '<>');
		}
		
		include( "sodittd_extra.php" );

		// BEGIN log
		$nama_table = 'sodittd';
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