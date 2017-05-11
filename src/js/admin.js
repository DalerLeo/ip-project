$("document").ready(function() {
  
  news_fill();
  $("#news_btn").on('click', news_fill);
  

  function news_fill() {
    
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
                  <label><input type="checkbox" value="'+val.id+'"></label>\
                </div>\
              </td>\
              <td>'+val.title+'</td>\
              <td>'+val.content+'</td>\
            </tr>');
      });

    });

  }


  $("#delete_btn").click(function(event) {
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

    $.post("api/get_doctors", function(response){
      
      $.each(response, function(i, val) {

        $("#table_body").append(
          '<tr>\
              <td>\
                <div class="checkbox">\
                  <label><input type="checkbox" value="'+val.id+'"></label>\
                </div>\
              </td>\
              <td>'+val.DocID+'</td>\
              <td>'+val.DocName+'</td>\
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

});  