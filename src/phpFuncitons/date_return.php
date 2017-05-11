<?php 


function times($doc)
{
	# code...
}
	include_once('../dbConfig.php');

try {

$select= "SELECT Sec1 , Sec2 , Sec3 , Sec4, Sec6 , Sec7, Sec8 
FROM booking 
WHERE DocID = '$doc' ";

$section = $db_con->prepare($select);
 
$section->execute();
$array = $section->fetch(PDO::FETCH_LAZY);
 
 $i=0;
 $tim=array();
 
	if($array['Sec1']==NULL){
		$tim[$i]= " 9:00 - 10:00";
		$i++;
	}if($array['Sec2']==NULL){
		$tim[$i]= "10:00 - 11:00";
		$i++;
	}if($array['Sec3']==NULL){
		$tim[$i]= "11:00 - 12:00";
		$i++;
	}if($array['Sec4']==NULL){
		$tim[$i]= "12:00 - 13:00";
		$i++;
	}if($array['Sec6']==NULL){
		$tim[$i]= "14:00 - 15:00";
		$i++;
	}if($array['Sec7']==NULL){
		$tim[$i]= "15:00 - 16:00";
		$i++;
	}if($array['Sec8']==NULL){
		$tim[$i]= "16:00 - 17:00";
		$i++;
	}

  	return  json_encode($tim);
}catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }


 ?>