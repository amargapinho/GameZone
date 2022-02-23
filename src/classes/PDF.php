<?php

namespace GameZone;

use Mpdf\Mpdf;
use Mpdf\MpdfException;

class PDF extends Mpdf{

    /**
     * @param array $vars
     * @param string $path
     * @throws MpdfException
     */
	public function writeTemplate(string $path, array $vars){
		ob_start();
        extract($vars);
		include $path;
		$this->WriteHTML(ob_get_clean());
	}


}