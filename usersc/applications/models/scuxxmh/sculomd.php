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
	
	if ( ! isset($_POST['id_grlxxmh']) || ! is_numeric($_POST['id_grlxxmh']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'grllomd' )
			->debug(true)
			->fields(
				Field::inst( 'grllomd.id' ),
				Field::inst( 'grllomd.id_grlxxmh' ),
				Field::inst( 'grllomd.id_gctxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'grllomd.id_gpvxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'grllomd.kode' ),
				Field::inst( 'grllomd.nama' ),
				Field::inst( 'grllomd.keterangan' ),
				Field::inst( 'grllomd.created_by' ),
				Field::inst( 'grllomd.transaction_state' ),
				Field::inst( 'grllomd.approval_state' ),
				Field::inst( 'grllomd.start_at' ),
				Field::inst( 'grllomd.finish_at' ),
				Field::inst( 'grllomd.is_defaultprogram' ),
				Field::inst( 'grllomd.alamat' ),
				Field::inst( 'gctxxmh.nama' ),
				Field::inst( 'gpvxxmh.nama' )
			)
			->leftJoin( 'gctxxmh','gctxxmh.id','=','grllomd.id_gctxxmh' )
			->leftJoin( 'gpvxxmh','gpvxxmh.id','=','grllomd.id_gpvxxmh' )
			->where('grllomd.id_grlxxmh',$_POST['id_grlxxmh'])
			;
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_grllomd'] == 0){
			$editor
				->where( 'grllomd.transaction_state', -9, '<>');
		}
		
		include( "sculomd_extra.php" );

		// BEGIN log
		$nama_table = 'grllomd';
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