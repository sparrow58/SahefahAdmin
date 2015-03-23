<?php
function __autoload($className){
	include_once("models/$className.php");	
}
//database setup
$users=new User("localhost","root","","sahefah_crud");
//check weather there is a post requist or not


		print $users->getNews3();
