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
	
	if ( ! isset($_POST['id_hemxxmh']) || ! is_numeric($_POST['id_hemxxmh']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'hemjbmh' )
			->debug(true)
			->fields(
				Field::inst( 'hemjbmh.id' ),
				Field::inst( 'hemjbmh.id_hemxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'hemjbmh.id_users' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'hemjbmh.id_gbrxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'hemjbmh.id_hovxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'hemjbmh.id_hodxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'hemjbmh.kode' ),
				Field::inst( 'hemjbmh.nama' ),
				Field::inst( 'hemjbmh.keterangan' ),
				Field::inst( 'hemjbmh.created_by' ),
				Field::inst( 'hemjbmh.transaction_state' ),
				Field::inst( 'hemjbmh.approval_state' ),
				Field::inst( 'hemjbmh.start_at' ),
				Field::inst( 'hemjbmh.finish_at' ),
				Field::inst( 'hemjbmh.is_defaultprogram' ),

				Field::inst( 'gbrxxmh.nama' ),
				Field::inst( 'hovxxmh.nama' ),
				Field::inst( 'hodxxmh.nama' )
			)
			->leftJoin( 'users','users.id','=','hemjbmh.id_users' )
			->leftJoin( 'gbrxxmh','gbrxxmh.id','=','hemjbmh.id_gbrxxmh' )
			->leftJoin( 'hovxxmh','hovxxmh.id','=','hemjbmh.id_hovxxmh' )
			->leftJoin( 'hodxxmh','hodxxmh.id','=','hemjbmh.id_hodxxmh' )
			->where('hemjbmh.id_hemxxmh',$_POST['id_hemxxmh']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_hemjbmh'] == 0){
			$editor
				->where( 'hemjbmh.transaction_state', -9, '<>');
		}
		
		include( "hemjbmh_extra.php" );

		// BEGIN log
		$nama_table = 'hemjbmh';
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