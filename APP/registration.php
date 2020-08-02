<?php
function register($db, $email, $password, $isPlainText = false){
	if($isPlainText){
		$password = password_hash($password, PASSWORD_BCRYPT);
	}
	if(strlen($password) != 60){
		$password = password_hash($password, PASSWORD_BCRYPT);
	}
	if(isset($db)){
		$stmt = $db->prepare("INSERT INTO Users (email, password) VALUES (:email, :password)");
		$r = $stmt->execute(array(":email" => $email, ":pass" => pass));
		$ei = $stmt->errorInfo();
		if($ei[0] == '00000'){
			return array("status"=>"success","added $r user");
		}
		else{
			return array("status"=>"error", "message"=>var_export($ei, true));
		}
	}
	else{
		return array("status"=>"error", "message"=>"Please try again.");
	}
}
?>