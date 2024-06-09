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
	
	$editor = Editor::inst( $db, 'httphtd' )
		->debug(true)
		->fields(
			Field::inst( 'httphtd.id' ),
			Field::inst( 'httphtd.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'httphtd.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'httphtd.keterangan' ),
			Field::inst( 'httphtd.created_by' ),
			Field::inst( 'httphtd.transaction_state' ),
			Field::inst( 'httphtd.approval_state' ),
			Field::inst( 'httphtd.start_at' ),
			Field::inst( 'httphtd.finish_at' ),
			Field::inst( 'httphtd.is_defaultprogram' ),
			Field::inst( 'httphtd.is_nextprocess' ),

			Field::inst( 'httphtd.tanggal' )
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
				) )
		);
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_httphtd'] == 0){
		$editor
			->where( 'httphtd.transaction_state', -9, '<>');
	}
	
	include( "httphtd_extra.php" );

	// BEGIN log
	$nama_table = 'httphtd';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>