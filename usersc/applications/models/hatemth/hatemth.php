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
	
	$editor = Editor::inst( $db, 'hatemth' )
		->debug(true)
		->fields(
			Field::inst( 'hatemth.id' ),
			Field::inst( 'hatemth.id_hemxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'hatemth.id_hattpmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'hatemth.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'hatemth.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'hatemth.keterangan' ),
			Field::inst( 'hatemth.created_by' ),
			Field::inst( 'hatemth.transaction_state' ),
			Field::inst( 'hatemth.approval_state' ),
			Field::inst( 'hatemth.start_at' ),
			Field::inst( 'hatemth.finish_at' ),
			Field::inst( 'hatemth.is_nextprocess' ),
			Field::inst( 'hatemth.is_defaultprogram' ),

			Field::inst( 'hatemth.alasan' ),
			Field::inst( 'hatemth.tanggal' )
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
			Field::inst( 'hemxxmh.nama' ),
			Field::inst( 'hattpmh.nama' ),
		)
		->leftJoin( 'hemxxmh','hemxxmh.id','=','hatemth.id_hemxxmh' )
		->leftJoin( 'hattpmh','hattpmh.id','=','hatemth.id_hattpmh' )
		;
	
	if($_POST['start_date'] != ''){
		$editor->where( 'hatemth.tanggal',$_POST['start_date'], '>=' );
	}
	if($_POST['end_date'] != ''){
		$editor->where( 'hatemth.tanggal', $_POST['end_date'], '<=' );
	}

	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_hatemth'] == 0){
		$editor
			->where( 'hatemth.transaction_state', -9, '<>');
	}
	
	include( "hatemth_extra.php" );

	// BEGIN log
	$nama_table = 'hatemth';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>