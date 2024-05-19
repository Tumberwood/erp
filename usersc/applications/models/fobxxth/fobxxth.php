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
	
	$editor = Editor::inst( $db, 'fobxxth' )
		->debug(true)
		->fields(
			Field::inst( 'fobxxth.id' ),
			Field::inst( 'fobxxth.id_gbrxxmh_asal' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'fobxxth.id_gbrxxmh_tujuan' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'fobxxth.id_aakxxmh_asal' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'fobxxth.id_aakxxmh_tujuan' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'fobxxth.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'fobxxth.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'fobxxth.keterangan' ),
			Field::inst( 'fobxxth.created_by' ),
			Field::inst( 'fobxxth.transaction_state' ),
			Field::inst( 'fobxxth.approval_state' ),
			Field::inst( 'fobxxth.start_at' ),
			Field::inst( 'fobxxth.finish_at' ),
			Field::inst( 'fobxxth.is_defaultprogram' ),

			Field::inst( 'fobxxth.tanggal' )
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
			Field::inst( 'fobxxth.amount' ),

			Field::inst( 'aakxxmh_asal.nama' ),
			Field::inst( 'aakxxmh_tujuan.nama' )
		)
		->leftJoin( 'aakxxmh as aakxxmh_asal ','aakxxmh_asal.id','=','fobxxth.id_aakxxmh_asal' )
		->leftJoin( 'aakxxmh as aakxxmh_tujuan','aakxxmh_tujuan.id','=','fobxxth.id_aakxxmh_tujuan' );
	
	if (isset($_POST['rowid']) && $_POST['rowid'] > 0) {
		$rowid = $_POST['rowid'];
		$editor
			->where( 'fobxxth.id', $rowid);
	}else{
		$editor
			->where( 'fobxxth.tanggal', $_POST['start_date'], '>=' )
			->where( 'fobxxth.tanggal', $_POST['end_date'], '<=' );
	}

	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_fobxxth'] == 0){
		$editor
			->where( 'fobxxth.transaction_state', -9, '<>');
	}
	
	include( "fobxxth_extra.php" );

	// BEGIN log
	$nama_table = 'fobxxth';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>