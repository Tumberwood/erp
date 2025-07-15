<?php
	include_once( "../../../../users/init.php" );
	include_once( "../../../../usersc/lib/DataTables.php" );
	include_once( "../../../../usersc/vendor/autoload.php");
	include_once( "../../../helpers/hakakses_s_fn.php" );
	include_once( "../../../helpers/SolusiIndonesiaUtilities.php" );
	include_once( "../../../helpers/fn_is_nextprocess.php" );
	include_once( "../../../helpers/fn_is_default_update_d.php" );
	
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
		$editor = Editor::inst( $db, 'wimivtd' )
			->debug(true)
			->fields(
				Field::inst( 'wimivtd.id' ),
				Field::inst( 'wimivtd.id_iimxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'wimivtd.id_iwhxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'wimivtd.id_iumxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'wimivtd.kode' ),
				Field::inst( 'wimivtd.nama' ),
				Field::inst( 'wimivtd.keterangan' ),
				Field::inst( 'wimivtd.created_by' ),
				Field::inst( 'wimivtd.transaction_state' ),
				Field::inst( 'wimivtd.approval_state' ),
				Field::inst( 'wimivtd.start_at' ),
				Field::inst( 'wimivtd.finish_at' ),
				Field::inst( 'wimivtd.is_defaultprogram' ),
				Field::inst( 'wimivtd.is_nextprocess' ),
				Field::inst( 'wimivtd.is_default' ),
				Field::inst( 'wimivtd.min_stock' ),
				Field::inst( 'wimivtd.max_stock' ),

				Field::inst( 'iwhxxmh.nama' ),
				Field::inst( 'iumxxmh.kode' ),
				Field::inst( 'v_wimivtd.current_stock as current_stock' ),
			)
			->leftJoin( 'iwhxxmh','iwhxxmh.id','=','wimivtd.id_iwhxxmh' )
			->leftJoin( 'iumxxmh','iumxxmh.id','=','wimivtd.id_iumxxmh' )
			->leftJoin( 'v_wimivtd','v_wimivtd.id','=','wimivtd.id' )
			->where('wimivtd.id_iimxxmh',$_POST['id_iimxxmh']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_wimivtd'] == 0){
			$editor
				->where( 'wimivtd.transaction_state', -9, '<>');
		}
		
		// include( "wimivtd_extra.php" );

		// BEGIN log
		$nama_table = 'wimivtd';
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