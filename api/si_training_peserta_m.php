<?php
// Check if request is empty
if ( ! empty( $_REQUEST ) ) {
    // Get the request. Works both for GET and POST
    $info = $_REQUEST;
    // Save HTTP METHOD for debugging
    $info['method'] = $_SERVER['REQUEST_METHOD'];
    // Create the JSON
    $json = json_encode( $info );
    // Store it in a file
    $filename = dirname( __FILE__ ) . '/eform-url-' . ( isset( $_REQUEST['data_id'] ) ? $_REQUEST['data_id'] : uniqid() ) . '.json';
    // We are not really checking if the file exists or not
    file_put_contents( $filename, $json );
// Request is empty, so exit
} else {
    echo 'Bad Request!';
}