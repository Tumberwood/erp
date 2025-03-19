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
	
	$editor = Editor::inst( $db, 'hacemtd' )
		->debug(true)
		->fields(
			Field::inst( 'hacemtd.id' ),
			Field::inst( 'hacemtd.id_hactpmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'hacemtd.id_hemxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'hacemtd.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'hacemtd.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'hacemtd.keterangan' ),
			Field::inst( 'hacemtd.created_by' ),
			Field::inst( 'hacemtd.transaction_state' ),
			Field::inst( 'hacemtd.approval_state' ),
			Field::inst( 'hacemtd.start_at' ),
			Field::inst( 'hacemtd.finish_at' ),
			Field::inst( 'hacemtd.is_defaultprogram' ),
			Field::inst( 'hacemtd.is_nextprocess' ),
			Field::inst( 'hacemtd.tanggal' )
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
			Field::inst( 'hactpmh.nama' ),
			Field::inst( 'CONCAT(hemxxmh.fname," ",hemxxmh.lname) as hemxxmh_fullname' ),
		)
		->leftJoin( 'hemxxmh','hemxxmh.id','=','hacemtd.id_hemxxmh' )
		->leftJoin( 'hactpmh','hactpmh.id','=','hacemtd.id_hactpmh' )
		;
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_hacemtd'] == 0){
		$editor
			->where( 'hacemtd.transaction_state', -9, '<>');
	}
	
	include( "hacemtd_extra.php" );

	// BEGIN log
	$nama_table = 'hacemtd';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>