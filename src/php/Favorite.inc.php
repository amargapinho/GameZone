<?php

use GameZone\Game;

if (isset($_POST['id'])) {
    $game = Game::getGame($_POST['id']);
    $game->setFavorite(!$game->isFavorite())->save();
}