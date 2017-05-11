<?php 

session_start();


if(!isset($_SESSION['admin_session'])){

	header("Location: admin.html");
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

    <title>Admin page</title>

    <!-- Bootstrap core CSS -->
    <link href="../libs/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="css/style.css">
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
          <a class="navbar-brand" href="#">Admin panel</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-left">
            <li role="presentation" class="active"><a href="#news" id="news_btn" aria-controls="home" role="tab" data-toggle="tab">News</a></li>
            <li role="presentation"><a id="doctors_btn" href="#doctors" aria-controls="doctors" role="tab" data-toggle="tab">Doctors</a></li>
            <li role="presentation"><a href="#users" id="users_btn" aria-controls="messages" role="tab" data-toggle="tab">Users</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
            <li><a href="#" id='sign_out'><span class="glyphicon glyphicon-log-out"></span> Sign out</a>
              </li>  

          </ul>

        </div>
      </div>
    </nav>

	<div class="container">
		<div class="row">
  <!-- Tab panes -->
    <div class="tab-content">
      <div role="tabpanel" class="tab-pane active" id="news">
        <button id="add_news" class="btn btn-success" >Add news</button>
        <button class="btn btn-danger" id="delete_news_btn">Delete</button>
        <div id="news_content"></div>
      </div>
      <div role="tabpanel" class="tab-pane" id="doctors">
        <button class="btn btn-danger" id="delete_docs_btn">Delete</button>
        <div id="docs_content"></div>
      </div>  
      <div role="tabpanel" class="tab-pane" id="users">
        <button class="btn btn-danger" id="delete_users_btn">Delete</button>
        <div id="users_content"></div>
      </div>
    </div>  
  </div>
</div>



    <!-- Modal -->
    <div class="modal fade" id="addNewsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Add news</h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <input type="text" id="news_title" placeholder="Title">
              </div>
            <div class="form-group">  
              <textarea class="form-control" placeholder="Content" id="news_content" rows="10"></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" id="save_news_btn" data-dismiss="modal" class="btn btn-primary" >Save</button>
          </div>
        </div>
      </div>
    </div>


    <script src="../libs/js/jquery.js"></script>
    <script src="../libs/js/bootstrap.js"></script>
    <script rel="javascript" src="js/admin.js"></script>
  </body>
</html>

