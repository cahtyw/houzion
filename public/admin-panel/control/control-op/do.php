<?php
    header('content-type: text/plain');
	$dev = $_POST['dev'];
	if($dev !== null)
	{
		fwrite(fopen('./output.fifo', 'w'), '>'.$dev.':'.$_POST['value'].';');
		$i = fopen('./input.fifo', 'r+'); // "r+" é usado para que não haja erros de sincronização.
		while(($line = fgets($i)) !== "=====\n")
		{
			echo $line;
		}
	}
?>

