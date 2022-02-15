
<?php

use GameZone\Game;

?>
<table>
    <thead>
    </thead>
    <tbody>
        <?php foreach(Game::getAll() as $game):?>
            <tr>
                <th>
                    <?php print($game->getDescription()) ?>
                </th>
            </tr>
        <?php endforeach; ?>
        <?php foreach(Game::getAll() as $gameName):?>
            <tr>
                <th>
                    <?php print($gameName->getDescription()) ?>
                </th>
            </tr>
        <?php endforeach; ?>
        <?php foreach(Game::getAll() as $images):?>
            <tr>
                <th>
                    <?php print( $images->getDescription()) ?>
                </th>
            </tr>
        <?php endforeach; ?>
        <?php foreach(Game::getAll() as $description):?>
            <tr>
                <th>
                    <?php print($description->getDescription()) ?>
                </th>
            </tr>
        <?php endforeach; ?>
        <?php foreach(Game::getAll() as $categories):?>
            <tr>
                <th>
                    <?php print($categories->getDescription()) ?>
                </th>
            </tr>
        <?php endforeach; ?>
        <?php foreach(Game::getAll() as $$releaseDate):?>
            <tr>
                <th>
                    <?php print($releaseDate->getDescription()) ?>
                </th>
            </tr>
        <?php endforeach; ?>
        <?php foreach(Game::getAll() as $price):?>
            <tr>
                <th>
                    <?php print($price->getDescription()) ?>
                </th>
            </tr>
        <?php endforeach; ?>
        <?php foreach(Game::getAll() as $review):?>
            <tr>
                <th>
                    <?php print($review->getDescription()) ?>
                </th>
            </tr>
        <?php endforeach; ?>
        <?php foreach(Game::getAll() as $wishlisted):?>
            <tr>
                <th>
                    <?php print($wishlisted->getDescription()) ?>
                </th>
            </tr>
        <?php endforeach; ?>
        <?php foreach(Game::getAll() as $favored):?>
            <tr>
                <th>
                    <?php print($favored->getDescription()) ?>
                </th>
            </tr>
        <?php endforeach; ?>
        <?php foreach(Game::getAll() as $purchaseDate):?>
            <tr>
                <th>
                    <?php print($purchaseDate->getDescription()) ?>
                </th>
            </tr>
        <?php endforeach; ?>
        <?php foreach(Game::getAll() as $deleted):?>
            <tr>
                <th>
                    <?php print($deleted->getDescription()) ?>
                </th>
            </tr>
        <?php endforeach; ?>


        <?php
        if(isset($_GET['$categories'] )&& isset($_GET['$gameName'] )&& isset($_GET['$favored']) &&isset($_GET['$review']))
        {
        }
        ?>
    </tbody>
</table>