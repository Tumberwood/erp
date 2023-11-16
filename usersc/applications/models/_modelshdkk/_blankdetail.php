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
	
	if ( ! isset($_POST['id__blankheader']) || ! is_numeric($_POST['id__blankheader']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, '_blankdetail' )
			->debug(true)
			->fields(
				Field::inst( '_blankdetail.id' ),
				Field::inst( '_blankdetail.id__blankheader' ),
				Field::inst( '_blankdetail.kode' ),
				Field::inst( '_blankdetail.nama' ),
				Field::inst( '_blankdetail.keterangan' ),
				Field::inst( '_blankdetail.created_by' ),
				Field::inst( '_blankdetail.transaction_state' ),
				Field::inst( '_blankdetail.approval_state' ),
				Field::inst( '_blankdetail.start_at' ),
				Field::inst( '_blankdetail.finish_at' ),
				Field::inst( '_blankdetail.is_defaultprogram' )
			)
			->where('_blankdetail.id__blankheader',$_POST['id__blankheader']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted__blankdetail'] == 0){
			$editor
				->where( '_blankdetail.transaction_state', -9, '<>');
		}
		
		include( "_blankdetail_extra.php" );

		// BEGIN log
		$nama_table = '_blankdetail';
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