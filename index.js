//AJAX call for the sign up form
//once the form is submitted
$("#signupform").submit(function(event){
    //prevent the default php processing
    event.preventDefault();
    //collect user inputs
    var datatopost = $(this).serializeArray();
    //send them to signup.php using AJAX
    $.ajax({
        url: "signup.php",//the url it will redirect
        type: "POST",//the type of the call is POST call
        data: datatopost,
        success: function(data){//what to do if the call is successful
            if(data){
                $("#signupmessage").html(data);
            }
        },
        error: function(){//what to do if the call fails
            $("#signupmessage").html("<div class='alert alert-danger'>There was an error with the AJAX call. Please try again later.</div>");
        }
    }); 
});


//AJAX call for the login form
//once the form is submitted
    //prevent the default php processing
    //collect user inputs
    //send them to login.php using AJAX
        //AJAX call successful
            //if php files return "success": redirect the user to notes page
            //otherwise, show error message
        //AJAX call fails: show AJAX call error
$("#loginform").submit(function(event){
    //prevent the default php processing
    event.preventDefault();
    //collect user inputs
    var datatopost = $(this).serializeArray();
    //send them to login.php using AJAX
    $.ajax({
        url: "login.php",//the url it will redirect
        type: "POST",//the type of the call is POST call
        data: datatopost,
        success: function(data){//what to do if the call is successful
            if(data == "success"){//this data is returned from the php file.
                window.location = "mainpageloggedin.php";
            }else{
                $("#loginmessage").html(data);
            }
        },
        error: function(){//what to do if the call fails
            $("#loginmessage").html("<div class='alert alert-danger'>There was an error with the AJAX call. Please try again later.</div>");
        }
    }); 
});


//AJAX call for the forgot password form
//Once the form is submitted
    //prevent default php processing
    //collect user inputs
    //send them to login.php using AJAX
        //AJAX call successful: show error or success message
        //AJAX call fails: show AJAX call error
$("#forgotpasswordform").submit(function(event){
    //prevent the default php processing
    event.preventDefault();
    //collect user inputs
    var datatopost = $(this).serializeArray();
    //send them to signup.php using AJAX
    $.ajax({
        url: "forgot-password.php",//the url it will redirect
        type: "POST",//the type of the call is POST call
        data: datatopost,
        success: function(data){//what to do if the call is successful
            $('#forgotpasswordmessage').html(data);
        },
        error: function(){//what to do if the call fails
            $("#forgotpasswordmessage").html("<div class='alert alert-danger'>There was an error with the Ajax Call. Please try again later.</div>");
            
        }
    }); 
});