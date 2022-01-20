<?php

if(isset($_POST['action'])){
	switch ($_POST['action']){

		case 'importCSV':
			include PHP . 'csvImport.inc.php';
			break;

		case 'saveCategory':
			include PHP . 'saveCategory.inc.php';
			break;

	}
}