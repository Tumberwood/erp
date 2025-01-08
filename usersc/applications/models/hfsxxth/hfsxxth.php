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
	
	$editor = Editor::inst( $db, 'hfsxxth' )
		->debug(true)
		->fields(
			Field::inst( 'hfsxxth.id' ),
			Field::inst( 'hfsxxth.id_hfkxxth' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'hfsxxth.id_hemxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'hfsxxth.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'hfsxxth.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'hfsxxth.keterangan' ),
			Field::inst( 'hfsxxth.created_by' ),
			Field::inst( 'hfsxxth.transaction_state' ),
			Field::inst( 'hfsxxth.approval_state' ),
			Field::inst( 'hfsxxth.start_at' ),
			Field::inst( 'hfsxxth.finish_at' ),
			Field::inst( 'hfsxxth.is_nextprocess' ),
			Field::inst( 'hfsxxth.is_defaultprogram' ),
			Field::inst( 'hfsxxth.periode' )
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
		->leftJoin( 'hemxxmh','hemxxmh.id','=','hfsxxth.id_hemxxmh' )
		->leftJoin( 'hemjbmh','hemjbmh.id_hemxxmh','=','hemxxmh.id' )
		->leftJoin( 'hovxxmh','hovxxmh.id','=','hemjbmh.id_hovxxmh' )
		->leftJoin( 'hodxxmh','hodxxmh.id','=','hemjbmh.id_hodxxmh' )
		->leftJoin( 'hetxxmh','hetxxmh.id','=','hemjbmh.id_hetxxmh' )
		;
	
	if($_POST['start_date'] != ''){
		$editor->where( 'hfsxxth.periode',$_POST['start_date'], '>=' );
	}
	if($_POST['end_date'] != ''){
		$editor->where( 'hfsxxth.periode', $_POST['end_date'], '<=' );
	}

	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_hfsxxth'] == 0){
		$editor
			->where( 'hfsxxth.transaction_state', -9, '<>');
	}
	
	include( "hfsxxth_extra.php" );

	// BEGIN log
	$nama_table = 'hfsxxth';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>