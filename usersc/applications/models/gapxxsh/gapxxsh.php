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
	
	$editor = Editor::inst( $db, 'gapxxsh' )
		->debug(true)
		->fields(
			Field::inst( 'gapxxsh.id' ),
			Field::inst( 'gapxxsh.id_gtbrlsh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'gapxxsh.id_gaptpmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'gapxxsh.id_gtbrlsh_group' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'gapxxsh.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'gapxxsh.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'gapxxsh.keterangan' ),
			Field::inst( 'gapxxsh.created_by' ),
			Field::inst( 'gapxxsh.transaction_state' ),
			Field::inst( 'gapxxsh.approval_state' ),
			Field::inst( 'gapxxsh.start_at' ),
			Field::inst( 'gapxxsh.finish_at' ),
			Field::inst( 'gapxxsh.is_defaultprogram' ),
			Field::inst( 'gapxxsh.jumlah_level' ),

			Field::inst( 'gtbrlsh.nama' ),
			Field::inst( 'gtbrlsh.tblheader' ),
			Field::inst( 'gaptpmh.nama' ),
			Field::inst( 'gtbrlsh_grup.nama' )
		)
		->leftJoin( 'gtbrlsh','gtbrlsh.id','=','gapxxsh.id_gtbrlsh' )
		->leftJoin( 'gaptpmh','gaptpmh.id','=','gapxxsh.id_gaptpmh' )
		->leftJoin( 'gtbrlsh as gtbrlsh_grup','gtbrlsh_grup.id','=','gapxxsh.id_gtbrlsh_group' );
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_gapxxsh'] == 0){
		$editor
			->where( 'gapxxsh.transaction_state', -9, '<>');
	}
	
	include( "gapxxsh_extra.php" );

	// BEGIN log
	$nama_table = 'gapxxsh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>