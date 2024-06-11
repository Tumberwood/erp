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
	
	if ( ! isset($_POST['id_ljoxxth']) || ! is_numeric($_POST['id_ljoxxth']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'ljoprtd' )
			->debug(true)
			->fields(
				Field::inst( 'ljoprtd.id' ),
				Field::inst( 'ljoprtd.id_ljoxxth' ),
				Field::inst( 'ljoprtd.id_lprxxmh' )
					->setFormatter( Format::ifEmpty( 0 ) ),
				Field::inst( 'ljoprtd.kode' ),
				Field::inst( 'ljoprtd.nama' ),
				Field::inst( 'ljoprtd.keterangan' ),
				Field::inst( 'ljoprtd.created_by' ),
				Field::inst( 'ljoprtd.transaction_state' ),
				Field::inst( 'ljoprtd.approval_state' ),
				Field::inst( 'ljoprtd.start_at' ),
				Field::inst( 'ljoprtd.finish_at' ),
				Field::inst( 'ljoprtd.is_defaultprogram' ),
				Field::inst( 'ljoprtd.tanggaljam_start' )
					->getFormatter( 'Format::datetime', array(
						'from' => 'Y-m-d H:i:s',
						'to' =>   'd M Y H:i'
					) )
					->setFormatter( 'Format::datetime', array(
						'from' => 'd M Y H:i',
						'to' =>   'Y-m-d H:i:s'
					) ),
				Field::inst( 'ljoprtd.tanggaljam_finish' )
					->getFormatter( 'Format::datetime', array(
						'from' => 'Y-m-d H:i:s',
						'to' =>   'd M Y H:i'
					) )
					->setFormatter( 'Format::datetime', array(
						'from' => 'd M Y H:i',
						'to' =>   'Y-m-d H:i:s'
					) ),

				Field::inst( 'lprxxmh.nama' )
			)
			->leftJoin( 'lprxxmh','lprxxmh.id','=','ljoprtd.id_lprxxmh' )
			->where('ljoprtd.id_ljoxxth',$_POST['id_ljoxxth']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_ljoprtd'] == 0){
			$editor
				->where( 'ljoprtd.transaction_state', -9, '<>');
		}
		
		include( "ljoprtd_extra.php" );

		// BEGIN log
		$nama_table = 'ljoprtd';
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