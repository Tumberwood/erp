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
		$editor = Editor::inst( $db, 'udpwhsd' )
			->debug(true)
			->fields(
				Field::inst( 'udpwhsd.id' )
					->set( Field::SET_NONE ),
				Field::inst( 'udpwhsd.id_udpxxsh' )
					->set( Field::SET_NONE )
			)
			->where('udpwhsd.id_udpxxsh',$_POST['id_udpxxsh']);
		
		$editor
			->on('preCreate',function( $editor, $values ) use ( $s_id_users, $s_username) {
				$start_at           = $values['start_at'];
            	$finish_at          = $values['finish_at'];
				$id_udpxxsh = $values['udpwhsd']['id_udpxxsh'];

				//hapus detail lama
				$qd_udpwhsd = $editor->db()
					->query('delete', 'udpwhsd')
					->where('id_udpxxsh',$id_udpxxsh)
					->exec();
				
				$qs_udpxxsh = $editor->db()
					->query('select', 'udpxxsh' )
					->get(['id_users'] )
					->where('id', $id_udpxxsh )
					->exec();
				$rs_udpxxsh = $qs_udpxxsh->fetch();
				$id_users = $rs_udpxxsh['id_users'];

				$qs_udpwhsd = $editor->db()
					->raw()
					->bind(':id_udpxxsh_source', $values['id_udpxxsh_source'])
					->bind(':id_udpxxsh_target', $id_udpxxsh)
					->exec('
						INSERT INTO
							udpwhsd (
								id_udpxxsh,
								id_iwhxxmh,
								keterangan
							)
						SELECT
							:id_udpxxsh_target,
							id_iwhxxmh,
							keterangan
						FROM udpwhsd
						WHERE 1
							AND id_udpxxsh = :id_udpxxsh_source 
					');

					General::logChange( $editor->db() , 'udpwhsd', $s_id_users, $s_username, 'CREATE', $values['udpwhsd']['id_udpxxsh'], 'Insert from generate', $start_at, $finish_at );

			});
		
		$json = $editor
			->process( $_POST )
			->data();

		// debugging hak akses
		$json['hakakses'] = $hakakses;

		echo json_encode( $json );

	}
?>