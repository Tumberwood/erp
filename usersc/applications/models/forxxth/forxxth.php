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
	
	$editor = Editor::inst( $db, 'forxxth' )
		->debug(true)
		->fields(
			Field::inst( 'forxxth.id' ),
			Field::inst( 'forxxth.id_aakxxmh' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'forxxth.kode' )
				->setFormatter( function ( $val ) {
					return strtoupper($val);
				} ),
			Field::inst( 'forxxth.nama' )
				->setFormatter( function ( $val ) {
					return ucwords($val);
				} ),
			Field::inst( 'forxxth.keterangan' ),
			Field::inst( 'forxxth.created_by' ),
			Field::inst( 'forxxth.transaction_state' ),
			Field::inst( 'forxxth.approval_state' ),
			Field::inst( 'forxxth.start_at' ),
			Field::inst( 'forxxth.finish_at' ),
			Field::inst( 'forxxth.is_defaultprogram' ),

			Field::inst( 'forxxth.tanggal' )
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
			Field::inst( 'forxxth.amount' ),

			Field::inst( 'aakxxmh.kode' ),
			Field::inst( 'aakxxmh.nama' )
		)
		->leftJoin( 'aakxxmh','aakxxmh.id','=','forxxth.id_aakxxmh' );
	
	// do not erase
	// function show / hide inactive document
	if ( $_POST['show_deleted_forxxth'] == 0){
		$editor
			->where( 'forxxth.transaction_state', -9, '<>');
	}
	
	include( "forxxth_extra.php" );

	// BEGIN log
	$nama_table = 'forxxth';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>