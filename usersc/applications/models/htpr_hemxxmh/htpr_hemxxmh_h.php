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
	
	$editor = Editor::inst( $db, 'hemxxmh' )
		->debug(true)
		->fields(
			Field::inst( 'hemxxmh.id' ),
			Field::inst( 'hemxxmh.kode' ),
			Field::inst( 'hemxxmh.nama' ),
			
			Field::inst( 'concat(hemxxmh.kode," - ",hemxxmh.nama) as hemxxmh_data' ),
			Field::inst( 'hemxxmh.keterangan' ),
			Field::inst( 'hemxxmh.created_by' ),
			Field::inst( 'hemxxmh.transaction_state' ),
			Field::inst( 'hemxxmh.approval_state' ),
			Field::inst( 'hemxxmh.start_at' ),
			Field::inst( 'hemxxmh.finish_at' ),
			Field::inst( 'hemxxmh.is_defaultprogram' ),

			Field::inst( 'hodxxmh.nama' ),
			Field::inst( 'hosxxmh.nama' ),
			Field::inst( 'hevxxmh.nama' ),
			Field::inst( 'hetxxmh.nama' )
		)
		->leftJoin( 'hemjbmh','hemjbmh.id_hemxxmh','=','hemxxmh.id' )
		->leftJoin( 'hodxxmh','hodxxmh.id','=','hemjbmh.id_hodxxmh' )
		->leftJoin( 'hosxxmh','hosxxmh.id','=','hemjbmh.id_hosxxmh' )
		->leftJoin( 'hevxxmh','hevxxmh.id','=','hemjbmh.id_hevxxmh' )
		->leftJoin( 'hetxxmh','hetxxmh.id','=','hemjbmh.id_hetxxmh' );
		;
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_hemxxmh'] == 0){
		$editor
			->where( 'hemxxmh.transaction_state', -9, '<>');
	}
	
	// include( "hemxxmh_extra.php" );

	// BEGIN log
	$nama_table = 'hemxxmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>