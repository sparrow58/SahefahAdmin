<?php

function __autoload($className) {
    include_once("models/$className.php");
}

//database setup
$users = new User("localhost", "root", "", "sahefah_crud");


$errors         = array();  	// array to hold validation errors
$data           = array(); 		// array to pass back data

// validate the variables ======================================================
	if (empty($_POST['id']))
		$errors['id'] = 'no id found';

//	if (empty($_POST['details']))
//		$errors['details'] = 'Superhero alias is required.';

// return a response ===========================================================

	// response if there are errors
	if ( ! empty($errors)) {

		// if there are items in our errors array, return those errors
		$data['success'] = false;
		$data['errors']  = $errors;
	} else {

		// if there are no errors, return a message
                $id = $_POST['id'];
                
                
                
                $news = array(
                  'id' => $id,
                );
                $users->deleteNews($news);
                
		$data['success'] = true;
		$data['msg'] = 'تم حذف الخبر';
                //$data['message'] = $title;
	}

	// return all our data to an AJAX call
	echo json_encode($data);


