$("document").ready(function() {
  
  $("#news_btn").click(function() {
    
    $("#content_container").html(
          '<div class="table-responsive">\
              <table class="table table-striped">\
                <thead>\
                  <tr>\
                    <th>#</th>\
                    <th>Title</th>\
                    <th>Content</th>\
                    </tr>\
                </thead>\
                <tbody id="table_body">\
                </tbody\
              </table>\
            </div>');

    $.post("getNews.php", function(response){
      
      $.each(JSON.parse(response), function(i, val) {

        $("#table_body").append(
          '<tr>\
              <td>\
                <div class="checkbox">\
                  <label><input type="checkbox" value="'+val.id+'">'+val.id+'</label>\
                </div>\
              </td>\
              <td>'+val.title+'</td>\
              <td>'+val.content+'</td>\
            </tr>');
      });

    })

  });


  $("#delete_btn").click(function(event) {
    var i =$("input:checked").length;
    if(i>1){
      alert("You can choose only one news");
    }
    else{
      alert($("input:checked").val());
    }  
  });
/*FILLING DOCTOR TABLE WHEN DOCTORS BUTTON CLICKED*/
  $("#doctor_btn").click(function() {

          $("#content_container").html(
          '<div class="table-responsive">\
              <table class="table table-striped">\
                <thead>\
                  <tr>\
                    <th>#</th>\
                    <th>Title</th>\
                    <th>Content</th>\
                    </tr>\
                </thead>\
                <tbody id="table_body">\
                </tbody\
              </table>\
            </div>');

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
});  