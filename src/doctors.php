<?php 

//new
try {

$servername = "localhost";
$user = "root";
$password= "";
$db_name= "Records";
 
    $conn = new PDO("mysql:host=$servername;dbname=$db_name", 	
    	$user, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$select=
 "SELECT DocID, DocWorkField
 	FROM doctors";

$section = $conn->prepare($select);
$section->execute(); 
$SecValues = $section->fetchAll();

    echo json_encode($SecValues);


}catch(PDOException $e){

    echo "Connection failed: " . $e->getMessage();
    }



 ?>