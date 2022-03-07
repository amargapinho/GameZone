<?php

namespace GameZone;

class TwitchSearch {

	use Singleton;

	private $curl;

	private function __construct() {
		if ($this->isTwitchAvailable()) {
			$this->curl=curl_init();
            curl_setopt_array($this->curl, Config::CURL_OPTIONS);
		}
	}

	public function __destruct() {
		if ($this->isTwitchAvailable()) {
			curl_close($this->curl);
		}
	}

	/**
	 * @param string $query
	 * @return string
	 */
	public function search(string $query):string {
		if ($this->isTwitchAvailable()) {
			$query=$this->shrinkToMaxSize($query);
			$jsonResponse=$this->request($query);
			$response=$this->parseResponse($jsonResponse);

			return $this->getBestMatch($query, $response);
		}

		return '';
	}

	/**
	 * @param string $query
	 * @return string
	 */
	private function request(string $query):string {
		curl_setopt($this->curl, CURLOPT_URL, 'https://api.twitch.tv/helix/search/categories?'.http_build_query(['query'=>$query]));
		$response=curl_exec($this->curl);
		if (curl_errno($this->curl)) {
			echo curl_error($this->curl);
		}

		return $response;
	}

	/**
	 * @param string $query
	 * @param TwitchResponse $response
	 * @return string
	 */
	private function getBestMatch(string $query, $response):string {

		//Max possible distance is 255
		$smallestDistance=256;
		$image='';

		foreach ($response->data as $game) {
			$distance=levenshtein($query, $this->shrinkToMaxSize($game->name));
			if ($smallestDistance>$distance) {
				$smallestDistance=$distance;
				$image=$game->box_art_url;
			}
		}

		return str_replace('52x72', '520x720', $image);
	}

	/**
	 * @param string $jsonResponse
	 * @return TwitchResponse
	 */
	private function parseResponse(string $jsonResponse) {
		return json_decode($jsonResponse);
	}

	/**
	 * @param string $string
	 * @return string
	 */
	private function shrinkToMaxSize(string $string):string {
		return substr($string, 0, 255);
	}

	public function isTwitchAvailable():bool {
		return Config::TWITCH_CLIENT_ID!==''&&Config::TWITCH_TOKEN!=='';
	}

}