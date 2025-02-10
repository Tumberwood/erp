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
	
	if ( ! isset($_POST['id_fpmxxth']) || ! is_numeric($_POST['id_fpmxxth']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'fpmivtd' )
			->debug(true)
			->fields(
				Field::inst( 'fpmivtd.id' ),
				Field::inst( 'fpmivtd.id_fpmxxth' ),
				Field::inst( 'fpmivtd.id_pivxxth' )
				->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'fpmivtd.id_fprivtd' )
				->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'fpmivtd.kode' ),
				Field::inst( 'fpmivtd.nama' ),
				Field::inst( 'fpmivtd.keterangan' ),
				Field::inst( 'fpmivtd.created_by' ),
				Field::inst( 'fpmivtd.transaction_state' ),
				Field::inst( 'fpmivtd.approval_state' ),
				Field::inst( 'fpmivtd.start_at' ),
				Field::inst( 'fpmivtd.finish_at' ),
				Field::inst( 'fpmivtd.is_nextprocess' ),
				Field::inst( 'fpmivtd.is_defaultprogram' ),
				Field::inst( 'fpmivtd.amount' ),
				Field::inst( 'fpmivtd.rencana_bayar' ),
				Field::inst( 'fpmivtd.sisa' ),
				Field::inst( 'fpmivtd.tanggal' )
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
				Field::inst( 'fpmivtd.tanggal_jatuh_tempo' )
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
				Field::inst( 'pivxxth.kode' )
			)
			->leftJoin( 'pivxxth','pivxxth.id','=','fpmivtd.id_pivxxth' )
			->where('fpmivtd.id_fpmxxth',$_POST['id_fpmxxth'])
			;
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_fpmivtd'] == 0){
			$editor
				->where( 'fpmivtd.transaction_state', -9, '<>');
		}
		
		include( "fpmivtd_extra.php" );

		// BEGIN log
		$nama_table = 'fpmivtd';
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