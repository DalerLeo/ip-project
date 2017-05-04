<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_reg";

try {

    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";

$user_p=$_POST["$user_pas"];
$doc_p=$_POST["$doc_pas"];
$presc=$_POST["$pres"];
$medic=$_POST["$med"];
$date=$_POST["$date_p"];
 

 $sql = " INSERT INTO history (user_pas,doc_pas,prescreption, medicine, date) 
 VALUES ('$user_p','$doc_p','$presc','$medic','$date') ";
    $conn->exec($sql);
	echo "INSERTED";     
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }
?>