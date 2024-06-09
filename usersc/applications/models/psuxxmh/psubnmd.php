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
		$editor = Editor::inst( $db, 'grlbnmd' )
			->debug(true)
			->fields(
				Field::inst( 'grlbnmd.id' ),
				Field::inst( 'grlbnmd.id_grlxxmh' ),
				Field::inst( 'grlbnmd.id_fbnxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'grlbnmd.kode' ),
				Field::inst( 'grlbnmd.nama' ),
				Field::inst( 'grlbnmd.keterangan' ),
				Field::inst( 'grlbnmd.created_by' ),
				Field::inst( 'grlbnmd.transaction_state' ),
				Field::inst( 'grlbnmd.approval_state' ),
				Field::inst( 'grlbnmd.start_at' ),
				Field::inst( 'grlbnmd.finish_at' ),
				Field::inst( 'grlbnmd.is_defaultprogram' ),
				Field::inst( 'grlbnmd.is_default' ),
				Field::inst( 'grlbnmd.no_rek' ),
				Field::inst( 'fbnxxmh.nama' )
			)
			->leftJoin( 'fbnxxmh','fbnxxmh.id','=','grlbnmd.id_fbnxxmh' )
			->where('grlbnmd.id_grlxxmh',$_POST['id_grlxxmh']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_grlbnmd'] == 0){
			$editor
				->where( 'grlbnmd.transaction_state', -9, '<>');
		}
		
		include( "psubnmd_extra.php" );

		// BEGIN log
		$nama_table = 'grlbnmd';
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