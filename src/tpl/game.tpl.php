<?php

use GameZone\Game;

$game = Game::getGame($_GET['id'] ?? 1);
?>
<div class="float-left p-1 sticky-top">
  <button type="button" class="btn btn-primary menu-button"><i class="fas fa-arrow-left w-100 h-auto"></i></button>
</div>
<div class="float-right p-1 sticky-top">
  <button type="button" class="btn btn-primary  menu-button"  data-toggle="modal" data-target="#gameModal"><i class="far fa-edit w-100 h-auto"></i></button>
</div>

<div class="container">

  <h1 class="text-center py-5"><?=$game->getGameName()?></h1>

  <div id="carouselExampleControls" class="carousel slide py-5" data-ride="carousel">
	  <ol class="carousel-indicators">
	  <?php foreach ($game->getImages() as $key => $image):?>
		  <li data-target="#carouselExampleIndicators" data-slide-to="<?=$key?>"
			  <?php if($key === 0):?>
				class="active"
			  <?php endif;?>
		  ></li>
	  <?php endforeach;?>
	  </ol>
    <div class="carousel-inner">
		<?php foreach ($game->getImages() as $key => $image):?>
			<div class="carousel-item text-center
				<?php if($key === 0):?>
					active
				<?php endif;?>
			">
				<img src="src/images/<?=$image->getImageName()?>" class="h-50 w-auto" alt="<?=$game->getGameName()?>">
			</div>
		<?php endforeach;?>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>

  <h4 class="text-center py-5">
    Preis (Amazon): <?=$game->getPrice()?>€<br><br>
    Bewertung <?=$game->getReview()?><i class="fas fa-star"></i>
  </h4>

  <span class="text-center py-5">
    Spiel Beschreibung:<br><br>
  	<?=$game->getDescription()?>
  </span>

</div>
