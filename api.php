<?php

require_once __DIR__ . '/vendor/autoload.php';

use GameZone\Category;
use GameZone\Game;
use GameZone\Json;

if(isset($_POST['action'])){

	switch ($_POST['action']){

		case 'getGame':
			Json::send(Game::getGame($_POST['id']));
			break;

		case 'getCategory':
			Json::send(Category::getCategory($_POST['id']));
			break;


	}

}