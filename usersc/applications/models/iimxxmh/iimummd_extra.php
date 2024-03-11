<?php
	
	function isIumxxmhBeli( $db, $id_transaksi_h, $id_transaksi_default, $action ){
		if($action != 'REMOVE'){
			$qu = $db
				->raw()
				->bind(':id_transaksi_h', $id_transaksi_h)
				->bind(':id_transaksi_default', $id_transaksi_default)
				->exec('
					UPDATE iimummd
					SET
						is_iumxxmh_beli = 0
					WHERE 
						id_iimxxmh = :id_transaksi_h AND
						id <> :id_transaksi_default
				');
		}

	}

	function isIumxxmhJual( $db, $id_transaksi_h, $id_transaksi_default, $action ){
		if($action != 'REMOVE'){
			$qu = $db
				->raw()
				->bind(':id_transaksi_h', $id_transaksi_h)
				->bind(':id_transaksi_default', $id_transaksi_default)
				->exec('
					UPDATE iimummd
					SET
						is_iumxxmh_jual = 0
					WHERE 
						id_iimxxmh = :id_transaksi_h AND
						id <> :id_transaksi_default
				');
		}

	}
	
    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row ) {
			// BEGIN isNextProcess
			if( $values['iimummd']['id_iumxxmh'] > 0 ){
				isNextProcess( $editor->db(), '', 'iumxxmh', 'iimummd', $id, 'CREATE' );
			}
			// END isNextProcess

			// BEGIN is_update_iumxxmh_default
			if( $values['is_update_iumxxmh_default'] == 1 ){
				$id_transaksi_h = $values['iimummd']['id_iimxxmh'];
				isDefaultUpdateD( $editor->db(), 'iimummd', $id_transaksi_h, $id, 'EDIT' );
			}
			// END is_update_iumxxmh_default
		})
		->on('preEdit',function( $editor, $id, $values ) {
			// script diletakkan disini
		})
		->on('postEdit',function( $editor, $id, $values, $row ) {
			// BEGIN isNextProcess
			if( $values['iimummd']['id_iumxxmh'] > 0 ){
				isNextProcess( $editor->db(), '', 'iumxxmh', 'iimummd', $id, 'EDIT' );
			}
			// END isNextProcess

			// BEGIN is_update_iumxxmh_default
			if( $values['is_update_iumxxmh_default'] == 1 ){
				$id_transaksi_h = $values['iimummd']['id_iimxxmh'];
				isDefaultUpdateD( $editor->db(), 'iimummd', $id_transaksi_h, $id, 'EDIT' );
			}
			// END is_update_iumxxmh_default

			// BEGIN is_update_iumxxmh_beli
			if( $values['is_update_iumxxmh_beli'] == 1 ){
				$id_transaksi_h = $values['iimummd']['id_iimxxmh'];
				isIumxxmhBeli( $editor->db(), $id_transaksi_h, $id, 'EDIT' );
			}
			// END is_update_iumxxmh_beli

			// BEGIN is_update_iumxxmh_jual
			if( $values['is_update_iumxxmh_jual'] == 1 ){
				$id_transaksi_h = $values['iimummd']['id_iimxxmh'];
				isIumxxmhJual( $editor->db(), $id_transaksi_h, $id, 'EDIT' );
			}
			// END is_update_iumxxmh_jual
			
		})
		->on('preRemove',function( $editor, $id, $values ) {
			// BEGIN isNextProcess
			if( $values['iimummd']['id_iumxxmh'] > 0 ){
				isNextProcess( $editor->db(), '', 'iumxxmh', 'iimummd', $id, 'REMOVE' );
			}
			// END isNextProcess
		})
		->on('postRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		});
?>