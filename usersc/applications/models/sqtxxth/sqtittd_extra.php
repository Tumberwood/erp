<?php

	use 
		SolusiIndonesia\Utilities\General;
		
    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row ) {
			$id_iimxxmh = $values['sqtittd']['id_iimxxmh'];
			$jumlah_unit = $values['sqtittd']['jumlah_unit'];
			$id_iumxxmh_unit = $values['sqtittd']['id_iumxxmh_unit'];

			if ($id_iimxxmh > 0) {
				General::konversiUom( $editor->db(), 'sqtittd', $id );
			} else {
				$qu_sqtittd = $editor->db()
					->query('update', 'sqtittd')
					->set('id_iumxxmh_terkecil',$id_iumxxmh_unit)
					->set('id_iumxxmh_default',$id_iumxxmh_unit)
					->set('jumlah_terkecil',$jumlah_unit)
					->set('jumlah_terkecil_os',$jumlah_unit)
					->set('jumlah_konversi',1)
					->set('jumlah_default',$jumlah_unit)
					->set('jumlah_default_os',$jumlah_unit)
					->where('id',$id)
					->exec();
			}
		})
		->on('preEdit',function( $editor, $id, $values ) {
			// script diletakkan disini
		})
		->on('postEdit',function( $editor, $id, $values, $row ) {
			$id_iimxxmh = $values['sqtittd']['id_iimxxmh'];
			$jumlah_unit = $values['sqtittd']['jumlah_unit'];
			$id_iumxxmh_unit = $values['sqtittd']['id_iumxxmh_unit'];

			if ($id_iimxxmh > 0) {
				General::konversiUom( $editor->db(), 'sqtittd', $id );
			} else {
				$qu_sqtittd = $editor->db()
					->query('update', 'sqtittd')
					->set('id_iumxxmh_terkecil',$id_iumxxmh_unit)
					->set('id_iumxxmh_default',$id_iumxxmh_unit)
					->set('jumlah_terkecil',$jumlah_unit)
					->set('jumlah_terkecil_os',$jumlah_unit)
					->set('jumlah_konversi',1)
					->set('jumlah_default',$jumlah_unit)
					->set('jumlah_default_os',$jumlah_unit)
					->where('id',$id)
					->exec();
			}
		})
		->on('preRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		})
		->on('postRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		});
?>