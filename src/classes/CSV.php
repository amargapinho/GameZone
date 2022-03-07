<?php

namespace GameZone;

class CSV {

	/**
	 * @var string
	 */
	private $path;

	/**
	 * @var Game[]
	 */
	private $games;

	private $file;

	/**
	 * @return string
	 */
	public function getPath():string {
		return $this->path;
	}

	/**
	 * @param string $path
	 * @return CSV
	 */
	public function setPath(string $path):CSV {
		$this->path=$path;

		return $this;
	}

	/**
	 * @return Game[]
	 */
	public function getGames():array {
		return $this->games;
	}

	/**
	 * @param Game[] $games
	 * @return CSV
	 */
	public function setGames(array $games):CSV {
		$this->games=$games;

		return $this;
	}

	public function __construct(string $path) {
		$this->setPath($path);
	}

	public function write() {
		$this->file=fopen($this->getPath(), 'w');

		foreach ($this->getGames() as $game) {
			$game->exportCSV($this->file);
		}

		fclose($this->file);
	}

	public function read() {
		$this->file=fopen($this->getPath(), 'r');

		while (!feof($this->file)) {
			$csvArray=fgetcsv($this->file, 0, ';');
			if (is_array($csvArray)) {
				Game::importCSV($csvArray);
			}
		}

		fclose($this->file);
	}

	public function send() {
		$filename=$this->getFilename();
		header('Content-type: application/csv');
		header("Content-Disposition: inline; filename=$filename");
		readfile($this->getPath());
		die();
	}

	/**
	 * @return string
	 */
	private function getFilename():string {
		return substr($this->getPath(), strrpos($this->getPath(), DIRECTORY_SEPARATOR)+1);
	}

}