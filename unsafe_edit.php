<!-- 
SEED Lab: SQL Injection Education Web plateform
Author: Kailiang Ying
Email: kying@syr.edu
-->

<!DOCTYPE html>
<html>
<body>


<?php
   session_start(); 
   $input_email = $_GET['Email'];
   $input_nickname = $_GET['NickName'];
   $input_address= $_GET['Address'];
   $input_pwd = $_GET['Password']; 
   $input_phonenumber = $_GET['PhoneNumber']; 
   $input_id = $_SESSION['id'];
   $conn = getDB();
  
   // Don't do this, this is not safe against SQL injection attack
   $sql="";
   if($input_pwd!=''){
       $input_pwd = sha1($input_pwd);
       $sql = "UPDATE credential SET nickname=? ,email= ?,address=?,Password=?,PhoneNumber=? where ID=?;";
       $stmt = $conn->prepare($sql);
	$stmt->bind_param("ssssss", $input_nickname, $input_email,$input_address,$input_pwd,$input_phonenumber,$input_id);
	$stmt->execute();
 

        
   }else{
       $sql = "UPDATE credential SET nickname=?,email=?,address=?,PhoneNumber=? where ID=?;";
        $stmt = $conn->prepare($sql);
	$stmt->bind_param("sssss", $input_nickname, $input_email,$input_address,$input_phonenumber,$input_id);
	$stmt->execute();
        
   }
 if ($stmt->errno) {
    echo "FAILURE!!! " . $stmt->error;
    }
   else echo "Updated {$stmt->affected_rows} rows";

   

   $conn->close();    
   //header("Location: unsafe_credential.php");
   exit();

function getDB() {
   $dbhost="localhost";
   $dbuser="root";
   $dbpass="seedubuntu";
   $dbname="Users";


   // Create a DB connection
   $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
   if ($conn->connect_error) {
         die("Connection failed: " . $conn->connect_error . "\n");
   }
return $conn;
}
 
?>

</body>
</html>
