<html>
<?php
session_start();
?>

<body>

<?php
  //$accounts = &json_decode(file_get_contents("accounts.json"));
  
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
  
  
  $invalid_login = false;
  if($_POST['login'] == 'true')
  { 
    $sql = "SELECT Username , Password, email FROM users";
    $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) 
    {
      if(strcmp($row["Username"],$_POST['username']) == 0)
      {
        if(strcmp($row["Password"],$_POST['password']) == 0)
        {
          $_SESSION['username'] = $_POST['username'];
          $_SESSION['email'] = $row["email"];
          header("Location: " . dirname($_SERVER['SCRIPT_NAME']) . "/homepage.php");
        }
      }
    } 
  }
  else {
     echo "0 results";
  }
  $invalid_login = true;
  
  }
  if($_POST['logout'] == 'true')
  {
    unset($_SESSION['username']);
    unset($_SESSION['email']);
  }
  else
  {
    if(strlen($_POST['password'])!=0 && strlen($_POST['username'])!=0 && strlen($_POST['email'])!=0 )
    {      
      $sql = "INSERT INTO users (Username, Password, email) VALUES ('". $_POST['username'] . "', '". $_POST['password'] . "', '" . $_POST['email'] ."')";
      if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
      } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
      }
    }
  }
  ?>

<script>
function validateForm()
{
	var i = document.forms["newaccount"]["username"].value;
		if (i == null || i == "") {
			alert("Username must be filled out");
			return false;
		}
	var j = document.forms["newaccount"]["email"].value;
	var atpos = j.indexOf("@");
	var dotpos = j.lastIndexOf(".");
		if (atpos< 1 || dotpos<atpos+2 || dotpos+2>=j.length) {
			alert("Not a valid e-mail address");
			return false;
		}
	var x=document.forms["newaccount"]["password"].value;
	var y=document.forms["newaccount"]["password2"].value;
		if (x == null || x == "") {
			alert("Password must be filled out");
			return false;
		}
		else if (x != y)
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
