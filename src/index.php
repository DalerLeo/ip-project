<?php
session_start();
include_once 'dbConfig.php';

/*require_once('phpFuncitons/date_return.php');*/



    if(isset($_SESSION['user_session']))
  {

  $stmt = $db_con->prepare("SELECT * FROM siteUsers WHERE passport=:uid");
  $stmt->execute(array(":uid"=>$_SESSION['user_session']));
  $row=$stmt->fetch(PDO::FETCH_ASSOC);
  }
  else if(isset($_SESSION['doc_session'])){
      $stmt = $db_con->prepare("SELECT * FROM doctors WHERE DocID=:uid");
  $stmt->execute(array(":uid"=>$_SESSION['doc_session']));
  $row=$stmt->fetch(PDO::FETCH_ASSOC);




  }


function show_date(){

 for($x=1;$x<8;$x++){
    $add = strtotime('+'. $x . ' day');
    echo "<option>" . date('Y-m-d' , $add) . "</option>";
    }


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
    <link rel="icon" href="img/favicon.ico">
    <title>My Doctor</title>

    <!-- Bootstrap core CSS -->
    <link href="../libs/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    
  </head>
  <body style="margin-top:30px;">

<!-- NAVBAR
================================================== -->
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>  

          <a class="navbar-brand" href="#">
          <img src="img/logolast.png" alt="">
<!--              <img src="http://placehold.it/150x50&text=Logo" alt=""> -->
          </a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <li class="active"><a href="/">Home</a></li>
            
          </ul>
          <ul class="nav navbar-nav navbar-right">
          <!--  -->
            <li><a data-toggle="modal"  id="booking_btn"><span class="glyphicon glyphicon-pencil"></span> Booking</a></li>
            <?php if(isset($_SESSION['user_session']) || isset($_SESSION['doc_session'])) {  ?>
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
                <img class="img-responsive" src="img/a.jpg" style="width:100%;" alt="...">
                <div class="carousel-caption">
                  
                </div>
              </div>
              <div class="item">
                <img class="img-responsive" src="img/b.jpg" style="width:100% " alt="...">
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
              <?php if(isset($_SESSION['doc_session'])){ ?>
                <nav class="container-fluid navbar-inverse" style="margin-top:20px;">
                      <h3 style="color:white!important"><span id="doc_work_field"><?=$row['DocWorkField']; ?></span> Dr. <?php print($row['DocName']); ?> <span id="docID" class='sr-only' ><?=$row['DocID']; ?></span> </h3>
                    </nav>
                  <div class="col-md-8" >       
                      <div id="accor1"></div>
                    
                    <div class="panel-footer">
                        <label for="prescription">Prescription</label> 
                        <textarea id="prescription" name="prescription" class="form-control" rows="5"></textarea>
                        <label for="medicine">Medicine</label>
                        <textarea name="medicine" id="medicine" class="form-control"  rows="3"></textarea>
                        <button class="right btn btn-success" id='docSubmit'> Submit</button>
                      </div>
                  </div>
                  <div class="col-md-4">
                    <h3>Patients <span id="insert_patient"><span></h3>
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
                  
                <?php }else if(isset($_SESSION['user_session'])){ ?>


                    <nav class="container-fluid navbar-inverse" style="margin-top:20px;">
                      <h3 style="color:white!important"><?= $row['first_name'] . " " . $row['last_name']; ?> </h3>
                      <div class="sr-only" id="userID" ><?= $row['passport']; ?></div>
                    </nav>

                    <div class="col-md-12" >       

                      <div id="accor1">
                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                      <div class="panel panel-success">
                        <div class="panel-heading" role="tab" id="">
                          <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#Dentist" aria-expanded="true" aria-controls="Dentist">
                              Dentist
                            </a>
                          </h4>
                        </div>
                        <div id="Dentist" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                          
                        </div>
                      </div>
                    </div>
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                      <div class="panel panel-success">
                        <div class="panel-heading" role="tab" id="">
                          <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#Surgeon" aria-expanded="true" aria-controls="Surgeon">
                              Surgeon
                            </a>
                          </h4>
                        </div>
                        <div id="Surgeon" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                          
                        </div>
                      </div>
                    </div>
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                      <div class="panel panel-success">
                        <div class="panel-heading" role="tab" id="">
                          <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#Pediatrician" aria-expanded="true" aria-controls="Pediatrician">
                              Pediatrician
                            </a>
                          </h4>
                        </div>
                        <div id="Pediatrician" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                          
                        </div>
                      </div>
                    </div>
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                      <div class="panel panel-success">
                        <div class="panel-heading" role="tab" id="">
                          <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#Cardiologist" aria-expanded="true" aria-controls="Cardiologist">
                              Cardiologist
                            </a>
                          </h4>
                        </div>
                        <div id="Cardiologist" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                          
                        </div>
                      </div>
                    </div>
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                      <div class="panel panel-success">
                        <div class="panel-heading" role="tab" id="">
                          <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#Gynecologist" aria-expanded="true" aria-controls="Gynecologist">
                              Gynecologist
                            </a>
                          </h4>
                        </div>
                        <div id="Gynecologist" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                          
                        </div>
                      </div>
                    </div>'
                      </div>
                  </div>

                <?php }else{  ?>
                  <div class="row" id="news_container">
                    <nav class="container-fluid navbar-inverse" style="margin-top:20px;">
                      <h3 style="color:white!important">News</h3>
                    </nav>
                  </div>
                <?php } ?>  
            </div>
          </div>
        
<!-- SIGN IN MODAL -->

<div class="modal fade" id="singinModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2 class="modal-title" id="myModalLabel">Sign in</h2>
      </div>
      <div class="modal-body">
      
         
       <form class="form-signin" method="post" id="login_form">
        
        <div id="error">
        <!-- error will be shown here ! -->
        </div>
        
        <div class="form-group">
        <input type="text" class="form-control" placeholder="Passport No" name="passport_no" id="passport_no" />
        <span id="check-e"></span>
        </div>
        <div class="form-group">
          
          <input type="checkbox" name="docCheck" id="status"> 
          <label for="status">Doctor?</label>
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
          <input name="status" id="status" type="hidden" value="0" />
          <input id="status" name="status" data-toggle='collapse' data-target='#position' type="checkbox" value="1">
          <label for="status"> Doctor?<span></span> </label>
          
            <div id="position" class="collapse">
              <div class="form-group">
                <label for="sel1">Select position</label>
                <select class="form-control" id="sel1">
                  <option>Dentist</option>
                  <option>Surgeon</option>
                  <option>Pediatrician</option>
                  <option>Gynecologist</option>
                  <option>Dermatologist</option>
                  <option>Cardiologist</option>
                </select>
              </div>
            </div>
        </div>
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
          <label for="password1">password <span></span> </label>
          <input id="password1" name="password1" type="password"  class="form-control">
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
    </div>
  </div>
</div>

   <!-- BOOKING MODAL -->
   

<!-- SUCCESS MODAL -->

<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2 class="modal-title" id="myModalLabel"><div class="success alert-success"> <span class="glyphicon glyphicon-info-sign"></span> Successfully registered !</div></h2>
      </div>
      <div class="modal-body">
        
      </div>

    </div>
  </div>
</div><!-- SUCCESS MODAL -->


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
          <div class="dropdown" id="doc_drop">
            <div class="form-group" >
              <label for="doc_list">Doctors</label>
              <select class="form-control" id="doc_list">
                <option>------</option>>
              </select>
            </div>
          </div>
        </div>  
        <div class="col-md-4">
          <div class="dropdown">
            <div class="form-group" id="day_drop" >
              <label for="day_list">Date</label>
              <select class="form-control" id="day_list">
                <option>------</option>
                <?php show_date(); ?>
              </select>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="dropdown">
            <div class="form-group" id="time_drop" >
              <label for="sel1">Time:</label>
              <select class="form-control" id="time_list">
              <option>------</option>
                
              </select>
            </div>
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


    <!-- END BOOKING MODAL  -->

  <footer class="container-fluid">
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <p>ShAHD Medical center</p>
          <p>Office : 9, Ziyolilar str., M.Ulugbek district, Tashkent city</p>
          
          
        </div>  
        <div class="col-md-4">
          <p>Phone : +998 71 289-99-99</p>

          <p>Email : info@mycare.uz</p>
        </div>
        <div class="col-md-4">
          Copyright 2017 by ShAHD team. All Rights Reserved.

        </div>
      </div>
    </div>
  </footer>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="../libs/js/jquery.js"></script>
    <script src="../libs/js/jquery.validate.js"></script>
    <script>window.jQuery || document.write('<script src="../libs/js/jquery.js"><\/script>')</script>
    <script rel="javascript" src="js/script.js"></script>
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