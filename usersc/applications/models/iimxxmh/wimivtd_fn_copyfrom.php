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
		$editor = Editor::inst( $db, 'wimivtd' )
			->debug(true)
			->fields(
				Field::inst( 'wimivtd.id' )
					->set( Field::SET_NONE ),
				Field::inst( 'wimivtd.id_iimxxmh' )
					->set( Field::SET_NONE )
			)
			->where('wimivtd.id_iimxxmh',$_POST['id_iimxxmh']);
		
		$editor
			->on('preCreate',function( $editor, $values ) use ( $s_id_users, $s_username) {
				$start_at           = $values['start_at'];
            	$finish_at          = $values['finish_at'];

				$qs_wimivtd = $editor->db()
					->raw()
					->bind(':id_iimxxmh_source', $values['id_iimxxmh_source'])
					->bind(':id_iimxxmh_target', $values['wimivtd']['id_iimxxmh'])
					->exec('
						INSERT INTO
							wimivtd (
								id_iimxxmh,
								id_iumxxmh,
								id_iwhxxmh,
								min_stock,
								max_stock
							)
						SELECT
							'. $values['wimivtd']['id_iimxxmh'] . ',
							id_iumxxmh,
							id_iwhxxmh,
							min_stock,
							max_stock
						FROM wimivtd
						WHERE 1
                            AND id_iimxxmh = :id_iimxxmh_source 
							AND id_iwhxxmh NOT IN (
								SELECT
									id_iwhxxmh
								FROM wimivtd
								WHERE
									id_iimxxmh = :id_iimxxmh_target
							)
					');

					General::logChange( $editor->db() , 'wimivtd', $s_id_users, $s_username, 'CREATE', $values['wimivtd']['id_iimxxmh'], 'Insert from generate', $start_at, $finish_at );
			});
		
		$json = $editor
			->process( $_POST )
			->data();

		// debugging hak akses
		$json['hakakses'] = $hakakses;

		echo json_encode( $json );

	}
?>