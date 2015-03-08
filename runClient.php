<?php
	//used to grab output of "TCPServer.py" and return to "homepage.php"
	exec('python TCPClient.py', $output);
	print(json_encode($output));
?>
