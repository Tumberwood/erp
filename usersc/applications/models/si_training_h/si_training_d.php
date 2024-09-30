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
	
	if ( ! isset($_POST['id_si_training_h']) || ! is_numeric($_POST['id_si_training_h']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'si_training_d' )
			->debug(true)
			->fields(
				Field::inst( 'si_training_d.id' ),
				Field::inst( 'si_training_d.id_si_training_h' ),
				Field::inst( 'si_training_d.id_si_training_peserta_m' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'si_training_d.kode' ),
				Field::inst( 'si_training_d.nama' ),
				Field::inst( 'si_training_d.keterangan' ),
				Field::inst( 'si_training_d.created_by' ),
				Field::inst( 'si_training_d.transaction_state' ),
				Field::inst( 'si_training_d.approval_state' ),
				Field::inst( 'si_training_d.start_at' ),
				Field::inst( 'si_training_d.finish_at' ),
				Field::inst( 'si_training_d.is_nextprocess' ),
				Field::inst( 'si_training_d.is_defaultprogram' ),

				Field::inst( 'si_training_peserta_m.nama' ),
				Field::inst( 'si_training_peserta_m.no_wa' ),
			)
			->leftJoin( 'si_training_peserta_m','si_training_peserta_m.id','=','si_training_d.id_si_training_peserta_m' )
			->where('si_training_d.id_si_training_h',$_POST['id_si_training_h']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_si_training_d'] == 0){
			$editor
				->where( 'si_training_d.transaction_state', -9, '<>');
		}
		
		include( "si_training_d_extra.php" );

		// BEGIN log
		$nama_table = 'si_training_d';
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