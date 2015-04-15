<html>
<?php
	session_start();
?>
<?php
//This line prevents the user from just typing in /homepage.php in their browser, they must log in
if(!isset($_SESSION['username']) && !isset($_SESSION['email']))
  header("Location: " . dirname($_SERVER['SCRIPT_NAME']) . "/login.php");

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
  echo '<div class="black" id="account_info">';
  echo '<h4><b>Your Account Information:</b></h4>';
	echo 'Username: ' . htmlspecialchars($_SESSION["username"]) . "<br>";
	echo 'Email: ' . htmlspecialchars($_SESSION["email"]);
	echo "<br><br>";
	
	//print('<a href=' . dirname($_SERVER['SCRIPT_NAME']) . '/edit_profile.php>Edit Account</a>');

//code for adding device to database
if(isset($_POST['add']) && $_POST['add'] == 'true')
{  
  if(is_numeric($_POST['portnum'])){
    //print('python TCPClient.py ' . $_POST['portnum'] . " " . $_SESSION["username"] . " " . $_POST['devicename']);
    exec('python TCPClient.py ' . $_POST['portnum'] . " " . $_SESSION["username"] . " " . $_POST['devicename'] , $output);
    //print_r($output); 
    
    //if the responce is valid add to database
    if(!empty($output)){
      $sql = "INSERT INTO devices (Username, device, port) VALUES ('". $_SESSION['username'] . "', '" . $_POST['devicename'] . "', '" . $output[0] ."')";

      if ($conn->query($sql) === TRUE) {
        echo "New Device successfully added";
        echo "<br>";
      } 
        
      else {
        echo "Device already exists";
        echo "<br>";
      }
      $output = array_slice($output, 1);
      foreach($output as &$word){
        $sql = "INSERT INTO functions (Username, device, func_name) VALUES ('". $_SESSION['username'] . "', '". $_POST['devicename'] . "', '" . $word ."')";
        
        if ($conn->query($sql) === TRUE) {
          //echo "New Function " . $word . " added successfully";
          //echo "<br>";
        } 
        
        else {
          //echo "Error: function already exists";
          //echo "<br>";
        }
        
      }
    }
    else{
      print('Device ' . $_POST['devicename'] . ' not found!');
    }
  }
}
elseif(isset($_POST['del']) && $_POST['del'] == 'true' && $_POST['devicename'] != '')
{
  $sql = "DELETE FROM devices WHERE Username='" . $_SESSION['username'] . "' AND device='" . $_POST['devicename'] . "'";
  if ($conn->query($sql) === TRUE) {
     
     $sql2 = "DELETE FROM functions WHERE Username='" . $_SESSION['username'] . "' AND device='" . $_POST['devicename'] . "'";
     
     if ($conn->query($sql2) === TRUE) {
          echo "Device Removed";
          echo "<br>";
     }
     else {
          echo "functions not removed!";
          echo "<br>";
     }
  } 
        
  else {
     echo "Device not Found";
     echo $sql;
     echo "<br>";
  }
  
  
}

echo '</div>';

	

?>
<script>

function runClient(func, port, device, username){
  //var message = "message=";
	//var portnum = "&port=";
	var message = "message=";
	var portnum = "&port=";
	var user = "&user=";
	//document.getElementById("test").innerHTML = message.concat(func, portnum, port, user, username);
	var xmlhttp = new XMLHttpRequest();
	var output = 0;
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			output = JSON.parse(xmlhttp.responseText);
			//document.getElementById("test2").innerHTML = device.concat("_message");
			//document.getElementById("test2").innerHTML = output;
			if(output.length > 0){
        
        var line = '';
        var i;
        for (i = 0; i < output.length; i++) {
          line += output[i] + " ";
        } 
				document.getElementById(device.concat("_message")).innerHTML = line;
				
			}
			else{
				alert("Server Timed Out. Please refresh page.");
			}
		}
	}
	
	xmlhttp.open("POST", "runClient.php", true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send(message.concat(func, portnum, port, user, username));
	//document.getElementById("test2").innerHTML = "YAY";
	
};
</script>

<link rel="stylesheet" href="homepage_stylesheet.css">

<style>
  div.black {border-style: solid; border-color: black; border-width: 5px;}
	div.red {border-style: solid; border-color: #990000; border-width: 10px;}
	div.blue {border-style: groove; border-color: blue; border-width: 5px;}
	div.indent {text-indent: 50px;}
	ol.a {list-style-type: circle;}
	ol.b {list-style-type: square;}
</style>
<body>
	<br>
	<div class = "black" id = add_device_box">
	<h4><b>Add a Device to Your SmartHome System:</b></h4>
	<form name="device_add" action="<?php print($_SERVER['SCRIPT_NAME'])?>" method="POST">
        Device Name: <input type="text" name="devicename"><br>
        Port Number: <input type="text" name="portnum"><br>
        <input type="submit" value="Add Device"><br><br>
        <input type="hidden" name="add" value="true">
	</form>
	</div>
	<br>

	<div class = "black">
	<h4><b>Your SmartHome Devices:</b></h4>
	<?php
	#echo "query:";
	$sql = "SELECT device, port FROM devices WHERE username='" . $_SESSION['username'] ."'" ;
  $result = $conn->query($sql);
  #echo $sql;
  
  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) 
    {
      print '<div class="red" id = "' . $row["device"] . '"">';
      print $row["device"];
      echo "<br>";
      print "<div id='" . $row["device"] . "_message'></div>";
      $sql2 = "SELECT func_name from functions WHERE username='" . $_SESSION['username'] ."' AND device='" . $row["device"] . "'";
      $result2 = $conn->query($sql2);
      if ($result2->num_rows > 0) {
        echo '<ol class = "a" id = "' . $row["device"] . '_functions">';
        while($funcs = $result2->fetch_assoc()) 
        {
          print "<li><button type=\"button\" onclick=\"runClient('" . $funcs["func_name"] . "','" . $row["port"] . "','" . $row["device"] . "','" . $_SESSION["username"] . "')\">" . $funcs["func_name"] . "</button></li>";
        }
        echo '</ol>';
      }
      print '</div>';
    } 
  }
	?>
	</div>
	<div id="test"></div>
	<div id="test2"></div>
	<div id="test3"></div>
	<br>
	<div class="black" id = add_device_box">
	<h4><b>Remove a Device from Your SmartHome System:</b></h4>
	<form name="device_remove" action="<?php print($_SERVER['SCRIPT_NAME'])?>" method="POST">
        Delete Device Name: <input type="text" name="devicename"><br>
        <input type="submit" value="Remove Device"><br><br>
        <input type="hidden" name="del" value="true">
	</form>
	</div>
	
	<br>
	<form name="logout_form" action="<?php print(dirname($_SERVER['SCRIPT_NAME']) . "/login.php")?>" method="POST">
    		<input type="submit" value="Logout">
    		<input type="hidden" name="logout" value="true">  
  
</form>
</body>
</html>
