<?php

	use SolusiIndonesia\Utilities\Converter;

	function isIumxxmhBeli( $db, $id_transaksi_default, $id_wloctmh, $id_iwhxxmh ){
		$qu = $db
			->raw()
			->exec('UPDATE wloxxmh
					SET
						is_default = 0
					WHERE 
						id_iwhxxmh = '.$id_iwhxxmh.' AND
						id_wloctmh = '.$id_wloctmh.' AND
						id <> '.$id_transaksi_default.'
			');
	}

    $editor
		->on('preCreate',function( $editor, $values ) {
			$editor
				->field( 'wloxxmh.rack' )
				->setValue( Converter::convertAllToNumber($values['wloxxmh']['rack_name']) );
			$editor
				->field( 'wloxxmh.bay' )
				->setValue( Converter::convertAllToNumber($values['wloxxmh']['bay_name']) );
			$editor
				->field( 'wloxxmh.level' )
				->setValue( Converter::convertAllToNumber($values['wloxxmh']['level_name']) );
			$editor
				->field( 'wloxxmh.position' )
				->setValue( Converter::convertAllToNumber($values['wloxxmh']['position_name']) );
				
		})
		->on('postCreate',function( $editor, $id, $values, $row ) {
			// script diletakkan disini
			$id_iwhxxmh = $values['wloxxmh']['id_iwhxxmh'];
			$id_wloctmh = $values['wloxxmh']['id_wloctmh'];
			$is_default = $values['wloxxmh']['is_default'];

			if( $is_default == 1 ){
				isIumxxmhBeli( $editor->db(), $id, $id_wloctmh, $id_iwhxxmh);
			}
		})
		->on('preEdit',function( $editor, $id, $values ) {
			$editor
				->field( 'wloxxmh.rack' )
				->setValue( Converter::convertAllToNumber($values['wloxxmh']['rack_name']) );
			$editor
				->field( 'wloxxmh.bay' )
				->setValue( Converter::convertAllToNumber($values['wloxxmh']['bay_name']) );
			$editor
				->field( 'wloxxmh.level' )
				->setValue( Converter::convertAllToNumber($values['wloxxmh']['level_name']) );
			$editor
				->field( 'wloxxmh.position' )
				->setValue( Converter::convertAllToNumber($values['wloxxmh']['position_name']) );
		})
		->on('postEdit',function( $editor, $id, $values, $row ) {
			// BEGIN is_update_iumxxmh_beli
			$id_iwhxxmh = $values['wloxxmh']['id_iwhxxmh'];
			$id_wloctmh = $values['wloxxmh']['id_wloctmh'];
			$is_default = $values['wloxxmh']['is_default'];

			if( $is_default == 1 ){
				isIumxxmhBeli( $editor->db(), $id, $id_wloctmh, $id_iwhxxmh);
			}
			// END is_update_iumxxmh_beli
		})
		->on('preRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		})
		->on('postRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		});
?>