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
	
	if ( ! isset($_POST['id_hemxxmh']) || ! is_numeric($_POST['id_hemxxmh']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'hesxxtd' )
			->debug(true)
			->fields(
				Field::inst( 'hesxxtd.id' ),
				Field::inst( 'hesxxtd.id_hemxxmh' ),
				Field::inst( 'hesxxtd.id_hesxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'hesxxtd.kode' ),
				Field::inst( 'hesxxtd.nama' ),
				Field::inst( 'hesxxtd.keterangan' ),
				Field::inst( 'hesxxtd.created_by' ),
				Field::inst( 'hesxxtd.transaction_state' ),
				Field::inst( 'hesxxtd.approval_state' ),
				Field::inst( 'hesxxtd.start_at' ),
				Field::inst( 'hesxxtd.finish_at' ),
				Field::inst( 'hesxxtd.is_defaultprogram' ),
				Field::inst( 'hesxxtd.is_default' ),
				
				Field::inst( 'hesxxtd.tanggal_awal' )
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
				Field::inst( 'hesxxtd.tanggal_akhir' )
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
				Field::inst( 'hesxxmh.nama' )
			)
			->leftJoin( 'hesxxmh','hesxxmh.id','=','hesxxtd.id_hesxxmh' )
			->where('hesxxtd.id_hemxxmh',$_POST['id_hemxxmh']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_hesxxtd'] == 0){
			$editor
				->where( 'hesxxtd.transaction_state', -9, '<>');
		}
		

		// BEGIN log
		$nama_table = 'hesxxtd';
		include( "../../../helpers/edt_log.php" );
		// END log
		
		$json = $editor
			->process( $_POST )
			->data();

		// debugging hak akses
		$json['hakakses'] = $hakakses;

		echo json_encode( $json );

	}
?>