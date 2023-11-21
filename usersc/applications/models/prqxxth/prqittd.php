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
	
	if ( ! isset($_POST['id_prqxxth']) || ! is_numeric($_POST['id_prqxxth']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'prqittd' )
			->debug(true)
			->fields(
				Field::inst( 'prqittd.id' ),
				Field::inst( 'prqittd.id_iumxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'prqittd.id_prqxxth' ),
				Field::inst( 'prqittd.kode' ),
				Field::inst( 'prqittd.nama' ),
				Field::inst( 'prqittd.keterangan' ),
				Field::inst( 'prqittd.created_by' ),
				Field::inst( 'prqittd.transaction_state' ),
				Field::inst( 'prqittd.approval_state' ),
				Field::inst( 'prqittd.start_at' ),
				Field::inst( 'prqittd.finish_at' ),
				Field::inst( 'prqittd.tanggal' )
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
				Field::inst( 'prqittd.is_defaultprogram' ),
				Field::inst( 'prqittd.qty' ),
				Field::inst( 'iumxxmh.nama' )
			)
			->leftJoin( 'iumxxmh','iumxxmh.id','=','prqittd.id_iumxxmh' )
			->where('prqittd.id_prqxxth',$_POST['id_prqxxth'])
			;
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_prqittd'] == 0){
			$editor
				->where( 'prqittd.transaction_state', -9, '<>');
		}
		
		include( "prqittd_extra.php" );

		// BEGIN log
		$nama_table = 'prqittd';
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