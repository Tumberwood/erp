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
	
	if ( ! isset($_POST['id_hrolxth']) || ! is_numeric($_POST['id_hrolxth']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'hropctd' )
			->debug(true)
			->fields(
				Field::inst( 'hropctd.id' ),
				Field::inst( 'hropctd.id_hrolxth' ),
				Field::inst( 'hropctd.id_hpcxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'hropctd.kode' ),
				Field::inst( 'hropctd.nama' ),
				Field::inst( 'hropctd.keterangan' ),
				Field::inst( 'hropctd.created_by' ),
				Field::inst( 'hropctd.transaction_state' ),
				Field::inst( 'hropctd.approval_state' ),
				Field::inst( 'hropctd.start_at' ),
				Field::inst( 'hropctd.finish_at' ),
				Field::inst( 'hropctd.is_nextprocess' ),
				Field::inst( 'hropctd.is_defaultprogram' ),
				Field::inst( 'hropctd.nilai' ),
				Field::inst( 'hpcxxmh.nama' ),
			)
			->leftJoin( 'hpcxxmh','hpcxxmh.id','=','hropctd.id_hpcxxmh' )
			->where('hropctd.id_hrolxth',$_POST['id_hrolxth']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_hropctd'] == 0){
			$editor
				->where( 'hropctd.transaction_state', -9, '<>');
		}
		
		include( "hropctd_extra.php" );

		// BEGIN log
		$nama_table = 'hropctd';
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