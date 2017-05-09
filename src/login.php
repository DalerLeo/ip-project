<?php
 session_start();
 require_once 'dbConfig.php';

 if(isset($_POST['btn-login']))
 {
  $passport_no = trim($_POST['passport_no']);
  $user_password = trim($_POST['password']);
  
  $password = md5($user_password);
  
  try
  { 
  
   $stmt = $db_con->prepare("SELECT * FROM siteUsers WHERE email=:email");
   $stmt->execute(array(":email"=>$passport_no));
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

?>