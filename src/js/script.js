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
    var position = $("#position select").val();
    var checker= [];
    var inputs = $("#sign_up_form").serializeArray();
    var inputObj = {};
    
    $.each(inputs, function(i,field){
      inputObj[field.name] = field.value;
      var select = field.name;
      console.log(inputObj[select]);

      if(inputObj[select] && confirm_password() && birth_data_validator()){
          //$("label[for="+select+"] span").addClass('glyphicon glyphicon-ok');
      }
      else{

        if(select!="status")
        $("label[for="+select+"] span").addClass('glyphicon glyphicon-remove');
      }
      checker[i] = $("label[for="+select+"] span").hasClass("glyphicon-remove");
      /*var html= $("label[for="+select+"]").html() +"this field is required";
      $("label[for="+select+"]").html(html);*/
      
      console.log(i +". " +inputObj[select] +" "+ checker[i]);
    });
      
    var passport = $("label[for=passport] span").hasClass("glyphicon-ok");
        

    if( !checker[0] && !checker[1] && !checker[2] && !checker[3] && !checker[4] && !checker[5] && !checker[6] && !checker[7]){
      
      alert("IF WORKS")
      $.post('api/signup', {
        first_name: inputObj['first_name'],
        last_name: inputObj['last_name'],
        passport: inputObj['passport'],
        birth_date: inputObj['birth_date'],
        email: inputObj['email'],
        phone: inputObj['phone'],
        job_study: inputObj['job_study'], 
        password: inputObj['password1'],
        status: inputObj['status'],
        position: position

      },
      function(resp){

        
        console.log(resp);
        if(!resp){
           $('#successModal').modal('show'); 
          setTimeout(function() {
            
          }, 3000);
          window.location.href = 'index.php';
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
        alert("BYE BYE ;)");
        window.location.href = "index.php";
      }
      else{
        alert("ERROR");
      }
    })

  });

     /* validation  for sign-in*/

  $("#login_form").validate({
      rules:
   {
   password: {
   required: true,
   },
   passport_no: {
            required: true
            },
    },
       messages:
    {
            password:{
                      required: "please enter your password"
                     },
            passport_no: "please enter passport No",
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
        console.log(response);
         if(response=="ok"){
             
            $("#btn_login").html('<img src="btn-ajax-loader.gif" /> &nbsp; Signing In ...');
          window.location.href = "index.php";
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

  if($("#password2").val()!==$("#sign_up_form #password1").val() && $("#sign_up_form #password1").val() ){
          $("label[for=password2] span").removeClass('glyphicon glyphicon-ok').addClass('glyphicon glyphicon-remove');
          return false;
    }
    else{
        $("label[for=password2] span").removeClass('glyphicon glyphicon-remove').addClass('glyphicon glyphicon-ok');
        return true;
    }
}/*end comfirm password*/


/*passport validation*/
function passport_validation() {

  var inputs = $("#sign_up_form").serializeArray();
    
    

  var status = inputs[1]['value'];
  if(!status){
    status = 0;
  }

  var input = /([a-zA-Z]){2}\d{6}/;
  var pass = $("#sign_up_form #passport").val();
  var check = input.test(pass);
  if(check){

    $.post('api/passport', { passport: pass, status:status } , function(resp) {
      
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

    $("#phone").on('focusout', function(){
      
      var access_key = 'f6de90ecfb7c829fdefb0f96c2152b17';
      var phone_number = $(this).val();

// verify email address via AJAX call
/*      $.ajax({
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
*/$("label[for=phone] span").removeClass('glyphicon glyphicon-remove').addClass('glyphicon glyphicon-ok');
  return true;
    });

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

    $("#password1").on('input', function(){

      if($(this).val()){
        $("label[for=password1] span").removeClass('glyphicon glyphicon-remove').addClass('glyphicon glyphicon-ok').cs;
        return true;
      }
      else{
        $("label[for=password1] span").removeClass('glyphicon glyphicon-ok').addClass('glyphicon glyphicon-remove');
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
  

 /* $.each(days, function(index, val) {
    $("#days").append("<li><a>"+val+"-03-2017</a></li>")
  });

  $.each(docs, function(index, val) {
    $("#doctors").append("<li><a>"+val+"</a></li>")   
  });
*/
/*  $.each(sec, function (index, value) {
      var exactTime=0;
      
      if (value) {
        exactTime = index+9;
        console.log(index);
        $("#time").prepend("<li><a>"+exactTime+":00</a></li>");
        }
  });*/

}
/*Fill show booking time*/

/*get booking time and go post it in data base*/

$("#bookingBtn").click(function() {

  var selectedDay =  $("#day_drop select").val();
  var selectedDoc =  $("#doc_drop select").val();
  var selectedTime = $("#time_drop select").val();

    var id =  $("#doc_drop select").val();
    var id =  $("#doc_drop select").val();
    var userID = $("#userID").val();

    console.log(userID); 
  if (selectedTime=="------") {
      $("#bookingError").fadeIn(500, function(){      
    $("#bookingError").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Please, select time !</div>');
           $("#btn-login").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Sign In');
         });
  } else if(selectedDay=="------"){
    $("#bookingError").fadeIn(500, function(){      
    $("#bookingError").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Please, select date !</div>');
           $("#btn-login").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Sign In');
      });
  }else if(selectedDoc =="------"){
      $("#bookingError").fadeIn(500, function(){      
    $("#bookingError").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Please, select doctor !</div>');
           
      });
  }else
      {

    $.post('api/booking', {
      user: userID,
      doctor: selectedDoc,
      day: selectedDay,
      time: selectedTime
    }, function(resp) {


    });
  }

});/*END OF BOOKING DATA FILL



  table_fill();
  /*ADD PATIENT TO TABLE*/
  table_fill();
  function table_fill() {
    

    var data = [];

    data = [ {
        name: "DALER",
        time: "10:00",
        passport: "AA322132"
      },
      {
        name: "Muxlisa",
        time: '12:00',
        passport: "AB12345"
      }

    ]
/*              $.post('api/queueing_patients', {docID: docID}, function(resp) {
                  

                  });*/
    $.each( data, function(i, val) {
     

     $("#patient_table").append('<tr><td>'+data[i]["time"]+'</td><td>'+data[i]["name"]+'</td><td class="userID">'+data[i]["passport"]+'</td></tr>')

    });



  };/*END PATIENT ADD TO TABLE*/

  /*GET PATIENT ID WHEN CLIKED ON ROW*/
  $("#patient_table tr").click(function(event) {
    

    var userID = $(this).find(".userID").html();
    $("#insert_patient").html(userID + "");

    $.post('api/get_medical_history', {userID: userID}, function(resp) {
       
       $("#accor1").html('<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">\
                      <div class="panel panel-success">\
                        <div class="panel-heading" role="tab" id="">\
                          <h4 class="panel-title">\
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#Dentist" aria-expanded="true" aria-controls="Dentist">\
                              Dentist\
                            </a>\
                          </h4>\
                        </div>\
                        <div id="Dentist" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">\
                          \
                        </div>\
                      </div>\
                    </div>\
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">\
                      <div class="panel panel-success">\
                        <div class="panel-heading" role="tab" id="">\
                          <h4 class="panel-title">\
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#Surgeon" aria-expanded="true" aria-controls="Surgeon">\
                              Surgeon\
                            </a>\
                          </h4>\
                        </div>\
                        <div id="Surgeon" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">\
                          \
                        </div>\
                      </div>\
                    </div>\
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">\
                      <div class="panel panel-success">\
                        <div class="panel-heading" role="tab" id="">\
                          <h4 class="panel-title">\
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#Pediatrician" aria-expanded="true" aria-controls="Pediatrician">\
                              Pediatrician\
                            </a>\
                          </h4>\
                        </div>\
                        <div id="Pediatrician" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">\
                          \
                        </div>\
                      </div>\
                    </div>\
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">\
                      <div class="panel panel-success">\
                        <div class="panel-heading" role="tab" id="">\
                          <h4 class="panel-title">\
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#Cardiologist" aria-expanded="true" aria-controls="Cardiologist">\
                              Cardiologist\
                            </a>\
                          </h4>\
                        </div>\
                        <div id="Cardiologist" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">\
                          \
                        </div>\
                      </div>\
                    </div>\
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">\
                      <div class="panel panel-success">\
                        <div class="panel-heading" role="tab" id="">\
                          <h4 class="panel-title">\
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#Gynecologist" aria-expanded="true" aria-controls="Gynecologist">\
                              Gynecologist\
                            </a>\
                          </h4>\
                        </div>\
                        <div id="Gynecologist" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">\
                          \
                        </div>\
                      </div>\
                    </div>');
        $.each(resp, function(index, val) {
            
          var collapse = '<div class="panel-body">\
                            <span class="badge">'+val.Date+'</span><br> \
                              '+val.Prescription+'\
                            </div>\
                          <div class="panel-footer">'+val.Medicine+'</div>';
                        
                        $("#"+val.WorkField).append(collapse);
        });


     });

  });/*END OF GET PATIENT ID WHEN CLIKED ON ROW*/

illness_his();


  function illness_his() {

 

    var userID = $("div #userID").text();
    console.log(userID);
    $.post('api/get_medical_history', {userID: userID}, function(resp) {
      
      $.each(resp, function(index, val) {
         var collapse = '<div class="panel-body">\
                            <span class="badge">'+val.Date+'</span><br> \
                              '+val.Prescription+'\
                            </div>\
                          <div class="panel-footer panel-info">'+val.Medicine+'</div>';
                        
                        $("#"+val.WorkField).append(collapse);
      });


    });


  }

  getNews();
  function getNews(){
    $.post('getNews.php', function(response) {

        $.each( JSON.parse(response), function(index, val) {
          if(index<4)  
            $('#news_container').append('<div class="col-md-6"><h3>'+val.title+'</h3><p>'+val.content+'</p></div>')

        });

    });
  }


  $("#booking_btn").click(function(event) {
    /* Act on the event */
    if($("#sign_out").text()){


      $.post('doctors.php', function(response) {

        $.each(JSON.parse(response), function(index, val) {
           $("#doc_list").append('<option value='+val.DocID+'>'+val.DocWorkField+'</option>')
        });
      });



    $("#bookingModal").modal('show');
    }
    else{

      alert("Please first sign in");
    }
  });


/*GETTING FREE TIME OF SELECTED DOC REFERING TO DAY*/
  $("#day_list").on('input', function (argument) {
    // body...
    var day =  $("#day_drop select").val();
    var id =  $("#doc_drop select").val();
    $.post('api/get_free_time', {date: day, docID:id }, function(response) {
        $.each(response, function(index, val) {
           
            $("#time_list").append('<option value='+val+'>'+val+'</option>');
        }, "json");

    });

  })

  /*Droopdown menu selected Doc */
 $('#doctors a').click(function(){
    $('#selectedDoc').text($(this).text());
    console.log($(this).text());
   
  });


 /*Droopdown menu selected Day */
 $('#days a').click(function(){
    $('#selectedDay').text($(this).text());

  });

 /*Droopdown menu selected Time */
 $('#time a').click(function(){
    $('#selectedTime').text($(this).text());

  });


$("#doc_table tr").click(function(event) {
    

    var userID = $(this).find(".docs").html();
    console.log(userID); 

  });/*END OF GET PATIENT ID WHEN CLIKED ON ROW*/


  $("#docSubmit").click(function(event) {

      var prescription = $("#prescription").val();
      var medicine = $("#medicine").val();
      var userID= $("#insert_patient").html();
      var workField = $("#doc_work_field").html();
      var docID = $("#docID").text();
      if(userID=='<span></span>'){
        alert("Please, first select patient");
      }
      else{

        $.post('api/post_medical_history', {
          userID: userID,
          docID: docID,
          prescription: prescription,
          medicine: medicine
          }, function(resp) {
          
            if(!resp){

              var collapse = '<div class="panel-body">\
                              <span class="badge">2017-05-11</span><br> \
                                '+prescription+'\
                              </div>\
                            <div class="panel-footer">'+medicine+'</div>';
                          
                          $("#"+workField).append(collapse);
              $("#prescription").val('');
              $("#medicine").val(' ');                      
              alert("Successfully added!!!");
            }

        });
      }
  });

});