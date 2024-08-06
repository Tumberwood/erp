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
	
	if ( ! isset($_POST['id_udpxxsh']) || ! is_numeric($_POST['id_udpxxsh']) ) {
		echo json_encode( [ "data" => [] ] );
	}else{
		$editor = Editor::inst( $db, 'udpodsd' )
			->debug(true)
			->fields(
				Field::inst( 'udpodsd.id' )
					->set( Field::SET_NONE ),
				Field::inst( 'udpodsd.id_udpxxsh' )
					->set( Field::SET_NONE )
			)
			->where('udpodsd.id_udpxxsh',$_POST['id_udpxxsh']);
		
		$editor
			->on('preCreate',function( $editor, $values ) use ( $s_id_users, $s_username) {
				$start_at           = $values['start_at'];
            	$finish_at          = $values['finish_at'];
				$id_udpxxsh = $values['udpodsd']['id_udpxxsh'];

				//hapus detail lama
				$qd_udpodsd = $editor->db()
					->query('delete', 'udpodsd')
					->where('id_udpxxsh',$id_udpxxsh)
					->exec();
				
				$qs_udpxxsh = $editor->db()
					->query('select', 'udpxxsh' )
					->get(['id_users'] )
					->where('id', $id_udpxxsh )
					->exec();
				$rs_udpxxsh = $qs_udpxxsh->fetch();
				$id_users = $rs_udpxxsh['id_users'];

				$qs_udpodsd = $editor->db()
					->raw()
					->bind(':id_udpxxsh_source', $values['id_udpxxsh_source'])
					->bind(':id_udpxxsh_target', $id_udpxxsh)
					->exec('
						INSERT INTO
							udpodsd (
								id_udpxxsh,
								id_hodxxmh,
								keterangan
							)
						SELECT
							:id_udpxxsh_target,
							id_hodxxmh,
							keterangan
						FROM udpodsd
						WHERE 1
							AND id_udpxxsh = :id_udpxxsh_source 
					');

					General::logChange( $editor->db() , 'udpodsd', $s_id_users, $s_username, 'CREATE', $values['udpodsd']['id_udpxxsh'], 'Insert from generate', $start_at, $finish_at );

			});
		
		$json = $editor
			->process( $_POST )
			->data();

		// debugging hak akses
		$json['hakakses'] = $hakakses;

		echo json_encode( $json );

	}
?>