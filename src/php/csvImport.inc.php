<?php

use GameZone\Game;

if(isset($_GET['action']) && $_GET['action'] === 'importCSV'){
    	
    move_uploaded_file($_FILES['GameFile']['tmp_name'], __DIR__ . '/../tmp/' .$_FILES['GameFile']['name']);
    
    $contents = file(__DIR__ . '/../tmp/' .$_FILES['GameFile']['name']);
    for($i=0;$i < count($contents); $i++){
        Game::importCSV($contents[$i]);
    }
}


?>