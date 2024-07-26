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
	
	$editor = Editor::inst( $db, 'fopxxth' )
		->debug(true)
		->fields(
			Field::inst( 'fopxxth.id' ),
			Field::inst( 'fopxxth.id_aakxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'fopxxth.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'fopxxth.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'fopxxth.keterangan' ),
			Field::inst( 'fopxxth.created_by' ),
			Field::inst( 'fopxxth.transaction_state' ),
			Field::inst( 'fopxxth.approval_state' ),
			Field::inst( 'fopxxth.start_at' ),
			Field::inst( 'fopxxth.finish_at' ),
			Field::inst( 'fopxxth.is_nextprocess' ),
			Field::inst( 'fopxxth.is_defaultprogram' ),

			Field::inst( 'fopxxth.tanggal' )
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
			Field::inst( 'fopxxth.amount' ),

			Field::inst( 'aakxxmh.kode' ),
			Field::inst( 'aakxxmh.nama' )
		)
		->leftJoin( 'aakxxmh','aakxxmh.id','=','fopxxth.id_aakxxmh' );

	if (isset($_POST['rowid']) && $_POST['rowid'] > 0) {
		$rowid = $_POST['rowid'];
		$editor
			->where( 'fopxxth.id', $rowid);
	}else{
		$editor
			->where( 'fopxxth.tanggal', $_POST['start_date'], '>=' )
			->where( 'fopxxth.tanggal', $_POST['end_date'], '<=' );
	}
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_fopxxth'] == 0){
		$editor
			->where( 'fopxxth.transaction_state', -9, '<>');
	}
	
	include( "fopxxth_extra.php" );

	// BEGIN log
	$nama_table = 'fopxxth';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>