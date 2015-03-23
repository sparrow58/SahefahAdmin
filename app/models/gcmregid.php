<?php
//This is the model that make the communication through the database
class User {
	
	private $dbh;
	//PDO database initialazation
	public function __construct($host,$user,$pass,$db)	{		
		$this->dbh = new PDO("mysql:host=".$host.";dbname=".$db,$user,$pass);		
	}
        // function to display all the users
	public function getUsers(){				
		$sth = $this->dbh->prepare("SELECT * FROM users ORDER BY id DESC");
		$result = $sth->execute();
                $rows = $sth->fetchAll();
                if ($rows) {
                    $response["success"] = 1;
                    $response["message"] = "Post Available!";
                    $response["posts"]   = array();

                    foreach ($rows as $row) {
                        $post             = array();
                        $post["id"]  = $row["id"];
                        $post["name"] = $row["name"];
                        $post["email"]    = $row["email"];
                        //$post["mobile"]  = $row["mobile"];
                        $post["address"]  = $row["address"];


                        //update our repsonse JSON data
                        array_push($response["posts"], $post);
                    }

                    // echoing JSON response
                    return json_encode($response);


                } else {
                    $response["success"] = 0;
                    $response["message"] = "No Post Available!";
                    return json_encode($response);
                }
                
		//return json_encode($sth->fetchAll());//fetching data through json data intermediary
	}
        //function for adding user to the database
	public function add($user){		
		$sth = $this->dbh->prepare("INSERT INTO users(name,email , address) VALUES (?, ? , ?)");
		$sth->execute(array($user->name,$user->email, $user->address));		
		return json_encode($this->dbh->lastInsertId());
	}
	//function to delete user from the database
	public function delete($user){				
		$sth = $this->dbh->prepare("DELETE FROM users WHERE id=?");
		$sth->execute(array($user->id));
		return json_encode(1);
	}
	//function to update user to the database
	public function updateValue($user){		
		$sth = $this->dbh->prepare("UPDATE users SET ". $user->field ."=? WHERE id=?");
		$sth->execute(array($user->newvalue, $user->id));				
		return json_encode(1);	
	}
}
?>