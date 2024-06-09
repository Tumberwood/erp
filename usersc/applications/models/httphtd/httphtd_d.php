<?php
	include_once( "../../../../users/init.php" );
	include_once( "../../../../usersc/lib/DataTables.php" );
	include_once( "../../../../usersc/vendor/autoload.php");
	include_once( "../../../helpers/hakakses_s_fn.php" );
	include_once( "../../../helpers/SolusiIndonesiaUtilities.php" );
	include_once( "../../../helpers/fn_is_nextprocess.php" );
	include_once( "../../../helpers/fn_is_default_update_d.php" );
	
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
	
	if ( ! isset($_POST['id_httphtd']) || ! is_numeric($_POST['id_httphtd']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'httphtd_d' )
			->debug(true)
			->fields(
				Field::inst( 'httphtd_d.id' ),
				Field::inst( 'httphtd_d.id_httphtd' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'httphtd_d.id_transaksi' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'httphtd_d.kode' ),
				Field::inst( 'httphtd_d.nama' ),
				Field::inst( 'httphtd_d.keterangan' ),
				Field::inst( 'httphtd_d.created_by' ),
				Field::inst( 'httphtd_d.transaction_state' ),
				Field::inst( 'httphtd_d.approval_state' ),
				Field::inst( 'httphtd_d.start_at' ),
				Field::inst( 'httphtd_d.finish_at' ),
				Field::inst( 'httphtd_d.is_defaultprogram' ),
				Field::inst( 'httphtd_d.is_nextprocess' ),
				Field::inst( 'httphtd_d.is_default' ),
				Field::inst( 'httphtd_d.jenis' ),
				Field::inst( 'httphtd_d.nama_tabel' ),
			)
			// ->leftJoin( 'iumxxmh','iumxxmh.id','=','httphtd_d.id_transaksi' )
			->where('httphtd_d.id_httphtd',$_POST['id_httphtd']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_httphtd_d'] == 0){
			$editor
				->where( 'httphtd_d.transaction_state', -9, '<>');
		}
		
		include( "httphtd_d_extra.php" );

		// BEGIN log
		$nama_table = 'httphtd_d';
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