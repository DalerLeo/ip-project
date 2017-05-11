<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../../vendor/autoload.php';


$app = new \Slim\App;
$app->get('/hello/{name}', function (Request $request, Response $response) {
    $name = $request->getAttribute('name');
    $response->getBody()->write("Hello, $name");

    return $response;

});

$app->post('/booking', function(Request $request, Response $response){

  require_once "../dbConfig.php";

  $data = $request->getParsedBody();

  $userID = filter_var($data['user'], FILTER_SANITIZE_STRING);
  $docID = filter_var($data['doctor'], FILTER_SANITIZE_STRING);
  $secT = filter_var($data['time'], FILTER_SANITIZE_STRING);
  $date = filter_var($data['date'], FILTER_SANITIZE_STRING);

  try{
  $sql= " 
  SELECT $secT 
  FROM booking 
  WHERE DocID = '$docID' ";

  $section = $conn->prepare($sql);
  $section->execute(); 
  $row = $section->fetchAll();
      

   
   if(is_null($row[0][$secT])){
          $update = "UPDATE booking  
          SET $secT = '$userID' 
          WHERE DocID = '$docID' AND Date = '$date'";

          $conn->exec($update);
          echo "\n booked!!!!!";
   }else{
      echo "\n Already reserved!!!!";
   }
   

   if(date("h,a")=="05,pm"){
          $selDoc="SELECT DocID FROM doctors ";
          $section = $conn->prepare($selDoc);
          $section->execute(); 
          $SecValues = $section->fetchAll();
          $c=0;
          foreach ($SecValues as $key) { 
              $c++;
          }
          for($x=0;$x<$c;$x++){
              $ad=strtotime("+7 day");
              $incr = "INSERT INTO booking ( DocID , Date) 
              VALUES ($SecValues[$x]['DocID'],
              date('Y-m-d' , $ad))";
              $conn->exec($incr);
          }
   }


   
  echo "Connected Succesfully!!!";
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
        $tim[$i]= " 9:00 - 10:00";
        $i++;
      }if($row['Sec2']==NULL){
        $tim[$i]= "10:00 - 11:00";
        $i++;
      }if($row['Sec3']==NULL){
        $tim[$i]= "11:00 - 12:00";
        $i++;
      }if($row['Sec4']==NULL){
        $tim[$i]= "12:00 - 13:00";
        $i++;
      }if($row['Sec6']==NULL){
        $tim[$i]= "14:00 - 15:00";
        $i++;
      }if($row['Sec7']==NULL){
        $tim[$i]= "15:00 - 16:00";
        $i++;
      }if($row['Sec8']==NULL){
        $tim[$i]= "16:00 - 17:00";
        $i++;
      }

        return $response->withJson($tim);

    }catch(PDOException $e)
        {
        echo "Connection failed: " . $e->getMessage();
        }

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
/*Checking wheather user with same passpoert No has been registered*/
$app->post('/passport', function (Request $request, Response $response){

    $data = $request->getParsedBody();
    $resp = [];
    $resp['passport'] = filter_var($data['passport'], FILTER_SANITIZE_STRING);
    

    require_once "../dbConfig.php";

    try
      { 

      $passport = $db_con->quote($resp['passport']);
        
      $stmt = $db_con->prepare("SELECT passport FROM siteUsers WHERE passport=$passport");
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

  print(resp['status']);
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

/*        $query = "INSERT INTO siteUsers (first_name, last_name, passport, birth_date, email, phone, job_study, password)
                 VALUES ($first_name, $last_name, $passport, $birth_date, $email, $phone, $job_study, $password) ";
        
        $db_con->exec($query);*/
        return $response->withJson(0);

    }
    catch (PDOException $except) {
        echo $query . $except->getMessage();
    }
    $connect = null;
});


$app->post('/logout', function(Request $request, Response $response){

     session_start();
     unset($_SESSION['user_session']);
     
     if(session_destroy())
     {
        return $response->withJson(1);
     }
     else{
        return $response->withJson(0);
     }

});

$app->post('/signin', function(Request $request, Response $response){

	$data = $request->getParsedBody();

	if(isset($data['user_email']))
 {
  $user_email = trim($data['user_email']);
  $user_password = trim($data['password']);
  
  $password = md5($user_password);
  
  try
  { 
  
  require_once "../dbConfig.php";
   $stmt = $db_con->prepare("SELECT * FROM siteUsers WHERE email=:email");
   $stmt->execute(array(":email"=>$user_email));
   $row = $stmt->fetch(PDO::FETCH_ASSOC);
   
   if($row['password']==$user_password){
    
    echo "ko"; // log in
    $_SESSION['user_session'] = $row['userID'];
   }
   else{
    
    echo "email or password does not exist."; // wrong details 
   }
    
  }
  catch(PDOException $e){
   echo $e->getMessage();
  }
 }


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