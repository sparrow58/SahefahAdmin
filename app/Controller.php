<?php
function __autoload($className){
	include_once("models/$className.php");	
}
//database setup
$users=new User("localhost","root","","sahefah_crud");
//check weather there is a post requist or not


if(!empty($_GET['shareRegId'])) {

    $gcmRegId = $_POST['regId'];
    $test = $users->addGCM($gcmRegId);
    if(!empty($test))
    {
        echo 'OK';
        exit;
    }
}

//wait for a post request that comes from js/custom.js to perform an action
switch(isset($_GET['action']))  {
    case 'get_users'://incase 'get_users' post requist occurse:
		print $users->getUsers();		
	break;
}

switch( isset($_POST['action'])) {
	case 'get_users'://incase 'get_users' post requist occurse:
		print $users->getUsers();		
	break;
	
      
        case 'add_user': //incase 'add_user' post requist occurse:
                   $user = new stdClass; //stdClass is an empty class used when using json enconed/decode  to convert array to object to array
                   $user = json_decode($_POST['user']);
                   print $users->add($user);
                   $gcmRegIds = $users->getGCM();
                   $pushMessage = $user->title; // getting the message from the form
                   if(isset($gcmRegIds) && isset($pushMessage)) {
                        $message = array('message' => $pushMessage); //convert text to array
                        print $users->sendPushNotification($gcmRegIds, $message); // sending push notification to gcmregIds
                    }
        break;
    
        
	
        case 'delete_user':  //incase 'delete_user' post requist occurse:
		$user = new stdClass;
		$user = json_decode($_POST['user']);
		print $users->delete($user);
       
                
       
                
	break;
	
        case 'update_field_data': //incase 'update_field_data' post requist occurse:
		$user = new stdClass;
		$user = json_decode($_POST['user']);
		print $users->updateValue($user);				
	break;
}

exit();