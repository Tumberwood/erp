<?php
	include_once( "../../../../users/init.php" );
	include_once( "../../../../usersc/lib/DataTables.php" );
	include_once( "../../../../usersc/vendor/autoload.php");
	include_once( "../../../helpers/hakakses_s_fn.php" );
	
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
	
	$editor = Editor::inst( $db, 'rbmxxth' )
		->debug(true)
		->fields(
			Field::inst( 'rbmxxth.id' ),
			Field::inst( 'rbmxxth.id_iimxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'rbmxxth.id_iumxxmh_unit' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'rbmxxth.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'rbmxxth.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'rbmxxth.keterangan' ),
			Field::inst( 'rbmxxth.created_by' ),
			Field::inst( 'rbmxxth.transaction_state' ),
			Field::inst( 'rbmxxth.approval_state' ),
			Field::inst( 'rbmxxth.start_at' ),
			Field::inst( 'rbmxxth.finish_at' ),
			Field::inst( 'rbmxxth.is_defaultprogram' ),
			Field::inst( 'rbmxxth.revisi_ke' ),
			Field::inst( 'rbmxxth.tanggal' )
				->getFormatter( function ( $val, $data, $opts ) {
					if ($val === '0000-00-00' || $val === null){
						return '';
					}else{
						return date( 'd M Y', strtotime( $val ) );
					}
				} )
				->setFormatter( 'Format::datetime', array(
					'from' => 'd M Y',
					'to' =>   'Y-m-d'
				) ),
			Field::inst( 'iimxxmh.kode' ),
			Field::inst( 'iimxxmh.nama' )
		)
		->leftJoin( 'iimxxmh','iimxxmh.id','=','rbmxxth.id_iimxxmh' );
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_rbmxxth'] == 0){
		$editor
			->where( 'rbmxxth.transaction_state', -9, '<>');
	}
	
	include( "rbmxxth_extra.php" );

	// BEGIN log
	$nama_table = 'rbmxxth';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>