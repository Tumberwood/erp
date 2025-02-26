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
	
	if ( ! isset($_POST['id_sivxxth']) || ! is_numeric($_POST['id_sivxxth']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'sivittd' )
			->debug(true)
			->fields(
				Field::inst( 'sivittd.id' ),
				Field::inst( 'sivittd.id_sivxxth' ),
				Field::inst( 'sivittd.id_iumxxmh_unit' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'sivittd.id_iumxxmh_buy' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'sivittd.id_sdlittd' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'sivittd.id_iimxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'sivittd.kode' ),
				Field::inst( 'sivittd.nama' ),
				Field::inst( 'sivittd.keterangan' ),
				Field::inst( 'sivittd.created_by' ),
				Field::inst( 'sivittd.transaction_state' ),
				Field::inst( 'sivittd.approval_state' ),
				Field::inst( 'sivittd.start_at' ),
				Field::inst( 'sivittd.finish_at' ),
				Field::inst( 'sivittd.tanggal_dibutuhkan' )
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
				Field::inst( 'sivittd.is_defaultprogram' ),
				Field::inst( 'sivittd.jumlah_unit' ),
				Field::inst( 'sivittd.jumlah_buy' ),
				Field::inst( 'sivittd.harga_unit' ),
				Field::inst( 'sivittd.harga_buy' ),
				Field::inst( 'sivittd.subtotal' ),
				Field::inst( 'sivittd.diskon_jenis' ),
				Field::inst( 'sivittd.diskon_value' ),
				Field::inst( 'sivittd.diskon_persen' ),
				Field::inst( 'sivittd.diskon_final' ),
				Field::inst( 'sivittd.dpp' ),

				Field::inst( 'iumxxmh.nama' ),
				Field::inst( 'iimxxmh.kode' ),
				Field::inst( 'iimxxmh.nama' ),
				Field::inst( 'sdlxxth.kode' )
			)
			->leftJoin( 'iumxxmh','iumxxmh.id','=','sivittd.id_iumxxmh_unit' )
			->leftJoin( 'sdlittd','sdlittd.id','=','sivittd.id_sdlittd' )
			->leftJoin( 'sdlxxth','sdlxxth.id','=','sdlittd.id_sdlxxth' )
			->leftJoin( 'iimxxmh','iimxxmh.id','=','sivittd.id_iimxxmh' )
			->where('sivittd.id_sivxxth',$_POST['id_sivxxth']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_sivittd'] == 0){
			$editor
				->where( 'sivittd.transaction_state', -9, '<>');
		}
		
		// BEGIN log
		$nama_table = 'sivittd';
		$nama_table_before = 'sdlittd';
		include( "sivittd_extra.php" );

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