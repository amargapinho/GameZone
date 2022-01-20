<?php

use GameZone\Category;

$category = isset($_POST['categoryID']) && !empty($_POST['categoryID']) ? Category::getCategory($_POST['categoryID']) : new Category();
$category->setCategoryName($_POST['categoryName'])->save();