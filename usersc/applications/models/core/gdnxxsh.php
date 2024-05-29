<?php
	include( "../../../../users/init.php" );
	include( "../../../../usersc/lib/DataTables.php" );
	include_once( "../../../../usersc/vendor/autoload.php");
	include( "../../../helpers/hakakses_s_fn.php" );
	
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
		$dt = new Carbon();
	
	$editor = Editor::inst( $db, 'gdnxxsh' )
		->debug(true)
		->fields(
			Field::inst( 'gdnxxsh.id' ),
			Field::inst( 'gdnxxsh.nama' ),
			Field::inst( 'gdnxxsh.keterangan' )
				->setFormatter( function ( $val, $data, $opts ) {
					return implode(', ', $val);
				}),
			Field::inst( 'gdnxxsh.created_by' ),
			Field::inst( 'gdnxxsh.transaction_state' ),
			Field::inst( 'gdnxxsh.approval_state' ),
			Field::inst( 'gdnxxsh.start_at' ),
			Field::inst( 'gdnxxsh.finish_at' ),
			Field::inst( 'gdnxxsh.is_defaultprogram' ),
			Field::inst( 'gdnxxsh.mode' )
				->searchPaneOptions( SearchPaneOptions::inst()),
			Field::inst( 'gdnxxsh.nama_tabel' )
				->setFormatter( Format::ifEmpty( 0 ) )
				->options( Options::inst()
					->table( 'v_tablelist' )
					->value( 'id' )
					->label( 'nama' )
				),
			Field::inst( 'gdnxxsh.kategori_dokumen' ),
			Field::inst( 'gdnxxsh.kategori_dokumen_value' ),
			Field::inst( 'gdnxxsh.prefix' ),
			Field::inst( 'gdnxxsh.suffix' ),
			Field::inst( 'gdnxxsh.total_digit' ),
			Field::inst( 'gdnxxsh.reset_by' )
				->searchPaneOptions( SearchPaneOptions::inst()),
			Field::inst( 'gdnxxsh.separator' ),
			Field::inst( 'gdnxxsh.by_company' ),
			Field::inst( 'gdnxxsh.by_cabang' ),
			Field::inst( 'gdnxxsh.field_tanggal' ),
			Field::inst( 'gdnxxsh.field_kode' ),

			Field::inst( 'v_tablelist.nama' )
			
		)
		->leftJoin( 'v_tablelist','v_tablelist.id','=','gdnxxsh.nama_tabel' );
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_gdnxxsh'] == 0){
		$editor
			->where( 'gdnxxsh.transaction_state', -9, '<>');
	}
	
	// include( "gdnxxsh_extra.php" );

	// BEGIN log
	$nama_table = 'gdnxxsh';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>