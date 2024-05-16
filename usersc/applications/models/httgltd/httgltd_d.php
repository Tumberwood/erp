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
	
	if ( ! isset($_POST['id_httgltd']) || ! is_numeric($_POST['id_httgltd']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'httgltd_d' )
			->debug(true)
			->fields(
				Field::inst( 'httgltd_d.id' ),
				Field::inst( 'httgltd_d.id_httgltd' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'httgltd_d.id_transaksi' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'httgltd_d.kode' ),
				Field::inst( 'httgltd_d.nama' ),
				Field::inst( 'httgltd_d.keterangan' ),
				Field::inst( 'httgltd_d.created_by' ),
				Field::inst( 'httgltd_d.transaction_state' ),
				Field::inst( 'httgltd_d.approval_state' ),
				Field::inst( 'httgltd_d.start_at' ),
				Field::inst( 'httgltd_d.finish_at' ),
				Field::inst( 'httgltd_d.is_defaultprogram' ),
				Field::inst( 'httgltd_d.is_nextprocess' ),
				Field::inst( 'httgltd_d.is_default' ),
				Field::inst( 'httgltd_d.jenis' ),
				Field::inst( 'httgltd_d.nama_tabel' ),
			)
			// ->leftJoin( 'iumxxmh','iumxxmh.id','=','httgltd_d.id_transaksi' )
			->where('httgltd_d.id_httgltd',$_POST['id_httgltd']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_httgltd_d'] == 0){
			$editor
				->where( 'httgltd_d.transaction_state', -9, '<>');
		}
		
		include( "httgltd_d_extra.php" );

		// BEGIN log
		$nama_table = 'httgltd_d';
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