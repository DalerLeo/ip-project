<?php 

session_start();


if(!isset($_SESSION['admin_session'])){

	header("Location: admin.html");
}



echo  $_SESSION['admin_session'];
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

    <title>Admin page</title>

    <!-- Bootstrap core CSS -->
    <link href="../libs/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="css/admin.css">
  </head>
  <body>

 <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
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
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#" id="news_btn">News</a></li>
            <li><a href="#" id="doctor_btn">Doctors</a></li>
            <li><a href="#" id="user_btn">Users</a></li>

          </ul>

        </div>
      </div>
    </nav>

	<div class="container" id="news_container">
		<div class="row">
			<button class="btn btn-danger" id="delete_btn">Delete</button>
		</div>
		<div class="row">

			<div class="col-md-12" id="content_container">
				<div class="table-responsive">
	            <table class="table table-striped">
	              <thead>
	                <tr>
	                  <th>#</th>
	                  <th>Title</th>
	                  <th>Content</th>
		                </tr>
	              </thead>
	              <tbody>
	                <tr>
	                  <td>
	                  	<div class="checkbox">
							<label><input type="checkbox" value="">1
							</label>
						</div></td>
	                  <td>1,001</td>
	                  <td>Lorem</td>
	                </tr>
	              </tbody>
	            </table>
	          </div>
			</div>
		</div>
	</div>

    <script src="../libs/js/jquery.js"></script>
    <script src="../libs/js/bootstrap.js"></script>
    <script rel="javascript" src="js/admin.js"></script>
  </body>
</html>



<!-- 
<button type="button" id="bookingBtn" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#bookingModal">
Booking
</button> -->