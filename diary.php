<?php
ob_start();
session_start();
$error = "";
$errorClass = "";
if(array_key_exists("logout", $_GET)){
  session_unset();
  session_destroy();
  unset($_SESSION);
  setcookie("id","", time() -60*60);
  $_COOKIE["id"] = "";
  header("Location: diary.php");
}

elseif((array_key_exists("id",$_SESSION) AND $_SESSION['id']) OR (array_key_exists("id",$_COOKIE) AND $_COOKIE['id']) ){
  header("Location: textArea.php");
}
if(array_key_exists("submit",$_POST)){
  include("connection.php");

    if(!$_POST['email']){
      $error = "An email address is required<br>";
    }
    if(!$_POST['password']){
      $error = $error."An password is required<br>";
    }
    if($error !=""){
      $errorClass = "class='alert alert-danger' role='alert'";
      $error ="<p>There were error(s) in your form </p>".$error;
    }
    else{
      if($_POST['signUp'] == '1'){
        $query = "SELECT id FROM users WHERE email = '".mysqli_real_escape_string($link,$_POST['email'])."' ";
        if (mysqli_error($link)){
          echo mysqli_error($link);
        }
        else{
          $result = mysqli_query($link,$query);
          echo  mysqli_error($link);
          if(mysqli_num_rows($result) > 0){
            $error = "<p>That email address is taken.</p>";
            $errorClass = "class='alert alert-danger' role='alert'";
          }
          else{
            $query = "INSERT INTO users (email, password)
            VALUES('".mysqli_real_escape_string($link, $_POST['email'])."' ,
             '".mysqli_real_escape_string($link, $_POST['password'])."')";
             echo  mysqli_error($link);
             if(!mysqli_query($link,$query)){
               echo  mysqli_error($link);
               $error = "<p>Could not sign you up please try again later.</p>";
               $errorClass = "class='alert alert-danger' role='alert'";
             }
             else{
               //update password by returning the id used in the last query
               $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
               $query = "UPDATE users SET password = '".$hash."'WHERE id =
               ".mysqli_insert_id($link)." LIMIT 1";
               mysqli_query($link,$query);
               $_SESSION['id'] = mysqli_insert_id($link);
               if($_POST['stayLoggedIn'] == 1){
                 setcookie("id", mysqli_insert_id($link), time() + 60*60*24*365);
               }
               header("Location: textArea.php");
             }
          }
        }
      }
      else{

        $query = "SELECT * FROM users WHERE email = '".mysqli_real_escape_string($link,$_POST['email'])."'";

        $result = mysqli_query($link,$query);
        $row = mysqli_fetch_array($result);

        if(isset($row)){
          if(password_verify($_POST['password'],$row['password'] )){
            $_SESSION['id'] = $row['id'];
            if($_POST['stayLoggedIn'] == 1){
              setcookie("id", $row['id'], time() + 60*60*24*365);
            }
            header("Location: textArea.php");
          }
          else{
            $errorClass = "class='alert alert-danger' role='alert'";
            $error = "<p>Invalid email or password.</p>";
          }
        }
        else{
            $errorClass = "class='alert alert-danger' role='alert'";
          $error = "<p>Invalid email or password.</p>";
        }
      }
    }
  }


?>
    <?php include("header.php");?>
      <div class="container" id="homePageContainer">
      <div id="error" <?php echo $errorClass?>><?php echo $error;?></div>
      <form method="post" class="text-center content" id="signUpForm">
        <h1>Secert Diary</h1>
        <div class="form-group">
          <input type="email" class="form-control" name="email" placeholder="Email">
        </div>
        <div class="form-group">
          <input type="password" class="form-control" name="password" placeholder="Password">
        </div>
        <div class="form-group form-check">
          <input type="checkbox" class="form-check-input" name="stayLoggedIn" value="1">
          <label class="form-check-label">Stay logged in</label>
        </div>
        <button type="submit" class="btn btn-primary"name="submit">Sign Up!</button>
        <p><a class="toggleForms" >Log in</a></p>
        <input type="hidden" name="signUp" value="1">
      </form>

      <form method="post" class="text-center content" id="logInForm">
        <h1>Secert Diary</h1>
        <div class="form-group">
          <input type="email" class="form-control" name="email" placeholder="Email">
        </div>

        <div class="form-group">
          <input type="password" class="form-control" name="password" placeholder="Password">
        </div>
        <div class="form-group form-check">
          <input type="checkbox" class="form-check-input" name="stayLoggedIn" value="1">
          <label class="form-check-label">Stay logged in</label>
        </div>
        <button type="submit" class="btn btn-primary"name="submit">Log In!</button>
        <input type="hidden" name="signUp" value="0">
        <p><a class="toggleForms">Sign Up!</a></p>
      </form>
    </div>
    <?php include("footer.php");?>
