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
	
	if ( ! isset($_POST['id_crfpxth']) || ! is_numeric($_POST['id_crfpxth']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'crfittd' )
			->debug(true)
			->fields(
				Field::inst( 'crfittd.id' ),
				Field::inst( 'crfittd.id_crfpxth' ),
				Field::inst( 'crfittd.id_sodxxth' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'crfittd.id_sodittd' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'crfittd.id_iimxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'crfittd.id_grlxxmh_customer' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'crfittd.id_iumxxmh_unit' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'crfittd.kode' ),
				Field::inst( 'crfittd.nama' ),
				Field::inst( 'crfittd.keterangan' ),
				Field::inst( 'crfittd.created_by' ),
				Field::inst( 'crfittd.transaction_state' ),
				Field::inst( 'crfittd.approval_state' ),
				Field::inst( 'crfittd.start_at' ),
				Field::inst( 'crfittd.finish_at' ),
				Field::inst( 'crfittd.is_nextprocess' ),
				Field::inst( 'crfittd.is_defaultprogram' ),
				Field::inst( 'grlxxmh.nama' ),
				Field::inst( 'iimxxmh.nama' ),
				Field::inst( 'iumxxmh.kode' ),
				Field::inst( 'sodxxth.kode' ),

				Field::inst( 'crfittd.jumlah_unit' ),
				Field::inst( 'crfittd.tanggal_dibutuhkan_customer' )
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
				Field::inst( 'crfittd.tanggal_dibutuhkan' )
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
			)
			->leftJoin( 'iimxxmh','iimxxmh.id','=','crfittd.id_iimxxmh' )
			->leftJoin( 'sodxxth','sodxxth.id','=','crfittd.id_sodxxth' )
			->leftJoin( 'iumxxmh','iumxxmh.id','=','crfittd.id_iumxxmh_unit' )
			->leftJoin( 'grlxxmh','grlxxmh.id','=','crfittd.id_grlxxmh_customer' )
			->where('crfittd.id_crfpxth',$_POST['id_crfpxth'])
			;
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_crfittd'] == 0){
			$editor
				->where( 'crfittd.transaction_state', -9, '<>');
		}
		
		include( "crfittd_extra.php" );

		// BEGIN log
		$nama_table = 'crfittd';
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