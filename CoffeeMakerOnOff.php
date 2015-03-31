<?php
	exec('python CoffeeMakerClient.py ON/OFF', $output);
	print(json_encode($output));
?>
