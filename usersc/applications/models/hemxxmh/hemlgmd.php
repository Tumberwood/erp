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
	
	if ( ! isset($_POST['id_hemxxmh']) || ! is_numeric($_POST['id_hemxxmh']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'hemlgmd' )
			->debug(true)
			->fields(
				Field::inst( 'hemlgmd.id' ),
				Field::inst( 'hemlgmd.id_hemxxmh' ),
				Field::inst( 'hemlgmd.id_hgnlgmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'hemlgmd.kode' ),
				Field::inst( 'hemlgmd.nama' ),
				Field::inst( 'hemlgmd.keterangan' ),
				Field::inst( 'hemlgmd.created_by' ),
				Field::inst( 'hemlgmd.transaction_state' ),
				Field::inst( 'hemlgmd.approval_state' ),
				Field::inst( 'hemlgmd.start_at' ),
				Field::inst( 'hemlgmd.finish_at' ),
				Field::inst( 'hemlgmd.is_defaultprogram' ),
				Field::inst( 'hemlgmd.is_default' ),
				Field::inst( 'hemlgmd.mendengar' ),
				Field::inst( 'hemlgmd.membaca' ),
				Field::inst( 'hemlgmd.menulis' ),
				Field::inst( 'hemlgmd.percakapan' ),

				Field::inst( 'hgnlgmh.nama' ),
			)
			->leftJoin( 'hgnlgmh','hgnlgmh.id','=','hemlgmd.id_hgnlgmh' )
			->where('hemlgmd.id_hemxxmh',$_POST['id_hemxxmh']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_hemlgmd'] == 0){
			$editor
				->where( 'hemlgmd.transaction_state', -9, '<>');
		}
		
		// include( "hemlgmd_extra.php" );

		// BEGIN log
		$nama_table = 'hemlgmd';
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