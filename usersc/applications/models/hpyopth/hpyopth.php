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
	
	$editor = Editor::inst( $db, 'hpyopth' )
		->debug(true)
		->fields(
			Field::inst( 'hpyopth.id' ),
			Field::inst( 'hpyopth.id_hemxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'hpyopth.id_hpcxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'hpyopth.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'hpyopth.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'hpyopth.keterangan' ),
			Field::inst( 'hpyopth.created_by' ),
			Field::inst( 'hpyopth.transaction_state' ),
			Field::inst( 'hpyopth.approval_state' ),
			Field::inst( 'hpyopth.start_at' ),
			Field::inst( 'hpyopth.finish_at' ),
			Field::inst( 'hpyopth.is_defaultprogram' ),
			Field::inst( 'hpyopth.is_nextprocess' ),
			Field::inst( 'hpyopth.nominal' ),
			Field::inst( 'hpyopth.tenor' ),
			Field::inst( 'hpyopth.cicilan_per_bulan' ),
			Field::inst( 'hpyopth.cicilan_terakhir' ),
			Field::inst( 'hpyopth.tanggal_mulai' )
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
			Field::inst( 'hpcxxmh.nama' ),
			Field::inst( 'hpyopth.tanggal_akhir' )
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

			Field::inst( 'concat(hemxxmh.kode, " - ", hemxxmh.nama) as hemxxmh_data' )
		)
		->leftJoin( 'hemxxmh','hemxxmh.id','=','hpyopth.id_hemxxmh' )
		->leftJoin( 'hpcxxmh','hpcxxmh.id','=','hpyopth.id_hpcxxmh' )
		;
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_hpyopth'] == 0){
		$editor
			->where( 'hpyopth.transaction_state', -9, '<>');
	}
	
	include( "hpyopth_extra.php" );

	// BEGIN log
	$nama_table = 'hpyopth';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>