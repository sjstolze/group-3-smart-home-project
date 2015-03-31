<?php
	exec('python CoffeeMakerClient.py brew', $output);
	print(json_encode($output));
?>
