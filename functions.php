/********************************************************************************
Create Post
********************************************************************************/
$api_response = wp_remote_post( 'https://example.com/wp-json/wp/v2/posts', array(
 	'headers' => array(
		'Authorization' => 'Basic ' . base64_encode( 'LOGIN:PASSWORD' )
	),
	'body' => array(
    'title'   => 'Hello World',
		'status'  => 'publish', 
		'content' => 'This is my first post created using rest API',
		'categories' => 5, // category ID
		'date' => '2015-05-05T10:00:00', // YYYY-MM-DDTHH:MM:SS
		'slug' => 'hello-world' 
	)
) );
 
$body = json_decode( $api_response['body'] );
 
// Let's take a look what is inside
// print_r( $body ); 
if( wp_remote_retrieve_response_message( $api_response ) === 'Created' ) {
	echo 'The post ' . $body->title->rendered . ' has been created successfully';
}

/********************************************************************************
Update Post
********************************************************************************/
$api_response = wp_remote_post( 'https://example.com/wp-json/wp/v2/posts/{POST_ID}/', array(
 	'headers' => array(
		'Authorization' => 'Basic ' . base64_encode( 'LOGIN:PASSWORD' )
	),
	'body' => array(
    		'title' => 'New Hello World'
	)
) );
 
$body = json_decode( $api_response['body'] );
 
if( wp_remote_retrieve_response_message( $api_response ) === 'OK' ) {
	echo 'The post ' . $body->title->rendered . ' has been updated successfully';
}

/********************************************************************************
Delete Post
********************************************************************************/
$api_response = wp_remote_request( 'https://WEBSITE/wp-json/wp/v2/posts/{POST_ID}', array(  // add ?force=true at end of url to delete post permenently
	'method'    => 'DELETE',
	'headers'   => array(
	    'Authorization' => 'Basic ' . base64_encode( 'LOGIN:PASSWORD' )
	)
));
 
$body = json_decode( $api_response['body'] );
 
if( wp_remote_retrieve_response_message( $api_response ) === 'OK' ) {
	if( $body->deleted == true ) {
		echo 'The post ' . $body->previous->title->rendered . ' has been completely deleted';
	} else {
		echo 'The post ' . $body->title->rendered . ' has been moved to trash';
	}
}
