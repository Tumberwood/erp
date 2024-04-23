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
		$editor = Editor::inst( $db, 'hemfmmd' )
			->debug(true)
			->fields(
				Field::inst( 'hemfmmd.id' ),
				Field::inst( 'hemfmmd.id_hemxxmh' ),
				Field::inst( 'hemfmmd.id_hedlvmh' ),
				Field::inst( 'hemfmmd.kode' ),
				Field::inst( 'hemfmmd.nama' ),
				Field::inst( 'hemfmmd.keterangan' ),
				Field::inst( 'hemfmmd.created_by' ),
				Field::inst( 'hemfmmd.transaction_state' ),
				Field::inst( 'hemfmmd.approval_state' ),
				Field::inst( 'hemfmmd.start_at' ),
				Field::inst( 'hemfmmd.finish_at' ),
				Field::inst( 'hemfmmd.is_defaultprogram' ),
				Field::inst( 'hemfmmd.is_default' ),
				Field::inst( 'hemfmmd.tanggal_lahir' )
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
				Field::inst( 'hemfmmd.hubungan' ),
				Field::inst( 'hemfmmd.gender' ),
				Field::inst( 'hemfmmd.pekerjaan' ),

				Field::inst( 'hedlvmh.nama' )
			)
			->leftJoin( 'hedlvmh','hedlvmh.id','=','hemfmmd.id_hedlvmh' )
			->where('hemfmmd.id_hemxxmh',$_POST['id_hemxxmh']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_hemfmmd'] == 0){
			$editor
				->where( 'hemfmmd.transaction_state', -9, '<>');
		}
		
		include( "hemfmmd_extra.php" );

		// BEGIN log
		$nama_table = 'hemfmmd';
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