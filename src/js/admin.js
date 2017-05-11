$("document").ready(function() {
  
 news_fill();
  $("#news_btn").on('click', news_fill);
  

  function news_fill() {
    
    $("#news_content").html(
          '<div class="table-responsive">\
              <table class="table table-striped">\
                <thead>\
                  <tr>\
                    <th>#</th>\
                    <th>Title</th>\
                    <th>Content</th>\
                    </tr>\
                </thead>\
                <tbody id="news_table_body">\
                </tbody\
              </table>\
            </div>');

    $.post("getNews.php", function(response){
      
      $.each(JSON.parse(response), function(i, val) {

        $("#news_table_body").append(
          '<tr>\
              <td>\
                <div class="checkbox">\
                  <label><input type="checkbox" value="'+val.id+'"></label>\
                </div>\
              </td>\
              <td>'+val.title+'</td>\
              <td>'+val.content+'</td>\
            </tr>');
      });

    });

  }


  $("#sign_out").click(function(){

//    window.location.href = "register.html";

    $.post('logout.php', function(resp) {
 
      if(resp){
        alert("BYE BYE ;)");
        window.location.href = "admin.html";
      }
      else{
        alert("ERROR");
      }
    })

  });


  $("#delete_docs_btn").click(function(event) {
      
    var i =$("#docs_content input:checked").length;
    if(i>1){
      alert("You can choose only one doctor");
    }
    else if(i==0){
      alert("Please, choose a doctor");
    }
    else{
      var id = $("input:checked").val();


      $.post('api/delete_doc', {id: id }, function(response) {
    
      });
    }  

  });

  $("#delete_users_btn").click(function() {
    var i =$("#users_content input:checked").length;
    if(i>1){
      alert("You can choose only single user");
    }
    else if(i==0){
      alert("Please, choose user to delete");
    }
    else{
      var id = $("input:checked").val();


      $.post('api/delete_user', {id: id }, function(response) {
    
      });
    }

  });

  $("#delete_news_btn").click(function(event) {
    var i =$("input:checked").length;
    if(i>1){
      alert("You can choose only one news");
    }
    else{
      var id = $("input:checked").val();


      $.post('api/delete_news', {id: id }, function(response) {
          news_fill();
      });
    }  
  });


  /*Filling Users Table and pane*/
  $("#users_btn").click(function(event) {
    
    $("#users_content").html(
          '<div class="table-responsive">\
              <table class="table table-striped">\
                <thead>\
                  <tr>\
                    <th>#</th>\
                    <th>Name</th>\
                    <th>Last name</th>\
                    <th>Email</th>\
                    <th>Phone No</th>\
                    <th>Birth date</th>\
                    </tr>\
                </thead>\
                <tbody id="users_table_body">\
                </tbody\
              </table>\
            </div>');

    $.post('api/get_users', function(resp) {

        $.each(resp, function(i, val) {

        $("#users_table_body").append(
          '<tr>\
              <td>\
                <div class="checkbox">\
                  <label><input type="checkbox" value="'+val.passport+'"></label>\
                </div>\
              </td>\
              <td>'+val.first_name+'</td>\
              <td>'+val.last_name+'</td>\
              <td>'+val.email+'</td>\
              <td>'+val.phone+'</td>\
              <td>'+val.birth_date+'</td>\
            </tr>');
      });

    });

  });

  /*END OF Filling Users Table and pane*/


/*FILLING DOCTOR TABLE WHEN DOCTORS BUTTON CLICKED*/
  $("#doctors_btn").click(function() {
      
          $("#docs_content").html(
          '<div class="table-responsive">\
              <table class="table table-striped">\
                <thead>\
                  <tr>\
                    <th>#</th>\
                    <th>Name</th>\
                    <th>Last name</th>\
                    <th>Email</th>\
                    <th>Phone No</th>\
                    <th>Position</th>\
                    </tr>\
                </thead>\
                <tbody id="doc_table_body">\
                </tbody\
              </table>\
            </div>');

    $.post("api/get_doctors", function(response){
      
      $.each(response, function(i, val) {

        $("#doc_table_body").append(
          '<tr>\
              <td>\
                <div class="checkbox">\
                  <label><input type="checkbox" value="'+val.DocID+'"></label>\
                </div>\
              </td>\
              <td>'+val.DocName+'</td>\
              <td>'+val.DocSurname+'</td>\
              <td>'+val.DocEmail+'</td>\
              <td>'+val.DocPhone+'</td>\
              <td>'+val.DocWorkField+'</td>\
            </tr>');
      });

    });

  });


  $("#login").click(function() {
    
      var data = $("#admin_form").serialize();


      $.ajax(
      {
      type : 'POST',
      url  : 'admin_login.php',
      data : data,
      success :  function(response){      
          if (response) {  
            window.location.href = 'adminpanel.php'
          }
          else{

            $(".error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; user name or password doesn\'t exists !</div>');

          }
        }
      });

    });

  $("#save_news_btn").click(function(event) {

    var content = $("textarea#news_content").val();
    var title = $("input#news_title").val();

    $.post('api/save_news', {content: content, title:title}, function(response) {
        news_fill();


    });

  });


  $("#add_news").click(function() {

    $("#addNewsModal").modal('show')
  })

});  