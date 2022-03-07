<?php
if (isset($_POST['action'])) {
	switch ($_POST['action']) {

		case 'importCSV':
			include PHP.'csvImport.inc.php';
		break;

		case 'saveCategory':
			include PHP.'saveCategory.inc.php';
		break;

		case 'deleteCategory':
			include PHP.'deleteCategory.inc.php';
		break;

		case 'updateGame':
			include PHP.'updateGame.inc.php';
		break;
	}
}

if (isset($_GET['action'])) {

	switch ($_GET['action']) {
		case 'game':
			include TPL.'game.tpl.php';
		break;

		case 'categories':
			include TPL.'categories.tpl.php';
		break;

		case 'wishlist':
			include TPL.'wishlist.tpl.php';
		break;

		case 'csv':
			include TPL.'csv.tpl.php';
		break;

		case 'recover':
			include TPL.'recover.tpl.php';
		break;
	}
}

else {
	include TPL.'maintable.tpl.php';
}
?>