<?php

/**
 * @var Game $game
 */

use GameZone\Game;

?>
<div>
    <form method="post">
        <button type="button" class="btn btn-secondary" name="action" value="favorite"><i class="bi bi-heart"></i></button>
        <input name="id" value="<?=$game->getGameId()?>" hidden>
    </form>
</div>