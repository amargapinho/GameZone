<?php

use GameZone\CSV;

(new CSV($_FILES['GameFile']['tmp_name']))->read();