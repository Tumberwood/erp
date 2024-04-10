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
	
	if ( ! isset($_POST['id_ljoxxth']) || ! is_numeric($_POST['id_ljoxxth']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'ljodstd' )
			->debug(true)
			->fields(
				Field::inst( 'ljodstd.id' ),
				Field::inst( 'ljodstd.id_ljoxxth' ),
				Field::inst( 'ljodstd.id_grlxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'ljodstd.kode' ),
				Field::inst( 'ljodstd.nama' ),
				Field::inst( 'ljodstd.keterangan' ),
				Field::inst( 'ljodstd.created_by' ),
				Field::inst( 'ljodstd.transaction_state' ),
				Field::inst( 'ljodstd.approval_state' ),
				Field::inst( 'ljodstd.start_at' ),
				Field::inst( 'ljodstd.finish_at' ),
				Field::inst( 'ljodstd.is_defaultprogram' ),
				Field::inst( 'ljodstd.urutan' ),

				Field::inst( 'grlxxmh.nama' )
			)
			->leftJoin( 'grlxxmh','grlxxmh.id','=','ljodstd.id_grlxxmh' )
			->where('ljodstd.id_ljoxxth',$_POST['id_ljoxxth']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_ljodstd'] == 0){
			$editor
				->where( 'ljodstd.transaction_state', -9, '<>');
		}
		
		include( "ljodstd_extra.php" );

		// BEGIN log
		$nama_table = 'ljodstd';
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