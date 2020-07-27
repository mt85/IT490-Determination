<?php
    require_once('path.inc');
    require_once('get_host_info.inc');
    require_once('rabbitMQlib.inc');
    require_once('MQClient.php');
    require_once('DBConnect.php');
    function register($email, $role, $usname, $psword){
        $db = connect();
        $psword = password_hash($psword, PASSWORD_BCRYPT);
        $query = "INSERT INTO 'users'('email', 'password', 'role', 'date_created', 'date_modified', 'username') VALUES ($email, $psword, $role, date(\"Y/m/d\"), date(\"Y/m/d\"), $usname)";
        return mysqli_query($db, $query);
    };
    function log_in($usname, $psword){
        $db = connect();
        $query = "SELECT 'password' FROM 'users' WHERE 'username' = '$usname'";
        $response = mysqli_query($db, $query);
        $responseArray = $response -> fetch_assoc();
        $numRows =  mysqli_num_rows($response);
        if(numRows>0){
            if(password_verify($psword, $responseArray['password'])){
                return True;
            }
            else{
                return False;
            }
        }
        else{
            return False;
        }
    }