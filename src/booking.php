
 <?php

 //RETUN FUnction

try {

$servername = "localhost";
$user = "root";
$password= "";
$db_name= "Records";
$doc= "456";
    $conn = new PDO("mysql:host=$servername;dbname=$db_name", 	
    	$user, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$select= "SELECT Sec1 , Sec2 , Sec3 FROM booking WHERE DocID = '$doc' ";

$section = $conn->prepare($select);
$section->execute(); 
$sl = $section->fetchAll();
 $ret= array();
 $increment=0;

  	 foreach ($sl as $cool) { 
      if($cool['Sec1']!=NULL)
      {
      	$ret[$increment]="Sec1";
      	$increment++;
      }else if($cool['Sec2']!=NULL)
      {
      	$ret[$increment]="Sec2";
      	$increment++;
      }else if($cool['Sec3']!=NULL)
      {
      	$ret[$increment]="Sec3";
      	$increment++;
      }
    }


    for($y=0;$y<$increment;$y++){
    	echo  $cool[$y];
    	echo "      ";
    }
    return (array_values($ret));
echo "Connected Succesfully!!!  ". $increment;
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }
    
    ?> 
 
