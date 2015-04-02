<?php
	//used to grab output of "TCPServer.py" and return to "homepage.php"
	exec('python TCPClient.py ' . $_POST['port'] . ' ' . $_POST['message'] , $output);
	print(json_encode($output));
  //print($_POST['port'] . " " . $_POST['message']);
?>
