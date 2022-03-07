<?php

namespace GameZone;

class Config{

	const CSV_PATH = __DIR__ . '/../csv/';

    const TWITCH_CLIENT_ID = '';
    const TWITCH_TOKEN = '';

    const CURL_HEADER = [
        'Authorization: Bearer ' . Config::TWITCH_TOKEN,
        'Client-Id: ' . CONFIG::TWITCH_CLIENT_ID
    ];

	const CURL_OPTIONS = [
		CURLOPT_HTTPHEADER => Config::CURL_HEADER,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_CUSTOMREQUEST => 'GET',
		CURLOPT_SSL_VERIFYHOST => false,
		CURLOPT_SSL_VERIFYPEER => false
	];

}