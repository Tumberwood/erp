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
		DataTables\Editor\Result,
		Carbon\Carbon,
		SolusiIndonesia\Utilities\General;
	
	if ( ! isset($_POST['id_iimxxmh']) || ! is_numeric($_POST['id_iimxxmh']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'iimrlmd_supplier' )
			->debug(true)
			->fields(
				Field::inst( 'iimrlmd_supplier.id' )
					->set( Field::SET_NONE ),
				Field::inst( 'iimrlmd_supplier.id_iimxxmh' )
					->set( Field::SET_NONE )
			)
			->where('iimrlmd_supplier.id_iimxxmh',$_POST['id_iimxxmh']);
		
		$editor
			->on('preCreate',function( $editor, $values ) use ( $s_id_users, $s_username) {
				$start_at           = $values['start_at'];
            	$finish_at          = $values['finish_at'];

				$qs_iimrlmd_supplier = $editor->db()
					->raw()
					->bind(':id_iimxxmh_source', $values['id_iimxxmh_source'])
					->bind(':id_iimxxmh_target', $values['iimrlmd_supplier']['id_iimxxmh'])
					->exec('
						INSERT INTO
							iimrlmd_supplier (
								id_iimxxmh,
								id_grlxxmh_supplier,
								leadtime_hari,
								moq
							)
						SELECT
							'. $values['iimrlmd_supplier']['id_iimxxmh'] . ',
							id_grlxxmh_supplier,
							leadtime_hari,
							moq
						FROM iimrlmd_supplier
						WHERE 1
							AND id_iimxxmh = :id_iimxxmh_source 
							AND id_grlxxmh_supplier NOT IN (
								SELECT
									id_grlxxmh_supplier
								FROM iimrlmd_supplier
								WHERE 
									id_iimxxmh = :id_iimxxmh_target
							)
					');

					General::logChange( $editor->db() , 'iimrlmd_supplier', $s_id_users, $s_username, 'CREATE', $values['iimrlmd_supplier']['id_iimxxmh'], 'Insert from generate', $start_at, $finish_at );

			});
		
		$json = $editor
			->process( $_POST )
			->data();

		// debugging hak akses
		$json['hakakses'] = $hakakses;

		echo json_encode( $json );

	}
?>