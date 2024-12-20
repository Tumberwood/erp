<?php
    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row ) {
			// script diletakkan disini
			$qs_httlptd = $editor->db()
				->raw()
				->bind(':id', $id)
				->exec('SELECT
							c.id_hovxxmh,
							c.id_hodxxmh,
							c.id_hosxxmh
						FROM httlptd a
						LEFT JOIN hemjbmh c on c.id_hemxxmh = a.id_hemxxmh
						WHERE a.id = :id
			');
			
			$rs_httlptd = $qs_httlptd->fetch();
			$id_hovxxmh = $rs_httlptd['id_hovxxmh'];
			$id_hodxxmh = $rs_httlptd['id_hodxxmh'];
			$id_hosxxmh = $rs_httlptd['id_hosxxmh'];

			$qu_httlptd = $editor->db()
				->query('update', 'httlptd')
				->set('id_hovxxmh',$id_hovxxmh)
				->set('id_hodxxmh',$id_hodxxmh)
				->set('id_hosxxmh',$id_hosxxmh)
				->where('id',$id)
				->exec();
		})
		->on('preEdit',function( $editor, $id, $values ) {
			// script diletakkan disini
		})
		->on('postEdit',function( $editor, $id, $values, $row ) {
			// script diletakkan disini
			// script diletakkan disini
			$qs_httlptd = $editor->db()
				->raw()
				->bind(':id', $id)
				->exec('SELECT
							c.id_hovxxmh,
							c.id_hodxxmh,
							c.id_hosxxmh
						FROM httlptd a
						LEFT JOIN hemjbmh c on c.id_hemxxmh = a.id_hemxxmh
						WHERE a.id = :id
			');
			
			$rs_httlptd = $qs_httlptd->fetch();
			$id_hovxxmh = $rs_httlptd['id_hovxxmh'];
			$id_hodxxmh = $rs_httlptd['id_hodxxmh'];
			$id_hosxxmh = $rs_httlptd['id_hosxxmh'];

			$qu_httlptd = $editor->db()
				->query('update', 'httlptd')
				->set('id_hovxxmh',$id_hovxxmh)
				->set('id_hodxxmh',$id_hodxxmh)
				->set('id_hosxxmh',$id_hosxxmh)
				->where('id',$id)
				->exec();
		})
		->on('preRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		})
		->on('postRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		});
?>