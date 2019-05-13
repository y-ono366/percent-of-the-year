<?php

namespace App\Services;
use Abraham\TwitterOAuth\TwitterOAuth;

class TwitterService {
    public $twitter;

    public function __construct() {
        if(empty(env('CONSUMER_KEY') )| empty(env('CONSUMER_SECRET') )| empty(env('ACCESS_TOKEN') )| empty(env('ACCESS_TOKEN_SECRET') )){
            return false;
        }
        $this->twitter = new TwitterOAuth(env('CONSUMER_KEY'),env('CONSUMER_SECRET'),env('ACCESS_TOKEN'),env('ACCESS_TOKEN_SECRET'));
    }
    public function post($message) {
        $statues = $this->twitter->post("statuses/update", ["status" => $message]);
        return $statues;
    }
}
