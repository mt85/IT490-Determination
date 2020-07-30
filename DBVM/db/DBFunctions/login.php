i<?php
function login($username, $password){
	//from dbconnection.php
	try {
	$stmt = getDB()->prepare("SELECT * FROM Users where email = :username LIMIT 1");
	$stmt->execute([":username"=>$username]);
	$result = $stmt->fetch(PDO::FETCH_ASSOC);
	//TODO do proper checking, maybe user doesn't exist
	if($result){
		if(password_verify($password, $result["password"])){
	//	if($password == $result["password"]) {
		unset($result["password"]);//never return password, there's no need to
	
		return array("status"=>200, "data"=>$result);
		//send user data back so app can use it
		}
		else{
			//must return proepr message blah blah blah see below
			return array("status"=>403, "message"=>"Password Incorrect");
		}
	}
	else{
		//must return a proper message so that the app can parse it
		//and display a user friendly message to the user
		return array("status"=>400, "message"=>"No User found");
	}
	} catch(PDOException $e) {
	
		echo $e->getMessage();
	}
}
?>
