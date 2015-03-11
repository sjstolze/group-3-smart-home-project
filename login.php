<html>
<?php
session_start();
?>

<body>

<?php

  $accounts = &json_decode(file_get_contents("accounts.json"));
  $invalid_login = false;
  if($_POST['login'] == 'true')
  { 
    $len = count($accounts);
    for($i=0; $i < $len;$i++)
    {
      if(strcmp($accounts[$i]->username,$_POST['username']) == 0)
      {
        if(strcmp($accounts[$i]->password,$_POST['password']) == 0)
        {
          $_SESSION['username'] = $_POST['username'];
          $_SESSION['email'] = $accounts[$i]->email;
          header("Location: " . dirname($_SERVER['SCRIPT_NAME']) . "/homepage.php");
        }
      }
      
    }
    $invalid_login = true;
  }
  if($_POST['logout'] == 'true')
  {
    unset($_SESSION['username']);
    unset($_SESSION['email']);
    print("UNSETTTT");
  }
  else
  {
    if(strlen($_POST['password'])!=0 && strlen($_POST['username'])!=0 && strlen($_POST['email'])!=0 )
    {      
      $accounts[] = $_POST;
    }

    $fh = fopen("accounts.json", 'w');
    if($fh === false)
      print("Failed to open accounts.json for writing.");
    else
    {
      fwrite($fh, json_encode($accounts));
      fclose($fh);
    }
  }
  ?>

<script>
function validateForm()
{
var x=document.forms["newaccount"]["password"].value;
var y=document.forms["newaccount"]["password2"].value;
if (x != y)
  {
  alert("Mismatching passwords");
  document.getElementById("1").innerHTML = "PASSWORDS DON'T MATCH";
  return false;
  }

}
</script>

<link rel="stylesheet" href="login_stylesheet.css">



<div id="section">
  <h2> 
    <li>SMART HOUSE!!</li>  
  </h2>
</div>

<div id="section">
<h3>
<div id="h4">Log in:</div><br>
<form action="<?php print($_SERVER['SCRIPT_NAME'])?>"  method="POST">
  Username: <input type="text" name="username"><br>
  Password: <input type="password" name="password"><br>
  <input type="submit" value="submit">
  <input type="hidden" name="login" value="true">
</form>

<?php
  if($invalid_login == true){
    $message = "Invalid username or password<br><br>";
    print $message;
}
?>

<div id="h4">Create new account:</div><br>
<form name="newaccount" action="<?php print($_SERVER['SCRIPT_NAME'])?>" onsubmit="return validateForm()" method="POST">
  Username: <input type="text" name="username"><br>
  Email Address: <input type="text" name="email"><br>
  Password: <input type="password" name="password"><br>
  Confirm Password: <input type="password" name="password2"><p id="1"></p><br>
  <input type="submit" value="submit">  
  
</form>
</h3>
<div>



</body>
</html>
