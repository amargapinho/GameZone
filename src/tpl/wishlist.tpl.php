<?php
use GameZone\DatabaseObject;
use GameZone\Game;
use GameZone\Image;
include TPL.'gameModal.tpl.php';

$games=Game::getWishlist();
?>
<script src="/src/js/mainTable.js"></script>
<script>
	$(document).ready(function () {
		getImages([
			<?php foreach ($games as $game):?>
			<?php if(empty($game->getImages())):?>
			<?=$game->getGameID()?>,
			<?php endif;?>
			<?php endforeach;?>
		]);
	});
	
	function CardFilter() {
		var input, filter, cards, cardContainer, h5, title, i;
		input = document.getElementById("Filter");
		filter = input.value.toUpperCase();
		cardContainer = document.getElementById("CardItems");
		cards = cardContainer.getElementsByClassName("card");
		for (i = 0; i < cards.length; i++) {
			title = cards[i].querySelector(".card-body h5.card-title");
			if (title.innerText.toUpperCase().indexOf(filter) > -1) {
				cards[i].style.display = "inline-block";
			} else {
				cards[i].style.display = "none";
			}
		}
	}
</script>

<div class="container py-5" style="margin-top: 20px">

	<div class="d-flex justify-content-between">
		<div style="margin: auto">
			<input
				type="text"
				id="Filter"
				class="form-control"
				onkeyup="CardFilter()"
				placeholder="Spiel filtern">
		</div>
	</div>
	
	<div id="CardItems" style="text-align: center;">
		<?php foreach ($games as $game): ?>
			<div class="card" style="width: 350px; margin: 5px; display:inline-block; vertical-align: top;">
			
			
				<?php if (empty($game->getImages())): ?>
					<span class="text-center" id="image<?= $game->getGameID() ?>" data-name="<?= $game->getGameName() ?>">
						<i class="fas fa-spinner fa-spin"></i>
					</span>
				<?php else: ?>
					<span class="text-center">
						<img src="<?= Image::WEB_PATH ?><?= $game->getImages()[0]->getImageName() ?>" alt="<?= $game->getGameName() ?>" height="200px" class="w-auto">
					</span>
				<?php endif; ?>
			
				
				<div class="card-body" style="text-align: left;">
					<h5 class="card-title">
						<?= $game->getGameName() ?>
						<div style="float: right;">
							<button
								class="btn btn-primary"
								type="button"
								onclick="window.location.href='/print.php?id=<?= $game->getGameID() ?>'"
								data-toggle="tooltip"
								title="Drucken">
								<i class="fa-solid fa-print"></i>
							</button>
							<button
								type="button"
								class="btn btn-primary"
								data-toggle="modal"
								data-target="#gameModal"
								onclick="getGame(<?= $game->getGameID() ?>)"
								data-toggle="tooltip"
								title="Bearbeiten">
								<i class="fa-solid fa-pen-to-square"></i>
							</button>
							<button
								type="button"
								class="btn btn-danger"
								id="deleteButton<?= $game->getGameID() ?>"
								onclick="deleteGame(<?= $game->getGameID() ?>)"
								data-toggle="tooltip"
								title="Löschen">
								<i class="fa-regular fa-trash-can"></i>
							</button>
						</div>
					</h5>
					
					<p class="card-text">
						<b>Bewertung</b>:<br/>
						<div style="margin: 0 0 0 10px; padding: 0">
							<button
								type="button"
								class="btn btn-outline-warning"
								disabled>
								<?php for ($i=0; $i<$game->getReview(); $i++): ?>
									<i class="fa-solid fa-star"></i>
								<?php endfor; ?>
							</button>
						</div>
						
						<b>Wunschliste</b>:<br/>
						<div style="margin: 0 0 0 10px; padding: 0">
							<button type="button" class="btn btn-outline-danger" id="favorButton<?= $game->getGameID() ?>" onclick="switchFavorite(<?= $game->getGameID() ?>)">
								<?php if ($game->isWishlisted()): ?>
									<span hidden>Yes</span><i class="fa-solid fa-heart"></i>
								<?php else: ?>
									<span hidden>No</span><i class="fa-regular fa-heart"></i>
								<?php endif; ?>
							</button>
						</div>
						
						<b>Kategorien</b>:<br/>
						<div style="margin: 0 0 0 10px; padding: 0">
							<?php foreach ($game->getCategories() as $category): ?>
								<span
									class="badge badge-primary"
									onclick="search('<?= addslashes($category->getCategoryName()) ?>')">
									<?= $category->getCategoryName() ?>
								</span>
							<?php endforeach; ?>
						</div>
						
						<b>Erscheinungsdatum</b>: <?= DatabaseObject::formatTime($game->getReleaseDate()) ?><br/>
						
						<b>Preis</b>: <?= $game->getPriceFormatted() ?>€<br/>
						
						<b>Beschreibung</b>:
						<div style="height:200px; overflow-y: scroll;">
							<?= nl2br($game->getDescription()) ?>
						</div><br/>
					</p>
				</div>
				
			</div>
		<?php endforeach; ?>
	</div>
</div>