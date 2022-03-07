<?php
use GameZone\DatabaseObject;
use GameZone\Game;
use GameZone\Image;
?>

<div>
	<h1>
		<?= $game->getGameName() ?>
	</h1>
</div>
<hr>

<div>
	<h4>Bewertung: <?= $game->getReview() ?> Sterne</h4>
	<h4>Kategorien:</h4>
	<div>
		<?php foreach ($game->getCategories() as $category): ?>
			<span>
				<?= $category->getCategoryName() ?>
			</span><br/>
		<?php endforeach; ?>
	</div>
	<h4>Erscheinungsdatum: <?= DatabaseObject::formatTime($game->getReleaseDate()) ?></h4>
	<h4>Preis: <?= $game->getPriceFormatted() ?>€</h4>
	<h4>Beschreibung:</h4>
	<h5><?= nl2br($game->getDescription()) ?></h5>
</div>

<table>
	<tr>
		<th></th>
		<th align="center">
			<img
				src="<?= Image::WEB_PATH ?><?= $game->getImages()[0]->getImageName() ?>"
				height="400">
		</th>
		<th></th>
	</tr>
</table>