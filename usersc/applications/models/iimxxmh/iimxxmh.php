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
	
	$editor = Editor::inst( $db, 'iimxxmh' )
		->debug(true)
		->fields(
			Field::inst( 'iimxxmh.id' ),
			Field::inst( 'iimxxmh.id_iittpmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'iimxxmh.id_iicctmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'iimxxmh.id_iiggrmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'iimxxmh.id_iibbrmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'iimxxmh.id_iumxxmh_content' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'iimxxmh.id_files_image' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'iimxxmh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'iimxxmh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'iimxxmh.keterangan' ),
			Field::inst( 'iimxxmh.created_by' ),
			Field::inst( 'iimxxmh.transaction_state' ),
			Field::inst( 'iimxxmh.approval_state' ),
			Field::inst( 'iimxxmh.start_at' ),
			Field::inst( 'iimxxmh.finish_at' ),
			Field::inst( 'iimxxmh.is_defaultprogram' ),

			Field::inst( 'iimxxmh.content' ),

			Field::inst( 'iittpmh.nama' ),
			Field::inst( 'iicctmh.nama' ),
			Field::inst( 'iiggrmh.nama' )
		)
		->leftJoin( 'iittpmh','iittpmh.id','=','iimxxmh.id_iittpmh' )
		->leftJoin( 'iicctmh','iicctmh.id','=','iimxxmh.id_iicctmh' )
		->leftJoin( 'iiggrmh','iiggrmh.id','=','iimxxmh.id_iiggrmh' )
		;
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_iimxxmh'] == 0){
		$editor
			->where( 'iimxxmh.transaction_state', -9, '<>');
	}
	
	include( "iimxxmh_extra.php" );

	// BEGIN log
	$nama_table = 'iimxxmh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>