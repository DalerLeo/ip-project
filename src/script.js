$('document').ready(function()
{ 

  /*Check password for confirmation*/
  $("#password2").on('input', confirm_password);

  /*passport validation*/
  $("#passport").on('input', passport_validation);

  /*Birth date handler*/
  $("#birth_date").on('input', birth_data_validator)

  /*mail validation*/
  $("#email").on('input', email_validator);  


  /*Add prescription by doctor*/

  $("#medicine_sub").click(function () {

  var pres = $("#prescription").val();    
  var med = $("#medicine").val();
    $.post('api/illness_history', {
      prescription: pres,
      medicine: med
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

  $("#signup").click(function(){

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



     /* validation  for sign-in*/

  $("#login-form").validate({
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
   var data = $("#login-form").serialize();

   $.ajax({
    
   type : 'POST',
   url  : 'login.php',
   data : data,
   beforeSend: function()
   { 
    $("#error").fadeOut();
    $("#btn-login").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; sending ...');
   },
   success :  function(response)
      {      
     if(response=="ok"){
         
      $("#btn-login").html('<img src="btn-ajax-loader.gif" /> &nbsp; Signing In ...');
      window.location.href = "home.php";
     }
     else{
      
      $("#error").fadeIn(500, function(){      
    $("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; '+response+' !</div>');
           $("#btn-login").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Sign In');
         });

     }
     }
   });
    return false;
  
  }
    /* login submit */

    /*password confirmation*/
function confirm_password() {

  if($("#password2").val()!==$("#password").val() && $("#password").val() ){
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

  var input = /([a-zA-Z]){2}\d{6}/;
  var pass = $("#passport").val();
  var check = input.test(pass);
  if(check){

    $.post('api/passport', { passport: pass } , function(resp) {
      
      if(!resp){
            $("label[for=passport] span").removeClass('glyphicon glyphicon-remove').addClass('glyphicon glyphicon-ok');
                return true;
      }
      else{
        $("label[for=passport] span").removeClass('glyphicon glyphicon-ok').addClass('glyphicon glyphicon-remove');
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
      
      var pattern = /.+@\w+\..+/
      var check = pattern.test($("#email").val());

      if(check){
        $("label[for=email] span").removeClass('glyphicon glyphicon-remove').addClass('glyphicon glyphicon-ok');
        return true;
      }
      else{
        $("label[for=email] span").removeClass('glyphicon glyphicon-ok').addClass('glyphicon glyphicon-remove');
        return false;
      }
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

    $("#phone").on('input', function(){
      if( $.isNumeric($(this).val()) ){
        $("label[for=phone] span").removeClass('glyphicon glyphicon-remove').addClass('glyphicon glyphicon-ok');
        return true;
      }
      else{
        $("label[for=phone] span").removeClass('glyphicon glyphicon-ok').addClass('glyphicon glyphicon-remove');
        return false;
      }
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

    $("#password").on('input', function(){

      if($(this).val()){
        $("label[for=password] span").removeClass('glyphicon glyphicon-remove').addClass('glyphicon glyphicon-ok');
        return true;
      }
      else{
        $("label[for=password] span").removeClass('glyphicon glyphicon-ok').addClass('glyphicon glyphicon-remove');
        return false;
      }
    });

});