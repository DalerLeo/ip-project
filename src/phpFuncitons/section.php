
 <?php 


    try {

    $servername = "localhost";
    $user = "root";
    $password= "";
    $db_name= "Records";
    $doc= 'aa123456';
    /*$date = $docDate;*/
        $conn = new PDO("mysql:host=$servername;dbname=$db_name", 	
        	$user, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $select=

     "SELECT Sec1 , Sec2 , Sec3, Sec4, Sec6, Sec7, Sec8
     	FROM booking 
    	WHERE DocID = '$doc' ";

    $section = $conn->prepare($select);
    $section->execute(); 
    $SecValues = $section->fetchAll();
    $ret= array();
     $increment = 0;

         foreach ($SecValues as $cool) { 
      if($cool['Sec1']!=0)
      {
        $ret[$increment]= "Sec1";
        $increment++;
      }else if($cool['Sec2']!=0)
      {
        $ret[$increment]="Sec2";
        $increment++;
      }else if($cool['Sec3']!=0)
      {
        $ret[$increment]="Sec3";
        $increment++;
      }
    }
    echo $increment;

    for($y=0;$y<$increment;$y++){
        echo  $cool[$y];
        echo "      ";
    }

/*
       foreach ($ret as $value) {
              print_r($ret);

       }*/


     
     
    }
    catch(PDOException $e)
        {
        echo "Connection failed: " . $e->getMessage();
        }
        	

    ?> 
 
