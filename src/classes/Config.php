<?php

namespace GameZone;

class Config{

    const TWITCH_CLIENT_ID = '';
    const TWITCH_TOKEN = '';

    const CURL_HEADER = [
        'Authorization: Bearer ' . Config::TWITCH_TOKEN,
        'Client-Id: ' . CONFIG::TWITCH_CLIENT_ID
    ];

}