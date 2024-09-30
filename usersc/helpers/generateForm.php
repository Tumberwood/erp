<?php
	use
		DataTables\Editor,
		DataTables\Editor\Query,
		DataTables\Editor\Field,
		DataTables\Editor\Validate,
		DataTables\Editor\ValidateOptions,
		DataTables\Editor\Result;

	// Execute the query to get the field information
	$query = $db
		->raw()
		->bind(':nama_table', $nama_table)
		->exec('SELECT
					a.is_required,
					a.type_data,
					a.nama
				FROM gfrfltd a
				LEFT JOIN gfrxxth b ON b.id = a.id_gfrxxth
				WHERE b.nama_tabel = :nama_table AND a.transaction_state <> -9 AND b.transaction_state = 1
		');

	// Fetch results
	$results = $query->fetchAll();

	// Get existing field names
	$existingFields = array_map(function($field) {
		return $field->name();
	}, $editor->fields());

	// Add new fields, ensuring we don't add duplicates
	foreach ($results as $gen_form) {
		$is_required = $gen_form['is_required'];
		$fieldName = $gen_form['nama'];

		// Only add the field if it does not already exist
		if (!in_array($fieldName, $existingFields)) {
			//IF TIPE DATA = DATE
			if ($gen_form['type_data'] == 'DATE') {
				$editor->field(
					Field::inst($fieldName)
						->getFormatter( function ( $val, $data, $opts ) {
							if ($val === '0000-00-00' || $val === null){
								echo '';
							}else{
								return date( 'd M Y', strtotime( $val ) );
							}
						} )
						->setFormatter( 'Format::datetime', array(
							'from' => 'd M Y',
							'to' =>   'Y-m-d'
						) ),
				);
			
			//IF TIPE DATA = DATETIME
			} else if ($gen_form['type_data'] == 'DATETIME') {
				$editor->field(
					Field::inst($fieldName)
						->getFormatter( 'Format::datetime', array(
							'from' => 'Y-m-d H:i:s',
							'to' =>   'd M Y H:i'
						) )
						->setFormatter( 'Format::datetime', array(
							'from' => 'd M Y H:i',
							'to' =>   'Y-m-d H:i:s'
						) )
				);
			
			//IF TIPE DATA = TIME
			} else if ($gen_form['type_data'] == 'TIME') {
				$editor->field(
					Field::inst($fieldName)
						->getFormatter( 'Format::datetime', array(
							'from' => 'H:i:s',
							'to' =>   'H:i'
						) )
						->setFormatter( 'Format::datetime', array(
							'from' => 'H:i',
							'to' =>   'H:i:s'
						) )
				);
			} else {
				$editor->field(
					Field::inst($fieldName)
				);
			}
		}
	}
?>
