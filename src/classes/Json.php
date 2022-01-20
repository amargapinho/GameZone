<?php

namespace GameZone;

class Json {

	/**
	 * @param mixed $data
	 * @param bool $prettyPrint
	 */
	public static function send($data, bool $prettyPrint = false){
		die(json_encode($data, $prettyPrint ? JSON_PRETTY_PRINT : 0));
	}

	/**
	 * @param string $json
	 * @return array
	 */
	public static function parse(string $json): array{
		return json_decode($json, true);
	}

}