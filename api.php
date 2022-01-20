<?php

require_once __DIR__ . '/vendor/autoload.php';

use GameZone\Category;
use GameZone\Game;
use GameZone\Json;

if(isset($_GET['action'])){

	switch ($_GET['action']){

		case 'getGame':
			Json::send(Game::getGame($_GET['id'])->loadCategories());
			break;

		case 'getCategory':
			Json::send(Category::getCategory($_GET['id']));
			break;


	}

}