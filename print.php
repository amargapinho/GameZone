<?php

use GameZone\Game;
use GameZone\PDF;

require_once __DIR__ . '/vendor/autoload.php';

$pdf = new PDF();

$games = isset($_GET['id']) ? [Game::getGame($_GET['id'])] : Game::getWishlist();

foreach ($games as $game){
	$pdf->AddPage();
	$pdf->writeTemplate(__DIR__ . '/src/tpl/print.tpl.php', ['game' => $game]);
}

$pdf->Output('wishlist.pdf', PDF::INLINE);