<?php

require_once(__ROOT__.'/vendor/twitteroauth/twitteroauth.php'); 

class Twitter {

	public static function getLatestTweet(){
		$tweets = self::get();
		if (isset($tweets)) {
			return json_encode($tweets[0]);
		}
		return ErrorHandler::message('T1', 'Unable to get Tweets.');
	}

	public static function getTweets($count) {
		if ($count > TWITTER_LIMIT)
			return ErrorHandler::message('T2', 'Tweet count ('.$count.') is more than API Tweet Limit');

		$tweets = self::get();
		if (isset($tweets)) {
			return json_encode(array_slice($tweets, 0, $count));
		}
		return ErrorHandler::message('T1', 'Unable to get Tweets.');
	}

	public static function get(){
		/*$cachedData = phpFastCache::get("twitter-tweets");
		if ($cachedData != null)
			return json_decode($cachedData);*/

		try {
			# Create the connection
		    $twitter = new TwitterOAuth(TWITTER_CONSUMER_KEY, TWITTER_CONSUMER_SECRET, TWITTER_ACCESSTOKEN, TWITTER_ACCESSTOKEN_SECRET);

		    # Migrate over to SSL/TLS
		    $twitter->ssl_verifypeer = true;

		    # Load the Tweets
		    $tweets = $twitter->get('statuses/user_timeline', array('screen_name' => TWITTER_USERNAME, 'exclude_replies' => 'true', 'include_rts' => 'false', 'count' => TWITTER_LIMIT));

		    $tweet = array();
		    foreach ($tweets as $data) {
				$t = new Tweet();
				$t->id = $data->id_str;
				$t->text = self::linkify_twitter_status($data->text);
				$t->date_tweeted = $data->created_at;
				$t->retweet_count = $data->retweet_count;
				$t->favorite_count = $data->favorite_count;

				$tweet[] = $t;
			}
			// Set Cache
			phpFastCache::set("twitter-tweets", json_encode($tweet), CACHE_DURATION);
		   	return $tweet;
	 	} catch(Exception $e) {
	 		return ErrorHandler::message('T3', $e->getMessage());
		}

	}

	private static function linkify_twitter_status($status_text) {
	  // linkify URLs
	  $status_text = preg_replace(
	    '/(https?:\/\/\S+)/',
	    '<a href="\1">\1</a>',
	    $status_text
	  );

	  // linkify twitter users
	  $status_text = preg_replace(
	    '/(^|\s)@(\w+)/',
	    '\1@<a href="http://twitter.com/\2">\2</a>',
	    $status_text
	  );

	  // linkify tags
	  $status_text = preg_replace(
	    '/(^|\s)#(\w+)/',
	    '\1#<a href="https://twitter.com/search?q=%23\2">\2</a>',
	    $status_text
	  );

	  return $status_text;
	}

}

class Tweet {
	public $id = "";
	public $text = "";
	public $date_tweeted = "";
	public $retweet_count = "";
	public $favorite_count = "";
}

?>