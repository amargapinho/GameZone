<?php

use GameZone\Game;

if(isset($_GET['action']) && $_GET['action'] === 'importCSV'){

	$filePath = __DIR__ . '/../tmp/' .$_FILES['GameFile']['name'];
    	
    move_uploaded_file($_FILES['GameFile']['tmp_name'], $filePath);

	$file = fopen($filePath, 'r');

	while (!feof($file)){
		Game::importCSV(fgetcsv($file));
	}

	fclose($file);
	unlink($filePath);

}