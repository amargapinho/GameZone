<?php

use GameZone\Category;

$category = Category::getCategory($_POST['categoryID']);
$category->delete();