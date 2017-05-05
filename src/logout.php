<?php
 session_start();
 unset($_SESSION['user_session']);
 
 if(session_destroy())
 {
  echo 1;
 }
 else{
 	echo 0;
 }
?>