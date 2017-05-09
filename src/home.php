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
    <link rel="stylesheet" type="text/css" href="style.css">
    
  </head>
  <body style="margin-top:30px;">

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
            <li><a href="#">Page 2</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
          <!--  -->
            <li><a data-toggle="modal" data-target="#bookingModal"><span class="glyphicon glyphicon-pencil"></span> Booking</a></li>
            <?php if(isset($_SESSION['user_session'])){ ?>
              <li>
                 <a href="#" id='sign_out'><span class="glyphicon glyphicon-log-out"></span> Sign out</a>
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
    ================================================== -->
    <!-- Wrap the rest of the page in another container to center all the content. -->

      

    
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
                  
                </div>
              </div>
              <div class="item">
                <img src="img/b.jpg" alt="...">
                <div class="carousel-caption">
                  
                </div>
              </div>
              
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
          
              <?php if(isset($_SESSION['user_session'])){ ?>
                
                  <div class="col-md-8" >       
                    <div class="panel-group " id="accordion" role="tablist" aria-multiselectable="true">
                  
                    </div>
                  </div>
                  <div class="col-md-4">
                    <h3>Patients</h3>
                    <table class="table table-striped" >

                      <thead>
                        <tr>
                          <th>Time</th>
                          <th>Name</th>
                          <th>Passport</th>
                        </tr>
                      </thead>
                      <tbody id="patient_table">
                      </tbody>
                    </table>               
                  </div> <!-- ADDITIONAL INFO -->
                  
                <?php }else{ ?>
                  <div class="row" id="news_container">
                  </div>
              <?php } ?>
            </div>
          </div>
        
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
      
         
       <form class="form-signin" method="post" id="login_form">
      
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
            <button type="submit" class="btn btn-primary" name="btn-login" id="btn_login">
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
          <input id="passport" type="text" name="passport" maxlength="9" class="form-control" placeholder="AA1234567">
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
        <h4 class="modal-title" id="myModalLabel">Register an appointment</h4>
      </div>
      <div class="modal-body">
        <div id="bookingError"></div>
        <div class="col-md-4">
          <div class="dropdown">
            <a aria-expanded="false" aria-haspopup="true" role="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle" href="#">
              <span id="selectedDoc">Doctors</span><span class="caret"></span></a>
            <ul class="dropdown-menu" id="doctors">

            </ul>
          </div>
        </div>  
        <div class="col-md-4">
          <div class="dropdown">
            <a aria-expanded="false" aria-haspopup="true" role="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle" href="#">
              <span id="selectedDay">Day</span><span class="caret"></span></a>
            <ul class="dropdown-menu" id="days">

            </ul>
          </div>
        </div>
        <div class="col-md-4">
          <div class="dropdown">
            <a aria-expanded="false" aria-haspopup="true" role="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle" href="#">
              <span id="selectedTime">Time</span><span class="caret"></span></a>
            <ul class="dropdown-menu" id="time">

            </ul>
          </div>
      </div>
    </div>
    <hr>
    <div class="modal-footer">
        <button type="button" id="bookingBtn" class="btn btn-primary">Register reception</button>
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



<!-- 
<button type="button" id="bookingBtn" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#bookingModal">
Booking
</button> -->