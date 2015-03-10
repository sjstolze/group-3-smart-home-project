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
	echo "<br>";
?>
<script>
function runClient(){
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
	<div class="red">
		DEVICE MANAGER
		<div class = "blue">
		Devices
			<ol class = "a">
				<li>Device 1</li>
					<ol class = "b">
						<li>Function 1</li>
						<li>Function 2</li>
						<li>Function 3</li>
					</ol>
				<li>Device 2</li>
				<li>Device 3</li>
			</ol>
		<button onclick = "runClient();">Find new devices...</button>
		<div id = "foo"><div>
		</div>
	</div>
	
	<form name="newaccount" action="<?php print(dirname($_SERVER['SCRIPT_NAME']) . "/login.php")?>" method="POST">
    <input type="submit" value="logout">
    <input type="hidden" name="logout" value="true">  
  
</form>
</body>
</html>
