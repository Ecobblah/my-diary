<?php
ob_start();
session_start();

$diaryContent = "";
if(array_key_exists("id",$_COOKIE)){
  $_SESSION['id'] = $_COOKIE['id'];
}

if(array_key_exists("id", $_SESSION)){
  include("connection.php");
  $query = "SELECT diary FROM users WHERE id = '".mysqli_real_escape_string($link, $_SESSION['id'])."'LIMIT 1";
  $result = mysqli_query($link, $query);
  if (!$result) {
    echo 'Invalid query: ' . mysqli_error($link);
}
  $row = mysqli_fetch_array($result);
  $diaryContent = $row['diary'];
}
else{
  header("Location: diary.php");
}
include("header.php");
?>



  <nav class="navbar navbar-dark bg-dark">
      <a class="btn btn-success my-2 my-sm-0" href='diary.php?logout=1'>Logout!</a>
  </nav>

<div class="container-fluid">
  <textarea id="diary" class="form-control" ng-model="name"><?php echo $diaryContent?></textarea>
</div>
<?php
include("footer.php");
 ?>
