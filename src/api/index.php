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
   $count = $stmt->rowCount();
   
   if($row['password']==$user_password){
    
    echo "ok"; // log in
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

$app->run();