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
	
	if ( ! isset($_POST['id_udpxxsh']) || ! is_numeric($_POST['id_udpxxsh']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'ucudasd' )
			->debug(true)
			->fields(
				Field::inst( 'ucudasd.id' ),
				Field::inst( 'ucudasd.id_udpxxsh' ),
				Field::inst( 'ucudasd.id_pages' )
					->options( Options::inst()
						->table( 'pages' )
						->value( 'id' )
						->label( ['title'] )
						->where( function ($q) {
							$q
								->where( 'LEFT (page, 6)', 'usersc' )
								->where( 'id', '(SELECT id_pages FROM ucudasd)', 'NOT IN', false );
						})
						->order( 'title' )
					),
				Field::inst( 'ucudasd.kode' ),
				Field::inst( 'ucudasd.nama' ),
				Field::inst( 'ucudasd.keterangan' ),
				Field::inst( 'ucudasd.created_by' ),
				Field::inst( 'ucudasd.transaction_state' ),
				Field::inst( 'ucudasd.approval_state' ),
				Field::inst( 'ucudasd.start_at' ),
				Field::inst( 'ucudasd.finish_at' ),
				Field::inst( 'ucudasd.is_defaultprogram' ),

				Field::inst( 'ucudasd.hak_c' ),
				Field::inst( 'ucudasd.hak_r' ),
				Field::inst( 'ucudasd.hak_u' ),
				Field::inst( 'ucudasd.hak_d' ),
				Field::inst( 'ucudasd.hak_a' ),
				Field::inst( 'ucudasd.hak_l' ),
				Field::inst( 'ucudasd.hak_e' ),
				Field::inst( 'ucudasd.hak_p' ),
				Field::inst( 'pages.title' ),
				Field::inst( 'menus.display_order' ),
			)
			->leftJoin( 'pages','pages.id','=','ucudasd.id_pages' )
			->leftJoin( 'menus','menus.link','=','SUBSTRING_INDEX(pages.page, "views/", -1)' )
			->where('ucudasd.id_udpxxsh',$_POST['id_udpxxsh']);
		
		// do not erase
		// function show / hide inactive document
		if ( $_POST['show_deleted_ucudasd'] == 0){
			$editor
				->where( 'ucudasd.transaction_state', -9, '<>');
		}

		// BEGIN log
		$nama_table = 'ucudasd';
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