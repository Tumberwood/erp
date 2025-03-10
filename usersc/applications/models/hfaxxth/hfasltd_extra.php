<?php
    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row ) {
			$id_hfasktd = $values['hfasltd']['id_hfasktd'];
			$status = $values['hfasltd']['status'];

			if ($status == 'OK') {
				$status_final = "Done";
				$transaction_state = 1;
			} else {
				$status_final = "Open";
				$transaction_state = 0;
			}
			
			$qu_hfasktd = $editor->db()
				->query('update', 'hfasktd')
				->set('status',$status_final)
				->set('transaction_state',$transaction_state)
				->where('id',$id_hfasktd)
				->exec();
		})
		->on('preEdit',function( $editor, $id, $values ) {
			// script diletakkan disini
		})
		->on('postEdit',function( $editor, $id, $values, $row ) {
			$id_hfasktd = $values['hfasltd']['id_hfasktd'];
			$status = $values['hfasltd']['status'];

			if ($status == 'OK') {
				$status_final = "Done";
				$transaction_state = 1;
			} else {
				$status_final = "Open";
				$transaction_state = 0;
			}
			
			$qu_hfasktd = $editor->db()
				->query('update', 'hfasktd')
				->set('status',$status_final)
				->set('transaction_state',$transaction_state)
				->where('id',$id_hfasktd)
				->exec();
		})
		->on('preRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		})
		->on('postRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		});
?>