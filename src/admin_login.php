<?php
  header("ContentType: application/json ");
 session_start();
 require_once 'dbConfig.php';

  $user_name = trim($_POST['user_name']);
  $user_password = trim($_POST['password']);
  
  try
  { 
  
   $stmt = $db_con->prepare("SELECT * FROM admins WHERE userName='$user_name'");
   
   $stmt->execute();
   $row = $stmt->fetch(PDO::FETCH_ASSOC);
   $count = $stmt->rowCount();
   

   if($row['password']==$user_password){
    
     // log in
    $_SESSION['admin_session'] = $row['userName'];
    echo "ok";
   }
   else{
    
    echo null; // wrong details 
   }
    
  }
  catch(PDOException $e){
   echo $e->getMessage();
  }

?>
