<?php
function getDB(){
	global $db;
	if(!isset($db)){
		//DO NOT COMMIT PRIVATE CREDENTIALS TO A REPOSITORY EVER
		$conn_string = "mysql:host=localhost;dbname=IT490";
		$dbusername="root";
		$dbpassword="Oldisgold1!";
		//TODO should pull from config or env variables
try {
		$db = new PDO($conn_string, $dbusername, $dbpassword);
//		 $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);//Suggested to uncomment on production websites
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//Suggested to comment on production websites
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

} catch(PDOException $e) {
	//show error
    echo $e->getMessage();
    exit;
}
	}	
	return $db;
	
}
?>
