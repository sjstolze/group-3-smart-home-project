<!DOCTYPE html>
<html>
<?php
session_start();
  $accounts = &json_decode(file_get_contents("accounts.json"));
  $change = false;
  if(strlen($_POST['username']) != 0)
  { 
    $len = count($accounts);
    for($i=0; $i < $len;$i++)
    {
      if(strcmp($accounts[$i]->username,$_SESSION['username']) == 0)
      {
            $_SESSION['username'] = $_POST['username'];
            $accounts[$i]->username = $_POST['username'];
            $fh = fopen("accounts.json", 'w');
            if($fh === false)
              print("Failed to open accounts.json for writing.");
            else
            {
              fwrite($fh, json_encode($accounts));
              fclose($fh);
            }
      }
      
    }
  }
  
  if(strlen($_POST['email']) != 0)
  { 
    $len = count($accounts);
    for($i=0; $i < $len;$i++)
    {
      if(strcmp($accounts[$i]->email,$_SESSION['email']) == 0)
      {
            $_SESSION['email'] = $_POST['email'];
            $accounts[$i]->email = $_POST['email'];
            $fh = fopen("accounts.json", 'w');
            if($fh === false)
              print("Failed to open accounts.json for writing.");
            else
            {
              fwrite($fh, json_encode($accounts));
              fclose($fh);
            }
      }
      
    }
  }
  
  if(strlen($_POST['password']) != 0)
  { 
    $len = count($accounts);
    for($i=0; $i < $len;$i++)
    {
      if(strcmp($accounts[$i]->email,$_SESSION['email']) == 0)
      {
            $accounts[$i]->password = $_POST['password'];
            $accounts[$i]->password2 = $_POST['password'];
            $fh = fopen("accounts.json", 'w');
            if($fh === false)
              print("Failed to open accounts.json for writing.");
            else
            {
              fwrite($fh, json_encode($accounts));
              fclose($fh);
            }
      }
      
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
  //This line prevents the user from just typing in /homepage.php in their browser, they must log in
  if(!isset($_SESSION['username']) && !isset($_SESSION['email']))
    header("Location: " . dirname($_SERVER['SCRIPT_NAME']) . "/login.php");
  
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
