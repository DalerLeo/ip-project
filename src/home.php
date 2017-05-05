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
    
  </head>
<!-- NAVBAR
================================================== -->
  <body>
    <div class="navbar-wrapper">
      <div class="container">

        <nav class="navbar navbar-inverse navbar-static-top">
          <div class="container">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="#">Project name</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
              <ul class="nav navbar-nav">
                <li class="active"><a href="#">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#contact">Contact</a></li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li role="separator" class="divider"></li>
                    <li class="dropdown-header">Nav header</li>
                    <li><a href="#">Separated link</a></li>
                    <li><a href="#">One more separated link</a></li>
                  </ul>
                </li>
                <li>><button type="button" id="signin" class="btn btn-default navbar-btn">Sign in</button></li>
                <li>
                    <button type="button" id="signup" class="btn btn-default navbar-btn">Sign UP</button>
                    </li
              </ul>
            </div>
          </div>
        </nav>

      </div>
    </div>


  
    <!-- Marketing messaging and featurettes
    ================================================== -->
    <!-- Wrap the rest of the page in another container to center all the content. -->

    <div class="container marketing">

      <!-- Three columns of text below the carousel -->
      <div class="row">
        <div class="col-lg-4">
          <img class="img-circle" src="" alt="" width="140" height="140">
          <h2>
            <div>
              <strong>Hello <?php if(isset($_SESSION['user_session'])){echo $row['email'];}else echo "No USER";  ?></strong>  Welcome to the members page.
            </div>
           </h2>
          <p></p>
          
        </div><!-- /.col-lg-4 -->
        <div class="col-lg-4">
          
          <div class="form-group">
            <input id="passport" type="text" class="form-control" placeholder="Passport No">
          </div>
          <div class="form-group">
            <textarea id="pres" type="text" class="form-control" placeholder="Prescription"></textarea>
          </div>
          <div class="form-group">
            <textarea id="medicine" type="text" class="form-control" placeholder="Medicine"></textarea>
          </div>
          <div class="form-group">
            <input id="medicine_sub" type="button" class="form-control" value="Submit">
          </div>


        </div><!-- /.col-lg-4 -->
        <div class="col-lg-4">
          <img class="img-circle" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Generic placeholder image" width="140" height="140">
          <h2>Heading</h2>
          <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
          <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
        </div><!-- /.col-lg-4 -->
      </div><!-- /.row -->


      <!-- START THE FEATURETTES -->

      <hr class="featurette-divider">

      
      
      

      <hr class="featurette-divider">

      <!-- /END THE FEATURETTES -->


      <!-- FOOTER -->
      <footer>
        <p class="pull-right"><a href="#">Back to top</a></p>
        <p>&copy; 2016 Company, Inc. &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a></p>
      </footer>

    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="../libs/js/jquery.js"></script>
    <script src="../libs/js/jquery.validate.js"></script>
    <script>window.jQuery || document.write('<script src="../libs/js/jquery.js"><\/script>')</script>
    <script rel="javascript" src="script.js"></script>
    <script src="../libs/js/bootstrap.js"></script>
    <script src="../libs/js/carousel.js"></script>
  </body>
</html>




