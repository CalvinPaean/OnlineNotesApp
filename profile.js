//ajax call to updateusername.php
$("#updateusernameform").submit(function(event){
    //prevent the default php processing
    event.preventDefault();
    //collect user inputs
    var datatopost = $(this).serializeArray();
    //send them to signup.php using AJAX
    $.ajax({
        url: "updateusername.php",//the url it will redirect
        type: "POST",//the type of the call is POST call
        data: datatopost,
        success: function(data){//what to do if the call is successful
            if(data){
                $("#updateusernamemessage").html(data);
            }else{
                location.reload();//reload the page
            }
        },
        error: function(){//what to do if the call fails
            $("#updateusernamemessage").html("<div class='alert alert-danger'>There was an error with the AJAX call. Please try again later.</div>");
        }
    }); 
});



//ajax call to updatepassword.php
$("#updatepasswordform").submit(function(event){
    //prevent the default php processing
    event.preventDefault();
    //collect user inputs
    var datatopost = $(this).serializeArray();
    //send them to signup.php using AJAX
    $.ajax({
        url: "updatepassword.php",//the url it will redirect
        type: "POST",//the type of the call is POST call
        data: datatopost,
        success: function(data){//what to do if the call is successful
            if(data){
                $("#updatepasswordmessage").html(data);
            }
        },
        error: function(){//what to do if the call fails
            $("#updatepasswordmessage").html("<div class='alert alert-danger'>There was an error with the AJAX call. Please try again later.</div>");
        }
    }); 
});


//ajax call to updateemail.php
$("#updateemailform").submit(function(event){
    //prevent the default php processing
    event.preventDefault();
    //collect user inputs
    var datatopost = $(this).serializeArray();
    //send them to signup.php using AJAX
    $.ajax({
        url: "updateemail.php",//the url it will redirect
        type: "POST",//the type of the call is POST call
        data: datatopost,
        success: function(data){//what to do if the call is successful
            if(data){
                $("#updateemailmessage").html(data);
            }
        },
        error: function(){//what to do if the call fails
            $("#updatepasswordmessage").html("<div class='alert alert-danger'>There was an error with the AJAX call. Please try again later.</div>");
        }
    }); 
});




