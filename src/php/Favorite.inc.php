<?php
use GameZone\Game;

if (isset($_POST['favorite'])) {
    switch ($_POST['favorite']) {
        case 'Favorite':
            favorite();
            break;
        case 'Unfavorite':
            unfavorite();
            break;
    }
}
?>

if(isset($_GET['action']) && $_GET['action'] === 'importCSV')

<!-- $item_type = $_POST['item_type'];
$item_id = $_POST['item_id'];

if(make_favorite($item_type, $item_id)){
  $response = array('ok' => true, 'message' => 'Huzza!');
}
else {
  $response = array('ok' => false, 'message' => mysql_error());
} -->