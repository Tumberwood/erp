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
	
	$editor = Editor::inst( $db, 'hpyoptd' )
		->debug(true)
		->fields(
			Field::inst( 'hpyoptd.id' ),
			Field::inst( 'hpyoptd.id_hemxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'hpyoptd.id_hpcxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'hpyoptd.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'hpyoptd.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'hpyoptd.keterangan' ),
			Field::inst( 'hpyoptd.created_by' ),
			Field::inst( 'hpyoptd.transaction_state' ),
			Field::inst( 'hpyoptd.approval_state' ),
			Field::inst( 'hpyoptd.start_at' ),
			Field::inst( 'hpyoptd.finish_at' ),
			Field::inst( 'hpyoptd.is_defaultprogram' ),
			Field::inst( 'hpyoptd.is_nextprocess' ),
			Field::inst( 'hpyoptd.nominal' ),
			Field::inst( 'hpyoptd.tanggal' )
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
			Field::inst( 'concat(hemxxmh.kode, " - ", hemxxmh.nama) as hemxxmh_data' )
		)
		->leftJoin( 'hemxxmh','hemxxmh.id','=','hpyoptd.id_hemxxmh' )
		->leftJoin( 'hpcxxmh','hpcxxmh.id','=','hpyoptd.id_hpcxxmh' )
		;
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_hpyoptd'] == 0){
		$editor
			->where( 'hpyoptd.transaction_state', -9, '<>');
	}
	
	include( "hpyoptd_extra.php" );

	// BEGIN log
	$nama_table = 'hpyoptd';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>