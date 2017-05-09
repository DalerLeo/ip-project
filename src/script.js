$('document').ready(function()
{ 

  /*Check password for confirmation*/
  $("#password2").on('input', confirm_password);

  /*passport validation*/
  $("#sign_up_form #passport").on('input', passport_validation);

  /*Birth date handler*/
  $("#birth_date").on('input', birth_data_validator)

  /*mail validation*/
  $("#email").on('focusout', email_validator);  

  Fil();

  /*Add prescription by doctor*/

  $("#medicine_sub").click(function () {

  var pres = $("#pres").val();    
  var med = $("#medicine").val();
  var pass = $("#passport").val();
    $.post('api/illness_history', {
      prescription: pres,
      medicine: med,
      passport: pass
    }, function (resp) {
      
      if(!resp){
        alert(resp);
      }

    })

  })

/*Click function handler*/
  $("#sign_up_btn").click(function() {
    
    var inputs = $("#sign_up_form").serializeArray();
    var inputObj = {};
    var checker= [];
    $.each(inputs, function(i,field){
      inputObj[field.name] = field.value;
      var select = field.name;
      if(inputObj[select] && confirm_password() && birth_data_validator()){
          //$("label[for="+select+"] span").addClass('glyphicon glyphicon-ok');
      }
      else{
        $("label[for="+select+"] span").addClass('glyphicon glyphicon-remove');
      }
      checker[i] = $("label[for="+select+"] span").hasClass("glyphicon-remove");
      var html= $("label[for="+select+"]").html() +"this field is required";
      $("label[for="+select+"]").html(html);
      console.log(html);
    });
      
    var passport = $("label[for=passport] span").hasClass("glyphicon-ok");


    if( !checker[0] && !checker[1] && !checker[2] && !checker[3] && !checker[4] && !checker[5] && !checker[6] && !checker[7]){
      
      $.post('api/signup', {
        first_name: inputObj['first_name'],
        last_name: inputObj['last_name'],
        passport: inputObj['passport'],
        birth_date: inputObj['birth_date'],
        email: inputObj['email'],
        phone: inputObj['phone'],
        job_study: inputObj['job-study'], 
        password: inputObj['password']

      },
      function(resp){

        
        console.log(resp);
        if(!resp){
           $('#myModal').modal('show'); 
          setTimeout(function() {
            
          }, 3000);
/*          window.location.href = 'home.php';*/
        }

      }, "json");  

    }

  });/*CLICK button finish*/
  /*Sign-up function*/
  $("#signup-btn").click(function () {

    

  })


  /*Redirection to sign-in page*/
  $("#signin").click(function(){

    window.location.href = "login-ajax.html";
  });

  /*redicrection to sign-up page*/

  $("#sign_out").click(function(){

//    window.location.href = "register.html";

    $.post('logout.php', function(resp) {
 
      if(resp){
        alert("LOGGED OUT");
        window.location.href = "home.php";
      }
      else{
        alert("ERROR");
      }
    })

  });

/*Droopdown menu selected Doc */
 $('#doctors a').click(function(){
    $('#selectedDoc').text($(this).text());
   
  });


 /*Droopdown menu selected Day */
 $('#days a').click(function(){
    $('#selectedDay').text($(this).text());

  });

 /*Droopdown menu selected Time */
 $('#time a').click(function(){
    $('#selectedTime').text($(this).text());

  });

     /* validation  for sign-in*/

  $("#login_form").validate({
      rules:
   {
   password: {
   required: true,
   },
   confirm_password:{
    required: true,
    equalTo: "#password"
   },
   user_email: {
            required: true,
            email: true
            },
    },
       messages:
    {
            password:{
                      required: "please enter your password"
                     },
            confirm_password: {
              equalTo: "Does no match"
            },
            user_email: "please enter your email address",
       },
    submitHandler: submitForm 
       });  
    /* validation */
    
    /* login submit */
    function submitForm()
    {  
   var data = $("#login_form").serialize();

   $.ajax({
    
   type : 'POST',
   url  : 'login.php',
   data : data,
   beforeSend: function()
   { 
    $("#error").fadeOut();
    $("#btn_login").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; sending ...');
   },
   success :  function(response)
      {      
     if(response=="ok"){
         
      $("#btn_login").html('<img src="btn-ajax-loader.gif" /> &nbsp; Signing In ...');
      window.location.href = "home.php";
     }
     else{
      
      $("#error").fadeIn(500, function(){      
    $("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; '+response+' !</div>');
           $("#btn_login").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Sign In');
         });

     }
     }
   });
    return false;
  
  }
    /* login submit */

    /*password confirmation*/
function confirm_password() {

  if($("#password2").val()!==$("#sign_up_form #password").val() && $("#sign_up_form #password").val() ){
          console.log($("#password2").val() + "!==" + $("#sign_up_form #password").val());
          $("label[for=password2] span").removeClass('glyphicon glyphicon-ok').addClass('glyphicon glyphicon-remove');
          return false;
    }
    else{
                  console.log($("#password2").val() + "==" + $("#password").val());
        $("label[for=password2] span").removeClass('glyphicon glyphicon-remove').addClass('glyphicon glyphicon-ok');
        return true;
    }
}/*end comfirm password*/


/*passport validation*/
function passport_validation() {

  var input = /([a-zA-Z]){2}\d{6}/;
  var pass = $("#sign_up_form #passport").val();
  var check = input.test(pass);
  if(check){

    $.post('api/passport', { passport: pass } , function(resp) {
      
      if(!resp){
            $("#sign_up_form label[for=passport] span").removeClass('glyphicon glyphicon-remove').addClass('glyphicon glyphicon-ok');
                return true;
      }
      else{
        $("#sign_up_form label[for=passport] span").removeClass('glyphicon glyphicon-ok').addClass('glyphicon glyphicon-remove');
        return false;
      }

    }, "json");  
    

  }
  else{
    $("label[for=passport] span").removeClass('glyphicon glyphicon-ok').addClass('glyphicon glyphicon-remove');
    return false;
  }
}


function birth_data_validator(){

      var resp = /([0-3])?([0-9]){1}\/([0-1])?([0-2]){1}\/\d{4}/;
      var check = resp.test($("#birth_date").val());

      if(check){
        $("label[for=birth_date] span").removeClass('glyphicon glyphicon-remove').addClass('glyphicon glyphicon-ok');
        return true;
      }
      else{
        $("label[for=birth_date] span").removeClass('glyphicon glyphicon-ok').addClass('glyphicon glyphicon-remove');
        return false;
      }
    }


    function email_validator() {
      

      var access_key = 'f051a444428a379d9c2d557a995a4ad3';
      var email_address = $("#email").val();

      // verify email address via AJAX call
      $.ajax({
          url: 'http://apilayer.net/api/check?access_key=' + access_key + '&email=' + email_address,   
          dataType: 'json',
          success: function(resp) {

            if(resp.format_valid){
              $("label[for=email] span").removeClass('glyphicon glyphicon-remove').addClass('glyphicon glyphicon-ok');
              return resp;              
            }else{
              $("label[for=email] span").removeClass('glyphicon glyphicon-ok').addClass('glyphicon glyphicon-remove');
              return resp;
      }
                      
          }
      });

      /*var pattern = /.+@\w+\..+/
      var check = pattern.test($("#email").val());

      if(check){
        $("label[for=email] span").removeClass('glyphicon glyphicon-remove').addClass('glyphicon glyphicon-ok');
        return true;
      }
      else{
        $("label[for=email] span").removeClass('glyphicon glyphicon-ok').addClass('glyphicon glyphicon-remove');
        return false;
      }*/
      }


    $("#first_name").on('input', function() {
      
      var pattern = /\w{2,20}-?\w{1,20}/;
      var check = pattern.test($("#first_name").val());
      if(check){
        $("label[for=first_name] span").removeClass('glyphicon glyphicon-remove').addClass('glyphicon glyphicon-ok');
        return true;
      }
      else{
        $("label[for=first_name] span").removeClass('glyphicon glyphicon-ok').addClass('glyphicon glyphicon-remove');
        return false;
      }

    });

    $("#last_name").on('input', function() {
      
      var pattern = /\w{2,20}-?\w{1,20}/;
      var check = pattern.test($("#last_name").val());
      if(check){
        $("label[for=last_name] span").removeClass('glyphicon glyphicon-remove').addClass('glyphicon glyphicon-ok');
        return true;
      }
      else{
        $("label[for=last_name] span").removeClass('glyphicon glyphicon-ok').addClass('glyphicon glyphicon-remove');
        return false;
      }

    });
/*
    $("#phone").on('focusout', function(){
      
      var access_key = 'f6de90ecfb7c829fdefb0f96c2152b17';
      var phone_number = $(this).val();

// verify email address via AJAX call
      $.ajax({
          url: 'http://apilayer.net/api/validate?access_key=' + access_key + '&number=' + phone_number,   
          dataType: 'json',
          success: function(json) {

          // Access and use your preferred validation result objects
          console.log(json.valid);
          console.log(json.country_code);
          console.log(json.carrier);
            if(json.valid){
              $("label[for=phone] span").removeClass('glyphicon glyphicon-remove').addClass('glyphicon glyphicon-ok');
              
            }else{
              $("label[for=phone] span").removeClass('glyphicon glyphicon-ok').addClass('glyphicon glyphicon-remove');
              
            }          
              return json.valid;
          }
      });

    });*/

    $("#job_study").on('input', function(){

      if($(this).val()){
        $("label[for=job_study] span").removeClass('glyphicon glyphicon-remove').addClass('glyphicon glyphicon-ok');
        return true;
      }
      else{
        $("label[for=job_study] span").removeClass('glyphicon glyphicon-ok').addClass('glyphicon glyphicon-remove');
        return false;
      }
    });

    $("#password").on('input', function(){

      if($(this).val()){
        $("label[for=password] span").removeClass('glyphicon glyphicon-remove').addClass('glyphicon glyphicon-ok').cs;
        return true;
      }
      else{
        $("label[for=password] span").removeClass('glyphicon glyphicon-ok').addClass('glyphicon glyphicon-remove');
        return false;
      }
    });

/*Fill  booking time, date and doctors available dropdown on*/

function Fil(){


  var data = {
    sec1: "10:00",
    sec2: "11:00",
    sec3: "12:00"
  }

  sec = [1, 1, 0, 1, 0, 1];
  days = [12, 13, 14, 15];
  docs = ["Gidor", "chidor", "xidor"];

/*  var li = $("#time_menu>li");
  var timeArray = [];
  
  li.each(function(index){
    timeArray.push($(this).text() );
  });*/

  $.each(days, function(index, val) {
    $("#days").append("<li><a>"+val+"-03-2017</a></li>")
  });

  $.each(docs, function(index, val) {
    $("#doctors").append("<li><a>"+val+"</a></li>")   
  });

  $.each(sec, function (index, value) {
      var exactTime=0;
      
      if (value) {
        exactTime = index+9;
        console.log(index);
        $("#time").prepend("<li><a>"+exactTime+":00</a></li>");
        }
  });

}
/*Fill show booking time*/

/*get booking time and go post it in data base*/

$("#bookingBtn").click(function() {

  var selectedDoc = $('#selectedDoc').text();
  var selectedDay = $("#selectedDay").text();
  var selectedTime = $("#selectedTime").text();


  if (selectedTime=="Time") {
      $("#bookingError").fadeIn(500, function(){      
    $("#bookingError").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Please, select time !</div>');
           $("#btn-login").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Sign In');
         });
  } else if(selectedDay=="Day"){
    $("#bookingError").fadeIn(500, function(){      
    $("#bookingError").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Please, select date !</div>');
           $("#btn-login").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Sign In');
      });
  }else if(selectedDoc =="Doctors"){
      $("#bookingError").fadeIn(500, function(){      
    $("#bookingError").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Please, select doctor !</div>');
           
      });
  }else
      {

    $.post('api/booking', {
      doctor: selectedDoc,
      day: selectedDay,
      time: selectedTime
    }, function(resp) {
      /*optional stuff to do after success */
      //HANDLE AFTER BOOKING
    });
  }



});/*END OF BOOKING DATA FILL*/



  table_fill();
  /*ADD PATIENT TO TABLE*/
  function table_fill() {
    
    var patients = ["Shaxzod", "Mohi", "Sardor", "Sunnat"];


    var data = [];

    data = [ {
        name: "DALER",
        time: "10:00",
        passport: "AA322132"
      },
      {
        name: "Abdullo",
        time: '12:00',
        passport: "BB12323ds"
      }

    ]

    $.each( data, function(i, val) {
     
     console.log(data[i]["name"]);

     $("#patient_table").append('<tr><td>'+data[i]["time"]+'</td><td>'+data[i]["name"]+'</td><td class="userID">'+data[i]["passport"]+'</td></tr>')

    });



  };/*END PATIENT ADD TO TABLE*/

  /*GET PATIENT ID WHEN CLIKED ON ROW*/
  $("#patient_table tr").click(function(event) {
    

    var userID = $(this).find(".userID").html();
    console.log(userID); 

  });/*END OF GET PATIENT ID WHEN CLIKED ON ROW*/

illness_his();


  function illness_his() {

 
    var data = [
    {
      date: '01-12-2017',
      illness: "Cardiology",
      prescription: 'HEle Hele hey lelelelelelele',
      medicine: 'aspirin, pasatamol'
    },
    {
      date: '04-12-2017',
      illness: "Stomatology",
      prescription: 'There is no Dent 5',
      medicine: 'Ketanal'
    },
    {
      date: '07-12-2017',
      illness: 'neurologist',
      prescription: 'Really asdf sadfasdf asdfsdf sdfaasdf',
      medicine: 'sitramon'
    }];


    $.each(data, function(i, val) {
       /* iterate through array or object */
    
    var fill_history = '<div class="panel panel-default">\
                    <div class="panel-heading" role="tab" id="'+i+'">\
                      <h4 class="panel-title">\
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#'+data[i]["illness"]+'" aria-expanded="true" aria-controls="'+data[i]["illness"]+'">'+data[i]["illness"]+'\
                        </a>\
                      </h4>\
                    </div>\
                    <div id="'+data[i]["illness"]+'" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="'+i+'">\
                      <div class="panel-body">' +data[i]["prescription"]+
                      '</div>\
                      <div class="panel-footer">\
                        <label for="prescription">Prescription</label> \
                        <textarea id="prescription" name="prescription" class="form-control" rows="5"></textarea>\
                        <label for="medicine">Medicine</label>\
                        <textarea name="medicine" id="medicine" class="form-control"  rows="3"></textarea>\
                        <button class="right btn btn-success" > Submit</button>\
                      </div>\
                    </div>\
                  </div>';

            console.log(data[i]["illness"]);   
            $("#accordion").append(fill_history);
      });

  }

  getNews();
  function getNews(){
    $.post('getNews.php', function(response) {

        $.each( JSON.parse(response), function(index, val) {
          $('#news_container').append('<div class="col-md-6"><h3>'+val.title+'</h3><p>'+val.content+'</p></div>')

        });

    });
  }



});