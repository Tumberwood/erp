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
	
	if ( ! isset($_POST['id_podxxth']) || ! is_numeric($_POST['id_podxxth']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'podittd' )
			->debug(true)
			->fields(
				Field::inst( 'podittd.id' ),
				Field::inst( 'podittd.id_iumxxmh_unit' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'podittd.id_prqittd' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'podittd.id_iimxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'podittd.id_podxxth' ),
				Field::inst( 'podittd.kode' ),
				Field::inst( 'podittd.nama' ),
				Field::inst( 'podittd.keterangan' ),
				Field::inst( 'podittd.created_by' ),
				Field::inst( 'podittd.transaction_state' ),
				Field::inst( 'podittd.approval_state' ),
				Field::inst( 'podittd.start_at' ),
				Field::inst( 'podittd.finish_at' ),
				Field::inst( 'podittd.tanggal_dibutuhkan' )
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
				Field::inst( 'podittd.is_defaultprogram' ),
				Field::inst( 'podittd.jumlah_unit' ),
				Field::inst( 'podittd.harga_unit' ),
				Field::inst( 'podittd.subtotal' ),
				Field::inst( 'podittd.diskon_jenis' ),
				Field::inst( 'podittd.diskon_value' ),
				Field::inst( 'podittd.diskon_persen' ),
				Field::inst( 'podittd.diskon_final' ),
				Field::inst( 'podittd.dpp' ),
				Field::inst( 'iumxxmh.nama' ),
				Field::inst( 'iimxxmh.nama' ),
				Field::inst( 'prqxxth.kode' )
			)
			->leftJoin( 'iumxxmh','iumxxmh.id','=','podittd.id_iumxxmh_unit' )
			->leftJoin( 'prqittd','prqittd.id','=','podittd.id_prqittd' )
			->leftJoin( 'prqxxth','prqxxth.id','=','prqittd.id_prqxxth' )
			->leftJoin( 'iimxxmh','iimxxmh.id','=','podittd.id_iimxxmh' )
			->where('podittd.id_podxxth',$_POST['id_podxxth']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_podittd'] == 0){
			$editor
				->where( 'podittd.transaction_state', -9, '<>');
		}
		
		include( "podittd_extra.php" );

		// BEGIN log
		$nama_table = 'podittd';
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