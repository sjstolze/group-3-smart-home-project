<!DOCTYPE html>
<html>
<?php
session_start();

if(!isset($_SESSION['username']) && !isset($_SESSION['email']))
  header("Location: " . dirname($_SERVER['SCRIPT_NAME']) . "/login.php");

  $change = false;
  $sql = '';
  if(strlen($_POST['username']) != 0)
  { 
    $sql = "UPDATE devices, functions,  users SET devices.username='" . $_POST['username'] . "', functions.username='" . $_POST['username'] . "', users.username='" . $_POST['username'] . "' WHERE devices.username='" . $_SESSION['username'] . "'AND functions.username='" . $_SESSION['username'] . "' AND users.username='" . $_SESSION['username'] . "';";
    $_SESSION['username'] = $_POST['username'];
  }
  
  if(strlen($_POST['email']) != 0)
  { 
    $sql = "UPDATE users SET email ='" . $_POST['email'] . "' WHERE username='" . $_SESSION['username'] . "';";
  }
  
  if(strlen($_POST['password']) != 0)
  { 
    $sql = "UPDATE users SET password='" . $_POST['password'] . "' WHERE username='" . $_SESSION['username'] . "';";
  }

  if($sql != '')
  {
    $servername = "localhost";
    $username = "root";
    $password = "kohSha4E";
    $dbname = "smarthome";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
      
    if ($conn->query($sql) === TRUE) {
        echo "update successful";
      } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
      }
  }
?>
<body onLoad="setupLinks()">

<script type="text/javascript">
  function setupLinks(){
      
      var user = document.getElementById("edit_username");
      
      
      user.onclick = function(){
          document.getElementById("user_edit").innerHTML = "New Username:<input type=\"text\" name=\"username\"><input type=\"submit\" value=\"submit\">"; 
          return false;
      };
      
      var mail =  document.getElementById("edit_email");

      mail.onclick = function(){
          document.getElementById("mail_edit").innerHTML = "New Email:<input type=\"text\" name=\"email\"><input type=\"submit\" value=\"submit\">"; 
          return false;};
          
      var pass = document.getElementById("edit_pass");
      pass.onclick = function(){
          document.getElementById("pass_edit").innerHTML = "New Password:<input type=\"password\" name=\"password\"><input type=\"submit\" value=\"submit\">"; 
          return false;
          };
  }
  </script>
<?php

  
  echo 'Username: ' . htmlspecialchars($_SESSION["username"]);
?>
  <a id="edit_username" href="">edit</a>
  <form id="user_edit" action="<?php print($_SERVER['SCRIPT_NAME'])?>"  method="POST">
  </form>
  <br>
<?php    
	echo 'Email: ' . htmlspecialchars($_SESSION["email"]);
?>
  <a id="edit_email" href="">edit</a>
  <form id="mail_edit" action="<?php print($_SERVER['SCRIPT_NAME'])?>"  method="POST">
  </form>
  <br>

  <a id="edit_pass" href="">Change Password</a>
  <form id="pass_edit" action="<?php print($_SERVER['SCRIPT_NAME'])?>"  method="POST">
  </form>
  <br>
  
  <a id="return" href="<?php print(dirname($_SERVER['SCRIPT_NAME']) . "/homepage.php")?>">return</a>
</body>
</html>