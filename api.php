<?php

require_once __DIR__ . '/vendor/autoload.php';

use GameZone\Category;
use GameZone\Game;
use GameZone\Json;

if(isset($_GET['action'], $_GET['value'])){

	switch ($_GET['action']){
		case 'getGame':
			Json::send(Game::getGame($_GET['value'])->loadCategories());
			break;

		case 'getCategory':
			Json::send(Category::getCategory($_GET['value']));
			break;

		case 'getImage':
            die(Game::getGameByName($_GET['value'])->getTwitchImage());

		case 'switchFavorite':
			$game = Game::getGame($_GET['value']);
			$game->setWishlisted(!$game->isWishlisted())->save();
			break;

		case 'deleteGame':
			Game::getGame($_GET['value'])->delete();
			break;

        case 'deleteCategory':
            Category::getCategory($_GET['value'])->delete();
            break;

		case 'recover':
			Game::getGame($_GET['value'])->recover();
			break;
	}

}