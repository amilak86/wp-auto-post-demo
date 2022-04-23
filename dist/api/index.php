<?php
error_reporting(E_ALL && ~E_NOTICE);			// sets error reporting level

require '../../config.php';						// required. don't remove
require APP_ROOT . '/vendor/autoload.php';		// required. don't remove

use Ak86\WPAutoPost;
//use GuzzleHttp\Exception\ConnectException;
//use GuzzleHttp\Exception\RequestException;

	// exit if the request method is not POST
	if ($_SERVER['REQUEST_METHOD'] != 'POST') {
		http_response_code(405); 
		exit;
	}

	// exit if the $_POST is empty
	if (!$_POST) {
		http_response_code(400);
		exit;
	}

	$response = [];

	// process submission
	try {

		// upload image: check for upload errors
		if (!isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
			throw new Exception('Image Upload Error: ' . $_FILES['image']['error']);
		}

		// upload image: check the file type
		$ext = strtolower(end(explode('.', $_FILES['image']['name'])));
		if (!in_array($ext, ['jpg','png','gif'])) {
			throw new Exception('Invalid File Type. Only Image Types are Allowed!');
		}

		// upload image: check file size
		if ($_FILES['image']['size'] > 1000000) {
			throw new Exception('File exceeds maximum size (1MB)');
		}

		// upload image: save image
		$fileName = md5(time() . basename($_FILES['image']['name'])) . '.' . $ext;
		if ( !move_uploaded_file($_FILES['image']['tmp_name'], APP_ROOT . '/dist/uploads/' . $fileName )) {
			throw new Exception('Error saving the image!');
		}

		// upload image: set image url
		$imageUrl = APP_URL . '/uploads/'.$fileName;

		// initialize wp auto post client
		$wpap_client = new WPAutoPost(WP_REST_POST_ENDPOINT, WP_REST_MEDIA_ENDPOINT, WP_REST_AUTH_APP_USER, WP_REST_AUTH_APP_PASS);

		// upload the image to wordpress
		if(!$uploaded_image = $wpap_client->upload_image($imageUrl))
		{
			throw new Exception('Error occurred while uploading the image to wordpress! Please check the script and try again!');
		}

		// prepare post data
		/*
		* title -> your post title
		* content -> your post content. you may use single quotes and other escape characters. if using double quotes you have to escape it with a slash
		* status -> status can be 'publish', 'draft', 'pending' etc.
		* YOU MAY ADD ANY OTHER NECESSARY PARAMETERS THAT WORDPRESS POST API ACCEPTS (https://developer.wordpress.org/rest-api/reference/posts/#create-a-post)
		*/
		$postData = array(
			"title" => filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING),
			"content" => filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING),
			"status" => "publish"
		);

		// create the post in wordpress
		if(!$wpPost = $wpap_client->add_wp_post($postData, $uploaded_image->id))
		{
			throw new Exception('Error occurred while trying to create the wordpress post! Check your post data!');
		}

		// delete the uploaded file
		@unlink(APP_ROOT . '/dist/uploads/' . $fileName);

		$response = [
			'status' => 1,
			'message' => 'Please <a href="'.$wpPost->link.'" target="_blank">click here</a> to see the post.'
		];

	} catch (Exception $e) {
		// error.
		$response = [
			'status' => 0,
			'message' => $e->getMessage()
		];
	}

	// return the response
	header('Content-Type: application/json; charset=utf-8');
	echo json_encode($response);
