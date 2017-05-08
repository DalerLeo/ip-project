<?php
session_start();
include_once 'dbConfig.php';

    if(isset($_SESSION['user_session']))
  {


  $stmt = $db_con->prepare("SELECT * FROM siteUsers WHERE userID=:uid");
  $stmt->execute(array(":uid"=>$_SESSION['user_session']));
  $row=$stmt->fetch(PDO::FETCH_ASSOC);

  }

  

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Hme page</title>

    <!-- Bootstrap core CSS -->
    <link href="../libs/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/simple-sidebar.css">
    <link rel="stylesheet" type="text/css" href="style,css">
    
  </head>
  <body>

<!-- NAVBAR
================================================== -->
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>  

          <a href="#menu-toggle" class="navbar-brand visible-xs " id="menu-toggle"> <span class="glyphicon glyphicon-option-vertical"></span></a>
          <a class="navbar-brand" href="#">WebSiteName</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
            <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Page 1 <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="#">Page 1-1</a></li>
                <li><a href="#">Page 1-2</a></li>
                <li><a href="#">Page 1-3</a></li>
              </ul>
            </li>
            <li><a href="#">Page 2</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
          <li><a data-toggle="modal" data-target="#bookingModal"><span class="glyphicon glyphicon-pencil"></span> Booking</a></li>
            <?php if(isset($_SESSION['user_session'])){ ?>
              <li>
                 <a href="#" id='sign_out'> <?= $row['email']?><span class="glyphicon glyphicon-log-out"></span> Sign out</a>
              </li>  
               <?php } else{?>
              <li>
                  <a data-toggle="modal" data-target="#singinModal"><span class="glyphicon glyphicon-log-in"></span> Sign in</a>
              </li>
          <?php } ?>
            <li><a data-toggle="modal" data-target="#signupModal"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
          </ul>
        </div>  
      </div>
    </nav>
  
    <!-- Marketing messaging and featurettes
    <strong>Hello 
    ================================================== -->
    <!-- Wrap the rest of the page in another container to center all the content. -->
  <div id="wrapper">
        <!-- Sidebar -->
    <div id="sidebar-wrapper">
      <ul class="sidebar-nav">
        <li class="sidebar-brand">
            <a href="#">
                Start Bootstrap
            </a>
        </li>
        <li>
            <a href="#">Dashboard</a>
        </li>
        <li>
            <a href="#">Shortcuts</a>
        </li>
        <li>
            <a href="#">Overview</a>
        </li>
        <li>
            <a href="#">Events</a>
        </li>
        <li>
            <a href="#">About</a>
        </li>
        <li>
            <a href="#">Services</a>
        </li>
        <li>
            <a href="#">Contact</a>
        </li>
      </ul>
    </div>
        <!-- /#sidebar-wrapper -->
        <!-- Page Content -->
    <div id="page-content-wrapper">
      <div class="container">
        <div class="row">
      <!-- CARUSEL+============================= -->   

          <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
          <!-- Indicators -->
            <ol class="carousel-indicators">
              <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
              <li data-target="#carousel-example-generic" data-slide-to="1"></li>
              <li data-target="#carousel-example-generic" data-slide-to="2"></li>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
              <div class="item active">
                <img src="img/a.jpg" alt="...">
                <div class="carousel-caption">
                  ...
                </div>
              </div>
              <div class="item">
                <img src="img/b.jpg" alt="...">
                <div class="carousel-caption">
                  ...
                </div>
              </div>
              ...
            </div>

            <!-- Controls -->
            <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
              <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
              <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>
          </div>
        </div>
<!-- CARUSEL ENDS============================= -->  
        <div class="row">
          <div class="col-md-1"></div> <!-- UNNEEDED SPACE -->
          <div class="col-md-8"> 
            <div class="row"> <!-- NEWS COLUMN -->
              <div class="col-md-6"> 
                
                <h3>Title</h3><br>
 <!--                You have to create some title and little contnet for NEWS SHAXOD
 
 title of the news ==== Lorem ipsum dolor sit amet, consectetur adipiscing elit,
 
 content of it ==== Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.  -->
              </div>

              <div class="col-md-6"> 
                <h3>Title</h3><br>
 <!--                You have to create some title and little contnet for NEWS SHAXOD
 
 title of the news ==== Lorem ipsum dolor sit amet, consectetur adipiscing elit,
 
 content of it ==== Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.  -->
              </div>

              <div class="col-md-6"> 
                <h3>Title</h3><br>
 <!--                You have to create some title and little contnet for NEWS SHAXOD
 
 title of the news ==== Lorem ipsum dolor sit amet, consectetur adipiscing elit,
 
 content of it ==== Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.  -->
              </div>

              <div class="col-md-6"> 
                <h3>Title</h3><br>
 <!--                You have to create some title and little contnet for NEWS SHAXOD
 
 title of the news ==== Lorem ipsum dolor sit amet, consectetur adipiscing elit,
 
 content of it ==== Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.  -->  
              </div>

              <div class="col-md-6"> 
                <h3>Title</h3><br>
 <!--                You have to create some title and little contnet for NEWS SHAXOD
 
 title of the news ==== Lorem ipsum dolor sit amet, consectetur adipiscing elit,
 
 content of it ==== Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.  -->
              </div>

            </div>
          </div>
          <div class="col-md-3">               
            

            
          </div> <!-- ADDITIONAL INFO -->
        </div>
      </div>
    </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->
   




<!-- SIGN IN MODAL -->


<!-- Modal -->
<div class="modal fade" id="singinModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Sign in</h4>
      </div>
      <div class="modal-body">
      
         
       <form class="form-signin" method="post" id="login-form">
      
        <h2 class="form-signin-heading">Log In to WebApp.</h2><hr />
        
        <div id="error">
        <!-- error will be shown here ! -->
        </div>
        
        <div class="form-group">
        <input type="email" class="form-control" placeholder="Email address" name="user_email" id="user_email" />
        <span id="check-e"></span>
        </div>
        
        <div class="form-group">
        <input type="password" class="form-control" placeholder="Password" name="password" id="password" />
        </div>
       
      <hr />
        
        <div class="form-group">
            <button type="submit" class="btn btn-primary" name="btn-login" id="btn-login">
      <span class="glyphicon glyphicon-log-in"></span> &nbsp; Sign In
   </button> 
        </div>  
      
      </form>



      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<!-- SIGN UP MODAL -->


<div class="modal fade" id="signupModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Sign up</h4>
      </div>
      <div class="modal-body">
        
      
        <form id="sign_up_form" action="">
        <div class="form-group">
          <label for="first_name">First name <span></span> </label>
          <input id="first_name" type="text" name="first_name" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="last_name">Last name <span></span> </label>
          <input id="last_name" type="text" name="last_name" class="form-control" pattern="\w+" required>
        </div>
        <div class="form-group">
          <label for="passport">passport <span></span> </label>
          <input id="passport" type="text" name="passport"  class="form-control" placeholder="AA1234567">
        </div>
        <div class="form-group">
          <label for="birth_date">Birth date <span></span> </label>
          <input id="birth_date" placeholder="dd/mm/yyyy" name="birth_date" type="text"  class="form-control">
        </div>
        <div class="form-group">
          <label for="email">Email <span></span> </label>
          <input id="email" type="email" name="email" class="form-control" >
        </div>
        <div class="form-group">
          <label for="phone">phone <span></span> </label>
          <input id="phone" type="text" name="phone" placeholder="998987654321" pattern="\d+"  class="form-control">
        </div>
        <div class="form-group">
          <label for="job_study">job-study place <span></span> </label>
          <input id="job_study" name="job_study" type="text"  class="form-control">
        </div>
        <div class="form-group">
          <label for="password">password <span></span> </label>
          <input id="password" name="password" type="password"  class="form-control">
        </div>
        <div class="form-group">
          <label for="password2">Confirm password <span></span> </label>
          <input id="password2" name="password2" type="password"  class="form-control">
        </div>
        <div class="form-group">
          <input id="sign_up_btn" type="button"  class="form-control" value="Sign up">
        </div>
      </form>



      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

   <!-- BOOKING MODAL -->
   
<!-- Button trigger modal -->


<!-- BOOKING MODAL -->
<div class="modal fade" id="bookingModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
      <div class="dropdown">
  <button id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Doctors
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" aria-labelledby="dLabel">
             <ul class="list-group">
              <li class="list-group-item">Name</li>
              <li class="list-group-item">NAme</li>
              <li class="list-group-item">NAme</li>
              <li class="list-group-item">NAme</li>
             </ul>
  </ul>
</div>
      </div>
        <div class="modal-body">
          <div class="dropdown">
            <button class="btn btn-default dropdown-toggle" type="button" id="timeDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                  time
              <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" id="time_menu" aria-labelledby="timeDropdown">
            </ul>
          </div>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary">Book</button>
      </div>
    </div>
  </div>
</div>
<!-- Button trigger modal -->


    <!-- END BOOKING MODAL  -->








    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="../libs/js/jquery.js"></script>
    <script src="../libs/js/jquery.validate.js"></script>
    <script>window.jQuery || document.write('<script src="../libs/js/jquery.js"><\/script>')</script>
    <script rel="javascript" src="script.js"></script>
    <script src="../libs/js/bootstrap.js"></script>
    <script src="../libs/js/carousel.js"></script>
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });

    </script>
  </body>
</html>




