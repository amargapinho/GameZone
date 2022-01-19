<?php

namespace GameZone;

use Mpdf\Mpdf;
use Mpdf\MpdfException;

class PDF extends Mpdf{

	/**
	 * @var string $path
	 * @throws MpdfException
	 */
	public function writeTemplate(string $path){
		ob_start();
		include $path;
		$this->WriteHTML(ob_get_clean());
	}


}