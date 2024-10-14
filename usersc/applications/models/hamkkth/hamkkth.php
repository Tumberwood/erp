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
	
	$editor = Editor::inst( $db, 'hamkkth' )
		->debug(true)
		->fields(
			Field::inst( 'hamkkth.id' ),
			Field::inst( 'hamkkth.id_hemxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'hamkkth.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'hamkkth.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'hamkkth.keterangan' ),
			Field::inst( 'hamkkth.created_by' ),
			Field::inst( 'hamkkth.transaction_state' ),
			Field::inst( 'hamkkth.approval_state' ),
			Field::inst( 'hamkkth.start_at' ),
			Field::inst( 'hamkkth.finish_at' ),
			Field::inst( 'hamkkth.is_defaultprogram' ),
			Field::inst( 'hamkkth.is_nextprocess' ),
			
			Field::inst( 'hamkkth.jenis' ),
			Field::inst( 'hamkkth.tanggal_mulai' )
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
			Field::inst( 'hamkkth.tanggal_selesai' )
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
		)
		->leftJoin( 'hemxxmh','hemxxmh.id','=','hamkkth.id_hemxxmh' );
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_hamkkth'] == 0){
		$editor
			->where( 'hamkkth.transaction_state', -9, '<>');
	}
	
	include( "hamkkth_extra.php" );

	// BEGIN log
	$nama_table = 'hamkkth';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>