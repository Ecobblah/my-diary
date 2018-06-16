<?php
  $severname = "shareddb-i.hosting.stackcp.net";
  $username = "myUsers-3335b2fc";


  $link = mysqli_connect($severname, $username, $password, $username);

  if(!$link){
    die("Connect failed: ".mysqli_connect_error());
  }

if($_POST){

  $query = "SELECT * FROM users WHERE email = '".$_POST['email']."' AND password = '".$_POST['password']."'";
  $result = mysqli_query($link, $query);
  if(mysqli_num_rows($result) > 0){
    $row = mysqli_fetch_assoc($result);
    echo "redirecting you to your diary ".$row['email'];
  }
  else{
    echo "Invalid Email or Password";
  }

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
