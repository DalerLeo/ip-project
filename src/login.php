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
  
  if (isset($_POST['docCheck'])) {
    
  
   $stmt = $db_con->prepare("SELECT * FROM doctors WHERE DocID=:DocID");
   $stmt->execute(array(":DocID"=>$passport_no));
   $row = $stmt->fetch(PDO::FETCH_ASSOC);
   $count = $stmt->rowCount();

   if($row['DocPassword']==$user_password){
    
    echo "ok"; // log in
    $_SESSION['doc_session'] = $row['DocID'];

   }
   else{
    
    echo "Doc or password does not exist."; // wrong details 
   }
 }
 else{
  $stmt = $db_con->prepare("SELECT * FROM siteUsers WHERE passport=:passport");
  $stmt->execute(array(":passport"=>$passport_no));
   $row = $stmt->fetch(PDO::FETCH_ASSOC);
   $count = $stmt->rowCount();
   
   if($row['password']==$user_password){
    
    echo "ok"; // log in
    $_SESSION['user_session'] = $row['passport'];
   }
   else{
    
    echo "email or password does not exist."; // wrong details 
   }
 }

   
    
  }
  catch(PDOException $e){
   echo $e->getMessage();
  }
 }

?>