<?php

use GameZone\CSV;
use GameZone\Game;

require_once __DIR__ . '/vendor/autoload.php';

$csv = new CSV(__DIR__ . '/export.csv');
$csv->setGames(Game::getAll());
$csv->write();
$csv->send();