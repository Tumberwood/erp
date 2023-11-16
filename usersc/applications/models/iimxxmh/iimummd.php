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
	
	if ( ! isset($_POST['id_iimxxmh']) || ! is_numeric($_POST['id_iimxxmh']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'iimummd' )
			->debug(true)
			->fields(
				Field::inst( 'iimummd.id' ),
				Field::inst( 'iimummd.id_iimxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'iimummd.id_iumxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'iimummd.kode' ),
				Field::inst( 'iimummd.nama' ),
				Field::inst( 'iimummd.keterangan' ),
				Field::inst( 'iimummd.created_by' ),
				Field::inst( 'iimummd.transaction_state' ),
				Field::inst( 'iimummd.approval_state' ),
				Field::inst( 'iimummd.start_at' ),
				Field::inst( 'iimummd.finish_at' ),
				Field::inst( 'iimummd.is_defaultprogram' ),

				Field::inst( 'iimummd.is_terkecil' ),
				Field::inst( 'iimummd.jumlah_konversi' ),
				Field::inst( 'iimummd.panjang' ),
				Field::inst( 'iimummd.lebar' ),
				Field::inst( 'iimummd.tinggi' ),
				Field::inst( 'iimummd.nw' ),
				Field::inst( 'iimummd.gw' ),

				Field::inst( 'iumxxmh.kode' )
			)
			->leftJoin( 'iumxxmh','iumxxmh.id','=','iimummd.id_iumxxmh' )
			->where('iimummd.id_iimxxmh',$_POST['id_iimxxmh']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_iimummd'] == 0){
			$editor
				->where( 'iimummd.transaction_state', -9, '<>');
		}
		
		include( "iimummd_extra.php" );

		// BEGIN log
		$nama_table = 'iimummd';
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