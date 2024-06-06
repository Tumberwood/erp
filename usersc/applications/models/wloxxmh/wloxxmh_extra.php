<?php
	function convertNumber($input) {
		if (preg_match('/^\d+$/', $input)) {
			$number = intval($input);

		} elseif (preg_match('/^[A-Z]+$/', $input)) {
			$input = strtoupper($input);
			$length = strlen($input);
			$number = 0;
		
			for ($i = 0; $i < $length; $i++) {
				$number = $number * 26 + (ord($input[$i]) - ord('A') + 1);
			}

		} else {
			$number = 0;
		}

		return $number;
	}

    $editor
		->on('preCreate',function( $editor, $values ) {
			$editor
				->field( 'wloxxmh.rack' )
				->setValue( convertNumber($values['wloxxmh']['rack_name']) );
			$editor
				->field( 'wloxxmh.bay' )
				->setValue( convertNumber($values['wloxxmh']['bay_name']) );
				
		})
		->on('postCreate',function( $editor, $id, $values, $row ) {
			// script diletakkan disini
		})
		->on('preEdit',function( $editor, $id, $values ) {
			$editor
				->field( 'wloxxmh.rack' )
				->setValue( convertNumber($values['wloxxmh']['rack_name']) );
			$editor
				->field( 'wloxxmh.bay' )
				->setValue( convertNumber($values['wloxxmh']['bay_name']) );
			$editor
				->field( 'wloxxmh.level' )
				->setValue( convertNumber($values['wloxxmh']['level_name']) );
			$editor
				->field( 'wloxxmh.position' )
				->setValue( convertNumber($values['wloxxmh']['position_name']) );
		})
		->on('postEdit',function( $editor, $id, $values, $row ) {
			// script diletakkan disini
		})
		->on('preRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		})
		->on('postRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		});
?>