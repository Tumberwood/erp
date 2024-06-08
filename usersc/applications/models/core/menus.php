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
	
	$editor = Editor::inst( $db, 'menus' )
		->debug(true)
		->fields(
			Field::inst( 'menus.id' ),
			Field::inst( 'menus.menu_title' )
				->set( Field::SET_CREATE )
				->setValue('side'),
			Field::inst( 'menus.parent' )
				->setFormatter( Format::ifEmpty( 0 ) ),
			Field::inst( 'menus.dropdown' ),
			Field::inst( 'menus.logged_in' ),
			Field::inst( 'menus.display_order' ),
			Field::inst( 'menus.label' ),
			Field::inst( 'menus.link' ),
			Field::inst( 'menus.icon_class' ),

			Field::inst( 'menus_parent.label' ),
			Field::inst( 'menus_extend.created_by' ),
			Field::inst( 'menus_extend.transaction_state' ),
			Field::inst( 'menus_extend.approval_state' ),
			Field::inst( 'menus_extend.start_at' ),
			Field::inst( 'menus_extend.finish_at' ),
			Field::inst( 'menus_extend.is_defaultprogram' )
		)
        ->leftJoin( 'menus as menus_parent','menus_parent.id','=','menus.parent' )
		->leftJoin( 'menus_extend','menus_extend.id','=','menus.id' )
		->join(
			Mjoin::inst( 'permissions' )
				->link( 'menus.id', 'groups_menus.menu_id' )
				->link( 'permissions.id', 'groups_menus.group_id' )
				->fields(
					Field::inst( 'id' )
						->setFormatter( Format::ifEmpty( 0 ) )
						->options( Options::inst()
							->table( 'permissions' )
							->value( 'id' )
							->label( ['name'] )
							->render( function ( $row ) {
								return $row['name'];
							} )
							->order( 'name' )
						),
					Field::inst( 'name' )
				)
		)
		->where( 'menus.menu_title', 'side');

	$editor
		->on( 'preCreate', function ( $editor, &$values ) {
			$parent = $values['menus']['parent'];
			$dropdown = $values['menus']['dropdown'];
			if($parent == ''){
				$editor
					->field( 'menus.parent' )
					->setValue( -1 );
			}
			
		} )
		->on( 'preEdit', function ( $editor, $id, &$values ) {
			$parent = $values['menus']['parent'];
			$dropdown = $values['menus']['dropdown'];
			if($parent == ''){
				$editor
					->field( 'menus.parent' )
					->setValue( -1 );
			}
		} );

	// BEGIN log
	$nama_table = 'menus_extend';
	include( "../../../helpers/edt_log.php" );
	// END log
	
	$json = $editor
		->process( $_POST )
		->data();

	// debugging hak akses
	$json['hakakses'] = $hakakses;

	echo json_encode( $json );
?>