<?php
function register($username, $password,$confirm_password){
	//from dbconnection.php
	try {
	$stmt = getDB()->prepare("SELECT * FROM Users where email = :username LIMIT 1");
        $stmt->execute([":username"=>$username]);       
	$result = $stmt->fetch(PDO::FETCH_ASSOC);

	if(!empty($result) && $password != $confirm_password){
		 return array("status"=>400, "message"=>"Passwords donot match or user already exists");
	}


	else {

	$hash = password_hash($password, PASSWORD_BCRYPT);
	try {
	$stmt1 = getDB()->prepare("INSERT into Users(email,password) values (:email,:password)");
	$stmt1->execute([
		":email" => $username,
		":password" => $hash,
	]);

	if($stmt1) {	
               return array("status"=>200, "message"=>"Registered Successfully!");
      }
	} catch(PDOException $e) {
	
		echo $e->getMessage();
	}
}
} catch(PDOException $e) {
	echo $e->getMessage();
}
	
}

?>
