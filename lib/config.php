<?php

/*
	CACHING
	CACHE DURATION: 3500 sec = 1 hour
*/
defined('CACHE_DURATION') ? NULL : define('CACHE_DURATION', 3600);

/* 
	INSTAGRAM

	USER_ID: https://api.instagram.com/v1/users/search?q=[HANDLE_NAME]&access_token=[ACCESS_TOKEN]
	ACCESS_TOKEN: https://instagram.com/oauth/authorize/?client_id=[CLIENT_ID_HERE]&redirect_uri=http://localhost&response_type=token
*/

defined('INSTA_CLIENTID') ? NULL : define('INSTA_CLIENTID', '');
defined('INSTA_USERID') ? NULL : define('INSTA_USERID', '');
defined('INSTA_ACCESSTOKEN') ? NULL : define('INSTA_ACCESSTOKEN', '');
defined('INSTA_LIMIT') ? NULL : define('INSTA_LIMIT', 10);

/* 
	TWITTER
*/

defined('TWITTER_CONSUMER_KEY') ? NULL : define('TWITTER_CONSUMER_KEY', '');
defined('TWITTER_CONSUMER_SECRET') ? NULL : define('TWITTER_CONSUMER_SECRET', '');
defined('TWITTER_ACCESSTOKEN') ? NULL : define('TWITTER_ACCESSTOKEN', '');
defined('TWITTER_ACCESSTOKEN_SECRET') ? NULL : define('TWITTER_ACCESSTOKEN_SECRET', '');
defined('TWITTER_USERNAME') ? NULL : define('TWITTER_USERNAME', '');
defined('TWITTER_LIMIT') ? NULL : define('TWITTER_LIMIT', 10);

/*
	GOOGLE ANALYTICS
*/

defined('GA_CLIENTID') ? NULL : define('GA_CLIENTID', '');
defined('GA_SERVICE_ACCOUNTNAME') ? NULL : define('GA_SERVICE_ACCOUNTNAME', '');
defined('GA_KEY_FILE') ? NULL : define('GA_KEY_FILE', 'tocWidgetsKey.p12');
defined('GA_PROFILE_ID') ? NULL : define('GA_PROFILE_ID', '');
defined('GA_SORT_DEFAULT') ? NULL : define('GA_SORT_DEFAULT', '');

/*
	OPEN WEATHER MAP
	Website: http://openweathermap.org/
*/

defined('WEATHER_APPID') ? NULL : define('WEATHER_APPID', '');


/*
	YOUTUBE
*/
defined('YOUTUBE_FEATURED') ? NULL : define('YOUTUBE_FEATURED', '');
defined('YOUTUBE_BASE_URL') ? NULL : define('YOUTUBE_BASE_URL', 'https://www.youtube.com/watch?v=');

?>