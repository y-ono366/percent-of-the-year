<?php

namespace App\Services;
use Abraham\TwitterOAuth\TwitterOAuth;

class TwitterService {
    public $twitter;

    public function __construct() {
        $this->twitter = new TwitterOAuth(env('CONSUMER_KEY'),env('CONSUMER_SECRET'),env('ACCESS_TOKEN'),env('ACCESS_TOKEN_SECRET'));
    }
    public function post($message) {
        $this->twitter->post("statuses/update", ["status" => $message]);
    }
}
