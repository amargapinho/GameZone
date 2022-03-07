<?php
use GameZone\DatabaseObject;
use GameZone\Game;
use GameZone\Image;
include TPL.'gameModal.tpl.php';

$game=Game::getGame($_GET['id']??1);
$similarGames=$game->getSimilarGames();
?>
<script src="/src/js/mainTable.js"></script>

<div class="col-8 mx-auto py-5">

	<div class="d-flex justify-content-between">
		<div>
			<h1>
				<?= $game->getGameName() ?>
				<button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#gameModal" onclick="getGame(<?= $game->getGameID() ?>)">
					<i class="far fa-edit"></i>
				</button>
				<button class="btn btn-outline-info" type="button" onclick="window.location.href='/print.php?id=<?= $game->getGameID() ?>'">
					<i class="fa-solid fa-print"></i>
				</button>
				<button type="button" class="btn btn-outline-danger" id="favorButton<?= $game->getGameID() ?>" onclick="switchFavorite(<?= $game->getGameID() ?>)">
					<?php if ($game->isWishlisted()): ?>
						<i class="fa-solid fa-heart"></i>
					<?php else: ?>
						<i class="fa-regular fa-heart"></i>
					<?php endif; ?>
				</button>
			</h1>
		</div>
		<div>
			<?php for ($i=0; $i<$game->getReview(); $i++): ?>
				<i class="fa-solid fa-star" style="width: 2em;height: 2em"></i>
			<?php endfor; ?>
			<?php for (; $i<5; $i++): ?>
				<i class="fa-regular fa-star" style="width: 2em;height: 2em"></i>
			<?php endfor; ?>
		</div>
	</div>

	<hr>

	<div class="row">
		<div class="col-sm-12 col-xl-6 pb-sm-5">
			<h4 class="pt-2">Release Date: <?= DatabaseObject::formatTime($game->getReleaseDate()) ?></h4>
			<h4 class="py-2">Price: <?= $game->getPriceFormatted() ?> €</h4>
			<h4>Summary:</h4>
			<h6 class="py-2"><?= nl2br($game->getDescription()) ?></h6>
			<h4 class="py-2">Categories:</h4>
			<div class="pt-3">
				<?php foreach ($game->getCategories() as $category): ?>
					<span class="badge badge-pill badge-info m-1" onclick="window.location.href='?query=<?= $category->getCategoryName() ?>'">
					<h6 class="my-auto">
						<?= $category->getCategoryName() ?>
					</h6>
				</span>
				<?php endforeach; ?>
			</div>
		</div>
		<div class="col-sm-12 col-xl-6 col-6 h-50">
			<div id="carouselExampleControls" class="carousel slide py-5" data-ride="carousel">
				<ol class="carousel-indicators">
					<?php foreach ($game->getImages() as $key=>$image): ?>
						<li data-target="#carouselExampleIndicators" data-slide-to="<?= $key ?>"
							<?php if ($key===0): ?>
								class="active"
							<?php endif; ?>
						></li>
					<?php endforeach; ?>
				</ol>
				<div class="carousel-inner">
					<?php foreach ($game->getImages() as $key=>$image): ?>
						<div class="carousel-item text-center
					<?php if ($key===0): ?>
						active
					<?php endif; ?>
					">
							<img src="<?= Image::WEB_PATH ?><?= $image->getImageName() ?>" class="w-auto h-75">
						</div>
					<?php endforeach; ?>
				</div>
				<a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
					<span class="sr-only">Previous</span> </a>
				<a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
					<span class="sr-only">Next</span> </a>
			</div>
		</div>
	</div>

	<hr class="mt-5">

	<?php if (!empty($similarGames)): ?>

		<h1 class="py-5">Recommendations</h1>

		<div class="w-100 h-50">
			<div id="recommandations" class="carousel slide py-5" data-ride="carousel">
				<ol class="carousel-indicators">
					<?php foreach ($similarGames as $key=>$similarGame): ?>
						<li data-target="#carouselExampleIndicators" data-slide-to="<?= $key ?>"
							<?php if ($key===0): ?>
								class="active"
							<?php endif; ?>
						></li>
					<?php endforeach; ?>
				</ol>
				<div class="carousel-inner">
					<?php foreach ($similarGames as $key=>$similarGame): ?>
						<a href="?action=game&id=<?= $similarGame->getGameID() ?>" class="carousel-item text-center
						<?php if ($key===0): ?>
							active
						<?php endif; ?>
						">
							<img src="<?= Image::WEB_PATH ?><?= $similarGame->getImages()[0]->getImageName() ?>" class="w-auto h-75">
							<div class="carousel-caption d-none d-md-block">
								<h5><?= $similarGame->getGameName() ?></h5>
							</div>
						</a>
					<?php endforeach; ?>
				</div>
				<a class="carousel-control-prev" href="#recommandations" role="button" data-slide="prev">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
					<span class="sr-only">Previous</span> </a>
				<a class="carousel-control-next" href="#recommandations" role="button" data-slide="next">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
					<span class="sr-only">Next</span> </a>
			</div>
		</div>

	<?php endif; ?>

</div>