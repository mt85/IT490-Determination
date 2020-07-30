<?php
class Database{
	var $host='database-phonestore.ccodvlh2abh0.us-east-1.rds.amazonaws.com';


	//user was created during database creation and the consequent details
	var $user='admin';
	var $pass='Oldisgold1!';
	var $dbname='phonestore';
	var $conn;



	function __construct(){
		$this->conn=new PDO("mysql:host=".$this->host.";dbname=".$this->dbname,$this->user,$this->pass);
		if($this->conn){
			echo "successful connection";
			return $this->conn;
		}else{
			echo "error connecting to database";
		}
		
	
	}

	//mode to check the requested data from db if it exists
	function fetchAllPhones(){
		$query="SELECT * FROM phones";
		$stmt=$this->conn->prepare($query);
		$stmt->execute();
		$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
		if (count($result)>0) {
			return json_encode($result);
		}else{
			echo "call the API for data";
		}
	}

	//getting a phone that does not exist on db but available on API(by example)

	function getPhoneByCategory($category){
		$query="SELECT * FROM phones WHERE categor=:cat";
		$stmt=$this->conn->prepare($query);
		$stmt->execute(["cat"=>$category]);
		$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
		//a case where there is no such record
		if (count($result)==0) {
			//invoke the API to give you the phone
		}else{
			//return the phone details
			return json_encode($result);
		}
	}

	//create tables on db

	function createExamplDbTables(){
		$query="CREATE TABLE phone(id INTEGER(100) AUTO_INCREMENT PRIMARY KEY,type VARCHAR(50) NOT NULL,model VARCHAR(100) NOT NULL,category VARCHAR(50) NOT NULL)";
		$stmt=$this->conn->prepare($query);
		if($stmt->execute()){
			echo "successful phones table creation";
		}else{
			echo "Failed to create table";
		}
	}
	//dumping the fetched data from API

	function fetchedData($receivedData){
		$query="INSERT INTO phones(ptype,pmodel,pcategory) VALUES(:ptype,:pmodel,:pcategory)";
		$stmt=$this->conn->prepare($query);

		$ptype=$receivedData['ptype'];
		$pmodel=$receivedData['pmodel'];
		$pcategory=$receivedData['pcategory'];

		$res=$stmt->execute(["ptype"=>$ptype,"pmodel"=>$pmodel,"pcategory"=>$pcategory]);
		if($res==true){
			echo "data inserted successfully<br> ".$ptype."<br>".$pmodel."<br>".$pcategory;
		}else{
			echo "failed to insert data";
		}
		
	
	}
	function register($email,$password,$role,$username){
		$query="INSERT INTO users (username,email,password,role) VALUES (:user,:mail,:pass,:role)";

		$stmt=$this->conn->prepare($query);
		$res=$stmt->execute(['user'=>$username,'mail'=>$email,'pass'=>$password,'role'=>$role]);
		if ($res==true) {
			return json_encode({"message":"user registered successfully"});
		}else{
			return json_encode({"error":"user could not be registered"});
		}

	}
	function login($email,$password){
		$query="SELECT * FROM users WHERE email=:memail AND password=:pass";
		$stmt=$this->conn->prepare($query);
		$stmt->execute(['memail'=>$emai,'pass'=>$password]);
		$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
		if(count($result)>0){
			return json_encode($result);
		}
	}

	//close connection
	function closeConnection(){
		$this->conn->close();
	}
}


?>