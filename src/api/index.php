<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../../vendor/autoload.php';


$app = new \Slim\App;


$app->post('/queueing_patients', function(Request $request, Response $response){

  $data = $request->getParsedBody();
  $docID = filter_var($data['docID'], FILTER_SANITIZE_STRING);

  require_once '../dbConfig.php';
  try {

   
  $sql= "SELECT  Sec1, Sec2, Sec3, Sec4, Sec6, Sec7, Sec8 
  FROM booking
  WHERE DocID='$docID'";

  $section = $db_con->prepare($sql);
   
  $section->execute();
  $array = $section->fetch(PDO::FETCH_LAZY);

  $i=0;

  if($array['Sec1']!=NULL){
    $tim[$i]=  $array['Sec1'];
    $i++;
  }if($array['Sec2']!=NULL){
    $tim[$i]=  $array['Sec2'];
    $i++;
  }if($array['Sec3']!=NULL){
    $tim[$i]=  $array['Sec3'];
    $i++;
  }if($array['Sec4']!=NULL){    
    $tim[$i]=  $array['Sec4'];
    $i++;
  }if($array['Sec6']!=NULL){
    $tim[$i]=  $array['Sec6'];
    $i++;
  }if($array['Sec7']!=NULL){
    $tim[$i]=  $array['Sec7'];
    $i++;
  }if($array['Sec8']!=NULL){
    $tim[$i] = $array['Sec8'];
    $i++;
  }

  for($x=0;$x<$i;$x++){
     $z="SELECT first_name , last_name 
     FROM siteUsers 
     WHERE passport= '" . $tim[$x]."'";
      $row = $db_con->prepare($z);
       
      $row->execute();
      $column = $section->fetch(PDO::FETCH_LAZY);

  } 

      print_r($column);
      return $response->withJson($column);

 }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }


});

$app->post('/post_medical_history', function(Request $request, Response $response){

  $data = $request->getParsedBody();

  $user = filter_var($data['userID'], FILTER_SANITIZE_STRING);
  $doc = filter_var($data['docID'], FILTER_SANITIZE_STRING);
  $pres = filter_var($data['prescription'], FILTER_SANITIZE_STRING);
  $med = filter_var($data['medicine'], FILTER_SANITIZE_STRING);
  

  try {

    require_once "../dbConfig.php";

  $date=date('Y-m-h');
 
    $sql1= "SELECT DocWorkField
    FROM doctors
    WHERE DocID='$doc'";

    $section = $db_con->prepare($sql1);
     
    $section->execute();
    $array = $section->fetch(PDO::FETCH_LAZY);
 
    $sql =  
    "INSERT INTO illness_history (userID,DocID , Prescription, Medicine, Date, WorkField) 
    VALUES ('$user', '$doc', '$pres','$med','$date',
    '$array[DocWorkField]')";

    $db_con->exec($sql); 

  return $response->withJson(0);
      }
  catch(PDOException $e)
      {
      echo "Connection failed: " . $e->getMessage();
      }
    
});

$app->post('/get_medical_history', function(Request $request, Response $response){



  $data = $request->getParsedBody();

  $userID = filter_var($data['userID'], FILTER_SANITIZE_STRING);

  require_once "../dbConfig.php";
  
  try{


    $db_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql= "SELECT WorkField, Prescription, Medicine, Date FROM illness_history
    WHERE userID ='$userID' ";

    $section = $db_con->prepare($sql);
    $section->execute(); 
    $sl = $section->fetchAll();

    return $response->withJson($sl);

}
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }

});


$app->post('/booking', function(Request $request, Response $response){

  

  $data = $request->getParsedBody();

  $userID = filter_var($data['user'], FILTER_SANITIZE_STRING);
  $docID = filter_var($data['doctor'], FILTER_SANITIZE_STRING);
  $time = filter_var($data['time'], FILTER_SANITIZE_STRING);
  $date = filter_var($data['day'], FILTER_SANITIZE_STRING);
echo $time;
echo $docID;
echo $userID;
$convert= array("9:00"=>"Sec1", "10:00"=>"Sec2", "11:00"=>"Sec3",
 "12:00"=>"Sec4", "14:00"=>"Sec6", "15:00"=>"Sec7","16:00"=>"Sec8");


$secT = $convert[$time];

printf($secT);

require_once "../dbConfig.php";

  try{
  $sql= " 
  SELECT $secT 
  FROM booking 
  WHERE DocID = '$docID' ";

  $section = $db_con->prepare($sql);
  $section->execute(); 
  $row = $section->fetch(PDO::FETCH_LAZY);
      

   
   if(is_null($row[$secT])){
          $update = "UPDATE booking  
          SET $secT = '$userID' 
          WHERE DocID = '$docID' AND Date = '$date'";

          $db_con->exec($update);
          echo "\n booked";
   }else{
      echo "\n Already reserved!!!!";
   }
   
/*"*/

      }
  catch(PDOException $e)
      {
      echo "Connection failed: " . $e->getMessage();
      }
    
});

$app->post('/get_free_time', function(Request $request, Response $response){


    $data = $request->getParsedBody();


    $date = filter_var($data['date'], FILTER_SANITIZE_STRING);
    require_once('../dbConfig.php');

   try {

    $doc = $data['docID'];
    $select= "SELECT Sec1 , Sec2 , Sec3 , Sec4, Sec6 , Sec7, Sec8 
    FROM booking 
    WHERE DocID = '$doc' AND Date = '$date' ";

    $section = $db_con->prepare($select);
     
    $section->execute();
   
    $row = $section->fetch(PDO::FETCH_LAZY);
     $i=0;
     $tim=array();
     
      if($row['Sec1']==NULL){
        $tim[$i]= " 9:00";
        $i++;
      }if($row['Sec2']==NULL){
        $tim[$i]= "10:00";
        $i++;
      }if($row['Sec3']==NULL){
        $tim[$i]= "11:00";
        $i++;
      }if($row['Sec4']==NULL){
        $tim[$i]= "12:00";
        $i++;
      }if($row['Sec6']==NULL){
        $tim[$i]= "14:00";
        $i++;
      }if($row['Sec7']==NULL){
        $tim[$i]= "15:00";
        $i++;
      }if($row['Sec8']==NULL){
        $tim[$i]= "16:00";
        $i++;
      }

        return $response->withJson($tim);

    }catch(PDOException $e)
        {
        echo "Connection failed: " . $e->getMessage();
        }

  });

$app->post('/get_users', function(Request $request, Response $response){

  require_once "../dbConfig.php";
  try {

$query = "SELECT first_name, email, last_name, phone, birth_date, passport, job_study FROM siteUsers";
        $stmt = $db_con->prepare($query);
        $stmt->execute();
        $users_row = $stmt->fetchAll();
        


        return $response->withJson($users_row);
    }
    catch (PDOException $except) {
        echo  $except->getMessage();
    }
    $connect = null;


});

$app->post('/get_doctors', function(Request $request, Response $response){

    require_once "../dbConfig.php";
    try {


        $stmt = $db_con->prepare("SELECT * FROM doctors");
        $stmt->execute();
        $news_row = $stmt->fetchAll();
        $results = array();


        return $response->withJson($news_row);
    }
    catch (PDOException $except) {
        echo  $except->getMessage();
    }
    $connect = null;


});

$app->post('/delete_user', function(Request $request, Response $response){

  $data = $request->getParsedBody();
  $id = filter_var($data['id'], FILTER_SANITIZE_STRING);

  require_once "../dbConfig.php";

  try {
    
      $query = "DELETE FROM siteUsers WHERE passport= '$id'";

      $db_con->exec($query);
      return $response->withJson(0);

  } catch (PDOException $e) {
      echo $query . $e->getMessage();
  }

});

$app->post('/delete_doc', function(Request $request, Response $response){

  $data = $request->getParsedBody();
  $id = filter_var($data['id'], FILTER_SANITIZE_STRING);

  require_once "../dbConfig.php";

  try {
    
      $query = "DELETE FROM doctors WHERE DocID= '$id'";

      $db_con->exec($query);
      return $response->withJson(0);

  } catch (PDOException $e) {
      echo $query . $e->getMessage();
  }

});

$app->post('/delete_news', function(Request $request, Response $response){

  $data = $request->getParsedBody();
  $id = filter_var($data['id'], FILTER_SANITIZE_STRING);

  require_once "../dbConfig.php";

  try {
    
      $query = "DELETE FROM News WHERE id= '$id'";

      $db_con->exec($query);
      return $response->withJson(0);

  } catch (PDOException $e) {
      echo $query . $e->getMessage();
  }

});

/*ADD NEWS TO DATA BASE*/
$app->post('/save_news', function(Request $request, Response $response){

  $data = $request->getParsedBody();
  $resp = [];

  $title = filter_var($data['title'], FILTER_SANITIZE_STRING);
  $content = filter_var($data['content'], FILTER_SANITIZE_STRING);

  //print_r($data);

  require_once '../dbConfig.php';

  try {
    $query = "INSERT INTO News( title, content) VALUES ('$title', '$content')";

    $db_con->exec($query);
    return $response->withJson(0);

  } catch (PDOException $except) {
    echo $query . $except->getMessage();
  }

});
/*Checking wheather user with same passport No has been registered*/
$app->post('/passport', function (Request $request, Response $response){

    $data = $request->getParsedBody();
    $status = filter_var($data['status'], FILTER_SANITIZE_STRING);
    $passport = filter_var($data['passport'], FILTER_SANITIZE_STRING);
    
    require_once "../dbConfig.php";

    try
      { 

      $passport = $db_con->quote($passport);
        
      if(!$status){  
        $stmt = $db_con->prepare("SELECT passport FROM siteUsers WHERE passport=$passport");
      }
      else{
          $stmt = $db_con->prepare("SELECT DocID FROM doctors WHERE DocID=$passport"); 
      }
      $stmt->execute();
      

      $data = $stmt->fetchAll();
      if(empty($data)){
        return $response->withJson(0);
      }
      else{
        return $response->withJson("already registered");
      }

      }
      catch(PDOException $e){
       echo $e->getMessage();
      }

});

$app->post('/signup', function(Request $request, Response $response){

  $data = $request->getParsedBody();
  $resp = [];
  $resp['first_name'] = filter_var($data['first_name'], FILTER_SANITIZE_STRING);
  $resp['last_name'] = filter_var($data['last_name'], FILTER_SANITIZE_STRING);
  $resp['passport'] = filter_var($data['passport'], FILTER_SANITIZE_STRING);
  $resp['birth_date'] = filter_var($data['birth_date'], FILTER_SANITIZE_STRING);
  $resp['email'] = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
  $resp['phone'] = filter_var($data['phone'], FILTER_SANITIZE_STRING);
  $resp['job_study'] = filter_var($data['job_study'], FILTER_SANITIZE_STRING);
  $resp['password'] = filter_var($data['password'], FILTER_SANITIZE_STRING);
  $resp['status'] = filter_var($data['status'], FILTER_SANITIZE_STRING);
  $resp['position'] = filter_var($data['position'], FILTER_SANITIZE_STRING);


  require_once "../dbConfig.php";

  try {

        $first_name = $db_con->quote($resp['first_name']);
        $last_name = $db_con->quote($resp['last_name']);
        $passport = $db_con->quote($resp['passport']);
        $birth_date = $db_con->quote($resp['birth_date']);
        $email = $db_con->quote($resp['email']);
        $phone = $db_con->quote($resp['phone']);
        $job_study = $db_con->quote($resp['job_study']);
        $password = $db_con->quote($resp['password']);


        if($resp['status']){
          $position = $db_con->quote($resp['position']);

                  $query = "INSERT INTO doctors (DocID, DocName, DocSurname, DocEmail, DocPassword, DocPhone, DocBirth, DocWorkField)
                 VALUES ($passport, $first_name, $last_name, $email, $password, $phone, $birth_date, $position) ";

        }
        else if(!$resp['status']){

                    $query = "INSERT INTO siteUsers (first_name, last_name, passport, birth_date, email, phone, job_study, password)
                 VALUES ($first_name, $last_name, $passport, $birth_date, $email, $phone, $job_study, $password) ";

        }


        
        $db_con->exec($query);
        return $response->withJson(0);

    }
    catch (PDOException $except) {
        echo $query . $except->getMessage();
    }
    $connect = null;
});


$app->get('/news', function(Request $request, Response $response){

  require_once "../dbConfig.php";


  try
      { 

      $stmt = $db_con->prepare("SELECT * FROM News");
      $stmt->execute();
      
      $data = $stmt->fetchAll();
      
      return $response->withJson($data); 
  }
  catch(PDOException $e){
      echo $e->getMessage();
  }

});

$app->run();