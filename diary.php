<?php

if($_POST){
  echo "Thx for your email ".$_POST['email'];
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Diary</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  </head>
  <body>
    <div id="error"></div>
    <form method="post">
      <input class="noEmail" type="email" name="email" placeholder="Email">
      <input class="noPass" type="password" name="password" placeholder="Password">
      <input id="signBut" type="submit" name="" value="Sign up">
      </form>

    <form method="post">
      <input class="noEmail" type="email" name="email" placeholder="Email">
      <input type="password" name="password" placeholder="Password">
      <input id="loginBut"type="submit" name="" value="Sign in">
    </form>
    <script type="text/javascript">
      $("#signBut").click(function(){
        var error="";
        $("#error").html("");
        if( $(".noEmail").val()=="" ){
          error = "<p>Sry you got an empty email</p>";
          $("#error").html(error);
        }
        if( $(".noPass").val()==""){
          error = error + "<p>Sry you got an empty Password</p>";
          $("#error").html(error);
        }
        if(error ==""){
          return true;
        }
        else {
          return false;
        }
      });
    </script>
  </body>
</html>
