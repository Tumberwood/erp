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
	
	if ( ! isset($_POST['id_htsptth']) || ! is_numeric($_POST['id_htsptth']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'htststd' )
			->debug(true)
			->fields(
				Field::inst( 'htststd.id' ),
				Field::inst( 'htststd.id_htsptth' ),
				Field::inst( 'htststd.id_htsxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'htststd.kode' ),
				Field::inst( 'htststd.nama' ),
				Field::inst( 'htststd.keterangan' ),
				Field::inst( 'htststd.transaction_state' ),
				Field::inst( 'htststd.approval_state' ),
				Field::inst( 'htststd.start_at' ),
				Field::inst( 'htststd.finish_at' ),
				Field::inst( 'htststd.urutan' ),
				Field::inst( 'htststd.mulai_grup' ),
				
				Field::inst( 'htsxxmh.kode' )

			)
			->leftJoin( 'htsxxmh','htsxxmh.id','=','htststd.id_htsxxmh' )
			->where('htststd.id_htsptth',$_POST['id_htsptth']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_htststd'] == 0){
			$editor
				->where( 'htststd.transaction_state', -9, '<>');
		}
		
		include( "htststd_extra.php" );

		// BEGIN log
		$nama_table = 'htststd';
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