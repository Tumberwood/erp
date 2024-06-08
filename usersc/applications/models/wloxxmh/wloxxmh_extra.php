<?php

	use SolusiIndonesia\Utilities\Converter;

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
			// script diletakkan disini
		})
		->on('preRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		})
		->on('postRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		});
?>