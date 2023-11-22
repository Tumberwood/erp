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
	
	if ( ! isset($_POST['id_scuxxmh']) || ! is_numeric($_POST['id_scuxxmh']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'sculomd' )
			->debug(true)
			->fields(
				Field::inst( 'sculomd.id' ),
				Field::inst( 'sculomd.id_scuxxmh' ),
				Field::inst( 'sculomd.id_gctxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'sculomd.id_gpvxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'sculomd.kode' ),
				Field::inst( 'sculomd.nama' ),
				Field::inst( 'sculomd.keterangan' ),
				Field::inst( 'sculomd.created_by' ),
				Field::inst( 'sculomd.transaction_state' ),
				Field::inst( 'sculomd.approval_state' ),
				Field::inst( 'sculomd.start_at' ),
				Field::inst( 'sculomd.finish_at' ),
				Field::inst( 'sculomd.is_defaultprogram' ),
				Field::inst( 'sculomd.alamat' ),
				Field::inst( 'gctxxmh.nama' ),
				Field::inst( 'gpvxxmh.nama' )
			)
			->leftJoin( 'gctxxmh','gctxxmh.id','=','sculomd.id_gctxxmh' )
			->leftJoin( 'gpvxxmh','gpvxxmh.id','=','sculomd.id_gpvxxmh' )
			->where('sculomd.id_scuxxmh',$_POST['id_scuxxmh'])
			;
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_sculomd'] == 0){
			$editor
				->where( 'sculomd.transaction_state', -9, '<>');
		}
		
		include( "sculomd_extra.php" );

		// BEGIN log
		$nama_table = 'sculomd';
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