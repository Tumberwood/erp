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
	
	$editor = Editor::inst( $db, 'htlgntd' )
		->debug(true)
		->fields(
			Field::inst( 'htlgntd.id' ),
			Field::inst( 'htlgntd.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'htlgntd.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'htlgntd.keterangan' ),
			Field::inst( 'htlgntd.created_by' ),
			Field::inst( 'htlgntd.transaction_state' ),
			Field::inst( 'htlgntd.approval_state' ),
			Field::inst( 'htlgntd.start_at' ),
			Field::inst( 'htlgntd.finish_at' ),
			Field::inst( 'htlgntd.is_defaultprogram' ),
			Field::inst( 'htlgntd.is_nextprocess' ),

			Field::inst( 'htlgntd.tanggal' )
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
	if ( $_POST['show_deleted_htlgntd'] == 0){
		$editor
			->where( 'htlgntd.transaction_state', -9, '<>');
	}
	
	include( "htlgntd_extra.php" );

	// BEGIN log
	$nama_table = 'htlgntd';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>