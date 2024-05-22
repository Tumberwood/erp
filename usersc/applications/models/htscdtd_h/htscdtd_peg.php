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
	
	if ( ! isset($_POST['id_htscdtd_h']) || ! is_numeric($_POST['id_htscdtd_h']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'htscdtd_peg' )
			->debug(true)
			->fields(
				Field::inst( 'htscdtd_peg.id' ),
				Field::inst( 'htscdtd_peg.id_htscdtd_h' ),
				Field::inst( 'htscdtd_peg.id_hemxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'htscdtd_peg.kode' ),
				Field::inst( 'htscdtd_peg.nama' ),
				Field::inst( 'htscdtd_peg.keterangan' ),
				Field::inst( 'htscdtd_peg.created_by' ),
				Field::inst( 'htscdtd_peg.transaction_state' ),
				Field::inst( 'htscdtd_peg.approval_state' ),
				Field::inst( 'htscdtd_peg.start_at' ),
				Field::inst( 'htscdtd_peg.finish_at' ),
				Field::inst( 'htscdtd_peg.is_defaultprogram' ),
				Field::inst( 'hemxxmh.nama' ),
				Field::inst( 'hemxxmh.kode' ),
				Field::inst( 'hetxxmh.nama' ),
				Field::inst( 'hodxxmh.nama' )
			)
			->where('htscdtd_peg.id_htscdtd_h',$_POST['id_htscdtd_h'])
			->leftJoin( 'hemxxmh','hemxxmh.id','=','htscdtd_peg.id_hemxxmh' )
			->leftJoin( 'hemjbmh','hemjbmh.id_hemxxmh','=','hemxxmh.id' )
			->leftJoin( 'hetxxmh','hetxxmh.id','=','hemjbmh.id_hetxxmh' )
			->leftJoin( 'hodxxmh','hodxxmh.id','=','hemjbmh.id_hodxxmh' )
			;
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_htscdtd_peg'] == 0){
			$editor
				->where( 'htscdtd_peg.transaction_state', -9, '<>');
		}
		
		include( "htscdtd_peg_extra.php" );

		// BEGIN log
		$nama_table = 'htscdtd_peg';
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