<?php

namespace GameZone;

use TCPDF;

class PDF extends TCPDF {

	const INLINE='I';

	const DOWNLOAD='D';

	const FILE='F';

	const STRING='S';

	public function __construct() {
		parent::__construct();
		$this->setFont('helvetica');
	}

	/**
	 * @param array $vars
	 * @param string $path
	 */
	public function writeTemplate(string $path, array $vars=[]) {
		ob_start();
		extract($vars);
		include $path;
		$this->writeHTML(ob_get_clean());
	}
}
?>