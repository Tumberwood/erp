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
	
	if ( ! isset($_POST['id_psuxxmh']) || ! is_numeric($_POST['id_psuxxmh']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'psuxxtd' )
			->debug(true)
			->fields(
				Field::inst( 'psuxxtd.id' ),
				Field::inst( 'psuxxtd.id_psuxxmh' ),
				Field::inst( 'psuxxtd.id_hbnxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'psuxxtd.kode' ),
				Field::inst( 'psuxxtd.nama' ),
				Field::inst( 'psuxxtd.keterangan' ),
				Field::inst( 'psuxxtd.created_by' ),
				Field::inst( 'psuxxtd.transaction_state' ),
				Field::inst( 'psuxxtd.approval_state' ),
				Field::inst( 'psuxxtd.start_at' ),
				Field::inst( 'psuxxtd.finish_at' ),
				Field::inst( 'psuxxtd.is_defaultprogram' ),
				Field::inst( 'psuxxtd.is_default' ),
				Field::inst( 'psuxxtd.no_rek' ),
				Field::inst( 'hbnxxmh.nama' )
			)
			->leftJoin( 'hbnxxmh','hbnxxmh.id','=','psuxxtd.id_hbnxxmh' )
			->where('psuxxtd.id_psuxxmh',$_POST['id_psuxxmh']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_psuxxtd'] == 0){
			$editor
				->where( 'psuxxtd.transaction_state', -9, '<>');
		}
		
		include( "psuxxtd_extra.php" );

		// BEGIN log
		$nama_table = 'psuxxtd';
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