<html>
<?php
	session_start();
?>
<?php
//This line prevents the user from just typing in /homepage.php in their browser, they must log in
if(!isset($_SESSION['username']) && !isset($_SESSION['email']))
  header("Location: " . dirname($_SERVER['SCRIPT_NAME']) . "/login.php");
	
	echo 'Username: ' . htmlspecialchars($_SESSION["username"]) . "<br>";
	echo 'Email: ' . htmlspecialchars($_SESSION["email"]);
	echo "<br>";
	print('<a href=' . dirname($_SERVER['SCRIPT_NAME']) . '/edit_profile.php>Edit Account</a>');
	echo "<br>";
?>
<script>
function runServer(){
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.open("POST", "runServer.php", true);
	xmlhttp.send();
}
runServer();
function runClient(){
	document.getElementById("temp").style.display = "block";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			var output = JSON.parse(xmlhttp.responseText);
			document.getElementById("foo").innerHTML = output;
		}
	}
	xmlhttp.open("POST", "runClient.php", true);
	xmlhttp.send();
};
</script>

<style>
	div.red {border-style: solid; border-color: red; border-width: 10px;}
	div.blue {border-style: groove; border-color: blue; border-width: 5px;}
	div.indent {text-indent: 50px;}
	ol.a {list-style-type: circle;}
	ol.b {list-style-type: square;}
</style>
<body>
	<button onclick = "runClient();">Find new devices...</button>
	<div id = "foo"></div>
	
	<div class="red" id = "temp" style = "display: none">
	GENERIC DEVICE MANAGER
		<div class = "blue">
		Devices Found...
			<ol class = "a">
				<li>Generic Device 1</li>
					<ol class = "b">
						<li>Generic Function 1</li>
						<li>Generic Function 2</li>
						<li>Generic Function 3</li>
					</ol>
				<li>Generic Device 2</li>
				<li>Generic Device 3</li>
			</ol>
		</div>
	</div>
	
	<form name="logout_form" action="<?php print(dirname($_SERVER['SCRIPT_NAME']) . "/login.php")?>" method="POST">
    		<input type="submit" value="Logout">
    		<input type="hidden" name="logout" value="true">  
  
</form>
</body>
</html>
