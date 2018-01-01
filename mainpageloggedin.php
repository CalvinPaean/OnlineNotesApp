<?php
    session_start();
    if(!isset($_SESSION['user_id'])){
        header("Location: index.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>My Notes</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css?family=Arvo" rel="stylesheet" type="text/css">
      <link href="styling.css" rel="stylesheet">
      <style>
          #container{
              margin-top: 120px;
          }
          
          #notePad, #allNotes, #done, .delete{
              display: none;
          }
          .buttons{
              margin-bottom: 20px;
          }
          textarea{
              width: 100%;
              max-width: 100%;
              font-size: 16px;
              line-height: 1.5em;
              border-left-width: 20px;
              border-color: #484550;
              color: #484550;
              background-color:#F9F9F7;
              padding: 10px;
          }
          .noteheader{
              border: 1px solid grey;
              border-radius: 10px;
              cursor:pointer;
              margin-bottom: 10px;
              padding: 0 10px;
              background: linear-gradient(#D4D4D2,#DDE0E9);
          }
          .text{
              font-size: 20px;
              overflow: hidden;
              white-space: nowrap;
              text-overflow: ellipsis;
          }
          .timetext{
              overflow: hidden;
              white-space: nowrap;
              text-overflow: ellipsis;
          }
      </style>
  </head>
  <body>
<!--      Navigation bar-->
      <nav role="navigation" class="navbar navbar-custom navbar-fixed-top">
          <div class="container-fluid">
              <div class="navbar-header">
                  <a class="navbar-brand">Online Notes</a>
                  <button type="button" class="navbar-toggle" data-target="#navbarCollapse" data-toggle="collapse">
                      <span class="sr-only">Toggle Navigation</span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                  </button>
              </div>
              
              <div class="navbar-collapse collapse" id="navbarCollapse">
                  <ul class="nav navbar-nav">
                      <li><a href="profile.php">Profile</a></li>
                      <li><a href="#">Help</a></li>
                      <li><a href="#">Contact us</a></li>
                      <li class="active"><a href="#">My Notes</a></li>
                  </ul>
                  <ul class="nav navbar-nav navbar-right">
                      <li><a href="#">Logged in as <b><?php echo $_SESSION['username'] ?></b></a></li>
                      <li><a href="index.php?logout=1">Log out</a></li>
                     
                  </ul>
              </div>
          </div>
      </nav>
      
<!--Container  -->
      <div class="container" id="container">
<!--          Alert Message-->
          <div id="alert" class="alert alert-danger collapse">
              <a class="close" data-dismiss="alert">
                  &times;
              </a>
              <p id="alertContent"></p>
              
          </div>
          <div class="row">
              <div class="col-md-offset-3 col-md-6">
                  <div class="buttons">
                      <button id="addNote" type="button" class="btn btn-info btn-lg">Add Note</button>
                      <button id="edit" type="button" class="btn btn-info btn-lg pull-right">Edit</button>
                      <button id="done" type="button" class="btn green btn-lg pull-right">Done</button>
                      <button id="allNotes" type="button" class="btn btn-info btn-lg">All Notes</button>
                  </div>
                  <div id="notePad">
                      <textarea rows="10"></textarea>
                  </div>
                  <div id="notes" class="notes">
                      <!-- Ajax call to the PHP file -->
                  </div>
              </div>
          </div>
      </div>
      

      
<!--      footer-->
      <div class="footer">
          <div class="container">
              <p>Laniakea Copyright &copy; 2016-<?php $today=date('Y'); echo $today; ?></p>
          </div>
      </div>
      
<!--      jQuery -->
      
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    
    <script src="js/bootstrap.min.js"></script>
    <script src="mynotes.js"></script>
      
  </body>
</html>