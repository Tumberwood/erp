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
	
	if ( ! isset($_POST['id_psuxxmh']) || ! is_numeric($_POST['id_psuxxmh']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'psucttd' )
			->debug(true)
			->fields(
				Field::inst( 'psucttd.id' ),
				Field::inst( 'psucttd.id_psuxxmh' ),
				Field::inst( 'psucttd.kode' ),
				Field::inst( 'psucttd.nama' ),
				Field::inst( 'psucttd.keterangan' ),
				Field::inst( 'psucttd.created_by' ),
				Field::inst( 'psucttd.transaction_state' ),
				Field::inst( 'psucttd.approval_state' ),
				Field::inst( 'psucttd.start_at' ),
				Field::inst( 'psucttd.finish_at' ),
				Field::inst( 'psucttd.is_defaultprogram' ),
				Field::inst( 'psucttd.email' ),
				Field::inst( 'psucttd.posisi' ),
				Field::inst( 'psucttd.handphone' )
			)
			->where('psucttd.id_psuxxmh',$_POST['id_psuxxmh'])
			;
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_psucttd'] == 0){
			$editor
				->where( 'psucttd.transaction_state', -9, '<>');
		}
		
		include( "psucttd_extra.php" );

		// BEGIN log
		$nama_table = 'psucttd';
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