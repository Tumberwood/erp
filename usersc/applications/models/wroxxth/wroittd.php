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
	
	if ( ! isset($_POST['id_wroxxth']) || ! is_numeric($_POST['id_wroxxth']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'wroittd' )
			->debug(true)
			->fields(
				Field::inst( 'wroittd.id' ),
				Field::inst( 'wroittd.id_wroxxth' ),
				Field::inst( 'wroittd.id_iumxxmh_unit' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'wroittd.id_prqittd' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'wroittd.id_iimxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'wroittd.kode' ),
				Field::inst( 'wroittd.nama' ),
				Field::inst( 'wroittd.keterangan' ),
				Field::inst( 'wroittd.created_by' ),
				Field::inst( 'wroittd.transaction_state' ),
				Field::inst( 'wroittd.approval_state' ),
				Field::inst( 'wroittd.start_at' ),
				Field::inst( 'wroittd.finish_at' ),
				Field::inst( 'wroittd.tanggal_dibutuhkan' )
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
				Field::inst( 'wroittd.is_defaultprogram' ),
				Field::inst( 'wroittd.jumlah_unit' ),
				Field::inst( 'wroittd.harga_unit' ),
				Field::inst( 'wroittd.subtotal' ),
				Field::inst( 'wroittd.diskon_jenis' ),
				Field::inst( 'wroittd.diskon_value' ),
				Field::inst( 'wroittd.diskon_persen' ),
				Field::inst( 'wroittd.diskon_final' ),
				Field::inst( 'wroittd.dpp' ),

				Field::inst( 'iumxxmh.nama' ),
				Field::inst( 'iimxxmh.kode' ),
				Field::inst( 'iimxxmh.nama' ),
				Field::inst( 'prqxxth.kode' )
			)
			->leftJoin( 'iumxxmh','iumxxmh.id','=','wroittd.id_iumxxmh_unit' )
			->leftJoin( 'prqittd','prqittd.id','=','wroittd.id_prqittd' )
			->leftJoin( 'prqxxth','prqxxth.id','=','prqittd.id_prqxxth' )
			->leftJoin( 'iimxxmh','iimxxmh.id','=','wroittd.id_iimxxmh' )
			->where('wroittd.id_wroxxth',$_POST['id_wroxxth']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_wroittd'] == 0){
			$editor
				->where( 'wroittd.transaction_state', -9, '<>');
		}
		
		include( "wroittd_extra.php" );

		// BEGIN log
		$nama_table = 'wroittd';
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