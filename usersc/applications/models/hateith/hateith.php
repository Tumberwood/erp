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
	
	$editor = Editor::inst( $db, 'hateith' )
		->debug(true)
		->fields(
			Field::inst( 'hateith.id' ),
			Field::inst( 'hateith.id_hatemth' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'hateith.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'hateith.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'hateith.keterangan' ),
			Field::inst( 'hateith.created_by' ),
			Field::inst( 'hateith.transaction_state' ),
			Field::inst( 'hateith.approval_state' ),
			Field::inst( 'hateith.start_at' ),
			Field::inst( 'hateith.finish_at' ),
			Field::inst( 'hateith.is_nextprocess' ),
			Field::inst( 'hateith.is_defaultprogram' ),
			Field::inst( 'hateith.catatan' ),
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
			Field::inst( 'hatemth.kode' ),
			Field::inst( 'hemxxmh.nama' ),
		)
		->leftJoin( 'hatemth','hatemth.id','=','hateith.id_hatemth' )
		->leftJoin( 'hemxxmh','hemxxmh.id','=','hatemth.id_hemxxmh' )
		;
	
	if($_POST['start_date'] != ''){
		$editor->where( 'hatemth.tanggal',$_POST['start_date'], '>=' );
	}
	if($_POST['end_date'] != ''){
		$editor->where( 'hatemth.tanggal', $_POST['end_date'], '<=' );
	}

	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_hateith'] == 0){
		$editor
			->where( 'hateith.transaction_state', -9, '<>');
	}
	
	include( "hateith_extra.php" );

	// BEGIN log
	$nama_table = 'hateith';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>