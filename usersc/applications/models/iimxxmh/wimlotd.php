<?php
	include_once( "../../../../users/init.php" );
	include_once( "../../../../usersc/lib/DataTables.php" );
	include_once( "../../../../usersc/vendor/autoload.php");
	include_once( "../../../helpers/hakakses_s_fn.php" );
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
		$editor = Editor::inst( $db, 'wimlotd' )
			->debug(true)
			->fields(
				Field::inst( 'wimlotd.id' ),
				Field::inst( 'wimlotd.id_iimxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'wimlotd.id_wloxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'wimlotd.kode' ),
				Field::inst( 'wimlotd.nama' ),
				Field::inst( 'wimlotd.keterangan' ),
				Field::inst( 'wimlotd.created_by' ),
				Field::inst( 'wimlotd.transaction_state' ),
				Field::inst( 'wimlotd.approval_state' ),
				Field::inst( 'wimlotd.start_at' ),
				Field::inst( 'wimlotd.finish_at' ),
				Field::inst( 'wimlotd.is_defaultprogram' ),
				Field::inst( 'wimlotd.is_nextprocess' ),
				Field::inst( 'wimlotd.is_default' ),
				Field::inst( 'wimlotd.urutan' ),

				Field::inst( 'wloxxmh.nama' )
			)
			->leftJoin( 'wloxxmh','wloxxmh.id','=','wimlotd.id_wloxxmh' )
			->where('wimlotd.id_iimxxmh',$_POST['id_iimxxmh']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_wimlotd'] == 0){
			$editor
				->where( 'wimlotd.transaction_state', -9, '<>');
		}
		
		include( "wimlotd_extra.php" );

		// BEGIN log
		$nama_table = 'wimlotd';
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