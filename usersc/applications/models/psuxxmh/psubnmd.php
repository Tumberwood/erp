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
		$editor = Editor::inst( $db, 'psubnmd' )
			->debug(true)
			->fields(
				Field::inst( 'psubnmd.id' ),
				Field::inst( 'psubnmd.id_psuxxmh' ),
				Field::inst( 'psubnmd.id_fbnxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'psubnmd.kode' ),
				Field::inst( 'psubnmd.nama' ),
				Field::inst( 'psubnmd.keterangan' ),
				Field::inst( 'psubnmd.created_by' ),
				Field::inst( 'psubnmd.transaction_state' ),
				Field::inst( 'psubnmd.approval_state' ),
				Field::inst( 'psubnmd.start_at' ),
				Field::inst( 'psubnmd.finish_at' ),
				Field::inst( 'psubnmd.is_defaultprogram' ),
				Field::inst( 'psubnmd.is_default' ),
				Field::inst( 'psubnmd.no_rek' ),
				Field::inst( 'fbnxxmh.nama' )
			)
			->leftJoin( 'fbnxxmh','fbnxxmh.id','=','psubnmd.id_fbnxxmh' )
			->where('psubnmd.id_psuxxmh',$_POST['id_psuxxmh']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_psubnmd'] == 0){
			$editor
				->where( 'psubnmd.transaction_state', -9, '<>');
		}
		
		include( "psubnmd_extra.php" );

		// BEGIN log
		$nama_table = 'psubnmd';
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