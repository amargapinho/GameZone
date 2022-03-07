<?php

use GameZone\Category;

(new Category())->populate($_POST)->save();