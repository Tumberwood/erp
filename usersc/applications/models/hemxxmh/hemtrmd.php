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
	
	if ( ! isset($_POST['id_hemxxmh']) || ! is_numeric($_POST['id_hemxxmh']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'hemtrmd' )
			->debug(true)
			->fields(
				Field::inst( 'hemtrmd.id' ),
				Field::inst( 'hemtrmd.id_hemxxmh' ),
				Field::inst( 'hemtrmd.kode' ),
				Field::inst( 'hemtrmd.nama' ),
				Field::inst( 'hemtrmd.keterangan' ),
				Field::inst( 'hemtrmd.created_by' ),
				Field::inst( 'hemtrmd.transaction_state' ),
				Field::inst( 'hemtrmd.approval_state' ),
				Field::inst( 'hemtrmd.start_at' ),
				Field::inst( 'hemtrmd.finish_at' ),
				Field::inst( 'hemtrmd.is_defaultprogram' ),
				Field::inst( 'hemtrmd.is_default' ),
				Field::inst( 'hemtrmd.penyelenggara' ),
				
				Field::inst( 'hemtrmd.tanggal_awal' )
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
				Field::inst( 'hemtrmd.tanggal_akhir' )
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
			)
			->where('hemtrmd.id_hemxxmh',$_POST['id_hemxxmh']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_hemtrmd'] == 0){
			$editor
				->where( 'hemtrmd.transaction_state', -9, '<>');
		}
		

		// BEGIN log
		$nama_table = 'hemtrmd';
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