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
	
	$editor = Editor::inst( $db, 'hfaxxth' )
		->debug(true)
		->fields(
			Field::inst( 'hfaxxth.id' ),
			Field::inst( 'hfaxxth.id_hfsxxth' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'hfaxxth.id_hemxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'hfaxxth.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'hfaxxth.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'hfaxxth.keterangan' ),
			Field::inst( 'hfaxxth.created_by' ),
			Field::inst( 'hfaxxth.transaction_state' ),
			Field::inst( 'hfaxxth.approval_state' ),
			Field::inst( 'hfaxxth.start_at' ),
			Field::inst( 'hfaxxth.finish_at' ),
			Field::inst( 'hfaxxth.is_nextprocess' ),
			Field::inst( 'hfaxxth.is_defaultprogram' ),
			Field::inst( 'hfaxxth.periode' )
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
				) )
			,
		
			Field::inst( 'hemxxmh.kode' ),
			Field::inst( 'hemxxmh.nama' ),
			Field::inst( 'hovxxmh.nama' ),
			Field::inst( 'hodxxmh.nama' ),
			Field::inst( 'hetxxmh.nama' ),
		)
		->leftJoin( 'hemxxmh','hemxxmh.id','=','hfaxxth.id_hemxxmh' )
		->leftJoin( 'hemjbmh','hemjbmh.id_hemxxmh','=','hemxxmh.id' )
		->leftJoin( 'hovxxmh','hovxxmh.id','=','hemjbmh.id_hovxxmh' )
		->leftJoin( 'hodxxmh','hodxxmh.id','=','hemjbmh.id_hodxxmh' )
		->leftJoin( 'hetxxmh','hetxxmh.id','=','hemjbmh.id_hetxxmh' )
		;
	
	if($_POST['start_date'] != ''){
		$editor->where( 'hfaxxth.periode',$_POST['start_date'], '>=' );
	}
	if($_POST['end_date'] != ''){
		$editor->where( 'hfaxxth.periode', $_POST['end_date'], '<=' );
	}

	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_hfaxxth'] == 0){
		$editor
			->where( 'hfaxxth.transaction_state', -9, '<>');
	}
	
	include( "hfaxxth_extra.php" );

	// BEGIN log
	$nama_table = 'hfaxxth';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>