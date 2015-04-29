<?php
	//used to grab output of "TCPServer.py" and return to "homepage.php"
	exec('python TCPClient.py ' . $_POST['port'] . ' ' . $_POST['user'] . ' ' . $_POST['message'] , $output);
	//$output = 'python TCPClient.py ' . $_POST['port'] . ' ' . $_POST['user'] . ' ' . $_POST['message'];
	print(json_encode($output));
  //print($_POST['port'] . " " . $_POST['message']);
?>
