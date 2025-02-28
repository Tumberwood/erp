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
	
	if ( ! isset($_POST['id_sprxxth']) || ! is_numeric($_POST['id_sprxxth']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'sprivtd' )
			->debug(true)
			->fields(
				Field::inst( 'sprivtd.id' ),
				Field::inst( 'sprivtd.id_sprxxth' ),
				Field::inst( 'sprivtd.id_sivxxth' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'sprivtd.kode' ),
				Field::inst( 'sprivtd.nama' ),
				Field::inst( 'sprivtd.keterangan' ),
				Field::inst( 'sprivtd.created_by' ),
				Field::inst( 'sprivtd.transaction_state' ),
				Field::inst( 'sprivtd.approval_state' ),
				Field::inst( 'sprivtd.start_at' ),
				Field::inst( 'sprivtd.finish_at' ),
				Field::inst( 'sprivtd.is_nextprocess' ),
				Field::inst( 'sprivtd.is_defaultprogram' ),
				Field::inst( 'sprivtd.amount' ),
				Field::inst( 'sprivtd.rencana_bayar' ),
				Field::inst( 'sprivtd.sisa' ),
				Field::inst( 'sprivtd.tanggal' )
					->getFormatter( function ( $val, $data, $opts ) {
						if ($val === '0000-00-00' || $val === null){
							echo '';
						}else{
							return date( 'd M Y', strtotime( $val ) );
						}
					} )
					->setFormatter( 'Format::datetime', array(
						'from' => 'd M Y',
						'to' =>   'Y-m-d'
					) ),
				Field::inst( 'sprivtd.tanggal_jatuh_tempo' )
					->getFormatter( function ( $val, $data, $opts ) {
						if ($val === '0000-00-00' || $val === null){
							echo '';
						}else{
							return date( 'd M Y', strtotime( $val ) );
						}
					} )
					->setFormatter( 'Format::datetime', array(
						'from' => 'd M Y',
						'to' =>   'Y-m-d'
					) ),
				Field::inst( 'sivxxth.kode' )
			)
			->leftJoin( 'sivxxth','sivxxth.id','=','sprivtd.id_sivxxth' )
			->where('sprivtd.id_sprxxth',$_POST['id_sprxxth'])
			;
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_sprivtd'] == 0){
			$editor
				->where( 'sprivtd.transaction_state', -9, '<>');
		}
		
		include( "sprivtd_extra.php" );

		// BEGIN log
		$nama_table = 'sprivtd';
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