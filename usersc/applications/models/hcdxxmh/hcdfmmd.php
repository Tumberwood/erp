<?php
	include_once( "../../../../users/init.php" );
	include_once( "../../../../usersc/lib/DataTables.php" );
	include_once( "../../../../usersc/vendor/autoload.php");
	// include_once( "../../../helpers/hakakses_s_fn.php" );
	
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
	
	if ( ! isset($_POST['id_hcdxxmh']) || ! is_numeric($_POST['id_hcdxxmh']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'hcdfmmd' )
			->debug(true)
			->fields(
				Field::inst( 'hcdfmmd.id' ),
				Field::inst( 'hcdfmmd.id_hcdxxmh' ),
				Field::inst( 'hcdfmmd.id_hedlvmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'hcdfmmd.id_gctxxmh_lahir' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'hcdfmmd.kode' ),
				Field::inst( 'hcdfmmd.nama' ),
				Field::inst( 'hcdfmmd.keterangan' ),
				Field::inst( 'hcdfmmd.created_by' ),
				Field::inst( 'hcdfmmd.transaction_state' ),
				Field::inst( 'hcdfmmd.approval_state' ),
				Field::inst( 'hcdfmmd.start_at' ),
				Field::inst( 'hcdfmmd.finish_at' ),
				Field::inst( 'hcdfmmd.is_defaultprogram' ),
				Field::inst( 'hcdfmmd.tanggal_lahir' )
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
				Field::inst( 'hcdfmmd.gender' ),
				Field::inst( 'hcdfmmd.hubungan' ),
				Field::inst( 'hcdfmmd.pekerjaan' ),

				Field::inst( 'hedlvmh.nama' ),
				Field::inst( 'gctxxmh.nama' )
			)
			->leftJoin( 'hedlvmh','hedlvmh.id','=','hcdfmmd.id_hedlvmh' )
			->leftJoin( 'gctxxmh','gctxxmh.id','=','hcdfmmd.id_gctxxmh_lahir' )
			->where('hcdfmmd.id_hcdxxmh',$_POST['id_hcdxxmh']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_hcdfmmd'] == 0){
			$editor
				->where( 'hcdfmmd.transaction_state', -9, '<>');
		}
		
		// include( "hcdfmmd_extra.php" );

		// BEGIN log
		// $nama_table = 'hcdfmmd';
		// include( "../../../helpers/edt_log.php" );
		// END log
		
		$json = $editor
			->process( $_POST )
			->data();

		// debugging hak akses
		// $json['hakakses'] = $hakakses;

		echo json_encode( $json );

	}
?>