<?php
//This is the model that make the communication through the database
class User {
	
	private $dbh;
	//PDO database initialazation
	public function __construct($host,$user,$pass,$db)	{		
		$this->dbh = new PDO("mysql:host=".$host.";dbname=".$db,$user,$pass);		
	}
       
        function sendPushNotification($registration_ids, $message) {

            $url = 'https://android.googleapis.com/gcm/send';
            $fields = array(
                'registration_ids' => $registration_ids,
                'data' => $message,
            );

            define('GOOGLE_API_KEY', 'AIzaSyCIqpe9NaJwLU4JYX9GPgr2JPdPReIkHsA');

            $headers = array(
                'Authorization:key=' . GOOGLE_API_KEY,
                'Content-Type: application/json'
            );
            echo json_encode($fields);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

            $result = curl_exec($ch);
            if($result === false)
                die('Curl failed ' . curl_error());

            curl_close($ch);
            return $result;

        }

         public function getGCM(){				
		$sth = $this->dbh->prepare("SELECT regId FROM gcm");
		$result = $sth->execute(); 
                $rows = $sth->fetchAll();
                $gcmRegIds = array(); 
                foreach ($rows as $row) {
                    $query_row = array();
                    $query_row =  $row["regId"];
                    array_push($gcmRegIds, $query_row);
                }
                return $gcmRegIds;
        }
        public function addGCM($regId){
            $sth = $this->dbh->prepare("INSERT INTO gcm(regId) VALUES (?)");      
		$sth->execute(array($regId));
		return json_encode($this->dbh->lastInsertId());
        }


        //function to display all the news
	public function getUsers(){				
		$sth = $this->dbh->prepare("SELECT * FROM news ORDER BY id DESC LIMIT 30");
		$result = $sth->execute();
                $rows = $sth->fetchAll();
                if ($rows) {
                    $response["success"] = 1;
                    $response["message"] = "Post Available!";
                    $response["posts"]   = array();

                    foreach ($rows as $row) {
                        $post             = array();
                        $post["id"]  = $row["id"];
                        $post["title"] = $row["title"];
                        $post["date"]    = $row["date"];
                        //$post["mobile"]  = $row["mobile"];
                        $post["details"]  = $row["details"]; 
                        $post["status"]  = $row["syncsts"]; 


                        //update our repsonse JSON data
                        array_push($response["posts"], $post);
                    }
                    return json_encode($response);
                } else {
                    $response["success"] = 0;
                    $response["message"] = "No Post Available!";
                    return json_encode($response);  
                }              		
	}
        
        //function to display all the news
	public function getNews3(){				
		$sth = $this->dbh->prepare("SELECT * FROM news ORDER BY id DESC LIMIT 30");
		$result = $sth->execute();
                $rows = $sth->fetchAll();
                if ($rows) {
                  

                    foreach ($rows as $row) {
                        $post             = array();
                        $post["id"]  = $row["id"];
                        $post["title"] = $row["title"];
                        $post["date"]    = $row["date"];
                        
                        $post["details"]  = $row["details"]; 
                        $post["status"]  = $row["syncsts"]; 


                        //update our repsonse JSON data
                        array_push($rows, $post);
                    }
                    return json_encode($rows);
                } else {
                    $response["success"] = 0;
                    $response["message"] = "No Post Available!";
                    return json_encode($response);  
                }              		
	}
        
        
        
        public function getunSyncNews(){				
		$sth = $this->dbh->prepare("SELECT * FROM news WHERE syncsts = FALSE ORDER BY id DESC LIMIT 30");
		$result = $sth->execute();
                $rows = $sth->fetchAll();
                if ($rows) {
                    $response["success"] = 1;
                    $response["message"] = "Post Available!";
                    $response["posts"]   = array();

                    foreach ($rows as $row) {
                        $post             = array();
                        $post["id"]  = $row["id"];
                        $post["title"] = $row["title"];
                        $post["date"]    = $row["date"];
                        //$post["mobile"]  = $row["mobile"];
                        $post["details"]  = $row["details"]; 
                        $post["status"]  = $row["syncsts"]; 


                        //update our repsonse JSON data
                        array_push($response["posts"], $post);
                    }
                    return json_encode($response);
                } else {
                    $response["success"] = 0;
                    $response["message"] = "No Post Available!";
                    return json_encode($response);  
                }              		
	}
        //function for adding user to the database
	public function add($news){		
               
		$sth = $this->dbh->prepare("INSERT INTO news(title,details) VALUES (?, ? )");
		$sth->execute(array($news->title,$news->details ));
                
		//return json_encode($this->dbh->lastInsertId());
//                $response["success"] = 1;
//                $response["message"] = "Added";
                
                $data['success'] = true;
                $data['message'] = 'تمت اضافة الخبر';
              
	}
        public function addNews($news){
                $sth = $this->dbh->prepare("INSERT INTO news (title,date,details) VALUES (?,?, ? )");
                
		$sth->execute(array($news['title'],$news['date'],$news['details'] ));
        }
	//function to delete user from the database
	public function delete($user){				
		$sth = $this->dbh->prepare("DELETE FROM news WHERE id=?");
		$sth->execute(array($user->id));
		return json_encode(1);
	}
        public function deleteNews($news){				
		$sth = $this->dbh->prepare("DELETE FROM news WHERE id=?");
		$sth->execute(array($news['id']));
		return json_encode(1);
	}
	//function to update user to the database
	public function updateValue($user){		
		$sth = $this->dbh->prepare("UPDATE news SET ". $user->field ."=? WHERE id=?");
		$sth->execute(array($user->newvalue, $user->id));				
		return json_encode(1);	
	}
        public function updateSyncSts($id, $sts){		
		$sth = $this->dbh->prepare("UPDATE news SET syncsts =? WHERE id =?");
		$sth->execute(array($sts,$id));				
		return json_encode(1);
	}
        
        
}
?>