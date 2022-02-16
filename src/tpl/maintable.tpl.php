
<?php

use GameZone\Game;

?>
<table class="dataTable">
    <thead>
        <th>Name</th>
        <th>Bescription</th>
        <th>Images</th>
        <th>Categorie</th>
        <th>Review</th>
        <th>Price</th>
        <th>Wishlisted</th>
    </thead>
    <tbody>
        <?php foreach(Game::getAll() as $game):?>
            <tr>
                <th><?= $game->getGameName()?></th>
                <th><?= $game->getDescription() ?></th>
                <th><?= $game->getImages()?></th>
                <th><?= $game->getCategories()?></th>
                <th><?= $game->getReleaseDate()?></th>
                <th><?= $game->getPrice()?></th>
                <th><?= $game->getReview()?></th>
                <?php if($game->getReview()) :?>
                    <th>
                    <i class="fa-solid fa-star-sharp"></i>
                    </th>
                <?php endif; ?>
                <?php if($game->isWishlisted()) :?>
                        <th>
                        <i class="fa-solid fa-circle-heart"></i>
                        </th>
                    <?php else: ?>
                        <th>
                        <i class="fa-solid fa-xmark"></i>
                        </th>
                    <?php endif; ?>
                <th><?= $game->getPurchaseDate()?></th>
            </tr>
        <?php endforeach; ?>
        
       
    </tbody>
</table>